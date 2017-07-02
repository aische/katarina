<?php

class A2_I5 extends F_A2 {
    public function __construct () {
    }
    
    public function foldTestclass($tid, $name, $nodes){
        return ("\n        Testclass(" . $tid . ("):\n        <span class=\"edit\" \n              style=\"color:magenta;\"\n              data-tid=\"" . $tid . ("\"\n              data-typ=\"Testclass.name\"\n            >" . $name . ("</span>:\n        <ul>" . implode("", $nodes) . ("</ul>")))));
    }
    
    public function foldANode($aid, $weight){
        return ("\n        <li><span style=\"color:#008888;\">" . $aid . (": " . $weight . ("</span>\n        </li>")));
    }
    
    public function foldRNode($name, $weight, $nodes){
        return ("\n        <li><span style=\"color:#009900;\">" . $name . (": " . $weight . ("</span>\n        <ul>\n        " . implode("", $nodes) . ("\n        </ul>\n        </li>"))));
    }
}
