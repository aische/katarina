module Tokenizer where

import Control.Applicative
import Data.Char
import Parser
import Types

{-
split_tokens s = loop s
    where
        isSym c = elem c ".+-*/<>=&|:?!%@"
        tokstr ('\\':'"':s) = let (r,s') = tokenize_string s in ('\\' : '"' : r, s')
        tokstr ('"':s)      = ([], s)
        tokstr (c:s)        = let (r,s') = tokenize_string s in (c : r, s')
        tokstr []           = error "Error: String not closed, unexpected End of File"
        loop []  = []
        loop (c:cs) = case c of
            '(' -> "(" : loop cs
            ')' -> ")" : loop cs
            '{' -> "{" : loop cs
            '}' -> "}" : loop cs
            '[' -> "[" : loop cs
            ']' -> "]" : loop cs
            ';' -> ";" : loop cs
            ',' -> "," : loop cs
            '"' -> let (r,s) = tokstr cs in r : loop s
            '#' -> let (r,s) = span (/='\n') cs in (c:r) : loop s
            '\'' -> "'" : loop cs
            c | isSpace c -> let (r,s) = span isSpace cs in (c:r) : loop s
              | isDigit c -> let (r,s) = span isDigit cs in (c:r) : loop s
              | isLower c -> let (r,s) = span isAlphaNum cs in (c:r) : loop s
              | isUpper c -> let (r,s) = span isAlphaNum cs in (c:r) : loop s
              | isSym c   -> let (r,s) = span isSym cs in (c:r) : loop s
              | otherwise -> [c] : loop cs

type Tokenizer a = String -> Either Error (a, String)

type Tokenizer a = String -> Either Error (a, String)

[(Char -> Bool, String -> Either Error (String, String), String -> a)]
-}

{-
mktok t@(c:_) = case c of
    '(' -> POpen
    ')' -> PClose
    '{' -> StartBlock
    '}' -> EndBlock
    '[' -> StartList
    ']' -> EndList
    ';' -> TSemi
    ',' -> TComma
    '"' ->
    '#' ->
    '\'' ->
    c | isSpace c ->
      | isDigit c ->
      | isLower c ->
      | isUpper c ->
      | isSym c   ->
      | otherwise -> [c] : loop cs
-}


newtype SrcPos = SrcPos { getSrcPos :: String }
    -- deriving (Eq, Show)

data Token
    = TType        SrcPos String Bool
    | TName        SrcPos String Bool
--    | TPrimType    SrcPos String
    | StartBlock   SrcPos
    | EndBlock     SrcPos
    | StartList    SrcPos
    | EndList      SrcPos
    | POpen        SrcPos
    | PClose       SrcPos
    | TSemi        SrcPos
    | TComma       SrcPos
    | TWildcard    SrcPos

    | TIntLit      SrcPos Int
    | TStringLit   SrcPos String
    | TStringLit_  SrcPos String
    | TFloatLit    SrcPos Float
    | TBoolLit     SrcPos Bool
    | TStringTempl SrcPos String

    | TSymbol      SrcPos String
    | TError       SrcPos
    | TEnd
   -- deriving (Show,Eq)

tokenize :: String -> [Token]
tokenize = loop
    where
        isSym c = elem c "!$%&/=?<>.:|?@\\+-*"

        isAlphaNum_ '_' = True
        isAlphaNum_ c = isAlphaNum c

        --tokstr ('\\':'"':s) = let (r,s') = tokstr s in ('\\' : '"' : r, s')
        tokstr ('\\':'"':s) = let (r,s') = tokstr s in ('"' : r, s')
        tokstr ('"':s)      = ([], s)
        tokstr (c:s)        = let (r,s') = tokstr s in (c : r, s')
        tokstr []           = error "Error: String not closed, unexpected End of File"

        tokstr' ('\\':'\'':s) = let (r,s') = tokstr' s in ('\\' : '\'' : r, s')
        tokstr' ('\'':s)     = ([], s)
        tokstr' (c:s)        = let (r,s') = tokstr' s in (c : r, s')
        tokstr' []           = error "Error: String not closed, unexpected End of File"

        tok_template ('<':'?':s) = ("", s)
        tok_template (c:s) = let (r,s') = tok_template s in (c : r, s')
        tok_template _     = error "Error: String not closed, unexpected End of File"

        loop []       = [TEnd]
        loop str@(c:cs) = let w = SrcPos str in case c of
            '{' -> StartBlock   w : loop cs
            '}' -> EndBlock     w : loop cs
            '[' -> StartList    w : loop cs
            ']' -> EndList      w : loop cs
            '(' -> POpen        w : loop cs
            ')' -> PClose       w : loop cs
            ',' -> TComma       w : loop cs
            ';' -> TSemi        w : loop cs
            '_' -> TWildcard    w : loop cs

            '"'  -> let (r,s) = tokstr cs in TStringLit w r : loop s
            '\'' -> let (r,s) = tokstr' cs in TStringLit_ w r : loop s
            '#'  -> let (_,s) = span (/='\n') cs in loop s
            c   | isSpace c -> let (r,s) = span isSpace cs
                               in loop s
                | isSym c   -> case str of
                                    '?':'>':cs' -> let (r, s) = tok_template cs' in TStringTempl w r : loop s
                                    _ -> let (r,s) = span isSym cs in TSymbol w (c:r) : loop s
                | isDigit c -> let (s,r) = span isDigit cs
                               in case r of
                                    '.' : c2 : rr | isDigit c2 ->
                                        let (s2,r2) = span isDigit rr
                                        in TFloatLit w (read ((c:s) ++ "." ++ (c2:s2))) : loop r2
                                    _  -> TIntLit w (read (c:s)) : loop r
            c   | isUpper c -> let (s,r) = span isAlphaNum_ cs
                                   name = (c:s)
                               in if elem name ["Int", "String", "Float", "Bool"]
                                then TType w name True : loop r
                                else TType w name False : loop r
                | isLower c -> let (s,r) = span isAlphaNum_ cs in
                               let name = (c:s) in
                                case name of
                                 "true"  -> TBoolLit w True : loop r
                                 "false" -> TBoolLit w False : loop r
                                 _       -> TName w name False : loop r
                | otherwise -> [TError w]



isPrimType :: Token -> Bool
isPrimType      (TType _ _ True)   = True
isPrimType      _                  = False

isType :: Token -> Bool
isType          (TType _ _ False)  = True
isType          _                  = False

isName :: Token -> Bool
isName          (TName _ _ False)  = True
isName          _                  = False

isReservedName :: Token -> Bool
isReservedName  (TName _ _ True)   = True
isReservedName  _                  = False

isStartBlock :: Token -> Bool
isStartBlock    (StartBlock _)     = True
isStartBlock    _                  = False

isEndBlock :: Token -> Bool
isEndBlock      (EndBlock   _)     = True
isEndBlock      _                  = False

isStartList :: Token -> Bool
isStartList     (StartList  _)     = True
isStartList     _                  = False

isEndList :: Token -> Bool
isEndList       (EndList    _)     = True
isEndList       _                  = False

isPOpen :: Token -> Bool
isPOpen         (POpen      _)     = True
isPOpen         _                  = False

isPClose :: Token -> Bool
isPClose        (PClose     _)     = True
isPClose        _                  = False

isSemi :: Token -> Bool
isSemi          (TSemi      _)     = True
isSemi          _                  = False

isComma :: Token -> Bool
isComma         (TComma     _)     = True
isComma         _                  = False

isWildcard :: Token -> Bool
isWildcard      (TWildcard  _)     = True
isWildcard      _                  = False

isIntLit :: Token -> Bool
isIntLit        (TIntLit  _ _)     = True
isIntLit        _                  = False

isStringLit :: Token -> Bool
isStringLit     (TStringLit _ _)   = True
isStringLit     _                  = False

isStringLit_ :: Token -> Bool
isStringLit_    (TStringLit_ _ _)  = True
isStringLit_    _                  = False

isStringTempl :: Token -> Bool
isStringTempl   (TStringTempl _ _) = True
isStringTempl   _                  = False

isFloatLit :: Token -> Bool
isFloatLit      (TFloatLit _ _)    = True
isFloatLit      _                  = False

isBoolLit :: Token -> Bool
isBoolLit       (TBoolLit _ _)     = True
isBoolLit       _                  = False

isError :: Token -> Bool
isError         (TError     _)     = True
isError         _                  = False

isEnd :: Token -> Bool
isEnd           (TEnd        )     = True
isEnd           _                  = False

equalsType :: String -> Token -> Bool
equalsType    m (TType _ n False) = n == m
equalsType    _ _                 = False

equalsName :: String -> Token -> Bool
equalsName    m (TName _ n False) = n == m
equalsName    _ _                 = False

equalsReserved :: String -> Token -> Bool
equalsReserved m (TName _ n True) = n == m
equalsReserved _ _                 = False

equalsSymbol :: String -> Token -> Bool
equalsSymbol    m (TSymbol _ n )  = n == m
equalsSymbol    _ _               = False

--getTName (TName n _)
getSourceString :: Token -> String
getSourceString t = getSrcPos $ case t of
--     TPrimType    e _ -> e
     TType        e _ _ -> e
     TName        e _ _ -> e
     StartBlock   e     -> e
     EndBlock     e     -> e
     StartList    e     -> e
     EndList      e     -> e
     POpen        e     -> e
     PClose       e     -> e
     TIntLit      e _   -> e
     TStringLit   e _   -> e
     TStringLit_  e _   -> e
     TFloatLit    e _   -> e
     TBoolLit     e _   -> e
     TComma       e     -> e
     TSemi        e     -> e
     TSymbol      e _   -> e
     TError       e     -> e
     TEnd               -> SrcPos "<<End of File>>"


reserveNames :: [Name] -> [Token] -> [Token]
reserveNames ns ts = fmap f ts
    where
        f (TName e s _) = TName e s (elem s ns)
        f t             = t







