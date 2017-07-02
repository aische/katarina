{-# LANGUAGE TemplateHaskell #-}

module Assets where

import Data.FileEmbed
import qualified Data.ByteString as BS

prelude_php :: BS.ByteString
prelude_php = $(embedFile "assets/prelude.php")

writePreludePHP :: FilePath -> IO ()
writePreludePHP fp =
    BS.writeFile fp prelude_php

prelude_js :: BS.ByteString
prelude_js = $(embedFile "assets/prelude.js")

writePreludeJs :: FilePath -> IO ()
writePreludeJs fp =
    BS.writeFile fp prelude_js