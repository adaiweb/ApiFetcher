<?php 
function shortNum($number, $precision = 0, $divisors = null)
{

  // Setup default $divisors if not provided
  if (!isset($divisors)) {
    $divisors = array(
      pow(1000, 0)=> '',
      pow(1000, 1)=> ' K',
      pow(1000, 2)=> ' M',
      pow(1000, 3)=> ' B',
      pow(1000, 4)=> ' TR.',
      pow(1000, 5)=> ' QW',
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


 ?>