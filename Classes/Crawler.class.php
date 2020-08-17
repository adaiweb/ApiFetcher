<?php 

class Crawler
{	


	public static function search($query){

		$url = API_BASE_URL.'?query='.urlencode($query).'&method=search&iaadminept=on';
	
		$json = self::curl_get_contents($url);

		return $json;

	}

	

}



 ?>