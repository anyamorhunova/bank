<?php

$xml = file_get_contents('php://input');
$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($xml);
$file = fopen("C:\Users\zhoha\OneDrive\Desktop\Vsevolod's\Uni\web\Apache24\htdocs\lab9.xml", "r+");
fwrite($file, $dom->saveXML());
fclose($file);

?>