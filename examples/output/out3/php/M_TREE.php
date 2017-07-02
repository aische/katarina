<?php

class M_TREE extends F_M {
    public function __construct () {
    }
    
    public function foldAdd($x, $y){
        return array('constr' => "Add", 'x' => $x, 'y' => $y);
    }
    
    public function foldMul($x, $y){
        return array('constr' => "Mul", 'x' => $x, 'y' => $y);
    }
    
    public function foldDiv($x, $y){
        return array('constr' => "Div", 'x' => $x, 'y' => $y);
    }
    
    public function foldSub($x, $y){
        return array('constr' => "Sub", 'x' => $x, 'y' => $y);
    }
    
    public function foldNum($v){
        return array('constr' => "Num", 'v' => $v);
    }
    
    public function foldTree($m){
        return array('constr' => "Tree", 'm' => $m);
    }
}
