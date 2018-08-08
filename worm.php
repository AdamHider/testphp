<?php
set_time_limit(400);
ini_set('html_errors', false);
session_start();
header("Content-type: text/plain");

if( !isset($_SESSION['link_list']) ){
    $_SESSION['link_list']=[];
}
if( !isset($_SESSION['verificated_pages']) ){
    $_SESSION['verificated_pages']=[];
}

function scan_page($url){
    $html=file_get_contents($url);
    preg_match_all("/<a[^>]+href=\"([^\"]+)\"[^>]*>/",$html,$matches_links);
    preg_match_all('/<img[^>]+data\-original=\'([^\']+)\'[^>]*>/',$html,$matches_images);
    add_to_list($matches_links[1]);
    add_to_verificated($url);
    scan_next();
} 

function scan_next(){
   $unverificated = array_diff($_SESSION['link_list'], $_SESSION['verificated_pages']);
   if ( !isset($unverificated[0]) || count($_SESSION['link_list'])>2 ){
       return;
   }
   $url = $unverificated[0];
   scan_page($url); 
}

function add_to_verificated($url){
    $_SESSION['verificated_pages'][]=$url;
    $_SESSION['verificated_pages'] = array_unique($_SESSION['verificated_pages']);   
}

function add_to_list($new_scan){
    global $homepage;
    foreach($new_scan as $row){
        if (strpos($row, "https")!==false || strpos($row, "http")!==false || strpos($row, "#")!==false || strpos($row, "javascript")!==false){
           continue;
       }
       if (strpos($row, "https")===false && strpos($row, "lcwaikiki.com")===false ){
          $row = $homepage.$row; 
          $_SESSION ['link_list'][]=$row;
       }
       
       
    }
$_SESSION['link_list'] = array_unique($_SESSION ['link_list']);
}


print_r ($_SESSION['link_list']);
print_r ($_SESSION['verificated_pages']);

function download($src_list){
    $img_name = 1;
    foreach($src_list as $img_url){
        $img_name ++;
        copy($img_url, "img_folder/$img_name.jpeg");
    }
}

$homepage="https://www.lcwaikiki.com";

scan_page($homepage);

