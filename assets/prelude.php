<?php


class JSONERROR {
    public $msg;

    public function __construct ($msg, $err=NULL) {
        $this->msg = $msg;
        if ($err instanceof JSONERROR) {
            $this->msg .= " " . $err->msg;
        }

    }
}

function isJSONERROR ($x) {
    $r = $x instanceof JSONERROR; 
    return $r;
}

function isObject ($x) {
    return is_array($x);
}

function isAssoc ($type_keyname, $x) {
    return is_array($x) && isset ($x[$type_keyname]);
}

function pInt ($json) {
    $i = (int) $json;
    return ($i == $json) ? $i : new JSONERROR ("pInt NOT AN INT: " . json_encode($json));
}

function pFloat ($json) {
    $f = (float) $json;
    return ($f == $json) ? $f : new JSONERROR ("pFloat NOT A FLOAT: " . json_encode($json));
}

function pString ($json) {
    $s = $json;
    return $s . "";
}

function pList ($p, $json) {
    if (is_array ($json)) {
        $r = array();
        $len = count($json);
        for ($i=0; $i<$len; $i++) {
            $obj = call_user_func($p, $json[$i]);
            if (isJSONERROR($obj)) {
                return new JSONERROR ("pList " + $i + ": ", $obj);
            }
            $r[$i] = $obj;
        }
        return $r;
    }
    else {
        return new JSONERROR ("pList NOT A LIST: " . json_encode($json));
    }    
}

function pMap ($keyname, $p, $json) {
    if (is_array($json)) {
        $map = array();
        $len = count($json);
        for ($i=0; $i<$len; $i++) {
            $obj = call_user_func($p, $json[$i]);
            if (isJSONERROR($obj)) {
                return new JSONERROR ("pMap " . $i . ": ", $obj);
            }
            $id = $obj->$keyname;
            if (isset($map[$id])) {

                return new JSONERROR ("pMap " . $i . ": duplicate ID:" . $id);
            }
            else {
                $map[$id] = $obj;
            }
        }
        #return new AssocWrapper($keyname, $map);
        return $map;
    }
    else {
        return new JSONERROR ("pMap NOT A LIST: " . json_encode($json));
    }
}

function mapToJSON ($map) {
    $arr = array();
    foreach($map as $item) {
        $arr[] = $item->toJSON();
    }
    return $arr;
}

function pTuple ($ps, $json) {
    if (is_array ($json)) { 
        $len = count($ps);
        if ($len !== count($json)) {
            return new JSONERROR ("pTuple WRONG ARITY " . count($json) . " SHOULD BE " . $len . ": " . json_encode($json));
        }
        $r = array();
        for ($i=0; $i<$len; $i++) {
            $o = $ps[$i]($json[$i]);
            if (isJSONERROR($o)) {
                return new JSONERROR ("pTuple " . $i . ": ", $o);
            }
            $r[$i] = $o;
        }
        return $r;
    }
    else {
        return new JSONERROR ("pTuple NOT A LIST: " . json_encode($json));
    }
}

//

function pUnsafe ($json) {
    return $json;
}

function pListUnsafe ($p, $json) {
    $r = array();
    $len = count ($json);
    for ($i=0; $i<$len; $i++) {
        $obj = $p($json[$i]);
        $r[$i] = $obj;
    }
    return $r;
}

function pMapUnsafe ($keyname, $p, $json) {
    $map = array();
    $len = count ($json);
    for ($i=0; $i<$len; $i++) {
        $obj = $p ($json[$i]);
        $id = $obj[$keyname];
        $map[$id] = $obj;
    }
    #return new AssocWrapper($keyname, $map);
    return $map;
}

function pTupleUnsafe ($ps, $json) {
    $r = array();
    $len = count ($ps);
    for ($i=0; $i<$len; $i++) {
        $o = $ps[$i]($json[$i]);
        $r[$i] = $o;
    }
    return $r;
}

function assoc_map ($f, $map) {
    $r = array();
    foreach ($map as $k => $v) {
        $r[$k] = call_user_func($f, $v);
    }
    return $r;
}

function assoc_map_ ($f, $map) {
    $r = array();
    foreach ($map as $k => $v) {
        $r[] = call_user_func($f, $v);
    }
    return $r;
}

function assoc_map_order ($f, $map, $order) {
    $r = array();
    $len = count($order);
    for ($i=0; $i<$len; $i++) {
        $k = $order[$i];
        if (isset($map[$k])) {
            $r[] = $f($map[$k]);    
        }
    }
    return $r;
}

class AssocWrapper {
    public $map;
    public $keyname;
    
    public function __construct ($keyname, $map) {
        $this->keyname = $keyname;
        $this->map = $map;
    }

    public function put ($obj) {
        $key = $this->keyname;
        $id = $obj->$key;
        $this->map[$id] = $obj;
    }    

    public function at ($id) {
        return $this->map[$id];
    }    

    public function set ($id,  $key, $value) {
        if (isset($this->map[$id])) {
            $this->map[$id]->$key = $value;
            return True;
        }
        return False;
    }    

    public function get ($id,  $key) {
        if (isset($this->map[$id]) && isset($this->map[$id]->$key)) {
            return $this->map[$id]->$key;
        }
        return NULL;
    }    
    
    public function newKey () {
        $keys = array_keys($this->map);
        if (count($keys) == 0) {
            return 1;
        }
        else {
            return 1 + max($keys);
        }
    }
}

