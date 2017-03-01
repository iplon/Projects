<?php
$connect = mysql_connect('localhost','root','iplon321');
if (!$connect) { 
    die('Could not connect to MySQL: ' . mysql_error()); 
} 

$cid =mysql_select_db('rajapura',$connect); 
?>
