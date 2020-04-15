<?php


/**
 * Partitions array into given number of chunks and then applies the given function to each chunk.
 * @param $array array - list to partition
 * @param $columns int - number of chunks to create
 * @param callable $formatFunction the function to be applied on each chunk
 */
function chunkAndFormatArray($array, $columns, callable $formatFunction) {
    $chunks = array_chunk($array, ceil(count($array) / $columns));

    foreach ($chunks as $chunk) {
        if (isset($formatFunction) && $formatFunction != null) {
            $formatFunction($chunk);
        }
    }
}

?>