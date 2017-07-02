<?php
include("php/prelude.php");
include("php/M.php");
include("php/M_UL.php");
include("php/M_TREE.php");
include("php/M_I1.php");
include("php/M_I2.php");
$j = file_get_contents("data.json");
$a = json_decode($j, true);
print_r($a);
$p = Tree::fromJSON($a);
#echo $p->msg;
echo $p->fold(new M_UL());
echo "<br>";
echo $p->fold(new M_I1());
echo "<br>";
echo $p->fold(new M_I2());
echo "<br>";

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
</head>
<body>
<script type="text/javascript" src="jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/prelude.js"></script>
<script type="text/javascript" src="js/M.js"></script>
<script type="text/javascript" src="js/M_UL.js"></script>
<script type="text/javascript" src="js/M_TREE.js"></script>
<script type="text/javascript" src="js/M_I1.js"></script>
<script type="text/javascript" src="js/M_I2.js"></script>
<script type="text/javascript" >
var x = '<?= json_encode($p->toJSON()) ?>';
function doRender(){
    var p = Tree.fromJSON(JSON.parse(x));
    $("#result1").html(p.fold(new M_I1 ()));
    $("#show1").html(p.fold(new M_I2 ()));
}
function loadAndRender(url){
	$.get(url, function(data){
		console.log(data);
	    var p = Tree.fromJSON(data);
	    console.log("xxx", p.fold(new M_I1 ()));
	    $("#result1").html(p.fold(new M_I1 ()));
	    $("#show1").html(p.fold(new M_I2 ()));
	});
}
</script>
<h1 onclick="loadAndRender('data.json')">JS (click me)</h1>
<div id="result1" style="color:red;"></div>
<div id="show1"></div>
<h1 onclick="loadAndRender('data2.json')">click me 2</h1>
</body>
</html>
