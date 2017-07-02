function F_A1 () {
    this.keyorder = {};
}
F_A1.prototype.fmapProduct = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var pid = obj.pid;
    var name = obj.name;
    var values = (('foo' in inj.keyorder))?(assoc_map_order(function(obj){return obj.fold(inj, path2);}, obj.values, inj.keyorder['foo'])):(assoc_map_(function(obj){return obj.fold(inj, path2);}, obj.values));
    this.path = path;
    return this.foldProduct(pid, name, values);
};
F_A1.prototype.fmapAttribute = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var aid = obj.aid;
    var name = obj.name;
    var type = obj.type;
    this.path = path;
    return this.foldAttribute(aid, name, type);
};
F_A1.prototype.fmapValue = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var aid = obj.aid;
    var value = obj.value;
    this.path = path;
    return this.foldValue(aid, value);
};
F_A1.prototype.fmapANode = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldANode();
};
F_A1.prototype.fmapRNode = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldRNode();
};
F_A1.prototype.fmapTestclass = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldTestclass();
};
F_A1.prototype.fmapProject = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var id = obj.id;
    var name = obj.name;
    var attributes = (('foo' in inj.keyorder))?(assoc_map_order(function(obj){return obj.fold(inj, path2);}, obj.attributes, inj.keyorder['foo'])):(assoc_map_(function(obj){return obj.fold(inj, path2);}, obj.attributes));
    var products = assoc_map_(function(obj){return obj.fold(inj, path2);}, obj.products);
    var bla = obj.bla.map(function(obj){return [obj[0], obj[1], (('foo' in inj.keyorder))?(assoc_map_order(function(obj){return obj.fold(inj, path2);}, obj[2], inj.keyorder['foo'])):(assoc_map_(function(obj){return obj.fold(inj, path2);}, obj[2])), obj[3].fold(inj, path2)];});
    this.path = path;
    return this.foldProject(id, name, attributes, products, bla);
};
F_A1.prototype.fmapSavedSearch = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldSavedSearch();
};
F_A1.prototype.fmapFilter = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldFilter();
};
F_A1.prototype.fmapRange = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var min = obj.min;
    var max = obj.max;
    this.path = path;
    return this.foldRange(min, max);
};
F_A1.prototype.fmapElems = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldElems();
};
F_A1.prototype.fmapFilterset = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldFilterset();
};
F_A1.prototype.fmapWidget = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldWidget();
};
F_A1.prototype.fmapRangeSlider = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldRangeSlider();
};
F_A1.prototype.fmap2Product = function (obj, arg){
    var inj = this;
    assoc_map_(function(obj){obj.fold2(inj, arg);}, obj.values);
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2Attribute = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2Value = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2ANode = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2RNode = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2Testclass = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2Project = function (obj, arg){
    var inj = this;
    assoc_map_(function(obj){obj.fold2(inj, arg);}, obj.attributes);
    assoc_map_(function(obj){obj.fold2(inj, arg);}, obj.products);
    obj.bla.map(function(obj){assoc_map_(function(obj){obj.fold2(inj, arg);}, obj[2]);
obj[3].fold2(inj, arg);
});
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2SavedSearch = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2Filter = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2Range = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2Elems = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2Filterset = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2Widget = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A1.prototype.fmap2RangeSlider = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
