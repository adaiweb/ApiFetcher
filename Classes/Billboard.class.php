<?php 


class BillBoard extends Crawler {

	private static $base_url = 'https://www.billboard.com/';

	public static function getChart($type="songs",$slug=NULL){
		
		$url = self::$base_url.$slug;
		// die($url);

		$file = self::curl_get_contents($url);

		$posA = strpos($file, '<h1');

		$file2 = substr($file, $posA);

		$posB = strpos($file2,"<div class='ad_desktop dfp-ad dfp-ad-promo '");

		$file2 = substr($file2, 0, $posB);

		$html = str_get_html($file2);


		// $result['title'] = $html->find("meta[name=title]",0)->content;


		switch ($type) {
			case 'songs':

				$result['songs'] = self::crawlSongs($slug,$html);

				break;

			case 'vksongs':

				$songs = self::crawlSongs($slug,$html);

				$result['songs'] = self::crawlVK($songs);

				break;

			case 'artists':
				
				$result['artists'] = self::crawlArtists($slug,$html);

				break;
			
			default:
			die("ERROR");
					break;
		}

		return $result;


	}

	private static function crawlArtists($slug, $html){
	
		$artists = [];

		$artist_class = (strpos($slug, 'year') === false) ? ".chart-list-item__title-text" : ".ye-chart-item__title";
 
		foreach ($html->find($artist_class) as $key => $song_artist) {
			$artists[] = trim($song_artist->plaintext);

		}
		
		
		return $artists;
	}



	// private static function crawlVK($items){

	// 	$songs = []; 

	// 	foreach ($items as $key => $billboard_item) {
			
	// 		$myvkitem = array();

	// 		$title = $billboard_item['artist'].' '.$billboard_item['title'];
	// 		$url = 'http://api.bulbul.su/vk.api.php?query='.urlencode($title).'&method=search';
	// 		$file = get_web_page($url);
	// 		$json = json_decode($file, true);
	// 		$vksongs = $json['response']['items'];

	// 		$badwords = ['remix','cover','club','bass','karaoke','minus','mix','dj','version'];
			
	// 		foreach ($vksongs as $vkitem) {

	// 			if(strlen($vkitem['title']) == strlen($billboard_item['title'])) {
	// 				$myvkitem = $vkitem;
	// 				break;
	// 			}
	// 		}

		   
	// 	    if(empty($myvkitem)) {

	// 				foreach ($vksongs as $vkitem) {

	// 					if(strlen($vkitem['title']) != strlen(str_replace($badwords, '', mb_strtolower($vkitem['title'])))) continue;
	// 					else $myvkitem = $vkitem;
					 
	// 					if(!empty($myvkitem)) break;
	// 				}
	// 		}
			
	// 		if(empty($myvkitem)) $myvkitem = $vksongs[0];
 //   			else $songs[] = ['title'=>$myvkitem['title'],'artist'=>$myvkitem['artist'],'id'=>$myvkitem['id'],'owner_id'=>$myvkitem['owner_id'],'duration'=>$myvkitem['duration']];
	// 	}

	// 	return $songs;

	// }

	private static function crawlSongs($slug, $html){

		$songs = [];

		$song_class = (strpos($slug, 'year') === false) ? ".chart-element__information__song" : ".ye-chart-item__title";

		$artist_class = (strpos($slug, 'year') === false) ? ".chart-element__information__artist" : ".ye-chart-item__artist";


		foreach ($html->find($song_class) as $key => $song_title) {
			$songs[$key]['title'] = trim($song_title->plaintext);
		}
		foreach ($html->find($artist_class) as $key => $song_artist) {
			$songs[$key]['artist'] = trim($song_artist->plaintext);

		}

		return $songs;

	}
}

 ?>
