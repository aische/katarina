function F_A2 () {
    this.keyorder = {};
}
F_A2.prototype.fmapProduct = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldProduct();
};
F_A2.prototype.fmapAttribute = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldAttribute();
};
F_A2.prototype.fmapValue = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldValue();
};
F_A2.prototype.fmapANode = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var aid = obj.aid;
    var weight = obj.weight;
    this.path = path;
    return this.foldANode(aid, weight);
};
F_A2.prototype.fmapRNode = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var name = obj.name;
    var weight = obj.weight;
    var nodes = obj.nodes.map(function(obj){return obj.fold(inj, path2);});
    this.path = path;
    return this.foldRNode(name, weight, nodes);
};
F_A2.prototype.fmapTestclass = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var tid = obj.tid;
    var name = obj.name;
    var nodes = obj.nodes.map(function(obj){return obj.fold(inj, path2);});
    this.path = path;
    return this.foldTestclass(tid, name, nodes);
};
F_A2.prototype.fmapProject = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldProject();
};
F_A2.prototype.fmapSavedSearch = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldSavedSearch();
};
F_A2.prototype.fmapFilter = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldFilter();
};
F_A2.prototype.fmapRange = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldRange();
};
F_A2.prototype.fmapElems = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldElems();
};
F_A2.prototype.fmapFilterset = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldFilterset();
};
F_A2.prototype.fmapWidget = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldWidget();
};
F_A2.prototype.fmapRangeSlider = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldRangeSlider();
};
F_A2.prototype.fmap2Product = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2Attribute = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2Value = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2ANode = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2RNode = function (obj, arg){
    var inj = this;
    obj.nodes.map(function(obj){obj.fold2(inj, arg);});
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2Testclass = function (obj, arg){
    var inj = this;
    obj.nodes.map(function(obj){obj.fold2(inj, arg);});
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2Project = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2SavedSearch = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2Filter = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2Range = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2Elems = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2Filterset = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2Widget = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A2.prototype.fmap2RangeSlider = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
