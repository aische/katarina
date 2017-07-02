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
		document.querySelector("#foo1").innerHTML = foo.fold (new Listexample_UL());
		document.querySelector("#foo1_length").innerHTML = "length: " + foo.fold (new Listexample_Length());
		document.querySelector("#foo1_sum").innerHTML = "sum: " + foo.fold (new Listexample_Summe());
		document.querySelector("#foo1_text").innerHTML = "text: " + foo.fold (new Listexample_Text());
		document.querySelector("#foo1_text2").innerHTML = "text2: " + foo.fold (new Listexample_Text2());
		document.querySelector("#foo1_sum2").innerHTML = "sum (OneList): " + foo.fold (new OneList_Summe2());
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
