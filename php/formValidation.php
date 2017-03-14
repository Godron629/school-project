<?php

function regexForPhone($phone) {
	//Remove anything that's not a number
	return preg_replace("([^0-s]+)", "", $phone);
}

function regexForNames($text) {
	//Remove anything not a-z, apostrophe, hyphen or single space
	return preg_replace("/[^a-zA-Z '-]+/", "", $text);
}

?>