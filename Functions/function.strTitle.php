<?php 

function strTitle($string){
    return  mb_convert_case($string, MB_CASE_TITLE,  'UTF-8');
}


 ?>