function Foo_UL () {
}
Foo_UL.prototype = new F_Foo(); 
Foo_UL.prototype.foldProduct = function (pid, name, values){
    return ("Product<ul>" + ("<li>pid :: INT    = " + pid + "</li>") + ("<li>name :: STRING = " + name + "</li>") + ("<li>values :: MAP [aid => Value] = " + "<ul>" + values.join("") + "</ul>" + "</li>") + "</ul>");
};
Foo_UL.prototype.foldAttribute = function (aid, name, type){
    return ("Attribute<ul>" + ("<li>aid :: INT    = " + aid + "</li>") + ("<li>name :: STRING = " + name + "</li>") + ("<li>type :: STRING = " + type + "</li>") + "</ul>");
};
Foo_UL.prototype.foldValue = function (aid, value){
    return ("Value<ul>" + ("<li>aid :: INT    = " + aid + "</li>") + ("<li>value :: STRING = " + value + "</li>") + "</ul>");
};
Foo_UL.prototype.foldANode = function (aid, weight){
    return ("ANode<ul>" + ("<li>aid :: INT    = " + aid + "</li>") + ("<li>weight :: FLOAT  = " + weight + "</li>") + "</ul>");
};
Foo_UL.prototype.foldRNode = function (name, weight, nodes){
    return ("RNode<ul>" + ("<li>name :: STRING = " + name + "</li>") + ("<li>weight :: FLOAT  = " + weight + "</li>") + ("<li>nodes :: LIST = " + "<ul>" + nodes.map(function(obj){return ("<li>? :: ANode | RNode = " + obj + "</li>");}).join("") + "</ul>" + "</li>") + "</ul>");
};
Foo_UL.prototype.foldTestclass = function (tid, name, nodes, weights){
    return ("Testclass<ul>" + ("<li>tid :: INT    = " + tid + "</li>") + ("<li>name :: STRING = " + name + "</li>") + ("<li>nodes :: LIST = " + "<ul>" + nodes.map(function(obj){return ("<li>? :: ANode | RNode = " + obj + "</li>");}).join("") + "</ul>" + "</li>") + ("<li>weights :: MAP [aid => ANode] = " + "<ul>" + weights.join("") + "</ul>" + "</li>") + "</ul>");
};
Foo_UL.prototype.foldProject = function (id, name, attributes, products, testclasses, bla){
    return ("Project<ul>" + ("<li>id :: INT    = " + id + "</li>") + ("<li>name :: STRING = " + name + "</li>") + ("<li>attributes :: MAP [aid => Attribute] = " + "<ul>" + attributes.join("") + "</ul>" + "</li>") + ("<li>products :: MAP [pid => Product] = " + "<ul>" + products.join("") + "</ul>" + "</li>") + ("<li>testclasses :: MAP [tid => Testclass] = " + "<ul>" + testclasses.join("") + "</ul>" + "</li>") + ("<li>bla :: LIST = " + "<ul>" + bla.map(function(obj){return ("<li>? :: TUPLE = " + "<ul>" + [("<li>[0] :: INT    = " + obj[0] + "</li>"), ("<li>[1] :: STRING = " + obj[1] + "</li>"), ("<li>[2] :: MAP [aid => Attribute] = " + "<ul>" + obj[2].join("") + "</ul>" + "</li>"), ("<li>[3] :: Range = " + obj[3] + "</li>")].join("") + "</ul>" + "</li>");}).join("") + "</ul>" + "</li>") + "</ul>");
};
Foo_UL.prototype.foldSavedSearch = function (sid, values){
    return ("SavedSearch<ul>" + ("<li>sid :: INT    = " + sid + "</li>") + ("<li>values :: MAP [aid => Filter] = " + "<ul>" + values.join("") + "</ul>" + "</li>") + "</ul>");
};
Foo_UL.prototype.foldFilter = function (aid, predicate){
    return ("Filter<ul>" + ("<li>aid :: INT    = " + aid + "</li>") + ("<li>predicate :: Range | Elems = " + predicate + "</li>") + "</ul>");
};
Foo_UL.prototype.foldRange = function (min, max){
    return ("Range<ul>" + ("<li>min :: INT    = " + min + "</li>") + ("<li>max :: INT    = " + max + "</li>") + "</ul>");
};
Foo_UL.prototype.foldElems = function (values){
    return ("Elems<ul>" + ("<li>values :: LIST = " + "<ul>" + values.map(function(obj){return ("<li>? :: STRING = " + obj + "</li>");}).join("") + "</ul>" + "</li>") + "</ul>");
};
Foo_UL.prototype.foldFilterset = function (fsid, name, widgets){
    return ("Filterset<ul>" + ("<li>fsid :: INT    = " + fsid + "</li>") + ("<li>name :: STRING = " + name + "</li>") + ("<li>widgets :: MAP [aid => Widget] = " + "<ul>" + widgets.join("") + "</ul>" + "</li>") + "</ul>");
};
Foo_UL.prototype.foldWidget = function (aid, widget, info){
    return ("Widget<ul>" + ("<li>aid :: INT    = " + aid + "</li>") + ("<li>widget :: RangeSlider | Range = " + widget + "</li>") + ("<li>info :: STRING = " + info + "</li>") + "</ul>");
};
Foo_UL.prototype.foldRangeSlider = function (min, max, value1, value2){
    return ("RangeSlider<ul>" + ("<li>min :: INT    = " + min + "</li>") + ("<li>max :: INT    = " + max + "</li>") + ("<li>value1 :: INT    = " + value1 + "</li>") + ("<li>value2 :: INT    = " + value2 + "</li>") + "</ul>");
};
