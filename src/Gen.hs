module Gen where

import Types
import StatementM
import Control.Monad(forM_)

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
data Settings = Settings { type_fieldname :: String }
-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
makeClassDef :: Settings -> ClassSpec -> ClassDef
makeClassDef mp spec@(cname, props) =
    ClassDef cname Nothing props [] ([], [])
        [ mkFromArgs mp spec
        , mkToJSON mp spec
        , mkSafeFromJSON mp spec
        , mkUnsafeFromJSON mp spec
        , mkFromAssoc mp spec
       -- , mkFoldInstance mp spec
        , mkFoldGen mp spec
        , mkFold2Gen mp spec
        , mkUnfoldMethod mp spec
        ]

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
jsonErrorClass :: ClassName
jsonErrorClass = ClassName "JSONERROR"
-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
defaultFromPropertyType :: PropertyType -> Expression
defaultFromPropertyType t = case t of
    IntType        -> I 0
    FloatType      -> F 0
    BoolType       -> B False
    StringType     -> S ""
    ListType t'    -> ARRAY []
    ObjectType cs  -> NULL
    MapType key cn -> CALL (FUNC "pMap") [S key, LAMBDA["x"][Return $ NAME "x"][], ASSOC []]
    TupleType ts   -> NULL

isContainerProperty :: PropertyType -> Bool
isContainerProperty (ListType _)  = True
isContainerProperty (MapType _ _) = True
isContainerProperty _             = False

-------------------------------------------------------------------------------
-- SaveFromJSON
-------------------------------------------------------------------------------
mkSafeFromJSON :: Settings -> ClassSpec -> Method
mkSafeFromJSON mp (classname, props) =
    StaticMethod classname "fromJSON" ["json"] [] (getStatements $
        ifS (PRIM "and"
                [ ISASSOC (NAME "json")
                , HASKEY (type_fieldname mp) (NAME "json")
                , KEY (NAME "json") (type_fieldname mp) :== (S $ getClassName classname)]
        )
        (do def "obj" $ NEW classname []
            forM_ props $ \(n,t, defa) -> do
                ifS (HASKEY n (NAME "json"))
                    (do assign
                            (PROP (NAME "obj") n)
                            (CALL (mkSafeFromJSON_Property mp t)
                                [KEY (NAME "json") n])
                        ifS_
                            (CALL (FUNC "isJSONERROR")
                                [PROP (NAME "obj") n])
                            (ret $ NEW jsonErrorClass
                                    [ S (getClassName classname ++ "." ++ n)
                                    , (PROP (NAME "obj") n)])
                    )
                    (case defa of
                        Just v  -> assign (PROP (NAME "obj") n) v
                        Nothing -> ret $ NEW jsonErrorClass
                                    [S (getClassName classname ++ " fromJSON: missing key: " ++ n)]
                    )
            ret $ NAME "obj"
        )
        (ret $ NEW jsonErrorClass
            [S (getClassName classname ++ " ") :++ (KEY (NAME "json") (type_fieldname mp) )])
        )

mkSafeFromJSON_Property :: Settings  -> PropertyType -> Expression
mkSafeFromJSON_Property mp t =
    let oaux :: Expression -> [ClassName] -> Expression
        oaux e []       = NEW jsonErrorClass [S "Wrong Type: " :++ (KEY e (type_fieldname mp))]
        oaux e (cn:cs)  = IF (KEY e (type_fieldname mp) :== (S $ getClassName cn))
                             (CALL (STATIC cn "fromJSON") [e])
                             (oaux e cs)
    in case t of
        IntType      -> (FUNC "pInt")
        FloatType    -> (FUNC "pFloat")
        BoolType     -> (FUNC "pBool")
        StringType   -> (FUNC "pString")
        ListType t'  -> LAMBDA ["json"]
                        [Return (CALL (FUNC "pList") [mkSafeFromJSON_Property mp t', NAME "json" ])][]
        ObjectType cs  -> LAMBDA ["json"]
                            [Return $
                                IF  ( PRIM "and" [ISASSOC (NAME "json")
                                    , HASKEY (type_fieldname mp) (NAME "json")])
                                    (oaux (NAME "json") cs)
                                    (NEW jsonErrorClass [S "Wrong Object"])][]
        MapType key cn -> LAMBDA ["json"]
                            [Return
                                (CALL (FUNC "pMap")
                                    [ S key, (STATIC cn "fromJSON"), NAME "json"])] []
        TupleType ts ->
            LAMBDA ["json"]
                [Return
                    (CALL (FUNC "pTuple")
                        [ARRAY $
                            fmap (\t ->
                                LAMBDA ["json"]
                                    [Return (CALL (mkSafeFromJSON_Property mp t) [NAME "json"])][]
                            ) ts
                        , NAME "json"
                        ]
                    )
                ][]

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
mkUnsafeFromJSON :: Settings -> ClassSpec -> Method
mkUnsafeFromJSON mp (classname, props) =
    StaticMethod classname "unsafeFromJSON" ["json"] [] $ getStatements $ do
        def "obj" (NEW classname [])
        forM_ props $ \(n,t, defa) ->
            assign (PROP (NAME "obj") n) (CALL (mkUnsafeFromJSON_Property mp t) [KEY (NAME "json") n])
        ret $ NAME "obj"


mkUnsafeFromJSON_Property :: Settings  -> PropertyType -> Expression
mkUnsafeFromJSON_Property mp t =
    let
        oaux :: Expression -> [ClassName] -> Expression
        --oaux e []       = NEW jsonErrorClass [e `KEY` (type_fieldname mp)]
        oaux e [cn]     = (CALL (STATIC cn "unsafeFromJSON") [e])
        oaux e (cn:cs)  = IF (KEY e (type_fieldname mp) :== (S $ getClassName cn))
                            (CALL (STATIC cn "unsafeFromJSON") [e])
                            (oaux e cs)
    in case t of
        IntType      -> (FUNC "pUnsafe")
        FloatType    -> (FUNC "pUnsafe")
        BoolType     -> (FUNC "pUnsafe")
        StringType   -> (FUNC "pUnsafe")
        ListType t'  -> LAMBDA ["json"]
                        [Return (CALL (FUNC "pList") [mkUnsafeFromJSON_Property mp t', NAME "json" ])][]
        ObjectType cs  -> LAMBDA ["json"]
                            [Return $ oaux (NAME "json") cs][]
        MapType key cn -> LAMBDA ["json"]
                        [Return (CALL (FUNC "pMap") [ S key, (STATIC cn "unsafeFromJSON"), NAME "json"])][]
        TupleType ts ->
            LAMBDA ["json"]
                [Return
                    (CALL (FUNC "pTuple")
                        [ARRAY $
                            fmap (\t ->
                                LAMBDA ["json"]
                                    [Return (CALL (mkUnsafeFromJSON_Property mp t) [NAME "json"])][]

                            ) ts
                        , NAME "json"
                        ]
                    )
                ][]

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
mkToJSON :: Settings -> ClassSpec -> Method
mkToJSON mp (classname, props) =
    Method classname "toJSON" [] [] $ getStatements $ do
        def "json" (ASSOC [])
        assign (KEY (NAME "json") (type_fieldname mp)) (S $ getClassName classname)
        forM_ props $ \(n,t, defa) ->
            assign (KEY (NAME "json") n) (mkToJSON_Property mp (PROP (NAME "this") n) t)
        ret $ NAME "json"

mkToJSON_Property :: Settings -> Expression -> PropertyType -> Expression
mkToJSON_Property mp e t =
    case t of
        IntType        -> e
        FloatType      -> e
        BoolType       -> e
        StringType     -> e
        ListType t'    -> PRIM "map" [LAMBDA ["obj"] [Return (mkToJSON_Property mp (NAME "obj") t')][], e]
        ObjectType cs  -> CALL (METHOD e "toJSON") []
        MapType key cn -> CALL (FUNC "mapToJSON") [e]
        TupleType ts   -> (ARRAY $
                            fmap
                                (\(i,t) ->
                                    mkToJSON_Property mp (e `AT` (I i)) t
                                ) $ zip [0..] ts)
-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
{-
    Argumente sind alle properties außer List und Map-Types; diese werden durch leere Lists bzw Maps ersetzt

-}
mkFromArgs :: Settings -> ClassSpec -> Method
mkFromArgs mp (classname, props) =
    let container_props = filter (\(_,t,_)->isContainerProperty t) props
        argument_props  = filter (not.(\(_,t,_)->isContainerProperty t)) props
        args = fmap (\(n,t,d) -> n) argument_props

    in
    StaticMethod classname "fromArgs" args [] $ getStatements $ do
        def "obj" (NEW classname [])
        forM_ argument_props $ \(n,t, defa) ->
            case t of
                IntType    -> assign (PROP (NAME "obj") n) (PRIM "int" [NAME n])
                FloatType  -> assign (PROP (NAME "obj") n) (PRIM "float" [NAME n])
                BoolType   -> assign (PROP (NAME "obj") n) (PRIM "bool" [NAME n])
                StringType -> assign (PROP (NAME "obj") n) (PRIM "string" [NAME n])
                _          -> assign (PROP (NAME "obj") n) (NAME n)

        forM_ container_props $ \(n,t, defa) ->
            case t of
                ListType _    -> assign (PROP (NAME "obj") n) (ARRAY [])
                MapType key _ -> assign
                                    (PROP (NAME "obj") n)
                                    (CALL (FUNC "pMap")
                                        [S key, LAMBDA["x"][Return $ NAME "x"][], ARRAY []])
        ret $ NAME "obj"
-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------

mkFromAssoc :: Settings -> ClassSpec -> Method
mkFromAssoc mp (classname, props) =
    StaticMethod classname "fromAssoc" ["json"] [] (getStatements $
        ifS (ISASSOC (NAME "json"))
        (do def "obj" $ NEW classname []
            forM_ props $ \(n,t, defa) -> do
                ifS (HASKEY n (NAME "json"))
                    (do assign
                            (PROP (NAME "obj") n)
                            (case t of
                                IntType    -> (PRIM "int" [KEY (NAME "json") n])
                                FloatType  -> (PRIM "float" [KEY (NAME "json") n])
                                BoolType   -> (PRIM "bool" [KEY (NAME "json") n])
                                StringType -> (PRIM "string" [KEY (NAME "json") n])
                                _          -> (KEY (NAME "json") n)
                            )
                    )
                    (case defa of
                        Just v  -> assign (PROP (NAME "obj") n) v
                        Nothing -> assign (PROP (NAME "obj") n) (defaultFromPropertyType t)
                    )
            ret $ NAME "obj"
        )
        (ret NULL) )

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
{-
public function fold($inj){ return call_user_func(array($inj::$alg, 'foldProduct'), $inj, $this); }
-}

mkFoldGen :: Settings -> ClassSpec -> Method
mkFoldGen mp (classname, props) =
    let fname = "fmap" ++ getClassName classname in
    Method classname "fold" ["inj"] [("path", ARRAY [])] $ getStatements $ do
        ret $ CALL (METHOD (NAME "inj") fname) [NAME "this", NAME "path"]

mkMapGen :: Settings -> ClassSpec -> Method
mkMapGen mp (classname, props) =
    let fname = "map" ++ getClassName classname in
    Method classname "map" ["inj"] [] $ getStatements $
        ret $ CALL (METHOD (NAME "inj") fname) [NAME "this"]


mkFold2Gen :: Settings -> ClassSpec -> Method
mkFold2Gen mp (classname, props) =
    let fname = "fmap2" ++ getClassName classname in
    Method classname "fold2" ["inj", "arg"] [] $ getStatements $
        ret $ CALL (METHOD (NAME "inj") fname) [NAME "this", NAME "arg"]
-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------

mkUnfoldMethod :: Settings -> ClassSpec -> Method
mkUnfoldMethod mp (classname, props) =
    let unfname = "unfold" ++ getClassName classname in
    StaticMethod classname "unfold" ["coalg", "input"] [] $ getStatements $ do
        def "obj" (CALL (METHOD (NAME "coalg") unfname) [NAME "input"])
        forM_ props $ \(n,t,d) -> mkUnfoldMethod_Property (PROP (NAME "obj") n) t
        ret (NAME "obj")


mkUnfoldMethod_Property n t =
    case t of
        IntType -> return ();
        FloatType -> return ();
        StringType -> return ();
        BoolType -> return ();
        ListType t' ->
            assign n $ PRIM "map"
                [ LAMBDA ["obj"]
                    (getStatements (mkUnfoldMethod_Property (NAME "obj") t' >> ret (NAME "obj")))["coalg", "input"]
                , n
                ]
        MapType key cn -> assign n $ CALL (FUNC "assoc_map_") [LAMBDA ["input"]
                                    (getStatements $ ret $ CALL (STATIC cn "unfold")[NAME "coalg", NAME "input"]) ["coalg"], n]
        TupleType ts   -> mapM_
                            (\(i,t) ->
                                mkUnfoldMethod_Property (AT n (I i)) t
                            ) $ zip [0..] ts
        ObjectType cs  ->
            let loop [cn]    = assign n $ CALL (STATIC cn "unfold") [NAME "coalg", NAME "input"]
                loop (cn:cs) = do
                    assign n $ CALL (STATIC cn "unfold") [NAME "coalg", NAME "input"]
                    ifS n (return ()) $ loop cs
            in loop cs
-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
