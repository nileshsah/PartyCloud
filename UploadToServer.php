<?php
 include 'db.php';
// Path to move uploaded files
$target_path = "uploads/";
 
// array for final json respone
$response = array();
 
// getting server ip address
$server_ip = gethostbyname(gethostname());
 
// final file url that is being uploaded
$file_upload_url = 'http://' . $server_ip . '/' . 'PartyCloud' . '/' . $target_path;
 
 
if (isset($_FILES['image']['name'])) {
    $target_path = $target_path . basename($_FILES['image']['name']);
 
    // reading other post parameters
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';
	
 
    $response['file_name'] = basename($_FILES['image']['name']);
 
    try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }
 
        // File successfully uploaded
        $response['message'] = 'File uploaded successfully!';
        $response['error'] = false;
        $response['file_path'] = $file_upload_url . basename($_FILES['image']['name']);
		
		 $fileName = basename($_FILES['image']['name']);
		 
		 $sql = mysql_query("INSERT INTO photos( path, latitude, longitude ) VALUES( '$fileName', '$latitude', '$longitude' )");
		 
    } catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
} else {
    // File parameter is missing
    $response['error'] = true;
    $response['message'] = 'Not received any file!F';
}
 
// Echo final json response to client
echo json_encode($response);
?>