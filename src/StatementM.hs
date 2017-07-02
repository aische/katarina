module StatementM where

import Control.Monad(forM_)
import Types
import TypesParser

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
data StatementM a = StatementM { unStatementM :: (a, [Statement])}

getStatements (StatementM ((), s)) = s

instance Functor StatementM where
    fmap f (StatementM (a, s)) = (StatementM (f a, s))

instance Applicative StatementM where
    pure a = StatementM (a, [])
    StatementM (f, s1) <*> StatementM (a, s2) = StatementM (f a, s1 ++ s2)

instance Monad StatementM where
    return a = StatementM (a, [])
    StatementM (a, s1) >>= f = let StatementM (b, s2) = f a in StatementM (b, s1 ++ s2)


def :: Name -> Expression -> StatementM ()
def n e = StatementM ((), [Define n e])

assign :: Expression -> Expression -> StatementM ()
assign n e = StatementM ((), [Assign n e])

ifS :: Expression -> StatementM () -> StatementM () -> StatementM ()
ifS e a b = StatementM ((), [IfS e a' b'])
    where
        StatementM ((), a') = a
        StatementM ((), b') = b

ifS_ :: Expression -> StatementM () -> StatementM ()
ifS_ e a = ifS e a (return ())

ret :: Expression -> StatementM ()
ret e = StatementM ((), [Return e])

expression :: Expression -> StatementM ()
expression e = StatementM ((), [Expr e])

