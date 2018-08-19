<?php
// Задача: с помощью рег. выражений выделить из текста слово 'king'
$text = 'I am the king and king-kong';
$index = file_get_contents('list_of_urls');
$link = 'https://ru.aliexpress.com/item/-/32887407506.html?spm=a2g0v.search0104.3.99.2bb5c3d4C6Fggf&s=p&ws_ab_test=searchweb0_0';
$pattern = "/https.*?html/";
$match = [];
preg_match_all($pattern, $index, $match);

print_r ($match[0]);
