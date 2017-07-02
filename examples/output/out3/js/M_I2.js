function M_I2 () {
}
M_I2.prototype = new F_M(); 
M_I2.prototype.foldAdd = function (x, y){
    return ("<span style=\"color:blue;\">(" + x + " + " + y + ")</span>");
};
M_I2.prototype.foldMul = function (x, y){
    return ("<span style=\"color:green;\">(" + x + " * " + y + ")</span>");
};
M_I2.prototype.foldSub = function (x, y){
    return ("<span style=\"color:red;\">(" + x + " - " + y + ")</span>");
};
M_I2.prototype.foldDiv = function (x, y){
    return ("<span style=\"color:magenta;\">(" + x + " / " + y + ")</span>");
};
M_I2.prototype.foldNum = function (v){
    return ("<span style=\"color:gray;\">" + v + "</span>");
};
M_I2.prototype.foldTree = function (m){
    return m;
};
