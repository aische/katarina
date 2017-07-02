module GenAlg where

import Types
import Gen
import StatementM
import Misc

import Control.Monad(forM_)

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
filterClassSpec :: [PropertySubset] -> ClassSpec -> ClassSpec
filterClassSpec csps (classname, ps) = (classname, filter f ps)
    where
        f (n, _, _) = inClassSubProperties csps classname n --(getClassName n)

inClassSubProperties :: [PropertySubset] -> ClassName -> Name -> Bool
inClassSubProperties csps cn n = maybe False (elem n) (lookup cn csps)


filterClassSpec2 :: [PropertySubset2] -> ClassSpec -> ClassSpec2
filterClassSpec2 fps (classname, ps) = (classname, ps >>= f)
    where
        f (n, t, _) = maybe [] (\x->[(n,t,x)]) $ inClassSubProperties2 fps classname n

inClassSubProperties2 :: [PropertySubset2] -> ClassName -> Name -> Maybe (Maybe KeyorderName)
inClassSubProperties2 csps cn n =
    case lookup cn csps of
        Nothing -> Nothing
        Just xs -> lookup n xs

classSpecToClassSpec2 :: ClassSpec -> ClassSpec2
classSpecToClassSpec2 (cn, ps) = (cn, fmap f ps)
    where
        f (n,t,d) = (n,t,Nothing)

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
functor_prefix :: String
functor_prefix = "F_"

makeFunctor :: FunctorName -> [ClassSpec2] -> ClassDef
makeFunctor (FunctorName functorname) cds =
    let classname = ClassName (functor_prefix ++ functorname)
    in ClassDef classname Nothing [] [] ([], [Assign (PROP (NAME "this") "keyorder") (ASSOC[])])
        (  fmap (mkFunctorFoldMethod classname) cds
        ++ fmap (mkFunctor2FoldMethod classname) cds
        )

mkFunctorFoldMethod :: ClassName -> ClassSpec2 -> Method
mkFunctorFoldMethod rname (classname, props) =
    let fname = "fold" ++ getClassName classname in
    let fname2 = "fmap" ++ getClassName classname in
    Method rname fname2 ["obj", "path"] [] $ getStatements $ do
        def "inj" (NAME "this")
        def "path2" $ PRIM "consarray" [NAME "obj", NAME "path"]
        mapM_ (\(n,t,ko) ->
            def n (mkFunctorFold_Property (PROP (NAME "obj") n) t ko)
            ) props
        assign (PROP (NAME "this") "path") (NAME "path")
        ret $ CALL (METHOD (NAME ("this")) fname) $ fmap (\(n,t,_)-> NAME n) props


mkFunctorFold_Property :: Expression -> PropertyType -> Maybe KeyorderName -> Expression
mkFunctorFold_Property e t ko =
    case (t, ko) of
        (IntType     , _) -> e
        (FloatType   , _) -> e
        (BoolType    , _) -> e
        (StringType  , _) -> e
        (ListType t' , Just (KeyorderList ko)) ->
            PRIM "map"
                [ LAMBDA ["obj"]
                    [Return (mkFunctorFold_Property (NAME "obj") t' (Just ko))]["inj", "path2"]
                , e
                ]
        (ListType t' , _) ->
            PRIM "map"
                [ LAMBDA ["obj"]
                    [Return (mkFunctorFold_Property (NAME "obj") t' Nothing)]["inj", "path2"]
                , e
                ]
        (ObjectType cs, _) ->
            CALL (METHOD e "fold") [NAME "inj", NAME "path2"]
        (MapType key cn, Just (KeyorderName kn)) ->
            IF (HASKEY kn (PROP (NAME "inj") "keyorder"))
                (CALL (FUNC "assoc_map_order")
                    [ LAMBDA ["obj"]
                        (getStatements $ ret $ CALL (METHOD (NAME "obj") "fold")[NAME "inj", NAME "path2"]) ["inj", "path2"]
                    , e
                    , KEY (PROP (NAME "inj") "keyorder") kn
                    ]
                )
                (CALL (FUNC "assoc_map_")
                    [ LAMBDA ["obj"]
                        (getStatements $ ret $ CALL (METHOD (NAME "obj") "fold")[NAME "inj", NAME "path2"]) ["inj", "path2"]
                    , e
                    ]
                )
        (MapType key cn, _) ->
            CALL (FUNC "assoc_map_")
                [ LAMBDA ["obj"]
                    (getStatements $ ret $ CALL (METHOD (NAME "obj") "fold")[NAME "inj", NAME "path2"]) ["inj", "path2"]
                , e
                ]
        (TupleType ts, Just (KeyorderTuple kos)) ->
            ARRAY $ fmap
                (\(i,(t,ko)) ->
                    mkFunctorFold_Property (AT e (I i)) t (Just ko)
                ) $ zip [0..] $ zip ts (kos ++ repeat KeyorderWildcard)
        (TupleType ts, _) ->
            ARRAY $ fmap
                (\(i,t) ->
                    mkFunctorFold_Property (AT e (I i)) t Nothing
                ) $ zip [0..] ts

mkFunctor2FoldMethod :: ClassName -> ClassSpec2 -> Method
mkFunctor2FoldMethod rname (classname, props) =
    let fname = "fold2" ++ getClassName classname in
    let fname2 = "fmap2" ++ getClassName classname in
    Method rname fname2 ["obj", "arg"] [] $ getStatements $ do
        def "inj" (NAME "this")
        mapM_ (\(n,t,_) -> mkFunctor2Fold_Property (PROP (NAME "obj") n) t) props
        expression $ CALL (METHOD (NAME ("this")) "fold2") [NAME "obj", NAME "arg"]
        ret NULL

mkFunctor2Fold_Property :: Expression -> PropertyType -> StatementM ()
mkFunctor2Fold_Property e t =
    case t of
        IntType        -> return ()
        FloatType      -> return ()
        BoolType       -> return ()
        StringType     -> return ()
        ListType t'    -> expression $ PRIM "map" [LAMBDA ["obj"] (getStatements (mkFunctor2Fold_Property (NAME "obj") t'))["inj", "arg"], e]
        ObjectType cs  -> expression $ CALL (METHOD e "fold2") [NAME "inj", NAME "arg"]
        MapType key cn -> expression $ CALL (FUNC "assoc_map_") [LAMBDA ["obj"]
                                    (getStatements $ expression $ CALL (METHOD (NAME "obj") "fold2")[NAME "inj", NAME "arg"]) ["inj", "arg"], e]
        TupleType ts   -> mapM_
                            (\(i,t) ->
                                mkFunctor2Fold_Property (AT e (I i)) t
                            ) $ zip [0..] ts
-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
makeAlgebra :: AlgebraName -> FunctorName -> [MethodInjection] -> ClassDef
makeAlgebra (AlgebraName algname) (FunctorName functorname) cds =
    let superclass = (ClassName (functor_prefix ++ functorname))
        classname = ClassName (functorname ++ "_" ++ algname)
    in ClassDef classname (Just superclass) [] [] ([], []) $ fmap (mkAlgebraFoldMethod classname) cds


mkAlgebraFoldMethod :: ClassName -> (ClassName, [Name], [Statement]) -> Method
mkAlgebraFoldMethod rname (classname, names, body) =
    Method rname ("fold" ++ getClassName classname) names [] body
-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
makeAlgebra2 :: AlgebraName -> FunctorName -> ClassDef
makeAlgebra2 (AlgebraName algname) (FunctorName functorname) =
    let superclass = (ClassName (functor_prefix ++ functorname))
        classname = ClassName (functorname ++ "_" ++ algname)
    in ClassDef classname (Just superclass) [] [] ([], []) [mkAlgebra2FoldMethod classname]


mkAlgebra2FoldMethod :: ClassName -> Method
mkAlgebra2FoldMethod rname =
    Method rname ("fold2") ["obj", "arg"] [] [Return NULL]

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
makeAlgebra_Tree :: Settings -> AlgebraName -> FunctorName -> [ClassSpec] -> ClassDef
makeAlgebra_Tree mp (AlgebraName algname) (FunctorName functorname) cds =
    let superclass = (ClassName (functor_prefix ++ functorname))
        classname = ClassName (functorname ++ "_" ++ algname)
    in ClassDef classname (Just superclass) [] [] ([], []) $
        fmap (mkAlgebra_TreeFoldMethod mp classname) cds


mkAlgebra_TreeFoldMethod :: Settings -> ClassName -> ClassSpec -> Method
mkAlgebra_TreeFoldMethod mp rname (classname, props) =
    Method rname ("fold" ++ getClassName classname) (fmap (\(n,_,_)-> n) props) [] $ getStatements $
        ret $ ASSOC
            ( (type_fieldname mp, S $ getClassName classname) : fmap (\(n,_,_) -> (n, NAME n)) props )

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
makeAlgebra_UL :: AlgebraName -> FunctorName -> [ClassSpec] -> ClassDef
makeAlgebra_UL (AlgebraName algname) (FunctorName functorname) cds =
    let superclass = (ClassName (functor_prefix ++ functorname))
        classname = ClassName (functorname ++ "_" ++ algname)
    in ClassDef classname (Just superclass) [] [] ([], []) $ fmap (mkAlgebra_ULMethod classname) cds

mkAlgebra_ULMethod :: ClassName -> ClassSpec -> Method
mkAlgebra_ULMethod rname (classname, props) =
    Method rname ("fold" ++ getClassName classname) (fmap (\(n,_,_)-> n) props) [] $ getStatements $
        ret $ PRIM "concat"
            (  [ S (getClassName classname ++ "<ul>")]
            ++ fmap (\(n,t,d) -> mkAlgebra_ULProperty n (NAME n) t) props
            ++ [ S "</ul>"]
            )

mkAlgebra_ULProperty :: String -> Expression -> PropertyType -> Expression
mkAlgebra_ULProperty name e t = loop name e t
    where
        loop name e t = case t of
            IntType        -> PRIM "concat" [ S ("<li>" ++ name ++ " :: INT    = "), e, S "</li>" ]
            FloatType      -> PRIM "concat" [ S ("<li>" ++ name ++ " :: FLOAT  = "), e, S "</li>" ]
            BoolType       -> PRIM "concat" [ S ("<li>" ++ name ++ " :: BOOL   = "), e, S "</li>" ]
            StringType     -> PRIM "concat" [ S ("<li>" ++ name ++ " :: STRING = "), e, S "</li>" ]
            ObjectType cs  -> let csstr = joinStrings " | " (fmap getClassName cs) in
                              PRIM "concat" [ S ("<li>" ++ name ++ " :: " ++ csstr ++ " = "), e, S "</li>" ]
            ListType t'    -> PRIM "concat"
                                [ S ("<li>" ++ name ++ " :: LIST = ")
                                , S "<ul>"
                                , PRIM "implode" [S "", PRIM "map" [LAMBDA ["obj"]
                                    [Return (loop "?" (NAME "obj") t')][], e]]
                                , S "</ul>"
                                , S "</li>"
                                ]
            MapType key cn -> PRIM "concat"
                                [ S ("<li>" ++ name ++ " :: MAP [" ++ key ++ " => " ++ getClassName cn ++ "] = ")
                                , S "<ul>"
                                , PRIM "implode" [S "", e]
                                , S "</ul>"
                                , S "</li>"
                                ]
            TupleType ts   -> PRIM "concat"
                                [ S ("<li>" ++ name ++ " :: TUPLE = ")
                                , S "<ul>"
                                , PRIM "implode" [S "", ARRAY $ fmap
                                    (\(i,t) ->
                                        loop ("[" ++ show i ++ "]") (AT e (I i)) t
                                    ) $ zip [0..] ts]
                                , S "</ul>"
                                , S "</li>"
                                ]

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
