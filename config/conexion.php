<?php

$host = "sql103.infinityfree.com";

$user = "if0_42200629";

$password = "PVrF1abKOEgWt4";

$database = "if0_42200629_jcinvestments";

$conn = mysqli_connect($host,$user,$password,$database);

if(!$conn){

die("Error de conexión");

}

mysqli_set_charset($conn,"utf8");

?>