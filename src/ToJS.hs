module ToJS where

import Types
import Misc

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
indent_js = indent 4;

class ToJS m where
    toJS :: m -> [String]

class ToJSE m where
    toJSE :: m -> String

instance ToJS ClassDef where
    toJS (ClassDef (ClassName cname) scclass props sprops (cargs, cbody) meths)
        =  [ "function " ++ cname ++ " " ++ js_args cargs ++ " {"]
        ++ indent_js (cbody >>= toJS)
        ++ ["}"]
        ++ maybe [] (\(ClassName n) -> [ cname ++ ".prototype = new " ++ n ++ "(); "]) scclass
        ++ fmap (\(n,e) -> cname ++ ".prototype." ++ n ++ " = " ++ toJSE e ++ ";") sprops
        ++ fmap (\(n, e) -> cname ++ "." ++ n ++ " = " ++ toJSE e ++ ";") sprops
        ++ (meths >>= toJS)

instance ToJS Method where
    toJS (Method (ClassName cname) name args defargs body) -- TODO defargs
        =  [ (cname ++ ".prototype." ++ name ++ " = function " ++ js_args (args ++ fmap fst defargs) ++ "{") ]
        ++ indent_js (fmap (\(n,e) -> n ++ " = " ++ n ++ " || " ++ toJSE e ++ ";") defargs)
        ++ indent_js (body >>= toJS)
        ++ ["};"]
    toJS (StaticMethod (ClassName cname) name args defargs body) -- TODO defargs
        =  [ (cname ++ "." ++ name ++ " = function " ++ js_args (args ++ fmap fst defargs) ++ "{") ]
        ++ indent_js (fmap (\(n,e) -> n ++ " = " ++ n ++ " || " ++ toJSE e ++ ";") defargs)
        ++ indent_js (body >>= toJS)
        ++ ["};"]

instance ToJS Statement where
    toJS (Return e) = ["return " ++ toJSE e ++ ";"]
    toJS (IfS e b1 [])
        =  [ "if (" ++ toJSE e ++ ") {" ]
        ++ indent_js (b1 >>= toJS)
        ++ ["}"]
    toJS (IfS e b1 b2)
        =  [ "if (" ++ toJSE e ++ ") {" ]
        ++ indent_js (b1 >>= toJS)
        ++ ["}", "else {" ]
        ++ indent_js (b2 >>= toJS)
        ++ ["}"]
    toJS (Define n e)   = ["var " ++ n ++ " = " ++ toJSE e ++ ";"]
    toJS (Assign e1 e2) = [ toJSE e1 ++ " = " ++ toJSE e2 ++ ";"]
    toJS (Expr e)       = [ toJSE e ++ ";"]
    toJS (For0To ivar lenvar stmts) =
        ["for (" ++ ivar ++ "=0; " ++ ivar ++ "<" ++ lenvar ++"; " ++ ivar ++ "++) {"] ++
        (indent_js $ (stmts >>= toJS)) ++
        ["}"]

js_args :: [Name] -> String
js_args [] = "()"
js_args [x] = "(" ++ x ++ ")"
js_args xs = "(" ++ foldr1 (\x y->x++", "++y) xs ++ ")"

listToJSE :: [Expression] -> String
listToJSE es = "(" ++ joinStrings ", " (fmap toJSE es) ++ ")"

arrayToJSE :: [Expression] -> String
arrayToJSE es = "[" ++ joinStrings ", " (fmap toJSE es) ++ "]"

instance ToJSE Expression where
    toJSE (NAME n)               = n
    toJSE (CNAME c)              = getClassName c
    toJSE (FUNC n)               = n
    toJSE (PROP e n)             = toJSE e ++ "." ++ n
    toJSE (SPROP e n)            = toJSE e ++ "." ++ n
    toJSE (KEY e n)              = toJSE e ++ "['" ++ n ++ "']"
    toJSE (I i)                  = show i
    toJSE (S s)                  = show s
    toJSE (B b)                  = if b then "true" else "false"
    toJSE (F f)                  = show f
    toJSE NULL                   = "null"
    toJSE (ASSOC es)             = "{" ++ joinStrings ", " (fmap (\(n,e) -> n ++ ": " ++ toJSE e ) es) ++ "}"
    toJSE (ARRAY es)             = arrayToJSE es
    toJSE (AT e1 e2)             = toJSE e1 ++ "[" ++ toJSE e2 ++ "]"
    toJSE (NEW (ClassName c) es) = "new " ++ c ++ listToJSE es
    toJSE (IF e b1 b2)           = "(" ++ toJSE e ++ ")?(" ++ toJSE b1 ++ "):(" ++ toJSE b2 ++ ")"
    toJSE (ISASSOC e)            = "isObject(" ++ toJSE e ++ ")"
    toJSE (HASKEY n e)           = "('" ++ n ++ "' in " ++ toJSE e ++ ")"
    toJSE (CALL e es)            = toJSE e ++ listToJSE es
    toJSE (STATIC cn n)          = getClassName cn ++ "." ++ n
    toJSE (STATICE e n)          = toJSE e ++ "." ++ n
    toJSE (METHOD e n)           = toJSE e ++ "." ++ n
    toJSE (LAMBDA a b u)         = let lns = (b >>= toJS)
                                    in case lns of
                                        []  -> "function" ++ js_args a ++ "{}"
                                        [l] -> "function" ++ js_args a ++ "{" ++ l ++ "}"
                                        lns -> "function" ++ js_args a ++ "{" ++ unlines lns ++ "}"
    toJSE (e1 :== e2)            = "(" ++ toJSE e1 ++ " == " ++ toJSE e2 ++ ")"
    toJSE (e1 :=== e2)           = "(" ++ toJSE e1 ++ " === " ++ toJSE e2 ++ ")"
    toJSE (e1 :/= e2)            = "(" ++ toJSE e1 ++ " != " ++ toJSE e2 ++ ")"
    toJSE (e1 :/== e2)           = "(" ++ toJSE e1 ++ " !== " ++ toJSE e2 ++ ")"
    toJSE (e1 :|| e2)            = "(" ++ toJSE e1 ++ " || " ++ toJSE e2 ++ ")"
    toJSE (e1 :++ e2)            = "(" ++ toJSE e1 ++ " + " ++ toJSE e2 ++ ")"
    toJSE (e1 :+: e2)            = "(" ++ toJSE e1 ++ " + " ++ toJSE e2 ++ ")"
    toJSE (e1 :-: e2)            = "(" ++ toJSE e1 ++ " - " ++ toJSE e2 ++ ")"
    toJSE (e1 :*: e2)            = "(" ++ toJSE e1 ++ " * " ++ toJSE e2 ++ ")"
    toJSE (e1 :/: e2)            = "(" ++ toJSE e1 ++ " / " ++ toJSE e2 ++ ")"
    toJSE (e1 :%: e2)            = "(" ++ toJSE e1 ++ " % " ++ toJSE e2 ++ ")"
--    toJSE (ArrayLength e)        = toJSE e ++ ".length"
--    toJSE (IsArray e)            = "Array.isArray(" ++ toJSE e ++ ")"

    {-
    toJSE (AND es)               = "(" ++ joinStrings " && " (fmap toJSE es) ++ ")"
    toJSE (OR es)                = "(" ++ joinStrings " || " (fmap toJSE es) ++ ")"
    toJSE (STRAPPEND es)         = "(" ++ joinStrings " + " (fmap toJSE es) ++ ")"
    toJSE (ARRAYMAP f e)         = toJSE e ++ ".map(" ++ toJSE f ++ ")"
    toJSE (IMPLODE e1 e2)        = toJSE e2 ++ ".join(" ++ toJSE e1 ++ ")"

    toJSE (CASTTOINT    e)       = "parseInt(" ++ toJSE e ++ ")"
    toJSE (CASTTOFLOAT  e)       = "parseFloat(" ++ toJSE e ++ ")"
    toJSE (CASTTOBOOL   e)       = "(" ++ toJSE e ++ "? TRUE : FALSE)"
    toJSE (CASTTOSTRING e)       = "String(" ++ toJSE e ++ ")"
    -}

    toJSE (PRIM n es)            = case (n, es) of
                                    ("map", [f,e])        -> toJSE e ++ ".map(" ++ toJSE f ++ ")"
                                    ("int", [e])          -> "parseInt(" ++ toJSE e ++ ")"
                                    ("float", [e])        -> "parseFloat(" ++ toJSE e ++ ")"
                                    ("string", [e])       -> "String(" ++ toJSE e ++ ")"
                                    ("bool", [e])         -> "(" ++ toJSE e ++ "? true : false)"
                                    ("implode", [e1, e2]) -> toJSE e2 ++ ".join(" ++ toJSE e1 ++ ")"
                                    ("concat", _)         -> "(" ++ joinStrings " + " (fmap toJSE es) ++ ")"
                                    ("and", _)            -> "(" ++ joinStrings " && " (fmap toJSE es) ++ ")"
                                    ("or", _)             -> "(" ++ joinStrings " || " (fmap toJSE es) ++ ")"
                                    ("append", [v,a])     -> toJSE v ++ ".concat(" ++ toJSE a ++ ")"
                                    ("consarray", [v,a])  -> "[" ++ toJSE v ++ "].concat(" ++ toJSE a ++ ")"
                                    _                     -> error ("toJSE: " ++ n ++ listToJSE es)

