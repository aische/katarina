function Foo_TREE () {
}
Foo_TREE.prototype = new F_Foo(); 
Foo_TREE.prototype.foldProduct = function (pid, name, values){
    return {constr: "Product", pid: pid, name: name, values: values};
};
Foo_TREE.prototype.foldAttribute = function (aid, name, type){
    return {constr: "Attribute", aid: aid, name: name, type: type};
};
Foo_TREE.prototype.foldValue = function (aid, value){
    return {constr: "Value", aid: aid, value: value};
};
Foo_TREE.prototype.foldANode = function (aid, weight){
    return {constr: "ANode", aid: aid, weight: weight};
};
Foo_TREE.prototype.foldRNode = function (name, weight, nodes){
    return {constr: "RNode", name: name, weight: weight, nodes: nodes};
};
Foo_TREE.prototype.foldTestclass = function (tid, name, nodes, weights){
    return {constr: "Testclass", tid: tid, name: name, nodes: nodes, weights: weights};
};
Foo_TREE.prototype.foldProject = function (id, name, attributes, products, testclasses, bla){
    return {constr: "Project", id: id, name: name, attributes: attributes, products: products, testclasses: testclasses, bla: bla};
};
Foo_TREE.prototype.foldSavedSearch = function (sid, values){
    return {constr: "SavedSearch", sid: sid, values: values};
};
Foo_TREE.prototype.foldFilter = function (aid, predicate){
    return {constr: "Filter", aid: aid, predicate: predicate};
};
Foo_TREE.prototype.foldRange = function (min, max){
    return {constr: "Range", min: min, max: max};
};
Foo_TREE.prototype.foldElems = function (values){
    return {constr: "Elems", values: values};
};
Foo_TREE.prototype.foldFilterset = function (fsid, name, widgets){
    return {constr: "Filterset", fsid: fsid, name: name, widgets: widgets};
};
Foo_TREE.prototype.foldWidget = function (aid, widget, info){
    return {constr: "Widget", aid: aid, widget: widget, info: info};
};
Foo_TREE.prototype.foldRangeSlider = function (min, max, value1, value2){
    return {constr: "RangeSlider", min: min, max: max, value1: value1, value2: value2};
};
