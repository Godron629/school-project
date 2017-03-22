<?php


$date = date("Y-m-d");
$str = "test.xml";

$xml = simplexml_load_file("test.xml");
$xml_array = unserialize(serialize(json_decode(json_encode((array) $xml), 1)));

var_dump($xml_array);

echo $xml_array['entry'][0]['name'];

?>