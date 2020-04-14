<?php


function chunkAndFormatArray($array, $columns, callable $formatFunction) {
    $chunks = array_chunk($array, ceil(count($array) / $columns));

    foreach ($chunks as $chunk) {
        if (isset($formatFunction) && $formatFunction != null) {
            $formatFunction($chunk);
        }
    }
}

?>