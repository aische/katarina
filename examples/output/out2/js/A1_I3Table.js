function A1_I3Table () {
}
A1_I3Table.prototype = new F_A1(); 
A1_I3Table.prototype.foldProduct = function (pid, name, values){
    return ("\n        <tr>\n            <td>\n                " + pid + ("\n            </td>\n            <td>\n                <span class=\"edit\" \n                      style=\"color:green;\"\n                      data-pid=\"" + pid + ("\"\n                      data-typ=\"Product.name\"\n                      >" + name + ("</span>\n            </td>\n            " + values.join("") + ("\n        </tr>")))));
};
A1_I3Table.prototype.foldAttribute = function (aid, name, type){
    return [("\n        <td> \n            (" + aid + (")\n        </td> \n        ")), ("\n        <td> \n            <span class=\"edit\" \n                  style=\"color:blue;\"\n                  data-aid=\"" + aid + ("\"\n                  data-typ=\"Attribute.name\"\n            >" + name + ("</span>\n        </td> \n        "))), ("\n        <td> \n            <span class=\"edit\" \n                  style=\"color:magenta;\"\n                  data-aid=\"" + aid + ("\"\n                  data-typ=\"Attribute.type\"\n                  >" + type + ("</span>\n        </td>")))];
};
A1_I3Table.prototype.foldValue = function (aid, value){
    return ("\n        <td><span class=\"edit\" \n                  style=\"color:red;\"\n                  data-aid=\"" + aid + ("\"\n                  data-pid=\"" + this.path[0].pid + ("\"\n                  data-typ=\"Value\"\n            >" + value + ("</span>\n        </td>"))));
};
A1_I3Table.prototype.foldProject = function (id, name, attributes, products, bla){
    return ("\n            <table>\n                <tr><td></td><td></td>" + attributes.map(function(x){return x[0];}).join("") + ("</tr>\n                <tr><td></td><td></td>" + attributes.map(function(x){return x[1];}).join("") + ("</tr>\n                <tr><td></td><td></td>" + attributes.map(function(x){return x[2];}).join("") + ("</tr>\n                " + products.join("") + ("\n            </table>")))));
};
A1_I3Table.prototype.foldRange = function (min, max){
    return "";
};
