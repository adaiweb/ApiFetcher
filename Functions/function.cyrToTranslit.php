<?php   
function cyrToTranslit($string) {

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
 ?>