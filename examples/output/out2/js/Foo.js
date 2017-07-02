function Product () {
}
Product.fromArgs = function (pid, name){
    var obj = new Product();
    obj.pid = parseInt(pid);
    obj.name = String(name);
    obj.values = pMap("aid", function(x){return x;}, []);
    return obj;
};
Product.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Product";
    json['pid'] = this.pid;
    json['name'] = this.name;
    json['values'] = mapToJSON(this.values);
    return json;
};
Product.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Product"))) {
        var obj = new Product();
        if (('pid' in json)) {
            obj.pid = pInt(json['pid']);
            if (isJSONERROR(obj.pid)) {
                return new JSONERROR("Product.pid", obj.pid);
            }
        }
        else {
            return new JSONERROR("Product fromJSON: missing key: pid");
        }
        if (('name' in json)) {
            obj.name = pString(json['name']);
            if (isJSONERROR(obj.name)) {
                return new JSONERROR("Product.name", obj.name);
            }
        }
        else {
            return new JSONERROR("Product fromJSON: missing key: name");
        }
        if (('values' in json)) {
            obj.values = function(json){return pMap("aid", Value.fromJSON, json);}(json['values']);
            if (isJSONERROR(obj.values)) {
                return new JSONERROR("Product.values", obj.values);
            }
        }
        else {
            return new JSONERROR("Product fromJSON: missing key: values");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Product " + json['constr']));
    }
};
Product.unsafeFromJSON = function (json){
    var obj = new Product();
    obj.pid = pUnsafe(json['pid']);
    obj.name = pUnsafe(json['name']);
    obj.values = function(json){return pMap("aid", Value.unsafeFromJSON, json);}(json['values']);
    return obj;
};
Product.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Product();
        if (('pid' in json)) {
            obj.pid = parseInt(json['pid']);
        }
        else {
            obj.pid = 0;
        }
        if (('name' in json)) {
            obj.name = String(json['name']);
        }
        else {
            obj.name = "";
        }
        if (('values' in json)) {
            obj.values = json['values'];
        }
        else {
            obj.values = pMap("aid", function(x){return x;}, {});
        }
        return obj;
    }
    else {
        return null;
    }
};
Product.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapProduct(this, path);
};
Product.prototype.fold2 = function (inj, arg){
    return inj.fmap2Product(this, arg);
};
Product.unfold = function (coalg, input){
    var obj = coalg.unfoldProduct(input);
    obj.values = assoc_map_(function(input){return Value.unfold(coalg, input);}, obj.values);
    return obj;
};
function Attribute () {
}
Attribute.fromArgs = function (aid, name, type){
    var obj = new Attribute();
    obj.aid = parseInt(aid);
    obj.name = String(name);
    obj.type = String(type);
    return obj;
};
Attribute.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Attribute";
    json['aid'] = this.aid;
    json['name'] = this.name;
    json['type'] = this.type;
    return json;
};
Attribute.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Attribute"))) {
        var obj = new Attribute();
        if (('aid' in json)) {
            obj.aid = pInt(json['aid']);
            if (isJSONERROR(obj.aid)) {
                return new JSONERROR("Attribute.aid", obj.aid);
            }
        }
        else {
            return new JSONERROR("Attribute fromJSON: missing key: aid");
        }
        if (('name' in json)) {
            obj.name = pString(json['name']);
            if (isJSONERROR(obj.name)) {
                return new JSONERROR("Attribute.name", obj.name);
            }
        }
        else {
            return new JSONERROR("Attribute fromJSON: missing key: name");
        }
        if (('type' in json)) {
            obj.type = pString(json['type']);
            if (isJSONERROR(obj.type)) {
                return new JSONERROR("Attribute.type", obj.type);
            }
        }
        else {
            return new JSONERROR("Attribute fromJSON: missing key: type");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Attribute " + json['constr']));
    }
};
Attribute.unsafeFromJSON = function (json){
    var obj = new Attribute();
    obj.aid = pUnsafe(json['aid']);
    obj.name = pUnsafe(json['name']);
    obj.type = pUnsafe(json['type']);
    return obj;
};
Attribute.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Attribute();
        if (('aid' in json)) {
            obj.aid = parseInt(json['aid']);
        }
        else {
            obj.aid = 0;
        }
        if (('name' in json)) {
            obj.name = String(json['name']);
        }
        else {
            obj.name = "";
        }
        if (('type' in json)) {
            obj.type = String(json['type']);
        }
        else {
            obj.type = "";
        }
        return obj;
    }
    else {
        return null;
    }
};
Attribute.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapAttribute(this, path);
};
Attribute.prototype.fold2 = function (inj, arg){
    return inj.fmap2Attribute(this, arg);
};
Attribute.unfold = function (coalg, input){
    var obj = coalg.unfoldAttribute(input);
    return obj;
};
function Value () {
}
Value.fromArgs = function (aid, value){
    var obj = new Value();
    obj.aid = parseInt(aid);
    obj.value = String(value);
    return obj;
};
Value.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Value";
    json['aid'] = this.aid;
    json['value'] = this.value;
    return json;
};
Value.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Value"))) {
        var obj = new Value();
        if (('aid' in json)) {
            obj.aid = pInt(json['aid']);
            if (isJSONERROR(obj.aid)) {
                return new JSONERROR("Value.aid", obj.aid);
            }
        }
        else {
            return new JSONERROR("Value fromJSON: missing key: aid");
        }
        if (('value' in json)) {
            obj.value = pString(json['value']);
            if (isJSONERROR(obj.value)) {
                return new JSONERROR("Value.value", obj.value);
            }
        }
        else {
            obj.value = "Hello World";
        }
        return obj;
    }
    else {
        return new JSONERROR(("Value " + json['constr']));
    }
};
Value.unsafeFromJSON = function (json){
    var obj = new Value();
    obj.aid = pUnsafe(json['aid']);
    obj.value = pUnsafe(json['value']);
    return obj;
};
Value.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Value();
        if (('aid' in json)) {
            obj.aid = parseInt(json['aid']);
        }
        else {
            obj.aid = 0;
        }
        if (('value' in json)) {
            obj.value = String(json['value']);
        }
        else {
            obj.value = "Hello World";
        }
        return obj;
    }
    else {
        return null;
    }
};
Value.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapValue(this, path);
};
Value.prototype.fold2 = function (inj, arg){
    return inj.fmap2Value(this, arg);
};
Value.unfold = function (coalg, input){
    var obj = coalg.unfoldValue(input);
    return obj;
};
function ANode () {
}
ANode.fromArgs = function (aid, weight){
    var obj = new ANode();
    obj.aid = parseInt(aid);
    obj.weight = parseFloat(weight);
    return obj;
};
ANode.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "ANode";
    json['aid'] = this.aid;
    json['weight'] = this.weight;
    return json;
};
ANode.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "ANode"))) {
        var obj = new ANode();
        if (('aid' in json)) {
            obj.aid = pInt(json['aid']);
            if (isJSONERROR(obj.aid)) {
                return new JSONERROR("ANode.aid", obj.aid);
            }
        }
        else {
            return new JSONERROR("ANode fromJSON: missing key: aid");
        }
        if (('weight' in json)) {
            obj.weight = pFloat(json['weight']);
            if (isJSONERROR(obj.weight)) {
                return new JSONERROR("ANode.weight", obj.weight);
            }
        }
        else {
            obj.weight = 0.5;
        }
        return obj;
    }
    else {
        return new JSONERROR(("ANode " + json['constr']));
    }
};
ANode.unsafeFromJSON = function (json){
    var obj = new ANode();
    obj.aid = pUnsafe(json['aid']);
    obj.weight = pUnsafe(json['weight']);
    return obj;
};
ANode.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new ANode();
        if (('aid' in json)) {
            obj.aid = parseInt(json['aid']);
        }
        else {
            obj.aid = 0;
        }
        if (('weight' in json)) {
            obj.weight = parseFloat(json['weight']);
        }
        else {
            obj.weight = 0.5;
        }
        return obj;
    }
    else {
        return null;
    }
};
ANode.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapANode(this, path);
};
ANode.prototype.fold2 = function (inj, arg){
    return inj.fmap2ANode(this, arg);
};
ANode.unfold = function (coalg, input){
    var obj = coalg.unfoldANode(input);
    return obj;
};
function RNode () {
}
RNode.fromArgs = function (name, weight){
    var obj = new RNode();
    obj.name = String(name);
    obj.weight = parseFloat(weight);
    obj.nodes = [];
    return obj;
};
RNode.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "RNode";
    json['name'] = this.name;
    json['weight'] = this.weight;
    json['nodes'] = this.nodes.map(function(obj){return obj.toJSON();});
    return json;
};
RNode.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "RNode"))) {
        var obj = new RNode();
        if (('name' in json)) {
            obj.name = pString(json['name']);
            if (isJSONERROR(obj.name)) {
                return new JSONERROR("RNode.name", obj.name);
            }
        }
        else {
            return new JSONERROR("RNode fromJSON: missing key: name");
        }
        if (('weight' in json)) {
            obj.weight = pFloat(json['weight']);
            if (isJSONERROR(obj.weight)) {
                return new JSONERROR("RNode.weight", obj.weight);
            }
        }
        else {
            return new JSONERROR("RNode fromJSON: missing key: weight");
        }
        if (('nodes' in json)) {
            obj.nodes = function(json){return pList(function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "ANode"))?(ANode.fromJSON(json)):(((json['constr'] == "RNode"))?(RNode.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr']))))):(new JSONERROR("Wrong Object"));}, json);}(json['nodes']);
            if (isJSONERROR(obj.nodes)) {
                return new JSONERROR("RNode.nodes", obj.nodes);
            }
        }
        else {
            return new JSONERROR("RNode fromJSON: missing key: nodes");
        }
        return obj;
    }
    else {
        return new JSONERROR(("RNode " + json['constr']));
    }
};
RNode.unsafeFromJSON = function (json){
    var obj = new RNode();
    obj.name = pUnsafe(json['name']);
    obj.weight = pUnsafe(json['weight']);
    obj.nodes = function(json){return pList(function(json){return ((json['constr'] == "ANode"))?(ANode.unsafeFromJSON(json)):(RNode.unsafeFromJSON(json));}, json);}(json['nodes']);
    return obj;
};
RNode.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new RNode();
        if (('name' in json)) {
            obj.name = String(json['name']);
        }
        else {
            obj.name = "";
        }
        if (('weight' in json)) {
            obj.weight = parseFloat(json['weight']);
        }
        else {
            obj.weight = 0.0;
        }
        if (('nodes' in json)) {
            obj.nodes = json['nodes'];
        }
        else {
            obj.nodes = [];
        }
        return obj;
    }
    else {
        return null;
    }
};
RNode.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapRNode(this, path);
};
RNode.prototype.fold2 = function (inj, arg){
    return inj.fmap2RNode(this, arg);
};
RNode.unfold = function (coalg, input){
    var obj = coalg.unfoldRNode(input);
    obj.nodes = obj.nodes.map(function(obj){obj = ANode.unfold(coalg, input);
if (obj) {
}
else {
    obj = RNode.unfold(coalg, input);
}
return obj;
});
    return obj;
};
function Testclass () {
}
Testclass.fromArgs = function (tid, name){
    var obj = new Testclass();
    obj.tid = parseInt(tid);
    obj.name = String(name);
    obj.nodes = [];
    obj.weights = pMap("aid", function(x){return x;}, []);
    return obj;
};
Testclass.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Testclass";
    json['tid'] = this.tid;
    json['name'] = this.name;
    json['nodes'] = this.nodes.map(function(obj){return obj.toJSON();});
    json['weights'] = mapToJSON(this.weights);
    return json;
};
Testclass.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Testclass"))) {
        var obj = new Testclass();
        if (('tid' in json)) {
            obj.tid = pInt(json['tid']);
            if (isJSONERROR(obj.tid)) {
                return new JSONERROR("Testclass.tid", obj.tid);
            }
        }
        else {
            return new JSONERROR("Testclass fromJSON: missing key: tid");
        }
        if (('name' in json)) {
            obj.name = pString(json['name']);
            if (isJSONERROR(obj.name)) {
                return new JSONERROR("Testclass.name", obj.name);
            }
        }
        else {
            return new JSONERROR("Testclass fromJSON: missing key: name");
        }
        if (('nodes' in json)) {
            obj.nodes = function(json){return pList(function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "ANode"))?(ANode.fromJSON(json)):(((json['constr'] == "RNode"))?(RNode.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr']))))):(new JSONERROR("Wrong Object"));}, json);}(json['nodes']);
            if (isJSONERROR(obj.nodes)) {
                return new JSONERROR("Testclass.nodes", obj.nodes);
            }
        }
        else {
            return new JSONERROR("Testclass fromJSON: missing key: nodes");
        }
        if (('weights' in json)) {
            obj.weights = function(json){return pMap("aid", ANode.fromJSON, json);}(json['weights']);
            if (isJSONERROR(obj.weights)) {
                return new JSONERROR("Testclass.weights", obj.weights);
            }
        }
        else {
            return new JSONERROR("Testclass fromJSON: missing key: weights");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Testclass " + json['constr']));
    }
};
Testclass.unsafeFromJSON = function (json){
    var obj = new Testclass();
    obj.tid = pUnsafe(json['tid']);
    obj.name = pUnsafe(json['name']);
    obj.nodes = function(json){return pList(function(json){return ((json['constr'] == "ANode"))?(ANode.unsafeFromJSON(json)):(RNode.unsafeFromJSON(json));}, json);}(json['nodes']);
    obj.weights = function(json){return pMap("aid", ANode.unsafeFromJSON, json);}(json['weights']);
    return obj;
};
Testclass.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Testclass();
        if (('tid' in json)) {
            obj.tid = parseInt(json['tid']);
        }
        else {
            obj.tid = 0;
        }
        if (('name' in json)) {
            obj.name = String(json['name']);
        }
        else {
            obj.name = "";
        }
        if (('nodes' in json)) {
            obj.nodes = json['nodes'];
        }
        else {
            obj.nodes = [];
        }
        if (('weights' in json)) {
            obj.weights = json['weights'];
        }
        else {
            obj.weights = pMap("aid", function(x){return x;}, {});
        }
        return obj;
    }
    else {
        return null;
    }
};
Testclass.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapTestclass(this, path);
};
Testclass.prototype.fold2 = function (inj, arg){
    return inj.fmap2Testclass(this, arg);
};
Testclass.unfold = function (coalg, input){
    var obj = coalg.unfoldTestclass(input);
    obj.nodes = obj.nodes.map(function(obj){obj = ANode.unfold(coalg, input);
if (obj) {
}
else {
    obj = RNode.unfold(coalg, input);
}
return obj;
});
    obj.weights = assoc_map_(function(input){return ANode.unfold(coalg, input);}, obj.weights);
    return obj;
};
function Project () {
}
Project.fromArgs = function (id, name){
    var obj = new Project();
    obj.id = parseInt(id);
    obj.name = String(name);
    obj.attributes = pMap("aid", function(x){return x;}, []);
    obj.products = pMap("pid", function(x){return x;}, []);
    obj.testclasses = pMap("tid", function(x){return x;}, []);
    obj.bla = [];
    return obj;
};
Project.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Project";
    json['id'] = this.id;
    json['name'] = this.name;
    json['attributes'] = mapToJSON(this.attributes);
    json['products'] = mapToJSON(this.products);
    json['testclasses'] = mapToJSON(this.testclasses);
    json['bla'] = this.bla.map(function(obj){return [obj[0], obj[1], mapToJSON(obj[2]), obj[3].toJSON()];});
    return json;
};
Project.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Project"))) {
        var obj = new Project();
        if (('id' in json)) {
            obj.id = pInt(json['id']);
            if (isJSONERROR(obj.id)) {
                return new JSONERROR("Project.id", obj.id);
            }
        }
        else {
            return new JSONERROR("Project fromJSON: missing key: id");
        }
        if (('name' in json)) {
            obj.name = pString(json['name']);
            if (isJSONERROR(obj.name)) {
                return new JSONERROR("Project.name", obj.name);
            }
        }
        else {
            obj.name = "foobaz \"haha\"!";
        }
        if (('attributes' in json)) {
            obj.attributes = function(json){return pMap("aid", Attribute.fromJSON, json);}(json['attributes']);
            if (isJSONERROR(obj.attributes)) {
                return new JSONERROR("Project.attributes", obj.attributes);
            }
        }
        else {
            return new JSONERROR("Project fromJSON: missing key: attributes");
        }
        if (('products' in json)) {
            obj.products = function(json){return pMap("pid", Product.fromJSON, json);}(json['products']);
            if (isJSONERROR(obj.products)) {
                return new JSONERROR("Project.products", obj.products);
            }
        }
        else {
            return new JSONERROR("Project fromJSON: missing key: products");
        }
        if (('testclasses' in json)) {
            obj.testclasses = function(json){return pMap("tid", Testclass.fromJSON, json);}(json['testclasses']);
            if (isJSONERROR(obj.testclasses)) {
                return new JSONERROR("Project.testclasses", obj.testclasses);
            }
        }
        else {
            return new JSONERROR("Project fromJSON: missing key: testclasses");
        }
        if (('bla' in json)) {
            obj.bla = function(json){return pList(function(json){return pTuple([function(json){return pInt(json);}, function(json){return pString(json);}, function(json){return function(json){return pMap("aid", Attribute.fromJSON, json);}(json);}, function(json){return function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Range"))?(Range.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr'])))):(new JSONERROR("Wrong Object"));}(json);}], json);}, json);}(json['bla']);
            if (isJSONERROR(obj.bla)) {
                return new JSONERROR("Project.bla", obj.bla);
            }
        }
        else {
            obj.bla = [];
        }
        return obj;
    }
    else {
        return new JSONERROR(("Project " + json['constr']));
    }
};
Project.unsafeFromJSON = function (json){
    var obj = new Project();
    obj.id = pUnsafe(json['id']);
    obj.name = pUnsafe(json['name']);
    obj.attributes = function(json){return pMap("aid", Attribute.unsafeFromJSON, json);}(json['attributes']);
    obj.products = function(json){return pMap("pid", Product.unsafeFromJSON, json);}(json['products']);
    obj.testclasses = function(json){return pMap("tid", Testclass.unsafeFromJSON, json);}(json['testclasses']);
    obj.bla = function(json){return pList(function(json){return pTuple([function(json){return pUnsafe(json);}, function(json){return pUnsafe(json);}, function(json){return function(json){return pMap("aid", Attribute.unsafeFromJSON, json);}(json);}, function(json){return function(json){return Range.unsafeFromJSON(json);}(json);}], json);}, json);}(json['bla']);
    return obj;
};
Project.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Project();
        if (('id' in json)) {
            obj.id = parseInt(json['id']);
        }
        else {
            obj.id = 0;
        }
        if (('name' in json)) {
            obj.name = String(json['name']);
        }
        else {
            obj.name = "foobaz \"haha\"!";
        }
        if (('attributes' in json)) {
            obj.attributes = json['attributes'];
        }
        else {
            obj.attributes = pMap("aid", function(x){return x;}, {});
        }
        if (('products' in json)) {
            obj.products = json['products'];
        }
        else {
            obj.products = pMap("pid", function(x){return x;}, {});
        }
        if (('testclasses' in json)) {
            obj.testclasses = json['testclasses'];
        }
        else {
            obj.testclasses = pMap("tid", function(x){return x;}, {});
        }
        if (('bla' in json)) {
            obj.bla = json['bla'];
        }
        else {
            obj.bla = [];
        }
        return obj;
    }
    else {
        return null;
    }
};
Project.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapProject(this, path);
};
Project.prototype.fold2 = function (inj, arg){
    return inj.fmap2Project(this, arg);
};
Project.unfold = function (coalg, input){
    var obj = coalg.unfoldProject(input);
    obj.attributes = assoc_map_(function(input){return Attribute.unfold(coalg, input);}, obj.attributes);
    obj.products = assoc_map_(function(input){return Product.unfold(coalg, input);}, obj.products);
    obj.testclasses = assoc_map_(function(input){return Testclass.unfold(coalg, input);}, obj.testclasses);
    obj.bla = obj.bla.map(function(obj){obj[2] = assoc_map_(function(input){return Attribute.unfold(coalg, input);}, obj[2]);
obj[3] = Range.unfold(coalg, input);
return obj;
});
    return obj;
};
function SavedSearch () {
}
SavedSearch.fromArgs = function (sid){
    var obj = new SavedSearch();
    obj.sid = parseInt(sid);
    obj.values = pMap("aid", function(x){return x;}, []);
    return obj;
};
SavedSearch.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "SavedSearch";
    json['sid'] = this.sid;
    json['values'] = mapToJSON(this.values);
    return json;
};
SavedSearch.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "SavedSearch"))) {
        var obj = new SavedSearch();
        if (('sid' in json)) {
            obj.sid = pInt(json['sid']);
            if (isJSONERROR(obj.sid)) {
                return new JSONERROR("SavedSearch.sid", obj.sid);
            }
        }
        else {
            return new JSONERROR("SavedSearch fromJSON: missing key: sid");
        }
        if (('values' in json)) {
            obj.values = function(json){return pMap("aid", Filter.fromJSON, json);}(json['values']);
            if (isJSONERROR(obj.values)) {
                return new JSONERROR("SavedSearch.values", obj.values);
            }
        }
        else {
            return new JSONERROR("SavedSearch fromJSON: missing key: values");
        }
        return obj;
    }
    else {
        return new JSONERROR(("SavedSearch " + json['constr']));
    }
};
SavedSearch.unsafeFromJSON = function (json){
    var obj = new SavedSearch();
    obj.sid = pUnsafe(json['sid']);
    obj.values = function(json){return pMap("aid", Filter.unsafeFromJSON, json);}(json['values']);
    return obj;
};
SavedSearch.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new SavedSearch();
        if (('sid' in json)) {
            obj.sid = parseInt(json['sid']);
        }
        else {
            obj.sid = 0;
        }
        if (('values' in json)) {
            obj.values = json['values'];
        }
        else {
            obj.values = pMap("aid", function(x){return x;}, {});
        }
        return obj;
    }
    else {
        return null;
    }
};
SavedSearch.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapSavedSearch(this, path);
};
SavedSearch.prototype.fold2 = function (inj, arg){
    return inj.fmap2SavedSearch(this, arg);
};
SavedSearch.unfold = function (coalg, input){
    var obj = coalg.unfoldSavedSearch(input);
    obj.values = assoc_map_(function(input){return Filter.unfold(coalg, input);}, obj.values);
    return obj;
};
function Filter () {
}
Filter.fromArgs = function (aid, predicate){
    var obj = new Filter();
    obj.aid = parseInt(aid);
    obj.predicate = predicate;
    return obj;
};
Filter.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Filter";
    json['aid'] = this.aid;
    json['predicate'] = this.predicate.toJSON();
    return json;
};
Filter.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Filter"))) {
        var obj = new Filter();
        if (('aid' in json)) {
            obj.aid = pInt(json['aid']);
            if (isJSONERROR(obj.aid)) {
                return new JSONERROR("Filter.aid", obj.aid);
            }
        }
        else {
            return new JSONERROR("Filter fromJSON: missing key: aid");
        }
        if (('predicate' in json)) {
            obj.predicate = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Range"))?(Range.fromJSON(json)):(((json['constr'] == "Elems"))?(Elems.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr']))))):(new JSONERROR("Wrong Object"));}(json['predicate']);
            if (isJSONERROR(obj.predicate)) {
                return new JSONERROR("Filter.predicate", obj.predicate);
            }
        }
        else {
            return new JSONERROR("Filter fromJSON: missing key: predicate");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Filter " + json['constr']));
    }
};
Filter.unsafeFromJSON = function (json){
    var obj = new Filter();
    obj.aid = pUnsafe(json['aid']);
    obj.predicate = function(json){return ((json['constr'] == "Range"))?(Range.unsafeFromJSON(json)):(Elems.unsafeFromJSON(json));}(json['predicate']);
    return obj;
};
Filter.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Filter();
        if (('aid' in json)) {
            obj.aid = parseInt(json['aid']);
        }
        else {
            obj.aid = 0;
        }
        if (('predicate' in json)) {
            obj.predicate = json['predicate'];
        }
        else {
            obj.predicate = null;
        }
        return obj;
    }
    else {
        return null;
    }
};
Filter.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapFilter(this, path);
};
Filter.prototype.fold2 = function (inj, arg){
    return inj.fmap2Filter(this, arg);
};
Filter.unfold = function (coalg, input){
    var obj = coalg.unfoldFilter(input);
    obj.predicate = Range.unfold(coalg, input);
    if (obj.predicate) {
    }
    else {
        obj.predicate = Elems.unfold(coalg, input);
    }
    return obj;
};
function Range () {
}
Range.fromArgs = function (min, max){
    var obj = new Range();
    obj.min = parseInt(min);
    obj.max = parseInt(max);
    return obj;
};
Range.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Range";
    json['min'] = this.min;
    json['max'] = this.max;
    return json;
};
Range.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Range"))) {
        var obj = new Range();
        if (('min' in json)) {
            obj.min = pInt(json['min']);
            if (isJSONERROR(obj.min)) {
                return new JSONERROR("Range.min", obj.min);
            }
        }
        else {
            return new JSONERROR("Range fromJSON: missing key: min");
        }
        if (('max' in json)) {
            obj.max = pInt(json['max']);
            if (isJSONERROR(obj.max)) {
                return new JSONERROR("Range.max", obj.max);
            }
        }
        else {
            return new JSONERROR("Range fromJSON: missing key: max");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Range " + json['constr']));
    }
};
Range.unsafeFromJSON = function (json){
    var obj = new Range();
    obj.min = pUnsafe(json['min']);
    obj.max = pUnsafe(json['max']);
    return obj;
};
Range.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Range();
        if (('min' in json)) {
            obj.min = parseInt(json['min']);
        }
        else {
            obj.min = 0;
        }
        if (('max' in json)) {
            obj.max = parseInt(json['max']);
        }
        else {
            obj.max = 0;
        }
        return obj;
    }
    else {
        return null;
    }
};
Range.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapRange(this, path);
};
Range.prototype.fold2 = function (inj, arg){
    return inj.fmap2Range(this, arg);
};
Range.unfold = function (coalg, input){
    var obj = coalg.unfoldRange(input);
    return obj;
};
function Elems () {
}
Elems.fromArgs = function (){
    var obj = new Elems();
    obj.values = [];
    return obj;
};
Elems.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Elems";
    json['values'] = this.values.map(function(obj){return obj;});
    return json;
};
Elems.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Elems"))) {
        var obj = new Elems();
        if (('values' in json)) {
            obj.values = function(json){return pList(pString, json);}(json['values']);
            if (isJSONERROR(obj.values)) {
                return new JSONERROR("Elems.values", obj.values);
            }
        }
        else {
            return new JSONERROR("Elems fromJSON: missing key: values");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Elems " + json['constr']));
    }
};
Elems.unsafeFromJSON = function (json){
    var obj = new Elems();
    obj.values = function(json){return pList(pUnsafe, json);}(json['values']);
    return obj;
};
Elems.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Elems();
        if (('values' in json)) {
            obj.values = json['values'];
        }
        else {
            obj.values = [];
        }
        return obj;
    }
    else {
        return null;
    }
};
Elems.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapElems(this, path);
};
Elems.prototype.fold2 = function (inj, arg){
    return inj.fmap2Elems(this, arg);
};
Elems.unfold = function (coalg, input){
    var obj = coalg.unfoldElems(input);
    obj.values = obj.values.map(function(obj){return obj;});
    return obj;
};
function Filterset () {
}
Filterset.fromArgs = function (fsid, name){
    var obj = new Filterset();
    obj.fsid = parseInt(fsid);
    obj.name = String(name);
    obj.widgets = pMap("aid", function(x){return x;}, []);
    return obj;
};
Filterset.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Filterset";
    json['fsid'] = this.fsid;
    json['name'] = this.name;
    json['widgets'] = mapToJSON(this.widgets);
    return json;
};
Filterset.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Filterset"))) {
        var obj = new Filterset();
        if (('fsid' in json)) {
            obj.fsid = pInt(json['fsid']);
            if (isJSONERROR(obj.fsid)) {
                return new JSONERROR("Filterset.fsid", obj.fsid);
            }
        }
        else {
            return new JSONERROR("Filterset fromJSON: missing key: fsid");
        }
        if (('name' in json)) {
            obj.name = pString(json['name']);
            if (isJSONERROR(obj.name)) {
                return new JSONERROR("Filterset.name", obj.name);
            }
        }
        else {
            return new JSONERROR("Filterset fromJSON: missing key: name");
        }
        if (('widgets' in json)) {
            obj.widgets = function(json){return pMap("aid", Widget.fromJSON, json);}(json['widgets']);
            if (isJSONERROR(obj.widgets)) {
                return new JSONERROR("Filterset.widgets", obj.widgets);
            }
        }
        else {
            return new JSONERROR("Filterset fromJSON: missing key: widgets");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Filterset " + json['constr']));
    }
};
Filterset.unsafeFromJSON = function (json){
    var obj = new Filterset();
    obj.fsid = pUnsafe(json['fsid']);
    obj.name = pUnsafe(json['name']);
    obj.widgets = function(json){return pMap("aid", Widget.unsafeFromJSON, json);}(json['widgets']);
    return obj;
};
Filterset.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Filterset();
        if (('fsid' in json)) {
            obj.fsid = parseInt(json['fsid']);
        }
        else {
            obj.fsid = 0;
        }
        if (('name' in json)) {
            obj.name = String(json['name']);
        }
        else {
            obj.name = "";
        }
        if (('widgets' in json)) {
            obj.widgets = json['widgets'];
        }
        else {
            obj.widgets = pMap("aid", function(x){return x;}, {});
        }
        return obj;
    }
    else {
        return null;
    }
};
Filterset.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapFilterset(this, path);
};
Filterset.prototype.fold2 = function (inj, arg){
    return inj.fmap2Filterset(this, arg);
};
Filterset.unfold = function (coalg, input){
    var obj = coalg.unfoldFilterset(input);
    obj.widgets = assoc_map_(function(input){return Widget.unfold(coalg, input);}, obj.widgets);
    return obj;
};
function Widget () {
}
Widget.fromArgs = function (aid, widget, info){
    var obj = new Widget();
    obj.aid = parseInt(aid);
    obj.widget = widget;
    obj.info = String(info);
    return obj;
};
Widget.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Widget";
    json['aid'] = this.aid;
    json['widget'] = this.widget.toJSON();
    json['info'] = this.info;
    return json;
};
Widget.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Widget"))) {
        var obj = new Widget();
        if (('aid' in json)) {
            obj.aid = pInt(json['aid']);
            if (isJSONERROR(obj.aid)) {
                return new JSONERROR("Widget.aid", obj.aid);
            }
        }
        else {
            return new JSONERROR("Widget fromJSON: missing key: aid");
        }
        if (('widget' in json)) {
            obj.widget = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "RangeSlider"))?(RangeSlider.fromJSON(json)):(((json['constr'] == "Range"))?(Range.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr']))))):(new JSONERROR("Wrong Object"));}(json['widget']);
            if (isJSONERROR(obj.widget)) {
                return new JSONERROR("Widget.widget", obj.widget);
            }
        }
        else {
            return new JSONERROR("Widget fromJSON: missing key: widget");
        }
        if (('info' in json)) {
            obj.info = pString(json['info']);
            if (isJSONERROR(obj.info)) {
                return new JSONERROR("Widget.info", obj.info);
            }
        }
        else {
            return new JSONERROR("Widget fromJSON: missing key: info");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Widget " + json['constr']));
    }
};
Widget.unsafeFromJSON = function (json){
    var obj = new Widget();
    obj.aid = pUnsafe(json['aid']);
    obj.widget = function(json){return ((json['constr'] == "RangeSlider"))?(RangeSlider.unsafeFromJSON(json)):(Range.unsafeFromJSON(json));}(json['widget']);
    obj.info = pUnsafe(json['info']);
    return obj;
};
Widget.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Widget();
        if (('aid' in json)) {
            obj.aid = parseInt(json['aid']);
        }
        else {
            obj.aid = 0;
        }
        if (('widget' in json)) {
            obj.widget = json['widget'];
        }
        else {
            obj.widget = null;
        }
        if (('info' in json)) {
            obj.info = String(json['info']);
        }
        else {
            obj.info = "";
        }
        return obj;
    }
    else {
        return null;
    }
};
Widget.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapWidget(this, path);
};
Widget.prototype.fold2 = function (inj, arg){
    return inj.fmap2Widget(this, arg);
};
Widget.unfold = function (coalg, input){
    var obj = coalg.unfoldWidget(input);
    obj.widget = RangeSlider.unfold(coalg, input);
    if (obj.widget) {
    }
    else {
        obj.widget = Range.unfold(coalg, input);
    }
    return obj;
};
function RangeSlider () {
}
RangeSlider.fromArgs = function (min, max, value1, value2){
    var obj = new RangeSlider();
    obj.min = parseInt(min);
    obj.max = parseInt(max);
    obj.value1 = parseInt(value1);
    obj.value2 = parseInt(value2);
    return obj;
};
RangeSlider.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "RangeSlider";
    json['min'] = this.min;
    json['max'] = this.max;
    json['value1'] = this.value1;
    json['value2'] = this.value2;
    return json;
};
RangeSlider.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "RangeSlider"))) {
        var obj = new RangeSlider();
        if (('min' in json)) {
            obj.min = pInt(json['min']);
            if (isJSONERROR(obj.min)) {
                return new JSONERROR("RangeSlider.min", obj.min);
            }
        }
        else {
            return new JSONERROR("RangeSlider fromJSON: missing key: min");
        }
        if (('max' in json)) {
            obj.max = pInt(json['max']);
            if (isJSONERROR(obj.max)) {
                return new JSONERROR("RangeSlider.max", obj.max);
            }
        }
        else {
            return new JSONERROR("RangeSlider fromJSON: missing key: max");
        }
        if (('value1' in json)) {
            obj.value1 = pInt(json['value1']);
            if (isJSONERROR(obj.value1)) {
                return new JSONERROR("RangeSlider.value1", obj.value1);
            }
        }
        else {
            return new JSONERROR("RangeSlider fromJSON: missing key: value1");
        }
        if (('value2' in json)) {
            obj.value2 = pInt(json['value2']);
            if (isJSONERROR(obj.value2)) {
                return new JSONERROR("RangeSlider.value2", obj.value2);
            }
        }
        else {
            return new JSONERROR("RangeSlider fromJSON: missing key: value2");
        }
        return obj;
    }
    else {
        return new JSONERROR(("RangeSlider " + json['constr']));
    }
};
RangeSlider.unsafeFromJSON = function (json){
    var obj = new RangeSlider();
    obj.min = pUnsafe(json['min']);
    obj.max = pUnsafe(json['max']);
    obj.value1 = pUnsafe(json['value1']);
    obj.value2 = pUnsafe(json['value2']);
    return obj;
};
RangeSlider.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new RangeSlider();
        if (('min' in json)) {
            obj.min = parseInt(json['min']);
        }
        else {
            obj.min = 0;
        }
        if (('max' in json)) {
            obj.max = parseInt(json['max']);
        }
        else {
            obj.max = 0;
        }
        if (('value1' in json)) {
            obj.value1 = parseInt(json['value1']);
        }
        else {
            obj.value1 = 0;
        }
        if (('value2' in json)) {
            obj.value2 = parseInt(json['value2']);
        }
        else {
            obj.value2 = 0;
        }
        return obj;
    }
    else {
        return null;
    }
};
RangeSlider.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapRangeSlider(this, path);
};
RangeSlider.prototype.fold2 = function (inj, arg){
    return inj.fmap2RangeSlider(this, arg);
};
RangeSlider.unfold = function (coalg, input){
    var obj = coalg.unfoldRangeSlider(input);
    return obj;
};
function F_Foo () {
    this.keyorder = {};
}
F_Foo.prototype.fmapProduct = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var pid = obj.pid;
    var name = obj.name;
    var values = assoc_map_(function(obj){return obj.fold(inj, path2);}, obj.values);
    this.path = path;
    return this.foldProduct(pid, name, values);
};
F_Foo.prototype.fmapAttribute = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var aid = obj.aid;
    var name = obj.name;
    var type = obj.type;
    this.path = path;
    return this.foldAttribute(aid, name, type);
};
F_Foo.prototype.fmapValue = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var aid = obj.aid;
    var value = obj.value;
    this.path = path;
    return this.foldValue(aid, value);
};
F_Foo.prototype.fmapANode = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var aid = obj.aid;
    var weight = obj.weight;
    this.path = path;
    return this.foldANode(aid, weight);
};
F_Foo.prototype.fmapRNode = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var name = obj.name;
    var weight = obj.weight;
    var nodes = obj.nodes.map(function(obj){return obj.fold(inj, path2);});
    this.path = path;
    return this.foldRNode(name, weight, nodes);
};
F_Foo.prototype.fmapTestclass = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var tid = obj.tid;
    var name = obj.name;
    var nodes = obj.nodes.map(function(obj){return obj.fold(inj, path2);});
    var weights = assoc_map_(function(obj){return obj.fold(inj, path2);}, obj.weights);
    this.path = path;
    return this.foldTestclass(tid, name, nodes, weights);
};
F_Foo.prototype.fmapProject = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var id = obj.id;
    var name = obj.name;
    var attributes = assoc_map_(function(obj){return obj.fold(inj, path2);}, obj.attributes);
    var products = assoc_map_(function(obj){return obj.fold(inj, path2);}, obj.products);
    var testclasses = assoc_map_(function(obj){return obj.fold(inj, path2);}, obj.testclasses);
    var bla = obj.bla.map(function(obj){return [obj[0], obj[1], assoc_map_(function(obj){return obj.fold(inj, path2);}, obj[2]), obj[3].fold(inj, path2)];});
    this.path = path;
    return this.foldProject(id, name, attributes, products, testclasses, bla);
};
F_Foo.prototype.fmapSavedSearch = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var sid = obj.sid;
    var values = assoc_map_(function(obj){return obj.fold(inj, path2);}, obj.values);
    this.path = path;
    return this.foldSavedSearch(sid, values);
};
F_Foo.prototype.fmapFilter = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var aid = obj.aid;
    var predicate = obj.predicate.fold(inj, path2);
    this.path = path;
    return this.foldFilter(aid, predicate);
};
F_Foo.prototype.fmapRange = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var min = obj.min;
    var max = obj.max;
    this.path = path;
    return this.foldRange(min, max);
};
F_Foo.prototype.fmapElems = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var values = obj.values.map(function(obj){return obj;});
    this.path = path;
    return this.foldElems(values);
};
F_Foo.prototype.fmapFilterset = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var fsid = obj.fsid;
    var name = obj.name;
    var widgets = assoc_map_(function(obj){return obj.fold(inj, path2);}, obj.widgets);
    this.path = path;
    return this.foldFilterset(fsid, name, widgets);
};
F_Foo.prototype.fmapWidget = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var aid = obj.aid;
    var widget = obj.widget.fold(inj, path2);
    var info = obj.info;
    this.path = path;
    return this.foldWidget(aid, widget, info);
};
F_Foo.prototype.fmapRangeSlider = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var min = obj.min;
    var max = obj.max;
    var value1 = obj.value1;
    var value2 = obj.value2;
    this.path = path;
    return this.foldRangeSlider(min, max, value1, value2);
};
F_Foo.prototype.fmap2Product = function (obj, arg){
    var inj = this;
    assoc_map_(function(obj){obj.fold2(inj, arg);}, obj.values);
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2Attribute = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2Value = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2ANode = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2RNode = function (obj, arg){
    var inj = this;
    obj.nodes.map(function(obj){obj.fold2(inj, arg);});
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2Testclass = function (obj, arg){
    var inj = this;
    obj.nodes.map(function(obj){obj.fold2(inj, arg);});
    assoc_map_(function(obj){obj.fold2(inj, arg);}, obj.weights);
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2Project = function (obj, arg){
    var inj = this;
    assoc_map_(function(obj){obj.fold2(inj, arg);}, obj.attributes);
    assoc_map_(function(obj){obj.fold2(inj, arg);}, obj.products);
    assoc_map_(function(obj){obj.fold2(inj, arg);}, obj.testclasses);
    obj.bla.map(function(obj){assoc_map_(function(obj){obj.fold2(inj, arg);}, obj[2]);
obj[3].fold2(inj, arg);
});
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2SavedSearch = function (obj, arg){
    var inj = this;
    assoc_map_(function(obj){obj.fold2(inj, arg);}, obj.values);
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2Filter = function (obj, arg){
    var inj = this;
    obj.predicate.fold2(inj, arg);
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2Range = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2Elems = function (obj, arg){
    var inj = this;
    obj.values.map(function(obj){});
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2Filterset = function (obj, arg){
    var inj = this;
    assoc_map_(function(obj){obj.fold2(inj, arg);}, obj.widgets);
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2Widget = function (obj, arg){
    var inj = this;
    obj.widget.fold2(inj, arg);
    this.fold2(obj, arg);
    return null;
};
F_Foo.prototype.fmap2RangeSlider = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
