function F_OneList () {
    this.keyorder = {};
}
F_OneList.prototype.fmapNil = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldNil();
};
F_OneList.prototype.fmapCons = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var head = obj.head;
    var tail = obj.tail.fold(inj, path2);
    this.path = path;
    return this.foldCons(head, tail);
};
F_OneList.prototype.fmapFoo = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var list1 = obj.list1.fold(inj, path2);
    this.path = path;
    return this.foldFoo(list1);
};
F_OneList.prototype.fmap2Nil = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_OneList.prototype.fmap2Cons = function (obj, arg){
    var inj = this;
    obj.tail.fold2(inj, arg);
    this.fold2(obj, arg);
    return null;
};
F_OneList.prototype.fmap2Foo = function (obj, arg){
    var inj = this;
    obj.list1.fold2(inj, arg);
    this.fold2(obj, arg);
    return null;
};
