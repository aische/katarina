# katarina - catamorphism compiler

katarina is a proof on concept catamorphism compiler. It takes some definitions of datatypes, functors and f-algebras and compiles them to "isomorphic" Javascript and PHP. The datatype definitions are what is called a model in other contexts (in Elm, for example), and the algebras represent different view functions for that model. Basically that's it.

#### Usage

	> stack build
	
	> cd examples

	> ../.stack-work/install/x86_64-osx/lts-8.13/8.0.2/bin/katarina input/input1/ifile1.txt input/input1/pfile1.txt -f input/input1/assets -o output/out1
	
	> php -S localhost:8080

(Path to executable might be different). Now open the examples in your browser:

	http://localhost:8080/output/out1/index.php
	http://localhost:8080/output/out2/index.php

When katarina is on the path, it can be used like this:

	katarina DATA ALG1 ALG2 ... -f ASSETS_PATH -o PATH
	
where

- DATA is the file with the datatype definition
- ALG1 ALG2 .. are files with functor and algebra definitions
- ASSETS_PATH is the (optional) path of a directory with additional files that get copied to the output directory
- PATH is the output directory


#### Example

Datatype definition: A set of (possibly mutual recursive) objects:

	data Listexample {

    	list = Nil | Cons;

	    Nil {}

    	Cons { 
        	head  :: Int;
	        tail  :: list;
    	}  

	    Foo {
    	    list1 :: list;
        	list2 :: list;
	        info :: String;
    	}  
	}

Algebra definitions for the datatype "Listexample":

    algebra Length :: Listexample {

        Nil () {
            return 0;
        }

        Cons (head, tail) {
            return 1 + tail;
        }

        Foo (list1, list2, info) {
            return list1 + list2;
        }
    }

    algebra Summe :: Listexample {

        Nil () {
            return 0;
        }

        Cons (head, tail) {
            return head + tail;
        }

        Foo (list1, list2, info) {
            return list1 + list2;
        }
    }

    algebra Text :: Listexample {

        Nil () {
            return "[]";
        }

        Cons (head, tail) {
            return concat(head, " : ", tail);
        }

        Foo (list1, list2, info) {
            return concat(list1, ", ", list2);
        }
    }

    algebra Text2 :: Listexample {

        Nil () {
            return [];
        }

        Cons (head, tail) {
            return append([head], tail);
        }

        Foo (list1, list2, info) {
            return concat("[", implode(", ", list1), "], [", implode(", ", list2), "]", " ", info);
        }
    }

A functor is a subset of a datatype, where the properties of the objects are subset of the original properties. (Each datatype is also a functor):

    functor OneList :: Listexample {

        Nil ()

        Cons (head, tail)

        Foo (list1)
    }

Algebra for the functor "OneList":

    algebra Summe2 :: OneList {

        Nil () {
            return 0;
        }

        Cons (head, tail) {
            return head + tail;
        }

        Foo (list1) {
            return list1;
        }
    }

A PHP program can use the compiled code like this:

	<!doctype html>
	<html>
	<head>
	<meta charset="UTF-8" />
	</head>
	<body>
	<?php
		include("php/prelude.php");
		include("php/Listexample.php");
		include("php/Listexample_UL.php");
		include("php/Listexample_TREE.php");
		include("php/Listexample_Length.php");
		include("php/Listexample_Summe.php");
		include("php/Listexample_Text.php");
		include("php/Listexample_Text2.php");
		include("php/F_OneList.php");
		include("php/OneList_Summe2.php");	

		$json = json_decode(file_get_contents("data.json"), true);
		$foo = Foo::fromJSON($json);
		echo "<h3>rendered with PHP:</h3>";
		echo $foo->fold(new Listexample_UL());
		$a1 = new Listexample_Length ();
		$a2 = new Listexample_Summe ();
		$a3 = new OneList_Summe2 ();
		$a4 = new Listexample_Text ();
		$a5 = new Listexample_Text2 ();
		echo "length: " . $foo->fold($a1);
		echo "<br>";
		echo "sum: " . $foo->fold($a2);
		echo "<br>";
		echo "text: " . $foo->fold($a4);
		echo "<br>";
		echo "text2: " . $foo->fold($a5);
		echo "<br>";
		echo "sum (OneList): " . $foo->fold($a3);
		echo "<br>";
	?>
	<script type="text/javascript" src="js/prelude.js"></script>
	<script type="text/javascript" src="js/Listexample.js"></script>
	<script type="text/javascript" src="js/Listexample_UL.js"></script>
	<script type="text/javascript" src="js/Listexample_TREE.js"></script>
	<script type="text/javascript" src="js/Listexample_Length.js"></script>
	<script type="text/javascript" src="js/Listexample_Summe.js"></script>
	<script type="text/javascript" src="js/Listexample_Text.js"></script>
	<script type="text/javascript" src="js/Listexample_Text2.js"></script>
	<script type="text/javascript" src="js/F_OneList.js"></script>
	<script type="text/javascript" src="js/OneList_Summe2.js"></script>
	<script type="text/javascript">
		var foo = Foo.fromJSON(JSON.parse('<?= json_encode($foo->toJSON()) ?>'));
		function doRender(){
			document.querySelector("#foo1").innerHTML = 
				foo.fold (new Listexample_UL());
			document.querySelector("#foo1_length").innerHTML = 
				"length: " + foo.fold (new Listexample_Length());
			document.querySelector("#foo1_sum").innerHTML = 
				"sum: " + foo.fold (new Listexample_Summe());
			document.querySelector("#foo1_text").innerHTML = 
				"text: " + foo.fold (new Listexample_Text());
			document.querySelector("#foo1_text2").innerHTML = 
				"text2: " + foo.fold (new Listexample_Text2());
			document.querySelector("#foo1_sum2").innerHTML = 
				"sum (OneList): " + foo.fold (new OneList_Summe2());
		}
	</script>
	<h3 onclick="doRender()">rendered with javascript: (click me)</h3>
	<div id="foo1"></div>
	<div id="foo1_length"></div>
	<div id="foo1_sum"></div>
	<div id="foo1_text"></div>
	<div id="foo1_text2"></div>
	<div id="foo1_sum2"></div>
	</body>
	</html>
	
Two generic algebras are always generated: Rendering of the datastructure as UL/LI-list, and a catamorphism that maps the datatstrucure to a tree of nested arrays. 

The HTML page will look like this in the browser:

	rendered with PHP:
    
    Foo
        list1 :: Nil | Cons = Cons
            head :: INT = 25
            tail :: Nil | Cons = Cons
                head :: INT = 38
                tail :: Nil | Cons = Nil
        list2 :: Nil | Cons = Cons
            head :: INT = 18
            tail :: Nil | Cons = Cons
                head :: INT = 65
                tail :: Nil | Cons = Cons
                    head :: INT = 9
                    tail :: Nil | Cons = Cons
                        head :: INT = 6
                        tail :: Nil | Cons = Cons
                            head :: INT = 30
                            tail :: Nil | Cons = Cons
                                head :: INT = 71
                                tail :: Nil | Cons = Nil
        info :: STRING = hello

    length: 8
    sum: 262
    text: 25 : 38 : [], 18 : 65 : 9 : 6 : 30 : 71 : []
    text2: [25, 38], [18, 65, 9, 6, 30, 71] hello
    sum (OneList): 63
    
    rendered with javascript: (click me)

    Foo
        list1 :: Nil | Cons = Cons
            head :: INT = 25
            tail :: Nil | Cons = Cons
                head :: INT = 38
                tail :: Nil | Cons = Nil
        list2 :: Nil | Cons = Cons
            head :: INT = 18
            tail :: Nil | Cons = Cons
                head :: INT = 65
                tail :: Nil | Cons = Cons
                    head :: INT = 9
                    tail :: Nil | Cons = Cons
                        head :: INT = 6
                        tail :: Nil | Cons = Cons
                            head :: INT = 30
                            tail :: Nil | Cons = Cons
                                head :: INT = 71
                                tail :: Nil | Cons = Nil
        info :: STRING = hello

    length: 8
    sum: 262
    text: 25 : 38 : [], 18 : 65 : 9 : 6 : 30 : 71 : []
    text2: [25, 38], [18, 65, 9, 6, 30, 71] hello
    sum (OneList): 63
    
#### Core idea

Each object of the datatype definition is compiled to an "object class" in the target language and has a "fold" method that takes an algebra as argument. Each datatype definition and each functor is compiled to a "functor class" in the target language. The functor class has a "fmapXXX" method for each object and takes care of the recursive evaluation of non-primitive properties. Each algebra extends a functor class and has a foldXXX method for each object class of the datatype, containing the user code.

When the fold method of an object class XXX is called, it calls the fmapXXX function of the algebra with the object as argument. This fmapXXX function evaluates the non-primitive properties of the object by calling fold recursively, and then it calls the foldXXX method of the algebra, and runs the user code. 

For example:

	foo.fold(algebra)

	-->

	return algebra.fmapFoo(foo)

	-->

	arg1 = foo.arg1                 // primitive type
	arg2 = foo.arg2.fold(algebra)   // non-primitive type, recursive call
	...
	return algebra.foldFoo(arg1, arg2, ..)  // call user code with evaluated arguments

#### Property-types, Maps and keyorders

The following property types are supported:

- Int
- Float
- String
- Bool
- List
- Map
- N-Tuple
- Classes that are defined by the datatype

There is a difficulty with the order of the elements when folding a Map. In PHP, associative arrays are used to implement a Map, and they preserve the order of elements. In Javascript, plain objects are used which do not preserve the order of the elements. For this reason, an algebra can have additional properties called "keyorder[NAME]" which are arrays with the keys of the elements of a Map. When a Map is folded, those arrays with keys are used to determine the order in which the Map is folded. 

The definition of the keyorder takes place in the functor and will be used by the algebras that extend the functor. When defining a functor, telling the compiler which keyorder property should be used for a Map looks like this:

	functor F1 :: MyDataType {
		
		Bla (info, my_map_property <- foo, more_stuff)
	}

Here the property 'my_map_property' is of type Map, and it should use the keyorder called 'foo'. The keyorder propertiy has to be set explicitly by the user in the program that uses the compiled files, like here for the algebra Alg:

	$i1 = new F1_Alg ();
	$i1->keyorder["foo"] = [1,2,5,3,11];

#### Status of the project

It's a proof on concept project, and many important things are missing:

- no documentation
- no typechecking 
- only a few primitive operations for the algebra language
- syntax is a weird mix of Haskell, Javascript and PHP
- no guarantee that the names of the generated files / classes are unique or valid
- no optimization of generated Javascript/PHP-code
- no distinction between the AST of the input language and the output langage 

I started to work on this project in 2015 and got sidetracked by the attempt to write a typechecker for it, until I did not have more time to work on it.

#### Conclusion

I'm not sure if this project was a good idea, because in languages like Elm or GHCJS it's easy to write catamorphisms and view functions for given datastructures using pattern matching. Also, the ability to extend datatstructures is problematic in this approach, because at the top of the program there is the full datastructure, and the functors are subsets of this datastructure. So one has to start with the "biggest" declaration and then one can only cut it down, instead of extending it. That feels a bit wrong.

However, I still like the idea of a catamorphism language where you define the algebras in a short and concise way and compile them to many target languages at once. One of the main motivations of this experiment was the need for "isomorphic" code for serverside PHP and clientside Javascript. I had to write the same "rendering" of json-structures for both tiers and wanted to have a tool to make this easy (although I never used this in production).

There are no real plans for the future of this project, only some ideas:

- Type parameters for objects
- Type-checker / type inference
- Backends for other languages like Elm, Haskell or Typescript, and maybe also for some Virtual DOM libraries
- Turning the compiler into a library for a server-side language



