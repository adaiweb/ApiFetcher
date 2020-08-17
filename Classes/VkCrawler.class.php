<?php 

class VkCrawler
{	


	public static function search($query){

		$url = API_BASE_URL.'vk.api.php?query='.urlencode($query).'&method=search&iaadminept=on';
		
		$json = self::curl_get_contents($url);

		return $json;

	}
	

	private static function curl_get_contents($url) {
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11) AppleWebKit/601.1.56 (KHTML, like Gecko) Version/9.0 Safari/601.1.56');

		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data;
	}
	

}



 ?>