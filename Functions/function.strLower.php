<?php 
function strLower($string){
    return  mb_convert_case($string, MB_CASE_LOWER,  'UTF-8');
}
 ?>