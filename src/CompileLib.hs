module CompileLib where

import Types
import ToJS
import ToPHP
import Gen
import GenAlg
import TypesParser
import StatementM

import Control.Monad(forM_)
import System.Process
import System.Directory
import System.Random
import Data.Either
import Data.Map as Map

----------------------------------------------------------------------------------------
--
----------------------------------------------------------------------------------------
compileJS :: FilePath -> [ClassDef] -> IO ()
compileJS filename cds = writeFile (filename  ++ ".js") (unlines (cds >>= toJS))

compilePHP :: FilePath -> [ClassDef] -> IO ()
compilePHP filename cds = writeFile (filename  ++ ".php") ("<?php\n" ++ unlines (cds >>= toPHP))

----------------------------------------------------------------------------------------
--
----------------------------------------------------------------------------------------
readClassSpecs :: FilePath -> IO (ProjectName, [ClassSpec])
readClassSpecs filename = do
    s <- readFile filename
    case parse_specs s of
        Left s   -> error ("Parser Error: " ++ s)
        Right ps -> return ps

readFunctorSubset :: FilePath -> IO FunctorSubset2
readFunctorSubset filename = do
    s <- readFile filename
    case parse_functor s of
        Left s   -> error ("Parser Error: " ++ s)
        Right ps -> return ps

readClassInjection :: FilePath -> IO ClassInjection
readClassInjection filename = do
    s <- readFile filename
    case parse_injection s of
        Left s   -> error ("Parser Error: " ++ s)
        Right ps -> return ps


readFunctorDefs :: FilePath -> IO [FunctorDef]
readFunctorDefs filename = do
    s <- readFile filename
    case parse_functordefs s of
        Left s   -> error ("Parser Error: " ++ s)
        Right ps -> return ps
----------------------------------------------------------------------------------------
--
----------------------------------------------------------------------------------------
compADT :: Settings -> (ProjectName, [ClassSpec]) -> (FilePath, [ClassDef])
compADT mp (projectname, ps) =
    let cds   = fmap (makeClassDef mp) ps
        ofile = getProjectName projectname
    in (ofile, cds)

compFUN :: Settings -> (ProjectName, [ClassSpec]) -> (FilePath, [ClassDef])
compFUN mp (projectname, ps) =
    let ofile = getProjectName projectname ++ ".alg"
    in (ofile, [makeFunctor (FunctorName $ getProjectName projectname) $ fmap classSpecToClassSpec2 ps])

compFUN' :: Settings -> (ProjectName, [ClassSpec]) -> FunctorSubset2 -> (FilePath, [ClassDef])
compFUN' mp (projectname, ps) (functorname, tyname, csps) =
    let ps' = fmap (filterClassSpec2 csps) ps
        cds = [makeFunctor functorname ps']
        ofile = (functor_prefix ++ getFunctorName functorname)
    in (ofile, cds)

compALG :: Settings -> (ProjectName, [ClassSpec]) -> ClassInjection -> (FilePath, [ClassDef])
compALG mp (projectname, ps) (c1, functorname, bs) =
    let cds = [makeAlgebra c1 functorname bs]
        ofile = getFunctorName functorname ++ "_" ++ getAlgebraName c1
    in (ofile, cds)

compFA :: Settings -> (ProjectName, [ClassSpec]) -> FunctorDef -> (FilePath, [ClassDef])
compFA mp specs (Left alg)  = compFUN' mp specs alg
compFA mp specs (Right inj) = compALG mp specs inj

compALG_UL :: Settings -> String -> (ProjectName, [ClassSpec]) -> (FilePath, [ClassDef])
compALG_UL mp classname (projectname, ps) =
    let cds = [ makeAlgebra_UL (AlgebraName classname) (FunctorName $ getProjectName projectname) ps]
        ofile = getProjectName projectname ++ "_" ++ classname
    in (ofile, cds)

compALG_UL' :: Settings -> String -> (ProjectName, [ClassSpec]) -> FunctorSubset -> (FilePath, [ClassDef])
compALG_UL' mp classname (projectname, ps) (functorname, tyname, csps) =
    let ps' = fmap (filterClassSpec csps) ps
        cds = [ makeAlgebra_UL (AlgebraName classname) functorname ps']
        ofile = getFunctorName functorname ++ "_" ++ classname
    in (ofile, cds)

compALG_Tree :: Settings -> String -> (ProjectName, [ClassSpec]) -> (FilePath, [ClassDef])
compALG_Tree mp classname (projectname, ps) =
    let cds = [ makeAlgebra_Tree mp (AlgebraName classname) (FunctorName $ getProjectName projectname) ps]
        ofile = getProjectName projectname ++ "_" ++ classname
    in (ofile, cds)

compALG_Tree' :: Settings -> String -> (ProjectName, [ClassSpec]) -> FunctorSubset -> (FilePath, [ClassDef])
compALG_Tree' mp classname (projectname, ps) (functorname, tyname, csps) =
    let ps' = fmap (filterClassSpec csps) ps
        cds = [ makeAlgebra_Tree mp (AlgebraName classname) functorname ps']
        ofile = getFunctorName functorname ++ "_" ++ classname
    in (ofile, cds)


-- nooo what did i try here?
compALG2 :: Settings -> String -> (ProjectName, [ClassSpec]) -> (FilePath, [ClassDef])
compALG2 mp c1 (projectname, ps) =
    let cds = [makeAlgebra2 (AlgebraName c1) $ FunctorName $ getProjectName projectname]
        ofile = getProjectName projectname ++ "_" ++ c1
    in (ofile, cds)

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
