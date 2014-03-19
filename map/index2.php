<!DOCTYPE html>
<html>
  <head>
    <title>Custom infowindow example | CartoDB.js</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <link rel="shortcut icon" href="http://cartodb.com/assets/favicon.ico" />
    <style>
      html, body, #map {
        height: 100%;
        padding: 0;
        margin: 0;
      }
    </style>

    <link rel="stylesheet" href="http://libs.cartodb.com/cartodb.js/v3/themes/css/cartodb.css" />
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="http://libs.cartodb.com/cartodb.js/v3/themes/css/cartodb.ie.css" />
    <![endif]-->
  </head>
  <body>
    <div id="map"></div>

    <script type="infowindow/html" id="infowindow_template">
      <span> custom </span>
      <div class="cartodb-popup">
        <a href="#close" class="cartodb-popup-close-button close">x</a>

         <div class="cartodb-popup-content-wrapper">
           <div class="cartodb-popup-content">
             <img style="width: 100%" src="http://rambo.webcindario.com/images/18447755.jpg"></src>
             <!-- content.data contains the field info -->
             <h4>{{content.data.name}}</h4>
           </div>
         </div>
         <div class="cartodb-popup-tip-container"></div>
      </div>
    </script>

    <script src="http://libs.cartodb.com/cartodb.js/v3/cartodb.js"></script>

    <script>
      function main() {
       var map = L.map('map').setView([39.8, -98.2], 5);


      mapboxUrl = 'http://{s}.tiles.mapbox.com/v3/mapbox.world-light/{z}/{x}/{y}.png';     
	  mapbox = new L.TileLayer(mapboxUrl, {maxZoom: 18, attribution: null, detectRetina:true});
	  map.addLayer(mapbox,true); 


        cartodb.createLayer(map, {
detectRetina:true,
  user_name: 'photogrammar',
  type: 'cartodb',
  sublayers: [{
    sql: "SELECT uscounties.cartodb_id,uscounties.name,uscounties.state_name,ST_SIMPLIFY(uscounties.the_geom_webmercator,0.0001) as the_geom_webmercator,ST_ASGEOJSON(ST_SIMPLIFY(uscounties.the_geom,0.0001)) as geometry,COUNT(*) as npics  FROM uscounties,fsadata WHERE uscounties.fips = fsadata.fips GROUP BY uscounties.cartodb_id;",
    cartocss: '#uscounties{line-color:#3b3b3b;line-opacity:1;line-width:1;polygon-opacity:0.8;}#uscounties[npics>200]{polygon-fill:#00250f;}#uscounties[npics<=200]{polygon-fill:#005824;}#uscounties[npics<=100]{polygon-fill:#238B45;}#uscounties[npics<=50]{polygon-fill:#41AE76;}#uscounties[npics<=25]{polygon-fill:#66C2A4;}#uscounties[npics<=14]{polygon-fill:#CCECE6;}#uscounties[npics<=7]{polygon-fill:#D7FAF4;}#uscounties[npics<=3]{polygon-fill:#EDF8FB;}'
  }]
})
         .addTo(map)
         .on('done', function(layer) {
           // get sublayer 0 and set the infowindow template
           var sublayer = layer.getSubLayer(0);

           sublayer.infowindow.set('template', $('#infowindow_template').html());
          }).on('error', function() {
            console.log("some error occurred");
          });
      }
      
      
      
 
      

      window.onload = main;
    </script>
  </body>
</html>