<?php

class OneList_Summe2 extends F_OneList {
    public function __construct () {
    }
    
    public function foldNil(){
        return 0;
    }
    
    public function foldCons($head, $tail){
        return ($head + $tail);
    }
    
    public function foldFoo($list1){
        return $list1;
    }
}
