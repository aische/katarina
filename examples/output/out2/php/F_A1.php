<?php

class F_A1 {
    public function __construct () {
        $this->keyorder = array();
    }
    
    public function fmapProduct($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $pid = $obj->pid;
        $name = $obj->name;
        $values = (isset($inj->keyorder['foo']))?(call_user_func('assoc_map_order', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->values, $inj->keyorder['foo'])):(call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->values));
        $this->path = $path;
        return call_user_func(array($this, 'foldProduct'), $pid, $name, $values);
    }
    
    public function fmapAttribute($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $aid = $obj->aid;
        $name = $obj->name;
        $type = $obj->type;
        $this->path = $path;
        return call_user_func(array($this, 'foldAttribute'), $aid, $name, $type);
    }
    
    public function fmapValue($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $aid = $obj->aid;
        $value = $obj->value;
        $this->path = $path;
        return call_user_func(array($this, 'foldValue'), $aid, $value);
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
        $this->path = $path;
        return call_user_func(array($this, 'foldTestclass'));
    }
    
    public function fmapProject($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $id = $obj->id;
        $name = $obj->name;
        $attributes = (isset($inj->keyorder['foo']))?(call_user_func('assoc_map_order', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->attributes, $inj->keyorder['foo'])):(call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->attributes));
        $products = call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->products);
        $bla = array_map(function($obj)use($inj, $path2){return array($obj[0], $obj[1], (isset($inj->keyorder['foo']))?(call_user_func('assoc_map_order', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj[2], $inj->keyorder['foo'])):(call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj[2])), call_user_func(array($obj[3], 'fold'), $inj, $path2));}, $obj->bla);
        $this->path = $path;
        return call_user_func(array($this, 'foldProject'), $id, $name, $attributes, $products, $bla);
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
        $min = $obj->min;
        $max = $obj->max;
        $this->path = $path;
        return call_user_func(array($this, 'foldRange'), $min, $max);
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
        call_user_func('assoc_map_', function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj->values);
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
        call_user_func('assoc_map_', function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj->attributes);
        call_user_func('assoc_map_', function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj->products);
        array_map(function($obj)use($inj, $arg){call_user_func('assoc_map_', function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj[2]);
call_user_func(array($obj[3], 'fold2'), $inj, $arg);
}, $obj->bla);
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
