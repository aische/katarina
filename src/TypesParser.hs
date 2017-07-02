module TypesParser where

import Control.Applicative
import Data.Char
import Parser
import Types
import Tokenizer

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
reserved_names :: [String]
reserved_names = ["if", "return", "new", "var", "and", "or", "map", "concat", "implode", "append"]

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
isSum :: Token -> Bool
isSum (TSymbol _ "|")  = True
isSum _                 = False

isColon :: Token -> Bool
isColon (TSymbol _ ":")  = True
isColon _                 = False

isDoubleColon :: Token -> Bool
isDoubleColon (TSymbol _ "::") = True
isDoubleColon _                = False

isArrow :: Token -> Bool
isArrow (TSymbol _ "=>") = True
isArrow _                 = False

isEquals :: Token -> Bool
isEquals (TSymbol _ "=")  = True
isEquals  _               = False

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
type TypeSyn = (Name, PropertyType)

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
parse_specs :: String -> Either String (ProjectName, [ClassSpec])
parse_specs s = unP m ts f (Left . getSourceString . head)
    where
        m = p_specs >>= \r -> p_end >> return r
        ts = tokenize s
        f r []     = Right $ unSynSpecs r
        f r s  = (Left . getSourceString . head) s
        isLeft (Left _)   = True
        isLeft _          = False
        isRight (Right _) = True
        isRight _         = False
        unSynSpecs (classname, css) =
            let
                syns   = fmap (\(Left x)->x) $ filter (isLeft) css
                cdfs   = fmap (\(Right x)->x) $ filter (isRight) css
                cdfs'  = fmap (\(c,ps) -> (c, fmap unSyn2 ps)) cdfs
                unSyn2 (n,t,d) = (n, unSynType syns t, d)
            in (classname, cdfs')

unSynType :: [(Name, PropertyType)] -> PropertyType -> PropertyType
unSynType syns t = case t of
    AbstractType n -> case lookup n syns of
                        Just t' -> t'
                        Nothing -> error ("Undefined Type Synonym Name:" ++ n)
    ListType t'    -> ListType (unSynType syns t')
    TupleType ts   -> TupleType (fmap (unSynType syns) ts)
    _              -> t

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
parse_subprops :: String -> Either String [PropertySubset2]
parse_subprops s = unP m ts f (Left . getSourceString . head)
    where
        m = p_subproperties >>= \r -> p_end >> return r
        ts = tokenize s
        f r []     = Right r
        f r s  = (Left . getSourceString . head) s

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
parse_subpropsWB :: String -> Either String [(ClassName, [Name], [Statement])]
parse_subpropsWB s = unP m ts' f (Left . getSourceString . head)
    where
        m = p_subproperties2 >>= \r -> p_end >> return r
        ts = tokenize s
        ts' = reserveNames reserved_names ts
        f r []     = Right r
        f r s  = (Left . getSourceString . head) s
-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------

parse_functor :: String -> Either String FunctorSubset2
parse_functor s = unP m ts' f (Left . getSourceString . head)
    where
        m = p_functor >>= \r -> p_end >> return r
        ts = tokenize s
        ts' = reserveNames reserved_names ts
        f r []     = Right r
        f r s  = (Left . getSourceString . head) s


parse_injection :: String -> Either String ClassInjection
parse_injection s = unP m ts' f (Left . getSourceString . head)
    where
        m = p_injection >>= \r -> p_end >> return r
        ts = tokenize s
        ts' = reserveNames reserved_names ts
        f r []     = Right r
        f r s  = (Left . getSourceString . head) s

parse_functordefs :: String -> Either String [FunctorDef]
parse_functordefs s = unP m ts' f (Left . getSourceString . head)
    where
        m = some p_alg_inj >>= \r -> p_end >> return r
        ts = tokenize s
        ts' = reserveNames reserved_names ts
        f r []     = Right r
        f r s  = (Left . getSourceString . head) s


-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
p_end :: P o [Token] ()
p_end = do
    sat isEnd
    return ()

p_name :: P o [Token] String
p_name = sat isName >>= \(TName _ n _) -> return n

p_intlit :: P o [Token] Expression
p_intlit = do
    TIntLit _ i <- sat isIntLit
    return $ I i

p_floatlit :: P o [Token] Expression
p_floatlit = do
    TFloatLit _ f <- sat isFloatLit
    return $ F f

p_boollit :: P o [Token] Expression
p_boollit = do
    TBoolLit _ b <- sat isBoolLit
    return $ B b

p_stringlit :: P o [Token] Expression
p_stringlit = do
    TStringLit _ s <- sat isStringLit
    return (S s)

p_emptylistlit :: P o [Token] Expression
p_emptylistlit = do
    sat (isStartList)
    sat (isEndList)
    return (ARRAY [])

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
p_specs :: P o [Token] (ProjectName, [Either TypeSyn ClassSpec])
p_specs = do
    sat (equalsName "data")
    cn <- p_objecttype
    sat isStartBlock
    defs <- p_specs_
    sat isEndBlock
    return (ProjectName $ getClassName cn, defs)



p_specs_ :: P o [Token] [Either (String, PropertyType) (ClassName, [(String, PropertyType, Maybe Expression)])]
p_specs_ = many ((p_typesynonym >>= return . Left) <|> (p_classdef >>= return . Right))

p_typesynonym :: P o [Token] (String, PropertyType)
p_typesynonym = do
    n <- p_name
    sat isEquals
    ot <- p_objectsumtype
    sat isSemi
    return (n, ot)

p_classdef :: P o [Token] (ClassName, [(String, PropertyType, Maybe Expression)])
p_classdef = do
    TType _ c _ <- sat isType
    sat isStartBlock
    ds <- many p_property
    sat isEndBlock
    return (ClassName c, ds)

p_property :: P o [Token] (String, PropertyType, Maybe Expression)
p_property = do
    n <- p_name
    sat isDoubleColon
    t <- p_typedef
    d <- (sat isEquals >> p_lit >>= \x -> return (Just x)) <|> (return Nothing)
    sat isSemi
    return (n, t, d)

p_typedef  :: P o [Token] PropertyType
p_typedef = p_tupletype <|> p_maptype <|> p_listtype <|> p_primtype <|> p_objectsumtype <|> p_abstracttype

p_abstracttype :: P o [Token] PropertyType
p_abstracttype = p_name >>= return . AbstractType

p_primtype :: P o [Token] PropertyType
p_primtype = do
    TType _ n _ <- sat isPrimType
    case n of
        "Int"       -> return $ IntType
        "String"    -> return $ StringType
        "Float"     -> return $ FloatType
        "Bool"      -> return $ BoolType
        _           -> empty

p_listtype :: P o [Token] PropertyType
p_listtype = do
    sat (isStartList)
    t <- p_typedef
    sat (isEndList)
    return $ ListType t

p_objecttype :: P o [Token] ClassName
p_objecttype = do
    TType _ n _ <- sat isType
    if elem n ["Int", "String", "Float", "Bool"] then empty else return (ClassName n)


p_objectsumtype :: P o [Token] PropertyType
p_objectsumtype = do
    cs <- some_inter (sat isSum) p_objecttype
    return $ ObjectType cs

--
some_inter :: (Monad f, Alternative f) => f a1 -> f a -> f [a]
some_inter i p = do
    o <- p
    os <- many (i >> p)
    return (o:os)

many_inter :: (Monad f, Alternative f) => f a1 -> f a -> f [a]
many_inter i p = some_inter i p <|> return []

-- name
p_maptype :: P o [Token] PropertyType
p_maptype = do
    sat (isStartList)
    n <- p_name
    sat (isArrow)
    t <- p_objecttype
    sat (isEndList)
    return $ MapType n t

p_tupletype :: P o [Token] PropertyType
p_tupletype = do
    sat (isStartList)
    o <- p_typedef
    os <- some (sat (isComma) >> p_typedef)
    sat (isEndList)
    return $ TupleType (o:os)

p_lit :: P o [Token] Expression
p_lit = p_intlit <|> p_stringlit <|> p_floatlit <|> p_boollit <|> p_emptylistlit

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
p_alg_inj :: P o [Token] FunctorDef
p_alg_inj = (fmap Right p_injection <|> fmap Left p_functor)

p_functor :: P o [Token] FunctorSubset2
p_functor = do
    sat (equalsName "functor")
    cn <- p_objecttype
    sat (equalsSymbol "::")
    ty <- p_objecttype
    sat isStartBlock
    defs <- p_subproperties
    sat isEndBlock
    return (FunctorName $ getClassName cn, ProjectName $ getClassName ty, defs)

p_injection :: P o [Token] ClassInjection
p_injection = do
    sat (equalsName "algebra")
    cn <- p_objecttype
    sat (equalsSymbol "::")
    ty <- p_objecttype
    sat isStartBlock
    defs <- p_subproperties2
    sat isEndBlock
    return (AlgebraName $ getClassName cn, FunctorName $ getClassName ty, defs)
-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
p_subproperties :: P o [Token] [(ClassName, [(Name, Maybe KeyorderName)])]
p_subproperties = many p_subproperty

p_subproperty :: P o [Token] (ClassName, [(Name, Maybe KeyorderName)])
p_subproperty = do
    cn <- p_objecttype
    sat (isPOpen)
    ns <- many_inter (sat isComma) p_name_and_mbkeyorder
    sat (isPClose)
    return (cn, ns)

p_name_and_mbkeyorder :: P o [Token] (Name, Maybe KeyorderName)
p_name_and_mbkeyorder = do
    n   <- p_name
    mbk <- p_mbkeyorder
    return (n, mbk)

p_mbkeyorder :: P o [Token] (Maybe KeyorderName)
p_mbkeyorder = (sat (equalsSymbol "<-") >> p_keyorder >>= return . Just) <|> return Nothing

p_keyorder :: P o [Token] KeyorderName
p_keyorder = p_keyorderwildcard <|> p_keyordername <|> p_keyorderlistortuple

p_keyorderwildcard :: P o [Token] KeyorderName
p_keyorderwildcard = sat isWildcard >> return KeyorderWildcard

p_keyordername :: P o [Token] KeyorderName
p_keyordername = p_name >>= return . KeyorderName

p_keyorderlistortuple :: P o [Token] KeyorderName
p_keyorderlistortuple = do
    sat isStartList
    ko1 <- p_keyorder
    kos <- many (sat isComma >> p_keyorder)
    sat isEndList
    case kos of
        [] -> return $ KeyorderList ko1
        _  -> return $ KeyorderTuple (ko1:kos)



--------------------------------------------------------
--
-------------------------------------------------------------------------------
p_subproperties2 :: P o [Token] [(ClassName, [Name], [Statement])]
p_subproperties2 = many p_subproperty2

p_subproperty2 :: P o [Token] (ClassName, [Name], [Statement])
p_subproperty2 = do
    cn <- p_objecttype
    sat (isPOpen)
    ns <- many_inter (sat isComma) p_name
    sat (isPClose)
    bo <- p_statementblock
    return (cn, ns, bo)

p_functorproperties :: P o [Token] [(ClassName, [(Name, Maybe KeyorderName)])]
p_functorproperties = many p_functorproperty

p_functorproperty :: P o [Token] (ClassName, [(Name, Maybe KeyorderName)])
p_functorproperty = do
    cn <- p_objecttype
    sat (isPOpen)
    ns <- many_inter (sat isComma) p_name_and_mbkeyorder
    sat (isPClose)
    return (cn, ns)
-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
p_statementblock :: P o [Token] [Statement]
p_statementblock = do
    sat (isStartBlock)
    st <- many p_statement
    sat (isEndBlock)
    return st

p_statement :: P o [Token] Statement
p_statement = p_stmt_return <|> p_stmt_define <|> p_stmt_if <|> p_stmt_set

p_stmt_return :: P o [Token] Statement
p_stmt_return = do
    sat (equalsReserved "return")
    e <- p_expression
    sat isSemi
    return $ Return e

p_stmt_define :: P o [Token] Statement
p_stmt_define = do
    sat (equalsReserved "var")
    n <- p_name
    sat (equalsSymbol "=")
    e <- p_expression
    sat isSemi
    return $ Define n e

p_stmt_set :: P o [Token] Statement
p_stmt_set = do
    n <- p_expression
    sat (equalsSymbol "=")
    e <- p_expr
    sat isSemi
    return $ Assign n e

p_stmt_if :: P o [Token] Statement
p_stmt_if = do
    sat (equalsReserved "if")
    a <- p_expression
    b <- p_statementblock
    c <- p_statementblock
    return (IfS a b c)

p_expression :: P o [Token] Expression
p_expression = do
    e <- p_expr
    es <- many po_postop
    return $ foldl (\e f -> f e) e es

p_expr :: P o [Token] Expression
p_expr = (sat isPOpen >> p_expression >>= \e -> sat isPClose >> return e)
        <|> p_intlit
        <|> p_stringlit
        <|> p_floatlit
        <|> p_boollit
        <|> p_null
        <|> p_array
        <|> p_assoc
        <|> p_new
        <|> p_if
        <|> p_lambda
        <|> p_and
        <|> p_or
        <|> p_implode
        <|> p_map
        <|> p_concat
        <|> p_append
        <|> p_varname
        <|> p_funname
        <|> p_classname
        <|> p_template

p_varname :: P o [Token] Expression
p_varname = do
    n <- p_name
    return (NAME n)

p_funname :: P o [Token] Expression
p_funname = do
    sat (equalsSymbol "$")
    n <- p_name
    return (FUNC n)

p_classname :: P o [Token] Expression
p_classname = do
    c <- p_objecttype
    return (CNAME c)

p_null :: P o [Token] Expression
p_null = do
    sat (equalsType "BOOL")
    return NULL

p_array :: P o [Token] Expression
p_array = do
    sat isStartList
    es <- many_inter (sat isComma) p_expr
    sat isEndList
    return (ARRAY es)

p_assoc :: P o [Token] Expression
p_assoc = do
    sat isStartBlock
    es <- many_inter (sat isComma) (p_name >>= \n -> sat isColon >> p_expr >>= \e -> return (n,e))
    sat isEndBlock
    return (ASSOC es)

p_new :: P o [Token] Expression
p_new = do
    sat (equalsReserved "new")
    TType _ c _ <- sat isType
    sat isPOpen
    es <- many_inter (sat isComma) p_expr
    sat isPClose
    return (NEW (ClassName c) es)

p_if :: P o [Token] Expression
p_if = do
    sat (equalsReserved "if")
    e1 <- p_expr
    e2 <- p_expr
    e3 <- p_expr
    return $ IF e1 e2 e3

p_lambda :: P o [Token] Expression
p_lambda = do
    sat (equalsSymbol "\\")
    sat isPOpen
    xs <- many_inter (sat isComma) p_name
    sat isPClose
    body <- p_statementblock
    return (LAMBDA xs body [])

p_and :: P o [Token] Expression
p_and = do
    sat (equalsReserved "and")
    sat isPOpen
    es <- many_inter (sat isComma) p_expression
    sat isPClose
    return $ PRIM "and" es

p_or :: P o [Token] Expression
p_or = do
    sat (equalsReserved "or")
    sat isPOpen
    es <- many_inter (sat isComma) p_expression
    sat isPClose
    return $ PRIM "or" es

p_concat :: P o [Token] Expression
p_concat = do
    sat (equalsReserved "concat")
    sat isPOpen
    es <- many_inter (sat isComma) p_expression
    sat isPClose
    return $ PRIM "concat" es

p_append :: P o [Token] Expression
p_append = do
    sat (equalsReserved "append")
    sat isPOpen
    es <- many_inter (sat isComma) p_expression
    sat isPClose
    return $ PRIM "append" es

p_map :: P o [Token] Expression
p_map = do
    sat (equalsReserved "map")
    sat isPOpen
    f <- p_expression
    sat isComma
    e <- p_expression
    sat isPClose
    return $ PRIM "map" [f, e]

p_implode :: P o [Token] Expression
p_implode = do
    sat (equalsReserved "implode")
    sat isPOpen
    f <- p_expression
    sat isComma
    e <- p_expression
    sat isPClose
    return $ PRIM "implode" [f, e]

p_template :: P o [Token] Expression
p_template = do
    TStringTempl _ s <- sat isStringTempl
    es <- many p_expression
    return $ PRIM "concat" (S s : es)

po_postop :: P o [Token] (Expression -> Expression)
po_postop = po_key
        <|> po_at
        <|> po_prop
        <|> po_sprop
        <|> po_method
        <|> po_static
        <|> po_call
        <|> po_op

po_key :: P o [Token] (Expression -> Expression)
po_key = do
    sat isStartList
    TStringLit_ _ n <- sat isStringLit_
    sat isEndList
    return $ \e -> KEY e n

po_at :: P o [Token] (Expression -> Expression)
po_at = do
    sat isStartList
    a <- p_expr
    sat isEndList
    return $ \e -> AT e a

po_prop :: P o [Token] (Expression -> Expression)
po_prop = do
    sat(equalsSymbol ".")
    n <- p_name
    return $ \e -> PROP e n

po_sprop :: P o [Token] (Expression -> Expression)
po_sprop = do
    sat (equalsSymbol "::")
    n <- p_name
    return $ \e -> SPROP e n

po_method :: P o [Token] (Expression -> Expression)
po_method = do
    sat (equalsSymbol "->")
    n <- p_name
    return $ \e -> METHOD e n

po_static :: P o [Token] (Expression -> Expression)
po_static = do
    sat (equalsSymbol "::->")
    n <- p_name
    return $ \e -> METHOD e n

po_op :: P o [Token] (Expression -> Expression)
po_op = foldr (<|>) empty $ fmap aux ops
    where
        ops = [ ("++",  (:++))
              , ("==",  (:==))
              , ("/=",  (:/=))
              , ("===", (:===))
              , ("/==", (:/==))
              , ("||",  (:||))
              , ("+",   (:+:))
              , ("-",   (:-:))
              , ("*",   (:*:))
              , ("/",   (:/:))
              , ("%",   (:%:))
              ]
        aux (op,f) = do
            sat (equalsSymbol op)
            a <- p_expr
            return $ \e -> f e a

po_call :: P o [Token] (Expression -> Expression)
po_call = do
    sat isPOpen
    es <- many_inter (sat isComma) p_expr
    sat isPClose
    return $ \e -> CALL e es

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
