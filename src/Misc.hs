module Misc where

import Data.Char

----------------------------------------------------------------------------------------
--
----------------------------------------------------------------------------------------
joinStrings :: String -> [String] -> String
joinStrings j []  = ""
joinStrings j [s] = s
joinStrings j xs  = foldr1 (\x y->x++j++y) xs

----------------------------------------------------------------------------------------
--
----------------------------------------------------------------------------------------
indent :: Int -> [String] -> [String]
indent i lns = fmap (s++) lns
    where
        s = replicate i ' '

----------------------------------------------------------------------------------------
--
----------------------------------------------------------------------------------------
(+/+) :: FilePath -> FilePath -> FilePath
(+/+) "" s2 = s2
(+/+) s1 "" = s1
(+/+) s1 s2 = removeTrailingSlash ++ "/" ++ removeLeadingSlash s2
    where
        removeTrailingSlash = reverse $ f1 $ reverse s1
        f1 ('/':r) = r
        f1 r       = r
        removeLeadingSlash ('/':r) = r
        removeLeadingSlash r       = r


getDirectoryOfFile :: FilePath -> FilePath
getDirectoryOfFile fp = reverse (dropWhile (/='/') (reverse fp))
