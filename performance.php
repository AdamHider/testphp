<?php

/*header("Content-type:text/plain");
$result = 0;

 */

$array = file_get_contents('list_of_urls');

//ПАРСИМ ТЕКСТОВЫЙ ФАЙЛ В МАССИВ ИЗ КРАСИВЫХ И ЧИТАБЕЛЬНЫХ ССЫЛОК
function parse_url_list($list_of_urls){
    $regexp = "/http.*?html/";
    $new_array = [];
    preg_match_all($regexp, $list_of_urls, $new_array);
    return $new_array[0];
}

//ГЛАВНАЯ ФУНКЦИЯ
function make_price_list($list_of_urls){
    $array_of_urls = parse_url_list($list_of_urls);
    $price_list = [];
    foreach ($array_of_urls as $row) {
        array_unshift($price_list, get_price($row));
    }
    return $price_list;
}

//ВЫТЯГИВАЕМ НУЖНЫЙ КУСОК HTML ИЗ ВСЕЙ СТРАНИЦЫ
function get_price($page_url){
    header('Content-type: text/plain');
    $html = file_get_contents($page_url);
    $leftover = 'span id="j-sku-discount-price" class="p-price"';
    $left_count = strlen($leftover);
    $start = strpos($html, $leftover)+$left_count;
    $end = strpos($html, '</span><span', $start);
    $final_text1 = substr($html, $start, $end-$start);
    return str_analisis($final_text1);
}

//ВЫТЯГИВАЕМ ЦЕНУ ИЗ КУСКА HTML
function str_analisis($string){
    $substitution = array("&nbsp;" => "");
    $string = strtr($string, $substitution);
    $regexp = '/[0-9]{1,5},[0-9]{2}/';
    $price_array = [];
    $temporary_matches = [];
    preg_match_all($regexp, $string, $temporary_matches);
    array_unshift($price_array, $temporary_matches[0]);
    return $price_array[0];
}

print_r (make_price_list($array));






