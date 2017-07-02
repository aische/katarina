<?php

class M_I2 extends F_M {
    public function __construct () {
    }
    
    public function foldAdd($x, $y){
        return ("<span style=\"color:blue;\">(" . $x . " + " . $y . ")</span>");
    }
    
    public function foldMul($x, $y){
        return ("<span style=\"color:green;\">(" . $x . " * " . $y . ")</span>");
    }
    
    public function foldSub($x, $y){
        return ("<span style=\"color:red;\">(" . $x . " - " . $y . ")</span>");
    }
    
    public function foldDiv($x, $y){
        return ("<span style=\"color:magenta;\">(" . $x . " / " . $y . ")</span>");
    }
    
    public function foldNum($v){
        return ("<span style=\"color:gray;\">" . $v . "</span>");
    }
    
    public function foldTree($m){
        return $m;
    }
}
