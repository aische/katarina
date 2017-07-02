function Listexample_Text () {
}
Listexample_Text.prototype = new F_Listexample(); 
Listexample_Text.prototype.foldNil = function (){
    return "[]";
};
Listexample_Text.prototype.foldCons = function (head, tail){
    return (head + " : " + tail);
};
Listexample_Text.prototype.foldFoo = function (list1, list2, info){
    return (list1 + ", " + list2);
};
