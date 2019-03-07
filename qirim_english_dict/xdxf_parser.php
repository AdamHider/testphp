<?php

$xml = file_get_contents('dict_lite.xdxf');
$xml_object = explode("</ar>", $xml);
for($i=0;$i<count($xml_object); $i++){
    print_r($xml_object[$i]);
}
