<?php


function chunkAndFormatArray($array, $columns, callable $formatFunction, $shouldSort = false, callable $sortFunction = null) {
    if ($shouldSort) {
        if (isset($sortFunction) && $sortFunction != null) {
            uasort($array, $sortFunction);
        } else {
            asort($array);
        }
    }
    $chunks = array_chunk($array, ceil(count($array) / $columns));

    foreach ($chunks as $chunk) {
        if (isset($formatFunction) && $formatFunction != null) {
            $formatFunction($chunk);
        }
    }
}

?>