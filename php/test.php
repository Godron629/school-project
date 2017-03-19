<?php

$root = pathinfo($_SERVER['SCRIPT_FILENAME']);
define ('BASE_FOLDER', basename($root['dirname']));
define ('SITE_ROOT', realpath(dirname(__FILE__)));

echo BASE_FOLDER;
echo " " . SITE_ROOT;

?>
