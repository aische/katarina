<?php

class F_A3 {
    public function __construct () {
        $this->keyorder = array();
    }
    
    public function fmapProduct($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldProduct'));
    }
    
    public function fmapAttribute($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldAttribute'));
    }
    
    public function fmapValue($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldValue'));
    }
    
    public function fmapANode($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldANode'));
    }
    
    public function fmapRNode($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldRNode'));
    }
    
    public function fmapTestclass($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $tid = $obj->tid;
        $name = $obj->name;
        $this->path = $path;
        return call_user_func(array($this, 'foldTestclass'), $tid, $name);
    }
    
    public function fmapProject($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $testclasses = call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->testclasses);
        $this->path = $path;
        return call_user_func(array($this, 'foldProject'), $testclasses);
    }
    
    public function fmapSavedSearch($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldSavedSearch'));
    }
    
    public function fmapFilter($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldFilter'));
    }
    
    public function fmapRange($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldRange'));
    }
    
    public function fmapElems($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldElems'));
    }
    
    public function fmapFilterset($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldFilterset'));
    }
    
    public function fmapWidget($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldWidget'));
    }
    
    public function fmapRangeSlider($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $this->path = $path;
        return call_user_func(array($this, 'foldRangeSlider'));
    }
    
    public function fmap2Product($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Attribute($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Value($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2ANode($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2RNode($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Testclass($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Project($obj, $arg){
        $inj = $this;
        call_user_func('assoc_map_', function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj->testclasses);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2SavedSearch($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Filter($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Range($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Elems($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Filterset($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Widget($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2RangeSlider($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
}
