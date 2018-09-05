<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

<script type="text/javascript">
function fnGetLocation()
{
	var pickup = $('#pickup').val();
	var dropoff = $('#dropoff').val();
	var p_stops = [];
	var waypts = [];

	
	if(pickup!='' && dropoff!='' )
	{
		$('.stops').each(function() {
  			var pstop = $(this).val();
			if(pstop!='')
			{
				p_stops.push(pstop); 
			}
		});
		
		p_stops.forEach(function(val) {
			waypts.push({
          		location:val,
          		stopover:true
      		});

  		  // TODO: do something with the value
		});
		
	var request = {
      origin: pickup,
      destination: dropoff,
      waypoints: waypts,
      optimizeWaypoints: true,
      travelMode: google.maps.TravelMode.DRIVING
 	 };
	 
	 ///////////////////
	 var directionsService = new google.maps.DirectionsService();
	  directionsDisplay = new google.maps.DirectionsRenderer();
	  var mapOptions = {};
 // var chicago = new google.maps.LatLng(41.850033, -87.6500523);
 // var mapOptions = {
 //   zoom: 6,
  //  center: chicago
 // }
  map = new google.maps.Map(document.getElementById("show_map"), mapOptions);
  directionsDisplay.setMap(map);

	 
	 ////////////////////////////
	 directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      var route = response.routes[0];
      var summaryPanel = document.getElementById("directions_panel");
      summaryPanel.innerHTML = "";
      // For each route, display summary information.
	  var distance2 = 0;
      for (var i = 0; i < route.legs.length; i++) {
        var routeSegment = i+1;
        summaryPanel.innerHTML += "<b>Route Segment: " + routeSegment + "</b><br />";
        summaryPanel.innerHTML += route.legs[i].start_address + " to ";
        summaryPanel.innerHTML += route.legs[i].end_address + "<br />";
        summaryPanel.innerHTML += route.legs[i].distance.text + "<br /><br />";
		distance2 += parseInt(route.legs[i].distance.text.replace(',','').replace(' mi',''));
      }
	  document.getElementById("total_distance").innerHTML = "Total Distance = "+distance2+" Miles";
    }
	else
	{
		alert("Please varify your addresses");
	}
  });

	}
}
</script>
<input type="text" name="pickup" id="pickup" value="New Jersey Turnpike, Fort Lee, NJ, United States" onblur="fnGetLocation()" />
<input type="text" class="stops" name="location2" id="location2" value="Nashville, TN" onblur="fnGetLocation()" />
<input type="text" class="stops"  name="location3" id="location3" value="California City, CA" onblur="fnGetLocation()" />
<input type="text" name="dropoff" id="dropoff" value="Chicago Union Station, West Jackson Boulevard, Chicago, IL" onblur="fnGetLocation()" />
<br /><br />
<div id="total_distance"></div>
<div id="show_map" style="width:500px;height:500px"></div>
<div id="directions_panel" style="color:#FFF; background-color:#000; width:500px;"></div>