function F_A3 () {
    this.keyorder = {};
}
F_A3.prototype.fmapProduct = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldProduct();
};
F_A3.prototype.fmapAttribute = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldAttribute();
};
F_A3.prototype.fmapValue = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldValue();
};
F_A3.prototype.fmapANode = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldANode();
};
F_A3.prototype.fmapRNode = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldRNode();
};
F_A3.prototype.fmapTestclass = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var tid = obj.tid;
    var name = obj.name;
    this.path = path;
    return this.foldTestclass(tid, name);
};
F_A3.prototype.fmapProject = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    var testclasses = assoc_map_(function(obj){return obj.fold(inj, path2);}, obj.testclasses);
    this.path = path;
    return this.foldProject(testclasses);
};
F_A3.prototype.fmapSavedSearch = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldSavedSearch();
};
F_A3.prototype.fmapFilter = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldFilter();
};
F_A3.prototype.fmapRange = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldRange();
};
F_A3.prototype.fmapElems = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldElems();
};
F_A3.prototype.fmapFilterset = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldFilterset();
};
F_A3.prototype.fmapWidget = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldWidget();
};
F_A3.prototype.fmapRangeSlider = function (obj, path){
    var inj = this;
    var path2 = [obj].concat(path);
    this.path = path;
    return this.foldRangeSlider();
};
F_A3.prototype.fmap2Product = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2Attribute = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2Value = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2ANode = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2RNode = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2Testclass = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2Project = function (obj, arg){
    var inj = this;
    assoc_map_(function(obj){obj.fold2(inj, arg);}, obj.testclasses);
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2SavedSearch = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2Filter = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2Range = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2Elems = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2Filterset = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2Widget = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
F_A3.prototype.fmap2RangeSlider = function (obj, arg){
    var inj = this;
    this.fold2(obj, arg);
    return null;
};
