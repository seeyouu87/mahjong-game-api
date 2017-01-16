<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');
header("HTTP/1.1 "); //.strval($response_code));
http_response_code($response_code);

if(isset($json)){
log_message("error", "called json parse"); 
 echo json_encode($json);
die(); 
}
?>
