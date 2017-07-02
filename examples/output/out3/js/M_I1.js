function M_I1 () {
}
M_I1.prototype = new F_M(); 
M_I1.prototype.foldAdd = function (x, y){
    return (x + y);
};
M_I1.prototype.foldMul = function (x, y){
    return (x * y);
};
M_I1.prototype.foldSub = function (x, y){
    return (x - y);
};
M_I1.prototype.foldDiv = function (x, y){
    return (x / y);
};
M_I1.prototype.foldNum = function (v){
    return v;
};
M_I1.prototype.foldTree = function (m){
    return m;
};
