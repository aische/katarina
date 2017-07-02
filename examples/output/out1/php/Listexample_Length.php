<?php

class Listexample_Length extends F_Listexample {
    public function __construct () {
    }
    
    public function foldNil(){
        return 0;
    }
    
    public function foldCons($head, $tail){
        return (1 + $tail);
    }
    
    public function foldFoo($list1, $list2, $info){
        return ($list1 + $list2);
    }
}
