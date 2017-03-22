<?php

function regexForNames($string) {
	$string = preg_replace("/[^a-zA-Z0-9 -']/", "", $string);
	return $string;
}

function regexForPhone($phone) {
   $phone = preg_replace("([^0-s]+)", "", $phone);
   return $phone;
}

?>