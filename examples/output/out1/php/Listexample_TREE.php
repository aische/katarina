<?php

class Listexample_TREE extends F_Listexample {
    public function __construct () {
    }
    
    public function foldNil(){
        return array('constr' => "Nil");
    }
    
    public function foldCons($head, $tail){
        return array('constr' => "Cons", 'head' => $head, 'tail' => $tail);
    }
    
    public function foldFoo($list1, $list2, $info){
        return array('constr' => "Foo", 'list1' => $list1, 'list2' => $list2, 'info' => $info);
    }
}
