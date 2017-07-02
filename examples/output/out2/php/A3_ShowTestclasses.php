<?php

class A3_ShowTestclasses extends F_A3 {
    public function __construct () {
    }
    
    public function foldProject($testclasses){
        return implode("<br>", $testclasses);
    }
    
    public function foldTestclass($tid, $name){
        return ("\n        <a href=\"javascript: showTestclass(" . $tid . (")\">" . $name . ("</a>")));
    }
}
