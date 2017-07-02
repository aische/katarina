function A1_I1 () {
}
A1_I1.prototype = new F_A1(); 
A1_I1.prototype.foldProduct = function (pid, name, values){
    return ("\n        <li>\n            <span style=\"color:black;\">Product " + name + ("[pid=" + pid + ("]:</span>\n            <ul>" + values.join("") + ("</ul>\n        </li>"))));
};
A1_I1.prototype.foldAttribute = function (aid, name, type){
    return ("<li><span style=\"color:black;\">Attr " + name + ("[aid=" + aid + ("]::" + type + ("</span></li>"))));
};
A1_I1.prototype.foldValue = function (aid, value){
    return ("<li><span style=\"color:black;\">Value[aid=" + aid + ("] = " + value + ("</span></li>")));
};
A1_I1.prototype.foldProject = function (id, name, attributes, products, bla){
    return (id + ": <span style=\"color:black;\">" + name + "</span><ul>" + attributes.join("") + "</ul>" + "<ul>" + products.join("") + "</ul>" + bla[0][2].join(""));
};
A1_I1.prototype.foldRange = function (min, max){
    return "";
};
