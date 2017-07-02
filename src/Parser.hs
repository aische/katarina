module Parser where

import Control.Applicative
import Data.Char

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
newtype P o s a = P { unP :: s -> (a -> s -> o) -> (s -> o) -> o }

instance Functor (P o s) where
    fmap f (P g) = P $ \s c e -> g s (\a s -> c (f a) s) e

instance Applicative (P o s) where
    pure a = P $ \s c e -> c a s
    P mf <*> P ma = P $ \s c e -> mf s (\f s -> ma s (\a s -> c (f a) s) e) e

instance Alternative (P o s) where
    empty = P $ \s c e -> e s
    P m1 <|> P m2 = P $ \s c e -> m1 s c (\ _ -> m2 s c e)

instance Monad (P o s) where
    return = pure
    P g >>= f = P $ \s c e -> g s (\a s -> unP (f a) s c e) e

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
next :: P o [a] a
next = P $ \s c e -> case s of
    x:xs -> c x xs
    _    -> e []

nextP :: (s -> Maybe (a, s)) -> P o s a
nextP f = P $ \s c e -> maybe (e s) (uncurry c) $ f s

must :: Bool -> P o s ()
must p = if p then return () else empty

sat :: (a -> Bool) -> P o [a] a
sat p = next >>= \a -> if p a then return a else empty

