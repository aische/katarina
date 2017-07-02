module Main where

import Options.Applicative
import Data.Semigroup ((<>))
import Compile

test1 = compile "input/input1/ifile1.txt" ["input/input1/pfile1.txt"] "output/out1" "input/input1/files"
test2 = compile "input/input2/ifile1.txt" ["input/input2/pfile1.txt", "input/input2/pfile2.txt"] "output/out2" "input/input2/files"

main :: IO ()
main = do
    s <- execParser getArgumentsParser
    compile (datatypeFile s) (algebraFiles s) (outputPath s) (additionalFilesPath s)

getArgumentsParser :: ParserInfo Arguments
getArgumentsParser =
  info
    (argumentsParser <**> helper)
    ( fullDesc
    <> progDesc "compile catamorphisms"
    <> header "katarina - catamorphism compiler"
    )

data Arguments = Arguments
  { datatypeFile :: String
  , algebraFiles :: [String]
  , outputPath   :: String
  , additionalFilesPath :: String
  }

argumentsParser :: Parser Arguments
argumentsParser = Arguments
      <$> argument str (metavar "DATATYPEDEFINITION")
      <*> many (argument str (metavar "ALGEBRADEFINITIONS..."))
      <*> strOption
          ( long "output-path"
          <> short 'o'
          <> metavar "PATH"
          <> help "output path for generated files"
          )
      <*> strOption
          ( long "files"
          <> short 'f'
          <> metavar "PATH"
          <> value ""
          <> help "directory with additional files"
          )
