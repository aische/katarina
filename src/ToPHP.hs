module ToPHP where

import Types
import Misc

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
indent_php = indent 4;

class ToPHP m where
    toPHP :: m -> [String]

class ToPHPE m where
    toPHPE :: m -> String

instance ToPHP ClassDef where
    toPHP (ClassDef (ClassName cname) scclass props sprops (cargs, cbody) meths) =
        let superclass = maybe "" (\(ClassName n) -> "extends " ++ n ++ " ") scclass in
        [ "", "class " ++ cname ++ " " ++ superclass ++ "{"]
        ++ indent_php
            ( fmap (\(n,e) -> "public static $" ++ n ++ " = " ++ toPHPE e ++ ";") sprops
            ++ ["public function __construct " ++ php_args_ cargs ++ " {"]
            ++ indent_php (cbody >>= toPHP)
            ++ ["}"]
            )
        ++ indent_php (meths >>= toPHP)
        ++ [ "}"]

instance ToPHP Method where
    toPHP (Method (ClassName cname) name args defargs body) -- TODO defargs
        =  [ "", ("public function " ++ name ++ php_args args defargs ++ "{") ]
        ++ indent_php (body >>= toPHP)
        ++ ["}"]
    toPHP (StaticMethod (ClassName cname) name args defargs body) -- TODO defargs
        =  [ "", ("public static function " ++ name ++ php_args args defargs ++ "{") ]
        ++ indent_php (body >>= toPHP)
        ++ ["}"]

instance ToPHP Statement where
    toPHP (Return e) = ["return " ++ toPHPE e ++ ";"]
    toPHP (IfS e b1 [])
        =  [ "if (" ++ toPHPE e ++ ") {" ]
        ++ indent_php (b1 >>= toPHP)
        ++ ["}"]
    toPHP (IfS e b1 b2)
        =  [ "if (" ++ toPHPE e ++ ") {" ]
        ++ indent_php (b1 >>= toPHP)
        ++ ["}", "else {" ]
        ++ indent_php (b2 >>= toPHP)
        ++ ["}"]
    toPHP (Define n e)   = ["$" ++ n ++ " = " ++ toPHPE e ++ ";"]
    toPHP (Assign e1 e2) = [ toPHPE e1 ++ " = " ++ toPHPE e2 ++ ";"]
    toPHP (Expr e)       = [ toPHPE e ++ ";"]
    toPHP (For0To ivar lenvar stmts) =
        ( "for ($" ++ ivar ++ "=0; $" ++ ivar ++ "<$" ++ lenvar ++"; $" ++ ivar ++ "++)") :
        (indent_php $ (stmts >>= toPHP))

php_args :: [Name] -> [(Name, Expression)] -> String
php_args ns [] = php_args_ ns
php_args ns ds = php_args_ (ns ++ fmap (\(n,e) -> n ++ " = " ++ toPHPE e) ds)

php_args_ [] = "()"
php_args_ [x] = "($" ++ x ++ ")"
php_args_ xs = "(" ++ foldr1 (\x y-> x ++ ", " ++ y) (fmap ("$" ++) xs) ++ ")"

--dropDollar ('$':s) = s


listToPHPE :: [Expression] -> String
listToPHPE es = "(" ++ joinStrings ", " (fmap toPHPE es) ++ ")"

arrayToPHPE :: [Expression] -> String
arrayToPHPE es = "array(" ++ joinStrings ", " (fmap toPHPE es) ++ ")"

instance ToPHPE Expression where
    toPHPE (NAME n)               = "$" ++ n
    toPHPE (CNAME c)              = getClassName c
    toPHPE (FUNC n)               = "'" ++ n ++ "'"
    toPHPE (PROP e n)             = toPHPE e ++ "->" ++ n
    toPHPE (SPROP e n)            = toPHPE e ++ "::$" ++ n
    toPHPE (KEY e n)              = toPHPE e ++ "['" ++ n ++ "']"
    toPHPE (I i)                  = show i
    toPHPE (S s)                  = show s
    toPHPE (B b)                  = show b
    toPHPE (F f)                  = show f
    toPHPE NULL                   = "NULL"
    toPHPE (ASSOC es)             = "array(" ++ joinStrings ", " (fmap (\(n,e) -> "'" ++ n ++ "' => " ++ toPHPE e ) es) ++ ")"
    toPHPE (ARRAY es)             = arrayToPHPE es
    toPHPE (AT e1 e2)             = toPHPE e1 ++ "[" ++ toPHPE e2 ++ "]"
    toPHPE (NEW (ClassName c) es) = "new " ++ c ++ listToPHPE es
    toPHPE (IF e b1 b2)          = "(" ++ toPHPE e ++ ")?(" ++ toPHPE b1 ++ "):(" ++ toPHPE b2 ++ ")"
    toPHPE (ISASSOC e)            = "is_array(" ++ toPHPE e ++ ")"
    toPHPE (HASKEY n e)           = "isset(" ++ toPHPE e ++ "['" ++ n ++ "'])"
    toPHPE (CALL e es)             = "call_user_func" ++ listToPHPE (e:es)
--    toPHPE (ArrayLength e)        = "count(" ++ toPHPE e ++ ")"
--    toPHPE (IsArray e)            = "is_array(" ++ toPHPE e ++ ")"

    toPHPE (STATIC cn n)          = "array('" ++ getClassName cn ++ "', '" ++ n ++ "')"
    toPHPE (STATICE e n)          = "array(" ++ toPHPE e ++ ", '" ++ n ++ "')"
    toPHPE (METHOD e n)           = "array(" ++ toPHPE e ++ ", '" ++ n ++ "')"
    toPHPE (LAMBDA a b u)         = let lns = (b >>= toPHP) in
                                    let uuu | u == [] = ""
                                            | True    = "use" ++ php_args_ u

                                           in case lns of
                                            []  -> "function" ++ php_args_ a ++ uuu ++ "{}"
                                            [l] -> "function" ++ php_args_ a ++ uuu ++ "{" ++ l ++ "}"
                                            lns -> "function" ++ php_args_ a ++ uuu ++ "{" ++ unlines lns ++ "}"

    toPHPE (e1 :== e2)            = "(" ++ toPHPE e1 ++ " == " ++ toPHPE e2 ++ ")"
    toPHPE (e1 :=== e2)           = "(" ++ toPHPE e1 ++ " === " ++ toPHPE e2 ++ ")"
    toPHPE (e1 :/= e2)            = "(" ++ toPHPE e1 ++ " != " ++ toPHPE e2 ++ ")"
    toPHPE (e1 :/== e2)           = "(" ++ toPHPE e1 ++ " !== " ++ toPHPE e2 ++ ")"
    toPHPE (e1 :|| e2)            = "(" ++ toPHPE e1 ++ " || " ++ toPHPE e2 ++ ")"
    toPHPE (e1 :++ e2)            = "(" ++ toPHPE e1 ++ " . " ++ toPHPE e2 ++ ")"
    toPHPE (e1 :+: e2)            = "(" ++ toPHPE e1 ++ " + " ++ toPHPE e2 ++ ")"
    toPHPE (e1 :-: e2)            = "(" ++ toPHPE e1 ++ " - " ++ toPHPE e2 ++ ")"
    toPHPE (e1 :*: e2)            = "(" ++ toPHPE e1 ++ " * " ++ toPHPE e2 ++ ")"
    toPHPE (e1 :/: e2)            = "(" ++ toPHPE e1 ++ " / " ++ toPHPE e2 ++ ")"
    toPHPE (e1 :%: e2)            = "(" ++ toPHPE e1 ++ " % " ++ toPHPE e2 ++ ")"
    {-
    toPHPE (ARRAYMAP f e)         = "array_map(" ++ toPHPE f ++ ", " ++ toPHPE e ++ ")"
    toPHPE (IMPLODE e1 e2)        = "implode(" ++ toPHPE e1 ++ ", " ++ toPHPE e2 ++ ")"

    toPHPE (AND es)               = "(" ++ joinStrings " && " (fmap toPHPE es) ++ ")"
    toPHPE (OR es)                = "(" ++ joinStrings " || " (fmap toPHPE es) ++ ")"
    toPHPE (STRAPPEND es)         = joinStrings " . " (fmap toPHPE es)

    toPHPE (CASTTOINT    e)       = "(int)" ++ toPHPE e
    toPHPE (CASTTOFLOAT  e)       = "(float)" ++ toPHPE e
    toPHPE (CASTTOBOOL   e)       = "(" ++ toPHPE e ++ "? TRUE : FALSE)"
    toPHPE (CASTTOSTRING e)       = "(string)" ++ toPHPE e
    -}
    toPHPE (PRIM n es)            = case (n, es) of
                                    ("map", [f,e])        -> "array_map(" ++ toPHPE f ++ ", " ++ toPHPE e ++ ")"
                                    ("int", [e])          -> "(int)" ++ toPHPE e
                                    ("float", [e])        -> "(float)" ++ toPHPE e
                                    ("string", [e])       -> "(string)" ++ toPHPE e
                                    ("bool", [e])         -> "(" ++ toPHPE e ++ "? true : false)"
                                    ("implode", [e1, e2]) -> "implode(" ++ toPHPE e1 ++ ", " ++ toPHPE e2 ++ ")"
                                    ("concat", _)         -> "(" ++ joinStrings " . " (fmap toPHPE es) ++ ")"
                                    ("and", _)            -> "(" ++ joinStrings " && " (fmap toPHPE es) ++ ")"
                                    ("or", _)             -> "(" ++ joinStrings " || " (fmap toPHPE es) ++ ")"
                                    ("append", [v,a])     -> "array_merge(" ++ toPHPE v ++ "," ++ toPHPE a ++ ")"
                                    ("consarray", [v,a])  -> "array_merge(array(" ++ toPHPE v ++ ")," ++ toPHPE a ++ ")"
                                    _                     -> error ("toPHPPE: " ++ n ++ listToPHPE es)

