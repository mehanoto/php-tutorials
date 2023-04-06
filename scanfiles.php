<?php

$dir = "./images";
$files = scandir($dir);
var_dump($files);

$scanned_directory = array_diff($files, array('..', '.'));
var_dump($scanned_directory);