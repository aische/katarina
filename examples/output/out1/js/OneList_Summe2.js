function OneList_Summe2 () {
}
OneList_Summe2.prototype = new F_OneList(); 
OneList_Summe2.prototype.foldNil = function (){
    return 0;
};
OneList_Summe2.prototype.foldCons = function (head, tail){
    return (head + tail);
};
OneList_Summe2.prototype.foldFoo = function (list1){
    return list1;
};
