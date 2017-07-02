<?php

class A1_I1 extends F_A1 {
    public function __construct () {
    }
    
    public function foldProduct($pid, $name, $values){
        return ("\n        <li>\n            <span style=\"color:black;\">Product " . $name . ("[pid=" . $pid . ("]:</span>\n            <ul>" . implode("", $values) . ("</ul>\n        </li>"))));
    }
    
    public function foldAttribute($aid, $name, $type){
        return ("<li><span style=\"color:black;\">Attr " . $name . ("[aid=" . $aid . ("]::" . $type . ("</span></li>"))));
    }
    
    public function foldValue($aid, $value){
        return ("<li><span style=\"color:black;\">Value[aid=" . $aid . ("] = " . $value . ("</span></li>")));
    }
    
    public function foldProject($id, $name, $attributes, $products, $bla){
        return ($id . ": <span style=\"color:black;\">" . $name . "</span><ul>" . implode("", $attributes) . "</ul>" . "<ul>" . implode("", $products) . "</ul>" . implode("", $bla[0][2]));
    }
    
    public function foldRange($min, $max){
        return "";
    }
}
