function A2_I5 () {
}
A2_I5.prototype = new F_A2(); 
A2_I5.prototype.foldTestclass = function (tid, name, nodes){
    return ("\n        Testclass(" + tid + ("):\n        <span class=\"edit\" \n              style=\"color:magenta;\"\n              data-tid=\"" + tid + ("\"\n              data-typ=\"Testclass.name\"\n            >" + name + ("</span>:\n        <ul>" + nodes.join("") + ("</ul>")))));
};
A2_I5.prototype.foldANode = function (aid, weight){
    return ("\n        <li><span style=\"color:#008888;\">" + aid + (": " + weight + ("</span>\n        </li>")));
};
A2_I5.prototype.foldRNode = function (name, weight, nodes){
    return ("\n        <li><span style=\"color:#009900;\">" + name + (": " + weight + ("</span>\n        <ul>\n        " + nodes.join("") + ("\n        </ul>\n        </li>"))));
};
