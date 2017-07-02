module Checker where

import Types
import Data.Map as Map
import Data.Monoid

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
type Project = (ProjectName, [ClassSpec], [FunctorSubset2], [ClassInjection])

data Check = Ok | CheckError String
    deriving Show

instance Monoid Check where
    mappend Ok a = a
    mappend e  _ = e
    mempty       = Ok

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
checkProject :: Project -> Check
checkProject (projectname, classspecs, functordefs, algebradefs) = c1 `mappend` c2 `mappend` c3
    where
        c1 = mconcat $ fmap (checkClass cm) classspecs
        cm = Map.fromList $ fmap (\d@(cn,_) -> (cn, d)) classspecs
        fm = Map.fromList $ fmap (\d@(fn,_,_) -> (fn, d)) (df : functordefs)
        c2 = mconcat $ fmap (checkFunctorSubset2 cm) functordefs
        c3 = mconcat $ fmap (checkClassInjection cm fm) algebradefs
        df = (FunctorName $ getProjectName projectname, projectname, fmap toPropertySubset classspecs)
        toPropertySubset (cn, props) = (cn, fmap f props)
        f (name, _, _) = (name, Nothing)

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
checkClass :: Map ClassName a -> (ClassName, [([Char], PropertyType, Maybe Expression)]) -> Check
checkClass cm (cn, ps) = mconcat $ fmap (checkProperty cm cn) ps

checkProperty :: Map ClassName a -> ClassName -> ([Char], PropertyType, Maybe Expression) -> Check
checkProperty cm cn (n, t, d) = checkType cm t `mappend` checkDefault cm cn n t d

checkType :: Map ClassName a -> PropertyType -> Check
checkType cm t = case t of
    ListType t'   -> checkType cm t'
    ObjectType cc -> mconcat $ fmap (checkClassName cm) cc
    TupleType ts  -> mconcat $ fmap (checkType cm) ts
    MapType k c   -> checkClassName cm c
    _             -> Ok

checkDefault :: Map ClassName a -> ClassName -> [Char] -> PropertyType -> Maybe Expression -> Check
checkDefault cm cn n t d = case (t,d) of
    (_             , Nothing   )      -> Ok
    (IntType       , Just (I _))      -> Ok
    (FloatType     , Just (F _))      -> Ok
    (BoolType      , Just (B _))      -> Ok
    (StringType    , Just (S _))      -> Ok
    (ListType t'   , Just (ARRAY [])) -> checkType cm t'
    (ObjectType cc , Just (d  ))      -> mconcat $ fmap (checkClassName cm) cc
    (TupleType ts  , Just (d  ))      -> mconcat $ fmap (checkType cm) ts
    (MapType k c   , Just (ARRAY [])) -> checkClassName cm c
    _                                 -> CheckError ("Error: Invalid default value for " ++ getClassName cn ++ "." ++ n)

checkClassName :: Map ClassName a -> ClassName -> Check
checkClassName cm cname = if Map.member cname cm then Ok else CheckError ("Error: Unknown Classname " ++ getClassName cname)

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
checkFunctorSubset :: Map ClassName (ClassName, [([Char], t1, t)]) -> (FunctorName, t2, [(ClassName, [[Char]])]) -> Check
checkFunctorSubset cm (fn, pn, ps) = mconcat $ fmap (checkPropertySubset cm fn) ps

checkPropertySubset :: Map ClassName (ClassName, [([Char], t1, t)]) -> FunctorName -> (ClassName, [[Char]]) -> Check
checkPropertySubset cm fn (cn, ns) =
    case Map.lookup cn cm of
        Nothing       -> CheckError ("Unknown Classname " ++ getClassName cn ++ " in Functor " ++ getFunctorName fn)
        Just (cn, ps) -> checkPropertyOrder (" in Functor " ++ getFunctorName fn) cn ns ps

checkPropertyOrder :: [Char] -> ClassName -> [[Char]] -> [([Char], t1, t)] -> Check
checkPropertyOrder wh cn ns ps = loop ns ps
    where
        loop []     _  = Ok
        loop ns     [] = CheckError ("Invalid Argument " ++ head ns ++ " for " ++ getClassName cn ++ wh)
        loop (n:ns) ((n', t, d):ps) | n == n'   = loop ns ps
                                    | otherwise = loop (n:ns) ps

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
checkFunctorSubset2 :: Map ClassName ClassSpec -> (FunctorName, t, [(ClassName, [(Name, Maybe KeyorderName)])]) -> Check
checkFunctorSubset2 cm (fn, pn, ps) = mconcat $ fmap (checkPropertySubset2 cm fn) ps

checkPropertySubset2 :: Map ClassName ClassSpec -> FunctorName -> (ClassName, [(Name, Maybe KeyorderName)]) -> Check
checkPropertySubset2 cm fn (cn, ns) =
    case Map.lookup cn cm of
        Nothing       -> CheckError ("Unknown Classname " ++ getClassName cn ++ " in Functor " ++ getFunctorName fn)
        Just (cn, ps) -> checkPropertyOrder2 (" in Functor " ++ getFunctorName fn) cn ns ps

checkPropertyOrder2 :: String -> ClassName -> [(Name, Maybe KeyorderName)] -> [(Name, PropertyType, Maybe Expression)] -> Check
checkPropertyOrder2 wh cn ns ps = loop ns ps
    where
        loop []     _  = Ok
        loop ns     [] = CheckError ("Invalid Argument " ++ fst (head ns) ++ " for " ++ getClassName cn ++ wh)
        loop ((n,k):ns) ((n', t, d):ps) | n == n'   = loop ns ps
                                        | otherwise = loop ((n,k):ns) ps

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
checkClassInjection :: Map ClassName ClassSpec -> Map FunctorName FunctorSubset2 -> ClassInjection -> Check
checkClassInjection cm fm (an, fn, ms) =
    case Map.lookup fn fm of
        Nothing          -> CheckError ""
        Just (fn, _, ps) -> let pm = Map.fromList ps in mconcat $ fmap (checkMethodInjection pm an fn) ms

checkMethodInjection :: Map ClassName [(Name, Maybe KeyorderName)] -> AlgebraName -> FunctorName -> MethodInjection -> Check
checkMethodInjection pm an fn (cn, ns, ss) =
    case Map.lookup cn pm of
        Nothing  -> CheckError ""
        Just ns' -> checkInjectionOrder (" in Algebra " ++ getAlgebraName an ++ " of Functor " ++ getFunctorName fn) cn (fmap fst ns') ns

checkInjectionOrder :: Eq a => [Char] -> ClassName -> [a] -> [a] -> Check
checkInjectionOrder wh cn ns ms = loop ns ms
    where
        loop []     []  = Ok
        loop (n:ns) (n':ps) | n == n'   = loop ns ps
                            | otherwise = CheckError ("Invalid Arguments for " ++ getClassName cn ++ wh)

        loop ns     ps = CheckError ("Invalid Arguments for " ++ getClassName cn ++ wh)

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------





