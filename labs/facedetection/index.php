<!DOCTYPE html>
<html>
<head>
	<title>Faces of the FSA/OWI</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:image" content="route.png" />
	<link rel="stylesheet" href="lib/leaflet/leaflet.css" />
	<link rel="stylesheet" href="lib/cluster/MarkerCluster.css" />		
	<link rel="stylesheet" href="Leaflet.Instagram.css" />
	<link rel="stylesheet" href="map.css" />
</head>
<body>
	<div id="map"></div>
	<script src="lib/reqwest.min.js"></script>
	<script src="lib/leaflet/leaflet.js"></script>
	<script src="lib/cluster/leaflet.markercluster.js"></script>			
	<script src="Leaflet.Instagram.Cluster.js"></script>	
	<script>

	var map = L.map('map', {
		maxZoom: 10
	}).fitBounds([[24.396308,-124.848974 ], [49.384358,-66.885444 ]]);

	L.tileLayer('http://{s}.tiles.mapbox.com/v3/mapbox.world-light/{z}/{x}/{y}.png', {detectRetina: true
	}).addTo(map);

	L.instagram.cluster('http://photogrammar2.cartodb.com/api/v2/sql?q=SELECT *  FROM faces2'
	).addTo(map); 
	


	</script>
</body>
</html>



