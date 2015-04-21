<?php
   include 'db.php';
   
   $file = $_GET['path'];
   $lat = $_GET['latitude'];
   $long = $_GET['longitude'];
   $time = $_GET['time'];
   
   $sql = mysql_query("INSERT INTO photos( path, latitude, longitude ) VALUES( '$path', '$latitude', '$longitude' )");

   if( !$sql )
	 die("ERROR");
   else
     die("Recorded");
   
   
?>