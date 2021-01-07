<?php 

class YoutubeCrawler extends Crawler
{	

	public static function search($query){

 
		$url = 'https://yt.ninja/@api/search/YouTube/'.urlencode($query); 
	
		$json = self::curl_get_contents($url);
 
		return $json;

	}
	

}



 ?>