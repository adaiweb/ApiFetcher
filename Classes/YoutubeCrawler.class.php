<?php 

class YoutubeCrawler extends Crawler
{	

	public static function search($query){

<<<<<<< HEAD
		$url = API_BASE_URL.'?query='.urlencode($query).'&method=search&iaadminept=on';
 		$json = self::curl_get_contents($url);
=======
		$url = API_BASE_URL.'api.php?query='.urlencode($query).'&method=search&iaadminept=on';
	
		$json = self::curl_get_contents($url);
>>>>>>> e5555c22dc0cd4977702748f55d17cc2d48c2311

		return $json;

	}
	

}



 ?>