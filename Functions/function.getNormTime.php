<?php 
function getNormTime($youtube_time)
{
  $start = new DateTime('@0'); // Unix epoch
  $start->add(new DateInterval($youtube_time));
  return $start->format('i:s');

}
 ?>