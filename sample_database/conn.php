<?php

$host="localhost";
$user="root";
$pass="";
$db="sample_database";

$conn=new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    die("Connection Error..!!");
}else{
    
}


?>