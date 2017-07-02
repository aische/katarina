<?php

class Add {
    public function __construct () {
    }
    
    public static function fromArgs($x, $y){
        $obj = new Add();
        $obj->x = $x;
        $obj->y = $y;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Add";
        $json['x'] = call_user_func(array($this->x, 'toJSON'));
        $json['y'] = call_user_func(array($this->y, 'toJSON'));
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Add"))) {
            $obj = new Add();
            if (isset($json['x'])) {
                $obj->x = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Add"))?(call_user_func(array('Add', 'fromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'fromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'fromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'fromJSON'), $json)):((($json['constr'] == "Num"))?(call_user_func(array('Num', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr'])))))))):(new JSONERROR("Wrong Object"));}, $json['x']);
                if (call_user_func('isJSONERROR', $obj->x)) {
                    return new JSONERROR("Add.x", $obj->x);
                }
            }
            else {
                return new JSONERROR("Add fromJSON: missing key: x");
            }
            if (isset($json['y'])) {
                $obj->y = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Add"))?(call_user_func(array('Add', 'fromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'fromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'fromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'fromJSON'), $json)):((($json['constr'] == "Num"))?(call_user_func(array('Num', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr'])))))))):(new JSONERROR("Wrong Object"));}, $json['y']);
                if (call_user_func('isJSONERROR', $obj->y)) {
                    return new JSONERROR("Add.y", $obj->y);
                }
            }
            else {
                return new JSONERROR("Add fromJSON: missing key: y");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Add " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Add();
        $obj->x = call_user_func(function($json){return (($json['constr'] == "Add"))?(call_user_func(array('Add', 'unsafeFromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'unsafeFromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'unsafeFromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'unsafeFromJSON'), $json)):(call_user_func(array('Num', 'unsafeFromJSON'), $json)))));}, $json['x']);
        $obj->y = call_user_func(function($json){return (($json['constr'] == "Add"))?(call_user_func(array('Add', 'unsafeFromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'unsafeFromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'unsafeFromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'unsafeFromJSON'), $json)):(call_user_func(array('Num', 'unsafeFromJSON'), $json)))));}, $json['y']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Add();
            if (isset($json['x'])) {
                $obj->x = $json['x'];
            }
            else {
                $obj->x = NULL;
            }
            if (isset($json['y'])) {
                $obj->y = $json['y'];
            }
            else {
                $obj->y = NULL;
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapAdd'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Add'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldAdd'), $input);
        $obj->x = call_user_func(array('Add', 'unfold'), $coalg, $input);
        if ($obj->x) {
        }
        else {
            $obj->x = call_user_func(array('Mul', 'unfold'), $coalg, $input);
            if ($obj->x) {
            }
            else {
                $obj->x = call_user_func(array('Sub', 'unfold'), $coalg, $input);
                if ($obj->x) {
                }
                else {
                    $obj->x = call_user_func(array('Div', 'unfold'), $coalg, $input);
                    if ($obj->x) {
                    }
                    else {
                        $obj->x = call_user_func(array('Num', 'unfold'), $coalg, $input);
                    }
                }
            }
        }
        $obj->y = call_user_func(array('Add', 'unfold'), $coalg, $input);
        if ($obj->y) {
        }
        else {
            $obj->y = call_user_func(array('Mul', 'unfold'), $coalg, $input);
            if ($obj->y) {
            }
            else {
                $obj->y = call_user_func(array('Sub', 'unfold'), $coalg, $input);
                if ($obj->y) {
                }
                else {
                    $obj->y = call_user_func(array('Div', 'unfold'), $coalg, $input);
                    if ($obj->y) {
                    }
                    else {
                        $obj->y = call_user_func(array('Num', 'unfold'), $coalg, $input);
                    }
                }
            }
        }
        return $obj;
    }
}

class Mul {
    public function __construct () {
    }
    
    public static function fromArgs($x, $y){
        $obj = new Mul();
        $obj->x = $x;
        $obj->y = $y;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Mul";
        $json['x'] = call_user_func(array($this->x, 'toJSON'));
        $json['y'] = call_user_func(array($this->y, 'toJSON'));
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Mul"))) {
            $obj = new Mul();
            if (isset($json['x'])) {
                $obj->x = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Add"))?(call_user_func(array('Add', 'fromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'fromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'fromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'fromJSON'), $json)):((($json['constr'] == "Num"))?(call_user_func(array('Num', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr'])))))))):(new JSONERROR("Wrong Object"));}, $json['x']);
                if (call_user_func('isJSONERROR', $obj->x)) {
                    return new JSONERROR("Mul.x", $obj->x);
                }
            }
            else {
                return new JSONERROR("Mul fromJSON: missing key: x");
            }
            if (isset($json['y'])) {
                $obj->y = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Add"))?(call_user_func(array('Add', 'fromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'fromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'fromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'fromJSON'), $json)):((($json['constr'] == "Num"))?(call_user_func(array('Num', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr'])))))))):(new JSONERROR("Wrong Object"));}, $json['y']);
                if (call_user_func('isJSONERROR', $obj->y)) {
                    return new JSONERROR("Mul.y", $obj->y);
                }
            }
            else {
                return new JSONERROR("Mul fromJSON: missing key: y");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Mul " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Mul();
        $obj->x = call_user_func(function($json){return (($json['constr'] == "Add"))?(call_user_func(array('Add', 'unsafeFromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'unsafeFromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'unsafeFromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'unsafeFromJSON'), $json)):(call_user_func(array('Num', 'unsafeFromJSON'), $json)))));}, $json['x']);
        $obj->y = call_user_func(function($json){return (($json['constr'] == "Add"))?(call_user_func(array('Add', 'unsafeFromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'unsafeFromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'unsafeFromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'unsafeFromJSON'), $json)):(call_user_func(array('Num', 'unsafeFromJSON'), $json)))));}, $json['y']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Mul();
            if (isset($json['x'])) {
                $obj->x = $json['x'];
            }
            else {
                $obj->x = NULL;
            }
            if (isset($json['y'])) {
                $obj->y = $json['y'];
            }
            else {
                $obj->y = NULL;
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapMul'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Mul'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldMul'), $input);
        $obj->x = call_user_func(array('Add', 'unfold'), $coalg, $input);
        if ($obj->x) {
        }
        else {
            $obj->x = call_user_func(array('Mul', 'unfold'), $coalg, $input);
            if ($obj->x) {
            }
            else {
                $obj->x = call_user_func(array('Sub', 'unfold'), $coalg, $input);
                if ($obj->x) {
                }
                else {
                    $obj->x = call_user_func(array('Div', 'unfold'), $coalg, $input);
                    if ($obj->x) {
                    }
                    else {
                        $obj->x = call_user_func(array('Num', 'unfold'), $coalg, $input);
                    }
                }
            }
        }
        $obj->y = call_user_func(array('Add', 'unfold'), $coalg, $input);
        if ($obj->y) {
        }
        else {
            $obj->y = call_user_func(array('Mul', 'unfold'), $coalg, $input);
            if ($obj->y) {
            }
            else {
                $obj->y = call_user_func(array('Sub', 'unfold'), $coalg, $input);
                if ($obj->y) {
                }
                else {
                    $obj->y = call_user_func(array('Div', 'unfold'), $coalg, $input);
                    if ($obj->y) {
                    }
                    else {
                        $obj->y = call_user_func(array('Num', 'unfold'), $coalg, $input);
                    }
                }
            }
        }
        return $obj;
    }
}

class Div {
    public function __construct () {
    }
    
    public static function fromArgs($x, $y){
        $obj = new Div();
        $obj->x = $x;
        $obj->y = $y;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Div";
        $json['x'] = call_user_func(array($this->x, 'toJSON'));
        $json['y'] = call_user_func(array($this->y, 'toJSON'));
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Div"))) {
            $obj = new Div();
            if (isset($json['x'])) {
                $obj->x = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Add"))?(call_user_func(array('Add', 'fromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'fromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'fromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'fromJSON'), $json)):((($json['constr'] == "Num"))?(call_user_func(array('Num', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr'])))))))):(new JSONERROR("Wrong Object"));}, $json['x']);
                if (call_user_func('isJSONERROR', $obj->x)) {
                    return new JSONERROR("Div.x", $obj->x);
                }
            }
            else {
                return new JSONERROR("Div fromJSON: missing key: x");
            }
            if (isset($json['y'])) {
                $obj->y = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Add"))?(call_user_func(array('Add', 'fromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'fromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'fromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'fromJSON'), $json)):((($json['constr'] == "Num"))?(call_user_func(array('Num', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr'])))))))):(new JSONERROR("Wrong Object"));}, $json['y']);
                if (call_user_func('isJSONERROR', $obj->y)) {
                    return new JSONERROR("Div.y", $obj->y);
                }
            }
            else {
                return new JSONERROR("Div fromJSON: missing key: y");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Div " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Div();
        $obj->x = call_user_func(function($json){return (($json['constr'] == "Add"))?(call_user_func(array('Add', 'unsafeFromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'unsafeFromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'unsafeFromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'unsafeFromJSON'), $json)):(call_user_func(array('Num', 'unsafeFromJSON'), $json)))));}, $json['x']);
        $obj->y = call_user_func(function($json){return (($json['constr'] == "Add"))?(call_user_func(array('Add', 'unsafeFromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'unsafeFromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'unsafeFromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'unsafeFromJSON'), $json)):(call_user_func(array('Num', 'unsafeFromJSON'), $json)))));}, $json['y']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Div();
            if (isset($json['x'])) {
                $obj->x = $json['x'];
            }
            else {
                $obj->x = NULL;
            }
            if (isset($json['y'])) {
                $obj->y = $json['y'];
            }
            else {
                $obj->y = NULL;
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapDiv'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Div'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldDiv'), $input);
        $obj->x = call_user_func(array('Add', 'unfold'), $coalg, $input);
        if ($obj->x) {
        }
        else {
            $obj->x = call_user_func(array('Mul', 'unfold'), $coalg, $input);
            if ($obj->x) {
            }
            else {
                $obj->x = call_user_func(array('Sub', 'unfold'), $coalg, $input);
                if ($obj->x) {
                }
                else {
                    $obj->x = call_user_func(array('Div', 'unfold'), $coalg, $input);
                    if ($obj->x) {
                    }
                    else {
                        $obj->x = call_user_func(array('Num', 'unfold'), $coalg, $input);
                    }
                }
            }
        }
        $obj->y = call_user_func(array('Add', 'unfold'), $coalg, $input);
        if ($obj->y) {
        }
        else {
            $obj->y = call_user_func(array('Mul', 'unfold'), $coalg, $input);
            if ($obj->y) {
            }
            else {
                $obj->y = call_user_func(array('Sub', 'unfold'), $coalg, $input);
                if ($obj->y) {
                }
                else {
                    $obj->y = call_user_func(array('Div', 'unfold'), $coalg, $input);
                    if ($obj->y) {
                    }
                    else {
                        $obj->y = call_user_func(array('Num', 'unfold'), $coalg, $input);
                    }
                }
            }
        }
        return $obj;
    }
}

class Sub {
    public function __construct () {
    }
    
    public static function fromArgs($x, $y){
        $obj = new Sub();
        $obj->x = $x;
        $obj->y = $y;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Sub";
        $json['x'] = call_user_func(array($this->x, 'toJSON'));
        $json['y'] = call_user_func(array($this->y, 'toJSON'));
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Sub"))) {
            $obj = new Sub();
            if (isset($json['x'])) {
                $obj->x = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Add"))?(call_user_func(array('Add', 'fromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'fromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'fromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'fromJSON'), $json)):((($json['constr'] == "Num"))?(call_user_func(array('Num', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr'])))))))):(new JSONERROR("Wrong Object"));}, $json['x']);
                if (call_user_func('isJSONERROR', $obj->x)) {
                    return new JSONERROR("Sub.x", $obj->x);
                }
            }
            else {
                return new JSONERROR("Sub fromJSON: missing key: x");
            }
            if (isset($json['y'])) {
                $obj->y = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Add"))?(call_user_func(array('Add', 'fromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'fromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'fromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'fromJSON'), $json)):((($json['constr'] == "Num"))?(call_user_func(array('Num', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr'])))))))):(new JSONERROR("Wrong Object"));}, $json['y']);
                if (call_user_func('isJSONERROR', $obj->y)) {
                    return new JSONERROR("Sub.y", $obj->y);
                }
            }
            else {
                return new JSONERROR("Sub fromJSON: missing key: y");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Sub " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Sub();
        $obj->x = call_user_func(function($json){return (($json['constr'] == "Add"))?(call_user_func(array('Add', 'unsafeFromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'unsafeFromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'unsafeFromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'unsafeFromJSON'), $json)):(call_user_func(array('Num', 'unsafeFromJSON'), $json)))));}, $json['x']);
        $obj->y = call_user_func(function($json){return (($json['constr'] == "Add"))?(call_user_func(array('Add', 'unsafeFromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'unsafeFromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'unsafeFromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'unsafeFromJSON'), $json)):(call_user_func(array('Num', 'unsafeFromJSON'), $json)))));}, $json['y']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Sub();
            if (isset($json['x'])) {
                $obj->x = $json['x'];
            }
            else {
                $obj->x = NULL;
            }
            if (isset($json['y'])) {
                $obj->y = $json['y'];
            }
            else {
                $obj->y = NULL;
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapSub'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Sub'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldSub'), $input);
        $obj->x = call_user_func(array('Add', 'unfold'), $coalg, $input);
        if ($obj->x) {
        }
        else {
            $obj->x = call_user_func(array('Mul', 'unfold'), $coalg, $input);
            if ($obj->x) {
            }
            else {
                $obj->x = call_user_func(array('Sub', 'unfold'), $coalg, $input);
                if ($obj->x) {
                }
                else {
                    $obj->x = call_user_func(array('Div', 'unfold'), $coalg, $input);
                    if ($obj->x) {
                    }
                    else {
                        $obj->x = call_user_func(array('Num', 'unfold'), $coalg, $input);
                    }
                }
            }
        }
        $obj->y = call_user_func(array('Add', 'unfold'), $coalg, $input);
        if ($obj->y) {
        }
        else {
            $obj->y = call_user_func(array('Mul', 'unfold'), $coalg, $input);
            if ($obj->y) {
            }
            else {
                $obj->y = call_user_func(array('Sub', 'unfold'), $coalg, $input);
                if ($obj->y) {
                }
                else {
                    $obj->y = call_user_func(array('Div', 'unfold'), $coalg, $input);
                    if ($obj->y) {
                    }
                    else {
                        $obj->y = call_user_func(array('Num', 'unfold'), $coalg, $input);
                    }
                }
            }
        }
        return $obj;
    }
}

class Num {
    public function __construct () {
    }
    
    public static function fromArgs($v){
        $obj = new Num();
        $obj->v = (int)$v;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Num";
        $json['v'] = $this->v;
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Num"))) {
            $obj = new Num();
            if (isset($json['v'])) {
                $obj->v = call_user_func('pInt', $json['v']);
                if (call_user_func('isJSONERROR', $obj->v)) {
                    return new JSONERROR("Num.v", $obj->v);
                }
            }
            else {
                return new JSONERROR("Num fromJSON: missing key: v");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Num " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Num();
        $obj->v = call_user_func('pUnsafe', $json['v']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Num();
            if (isset($json['v'])) {
                $obj->v = (int)$json['v'];
            }
            else {
                $obj->v = 0;
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapNum'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Num'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldNum'), $input);
        return $obj;
    }
}

class Tree {
    public function __construct () {
    }
    
    public static function fromArgs($m){
        $obj = new Tree();
        $obj->m = $m;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Tree";
        $json['m'] = call_user_func(array($this->m, 'toJSON'));
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Tree"))) {
            $obj = new Tree();
            if (isset($json['m'])) {
                $obj->m = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Add"))?(call_user_func(array('Add', 'fromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'fromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'fromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'fromJSON'), $json)):((($json['constr'] == "Num"))?(call_user_func(array('Num', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr'])))))))):(new JSONERROR("Wrong Object"));}, $json['m']);
                if (call_user_func('isJSONERROR', $obj->m)) {
                    return new JSONERROR("Tree.m", $obj->m);
                }
            }
            else {
                return new JSONERROR("Tree fromJSON: missing key: m");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Tree " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Tree();
        $obj->m = call_user_func(function($json){return (($json['constr'] == "Add"))?(call_user_func(array('Add', 'unsafeFromJSON'), $json)):((($json['constr'] == "Mul"))?(call_user_func(array('Mul', 'unsafeFromJSON'), $json)):((($json['constr'] == "Sub"))?(call_user_func(array('Sub', 'unsafeFromJSON'), $json)):((($json['constr'] == "Div"))?(call_user_func(array('Div', 'unsafeFromJSON'), $json)):(call_user_func(array('Num', 'unsafeFromJSON'), $json)))));}, $json['m']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Tree();
            if (isset($json['m'])) {
                $obj->m = $json['m'];
            }
            else {
                $obj->m = NULL;
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapTree'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Tree'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldTree'), $input);
        $obj->m = call_user_func(array('Add', 'unfold'), $coalg, $input);
        if ($obj->m) {
        }
        else {
            $obj->m = call_user_func(array('Mul', 'unfold'), $coalg, $input);
            if ($obj->m) {
            }
            else {
                $obj->m = call_user_func(array('Sub', 'unfold'), $coalg, $input);
                if ($obj->m) {
                }
                else {
                    $obj->m = call_user_func(array('Div', 'unfold'), $coalg, $input);
                    if ($obj->m) {
                    }
                    else {
                        $obj->m = call_user_func(array('Num', 'unfold'), $coalg, $input);
                    }
                }
            }
        }
        return $obj;
    }
}

class F_M {
    public function __construct () {
        $this->keyorder = array();
    }
    
    public function fmapAdd($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $x = call_user_func(array($obj->x, 'fold'), $inj, $path2);
        $y = call_user_func(array($obj->y, 'fold'), $inj, $path2);
        $this->path = $path;
        return call_user_func(array($this, 'foldAdd'), $x, $y);
    }
    
    public function fmapMul($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $x = call_user_func(array($obj->x, 'fold'), $inj, $path2);
        $y = call_user_func(array($obj->y, 'fold'), $inj, $path2);
        $this->path = $path;
        return call_user_func(array($this, 'foldMul'), $x, $y);
    }
    
    public function fmapDiv($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $x = call_user_func(array($obj->x, 'fold'), $inj, $path2);
        $y = call_user_func(array($obj->y, 'fold'), $inj, $path2);
        $this->path = $path;
        return call_user_func(array($this, 'foldDiv'), $x, $y);
    }
    
    public function fmapSub($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $x = call_user_func(array($obj->x, 'fold'), $inj, $path2);
        $y = call_user_func(array($obj->y, 'fold'), $inj, $path2);
        $this->path = $path;
        return call_user_func(array($this, 'foldSub'), $x, $y);
    }
    
    public function fmapNum($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $v = $obj->v;
        $this->path = $path;
        return call_user_func(array($this, 'foldNum'), $v);
    }
    
    public function fmapTree($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $m = call_user_func(array($obj->m, 'fold'), $inj, $path2);
        $this->path = $path;
        return call_user_func(array($this, 'foldTree'), $m);
    }
    
    public function fmap2Add($obj, $arg){
        $inj = $this;
        call_user_func(array($obj->x, 'fold2'), $inj, $arg);
        call_user_func(array($obj->y, 'fold2'), $inj, $arg);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Mul($obj, $arg){
        $inj = $this;
        call_user_func(array($obj->x, 'fold2'), $inj, $arg);
        call_user_func(array($obj->y, 'fold2'), $inj, $arg);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Div($obj, $arg){
        $inj = $this;
        call_user_func(array($obj->x, 'fold2'), $inj, $arg);
        call_user_func(array($obj->y, 'fold2'), $inj, $arg);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Sub($obj, $arg){
        $inj = $this;
        call_user_func(array($obj->x, 'fold2'), $inj, $arg);
        call_user_func(array($obj->y, 'fold2'), $inj, $arg);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Num($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Tree($obj, $arg){
        $inj = $this;
        call_user_func(array($obj->m, 'fold2'), $inj, $arg);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
}
