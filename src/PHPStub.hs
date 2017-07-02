module PHPStub where

mkPHPStub :: [String] -> String
mkPHPStub onames = unlines lns
    where
        lns =
            [ "<?php"
            , "include(\"php/prelude.php\");"
            ] ++ fmap (\oname -> "include(\"php/" ++ oname ++ ".php\");") onames ++
            [ "?>"
            , "<!doctype html>"
            , "<html>"
            , "<head>"
            , "<meta charset=\"UTF-8\" />"
            , "</head>"
            , "<body>"
            , "<?php echo \"PHP OK\"; ?>"
            , "<script type=\"text/javascript\" src=\"js/prelude.js\"></script>"
            ] ++ fmap (\oname -> "<script type=\"text/javascript\" src=\"js/" ++ oname ++ ".js\"></script>") onames ++
            [ "<script type=\"text/javascript\" >"
            , "console.log(\"JS OK\");"
            , "</script>"
            , "</body>"
            , "</html>"
            ]
