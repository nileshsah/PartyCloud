<?php
 
include 'db.php';

set_time_limit(0);
date_default_timezone_set("Asia/Calcutta");

while (true) {

    $last_ajax_call = isset($_GET['timestamp']) ? urldecode( $_GET['timestamp']) : null;
	
	$datetime_from = date("Y-m-d H:i:s",strtotime("-20 minutes",strtotime(date("Y-m-d H:i:s"))));
	
	if( $last_ajax_call == null )
	 $sql = mysql_query("SELECT * FROM photos WHERE time > '$datetime_from' " );
	else
	 $sql = mysql_query("SELECT * FROM photos WHERE time > '$last_ajax_call' LIMIT 5" );
   
    if ( mysql_num_rows($sql) > 0 ) {
		$result = array();
		
		while( $info = mysql_fetch_array( $sql ))
          {
			 array_push( $result, array( 'path' => $info['path'], 'latitude' => $info['latitude'], 'longitude' => $info['longitude'], 'time' => $info['time'] ) );
		  }
   
        $json = json_encode($result);
        echo $json;

        break;

    } else {
        sleep( 1 );
        continue;
    }
}