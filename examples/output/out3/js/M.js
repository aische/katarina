function Add () {
}
Add.fromArgs = function (x, y){
    var obj = new Add();
    obj.x = x;
    obj.y = y;
    return obj;
};
Add.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Add";
    json['x'] = this.x.toJSON();
    json['y'] = this.y.toJSON();
    return json;
};
Add.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Add"))) {
        var obj = new Add();
        if (('x' in json)) {
            obj.x = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Add"))?(Add.fromJSON(json)):(((json['constr'] == "Mul"))?(Mul.fromJSON(json)):(((json['constr'] == "Sub"))?(Sub.fromJSON(json)):(((json['constr'] == "Div"))?(Div.fromJSON(json)):(((json['constr'] == "Num"))?(Num.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr'])))))))):(new JSONERROR("Wrong Object"));}(json['x']);
            if (isJSONERROR(obj.x)) {
                return new JSONERROR("Add.x", obj.x);
            }
        }
        else {
            return new JSONERROR("Add fromJSON: missing key: x");
        }
        if (('y' in json)) {
            obj.y = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Add"))?(Add.fromJSON(json)):(((json['constr'] == "Mul"))?(Mul.fromJSON(json)):(((json['constr'] == "Sub"))?(Sub.fromJSON(json)):(((json['constr'] == "Div"))?(Div.fromJSON(json)):(((json['constr'] == "Num"))?(Num.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr'])))))))):(new JSONERROR("Wrong Object"));}(json['y']);
            if (isJSONERROR(obj.y)) {
                return new JSONERROR("Add.y", obj.y);
            }
        }
        else {
            return new JSONERROR("Add fromJSON: missing key: y");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Add " + json['constr']));
    }
};
Add.unsafeFromJSON = function (json){
    var obj = new Add();
    obj.x = function(json){return ((json['constr'] == "Add"))?(Add.unsafeFromJSON(json)):(((json['constr'] == "Mul"))?(Mul.unsafeFromJSON(json)):(((json['constr'] == "Sub"))?(Sub.unsafeFromJSON(json)):(((json['constr'] == "Div"))?(Div.unsafeFromJSON(json)):(Num.unsafeFromJSON(json)))));}(json['x']);
    obj.y = function(json){return ((json['constr'] == "Add"))?(Add.unsafeFromJSON(json)):(((json['constr'] == "Mul"))?(Mul.unsafeFromJSON(json)):(((json['constr'] == "Sub"))?(Sub.unsafeFromJSON(json)):(((json['constr'] == "Div"))?(Div.unsafeFromJSON(json)):(Num.unsafeFromJSON(json)))));}(json['y']);
    return obj;
};
Add.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Add();
        if (('x' in json)) {
            obj.x = json['x'];
        }
        else {
            obj.x = null;
        }
        if (('y' in json)) {
            obj.y = json['y'];
        }
        else {
            obj.y = null;
        }
        return obj;
    }
    else {
        return null;
    }
};
Add.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapAdd(this, path);
};
Add.prototype.fold2 = function (inj, arg){
    return inj.fmap2Add(this, arg);
};
Add.unfold = function (coalg, input){
    var obj = coalg.unfoldAdd(input);
    obj.x = Add.unfold(coalg, input);
    if (obj.x) {
    }
    else {
        obj.x = Mul.unfold(coalg, input);
        if (obj.x) {
        }
        else {
            obj.x = Sub.unfold(coalg, input);
            if (obj.x) {
            }
            else {
                obj.x = Div.unfold(coalg, input);
                if (obj.x) {
                }
                else {
                    obj.x = Num.unfold(coalg, input);
                }
            }
        }
    }
    obj.y = Add.unfold(coalg, input);
    if (obj.y) {
    }
    else {
        obj.y = Mul.unfold(coalg, input);
        if (obj.y) {
        }
        else {
            obj.y = Sub.unfold(coalg, input);
            if (obj.y) {
            }
            else {
                obj.y = Div.unfold(coalg, input);
                if (obj.y) {
                }
                else {
                    obj.y = Num.unfold(coalg, input);
                }
            }
        }
    }
    return obj;
};
function Mul () {
}
Mul.fromArgs = function (x, y){
    var obj = new Mul();
    obj.x = x;
    obj.y = y;
    return obj;
};
Mul.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Mul";
    json['x'] = this.x.toJSON();
    json['y'] = this.y.toJSON();
    return json;
};
Mul.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Mul"))) {
        var obj = new Mul();
        if (('x' in json)) {
            obj.x = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Add"))?(Add.fromJSON(json)):(((json['constr'] == "Mul"))?(Mul.fromJSON(json)):(((json['constr'] == "Sub"))?(Sub.fromJSON(json)):(((json['constr'] == "Div"))?(Div.fromJSON(json)):(((json['constr'] == "Num"))?(Num.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr'])))))))):(new JSONERROR("Wrong Object"));}(json['x']);
            if (isJSONERROR(obj.x)) {
                return new JSONERROR("Mul.x", obj.x);
            }
        }
        else {
            return new JSONERROR("Mul fromJSON: missing key: x");
        }
        if (('y' in json)) {
            obj.y = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Add"))?(Add.fromJSON(json)):(((json['constr'] == "Mul"))?(Mul.fromJSON(json)):(((json['constr'] == "Sub"))?(Sub.fromJSON(json)):(((json['constr'] == "Div"))?(Div.fromJSON(json)):(((json['constr'] == "Num"))?(Num.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr'])))))))):(new JSONERROR("Wrong Object"));}(json['y']);
            if (isJSONERROR(obj.y)) {
                return new JSONERROR("Mul.y", obj.y);
            }
        }
        else {
            return new JSONERROR("Mul fromJSON: missing key: y");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Mul " + json['constr']));
    }
};
Mul.unsafeFromJSON = function (json){
    var obj = new Mul();
    obj.x = function(json){return ((json['constr'] == "Add"))?(Add.unsafeFromJSON(json)):(((json['constr'] == "Mul"))?(Mul.unsafeFromJSON(json)):(((json['constr'] == "Sub"))?(Sub.unsafeFromJSON(json)):(((json['constr'] == "Div"))?(Div.unsafeFromJSON(json)):(Num.unsafeFromJSON(json)))));}(json['x']);
    obj.y = function(json){return ((json['constr'] == "Add"))?(Add.unsafeFromJSON(json)):(((json['constr'] == "Mul"))?(Mul.unsafeFromJSON(json)):(((json['constr'] == "Sub"))?(Sub.unsafeFromJSON(json)):(((json['constr'] == "Div"))?(Div.unsafeFromJSON(json)):(Num.unsafeFromJSON(json)))));}(json['y']);
    return obj;
};
Mul.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Mul();
        if (('x' in json)) {
            obj.x = json['x'];
        }
        else {
            obj.x = null;
        }
        if (('y' in json)) {
            obj.y = json['y'];
        }
        else {
            obj.y = null;
        }
        return obj;
    }
    else {
        return null;
    }
};
Mul.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapMul(this, path);
};
Mul.prototype.fold2 = function (inj, arg){
    return inj.fmap2Mul(this, arg);
};
Mul.unfold = function (coalg, input){
    var obj = coalg.unfoldMul(input);
    obj.x = Add.unfold(coalg, input);
    if (obj.x) {
    }
    else {
        obj.x = Mul.unfold(coalg, input);
        if (obj.x) {
        }
        else {
            obj.x = Sub.unfold(coalg, input);
            if (obj.x) {
            }
            else {
                obj.x = Div.unfold(coalg, input);
                if (obj.x) {
                }
                else {
                    obj.x = Num.unfold(coalg, input);
                }
            }
        }
    }
    obj.y = Add.unfold(coalg, input);
    if (obj.y) {
    }
    else {
        obj.y = Mul.unfold(coalg, input);
        if (obj.y) {
        }
        else {
            obj.y = Sub.unfold(coalg, input);
            if (obj.y) {
            }
            else {
                obj.y = Div.unfold(coalg, input);
                if (obj.y) {
                }
                else {
                    obj.y = Num.unfold(coalg, input);
                }
            }
        }
    }
    return obj;
};
function Div () {
}
Div.fromArgs = function (x, y){
    var obj = new Div();
    obj.x = x;
    obj.y = y;
    return obj;
};
Div.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Div";
    json['x'] = this.x.toJSON();
    json['y'] = this.y.toJSON();
    return json;
};
Div.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Div"))) {
        var obj = new Div();
        if (('x' in json)) {
            obj.x = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Add"))?(Add.fromJSON(json)):(((json['constr'] == "Mul"))?(Mul.fromJSON(json)):(((json['constr'] == "Sub"))?(Sub.fromJSON(json)):(((json['constr'] == "Div"))?(Div.fromJSON(json)):(((json['constr'] == "Num"))?(Num.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr'])))))))):(new JSONERROR("Wrong Object"));}(json['x']);
            if (isJSONERROR(obj.x)) {
                return new JSONERROR("Div.x", obj.x);
            }
        }
        else {
            return new JSONERROR("Div fromJSON: missing key: x");
        }
        if (('y' in json)) {
            obj.y = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Add"))?(Add.fromJSON(json)):(((json['constr'] == "Mul"))?(Mul.fromJSON(json)):(((json['constr'] == "Sub"))?(Sub.fromJSON(json)):(((json['constr'] == "Div"))?(Div.fromJSON(json)):(((json['constr'] == "Num"))?(Num.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr'])))))))):(new JSONERROR("Wrong Object"));}(json['y']);
            if (isJSONERROR(obj.y)) {
                return new JSONERROR("Div.y", obj.y);
            }
        }
        else {
            return new JSONERROR("Div fromJSON: missing key: y");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Div " + json['constr']));
    }
};
Div.unsafeFromJSON = function (json){
    var obj = new Div();
    obj.x = function(json){return ((json['constr'] == "Add"))?(Add.unsafeFromJSON(json)):(((json['constr'] == "Mul"))?(Mul.unsafeFromJSON(json)):(((json['constr'] == "Sub"))?(Sub.unsafeFromJSON(json)):(((json['constr'] == "Div"))?(Div.unsafeFromJSON(json)):(Num.unsafeFromJSON(json)))));}(json['x']);
    obj.y = function(json){return ((json['constr'] == "Add"))?(Add.unsafeFromJSON(json)):(((json['constr'] == "Mul"))?(Mul.unsafeFromJSON(json)):(((json['constr'] == "Sub"))?(Sub.unsafeFromJSON(json)):(((json['constr'] == "Div"))?(Div.unsafeFromJSON(json)):(Num.unsafeFromJSON(json)))));}(json['y']);
    return obj;
};
Div.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Div();
        if (('x' in json)) {
            obj.x = json['x'];
        }
        else {
            obj.x = null;
        }
        if (('y' in json)) {
            obj.y = json['y'];
        }
        else {
            obj.y = null;
        }
        return obj;
    }
    else {
        return null;
    }
};
Div.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapDiv(this, path);
};
Div.prototype.fold2 = function (inj, arg){
    return inj.fmap2Div(this, arg);
};
Div.unfold = function (coalg, input){
    var obj = coalg.unfoldDiv(input);
    obj.x = Add.unfold(coalg, input);
    if (obj.x) {
    }
    else {
        obj.x = Mul.unfold(coalg, input);
        if (obj.x) {
        }
        else {
            obj.x = Sub.unfold(coalg, input);
            if (obj.x) {
            }
            else {
                obj.x = Div.unfold(coalg, input);
                if (obj.x) {
                }
                else {
                    obj.x = Num.unfold(coalg, input);
                }
            }
        }
    }
    obj.y = Add.unfold(coalg, input);
    if (obj.y) {
    }
    else {
        obj.y = Mul.unfold(coalg, input);
        if (obj.y) {
        }
        else {
            obj.y = Sub.unfold(coalg, input);
            if (obj.y) {
            }
            else {
                obj.y = Div.unfold(coalg, input);
                if (obj.y) {
                }
                else {
                    obj.y = Num.unfold(coalg, input);
                }
            }
        }
    }
    return obj;
};
function Sub () {
}
Sub.fromArgs = function (x, y){
    var obj = new Sub();
    obj.x = x;
    obj.y = y;
    return obj;
};
Sub.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Sub";
    json['x'] = this.x.toJSON();
    json['y'] = this.y.toJSON();
    return json;
};
Sub.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Sub"))) {
        var obj = new Sub();
        if (('x' in json)) {
            obj.x = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Add"))?(Add.fromJSON(json)):(((json['constr'] == "Mul"))?(Mul.fromJSON(json)):(((json['constr'] == "Sub"))?(Sub.fromJSON(json)):(((json['constr'] == "Div"))?(Div.fromJSON(json)):(((json['constr'] == "Num"))?(Num.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr'])))))))):(new JSONERROR("Wrong Object"));}(json['x']);
            if (isJSONERROR(obj.x)) {
                return new JSONERROR("Sub.x", obj.x);
            }
        }
        else {
            return new JSONERROR("Sub fromJSON: missing key: x");
        }
        if (('y' in json)) {
            obj.y = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Add"))?(Add.fromJSON(json)):(((json['constr'] == "Mul"))?(Mul.fromJSON(json)):(((json['constr'] == "Sub"))?(Sub.fromJSON(json)):(((json['constr'] == "Div"))?(Div.fromJSON(json)):(((json['constr'] == "Num"))?(Num.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr'])))))))):(new JSONERROR("Wrong Object"));}(json['y']);
            if (isJSONERROR(obj.y)) {
                return new JSONERROR("Sub.y", obj.y);
            }
        }
        else {
            return new JSONERROR("Sub fromJSON: missing key: y");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Sub " + json['constr']));
    }
};
Sub.unsafeFromJSON = function (json){
    var obj = new Sub();
    obj.x = function(json){return ((json['constr'] == "Add"))?(Add.unsafeFromJSON(json)):(((json['constr'] == "Mul"))?(Mul.unsafeFromJSON(json)):(((json['constr'] == "Sub"))?(Sub.unsafeFromJSON(json)):(((json['constr'] == "Div"))?(Div.unsafeFromJSON(json)):(Num.unsafeFromJSON(json)))));}(json['x']);
    obj.y = function(json){return ((json['constr'] == "Add"))?(Add.unsafeFromJSON(json)):(((json['constr'] == "Mul"))?(Mul.unsafeFromJSON(json)):(((json['constr'] == "Sub"))?(Sub.unsafeFromJSON(json)):(((json['constr'] == "Div"))?(Div.unsafeFromJSON(json)):(Num.unsafeFromJSON(json)))));}(json['y']);
    return obj;
};
Sub.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Sub();
        if (('x' in json)) {
            obj.x = json['x'];
        }
        else {
            obj.x = null;
        }
        if (('y' in json)) {
            obj.y = json['y'];
        }
        else {
            obj.y = null;
        }
        return obj;
    }
    else {
        return null;
    }
};
Sub.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapSub(this, path);
};
Sub.prototype.fold2 = function (inj, arg){
    return inj.fmap2Sub(this, arg);
};
Sub.unfold = function (coalg, input){
    var obj = coalg.unfoldSub(input);
    obj.x = Add.unfold(coalg, input);
    if (obj.x) {
    }
    else {
        obj.x = Mul.unfold(coalg, input);
        if (obj.x) {
        }
        else {
            obj.x = Sub.unfold(coalg, input);
            if (obj.x) {
            }
            else {
                obj.x = Div.unfold(coalg, input);
                if (obj.x) {
                }
                else {
                    obj.x = Num.unfold(coalg, input);
                }
            }
        }
    }
    obj.y = Add.unfold(coalg, input);
    if (obj.y) {
    }
    else {
        obj.y = Mul.unfold(coalg, input);
        if (obj.y) {
        }
        else {
            obj.y = Sub.unfold(coalg, input);
            if (obj.y) {
            }
            else {
                obj.y = Div.unfold(coalg, input);
                if (obj.y) {
                }
                else {
                    obj.y = Num.unfold(coalg, input);
                }
            }
        }
    }
    return obj;
};
function Num () {
}
Num.fromArgs = function (v){
    var obj = new Num();
    obj.v = parseInt(v);
    return obj;
};
Num.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Num";
    json['v'] = this.v;
    return json;
};
Num.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Num"))) {
        var obj = new Num();
        if (('v' in json)) {
            obj.v = pInt(json['v']);
            if (isJSONERROR(obj.v)) {
                return new JSONERROR("Num.v", obj.v);
            }
        }
        else {
            return new JSONERROR("Num fromJSON: missing key: v");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Num " + json['constr']));
    }
};
Num.unsafeFromJSON = function (json){
    var obj = new Num();
    obj.v = pUnsafe(json['v']);
    return obj;
};
Num.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Num();
        if (('v' in json)) {
            obj.v = parseInt(json['v']);
        }
        else {
            obj.v = 0;
        }
        return obj;
    }
    else {
        return null;
    }
};
Num.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapNum(this, path);
};
Num.prototype.fold2 = function (inj, arg){
    return inj.fmap2Num(this, arg);
};
Num.unfold = function (coalg, input){
    var obj = coalg.unfoldNum(input);
    return obj;
};
function Tree () {
}
Tree.fromArgs = function (m){
    var obj = new Tree();
    obj.m = m;
    return obj;
};
Tree.prototype.toJSON = function (){
    var json = {};
    json['constr'] = "Tree";
    json['m'] = this.m.toJSON();
    return json;
};
Tree.fromJSON = function (json){
    if ((isObject(json) && ('constr' in json) && (json['constr'] == "Tree"))) {
        var obj = new Tree();
        if (('m' in json)) {
            obj.m = function(json){return ((isObject(json) && ('constr' in json)))?(((json['constr'] == "Add"))?(Add.fromJSON(json)):(((json['constr'] == "Mul"))?(Mul.fromJSON(json)):(((json['constr'] == "Sub"))?(Sub.fromJSON(json)):(((json['constr'] == "Div"))?(Div.fromJSON(json)):(((json['constr'] == "Num"))?(Num.fromJSON(json)):(new JSONERROR(("Wrong Type: " + json['constr'])))))))):(new JSONERROR("Wrong Object"));}(json['m']);
            if (isJSONERROR(obj.m)) {
                return new JSONERROR("Tree.m", obj.m);
            }
        }
        else {
            return new JSONERROR("Tree fromJSON: missing key: m");
        }
        return obj;
    }
    else {
        return new JSONERROR(("Tree " + json['constr']));
    }
};
Tree.unsafeFromJSON = function (json){
    var obj = new Tree();
    obj.m = function(json){return ((json['constr'] == "Add"))?(Add.unsafeFromJSON(json)):(((json['constr'] == "Mul"))?(Mul.unsafeFromJSON(json)):(((json['constr'] == "Sub"))?(Sub.unsafeFromJSON(json)):(((json['constr'] == "Div"))?(Div.unsafeFromJSON(json)):(Num.unsafeFromJSON(json)))));}(json['m']);
    return obj;
};
Tree.fromAssoc = function (json){
    if (isObject(json)) {
        var obj = new Tree();
        if (('m' in json)) {
            obj.m = json['m'];
        }
        else {
            obj.m = null;
        }
        return obj;
    }
    else {
        return null;
    }
};
Tree.prototype.fold = function (inj, path){
    path = path || [];
    return inj.fmapTree(this, path);
};
Tree.prototype.fold2 = function (inj, arg){
    return inj.fmap2Tree(this, arg);
};
Tree.unfold = function (coalg, input){
    var obj = coalg.unfoldTree(input);
    obj.m = Add.unfold(coalg, input);
    if (obj.m) {
    }
    else {
        obj.m = Mul.unfold(coalg, input);
        if (obj.m) {
        }
        else {
            obj.m = Sub.unfold(coalg, input);
            if (obj.m) {
            }
            else {
                obj.m = Div.unfold(coalg, input);
                if (obj.m) {
                }
                else {
                    obj.m = Num.unfold(coalg, input);
                }
            }
        }
    }
    return obj;
};
function F_M () {
    this.keyorder = {};
}
F_M.prototype.fmapAdd = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var x = obj.x.fold(inj, path2);
    var y = obj.y.fold(inj, path2);
    this.path = path;
    return this.foldAdd(x, y);
};
F_M.prototype.fmapMul = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var x = obj.x.fold(inj, path2);
    var y = obj.y.fold(inj, path2);
    this.path = path;
    return this.foldMul(x, y);
};
F_M.prototype.fmapDiv = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var x = obj.x.fold(inj, path2);
    var y = obj.y.fold(inj, path2);
    this.path = path;
    return this.foldDiv(x, y);
};
F_M.prototype.fmapSub = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var x = obj.x.fold(inj, path2);
    var y = obj.y.fold(inj, path2);
    this.path = path;
    return this.foldSub(x, y);
};
F_M.prototype.fmapNum = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var v = obj.v;
    this.path = path;
    return this.foldNum(v);
};
F_M.prototype.fmapTree = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var m = obj.m.fold(inj, path2);
    this.path = path;
    return this.foldTree(m);
};
F_M.prototype.fmap2Add = function (obj, arg){
    var inj = this;
    obj.x.fold2(inj, arg);
    obj.y.fold2(inj, arg);
    this.fold2(obj, arg);
    return null;
};
F_M.prototype.fmap2Mul = function (obj, arg){
    var inj = this;
    obj.x.fold2(inj, arg);
    obj.y.fold2(inj, arg);
    this.fold2(obj, arg);
    return null;
};
F_M.prototype.fmap2Div = function (obj, arg){
    var inj = this;
    obj.x.fold2(inj, arg);
    obj.y.fold2(inj, arg);
    this.fold2(obj, arg);
    return null;
};
F_M.prototype.fmap2Sub = function (obj, arg){
    var inj = this;
    obj.x.fold2(inj, arg);
    obj.y.fold2(inj, arg);
    this.fold2(obj, arg);
    return null;
};
F_M.prototype.fmap2Num = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_M.prototype.fmap2Tree = function (obj, arg){
    var inj = this;
    obj.m.fold2(inj, arg);
    this.fold2(obj, arg);
    return null;
};
