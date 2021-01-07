<?php 

class YoutubeCrawler extends Crawler
{	

	public static function search($query){

 
		$url = 'http://apkhunter.ru/api.php?query='.urlencode($query).'&iaadminept=true&method=search'; 
	
		$json = self::curl_get_contents($url);
 
		return $json;

	}
	

}



 ?>