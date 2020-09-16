<?php 	

function getJson($url){
	global $function;
	$file = $function->getWebPage($url);
	return json_decode($file, true);
}

 ?>