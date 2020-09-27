<?php 

function addQuery($line,$max=20,$fileName) {

    // Remove Empty Spaces
    // die($fileName);
    $file = array_filter(array_map("trim", explode(PHP_EOL,file_get_contents($fileName))));
    // die($file);

    // Make Sure you always have maximum number of lines
    $file = array_slice($file, 0, $max);

    // Remove any extra line 
    count($file) >= $max and array_shift($file);

    // Add new Line
    array_push($file, $line);

    // Save Result
    file_put_contents($fileName, implode(PHP_EOL, array_unique(array_filter($file))));
}

 ?>