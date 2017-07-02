<?php

class Listexample_Text extends F_Listexample {
    public function __construct () {
    }
    
    public function foldNil(){
        return "[]";
    }
    
    public function foldCons($head, $tail){
        return ($head . " : " . $tail);
    }
    
    public function foldFoo($list1, $list2, $info){
        return ($list1 . ", " . $list2);
    }
}
