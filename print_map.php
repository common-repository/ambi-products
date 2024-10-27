<?php
/**
 * Project: rich
 * File Name: print_map.php
 * Author: Zameel Amjed
 * Date: 7/31/2019
 * Time: 10:29 AM
 */
function print_maps($coordinates = [], $url=null, $key){
	$draw =
		<<<EOD
		<div class="content">
<style>
     /* Always set the map height explicitly to define the size of the div
	  * element that contains the map. */
     #map {
     height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
	height: 100%;
	margin: 0;
	padding: 0;
}
    </style>
    <div class="overlay" style="height:300px;width:100%;">
    <div id="map"></div>
	</div><script>
EOD;
      // This example displays a marker at the center of Australia.
      // When the user clicks the marker, an info window opens.
$draw .= 'var loc = \''.json_encode($coordinates).'\';';
$draw .= 'var url = \''.$url.'\';';
$draw .=
	<<<EOD

function initMap() {
	      var colombo = {lat: 6.9192923, lng: 79.858891};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: colombo
        });
		var item = JSON.parse(loc);
		var seq = 0;
		var marker = [];
		var info = [];
		var infowindow = new google.maps.InfoWindow();
		for(var i = 0; i<item.length; i++){	
	      marker[i] = new google.maps.Marker({
          position: {lat:parseFloat(item[i].lat), lng:parseFloat(item[i].lng)},
          map: map,
          title: item[i].name,
          id: i
        });
        var image = '';
        if(item[i].image != ''){
        	image = '<img src="' + item[i].image +'" style="max-width: 200px;"/>';
        }
        
        marker[i].content = '<div>'+
            '<h3 id="firstHeading" class="firstHeading">' + item[i].name + '</h3>'+
            '<div id="bodyContent">'+
            image+
            '<p><a href="'+url+'?serial='+item[i].serial+'">Place an inquiry for this</a> '+
            '</p>'+
            '</div>'+
            '</div>';
         
        marker[i].addListener('click', function() {
      		infowindow.setContent(this.content);
    		infowindow.open(map, this);
        });
		} 
      }
    </script>
    
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=$key&callback=initMap">
    </script>
</div>
EOD;

return $draw;

?>


<?php } ?>