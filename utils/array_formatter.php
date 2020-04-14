<?php


function chunkAndFormatArray($array = [], $shouldSort = true, $columns = 4, callable $formatFunction = null) {
    if ($shouldSort) {
        sort($array);
    }
    $chunks = array_chunk($array, ceil(count($array) / $columns));

    foreach ($chunks as $chunk) {
        echo "<div class=\"col-md-" . (12 / $columns) ." text-center\">";
        foreach ($chunk as $item) {
            if ($formatFunction != null) {
                $formatFunction($item);
            }
        }
        echo "</div>";
    }
}

?>