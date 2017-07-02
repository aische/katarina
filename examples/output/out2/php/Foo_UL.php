<?php

class Foo_UL extends F_Foo {
    public function __construct () {
    }
    
    public function foldProduct($pid, $name, $values){
        return ("Product<ul>" . ("<li>pid :: INT    = " . $pid . "</li>") . ("<li>name :: STRING = " . $name . "</li>") . ("<li>values :: MAP [aid => Value] = " . "<ul>" . implode("", $values) . "</ul>" . "</li>") . "</ul>");
    }
    
    public function foldAttribute($aid, $name, $type){
        return ("Attribute<ul>" . ("<li>aid :: INT    = " . $aid . "</li>") . ("<li>name :: STRING = " . $name . "</li>") . ("<li>type :: STRING = " . $type . "</li>") . "</ul>");
    }
    
    public function foldValue($aid, $value){
        return ("Value<ul>" . ("<li>aid :: INT    = " . $aid . "</li>") . ("<li>value :: STRING = " . $value . "</li>") . "</ul>");
    }
    
    public function foldANode($aid, $weight){
        return ("ANode<ul>" . ("<li>aid :: INT    = " . $aid . "</li>") . ("<li>weight :: FLOAT  = " . $weight . "</li>") . "</ul>");
    }
    
    public function foldRNode($name, $weight, $nodes){
        return ("RNode<ul>" . ("<li>name :: STRING = " . $name . "</li>") . ("<li>weight :: FLOAT  = " . $weight . "</li>") . ("<li>nodes :: LIST = " . "<ul>" . implode("", array_map(function($obj){return ("<li>? :: ANode | RNode = " . $obj . "</li>");}, $nodes)) . "</ul>" . "</li>") . "</ul>");
    }
    
    public function foldTestclass($tid, $name, $nodes, $weights){
        return ("Testclass<ul>" . ("<li>tid :: INT    = " . $tid . "</li>") . ("<li>name :: STRING = " . $name . "</li>") . ("<li>nodes :: LIST = " . "<ul>" . implode("", array_map(function($obj){return ("<li>? :: ANode | RNode = " . $obj . "</li>");}, $nodes)) . "</ul>" . "</li>") . ("<li>weights :: MAP [aid => ANode] = " . "<ul>" . implode("", $weights) . "</ul>" . "</li>") . "</ul>");
    }
    
    public function foldProject($id, $name, $attributes, $products, $testclasses, $bla){
        return ("Project<ul>" . ("<li>id :: INT    = " . $id . "</li>") . ("<li>name :: STRING = " . $name . "</li>") . ("<li>attributes :: MAP [aid => Attribute] = " . "<ul>" . implode("", $attributes) . "</ul>" . "</li>") . ("<li>products :: MAP [pid => Product] = " . "<ul>" . implode("", $products) . "</ul>" . "</li>") . ("<li>testclasses :: MAP [tid => Testclass] = " . "<ul>" . implode("", $testclasses) . "</ul>" . "</li>") . ("<li>bla :: LIST = " . "<ul>" . implode("", array_map(function($obj){return ("<li>? :: TUPLE = " . "<ul>" . implode("", array(("<li>[0] :: INT    = " . $obj[0] . "</li>"), ("<li>[1] :: STRING = " . $obj[1] . "</li>"), ("<li>[2] :: MAP [aid => Attribute] = " . "<ul>" . implode("", $obj[2]) . "</ul>" . "</li>"), ("<li>[3] :: Range = " . $obj[3] . "</li>"))) . "</ul>" . "</li>");}, $bla)) . "</ul>" . "</li>") . "</ul>");
    }
    
    public function foldSavedSearch($sid, $values){
        return ("SavedSearch<ul>" . ("<li>sid :: INT    = " . $sid . "</li>") . ("<li>values :: MAP [aid => Filter] = " . "<ul>" . implode("", $values) . "</ul>" . "</li>") . "</ul>");
    }
    
    public function foldFilter($aid, $predicate){
        return ("Filter<ul>" . ("<li>aid :: INT    = " . $aid . "</li>") . ("<li>predicate :: Range | Elems = " . $predicate . "</li>") . "</ul>");
    }
    
    public function foldRange($min, $max){
        return ("Range<ul>" . ("<li>min :: INT    = " . $min . "</li>") . ("<li>max :: INT    = " . $max . "</li>") . "</ul>");
    }
    
    public function foldElems($values){
        return ("Elems<ul>" . ("<li>values :: LIST = " . "<ul>" . implode("", array_map(function($obj){return ("<li>? :: STRING = " . $obj . "</li>");}, $values)) . "</ul>" . "</li>") . "</ul>");
    }
    
    public function foldFilterset($fsid, $name, $widgets){
        return ("Filterset<ul>" . ("<li>fsid :: INT    = " . $fsid . "</li>") . ("<li>name :: STRING = " . $name . "</li>") . ("<li>widgets :: MAP [aid => Widget] = " . "<ul>" . implode("", $widgets) . "</ul>" . "</li>") . "</ul>");
    }
    
    public function foldWidget($aid, $widget, $info){
        return ("Widget<ul>" . ("<li>aid :: INT    = " . $aid . "</li>") . ("<li>widget :: RangeSlider | Range = " . $widget . "</li>") . ("<li>info :: STRING = " . $info . "</li>") . "</ul>");
    }
    
    public function foldRangeSlider($min, $max, $value1, $value2){
        return ("RangeSlider<ul>" . ("<li>min :: INT    = " . $min . "</li>") . ("<li>max :: INT    = " . $max . "</li>") . ("<li>value1 :: INT    = " . $value1 . "</li>") . ("<li>value2 :: INT    = " . $value2 . "</li>") . "</ul>");
    }
}
