function Listexample_Text2 () {
}
Listexample_Text2.prototype = new F_Listexample(); 
Listexample_Text2.prototype.foldNil = function (){
    return [];
};
Listexample_Text2.prototype.foldCons = function (head, tail){
    return [head].concat(tail);
};
Listexample_Text2.prototype.foldFoo = function (list1, list2, info){
    return ("[" + list1.join(", ") + "], [" + list2.join(", ") + "]" + " " + info);
};
