<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<style type="text/css">
* {box-sizing:border-box; -moz-box-sizing: border-box; }
body { font-size: 14px; line-height: 22px;}
</style>
</head>
<body onload="ini()">
<input type="file" id="file-input" />
<a href="javascript:exportFile()">save</a> |
<?php
include("php/prelude.php");
include("php/Foo.php");
include("php/Foo_UL.php");
include("php/Foo_TREE.php");
include("php/F_A1.php");
include("php/F_A2.php");
include("php/F_A3.php");
include("php/A1_I1.php");
include("php/A1_I3.php");
include("php/A1_I3Table.php");
include("php/A2_I5.php");
include("php/A3_ShowTestclasses.php");

$str = file_get_contents("example1.json");
$json = json_decode($str, true);
#print_r($json);
$p = Project::fromJSON($json);
#echo $p->msg;
#echo $p->fold(new FOO_UL());
#$i1 = new A1_I1 ();
#$i1->morestyle = "font-size: 24px;";
#echo $p->fold($i1);
$i1 = new A1_I1 ();
$i1->keyorder["foo"] = array(1,2,6); #array_keys ($p->attributes);
$i3 = new A1_I3 ();
$i3->attrs = $p->attributes;
$i3->keyorder["foo"] = $i1->keyorder["foo"];
$i3t = new A1_I3Table();
$i3t->keyorder["foo"] = $i1->keyorder["foo"];
?>
<a href="javascript: refreshAll()">refresh</a> |
<a href="javascript: refreshTreeUL()">refresh UL</a> |
<a href="javascript: refreshTreeULBig()">show all</a> |
<a href="javascript: refreshTestclassList()">show TCS</a>
<a href="javascript: addProduct()">+P</a>
<br> most red and pink values can be edited by clicking on it
<table width="100%">
<tr>
    <td width="40%" valign="top">
        <div id="o0">
        <h3>rendered by PHP:</h3>
        <?= $p->fold($i3) ?>
        </div>
    </td>
    <td width="200px" valign="top">
        <div id="tcs">
        <h3>rendered by PHP:</h3>
        <?= $p->fold(new A3_ShowTestclasses ()) ?>
        </div>
    </td>
    <td valign="top">
        <div id="o1">
        <h3>rendered by PHP:</h3>
        <?= $p->fold($i1) ?>
        </div>
    </td>
</table>
<div id="t1">
<?= $p->fold($i3t) ?>
</div>
<script type="text/javascript" src="jquery-1.11.2.min.js"></script>
<!-- <script type="text/javascript" src="jquery-ui.min.js"></script> -->
<script type="text/javascript" src="jquery.jeditable.mini.js" ></script>

<script type="text/javascript" src="js/prelude.js"></script>
<script type="text/javascript" src="js/Foo.js"></script>
<script type="text/javascript" src="js/Foo_UL.js"></script>
<script type="text/javascript" src="js/Foo_TREE.js"></script>
<script type="text/javascript" src="js/Foo_I2.js"></script>
<script type="text/javascript" src="js/F_A1.js"></script>
<script type="text/javascript" src="js/F_A2.js"></script>
<script type="text/javascript" src="js/F_A3.js"></script>
<script type="text/javascript" src="js/A1_I1.js"></script>
<script type="text/javascript" src="js/A1_I3.js"></script>
<script type="text/javascript" src="js/A1_I3Table.js"></script>
<script type="text/javascript" src="js/A2_I5.js"></script>
<script type="text/javascript" src="js/A3_ShowTestclasses.js"></script>
<script type="text/javascript">
var glob = {};
glob.x = '<?= json_encode($p->toJSON()) ?>';
function ini(){
    document.getElementById('file-input')
        .addEventListener('change', function (e) {importFile(e)}, false);

    glob.p = Project.fromJSON(JSON.parse(glob.x));
    //$("#o1").html(p.fold(new Foo_I2 ()));
    //var i1 = new A1_I1 ();
    //i1.morestyle = "font-size: 24px;";
    //$("#o2").html(p.fold(i1));
    //
    makeEditable ();
    glob.inj = {};
    glob.inj.i1 = new A1_I1 ();
    glob.inj.i1.keyorder["foo"] = [<?= implode(",", $i1->keyorder["foo"]) ?>];
    
    glob.inj.i3 = new A1_I3 ();
    glob.inj.i3.attrs = glob.p.attributes;
    glob.inj.i3.keyorder["foo"] = [<?= implode(",", $i1->keyorder["foo"]) ?>];

    glob.inj.i3t = new A1_I3Table ();
    //glob.inj.i3t.attrs = glob.p.attributes;
    glob.inj.i3t.keyorder["foo"] = [<?= implode(",", $i1->keyorder["foo"]) ?>];

    glob.inj.i2 = new Foo_I2 ();
    glob.inj.i5 = new A2_I5 ();
    glob.inj.itcs = new A3_ShowTestclasses ();

}

function makeEditable () {
    $('.edit').editable(function(value, settings) {
        //console.log("edit: ", value, this.dataset);
        switch (this.dataset.typ) {
            case "Value":
                var aid = this.dataset.aid;
                var pid = this.dataset.pid;
                glob.p.products[pid].values[aid].value = value;
                refreshTreeUL ();
                return value;
            case "Attribute.name":
                var aid = this.dataset.aid;
                glob.p.attributes[aid].name = value;
                refreshTreeUL ();
                return value;
            case "Attribute.type":
                var aid = this.dataset.aid;
                glob.p.attributes[aid].type = value;
                refreshTreeUL ();
                return value;
            case "Product.name":
                var pid = this.dataset.pid;
                glob.p.products[pid].name = value;
                refreshTreeUL ();
                return value;
            case "Project.name":
                glob.p.name = value;
                refreshTreeUL ();
                return value;
            case "Testclass.name":
                var tid = this.dataset.tid;
                glob.p.testclasses[tid].name = value;
                //refreshTreeUL ();
                refreshTestclassList ();
                return value;
            default:
                return "ERROR";
        }
    }, {
        placeholder: '<span style="color:red">---</span>',
        style: 'display: inline;'
    });
}

function refreshTree () {
    $("#o0").html("<h3>rendered by JS:</h3>" + glob.p.fold (glob.inj.i3));
    makeEditable ();
}

function refreshTreeUL () {
    $("#o1").html("<h3>rendered by JS:</h3>" + glob.p.fold (glob.inj.i1));
}

function refreshTreeULBig () {
    $("#o1").html("<h3>rendered by JS:</h3>" + glob.p.fold (glob.inj.i2));
}

function refreshTestclassList () {
    $("#tcs").html("<h3>rendered by JS:</h3>" + glob.p.fold (glob.inj.itcs));
}

function showTestclass (tid) {
    $("#o1").html("<h3>rendered by JS:</h3>" + glob.p.testclasses[tid].fold (glob.inj.i5));
    makeEditable ();
}

function refreshTable () {
    $("#t1").html("<h3>rendered by JS:</h3>" + glob.p.fold (glob.inj.i3t));
}

function addProduct () {
    var pid = 1 + Math.max(0, Math.max.apply(null, Object.keys(glob.p.products)));
    var p = Product.fromArgs(pid, "NEW");
    for (var aid in glob.p.attributes) {
        p.values[aid] = Value.fromArgs(aid, "");
    }
    glob.p.products[pid] = p;
    //console.log(glob.p.products[pid]);
    refreshAll ();
    //console.log(m);
}

function refreshAll () {
    refreshTreeUL ();
    refreshTestclassList ();
    refreshTable ();
    refreshTree ();
}

function importFile (e) {
    var file = e.target.files[0];
    if (!file) {
        return;
    }
    var reader = new FileReader();
    reader.onload = function(e) {
        var contents = e.target.result;
        var json = JSON.parse(contents);
        if (json) {
            var p = Project.fromJSON(json);
            if (p) {
                glob.p = p;
                refreshAll ();
            }
        }
    };
    reader.readAsText(file);
}

function exportFile () {
    var txt = JSON.stringify (glob.p.toJSON ());
    var textFileAsBlob = new Blob( [txt], {type:'text/plain'});
    var filename       = "project.txt";

    var downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.innerHTML = "Download File";

    if (window.webkitURL != null) { // Chrome allows the link to be clicked without actually adding it to the DOM.
        downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
    }
    else { // Firefox requires the link to be added to the DOM before it can be clicked.
        downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
        downloadLink.onclick = function (event) {
            document.body.removeChild(event.target);
        };
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
    }
    downloadLink.click();
}

</script>
</body>
</html>