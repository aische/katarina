<?php

class M_UL extends F_M {
    public function __construct () {
    }
    
    public function foldAdd($x, $y){
        return ("Add<ul>" . ("<li>x :: Add | Mul | Sub | Div | Num = " . $x . "</li>") . ("<li>y :: Add | Mul | Sub | Div | Num = " . $y . "</li>") . "</ul>");
    }
    
    public function foldMul($x, $y){
        return ("Mul<ul>" . ("<li>x :: Add | Mul | Sub | Div | Num = " . $x . "</li>") . ("<li>y :: Add | Mul | Sub | Div | Num = " . $y . "</li>") . "</ul>");
    }
    
    public function foldDiv($x, $y){
        return ("Div<ul>" . ("<li>x :: Add | Mul | Sub | Div | Num = " . $x . "</li>") . ("<li>y :: Add | Mul | Sub | Div | Num = " . $y . "</li>") . "</ul>");
    }
    
    public function foldSub($x, $y){
        return ("Sub<ul>" . ("<li>x :: Add | Mul | Sub | Div | Num = " . $x . "</li>") . ("<li>y :: Add | Mul | Sub | Div | Num = " . $y . "</li>") . "</ul>");
    }
    
    public function foldNum($v){
        return ("Num<ul>" . ("<li>v :: INT    = " . $v . "</li>") . "</ul>");
    }
    
    public function foldTree($m){
        return ("Tree<ul>" . ("<li>m :: Add | Mul | Sub | Div | Num = " . $m . "</li>") . "</ul>");
    }
}
