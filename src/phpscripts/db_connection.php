<?php

function OpenCon()
 {
 $dbhost = "<HOSTNAME>";
 $dbuser = "<USERNAME>";
 $dbpass = "<PASSWORD>";
 $db = "<DBNAME>";


 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   
?>