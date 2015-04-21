function getContent(timestamp)
{
    var queryString = {'timestamp' : timestamp};

    $.ajax(
        {
            type: 'GET',
            url: 'http://127.0.0.1/PartyCloud/server.php',
            data: queryString,
            success: function(data){
              var json = jQuery.parseJSON(data);
		      var newtime = null;
			  
			  
			  $.each(json, function(idx, obj) {
			      var lat = obj.latitude;
				  var lon = obj.longitude;
				  var loc = "";
				  
				  $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?latlng=" + lat + "," + lon + "&key=AIzaSyBcJe3_BZbF6Zepsg-5S3QUG2IVLywA0rA",     function(data) {
					console.log(data.results);
					loc = data.results[1].formatted_address;
					
						$("<li onclick= change(" + obj.latitude + "," + obj.longitude + "); ><figure onclick=setImage('"+obj.path+"'); ><img src= uploads/" + obj.path + " ></figure> <h3>" + loc + "</h3></li>").hide().prependTo("#ticker-wrapper ul").fadeIn('slow');
							
							
						  var myLatlng = new google.maps.LatLng(obj.latitude,obj.longitude);
						   var marker = new google.maps.Marker({
								map: map,
								position: myLatlng,
								title: loc
							});
						   marker.setMap(map); 
		
							map.panTo(myLatlng);
							google.maps.event.addListener(marker, 'click',  function() {
							    console.log(marker.getPosition());
								calcRoute(marker.getPosition());
							  });
						    
					  });
				  
				  
				  newtime = obj.time;
			  });
		  
                getContent(newtime);
            }
        }
    );
}

function change( latitude, longitude ) {
   var myLatlng;
 
   if( latitude == -1 && longitude == -1 ) {
    myLatlng = pos;
	var infowindow = new google.maps.InfoWindow({
				map: map,
				position: pos,
				content: "I'm here"
			  });
	directionsDisplay.setDirections({routes: []});
	map.setZoom(16);
	}
   else
	myLatlng = new google.maps.LatLng(latitude,longitude);
	
	map.panTo(myLatlng);
}

function setImage( img ) {
	$("#popup_img").attr("src", "uploads/"+img);
	$("#popup").show();
}
