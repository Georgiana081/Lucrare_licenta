<?php 
require_once 'config.php'; 
 
$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);  
  
if ($db->connect_errno) {  
    printf("Connect failed: %s\n", $db->connect_error);  
    exit();  
}