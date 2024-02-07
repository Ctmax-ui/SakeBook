<?php 
 $servername = "localhost";
 $username = "root";
 $userpass = "";
 $database = "sakebook";


 $connect = mysqli_connect($servername, $username, $userpass, $database) or die("Couldn't connect to Connect " . $connect->connect_error);
 
?>
