<?php

class A1_I3Table extends F_A1 {
    public function __construct () {
    }
    
    public function foldProduct($pid, $name, $values){
        return ("\n        <tr>\n            <td>\n                " . $pid . ("\n            </td>\n            <td>\n                <span class=\"edit\" \n                      style=\"color:green;\"\n                      data-pid=\"" . $pid . ("\"\n                      data-typ=\"Product.name\"\n                      >" . $name . ("</span>\n            </td>\n            " . implode("", $values) . ("\n        </tr>")))));
    }
    
    public function foldAttribute($aid, $name, $type){
        return array(("\n        <td> \n            (" . $aid . (")\n        </td> \n        ")), ("\n        <td> \n            <span class=\"edit\" \n                  style=\"color:blue;\"\n                  data-aid=\"" . $aid . ("\"\n                  data-typ=\"Attribute.name\"\n            >" . $name . ("</span>\n        </td> \n        "))), ("\n        <td> \n            <span class=\"edit\" \n                  style=\"color:magenta;\"\n                  data-aid=\"" . $aid . ("\"\n                  data-typ=\"Attribute.type\"\n                  >" . $type . ("</span>\n        </td>"))));
    }
    
    public function foldValue($aid, $value){
        return ("\n        <td><span class=\"edit\" \n                  style=\"color:red;\"\n                  data-aid=\"" . $aid . ("\"\n                  data-pid=\"" . $this->path[0]->pid . ("\"\n                  data-typ=\"Value\"\n            >" . $value . ("</span>\n        </td>"))));
    }
    
    public function foldProject($id, $name, $attributes, $products, $bla){
        return ("\n            <table>\n                <tr><td></td><td></td>" . implode("", array_map(function($x){return $x[0];}, $attributes)) . ("</tr>\n                <tr><td></td><td></td>" . implode("", array_map(function($x){return $x[1];}, $attributes)) . ("</tr>\n                <tr><td></td><td></td>" . implode("", array_map(function($x){return $x[2];}, $attributes)) . ("</tr>\n                " . implode("", $products) . ("\n            </table>")))));
    }
    
    public function foldRange($min, $max){
        return "";
    }
}
