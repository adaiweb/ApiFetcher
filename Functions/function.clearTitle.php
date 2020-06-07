<?php 	

function clearTitle($string){

	$re = '/(.*?) (\(|\[|\|)/m';
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
	preg_match($re, $string, $matches, PREG_OFFSET_CAPTURE, 0);

	return $matches[1];

}


 ?>