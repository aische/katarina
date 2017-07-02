<?php

class Listexample_UL extends F_Listexample {
    public function __construct () {
    }
    
    public function foldNil(){
        return ("Nil<ul>" . "</ul>");
    }
    
    public function foldCons($head, $tail){
        return ("Cons<ul>" . ("<li>head :: INT    = " . $head . "</li>") . ("<li>tail :: Nil | Cons = " . $tail . "</li>") . "</ul>");
    }
    
    public function foldFoo($list1, $list2, $info){
        return ("Foo<ul>" . ("<li>list1 :: Nil | Cons = " . $list1 . "</li>") . ("<li>list2 :: Nil | Cons = " . $list2 . "</li>") . ("<li>info :: STRING = " . $info . "</li>") . "</ul>");
    }
}
