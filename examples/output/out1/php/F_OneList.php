<?php

class F_OneList {
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
        $this->path = $path;
        return call_user_func(array($this, 'foldFoo'), $list1);
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
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
}
