function A3_ShowTestclasses () {
}
A3_ShowTestclasses.prototype = new F_A3(); 
A3_ShowTestclasses.prototype.foldProject = function (testclasses){
    return testclasses.join("<br>");
};
A3_ShowTestclasses.prototype.foldTestclass = function (tid, name){
    return ("\n        <a href=\"javascript: showTestclass(" + tid + (")\">" + name + ("</a>")));
};
