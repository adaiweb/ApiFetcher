<?php 

class YoutubeCrawler extends Crawler
{	

	public static function search($query){
 		
		$url = 'http://apich9999.mp3juices.red/api.php?query='.urlencode($query).'&iaadminept=true&method=search'; 

		$json = self::curl_get_contents($url);
		return $json;

	}
	

}



 ?>