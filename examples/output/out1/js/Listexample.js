function Nil () {
}
Nil.fromArgs = function (){
    var obj = new Nil();
    return obj;
};
Nil.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Nil";
    return json;
};
Nil.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Nil"))) {
        var obj = new Nil();
        return obj;
    }
    else {
        return new JSONERROR(("Nil " + json['constr']));
    }
};
Nil.unsafeFromJSON = function (json){
    var obj = new Nil();
    return obj;
};
Nil.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Nil();
        return obj;
    }
    else {
        return null;
    }
};
Nil.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapNil(this, path);
};
Nil.prototype.fold2 = function (inj, arg){
    return inj.fmap2Nil(this, arg);
};
Nil.unfold = function (coalg, input){
    var obj = coalg.unfoldNil(input);
    return obj;
};
function Cons () {
}
Cons.fromArgs = function (head, tail){
    var obj = new Cons();
    obj.head = parseInt(head);
    obj.tail = tail;
    return obj;
};
Cons.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Cons";
    json['head'] = this.head;
    json['tail'] = this.tail.toJSON();
    return json;
};
Cons.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Cons"))) {
        var obj = new Cons();
        if (('head' in json)) {
            obj.head = pInt(json['head']);
            if (isJSONERROR(obj.head)) {
                return new JSONERROR("Cons.head", obj.head);
            }
        }
        else {
            return new JSONERROR("Cons fromJSON: missing key: head");
        }
        if (('tail' in json)) {
            obj.tail = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Nil"))?(Nil.fromJSON(json)):(((json['constr'] == "Cons"))?(Cons.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr']))))):(new JSONERROR("Wrong Object"));}(json['tail']);
            if (isJSONERROR(obj.tail)) {
                return new JSONERROR("Cons.tail", obj.tail);
            }
        }
        else {
            return new JSONERROR("Cons fromJSON: missing key: tail");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Cons " + json['constr']));
    }
};
Cons.unsafeFromJSON = function (json){
    var obj = new Cons();
    obj.head = pUnsafe(json['head']);
    obj.tail = function(json){return ((json['constr'] == "Nil"))?(Nil.unsafeFromJSON(json)):(Cons.unsafeFromJSON(json));}(json['tail']);
    return obj;
};
Cons.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Cons();
        if (('head' in json)) {
            obj.head = parseInt(json['head']);
        }
        else {
            obj.head = 0;
        }
        if (('tail' in json)) {
            obj.tail = json['tail'];
        }
        else {
            obj.tail = null;
        }
        return obj;
    }
    else {
        return null;
    }
};
Cons.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapCons(this, path);
};
Cons.prototype.fold2 = function (inj, arg){
    return inj.fmap2Cons(this, arg);
};
Cons.unfold = function (coalg, input){
    var obj = coalg.unfoldCons(input);
    obj.tail = Nil.unfold(coalg, input);
    if (obj.tail) {
    }
    else {
        obj.tail = Cons.unfold(coalg, input);
    }
    return obj;
};
function Foo () {
}
Foo.fromArgs = function (list1, list2, info){
    var obj = new Foo();
    obj.list1 = list1;
    obj.list2 = list2;
    obj.info = String(info);
    return obj;
};
Foo.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Foo";
    json['list1'] = this.list1.toJSON();
    json['list2'] = this.list2.toJSON();
    json['info'] = this.info;
    return json;
};
Foo.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Foo"))) {
        var obj = new Foo();
        if (('list1' in json)) {
            obj.list1 = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Nil"))?(Nil.fromJSON(json)):(((json['constr'] == "Cons"))?(Cons.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr']))))):(new JSONERROR("Wrong Object"));}(json['list1']);
            if (isJSONERROR(obj.list1)) {
                return new JSONERROR("Foo.list1", obj.list1);
            }
        }
        else {
            return new JSONERROR("Foo fromJSON: missing key: list1");
        }
        if (('list2' in json)) {
            obj.list2 = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Nil"))?(Nil.fromJSON(json)):(((json['constr'] == "Cons"))?(Cons.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr']))))):(new JSONERROR("Wrong Object"));}(json['list2']);
            if (isJSONERROR(obj.list2)) {
                return new JSONERROR("Foo.list2", obj.list2);
            }
        }
        else {
            return new JSONERROR("Foo fromJSON: missing key: list2");
        }
        if (('info' in json)) {
            obj.info = pString(json['info']);
            if (isJSONERROR(obj.info)) {
                return new JSONERROR("Foo.info", obj.info);
            }
        }
        else {
            return new JSONERROR("Foo fromJSON: missing key: info");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Foo " + json['constr']));
    }
};
Foo.unsafeFromJSON = function (json){
    var obj = new Foo();
    obj.list1 = function(json){return ((json['constr'] == "Nil"))?(Nil.unsafeFromJSON(json)):(Cons.unsafeFromJSON(json));}(json['list1']);
    obj.list2 = function(json){return ((json['constr'] == "Nil"))?(Nil.unsafeFromJSON(json)):(Cons.unsafeFromJSON(json));}(json['list2']);
    obj.info = pUnsafe(json['info']);
    return obj;
};
Foo.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Foo();
        if (('list1' in json)) {
            obj.list1 = json['list1'];
        }
        else {
            obj.list1 = null;
        }
        if (('list2' in json)) {
            obj.list2 = json['list2'];
        }
        else {
            obj.list2 = null;
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
Foo.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapFoo(this, path);
};
Foo.prototype.fold2 = function (inj, arg){
    return inj.fmap2Foo(this, arg);
};
Foo.unfold = function (coalg, input){
    var obj = coalg.unfoldFoo(input);
    obj.list1 = Nil.unfold(coalg, input);
    if (obj.list1) {
    }
    else {
        obj.list1 = Cons.unfold(coalg, input);
    }
    obj.list2 = Nil.unfold(coalg, input);
    if (obj.list2) {
    }
    else {
        obj.list2 = Cons.unfold(coalg, input);
    }
    return obj;
};
function F_Listexample () {
    this.keyorder = {};
}
F_Listexample.prototype.fmapNil = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldNil();
};
F_Listexample.prototype.fmapCons = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var head = obj.head;
    var tail = obj.tail.fold(inj, path2);
    this.path = path;
    return this.foldCons(head, tail);
};
F_Listexample.prototype.fmapFoo = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var list1 = obj.list1.fold(inj, path2);
    var list2 = obj.list2.fold(inj, path2);
    var info = obj.info;
    this.path = path;
    return this.foldFoo(list1, list2, info);
};
F_Listexample.prototype.fmap2Nil = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_Listexample.prototype.fmap2Cons = function (obj, arg){
    var inj = this;
    obj.tail.fold2(inj, arg);
    this.fold2(obj, arg);
    return null;
};
F_Listexample.prototype.fmap2Foo = function (obj, arg){
    var inj = this;
    obj.list1.fold2(inj, arg);
    obj.list2.fold2(inj, arg);
    this.fold2(obj, arg);
    return null;
};
