function Listexample_Length () {
}
Listexample_Length.prototype = new F_Listexample(); 
Listexample_Length.prototype.foldNil = function (){
    return 0;
};
Listexample_Length.prototype.foldCons = function (head, tail){
    return (1 + tail);
};
Listexample_Length.prototype.foldFoo = function (list1, list2, info){
    return (list1 + list2);
};
