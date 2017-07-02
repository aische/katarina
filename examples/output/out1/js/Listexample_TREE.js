function Listexample_TREE () {
}
Listexample_TREE.prototype = new F_Listexample(); 
Listexample_TREE.prototype.foldNil = function (){
    return {constr: "Nil"};
};
Listexample_TREE.prototype.foldCons = function (head, tail){
    return {constr: "Cons", head: head, tail: tail};
};
Listexample_TREE.prototype.foldFoo = function (list1, list2, info){
    return {constr: "Foo", list1: list1, list2: list2, info: info};
};
