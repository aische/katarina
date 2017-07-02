function A1_I3 () {
}
A1_I3.prototype = new F_A1(); 
A1_I3.prototype.foldProduct = function (pid, name, values){
    return ("\n        <li> \n            (" + pid + ("):\n            <span class=\"edit\" \n                  style=\"color:green;\"\n                  data-pid=\"" + pid + ("\"\n                  data-typ=\"Product.name\"\n                  >" + name + ("</span>\n            <ul>" + values.join("") + ("</ul>\n        </li>")))));
};
A1_I3.prototype.foldAttribute = function (aid, name, type){
    return ("\n        <li> \n            (" + aid + ("):\n            <span class=\"edit\" \n                  style=\"color:blue;\"\n                  data-aid=\"" + aid + ("\"\n                  data-typ=\"Attribute.name\"\n                  >" + name + ("</span> ::\n            <span class=\"edit\" \n                  style=\"color:magenta;\"\n                  data-aid=\"" + aid + ("\"\n                  data-typ=\"Attribute.type\"\n                  >" + type + ("</span>\n        </li> "))))));
};
A1_I3.prototype.foldValue = function (aid, value){
    return ("\n        <li> \n            \n            " + this.attrs[aid].name + (" =\n            <span class=\"edit\" \n                  style=\"color:red;\"\n                  data-aid=\"" + aid + ("\"\n                  data-pid=\"" + this.path[0].pid + ("\"\n                  data-typ=\"Value\"\n            >" + value + ("</span>\n        </li>")))));
};
A1_I3.prototype.foldProject = function (id, name, attributes, products, bla){
    return ("\n            Project(" + id + ("):\n            <span class=\"edit\" \n                  style=\"color:red;\"\n                  data-id=\"" + id + ("\"\n                  data-typ=\"Project.name\"\n            >" + name + ("</span>\n            <br>Attributes:\n            <ul>" + attributes.join("") + ("</ul>\n            Products:\n            <ul>" + products.join("") + ("</ul>\n            "))))));
};
A1_I3.prototype.foldRange = function (min, max){
    return "";
};
