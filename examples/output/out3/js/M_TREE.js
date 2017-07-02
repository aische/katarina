function M_TREE () {
}
M_TREE.prototype = new F_M(); 
M_TREE.prototype.foldAdd = function (x, y){
    return {constr: "Add", x: x, y: y};
};
M_TREE.prototype.foldMul = function (x, y){
    return {constr: "Mul", x: x, y: y};
};
M_TREE.prototype.foldDiv = function (x, y){
    return {constr: "Div", x: x, y: y};
};
M_TREE.prototype.foldSub = function (x, y){
    return {constr: "Sub", x: x, y: y};
};
M_TREE.prototype.foldNum = function (v){
    return {constr: "Num", v: v};
};
M_TREE.prototype.foldTree = function (m){
    return {constr: "Tree", m: m};
};
