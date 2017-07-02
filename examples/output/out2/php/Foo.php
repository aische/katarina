<?php

class Product {
    public function __construct () {
    }
    
    public static function fromArgs($pid, $name){
        $obj = new Product();
        $obj->pid = (int)$pid;
        $obj->name = (string)$name;
        $obj->values = call_user_func('pMap', "aid", function($x){return $x;}, array());
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Product";
        $json['pid'] = $this->pid;
        $json['name'] = $this->name;
        $json['values'] = call_user_func('mapToJSON', $this->values);
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Product"))) {
            $obj = new Product();
            if (isset($json['pid'])) {
                $obj->pid = call_user_func('pInt', $json['pid']);
                if (call_user_func('isJSONERROR', $obj->pid)) {
                    return new JSONERROR("Product.pid", $obj->pid);
                }
            }
            else {
                return new JSONERROR("Product fromJSON: missing key: pid");
            }
            if (isset($json['name'])) {
                $obj->name = call_user_func('pString', $json['name']);
                if (call_user_func('isJSONERROR', $obj->name)) {
                    return new JSONERROR("Product.name", $obj->name);
                }
            }
            else {
                return new JSONERROR("Product fromJSON: missing key: name");
            }
            if (isset($json['values'])) {
                $obj->values = call_user_func(function($json){return call_user_func('pMap', "aid", array('Value', 'fromJSON'), $json);}, $json['values']);
                if (call_user_func('isJSONERROR', $obj->values)) {
                    return new JSONERROR("Product.values", $obj->values);
                }
            }
            else {
                return new JSONERROR("Product fromJSON: missing key: values");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Product " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Product();
        $obj->pid = call_user_func('pUnsafe', $json['pid']);
        $obj->name = call_user_func('pUnsafe', $json['name']);
        $obj->values = call_user_func(function($json){return call_user_func('pMap', "aid", array('Value', 'unsafeFromJSON'), $json);}, $json['values']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Product();
            if (isset($json['pid'])) {
                $obj->pid = (int)$json['pid'];
            }
            else {
                $obj->pid = 0;
            }
            if (isset($json['name'])) {
                $obj->name = (string)$json['name'];
            }
            else {
                $obj->name = "";
            }
            if (isset($json['values'])) {
                $obj->values = $json['values'];
            }
            else {
                $obj->values = call_user_func('pMap', "aid", function($x){return $x;}, array());
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapProduct'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Product'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldProduct'), $input);
        $obj->values = call_user_func('assoc_map_', function($input)use($coalg){return call_user_func(array('Value', 'unfold'), $coalg, $input);}, $obj->values);
        return $obj;
    }
}

class Attribute {
    public function __construct () {
    }
    
    public static function fromArgs($aid, $name, $type){
        $obj = new Attribute();
        $obj->aid = (int)$aid;
        $obj->name = (string)$name;
        $obj->type = (string)$type;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Attribute";
        $json['aid'] = $this->aid;
        $json['name'] = $this->name;
        $json['type'] = $this->type;
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Attribute"))) {
            $obj = new Attribute();
            if (isset($json['aid'])) {
                $obj->aid = call_user_func('pInt', $json['aid']);
                if (call_user_func('isJSONERROR', $obj->aid)) {
                    return new JSONERROR("Attribute.aid", $obj->aid);
                }
            }
            else {
                return new JSONERROR("Attribute fromJSON: missing key: aid");
            }
            if (isset($json['name'])) {
                $obj->name = call_user_func('pString', $json['name']);
                if (call_user_func('isJSONERROR', $obj->name)) {
                    return new JSONERROR("Attribute.name", $obj->name);
                }
            }
            else {
                return new JSONERROR("Attribute fromJSON: missing key: name");
            }
            if (isset($json['type'])) {
                $obj->type = call_user_func('pString', $json['type']);
                if (call_user_func('isJSONERROR', $obj->type)) {
                    return new JSONERROR("Attribute.type", $obj->type);
                }
            }
            else {
                return new JSONERROR("Attribute fromJSON: missing key: type");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Attribute " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Attribute();
        $obj->aid = call_user_func('pUnsafe', $json['aid']);
        $obj->name = call_user_func('pUnsafe', $json['name']);
        $obj->type = call_user_func('pUnsafe', $json['type']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Attribute();
            if (isset($json['aid'])) {
                $obj->aid = (int)$json['aid'];
            }
            else {
                $obj->aid = 0;
            }
            if (isset($json['name'])) {
                $obj->name = (string)$json['name'];
            }
            else {
                $obj->name = "";
            }
            if (isset($json['type'])) {
                $obj->type = (string)$json['type'];
            }
            else {
                $obj->type = "";
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapAttribute'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Attribute'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldAttribute'), $input);
        return $obj;
    }
}

class Value {
    public function __construct () {
    }
    
    public static function fromArgs($aid, $value){
        $obj = new Value();
        $obj->aid = (int)$aid;
        $obj->value = (string)$value;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Value";
        $json['aid'] = $this->aid;
        $json['value'] = $this->value;
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Value"))) {
            $obj = new Value();
            if (isset($json['aid'])) {
                $obj->aid = call_user_func('pInt', $json['aid']);
                if (call_user_func('isJSONERROR', $obj->aid)) {
                    return new JSONERROR("Value.aid", $obj->aid);
                }
            }
            else {
                return new JSONERROR("Value fromJSON: missing key: aid");
            }
            if (isset($json['value'])) {
                $obj->value = call_user_func('pString', $json['value']);
                if (call_user_func('isJSONERROR', $obj->value)) {
                    return new JSONERROR("Value.value", $obj->value);
                }
            }
            else {
                $obj->value = "Hello World";
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Value " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Value();
        $obj->aid = call_user_func('pUnsafe', $json['aid']);
        $obj->value = call_user_func('pUnsafe', $json['value']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Value();
            if (isset($json['aid'])) {
                $obj->aid = (int)$json['aid'];
            }
            else {
                $obj->aid = 0;
            }
            if (isset($json['value'])) {
                $obj->value = (string)$json['value'];
            }
            else {
                $obj->value = "Hello World";
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapValue'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Value'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldValue'), $input);
        return $obj;
    }
}

class ANode {
    public function __construct () {
    }
    
    public static function fromArgs($aid, $weight){
        $obj = new ANode();
        $obj->aid = (int)$aid;
        $obj->weight = (float)$weight;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "ANode";
        $json['aid'] = $this->aid;
        $json['weight'] = $this->weight;
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "ANode"))) {
            $obj = new ANode();
            if (isset($json['aid'])) {
                $obj->aid = call_user_func('pInt', $json['aid']);
                if (call_user_func('isJSONERROR', $obj->aid)) {
                    return new JSONERROR("ANode.aid", $obj->aid);
                }
            }
            else {
                return new JSONERROR("ANode fromJSON: missing key: aid");
            }
            if (isset($json['weight'])) {
                $obj->weight = call_user_func('pFloat', $json['weight']);
                if (call_user_func('isJSONERROR', $obj->weight)) {
                    return new JSONERROR("ANode.weight", $obj->weight);
                }
            }
            else {
                $obj->weight = 0.5;
            }
            return $obj;
        }
        else {
            return new JSONERROR(("ANode " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new ANode();
        $obj->aid = call_user_func('pUnsafe', $json['aid']);
        $obj->weight = call_user_func('pUnsafe', $json['weight']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new ANode();
            if (isset($json['aid'])) {
                $obj->aid = (int)$json['aid'];
            }
            else {
                $obj->aid = 0;
            }
            if (isset($json['weight'])) {
                $obj->weight = (float)$json['weight'];
            }
            else {
                $obj->weight = 0.5;
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapANode'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2ANode'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldANode'), $input);
        return $obj;
    }
}

class RNode {
    public function __construct () {
    }
    
    public static function fromArgs($name, $weight){
        $obj = new RNode();
        $obj->name = (string)$name;
        $obj->weight = (float)$weight;
        $obj->nodes = array();
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "RNode";
        $json['name'] = $this->name;
        $json['weight'] = $this->weight;
        $json['nodes'] = array_map(function($obj){return call_user_func(array($obj, 'toJSON'));}, $this->nodes);
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "RNode"))) {
            $obj = new RNode();
            if (isset($json['name'])) {
                $obj->name = call_user_func('pString', $json['name']);
                if (call_user_func('isJSONERROR', $obj->name)) {
                    return new JSONERROR("RNode.name", $obj->name);
                }
            }
            else {
                return new JSONERROR("RNode fromJSON: missing key: name");
            }
            if (isset($json['weight'])) {
                $obj->weight = call_user_func('pFloat', $json['weight']);
                if (call_user_func('isJSONERROR', $obj->weight)) {
                    return new JSONERROR("RNode.weight", $obj->weight);
                }
            }
            else {
                return new JSONERROR("RNode fromJSON: missing key: weight");
            }
            if (isset($json['nodes'])) {
                $obj->nodes = call_user_func(function($json){return call_user_func('pList', function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "ANode"))?(call_user_func(array('ANode', 'fromJSON'), $json)):((($json['constr'] == "RNode"))?(call_user_func(array('RNode', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr']))))):(new JSONERROR("Wrong Object"));}, $json);}, $json['nodes']);
                if (call_user_func('isJSONERROR', $obj->nodes)) {
                    return new JSONERROR("RNode.nodes", $obj->nodes);
                }
            }
            else {
                return new JSONERROR("RNode fromJSON: missing key: nodes");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("RNode " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new RNode();
        $obj->name = call_user_func('pUnsafe', $json['name']);
        $obj->weight = call_user_func('pUnsafe', $json['weight']);
        $obj->nodes = call_user_func(function($json){return call_user_func('pList', function($json){return (($json['constr'] == "ANode"))?(call_user_func(array('ANode', 'unsafeFromJSON'), $json)):(call_user_func(array('RNode', 'unsafeFromJSON'), $json));}, $json);}, $json['nodes']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new RNode();
            if (isset($json['name'])) {
                $obj->name = (string)$json['name'];
            }
            else {
                $obj->name = "";
            }
            if (isset($json['weight'])) {
                $obj->weight = (float)$json['weight'];
            }
            else {
                $obj->weight = 0.0;
            }
            if (isset($json['nodes'])) {
                $obj->nodes = $json['nodes'];
            }
            else {
                $obj->nodes = array();
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapRNode'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2RNode'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldRNode'), $input);
        $obj->nodes = array_map(function($obj)use($coalg, $input){$obj = call_user_func(array('ANode', 'unfold'), $coalg, $input);
if ($obj) {
}
else {
    $obj = call_user_func(array('RNode', 'unfold'), $coalg, $input);
}
return $obj;
}, $obj->nodes);
        return $obj;
    }
}

class Testclass {
    public function __construct () {
    }
    
    public static function fromArgs($tid, $name){
        $obj = new Testclass();
        $obj->tid = (int)$tid;
        $obj->name = (string)$name;
        $obj->nodes = array();
        $obj->weights = call_user_func('pMap', "aid", function($x){return $x;}, array());
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Testclass";
        $json['tid'] = $this->tid;
        $json['name'] = $this->name;
        $json['nodes'] = array_map(function($obj){return call_user_func(array($obj, 'toJSON'));}, $this->nodes);
        $json['weights'] = call_user_func('mapToJSON', $this->weights);
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Testclass"))) {
            $obj = new Testclass();
            if (isset($json['tid'])) {
                $obj->tid = call_user_func('pInt', $json['tid']);
                if (call_user_func('isJSONERROR', $obj->tid)) {
                    return new JSONERROR("Testclass.tid", $obj->tid);
                }
            }
            else {
                return new JSONERROR("Testclass fromJSON: missing key: tid");
            }
            if (isset($json['name'])) {
                $obj->name = call_user_func('pString', $json['name']);
                if (call_user_func('isJSONERROR', $obj->name)) {
                    return new JSONERROR("Testclass.name", $obj->name);
                }
            }
            else {
                return new JSONERROR("Testclass fromJSON: missing key: name");
            }
            if (isset($json['nodes'])) {
                $obj->nodes = call_user_func(function($json){return call_user_func('pList', function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "ANode"))?(call_user_func(array('ANode', 'fromJSON'), $json)):((($json['constr'] == "RNode"))?(call_user_func(array('RNode', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr']))))):(new JSONERROR("Wrong Object"));}, $json);}, $json['nodes']);
                if (call_user_func('isJSONERROR', $obj->nodes)) {
                    return new JSONERROR("Testclass.nodes", $obj->nodes);
                }
            }
            else {
                return new JSONERROR("Testclass fromJSON: missing key: nodes");
            }
            if (isset($json['weights'])) {
                $obj->weights = call_user_func(function($json){return call_user_func('pMap', "aid", array('ANode', 'fromJSON'), $json);}, $json['weights']);
                if (call_user_func('isJSONERROR', $obj->weights)) {
                    return new JSONERROR("Testclass.weights", $obj->weights);
                }
            }
            else {
                return new JSONERROR("Testclass fromJSON: missing key: weights");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Testclass " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Testclass();
        $obj->tid = call_user_func('pUnsafe', $json['tid']);
        $obj->name = call_user_func('pUnsafe', $json['name']);
        $obj->nodes = call_user_func(function($json){return call_user_func('pList', function($json){return (($json['constr'] == "ANode"))?(call_user_func(array('ANode', 'unsafeFromJSON'), $json)):(call_user_func(array('RNode', 'unsafeFromJSON'), $json));}, $json);}, $json['nodes']);
        $obj->weights = call_user_func(function($json){return call_user_func('pMap', "aid", array('ANode', 'unsafeFromJSON'), $json);}, $json['weights']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Testclass();
            if (isset($json['tid'])) {
                $obj->tid = (int)$json['tid'];
            }
            else {
                $obj->tid = 0;
            }
            if (isset($json['name'])) {
                $obj->name = (string)$json['name'];
            }
            else {
                $obj->name = "";
            }
            if (isset($json['nodes'])) {
                $obj->nodes = $json['nodes'];
            }
            else {
                $obj->nodes = array();
            }
            if (isset($json['weights'])) {
                $obj->weights = $json['weights'];
            }
            else {
                $obj->weights = call_user_func('pMap', "aid", function($x){return $x;}, array());
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapTestclass'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Testclass'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldTestclass'), $input);
        $obj->nodes = array_map(function($obj)use($coalg, $input){$obj = call_user_func(array('ANode', 'unfold'), $coalg, $input);
if ($obj) {
}
else {
    $obj = call_user_func(array('RNode', 'unfold'), $coalg, $input);
}
return $obj;
}, $obj->nodes);
        $obj->weights = call_user_func('assoc_map_', function($input)use($coalg){return call_user_func(array('ANode', 'unfold'), $coalg, $input);}, $obj->weights);
        return $obj;
    }
}

class Project {
    public function __construct () {
    }
    
    public static function fromArgs($id, $name){
        $obj = new Project();
        $obj->id = (int)$id;
        $obj->name = (string)$name;
        $obj->attributes = call_user_func('pMap', "aid", function($x){return $x;}, array());
        $obj->products = call_user_func('pMap', "pid", function($x){return $x;}, array());
        $obj->testclasses = call_user_func('pMap', "tid", function($x){return $x;}, array());
        $obj->bla = array();
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Project";
        $json['id'] = $this->id;
        $json['name'] = $this->name;
        $json['attributes'] = call_user_func('mapToJSON', $this->attributes);
        $json['products'] = call_user_func('mapToJSON', $this->products);
        $json['testclasses'] = call_user_func('mapToJSON', $this->testclasses);
        $json['bla'] = array_map(function($obj){return array($obj[0], $obj[1], call_user_func('mapToJSON', $obj[2]), call_user_func(array($obj[3], 'toJSON')));}, $this->bla);
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Project"))) {
            $obj = new Project();
            if (isset($json['id'])) {
                $obj->id = call_user_func('pInt', $json['id']);
                if (call_user_func('isJSONERROR', $obj->id)) {
                    return new JSONERROR("Project.id", $obj->id);
                }
            }
            else {
                return new JSONERROR("Project fromJSON: missing key: id");
            }
            if (isset($json['name'])) {
                $obj->name = call_user_func('pString', $json['name']);
                if (call_user_func('isJSONERROR', $obj->name)) {
                    return new JSONERROR("Project.name", $obj->name);
                }
            }
            else {
                $obj->name = "foobaz \"haha\"!";
            }
            if (isset($json['attributes'])) {
                $obj->attributes = call_user_func(function($json){return call_user_func('pMap', "aid", array('Attribute', 'fromJSON'), $json);}, $json['attributes']);
                if (call_user_func('isJSONERROR', $obj->attributes)) {
                    return new JSONERROR("Project.attributes", $obj->attributes);
                }
            }
            else {
                return new JSONERROR("Project fromJSON: missing key: attributes");
            }
            if (isset($json['products'])) {
                $obj->products = call_user_func(function($json){return call_user_func('pMap', "pid", array('Product', 'fromJSON'), $json);}, $json['products']);
                if (call_user_func('isJSONERROR', $obj->products)) {
                    return new JSONERROR("Project.products", $obj->products);
                }
            }
            else {
                return new JSONERROR("Project fromJSON: missing key: products");
            }
            if (isset($json['testclasses'])) {
                $obj->testclasses = call_user_func(function($json){return call_user_func('pMap', "tid", array('Testclass', 'fromJSON'), $json);}, $json['testclasses']);
                if (call_user_func('isJSONERROR', $obj->testclasses)) {
                    return new JSONERROR("Project.testclasses", $obj->testclasses);
                }
            }
            else {
                return new JSONERROR("Project fromJSON: missing key: testclasses");
            }
            if (isset($json['bla'])) {
                $obj->bla = call_user_func(function($json){return call_user_func('pList', function($json){return call_user_func('pTuple', array(function($json){return call_user_func('pInt', $json);}, function($json){return call_user_func('pString', $json);}, function($json){return call_user_func(function($json){return call_user_func('pMap', "aid", array('Attribute', 'fromJSON'), $json);}, $json);}, function($json){return call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Range"))?(call_user_func(array('Range', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr'])))):(new JSONERROR("Wrong Object"));}, $json);}), $json);}, $json);}, $json['bla']);
                if (call_user_func('isJSONERROR', $obj->bla)) {
                    return new JSONERROR("Project.bla", $obj->bla);
                }
            }
            else {
                $obj->bla = array();
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Project " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Project();
        $obj->id = call_user_func('pUnsafe', $json['id']);
        $obj->name = call_user_func('pUnsafe', $json['name']);
        $obj->attributes = call_user_func(function($json){return call_user_func('pMap', "aid", array('Attribute', 'unsafeFromJSON'), $json);}, $json['attributes']);
        $obj->products = call_user_func(function($json){return call_user_func('pMap', "pid", array('Product', 'unsafeFromJSON'), $json);}, $json['products']);
        $obj->testclasses = call_user_func(function($json){return call_user_func('pMap', "tid", array('Testclass', 'unsafeFromJSON'), $json);}, $json['testclasses']);
        $obj->bla = call_user_func(function($json){return call_user_func('pList', function($json){return call_user_func('pTuple', array(function($json){return call_user_func('pUnsafe', $json);}, function($json){return call_user_func('pUnsafe', $json);}, function($json){return call_user_func(function($json){return call_user_func('pMap', "aid", array('Attribute', 'unsafeFromJSON'), $json);}, $json);}, function($json){return call_user_func(function($json){return call_user_func(array('Range', 'unsafeFromJSON'), $json);}, $json);}), $json);}, $json);}, $json['bla']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Project();
            if (isset($json['id'])) {
                $obj->id = (int)$json['id'];
            }
            else {
                $obj->id = 0;
            }
            if (isset($json['name'])) {
                $obj->name = (string)$json['name'];
            }
            else {
                $obj->name = "foobaz \"haha\"!";
            }
            if (isset($json['attributes'])) {
                $obj->attributes = $json['attributes'];
            }
            else {
                $obj->attributes = call_user_func('pMap', "aid", function($x){return $x;}, array());
            }
            if (isset($json['products'])) {
                $obj->products = $json['products'];
            }
            else {
                $obj->products = call_user_func('pMap', "pid", function($x){return $x;}, array());
            }
            if (isset($json['testclasses'])) {
                $obj->testclasses = $json['testclasses'];
            }
            else {
                $obj->testclasses = call_user_func('pMap', "tid", function($x){return $x;}, array());
            }
            if (isset($json['bla'])) {
                $obj->bla = $json['bla'];
            }
            else {
                $obj->bla = array();
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapProject'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Project'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldProject'), $input);
        $obj->attributes = call_user_func('assoc_map_', function($input)use($coalg){return call_user_func(array('Attribute', 'unfold'), $coalg, $input);}, $obj->attributes);
        $obj->products = call_user_func('assoc_map_', function($input)use($coalg){return call_user_func(array('Product', 'unfold'), $coalg, $input);}, $obj->products);
        $obj->testclasses = call_user_func('assoc_map_', function($input)use($coalg){return call_user_func(array('Testclass', 'unfold'), $coalg, $input);}, $obj->testclasses);
        $obj->bla = array_map(function($obj)use($coalg, $input){$obj[2] = call_user_func('assoc_map_', function($input)use($coalg){return call_user_func(array('Attribute', 'unfold'), $coalg, $input);}, $obj[2]);
$obj[3] = call_user_func(array('Range', 'unfold'), $coalg, $input);
return $obj;
}, $obj->bla);
        return $obj;
    }
}

class SavedSearch {
    public function __construct () {
    }
    
    public static function fromArgs($sid){
        $obj = new SavedSearch();
        $obj->sid = (int)$sid;
        $obj->values = call_user_func('pMap', "aid", function($x){return $x;}, array());
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "SavedSearch";
        $json['sid'] = $this->sid;
        $json['values'] = call_user_func('mapToJSON', $this->values);
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "SavedSearch"))) {
            $obj = new SavedSearch();
            if (isset($json['sid'])) {
                $obj->sid = call_user_func('pInt', $json['sid']);
                if (call_user_func('isJSONERROR', $obj->sid)) {
                    return new JSONERROR("SavedSearch.sid", $obj->sid);
                }
            }
            else {
                return new JSONERROR("SavedSearch fromJSON: missing key: sid");
            }
            if (isset($json['values'])) {
                $obj->values = call_user_func(function($json){return call_user_func('pMap', "aid", array('Filter', 'fromJSON'), $json);}, $json['values']);
                if (call_user_func('isJSONERROR', $obj->values)) {
                    return new JSONERROR("SavedSearch.values", $obj->values);
                }
            }
            else {
                return new JSONERROR("SavedSearch fromJSON: missing key: values");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("SavedSearch " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new SavedSearch();
        $obj->sid = call_user_func('pUnsafe', $json['sid']);
        $obj->values = call_user_func(function($json){return call_user_func('pMap', "aid", array('Filter', 'unsafeFromJSON'), $json);}, $json['values']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new SavedSearch();
            if (isset($json['sid'])) {
                $obj->sid = (int)$json['sid'];
            }
            else {
                $obj->sid = 0;
            }
            if (isset($json['values'])) {
                $obj->values = $json['values'];
            }
            else {
                $obj->values = call_user_func('pMap', "aid", function($x){return $x;}, array());
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapSavedSearch'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2SavedSearch'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldSavedSearch'), $input);
        $obj->values = call_user_func('assoc_map_', function($input)use($coalg){return call_user_func(array('Filter', 'unfold'), $coalg, $input);}, $obj->values);
        return $obj;
    }
}

class Filter {
    public function __construct () {
    }
    
    public static function fromArgs($aid, $predicate){
        $obj = new Filter();
        $obj->aid = (int)$aid;
        $obj->predicate = $predicate;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Filter";
        $json['aid'] = $this->aid;
        $json['predicate'] = call_user_func(array($this->predicate, 'toJSON'));
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Filter"))) {
            $obj = new Filter();
            if (isset($json['aid'])) {
                $obj->aid = call_user_func('pInt', $json['aid']);
                if (call_user_func('isJSONERROR', $obj->aid)) {
                    return new JSONERROR("Filter.aid", $obj->aid);
                }
            }
            else {
                return new JSONERROR("Filter fromJSON: missing key: aid");
            }
            if (isset($json['predicate'])) {
                $obj->predicate = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "Range"))?(call_user_func(array('Range', 'fromJSON'), $json)):((($json['constr'] == "Elems"))?(call_user_func(array('Elems', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr']))))):(new JSONERROR("Wrong Object"));}, $json['predicate']);
                if (call_user_func('isJSONERROR', $obj->predicate)) {
                    return new JSONERROR("Filter.predicate", $obj->predicate);
                }
            }
            else {
                return new JSONERROR("Filter fromJSON: missing key: predicate");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Filter " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Filter();
        $obj->aid = call_user_func('pUnsafe', $json['aid']);
        $obj->predicate = call_user_func(function($json){return (($json['constr'] == "Range"))?(call_user_func(array('Range', 'unsafeFromJSON'), $json)):(call_user_func(array('Elems', 'unsafeFromJSON'), $json));}, $json['predicate']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Filter();
            if (isset($json['aid'])) {
                $obj->aid = (int)$json['aid'];
            }
            else {
                $obj->aid = 0;
            }
            if (isset($json['predicate'])) {
                $obj->predicate = $json['predicate'];
            }
            else {
                $obj->predicate = NULL;
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapFilter'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Filter'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldFilter'), $input);
        $obj->predicate = call_user_func(array('Range', 'unfold'), $coalg, $input);
        if ($obj->predicate) {
        }
        else {
            $obj->predicate = call_user_func(array('Elems', 'unfold'), $coalg, $input);
        }
        return $obj;
    }
}

class Range {
    public function __construct () {
    }
    
    public static function fromArgs($min, $max){
        $obj = new Range();
        $obj->min = (int)$min;
        $obj->max = (int)$max;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Range";
        $json['min'] = $this->min;
        $json['max'] = $this->max;
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Range"))) {
            $obj = new Range();
            if (isset($json['min'])) {
                $obj->min = call_user_func('pInt', $json['min']);
                if (call_user_func('isJSONERROR', $obj->min)) {
                    return new JSONERROR("Range.min", $obj->min);
                }
            }
            else {
                return new JSONERROR("Range fromJSON: missing key: min");
            }
            if (isset($json['max'])) {
                $obj->max = call_user_func('pInt', $json['max']);
                if (call_user_func('isJSONERROR', $obj->max)) {
                    return new JSONERROR("Range.max", $obj->max);
                }
            }
            else {
                return new JSONERROR("Range fromJSON: missing key: max");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Range " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Range();
        $obj->min = call_user_func('pUnsafe', $json['min']);
        $obj->max = call_user_func('pUnsafe', $json['max']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Range();
            if (isset($json['min'])) {
                $obj->min = (int)$json['min'];
            }
            else {
                $obj->min = 0;
            }
            if (isset($json['max'])) {
                $obj->max = (int)$json['max'];
            }
            else {
                $obj->max = 0;
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapRange'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Range'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldRange'), $input);
        return $obj;
    }
}

class Elems {
    public function __construct () {
    }
    
    public static function fromArgs(){
        $obj = new Elems();
        $obj->values = array();
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Elems";
        $json['values'] = array_map(function($obj){return $obj;}, $this->values);
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Elems"))) {
            $obj = new Elems();
            if (isset($json['values'])) {
                $obj->values = call_user_func(function($json){return call_user_func('pList', 'pString', $json);}, $json['values']);
                if (call_user_func('isJSONERROR', $obj->values)) {
                    return new JSONERROR("Elems.values", $obj->values);
                }
            }
            else {
                return new JSONERROR("Elems fromJSON: missing key: values");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Elems " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Elems();
        $obj->values = call_user_func(function($json){return call_user_func('pList', 'pUnsafe', $json);}, $json['values']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Elems();
            if (isset($json['values'])) {
                $obj->values = $json['values'];
            }
            else {
                $obj->values = array();
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapElems'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Elems'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldElems'), $input);
        $obj->values = array_map(function($obj)use($coalg, $input){return $obj;}, $obj->values);
        return $obj;
    }
}

class Filterset {
    public function __construct () {
    }
    
    public static function fromArgs($fsid, $name){
        $obj = new Filterset();
        $obj->fsid = (int)$fsid;
        $obj->name = (string)$name;
        $obj->widgets = call_user_func('pMap', "aid", function($x){return $x;}, array());
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Filterset";
        $json['fsid'] = $this->fsid;
        $json['name'] = $this->name;
        $json['widgets'] = call_user_func('mapToJSON', $this->widgets);
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Filterset"))) {
            $obj = new Filterset();
            if (isset($json['fsid'])) {
                $obj->fsid = call_user_func('pInt', $json['fsid']);
                if (call_user_func('isJSONERROR', $obj->fsid)) {
                    return new JSONERROR("Filterset.fsid", $obj->fsid);
                }
            }
            else {
                return new JSONERROR("Filterset fromJSON: missing key: fsid");
            }
            if (isset($json['name'])) {
                $obj->name = call_user_func('pString', $json['name']);
                if (call_user_func('isJSONERROR', $obj->name)) {
                    return new JSONERROR("Filterset.name", $obj->name);
                }
            }
            else {
                return new JSONERROR("Filterset fromJSON: missing key: name");
            }
            if (isset($json['widgets'])) {
                $obj->widgets = call_user_func(function($json){return call_user_func('pMap', "aid", array('Widget', 'fromJSON'), $json);}, $json['widgets']);
                if (call_user_func('isJSONERROR', $obj->widgets)) {
                    return new JSONERROR("Filterset.widgets", $obj->widgets);
                }
            }
            else {
                return new JSONERROR("Filterset fromJSON: missing key: widgets");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Filterset " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Filterset();
        $obj->fsid = call_user_func('pUnsafe', $json['fsid']);
        $obj->name = call_user_func('pUnsafe', $json['name']);
        $obj->widgets = call_user_func(function($json){return call_user_func('pMap', "aid", array('Widget', 'unsafeFromJSON'), $json);}, $json['widgets']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Filterset();
            if (isset($json['fsid'])) {
                $obj->fsid = (int)$json['fsid'];
            }
            else {
                $obj->fsid = 0;
            }
            if (isset($json['name'])) {
                $obj->name = (string)$json['name'];
            }
            else {
                $obj->name = "";
            }
            if (isset($json['widgets'])) {
                $obj->widgets = $json['widgets'];
            }
            else {
                $obj->widgets = call_user_func('pMap', "aid", function($x){return $x;}, array());
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapFilterset'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Filterset'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldFilterset'), $input);
        $obj->widgets = call_user_func('assoc_map_', function($input)use($coalg){return call_user_func(array('Widget', 'unfold'), $coalg, $input);}, $obj->widgets);
        return $obj;
    }
}

class Widget {
    public function __construct () {
    }
    
    public static function fromArgs($aid, $widget, $info){
        $obj = new Widget();
        $obj->aid = (int)$aid;
        $obj->widget = $widget;
        $obj->info = (string)$info;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "Widget";
        $json['aid'] = $this->aid;
        $json['widget'] = call_user_func(array($this->widget, 'toJSON'));
        $json['info'] = $this->info;
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "Widget"))) {
            $obj = new Widget();
            if (isset($json['aid'])) {
                $obj->aid = call_user_func('pInt', $json['aid']);
                if (call_user_func('isJSONERROR', $obj->aid)) {
                    return new JSONERROR("Widget.aid", $obj->aid);
                }
            }
            else {
                return new JSONERROR("Widget fromJSON: missing key: aid");
            }
            if (isset($json['widget'])) {
                $obj->widget = call_user_func(function($json){return ((is_array($json) && isset($json['constr'])))?((($json['constr'] == "RangeSlider"))?(call_user_func(array('RangeSlider', 'fromJSON'), $json)):((($json['constr'] == "Range"))?(call_user_func(array('Range', 'fromJSON'), $json)):(new JSONERROR(("Wrong Type: " . $json['constr']))))):(new JSONERROR("Wrong Object"));}, $json['widget']);
                if (call_user_func('isJSONERROR', $obj->widget)) {
                    return new JSONERROR("Widget.widget", $obj->widget);
                }
            }
            else {
                return new JSONERROR("Widget fromJSON: missing key: widget");
            }
            if (isset($json['info'])) {
                $obj->info = call_user_func('pString', $json['info']);
                if (call_user_func('isJSONERROR', $obj->info)) {
                    return new JSONERROR("Widget.info", $obj->info);
                }
            }
            else {
                return new JSONERROR("Widget fromJSON: missing key: info");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("Widget " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new Widget();
        $obj->aid = call_user_func('pUnsafe', $json['aid']);
        $obj->widget = call_user_func(function($json){return (($json['constr'] == "RangeSlider"))?(call_user_func(array('RangeSlider', 'unsafeFromJSON'), $json)):(call_user_func(array('Range', 'unsafeFromJSON'), $json));}, $json['widget']);
        $obj->info = call_user_func('pUnsafe', $json['info']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new Widget();
            if (isset($json['aid'])) {
                $obj->aid = (int)$json['aid'];
            }
            else {
                $obj->aid = 0;
            }
            if (isset($json['widget'])) {
                $obj->widget = $json['widget'];
            }
            else {
                $obj->widget = NULL;
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
        return call_user_func(array($inj, 'fmapWidget'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2Widget'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldWidget'), $input);
        $obj->widget = call_user_func(array('RangeSlider', 'unfold'), $coalg, $input);
        if ($obj->widget) {
        }
        else {
            $obj->widget = call_user_func(array('Range', 'unfold'), $coalg, $input);
        }
        return $obj;
    }
}

class RangeSlider {
    public function __construct () {
    }
    
    public static function fromArgs($min, $max, $value1, $value2){
        $obj = new RangeSlider();
        $obj->min = (int)$min;
        $obj->max = (int)$max;
        $obj->value1 = (int)$value1;
        $obj->value2 = (int)$value2;
        return $obj;
    }
    
    public function toJSON(){
        $json = array();
        $json['constr'] = "RangeSlider";
        $json['min'] = $this->min;
        $json['max'] = $this->max;
        $json['value1'] = $this->value1;
        $json['value2'] = $this->value2;
        return $json;
    }
    
    public static function fromJSON($json){
        if ((is_array($json) && isset($json['constr']) && ($json['constr'] == "RangeSlider"))) {
            $obj = new RangeSlider();
            if (isset($json['min'])) {
                $obj->min = call_user_func('pInt', $json['min']);
                if (call_user_func('isJSONERROR', $obj->min)) {
                    return new JSONERROR("RangeSlider.min", $obj->min);
                }
            }
            else {
                return new JSONERROR("RangeSlider fromJSON: missing key: min");
            }
            if (isset($json['max'])) {
                $obj->max = call_user_func('pInt', $json['max']);
                if (call_user_func('isJSONERROR', $obj->max)) {
                    return new JSONERROR("RangeSlider.max", $obj->max);
                }
            }
            else {
                return new JSONERROR("RangeSlider fromJSON: missing key: max");
            }
            if (isset($json['value1'])) {
                $obj->value1 = call_user_func('pInt', $json['value1']);
                if (call_user_func('isJSONERROR', $obj->value1)) {
                    return new JSONERROR("RangeSlider.value1", $obj->value1);
                }
            }
            else {
                return new JSONERROR("RangeSlider fromJSON: missing key: value1");
            }
            if (isset($json['value2'])) {
                $obj->value2 = call_user_func('pInt', $json['value2']);
                if (call_user_func('isJSONERROR', $obj->value2)) {
                    return new JSONERROR("RangeSlider.value2", $obj->value2);
                }
            }
            else {
                return new JSONERROR("RangeSlider fromJSON: missing key: value2");
            }
            return $obj;
        }
        else {
            return new JSONERROR(("RangeSlider " . $json['constr']));
        }
    }
    
    public static function unsafeFromJSON($json){
        $obj = new RangeSlider();
        $obj->min = call_user_func('pUnsafe', $json['min']);
        $obj->max = call_user_func('pUnsafe', $json['max']);
        $obj->value1 = call_user_func('pUnsafe', $json['value1']);
        $obj->value2 = call_user_func('pUnsafe', $json['value2']);
        return $obj;
    }
    
    public static function fromAssoc($json){
        if (is_array($json)) {
            $obj = new RangeSlider();
            if (isset($json['min'])) {
                $obj->min = (int)$json['min'];
            }
            else {
                $obj->min = 0;
            }
            if (isset($json['max'])) {
                $obj->max = (int)$json['max'];
            }
            else {
                $obj->max = 0;
            }
            if (isset($json['value1'])) {
                $obj->value1 = (int)$json['value1'];
            }
            else {
                $obj->value1 = 0;
            }
            if (isset($json['value2'])) {
                $obj->value2 = (int)$json['value2'];
            }
            else {
                $obj->value2 = 0;
            }
            return $obj;
        }
        else {
            return NULL;
        }
    }
    
    public function fold($inj, $path = array()){
        return call_user_func(array($inj, 'fmapRangeSlider'), $this, $path);
    }
    
    public function fold2($inj, $arg){
        return call_user_func(array($inj, 'fmap2RangeSlider'), $this, $arg);
    }
    
    public static function unfold($coalg, $input){
        $obj = call_user_func(array($coalg, 'unfoldRangeSlider'), $input);
        return $obj;
    }
}

class F_Foo {
    public function __construct () {
        $this->keyorder = array();
    }
    
    public function fmapProduct($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $pid = $obj->pid;
        $name = $obj->name;
        $values = call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->values);
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
        $aid = $obj->aid;
        $weight = $obj->weight;
        $this->path = $path;
        return call_user_func(array($this, 'foldANode'), $aid, $weight);
    }
    
    public function fmapRNode($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $name = $obj->name;
        $weight = $obj->weight;
        $nodes = array_map(function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->nodes);
        $this->path = $path;
        return call_user_func(array($this, 'foldRNode'), $name, $weight, $nodes);
    }
    
    public function fmapTestclass($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $tid = $obj->tid;
        $name = $obj->name;
        $nodes = array_map(function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->nodes);
        $weights = call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->weights);
        $this->path = $path;
        return call_user_func(array($this, 'foldTestclass'), $tid, $name, $nodes, $weights);
    }
    
    public function fmapProject($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $id = $obj->id;
        $name = $obj->name;
        $attributes = call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->attributes);
        $products = call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->products);
        $testclasses = call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->testclasses);
        $bla = array_map(function($obj)use($inj, $path2){return array($obj[0], $obj[1], call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj[2]), call_user_func(array($obj[3], 'fold'), $inj, $path2));}, $obj->bla);
        $this->path = $path;
        return call_user_func(array($this, 'foldProject'), $id, $name, $attributes, $products, $testclasses, $bla);
    }
    
    public function fmapSavedSearch($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $sid = $obj->sid;
        $values = call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->values);
        $this->path = $path;
        return call_user_func(array($this, 'foldSavedSearch'), $sid, $values);
    }
    
    public function fmapFilter($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $aid = $obj->aid;
        $predicate = call_user_func(array($obj->predicate, 'fold'), $inj, $path2);
        $this->path = $path;
        return call_user_func(array($this, 'foldFilter'), $aid, $predicate);
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
        $values = array_map(function($obj)use($inj, $path2){return $obj;}, $obj->values);
        $this->path = $path;
        return call_user_func(array($this, 'foldElems'), $values);
    }
    
    public function fmapFilterset($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $fsid = $obj->fsid;
        $name = $obj->name;
        $widgets = call_user_func('assoc_map_', function($obj)use($inj, $path2){return call_user_func(array($obj, 'fold'), $inj, $path2);}, $obj->widgets);
        $this->path = $path;
        return call_user_func(array($this, 'foldFilterset'), $fsid, $name, $widgets);
    }
    
    public function fmapWidget($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $aid = $obj->aid;
        $widget = call_user_func(array($obj->widget, 'fold'), $inj, $path2);
        $info = $obj->info;
        $this->path = $path;
        return call_user_func(array($this, 'foldWidget'), $aid, $widget, $info);
    }
    
    public function fmapRangeSlider($obj, $path){
        $inj = $this;
        $path2 = array_merge(array($obj),$path);
        $min = $obj->min;
        $max = $obj->max;
        $value1 = $obj->value1;
        $value2 = $obj->value2;
        $this->path = $path;
        return call_user_func(array($this, 'foldRangeSlider'), $min, $max, $value1, $value2);
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
        array_map(function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj->nodes);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Testclass($obj, $arg){
        $inj = $this;
        array_map(function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj->nodes);
        call_user_func('assoc_map_', function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj->weights);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Project($obj, $arg){
        $inj = $this;
        call_user_func('assoc_map_', function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj->attributes);
        call_user_func('assoc_map_', function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj->products);
        call_user_func('assoc_map_', function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj->testclasses);
        array_map(function($obj)use($inj, $arg){call_user_func('assoc_map_', function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj[2]);
call_user_func(array($obj[3], 'fold2'), $inj, $arg);
}, $obj->bla);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2SavedSearch($obj, $arg){
        $inj = $this;
        call_user_func('assoc_map_', function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj->values);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Filter($obj, $arg){
        $inj = $this;
        call_user_func(array($obj->predicate, 'fold2'), $inj, $arg);
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
        array_map(function($obj)use($inj, $arg){}, $obj->values);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Filterset($obj, $arg){
        $inj = $this;
        call_user_func('assoc_map_', function($obj)use($inj, $arg){call_user_func(array($obj, 'fold2'), $inj, $arg);}, $obj->widgets);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2Widget($obj, $arg){
        $inj = $this;
        call_user_func(array($obj->widget, 'fold2'), $inj, $arg);
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
    
    public function fmap2RangeSlider($obj, $arg){
        $inj = $this;
        call_user_func(array($this, 'fold2'), $obj, $arg);
        return NULL;
    }
}
