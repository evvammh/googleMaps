<?PHP
if(isset($_POST['submitLogin']))
{
   if($fgmembersite->Login())
   {
       $fgmembersite->RedirectToURL("index.php");
     
   }
}
if(isset($_GET['register']))
{
    echo("<script>location.href = 'register.php';</script>");
}


?>
 <?php 
 $loc_str=" -95.7128910,37.0902400,0"; 
	 $speed="75";
   ?>
   
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAPDUET0Qt7p2VcSk6JNU1sBSM5jMcmVqUpI7aqV44cW1cEECiThQYkcZUPRJn9vy_TWxWvuLoOfSFBw" type="text/javascript"></script> 
    <script type="text/javascript">

</script>
    
	<body onunload="GUnload()"> 
  <!-- you can use tables or divs for the overall layout --> 
	<table border="0"> 
		<tr> 
			<td>
				<div id="message"></div> 		
				<div id="map" style="width:940px; height:450px"></div> 
			</td> 
			<td width = "150" valign="top" style="text-decoration: underline; color: #4444ff;"> 
				<div id="side_bar"></div> 
			</td> 
		</tr> 
    </table> 
   <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
      However, it seems JavaScript is either disabled or not supported by your browser. 
      To view Google Maps, enable JavaScript by changing your browser options, and then 
      try again.
    </noscript> 
   <script type="text/javascript">
   <?php echo"var loc_str2='".$loc_str."';";
   		 echo"var speed2='".$speed."';";
   ?>
   
	//<![CDATA[
   if (GBrowserIsCompatible()) {
   var geo;
    var reasons=[];
      // this variable will collect the html which will eventually be placed in the side_bar
      var side_bar_html = "";
      // arrays to hold copies of the markers and html used by the side_bar
      // because the function closure trick doesnt work there
      var gmarkers = [];
      var htmls = [];
      var i = 0;
	  geo = new GClientGeocoder(); 
 
      // ====== Array for decoding the failure codes ======
      reasons[G_GEO_SUCCESS]            = "Success";
      reasons[G_GEO_MISSING_ADDRESS]    = "Missing Address: The address was either missing or had no value.";
      reasons[G_GEO_UNKNOWN_ADDRESS]    = "Unknown Address:  No corresponding geographic location could be found for the specified address.";
      reasons[G_GEO_UNAVAILABLE_ADDRESS]= "Unavailable Address:  The geocode for the given address cannot be returned due to legal or contractual reasons.";
      reasons[G_GEO_BAD_KEY]            = "Bad Key: The API key is either invalid or does not match the domain for which it was given";
      reasons[G_GEO_TOO_MANY_QUERIES]   = "Too Many Queries: The daily geocoding quota for this site has been exceeded.";
      reasons[G_GEO_SERVER_ERROR]   
	  
	  
	  function place(lat,lng) {
        var point = new GLatLng(lat,lng);
        map.setCenter(point,14); 
		var startPoint=point;
		 var speed = document.getElementById("txtSpeed").value;
			  
			  var color=new Array(); // regular array (add an optional integer
	color[1]="red";       // argument to control array's size)
	color[2]="black";
	color[3]="blue";
			  for (var a = 1; a <= 3 ; a+=1 )
    {
	drawCircle(map, startPoint, parseInt(speed)*(0.1*a), 40,color[a]);
	}
        map.addOverlay(new GMarker(point));
        document.getElementById("message").innerHTML = "";
      }
 
      // ====== Geocoding ======
      function showAddress() {
		  
        var search = document.getElementById("search").value;
        // ====== Perform the Geocoding ======        
        geo.getLocations(search, function (result)
          {
            map.clearOverlays(); 
            if (result.Status.code == G_GEO_SUCCESS) {
              // ===== If there was more than one result, "ask did you mean" on them all =====
              if (result.Placemark.length > 1) { 
                document.getElementById("message").innerHTML = "Did you mean:";
                // Loop through the results
                for (var i=0; i<result.Placemark.length; i++) {
                  var p = result.Placemark[i].Point.coordinates;
                  document.getElementById("message").innerHTML += "<br>"+(i+1)+": <a href='javascript:place(" +p[1]+","+p[0]+")'>"+ result.Placemark[i].address+"<\/a>";
                }
              }
              // ===== If there was a single marker =====
              else {
                document.getElementById("message").innerHTML = "";
                var p = result.Placemark[0].Point.coordinates;
                place(p[1],p[0]);
              }
			  
			  
            }
            // ====== Decode the error status ======
            else {
              var reason="Code "+result.Status.code;
              if (reasons[result.Status.code]) {
                reason = reasons[result.Status.code]
              } 
              alert('Could not find "'+search+ '" ' + reason);
            }
          }
        );
      }
    // A function to create the marker and set up the event window
      function createMarker(point,name,html) {
        var marker = new GMarker(point);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        // save the info we need to use later for the side_bar
        gmarkers[i] = marker;
        htmls[i] = html;
        // add a line to the side_bar html
        side_bar_html += '<a href="javascript:myclick(' + i + ')">' + name + '<\/a><br>';
        i++;
        return marker;
      }
      // This function picks up the click and opens the corresponding info window
      function myclick(i) {
        gmarkers[i].openInfoWindowHtml(htmls[i]);
      }
     // create the map
      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GSmallMapControl());
	  
	  map.setMapType( G_HYBRID_MAP );
      map.addControl(new GMapTypeControl());
	
	  data1=loc_str2.split(',');
      map.setCenter(new GLatLng( data1[1],data1[0]), 4);
	  var startPoint=new GLatLng(data1[1],data1[0]);
	//   var startPoint1=new GLatLng( 19.907787,-79.359741);
	
	var color=new Array(); // regular array (add an optional integer
	color[1]="red";       // argument to control array's size)
	color[2]="black";
	color[3]="blue";

	for (var a = 1; a <= 3 ; a+=1 )
    { try{//to fix the issue in mozilla
	drawCircle(map, startPoint, parseInt((speed2))*(a), 40,color[a]);
    }catch(e){
       // alert("called");
    }
	}
    var poly = [] ; 

        var line ; 

      var side_bar_html = "";
     // === Define the function thats going to process the text file ===
      process_it = function(doc) {
        // === split the document into lines ===
        lines = doc.split("\n");
        for (var i=0; i<lines.length; i++) {
          if (lines[i].length > 1) {
            // === split each line into parts separated by "|" and use the contents ===
            parts = lines[i].split("|");
            var lat = parseFloat(parts[0]);
            var lng = parseFloat(parts[1]);
            var html = '<div><img src="images/advertise.png" alt="Big Boat" />'+parts[2];
            var label = parts[3];
            var point = new GLatLng(lat,lng);
            // create the marker
            var marker = createMarker(point,label,html);
            map.addOverlay(marker);
          }
        }
        // put the assembled side_bar_html contents into the side_bar div
        document.getElementById("side_bar").innerHTML = side_bar_html;
      }          
          
      GDownloadUrl("example.txt", process_it);
	   function drawCircle(map, center, radius, numPoints,color)

        {

            poly = [] ; 
var color=color;
            var lat = center.lat() ;
			var lng = center.lng() ;
            var d2r = Math.PI/180 ;                // degrees to radians
            var r2d = 180/Math.PI ;                // radians to degrees
            var Clat = (radius/3963) * r2d ;      //  using 3963 as earths radius
            var Clng = Clat/Math.cos(lat*d2r); 
            //Add each point in the circle
            for (var i = 0 ; i < numPoints ; i++)
            {
                var theta = Math.PI * (i / (numPoints / 2)) ;
				Cx = lng + (Clng * Math.cos(theta)) ;
				Cy = lat + (Clat * Math.sin(theta)) ;
                poly.push(new GLatLng(Cy,Cx)) ;

            }
   			poly.push(poly[0]) ;
        //Create a line with teh points from poly, red, 3 pixels wide, 80% opaque
  			line = new GPolyline(poly,color, 3, 0.8) ;
			map.addOverlay(line) ;
		}
 }
 
    else {
		alert("Sorry, the Google Maps API is not compatible with this browser");
		}
    </script> 
<form onsubmit="showAddress(); return false" action="#"> 
	<table height="10" bgcolor="#EEFFFF" width="940">
		<tr width="940">
			<td nowrap >Plan your next golf tip below.Just tell us where you'll start and how far You can go. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
			<td><input id="search" size="30" type="text" value="<?=($_SESSION["default_airport"]==""? "U.S.A.":$_SESSION["default_airport"]) ?>" onfocus="if(this.value=='<?=($_SESSION["default_airport"]==""? "U.S.A.":$_SESSION["default_airport"]) ?>'){this.value=''}" onblur="if(this.value==''){this.value='<?=($_SESSION["default_airport"]==""? "U.S.A.":$_SESSION["default_airport"]) ?>'}">
				<input type='text' name='txtSpeed' id='txtSpeed' value="<?=($_SESSION["default_airspeed"]==""? "2":$_SESSION["default_airspeed"]) ?>" maxlength="50" onfocus="if(this.value=='<?=($_SESSION["default_airspeed"]==""? "2":$_SESSION["default_airspeed"]) ?>'){this.value=''}" onblur="if(this.value==''){this.value='<?=($_SESSION["default_airspeed"]==""? "2":$_SESSION["default_airspeed"]) ?>'}"/>     
				<input type="submit" value="MAP!" />
			</td>
		</tr>
		<tr>
			<td colspan="2" nowrap>(To skip this step in future simply register with us and we will keep this infromation for you)
			</td>
		</tr>
	</table>
</form>  
<div>
	<table>
		<tr>
			<td width="300" height="300"><?php include_once("add.php");?>
			</td>
			<td width="380" height="300"><?php include_once("Feature.php");?>
			</td>
			<td><?php include_once("login.php"); ?>
			</td>  
		</tr>
	</table>
</div>
</body>