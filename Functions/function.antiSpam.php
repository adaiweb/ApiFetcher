<?php 	
function antiSpam($string) {
    $replace = array(
        '[b]','[/b]','[',
        ']', '(',')',
    );

    if(!empty($string)) return trim(str_replace(array('()', '[]','"',"'"), '', preg_replace(array('((http:\/\/)?(www\.)?([\w\d-]*?\.)+(\w{2,4})/?([A-z0-9]*)?)si', '#<a.*\/a>#siU'), '', str_replace($replace, '', $string))));
} ?>