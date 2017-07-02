module Compile where

import Types
import ToJS
import ToPHP
import Gen
--import GenH
import GenAlg
import TypesParser
import StatementM
import Checker
import CompileLib
import Assets
import PHPStub
import Misc

import Control.Monad(forM_, when)
import System.Process
import System.Directory
import System.Random
import Data.Either
import Data.Map as Map


compile :: FilePath -> [FilePath] -> String -> String -> IO ()
compile ifile afiles opath additionalFilesPath = do
    -- read datatype definition
    specs@(projectname, classspecs) <- readClassSpecs ifile
    -- read functors and algebras
    defs <- mapM readFunctorDefs afiles >>= return . concat
    -- check validity (todo... tha language should be typed, but that is difficult)
    let pro = (projectname, classspecs, lefts defs, rights defs)
        a  = checkProject pro
    case a of
        CheckError s -> putStrLn s
        Ok -> do
            let mp = Settings "constr"
                appendDefs (filename, defs1) (_, defs2) = (filename, defs1 ++ defs2)
                ds = [ compADT mp specs `appendDefs` compFUN mp specs -- put datatype and functor in same file
                     , compALG_UL mp "UL" specs -- html list algebra
                     , compALG_Tree mp "TREE" specs -- array-tree algebra
                     -- , compALG2 mp "FFF" specs
                     ] ++ (fmap (compFA mp specs) defs) -- custom functors and algebras

            doesDirectoryExist opath >>= \b -> when b $ removeDirectoryRecursive opath
            createDirectory opath
            createDirectory (opath +/+ "js")
            createDirectory (opath +/+ "php")

            forM_ ds $ \(oname, cds) -> do
                let ofile = opath +/+ oname
                compileJS (opath +/+ "js" +/+ oname) cds
                compilePHP (opath +/+ "php" +/+ oname) cds

            writeFile (opath +/+ "test.php") $ mkPHPStub $ fmap fst ds
            writePreludePHP (opath +/+ "php/prelude.php")
            writePreludeJs (opath +/+ "js/prelude.js")
            if additionalFilesPath == "" then return () else do
                system ("cp -r " ++ (additionalFilesPath +/+ "/*") ++ " " ++ opath)
                return ()
            putStrLn "---compiled---"
            return ()

