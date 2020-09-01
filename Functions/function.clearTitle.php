<?php 	

function clearTitle($string){

$pattern1 = '/(\(.*?\))/mi';
$replacement = '';
$new_string = preg_replace($pattern1, $replacement, $string);

$pattern2 = '/(\[.*?\])/mi';
$new_string = preg_replace($pattern2, $replacement, $new_string);

return $new_string;

	// $re = '/(.*?) (\(|\[|\|)/m';
/* strings:
    'GHOSTEMANE - Mercury (Extreme Bass boosted)
	GHOSTEMANE - Mercury [Lyrics / Lyric Video]
	Lady Gaga - Stupid Love |REACTION|';
RESULT:
	Match 1
Full match	GHOSTEMANE - Mercury (
Group 1.	GHOSTEMANE - Mercury
Group 2.	(
*/
	// preg_match($re, $string, $matches, PREG_OFFSET_CAPTURE, 0);

	// $newstring = !empty($matches[1][0]) ? $matches[1][0] : $string;

	// return $newstring;

}


 ?>