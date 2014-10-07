<?php
$myfile = fopen("movie.json", "r") or die("Unable to open file!");
$data = fread($myfile,filesize("movie.json"));
fclose($myfile);
header('Content-Type: application/json');
echo ($data);
?>