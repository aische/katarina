function JSONERROR (msg, err) {
    this.msg = msg;
    if (err instanceof JSONERROR) {
        this.msg += " " + err.msg
    }
}

function isJSONERROR (x) {
    var r = x instanceof JSONERROR; 
    //console.log("isJSONERROR", r, x);
    return r;
}

function isObject (x) {
    if (x === null) { 
        return false;
    }
    return (typeof x === 'object'); // || (typeof val === 'function');
}

function isAssoc (type_keyname, x) {
    if (x === null) { 
        return false;
    }
    return ((typeof x === 'object') && (type_keyname in x)); // || (typeof val === 'function');
}

function pInt (json) {
    var i = parseInt(json);
    return ((""+i) == json) ? i : new JSONERROR ("pInt NOT AN INT: " + JSON.stringify(json));
}

function pFloat (json) {
    var f = parseFloat(json);
    return ((""+f) == json) ? f : new JSONERROR ("pFloat NOT A FLOAT: " + JSON.stringify(json))
}

function pString (json) {
    var s = json;
    return ((""+s) == json) ? s : new JSONERROR ("pString  NOT A STRING: " + JSON.stringify(json))
}

function pList (p, json) {
    if (Array.isArray (json)) {
        var r = [];
        for (var i=0; i<json.length; i++) {
            var obj = p(json[i]);
            if (isJSONERROR(obj)) {
                return new JSONERROR ("pList " + i + ": ", obj);
            }
            r[i] = obj;
        }
        return r;
    }
    else {
        return new JSONERROR ("pList NOT A LIST: " + JSON.stringify(json));
    }    
}

function pMap (keyname, p, json) {
    if (Array.isArray(json)) {
        var map = {};
        for (var i=0; i<json.length; i++) {
            var obj = p (json[i]);
            if (isJSONERROR(obj)) {
                return new JSONERROR ("pMap " + i + ": ", obj);
            }
            var id = obj[keyname];
            if (id in map) {
                return new JSONERROR ("pMap " + i + ": duplicate ID:" + id);
            }
            else {
                map[id] = obj;
            }
        }
        //return new AssocWrapper(keyname, map);
        return map;
    }
    else {
        return new JSONERROR ("pMap NOT A LIST: " + JSON.stringify(json));
    }
}

function mapToJSON (wmap) {
    var map = wmap; // .map;
    var arr = [];
    for (var id in map) {
        arr.push (map[id].toJSON());
    }
    return arr;
}

function pTuple (ps, json) {
    if (Array.isArray (json)) { 
        if (ps.length !== json.length) {
            return new JSONERROR ("pTuple WRONG ARITY " + json.length + " SHOULD BE " + ps.length + ": " + JSON.stringify(json));
        }
        var r = [];
        for (var i=0; i<ps.length; i++) {
            var o = ps[i](json[i]);
            if (isJSONERROR(o)) {
                return new JSONERROR ("pTuple " + i + ": ", o);
            }
            r[i] = o;
        }
        return r;
    }
    else {
        return new JSONERROR ("pTuple NOT A LIST: " + JSON.stringify(json));
    }
}

//

function pUnsafe (json) {
    return json;
}

function pListUnsafe (p, json) {
    var r = [];
    for (var i=0; i<json.length; i++) {
        var obj = p(json[i]);
        r[i] = obj;
    }
    return r;
}

function pMapUnsafe (keyname, p, json) {
    var map = {};
    for (var i=0; i<json.length; i++) {
        var obj = p (json[i]);
        var id = obj[keyname];
        map[id] = obj;
    }
    //return new AssocWrapper(keyname, map);
    return map;
}

function pTupleUnsafe (ps, json) {
    var r = [];
    for (var i=0; i<ps.length; i++) {
        var o = ps[i](json[i]);
        r[i] = o;
    }
    return r;
}

function assoc_map (f, obj) {
    var r = {};
    for (var k in obj) {
        r[k] = f(obj[k]);
    }
    return r;
}

function assoc_map_ (f, obj) {
    var r = [];
    
    for (var k in obj) {
        r.push(f(obj[k]));
    }
    return r;
}

function assoc_map_order (f, obj, order) {
    var r = [];
    for (var i=0; i<order.length; i++) {
        var k = order[i];
        if (k in obj) {
            r.push(f(obj[k]));    
        }
    }
    return r;
}


function AssocWrapper (keyname, map) {
    this.map = map;
    this.keyname = keyname;
}

AssocWrapper.prototype.put = function (obj) {
    var key = this.keyname;
    var id = obj.key;
    this.map[id] = obj;
};    

AssocWrapper.prototype.at = function (id) {
    return this.map[id];
};    

AssocWrapper.prototype.set = function (id, key, value) {
    if (id in this.map) {
        this.map[id][key] = value;
        return true;
    }
    return false;
};    

AssocWrapper.prototype.get = function (id, key) {
    if ((id in this.map) && (key in this.map[id])) {
        return this.map[id][key];
    }
    return null;
};    

AssocWrapper.prototype.newKey = function () {
    var keys = Object.keys(this.map);
    if (keys.length==0) {
        return 1;
    }
    else {
        return 1 + Math.max.apply(null, keys);
    }
}
