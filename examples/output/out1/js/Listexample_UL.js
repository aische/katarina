function Listexample_UL () {
}
Listexample_UL.prototype = new F_Listexample(); 
Listexample_UL.prototype.foldNil = function (){
    return ("Nil<ul>" + "</ul>");
};
Listexample_UL.prototype.foldCons = function (head, tail){
    return ("Cons<ul>" + ("<li>head :: INT    = " + head + "</li>") + ("<li>tail :: Nil | Cons = " + tail + "</li>") + "</ul>");
};
Listexample_UL.prototype.foldFoo = function (list1, list2, info){
    return ("Foo<ul>" + ("<li>list1 :: Nil | Cons = " + list1 + "</li>") + ("<li>list2 :: Nil | Cons = " + list2 + "</li>") + ("<li>info :: STRING = " + info + "</li>") + "</ul>");
};
