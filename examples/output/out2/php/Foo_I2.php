<?php

class Foo_I2 extends F_Foo {
    public function __construct () {
    }
    
    public function foldProduct($pid, $name, $values){
        return ("<li><span style=\"color:green;\">" . $pid . ": " . $name . "</span><ul>" . implode("", $values) . "</ul>" . "</li>");
    }
    
    public function foldAttribute($aid, $name, $type){
        return ("<li>" . "<span style=\"color:blue;\">" . $aid . ": " . $name . "(" . $type . ")" . "</span></li>");
    }
    
    public function foldValue($aid, $value){
        return ("<li>" . "<span style=\"color:red;\">" . $aid . ": " . $value . "</span></li>");
    }
    
    public function foldProject($id, $name, $attributes, $products, $testclasses, $bla){
        return ("<li>" . "<span style=\"color:#ff00ff;\">" . $id . $name . "</span><ul>" . implode("", $attributes) . "</ul>" . "<ul>" . implode("", $products) . "</ul>" . "<ul>" . implode("", $testclasses) . "</ul>" . "</li>");
    }
    
    public function foldANode($aid, $weight){
        return ("<li>" . "<span style=\"color:#00ffff;\">" . $aid . ": " . $weight . "</span></li>");
    }
    
    public function foldRNode($name, $weight, $nodes){
        return ("<li>" . "<span style=\"color:#00aa77;\">" . $name . ": " . $weight . "</span><ul>" . implode("", $nodes) . "</ul>" . "</li>");
    }
    
    public function foldSavedSearch($sid, $values){
        return ("<li>" . "<span style=\"color:#aa0077;\">" . $sid . "</span><ul>" . implode("", $values) . "</ul>" . "</li>");
    }
    
    public function foldFilter($aid, $predicate){
        return ("<li>" . "<span style=\"color:#aaff00;\">" . $aid . "</span>" . $predicate . "</li>");
    }
    
    public function foldRange($min, $max){
        return ("[" . $min . "-" . $max . "]");
    }
    
    public function foldElems($values){
        return "";
    }
    
    public function foldTestclass($tid, $name, $nodes, $weights){
        return ("<li>" . "<span style=\"color:#ffff00;\">" . $tid . ": " . $name . "</span><ul>" . implode("", $nodes) . "</ul>" . "weights:" . "<ul>" . implode("", $weights) . "</ul>" . "</li>");
    }
    
    public function foldFilterset($fsid, $name, $widgets){
        return ("<li>" . "<span style=\"color:#22aaff;\">" . $fsid . ": " . $name . "</span><ul>" . implode("", $widgets) . "</ul>" . "</li>");
    }
    
    public function foldRangeSlider($min, $max, $value1, $value2){
    }
    
    public function foldWidget($aid, $widget, $info){
    }
}
