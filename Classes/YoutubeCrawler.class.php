<?php 

class YoutubeCrawler
{

	public static function search($query){

		$url = $set['api']['base_url'].'?query='.urlencode($query).'&method=search&iaadminept=on';
	
		$json = get_web_page($url);

		return $json;

	}

}



 ?>