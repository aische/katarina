<?php

class Nil {
    public function __construct () {
    }
    
    public static function fromArgs(){
        $obj = new Nil();
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Nil";
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Nil"))) {
            $obj = new Nil();
            return $obj;
        }
        else {
            return new JSONERROR(("Nil " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Nil();
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Nil();
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapNil'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Nil'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldNil'), $input);
        return $obj;
    }
}

class Cons {
    public function __construct () {
    }
    
    public static function fromArgs($head, $tail){
        $obj = new Cons();
        $obj->head = (int)$head;
        $obj->tail = $tail;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Cons";
        $json['head'] = $this->head;
        $json['tail'] = call_user_func(array($this->tail, 'toJSON'));
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Cons"))) {
            $obj = new Cons();
            if (isset($json['head'])) {
                $obj->head = call_user_func('pInt', $json['head']);
                if (call_user_func('isJSONERROR', $obj->head)) {
                    return new JSONERROR("Cons.head", $obj->head);
                }
            }
            else {
                return new JSONERROR("Cons fromJSON: missing key: head");
            }
            if (isset($json['tail'])) {
                $obj->tail = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Nil"))?(call_user_func(array('Nil', 'fromJSON'), $json)):((($json['constr'] == "Cons"))?(call_user_func(array('Cons', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr']))))):(new JSONERROR("Wrong Object"));}, $json['tail']);
                if (call_user_func('isJSONERROR', $obj->tail)) {
                    return new JSONERROR("Cons.tail", $obj->tail);
                }
            }
            else {
                return new JSONERROR("Cons fromJSON: missing key: tail");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Cons " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Cons();
        $obj->head = call_user_func('pUnsafe', $json['head']);
        $obj->tail = call_user_func(function($json){return (($json['constr'] == "Nil"))?(call_user_func(array('Nil', 'unsafeFromJSON'), $json)):(call_user_func(array('Cons', 'unsafeFromJSON'), $json));}, $json['tail']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Cons();
            if (isset($json['head'])) {
                $obj->head = (int)$json['head'];
            }
            else {
                $obj->head = 0;
            }
            if (isset($json['tail'])) {
                $obj->tail = $json['tail'];
            }
            else {
                $obj->tail = NULL;
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapCons'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Cons'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldCons'), $input);
        $obj->tail = call_user_func(array('Nil', 'unfold'), $coalg, $input);
        if ($obj->tail) {
        }
        else {
            $obj->tail = call_user_func(array('Cons', 'unfold'), $coalg, $input);
        }
        return $obj;
    }
}

class Foo {
    public function __construct () {
    }
    
    public static function fromArgs($list1, $list2, $info){
        $obj = new Foo();
        $obj->list1 = $list1;
        $obj->list2 = $list2;
        $obj->info = (string)$info;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Foo";
        $json['list1'] = call_user_func(array($this->list1, 'toJSON'));
        $json['list2'] = call_user_func(array($this->list2, 'toJSON'));
        $json['info'] = $this->info;
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Foo"))) {
            $obj = new Foo();
            if (isset($json['list1'])) {
                $obj->list1 = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Nil"))?(call_user_func(array('Nil', 'fromJSON'), $json)):((($json['constr'] == "Cons"))?(call_user_func(array('Cons', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr']))))):(new JSONERROR("Wrong Object"));}, $json['list1']);
                if (call_user_func('isJSONERROR', $obj->list1)) {
                    return new JSONERROR("Foo.list1", $obj->list1);
                }
            }
            else {
                return new JSONERROR("Foo fromJSON: missing key: list1");
            }
            if (isset($json['list2'])) {
                $obj->list2 = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Nil"))?(call_user_func(array('Nil', 'fromJSON'), $json)):((($json['constr'] == "Cons"))?(call_user_func(array('Cons', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr']))))):(new JSONERROR("Wrong Object"));}, $json['list2']);
                if (call_user_func('isJSONERROR', $obj->list2)) {
                    return new JSONERROR("Foo.list2", $obj->list2);
                }
            }
            else {
                return new JSONERROR("Foo fromJSON: missing key: list2");
            }
            if (isset($json['info'])) {
                $obj->info = call_user_func('pString', $json['info']);
                if (call_user_func('isJSONERROR', $obj->info)) {
                    return new JSONERROR("Foo.info", $obj->info);
                }
            }
            else {
                return new JSONERROR("Foo fromJSON: missing key: info");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Foo " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Foo();
        $obj->list1 = call_user_func(function($json){return (($json['constr'] == "Nil"))?(call_user_func(array('Nil', 'unsafeFromJSON'), $json)):(call_user_func(array('Cons', 'unsafeFromJSON'), $json));}, $json['list1']);
        $obj->list2 = call_user_func(function($json){return (($json['constr'] == "Nil"))?(call_user_func(array('Nil', 'unsafeFromJSON'), $json)):(call_user_func(array('Cons', 'unsafeFromJSON'), $json));}, $json['list2']);
        $obj->info = call_user_func('pUnsafe', $json['info']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Foo();
            if (isset($json['list1'])) {
                $obj->list1 = $json['list1'];
            }
            else {
                $obj->list1 = NULL;
            }
            if (isset($json['list2'])) {
                $obj->list2 = $json['list2'];
            }
            else {
                $obj->list2 = NULL;
            }
            if (isset($json['info'])) {
                $obj->info = (string)$json['info'];
            }
            else {
                $obj->info = "";
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapFoo'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Foo'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldFoo'), $input);
        $obj->list1 = call_user_func(array('Nil', 'unfold'), $coalg, $input);
        if ($obj->list1) {
        }
        else {
            $obj->list1 = call_user_func(array('Cons', 'unfold'), $coalg, $input);
        }
        $obj->list2 = call_user_func(array('Nil', 'unfold'), $coalg, $input);
        if ($obj->list2) {
        }
        else {
            $obj->list2 = call_user_func(array('Cons', 'unfold'), $coalg, $input);
        }
        return $obj;
    }
}

class F_Listexample {
    public function __construct () {
        $this->keyorder = array();
    }
    
    public function fmapNil($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldNil'));
    }
    
    public function fmapCons($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $head = $obj->head;
        $tail = call_user_func(array($obj->tail, 'fold'), $inj, $path2);
        $this->path = $path;
        return call_user_func(array($this, 'foldCons'), $head, $tail);
    }
    
    public function fmapFoo($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $list1 = call_user_func(array($obj->list1, 'fold'), $inj, $path2);
        $list2 = call_user_func(array($obj->list2, 'fold'), $inj, $path2);
        $info = $obj->info;
        $this->path = $path;
        return call_user_func(array($this, 'foldFoo'), $list1, $list2, $info);
    }
    
    public function fmap2Nil($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Cons($obj, $arg){
        $inj = $this;
        call_user_func(array($obj->tail, 'fold2'), $inj, $arg);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Foo($obj, $arg){
        $inj = $this;
        call_user_func(array($obj->list1, 'fold2'), $inj, $arg);
        call_user_func(array($obj->list2, 'fold2'), $inj, $arg);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
}
