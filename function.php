<?php

/*header("Content-type:text/plain");
$result = 0;

 */
header('Content-type: text/plain');
$html = file_get_contents('cache');
$leftover = '<div class="fc__cur_val" data-type="fiz" data-group=0 data-cur="USD">';
$left_count = strlen($leftover);
$start = strpos($html, $leftover)+$left_count;
$end = strpos($html, "/", $start);
$var1 = substr($html, $start, $end-$start);
echo $var1;