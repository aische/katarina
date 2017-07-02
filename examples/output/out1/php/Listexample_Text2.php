<?php

class Listexample_Text2 extends F_Listexample {
    public function __construct () {
    }
    
    public function foldNil(){
        return array();
    }
    
    public function foldCons($head, $tail){
        return array_merge(array($head),$tail);
    }
    
    public function foldFoo($list1, $list2, $info){
        return ("[" . implode(", ", $list1) . "], [" . implode(", ", $list2) . "]" . " " . $info);
    }
}
