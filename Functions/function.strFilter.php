<?php 	
function strFilter($q){
	global $function;
    $q = mb_strtolower($q, 'UTF-8');
    $q = $function->filterUnwantedLetters($q);
    $q=str_replace(array('Ѻ','ø'),'o',$q);
    $q = html_entity_decode($q, ENT_QUOTES | ENT_XML1, 'UTF-8');
    $q = preg_replace('/[^ёәқіңөһұүабвгдеёжзийклмнопрстуфхцчщшъыьэюяşçi̇üöğ0-9a-z ]/', ' ', $q);
    $q=@iconv("UTF-8", "UTF-8//IGNORE", $q);
    $q=preg_replace('/\s+/', ' ', $q);
    return trim($q);
}
 ?>