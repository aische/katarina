function Foo_I2 () {
}
Foo_I2.prototype = new F_Foo(); 
Foo_I2.prototype.foldProduct = function (pid, name, values){
    return ("<li><span style=\"color:green;\">" + pid + ": " + name + "</span><ul>" + values.join("") + "</ul>" + "</li>");
};
Foo_I2.prototype.foldAttribute = function (aid, name, type){
    return ("<li>" + "<span style=\"color:blue;\">" + aid + ": " + name + "(" + type + ")" + "</span></li>");
};
Foo_I2.prototype.foldValue = function (aid, value){
    return ("<li>" + "<span style=\"color:red;\">" + aid + ": " + value + "</span></li>");
};
Foo_I2.prototype.foldProject = function (id, name, attributes, products, testclasses, bla){
    return ("<li>" + "<span style=\"color:#ff00ff;\">" + id + name + "</span><ul>" + attributes.join("") + "</ul>" + "<ul>" + products.join("") + "</ul>" + "<ul>" + testclasses.join("") + "</ul>" + "</li>");
};
Foo_I2.prototype.foldANode = function (aid, weight){
    return ("<li>" + "<span style=\"color:#00ffff;\">" + aid + ": " + weight + "</span></li>");
};
Foo_I2.prototype.foldRNode = function (name, weight, nodes){
    return ("<li>" + "<span style=\"color:#00aa77;\">" + name + ": " + weight + "</span><ul>" + nodes.join("") + "</ul>" + "</li>");
};
Foo_I2.prototype.foldSavedSearch = function (sid, values){
    return ("<li>" + "<span style=\"color:#aa0077;\">" + sid + "</span><ul>" + values.join("") + "</ul>" + "</li>");
};
Foo_I2.prototype.foldFilter = function (aid, predicate){
    return ("<li>" + "<span style=\"color:#aaff00;\">" + aid + "</span>" + predicate + "</li>");
};
Foo_I2.prototype.foldRange = function (min, max){
    return ("[" + min + "-" + max + "]");
};
Foo_I2.prototype.foldElems = function (values){
    return "";
};
Foo_I2.prototype.foldTestclass = function (tid, name, nodes, weights){
    return ("<li>" + "<span style=\"color:#ffff00;\">" + tid + ": " + name + "</span><ul>" + nodes.join("") + "</ul>" + "weights:" + "<ul>" + weights.join("") + "</ul>" + "</li>");
};
Foo_I2.prototype.foldFilterset = function (fsid, name, widgets){
    return ("<li>" + "<span style=\"color:#22aaff;\">" + fsid + ": " + name + "</span><ul>" + widgets.join("") + "</ul>" + "</li>");
};
Foo_I2.prototype.foldRangeSlider = function (min, max, value1, value2){
};
Foo_I2.prototype.foldWidget = function (aid, widget, info){
};
