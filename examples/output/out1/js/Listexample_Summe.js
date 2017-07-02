function Listexample_Summe () {
}
Listexample_Summe.prototype = new F_Listexample(); 
Listexample_Summe.prototype.foldNil = function (){
    return 0;
};
Listexample_Summe.prototype.foldCons = function (head, tail){
    return (head + tail);
};
Listexample_Summe.prototype.foldFoo = function (list1, list2, info){
    return (list1 + list2);
};
