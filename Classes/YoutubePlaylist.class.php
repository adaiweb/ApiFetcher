<?php 


class YoutubePlaylist { 
 
   function __construct(){

    try {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 9722);
        $this->redis->auth('zako@1996');

    } catch(RedisException $e) {
        exit('Connect error');
    } 

     
 }

private function curl_get_content($url)
{
  $uagent = "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14";

  $ch = curl_init( $url );

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
  curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
  curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
  curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
  curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа 

  $content = curl_exec( $ch );
  $err     = curl_errno( $ch );
  $errmsg  = curl_error( $ch );
  $header  = curl_getinfo( $ch );
  curl_close( $ch );

  $header['errno']   = $err;
  $header['errmsg']  = $errmsg;
  $header['content'] = $content;
  return $content;
} 


public function get($string){  

// $result = $this->redis->get('zplaylist'.$string);

if (empty($result))  { 

    // $token = 'AIzaSyBoAs5IcBObIbJJbypAPF6F1kjAIa04x-c'; 
  $tokens = ['AIzaSyBlNaM3lP4ZYmzqsJATgK5mfb9yLGGa2c4'];
    $token = $tokens[array_rand($tokens)];

                        $params = array(
                                    'playlistId'             => $string,
                                    'part'       => 'snippet,contentDetails',
                                    'maxResults' => '40',
                                    'key' => $token
                                  );


                    $url = 'https://www.googleapis.com/youtube/v3/playlistItems?'.http_build_query($params, '', '&');

    $result = $this->curl_get_content($url);
    $json = json_decode($result,true);

    $ids = NULL;
    if(!empty($json['items'])){
       $new_array = array();
     $new_array2 = [];
        foreach ($json['items'] as $key => $item) {
          $new_array2[] = array("id" => $item['contentDetails']['videoId'],"title" => $item['snippet']['title'],"author"=>$item['snippet']['channelTitle']); 
             $ids .= $item['contentDetails']['videoId'];
               if(!empty($json['items'][$key+1])) $ids .= ',';         
        }
        $new_array['playlist_id'] = $string;
        $new_array['data'] = $new_array2; 


         $params2 = array(
              'part'             => 'snippet,contentDetails,statistics',
              'id'          => $ids,
              'key'       => $token
            );
                $file = json_decode($this->curl_get_content('https://www.googleapis.com/youtube/v3/videos?'.http_build_query($params2, '', '&')), true);
                $q = 0;
                foreach($file['items'] as $video):
                  $snippet = $video['snippet'];
                  $content = $video['contentDetails'];
                    $statistics = $video['statistics']; 
                $new_array['data'][$q]['duration'] =  $content['duration'] ;
                 $new_array['data'][$q]['views'] = @$statistics['viewCount'];
                  $new_array['data'][$q]['likes'] = @$statistics['likeCount'];
              $q++;
                endforeach; 
                $json = $new_array;
     $this->redis->set('zplaylist'.$string, json_encode($new_array), 86400);
    } 
    else $this->redis->set('zplaylist'.$string, '', 60);
 
    
} else $json = json_decode($result, true); 

  return $json;
} 

 }

?>