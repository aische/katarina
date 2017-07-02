<?php

class A1_I3 extends F_A1 {
    public function __construct () {
    }
    
    public function foldProduct($pid, $name, $values){
        return ("\n        <li> \n            (" . $pid . ("):\n            <span class=\"edit\" \n                  style=\"color:green;\"\n                  data-pid=\"" . $pid . ("\"\n                  data-typ=\"Product.name\"\n                  >" . $name . ("</span>\n            <ul>" . implode("", $values) . ("</ul>\n        </li>")))));
    }
    
    public function foldAttribute($aid, $name, $type){
        return ("\n        <li> \n            (" . $aid . ("):\n            <span class=\"edit\" \n                  style=\"color:blue;\"\n                  data-aid=\"" . $aid . ("\"\n                  data-typ=\"Attribute.name\"\n                  >" . $name . ("</span> ::\n            <span class=\"edit\" \n                  style=\"color:magenta;\"\n                  data-aid=\"" . $aid . ("\"\n                  data-typ=\"Attribute.type\"\n                  >" . $type . ("</span>\n        </li> "))))));
    }
    
    public function foldValue($aid, $value){
        return ("\n        <li> \n            \n            " . $this->attrs[$aid]->name . (" =\n            <span class=\"edit\" \n                  style=\"color:red;\"\n                  data-aid=\"" . $aid . ("\"\n                  data-pid=\"" . $this->path[0]->pid . ("\"\n                  data-typ=\"Value\"\n            >" . $value . ("</span>\n        </li>")))));
    }
    
    public function foldProject($id, $name, $attributes, $products, $bla){
        return ("\n            Project(" . $id . ("):\n            <span class=\"edit\" \n                  style=\"color:red;\"\n                  data-id=\"" . $id . ("\"\n                  data-typ=\"Project.name\"\n            >" . $name . ("</span>\n            <br>Attributes:\n            <ul>" . implode("", $attributes) . ("</ul>\n            Products:\n            <ul>" . implode("", $products) . ("</ul>\n            "))))));
    }
    
    public function foldRange($min, $max){
        return "";
    }
}
