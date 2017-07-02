function M_UL () {
}
M_UL.prototype = new F_M(); 
M_UL.prototype.foldAdd = function (x, y){
    return ("Add<ul>" + ("<li>x :: Add | Mul | Sub | Div | Num = " + x + "</li>") + ("<li>y :: Add | Mul | Sub | Div | Num = " + y + "</li>") + "</ul>");
};
M_UL.prototype.foldMul = function (x, y){
    return ("Mul<ul>" + ("<li>x :: Add | Mul | Sub | Div | Num = " + x + "</li>") + ("<li>y :: Add | Mul | Sub | Div | Num = " + y + "</li>") + "</ul>");
};
M_UL.prototype.foldDiv = function (x, y){
    return ("Div<ul>" + ("<li>x :: Add | Mul | Sub | Div | Num = " + x + "</li>") + ("<li>y :: Add | Mul | Sub | Div | Num = " + y + "</li>") + "</ul>");
};
M_UL.prototype.foldSub = function (x, y){
    return ("Sub<ul>" + ("<li>x :: Add | Mul | Sub | Div | Num = " + x + "</li>") + ("<li>y :: Add | Mul | Sub | Div | Num = " + y + "</li>") + "</ul>");
};
M_UL.prototype.foldNum = function (v){
    return ("Num<ul>" + ("<li>v :: INT    = " + v + "</li>") + "</ul>");
};
M_UL.prototype.foldTree = function (m){
    return ("Tree<ul>" + ("<li>m :: Add | Mul | Sub | Div | Num = " + m + "</li>") + "</ul>");
};
