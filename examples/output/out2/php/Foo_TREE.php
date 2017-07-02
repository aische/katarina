<?php

class Foo_TREE extends F_Foo {
    public function __construct () {
    }
    
    public function foldProduct($pid, $name, $values){
        return array('constr' => "Product", 'pid' => $pid, 'name' => $name, 'values' => $values);
    }
    
    public function foldAttribute($aid, $name, $type){
        return array('constr' => "Attribute", 'aid' => $aid, 'name' => $name, 'type' => $type);
    }
    
    public function foldValue($aid, $value){
        return array('constr' => "Value", 'aid' => $aid, 'value' => $value);
    }
    
    public function foldANode($aid, $weight){
        return array('constr' => "ANode", 'aid' => $aid, 'weight' => $weight);
    }
    
    public function foldRNode($name, $weight, $nodes){
        return array('constr' => "RNode", 'name' => $name, 'weight' => $weight, 'nodes' => $nodes);
    }
    
    public function foldTestclass($tid, $name, $nodes, $weights){
        return array('constr' => "Testclass", 'tid' => $tid, 'name' => $name, 'nodes' => $nodes, 'weights' => $weights);
    }
    
    public function foldProject($id, $name, $attributes, $products, $testclasses, $bla){
        return array('constr' => "Project", 'id' => $id, 'name' => $name, 'attributes' => $attributes, 'products' => $products, 'testclasses' => $testclasses, 'bla' => $bla);
    }
    
    public function foldSavedSearch($sid, $values){
        return array('constr' => "SavedSearch", 'sid' => $sid, 'values' => $values);
    }
    
    public function foldFilter($aid, $predicate){
        return array('constr' => "Filter", 'aid' => $aid, 'predicate' => $predicate);
    }
    
    public function foldRange($min, $max){
        return array('constr' => "Range", 'min' => $min, 'max' => $max);
    }
    
    public function foldElems($values){
        return array('constr' => "Elems", 'values' => $values);
    }
    
    public function foldFilterset($fsid, $name, $widgets){
        return array('constr' => "Filterset", 'fsid' => $fsid, 'name' => $name, 'widgets' => $widgets);
    }
    
    public function foldWidget($aid, $widget, $info){
        return array('constr' => "Widget", 'aid' => $aid, 'widget' => $widget, 'info' => $info);
    }
    
    public function foldRangeSlider($min, $max, $value1, $value2){
        return array('constr' => "RangeSlider", 'min' => $min, 'max' => $max, 'value1' => $value1, 'value2' => $value2);
    }
}
