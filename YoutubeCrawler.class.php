<?php 

class YoutubeCrawler
{

	public static function search($query){

		$url = 'https://api.bulbul.su/api.php?query='.urlencode($query).'&method=search&iaadminept=on';
	
		$json = get_web_page($url);

		return $json;

	}

}



 ?>