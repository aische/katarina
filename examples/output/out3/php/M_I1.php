<?php

class M_I1 extends F_M {
    public function __construct () {
    }
    
    public function foldAdd($x, $y){
        return ($x + $y);
    }
    
    public function foldMul($x, $y){
        return ($x * $y);
    }
    
    public function foldSub($x, $y){
        return ($x - $y);
    }
    
    public function foldDiv($x, $y){
        return ($x / $y);
    }
    
    public function foldNum($v){
        return $v;
    }
    
    public function foldTree($m){
        return $m;
    }
}
