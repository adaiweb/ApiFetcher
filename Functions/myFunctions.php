<?php

function detectLicencedContent($string){
  
  $dictionaryLicencedContent = ["audio","music video","official","премьера","клипа","mv"];
  $dictionaryNotLicencedContent = ["lyrics","слова","karaoke","remix","текст"];
  
  if(strlen($string) != strlen(str_replace($dictionaryNotLicencedContent,"",myLower($string)))) {
    return 0;
  } elseif (strlen($string) != strlen(str_replace($dictionaryLicencedContent,"",myLower($string)))) {
     return 1;
  } 

   return 0;
}


function shorterCount($number){
   // Setup default $divisors if not provided
  if (!isset($divisors)) {
    $divisors = array(
      pow(1000, 0)=> 1,
      pow(1000, 1)=> 10,
      pow(1000, 2)=> 1000,
      pow(1000, 3)=> 1000, 
    );
  }

  // Loop through each $divisor and find the
  // lowest amount that matches
  foreach ($divisors as $divisor => $shorthand) {
    if ($number < ($divisor * 1000)) {
      // We found a match!
      break;
    }
  }

  // We found our match, or there were no matches.
  // Either way, use the last defined value for $divisor.
  return number_format($number / $divisor, $precision);
}
function getReviewsData($song){

  
  
  
  $reviews['count'] =  shorterCount($song['listened'])+29;

  $reviews['rating'] = $song['likes']/$song['listened']*1000;

    if (!isset($divisors)) {
      $divisors = array(
        pow(2, 0)=> 3,
        pow(2, 1)=> 3,
        pow(2, 2)=> 3,
        pow(2, 3)=> 4,
        pow(2, 4)=> 5,
      );
    }
    
    // Loop through each $divisor and find the
  // lowest amount that matches
  foreach ($divisors as $divisor => $shorthand) {
    if ($reviews['rating'] < ($divisor )) {
      // We found a match!
      break;
    }
  }

   
  
  if($reviews['count']<5) $reviews['count'] = 10;
  if($shorthand > 5) $reviews['value'] = 5;
  elseif($shortand < 2) $reviews['value'] = 3;
  else $reviews['value'] = $shorthand;


  return $reviews;

}

function getPT($duration){
  $mytime = array();
  
 if( substr_count($duration,':') > 1) sscanf($duration, "%d:%d:%d", $mytime['hours'], $mytime['minutes'], $mytime['seconds']);
  else sscanf($duration, "%d:%d", $mytime['minutes'], $mytime['seconds']);
//P0DT0H3M7S
    return !empty($mytime['hours']) ? 'P0DT'. $mytime['hours'] .'H'. $mytime['minutes'] .'M'.$mytime['seconds'].'S' : 'P0DT0H'. $mytime['minutes'] .'M'.$mytime['seconds'].'S';
}
 

function filterUnwantedLetters($string){
  $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
$str = strtr( $string, $unwanted_array );
return $str;
}

function addNew($line,$max=20) {


    $fileName=$_SERVER['DOCUMENT_ROOT'].'/searches.txt';

    // Remove Empty Spaces
    $file = array_filter(array_map("trim", file($fileName)));

    // Make Sure you always have maximum number of lines
    $file = array_slice($file, 0, $max);

    // Remove any extra line 
    count($file) >= $max and array_shift($file);

    // Add new Line
    array_push($file, $line);

    // Save Result
    file_put_contents($fileName, implode(PHP_EOL, array_unique(array_filter($file))));
}




function myfiltr($q){
    $q = mb_strtolower($q, 'UTF-8');
    $q = filterUnwantedLetters($q);
    $q=str_replace(array('Ѻ','ø'),'o',$q);
    $q = html_entity_decode($q, ENT_QUOTES | ENT_XML1, 'UTF-8');
    $q = preg_replace('/[^ёәқіңөһұүабвгдеёжзийклмнопрстуфхцчщшъыьэюяşçi̇üöğ0-9a-z ]/', ' ', $q);
    $q=@iconv("UTF-8", "UTF-8//IGNORE", $q);
    $q=preg_replace('/\s+/', ' ', $q);
    return trim($q);
}
 
function WriteQuery($q){
    $file=$_SERVER['DOCUMENT_ROOT'].'/searches.txt';
 $armar=array();
$armar=unserialize( trim( @file_get_contents($file) ) );
    if(count($armar)<=1) $armar[3]="TOOL";
@array_unshift($armar, $q);
$armar = @array_unique($armar);
if(count($armar)>50) { $armar=array_chunk($armar, 50);  $armar=$armar[0];}
//print_r($armar);
$fff=fopen($file,w); flock($fff, LOCK_EX);
fputs($fff,serialize($armar) );
flock($fff, LOCK_UN); 
fclose($fff); 
}




function getApiUrl($query,$method){
  $key = strtolower(sha1($query));
  
  $hard_api = 'api.bulbul.su';
  $easy_apies = ['api1.fmp3.ru','api2.fmp3.ru'];

  // $api_ip = in_array($key{0}, range('a', 'k')) ? $hard_api :  $easy_apies[array_rand($easy_apies)];
  $api_ip = $hard_api;
       $params = array(
                                    'query'        => $query,
                                    'method'       => $method,
                                    'access_token' => md5(date("Y/m"))
                                  );

  $urlapi = 'http://'.$api_ip.'/api.php?'.http_build_query($params, '', '&');
  
  return $urlapi;
}


function getCache($query,$function,$function_param=''){
  
  global $redis;

$cache = $redis->get($query);
  if(empty($cache)):
    $cache = $function($function_param);
    $redis->set($query,$cache,8640);
  endif;
   
    if(!empty($cache)) $cache = json_decode($cache, true);

  return $cache;
}


 function minify_output($buffer)
{
  $search = array(
  '/\>[^\S ]+/s',
  '/[^\S ]+\</s',
  '/(\s)+/s'
  );
  $replace = array(
  '>',
  '<',
  '\\1'
  );
  if (preg_match("/\<html/i",$buffer) == 1 && preg_match("/\<\/html\>/i",$buffer) == 1) {
    $buffer = preg_replace($search, $replace, $buffer);
  }
return $buffer;
}
function cyr2translit($string) {

    $converter = array(

        'а' => 'a',   'б' => 'b',   'в' => 'v', 
        'г' => 'g',   'д' => 'd',   'е' => 'e', 
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z', 
        'и' => 'i',   'й' => 'y',   'к' => 'k', 
        'л' => 'l',   'м' => 'm',   'н' => 'n', 
        'о' => 'o',   'п' => 'p',   'р' => 'r', 
        'с' => 's',   'т' => 't',   'у' => 'u', 
        'ф' => 'f',   'х' => 'h',   'ц' => 'c', 
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch', 
        'ь' => '',  'ы' => 'y',   'ъ' => '', 
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        'ә' => 'ä',  'қ' => 'q',   'і' => 'i',
        'ң' => 'ñ',   'ғ' => 'ğ',  'ү' => 'ü',
        'ұ' => 'u',  'ө' => 'ö',  'һ' => 'h',   
    );

    return strtr($string, $converter);

}

function antiSpam($string) {
    $replace = array(
        '[b]','[/b]','[',
        ']', '(',')',
    );

    return trim(str_replace(array('()', '[]','"',"'"), '', preg_replace(array('((http:\/\/)?(www\.)?([\w\d-]*?\.)+(\w{2,4})/?([A-z0-9]*)?)si', '#<a.*\/a>#siU'), '', str_replace($replace, '', $string))));
}

function myLower($string){
    return  mb_convert_case($string, MB_CASE_LOWER,  'UTF-8');
}

function covtime($youtube_time)
{
  $start = new DateTime('@0'); // Unix epoch
  $start->add(new DateInterval($youtube_time));
  return $start->format('i:s');

}

function getRusDate($datetime) {
    $yy = (int) substr($datetime,0,4);
    $mm = (int) substr($datetime,5,2);
    $dd = (int) substr($datetime,8,2);

    $hours = substr($datetime,11,5);

    $month =  array ('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');

    return ($dd > 0 ? $dd . " " : '') . $month[$mm - 1]." ".$yy." г. " . $hours;
  }
function number_shorten($number, $precision = 0, $divisors = null)
{

  // Setup default $divisors if not provided
  if (!isset($divisors)) {
    $divisors = array(
      pow(1000, 0)=> '',
      pow(1000, 1)=> ' тыс.',
      pow(1000, 2)=> ' млн.',
      pow(1000, 3)=> ' млрд.',
      pow(1000, 4)=> ' трлн.',
      pow(1000, 5)=> ' квдрлн.',
    );
  }

  // Loop through each $divisor and find the
  // lowest amount that matches
  foreach ($divisors as $divisor => $shorthand) {
    if ($number < ($divisor * 1000)) {
      // We found a match!
      break;
    }
  }

  // We found our match, or there were no matches.
  // Either way, use the last defined value for $divisor.
  return number_format($number / $divisor, $precision) . $shorthand;
}


function timeinsec($str_time)
{
  //  $str_time = "23:12:95";

  $str_time     = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

  sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

  $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
  return ($time_seconds);
}

function fsz($bytes)
{
  if ($bytes >= 1073741824) {
    $bytes = number_format($bytes / 1073741824, 2) . ' GB';
  }
  elseif ($bytes >= 1048576) {
    $bytes = number_format($bytes / 1048576, 2) . ' MB';
  }
  elseif ($bytes >= 1024) {
    $bytes = number_format($bytes / 1024, 2) . ' KB';
  }
  elseif ($bytes > 1) {
    $bytes = $bytes . ' bytes';
  }
  elseif ($bytes == 1) {
    $bytes = $bytes . ' byte';
  }
  else {
    $bytes = '0 bytes';
  }

  return $bytes;
}

function myTitle($string){
    return  mb_convert_case($string, MB_CASE_TITLE,  'UTF-8');
}



// for those who has PHP older than version 5.3
class IDN {
    // adapt bias for punycode algorithm
    private static function punyAdapt(
        $delta,
        $numpoints,
        $firsttime
    ) {
        $delta = $firsttime ? $delta / 700 : $delta / 2;
        $delta += $delta / $numpoints;
        for ($k = 0; $delta > 455; $k += 36)
            $delta = intval($delta / 35);
        return $k + (36 * $delta) / ($delta + 38);
    }

    // translate character to punycode number
    private static function decodeDigit($cp) {
        $cp = strtolower($cp);
        if ($cp >= 'a' && $cp <= 'z')
            return ord($cp) - ord('a');
        elseif ($cp >= '0' && $cp <= '9')
            return ord($cp) - ord('0')+26;
    }

    // make utf8 string from unicode codepoint number
    private static function utf8($cp) {
        if ($cp < 128) return chr($cp);
        if ($cp < 2048)
            return chr(192+($cp >> 6)).chr(128+($cp & 63));
        if ($cp < 65536) return
            chr(224+($cp >> 12)).
            chr(128+(($cp >> 6) & 63)).
            chr(128+($cp & 63));
        if ($cp < 2097152) return
            chr(240+($cp >> 18)).
            chr(128+(($cp >> 12) & 63)).
            chr(128+(($cp >> 6) & 63)).
            chr(128+($cp & 63));
        // it should never get here
    }

    // main decoding function
    private static function decodePart($input) {
        if (substr($input,0,4) != "xn--") // prefix check...
            return $input;
        $input = substr($input,4); // discard prefix
        $a = explode("-",$input);
        if (count($a) > 1) {
            $input = str_split(array_pop($a));
            $output = str_split(implode("-",$a));
        } else {
            $output = array();
            $input = str_split($input);
        }
        $n = 128; $i = 0; $bias = 72; // init punycode vars
        while (!empty($input)) {
            $oldi = $i;
            $w = 1;
            for ($k = 36;;$k += 36) {
                $digit = IDN::decodeDigit(array_shift($input));
                $i += $digit * $w;
                if ($k <= $bias) $t = 1;
                elseif ($k >= $bias + 26) $t = 26;
                else $t = $k - $bias;
                if ($digit < $t) break;
                $w *= intval(36 - $t);
            }
            $bias = IDN::punyAdapt(
                $i-$oldi,
                count($output)+1,
                $oldi == 0
            );
            $n += intval($i / (count($output) + 1));
            $i %= count($output) + 1;
            array_splice($output,$i,0,array(IDN::utf8($n)));
            $i++;
        }
        return implode("",$output);
    }

    public static function decodeIDN($name) {
        // split it, parse it and put it back together
        return
            implode(
                ".",
                array_map("IDN::decodePart",explode(".",$name))
            );
    }

}


function write_history($query,$cookie_name,$max = 20,$ex_time = 2592000) {
  $line = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $query)));

  mb_internal_encoding("UTF-8");

    $l = mb_strtoupper(trim($line), 'UTF-8');



  if(!empty($_COOKIE[$cookie_name])) {
    $array_file = $_COOKIE[$cookie_name];
          // Remove Empty Spaces
      // $file = array_filter(array_map("trim",$array_file));
      $file = explode(";",$array_file);
      // Make Sure you always have maximum number of lines
      $file = array_slice($file, 0, $max);
     
      // Remove any extra line 
      count($file) >= $max and array_shift($file);

  }
  else $file = [];

      // Add new Line
      array_push($file, $line);

      $file = array_unique($file);
      // Save Result
      $archive = implode(";", array_filter($file));

      setcookie($cookie_name, $archive, time() + $ex_time);
      // return $json;
}


function get_history($cookie_name){
  if(!empty($_COOKIE[$cookie_name]))  $array = explode(";",$_COOKIE[$cookie_name]);
  else $array = [];

  return array_reverse($array,true);
}




function write_fav($array_song,$cookie_name,$max = 50,$ex_time = 2592000) {
  
  $line = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $query)));

  mb_internal_encoding("UTF-8");

    $l = mb_strtoupper(trim($line), 'UTF-8');



  if(!empty($_COOKIE[$cookie_name])) {
    $array_file = $_COOKIE[$cookie_name];
          // Remove Empty Spaces
      // $file = array_filter(array_map("trim",$array_file));
      $file = explode(";",$array_file);
      // Make Sure you always have maximum number of lines
      $file = array_slice($file, 0, $max);
     
      // Remove any extra line 
      count($file) >= $max and array_shift($file);

  }
  else $file = [];

      // Add new Line
      array_push($file, $line);

      $file = array_unique($file);
      // Save Result
      $archive = implode(";", array_filter($file));

      setcookie($cookie_name, $archive, time() + $ex_time);
      // return $json;
}


//table = user
//array = ["json"=>{json}]
//where = ["uid":123123];


// function updatePdo($pdo,$table,$array,$where){

// $array_values =array_values($array+$where);


//  $q = ""; 
//  foreach ($array as $key => $value) {
//     $q .= "`$key`=?";
//     if(!empty($array[$key+1])) $q .= ", ";
//   }

//   $query = "UPDATE `$table` SET $q";

//    if(!empty($where_array)){
//        $query.= " WHERE ";

//       foreach ($where_array as $key => $value) {
//         $q .= "`$key`= $value";  
//       }
//     }  
//     $query .= ";";


//   $query .= " WHERE ";
//   $query .= ";";
//   die($query);
//   $stmt = $pdo->prepare();

//      $stmt->execute($array_values); 
// }

//table = user
//where_array = ["uid"=>1231231,"name"=>"zaka","surname"=>aisabaev]
  // $insert_array = array("uid"=>$user['uid'], "profile"=>$user['profile'], "first_name"=>$user['first_name'], "last_name"=>$user['last_name']);

function createUser($pdo, $array){


     $query = "INSERT INTO `users` (uid, profile, first_name, last_name) VALUES (?, ?, ?, ?)";
       try
       {
        $stmt = $pdo->prepare($query);
        $stmt->execute(array_values($array)); 
       }
        catch(PDOException $e)
        {
        echo 'Query failed'.$e->getMessage();
        }
}

function getUser($pdo, $uid){


     $query = "SELECT * FROM `users` WHERE uid = ?";
       try
       {
        $stmt = $pdo->prepare($query);

         $stmt->execute([$uid]); 
       }
        catch(PDOException $e)
        {
        echo 'Query failed'.$e->getMessage();
        }
       return $stmt->fetch();
}


function insertPdo($pdo,$table,$array){
  $q_1 = "";
  $q_2 = "";
 foreach ($array as $key => $value) {
    $q_1 .= "`$key`";
    if(!empty($array[$key+1])) $q_1 .= ", ";

    $q_2 .= "?";
    if(!empty($array[$key+1])) $q_2 .= ", ";

  }
  $query = "INSERT INTO `$table` ($q_1) VALUES ($q_2)";
   try
   {
    $stmt = $pdo->prepare();

     $stmt->execute(array_values($array)); 
   }
    catch(PDOException $e)
    {
    echo 'Query failed'.$e->getMessage();
    }
}

function updateUserPlaylist($pdo,$json,$uid){
    $sql = "UPDATE `playlists` SET json=? WHERE uid=?";
     try
   {
     $stmt= $pdo->prepare($sql);
      $stmt->execute([$json, $uid]);

    }
    catch(PDOException $e)
    {
    echo 'Query failed'.$e->getMessage();
    }
}


function getUserPlaylist($pdo,$uid){
    $sql = "SELECT * FROM `playlists` WHERE uid=?";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$uid]);
    return $stmt->fetch();
}

function createUserPlaylist($pdo,$uid){
    $sql = "INSERT INTO `playlists` (uid) VALUES (?)";
   try
   {
   $stmt= $pdo->prepare($sql);
    $stmt->execute([$uid]);

    }
    catch(PDOException $e)
    {
    echo 'Query failed'.$e->getMessage();
    }


}



function selectPdo($pdo,$table,$where_array=NULL){
  $query = "SELECT * FROM `$table`";

    if(!empty($where_array)){
       $query.= " WHERE ";

      foreach ($where_array as $key => $value) {
        $query.= "`$key` = ?";
        if(!empty($where_array[$key+1])) $query .= " AND ";
      }
    }  
    $query .= ";";

            $stmt = $pdo->prepare($query);
            $stmt->execute($where_array);

    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$records) {
        // NO RECORDS FOUND
        return 'No records found.';
    }
    return $records;


}



function unique_multidim_array($array, $key = "id") {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

?>
