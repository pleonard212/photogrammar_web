<?php $page = map; ?>
<?php include '../header.php'; ?>

 <link rel="stylesheet" href="http://libs.cartocdn.com/cartodb.js/v3/themes/css/cartodb.css" />
<!--[if lte IE 8]>
  <link rel="stylesheet" href="http://libs.cartocdn.com/cartodb.js/v3/themes/css/cartodb.ie.css" />
<![endif]-->
<script src="http://libs.cartocdn.com/cartodb.js/v3/cartodb.js"></script>

<style>
html, body, #map {
	height: 100%;
	width: 100%;
	overflow: hidden;
}
body {
	padding-top: 100px;
}
/* FIX for cosmetic bug in interaction between bootstrap and cartodb.js/Leaflet in popup box (broken right border) */

div.cartodb-popup div.cartodb-popup-content-wrapper { padding-right:210px;}
  

</style>

<div class="navbar navbar-fixed-top navbar-inverse" style="top: 50px; background-color:#777777;color:#fff;">
	<!-- Peter, put the search bar here! --->
	<div class="container">
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-left" style="line-height:3.4em;">
				<li class="">Year Range:</li>
				<li class="">Photographer:</li>
			</ul>
		</div>
	</div>
</div>



<div id="map"></div>
     <script type="infowindow/html" id="infowindow_template">
      
      <div class="cartodb-popup">
        <a href="#close" class="cartodb-popup-close-button close">x</a>
         <div class="cartodb-popup-content-wrapper">
           <div class="cartodb-popup-content">
                {{content.data.name}}, {{content.data.state_name}}<br/>
             <a href="http://photogrammar.yale.edu/search/results.php?start=0&search=&pname=&lot=&van=&state={{content.data.state_name}}&county={{content.data.name}}&city=&year_start=1935&month_start=0&year_stop=1945&month_stop=12" target="_blank">See {{content.data.npics}} Pictures</a>
           </div>
         </div>
         <div class="cartodb-popup-tip-container"></div>
      </div>
    </script>

 <script>
       function main() {
var map = L.map('map').setView([39.8, -98.2], 5);
mapboxUrl = 'http://{s}.tiles.mapbox.com/v3/mapbox.world-light/{z}/{x}/{y}.png';     
mapbox = new L.TileLayer(mapboxUrl, {maxZoom: 18, attribution: null, detectRetina:true});
map.addLayer(mapbox,true); 
/*

var seaver1937 = L.tileLayer.wms("http://kartor.32by32.com:8080/geoserver/Photogrammar/wms",{
	layers: 'Photogrammar:seaver1937geo',
	format: 'image/png',
	transparent: true,   
	attribution: '1937 Seaver', 
	detectRetina: true,
	opacity: 0.7    
});

*/



        cartodb.createLayer(map, 'http://photogrammar.cartodb.com/api/v2/viz/6a0e857e-4658-11e3-bf17-a739e2f77e9b/viz.json', {detectRetina: false})
         .addTo(map)
         .on('done', function(layer) {
           // get sublayer 0 and set the infowindow template
           var sublayer = layer.getSubLayer(0);

           sublayer.infowindow.set('template', $('#infowindow_template').html());
          }).on('error', function() {
            console.log("some error occurred");
          });

/*

.on('done', function(layer) {
	countysublayer = layer.getSubLayer(0);
	       
	countylayer = layer;
	  countylayer.setZIndex(99);
	map.addLayer(countylayer);
	
	countysublayer.infowindow.set('template', $('#infowindow_template').html());
}).on('error', function() {
	console.log("some error occurred");
}); 
*/

/*
var vizLayers = {};
var historicMaps = {'1937 Seaver<div class="slider" id="seaverslider" onmousedown="map.dragging.disable()"></div>': seaver1937};
map.addControl(new L.control.layers(vizLayers, historicMaps, {collapsed: false}));
*/
  };
    

   window.onload = main;
 </script>


<?php include '../footer.php'; ?>
