<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>BootLeaf Template</title>

        <!-- Core CSS -->
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.css" rel="stylesheet" type="text/css">
        <link href="assets/leaflet-sidebar/L.Control.Sidebar.css" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template -->
        <style>
            html, body, #map {
                height: 100%;
                width: 100%;
                overflow: hidden;
            }
            body {
                padding-top: 50px;
            }
            input[type="radio"], input[type="checkbox"] {
                margin: 0;
            }
            #loading {
                position: absolute;
                width: 220px;
                height: 19px;
                top: 50%;
                left: 50%;
                margin: -10px 0 0 -110px;
                z-index: 20001;
            }
            .leaflet-control-layers label {
                font-weight: normal;
                margin-bottom: 0px;
            }
            .table {
                margin-bottom: 0px;
            }
            .navbar .navbar-brand {
                font-weight: bold;
                font-size: 25px;
                color: white;
            }
            .navbar-collapse.in {
                overflow-y: hidden;
            }
            .typeahead {
                background-color: #FFFFFF;
            }
            .tt-dropdown-menu {
                background-color: #FFFFFF;
                border: 1px solid rgba(0, 0, 0, 0.2);
                border-radius: 4px 4px 4px 4px;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
                margin-top: 4px;
                padding: 4px 0;
                width: 100%;
                max-height: 300px;
                overflow: auto;
            }
            .tt-suggestion {
                font-size: 14px;
                line-height: 20px;
                padding: 3px 10px;
            }
            .tt-suggestion.tt-cursor {
                background-color: #0097CF;
                color: #FFFFFF;
                cursor: pointer;
            }
            .tt-suggestion p {
                margin: 0;
            }
            .tt-suggestion + .tt-suggestion {
                border-top: 1px solid #ccc;
            }
            .typeahead-header {
                margin: 0 5px 5px 5px;
                padding: 3px 0;
                border-bottom: 2px solid #333;
            }
            .has-feedback .form-control-feedback {
                position: absolute;
                top: 0;
                right: 0;
                display: block;
                width: 34px;
                height: 34px;
                line-height: 34px;
                text-align: center;
            }
            .leaflet-popup-content {
                margin-top: 5px;
                margin-bottom: 5px;
                margin-left: 5px;
                margin-right: 5px;
            }
            .leaflet-popup-content-wrapper {
                border-radius: 5px;
            }
            .leaflet-sidebar {
                z-index: 1020;
            }
            .leaflet-sidebar .close {
                right: 0px;
                top: 5px;
                background: transparent;
            }
            @media (max-width: 992px) {
                .navbar .navbar-brand {
                    font-size: 18px;
                }
            }
            @media (max-width: 767px){
                .url-break {
                    word-break: break-all;
                    word-break: break-word;
                    -webkit-hyphens: auto;
                    hyphens: auto;
                }
            }
            /* Print Handling */
            @media print {
                .navbar {
                    display: none !important;
                }
                .leaflet-control-container {
                    display: none !important;
                }
            }
        </style>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">BootLeaf</a>
            </div>
            <div class="navbar-collapse collapse">
                <form class="navbar-form navbar-right" role="search">
                    <div class="form-group has-feedback navbar-right">
                        <input id="searchbox" type="text" placeholder="Search" class="form-control">
                        <span id="searchicon" class="fa fa-search form-control-feedback"></span>
                    </div>
                </form>
                <ul class="nav navbar-nav">
                    <li><a href="#aboutModal" data-toggle="modal"><i class="fa fa-question-circle" style="color: white"></i>&nbsp;&nbsp;About</a></li>
                    <li class="dropdown">
                        <a id="toolsDrop" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-globe" style="color: white"></i>&nbsp;&nbsp;Tools <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" onclick="map.fitBounds(boroughs.getBounds()); return false;"><i class="fa fa-arrows-alt"></i>&nbsp;&nbsp;Zoom To Full Extent</a></li>
                            <li><a href="#legendModal" data-toggle="modal"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Show Legend</a></li>
                            <li class="divider hidden-xs"></li>
                                <li><a href="#loginModal" data-toggle="modal"><i class="fa fa-user"></i>&nbsp;&nbsp;Login</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a id="downloadDrop" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cloud-download" style="color: white"></i>&nbsp;&nbsp;Download <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="data/boroughs.geojson" download="boroughs.geojson" target="_blank" data-toggle="collapse" data-target=".navbar-collapse.in"><i class="fa fa-download"></i>&nbsp;&nbsp;Boroughs</a></li>
                            <li><a href="data/subways.geojson" download="subways.geojson" target="_blank" data-toggle="collapse" data-target=".navbar-collapse.in"><i class="fa fa-download"></i>&nbsp;&nbsp;Subway Lines</a></li>
                            <li><a href="data/DOITT_THEATER_01_13SEPT2010.geojson" download="theaters.geojson" target="_blank" data-toggle="collapse" data-target=".navbar-collapse.in"><i class="fa fa-download"></i>&nbsp;&nbsp;Theaters</a></li>
                            <li><a href="data/DOITT_MUSEUM_01_13SEPT2010.geojson" download="museums.geojson" target="_blank" data-toggle="collapse" data-target=".navbar-collapse.in"><i class="fa fa-download"></i>&nbsp;&nbsp;Museums</a></li>
                        </ul>
                    </li>
                    <li><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" onclick="sidebar.toggle(); return false;"><i class="fa fa-list" style="color: white"></i>&nbsp;&nbsp;Sidebar</a></li>
                </ul>
            </div><!--/.navbar-collapse -->
        </div>

        <div id="map"></div>
        <div id="sidebar">
            <h2>leaflet-sidebar</h2>
            <p>A <a href="https://github.com/turbo87/leaflet-sidebar/">responsive sidebar plugin</a> for <a href="http://leafletjs.com/">Leaflet</a>, a JS library for interactive maps.</p>
            <p class="lorem">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
            <p class="lorem">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
            <p class="lorem">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
            <p class="lorem">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
        </div>
        <div id="loading" style="display:block;">
            <div class="loading-indicator">
                <div class="progress progress-striped active">
                    <div class="progress-bar progress-bar-info" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="aboutModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Welcome to the BootLeaf template!</h4>
                    </div>

                    <div class="modal-body">
                         <ul id="aboutTabs" class="nav nav-tabs">
                            <li class="active"><a href="#about" data-toggle="tab"><i class="fa fa-question-circle"></i>&nbsp;About the project</a></li>
                            <li><a href="#contact" data-toggle="tab"><i class="fa fa-envelope"></i>&nbsp;Contact us</a></li>
                            <li><a href="#disclaimer" data-toggle="tab"><i class="fa fa-exclamation-circle"></i>&nbsp;Disclaimer</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-globe"></i>&nbsp;Metadata <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#boroughs-tab" data-toggle="tab">Boroughs</a></li>
                                    <li><a href="#subway-lines-tab" data-toggle="tab">Subway Lines</a></li>
                                    <li><a href="#theaters-tab" data-toggle="tab">Theaters</a></li>
                                    <li><a href="#museums-tab" data-toggle="tab">Museums</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div id="aboutTabsContent" class="tab-content" style="padding-top: 10px;">
                            <div class="tab-pane fade active in" id="about">
                                <p>A simple, responsive template for building web mapping applications with <a href="http://getbootstrap.com/">Bootstrap 3</a>, <a href="http://leafletjs.com/" target="_blank">Leaflet</a>, and <a href="http://twitter.github.io/typeahead.js/" target="_blank">typeahead.js</a>. Open source, MIT licensed, and available on <a href="https://github.com/bmcbride/bootleaf" target="_blank">GitHub</a>.</p>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Features
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item">Fullscreen mobile-friendly map template with responsive navbar and modal placeholders</li>
                                        <li class="list-group-item">jQuery loading of external GeoJSON files</li>
                                        <li class="list-group-item">Elegant client-side multi-layer feature search with autocomplete using <a href="http://twitter.github.io/typeahead.js/" target="_blank">typeahead.js</a></li>
                                        <li class="list-group-item">Integration of Bootstrap tables into Leaflet popups</li>
                                        <li class="list-group-item">Logic for minimizing layer control and switching to modal popups on small screens</li>
                                        <li class="list-group-item">Responsive sidebar functionality via the <a href="https://github.com/turbo87/leaflet-sidebar/" target="_blank">leaflet-sidebar</a> plugin</li>
                                        <li class="list-group-item">Marker icons included in layer control</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane fade text-danger" id="disclaimer">
                                <p>The data provided on this site is for informational and planning purposes only.</p>
                                <p>Absolutely no accuracy or completeness guarantee is implied or intended. All information on this map is subject to such variations and corrections as might result from a complete title search and/or accurate field survey.</p>
                            </div>
                            <div class="tab-pane fade" id="contact">
                                <form id="contact-form">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" id="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="text" class="form-control" id="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="comment">Comment:</label>
                                            <textarea class="form-control" rows="3" id="comment"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary pull-right" data-dismiss="modal">Submit</button>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="boroughs-tab">
                                <p>Borough data courtesy of <a href="http://www.nyc.gov/html/dcp/html/bytes/meta_dis_nyboroughwi.shtml" target="_blank">New York City Department of City Planning</a></p>
                            </div>
                            <div class="tab-pane fade" id="subway-lines-tab">
                                <p><a href="http://spatialityblog.com/2010/07/08/mta-gis-data-update/#datalinks" target="_blank">MTA Subway data</a> courtesy of the <a href="http://www.urbanresearch.org/about/cur-components/cuny-mapping-service" target="_blank">CUNY Mapping Service at the Center for Urban Research</a></p>
                            </div>
                            <div class="tab-pane fade" id="theaters-tab">
                                <p>Theater data courtesy of <a href="https://data.cityofnewyork.us/Recreation/Theaters/kdu2-865w" target="_blank">NYC Department of Information & Telecommunications (DoITT)</a></p>
                            </div>
                            <div class="tab-pane fade" id="museums-tab">
                                <p>Museum data courtesy of <a href="https://data.cityofnewyork.us/Recreation/Museums-and-Galleries/sat5-adpb" target="_blank">NYC Department of Information & Telecommunications (DoITT)</a></p>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="legendModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Map Legend</h4>
                    </div>
                    <div class="modal-body">
                        <p>Map Legend goes here...</p>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="loginModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Login</h4>
                    </div>
                    <div class="modal-body">
                        <form id="contact-form">
                            <fieldset>
                                <div class="form-group">
                                    <label for="name">Username:</label>
                                    <input type="text" class="form-control" id="username">
                                </div>
                                <div class="form-group">
                                    <label for="email">Password:</label>
                                    <input type="password" class="form-control" id="password">
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-right" data-dismiss="modal">Login</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="featureModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-primary" id="feature-title"></h4>
                    </div>
                    <div class="modal-body" id="feature-info">
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/typeahead/typeahead.bundle.min.js"></script>
        <script type="text/javascript" src="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js"></script>
        <script type="text/javascript" src="assets/leaflet-sidebar/L.Control.Sidebar.js"></script>
        <script type="text/javascript">
            var map, boroughSearch = [], theaterSearch = [], museumSearch = [];

            // Basemap Layers
            var mapquestOSM = L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {
                maxZoom: 19,
                subdomains: ["otile1", "otile2", "otile3", "otile4"],
                attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png">. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA.'
            });
            var mapquestOAM = L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg", {
                maxZoom: 18,
                subdomains: ["oatile1", "oatile2", "oatile3", "oatile4"],
                attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a>. Portions Courtesy NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency'
            });
            var mapquestHYB = L.layerGroup([L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg", {
                maxZoom: 18,
                subdomains: ["oatile1", "oatile2", "oatile3", "oatile4"]
            }), L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/hyb/{z}/{x}/{y}.png", {
                maxZoom: 19,
                subdomains: ["oatile1", "oatile2", "oatile3", "oatile4"],
                attribution: 'Labels courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png">. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA. Portions Courtesy NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency'
            })]);

            // Overlay Layers
            var boroughs = L.geoJson(null, {
                style: function (feature) {
                    return {
                        color: "black",
                        fill: false,
                        opacity: 1,
                        clickable: false
                    };
                },
                onEachFeature: function (feature, layer) {
                    boroughSearch.push({
                        name: layer.feature.properties.BoroName,
                        source: "Boroughs",
                        id: L.stamp(layer),
                        bounds: layer.getBounds()
                    });
                }
            });
            $.getJSON("data/boroughs.geojson", function (data) {
                boroughs.addData(data);
            });

            var subwayLines = L.geoJson(null, {
                style: function (feature) {
                    if (feature.properties.route_id === "1" || feature.properties.route_id === "2" || feature.properties.route_id === "3") {
                        return {
                            color: "#ff3135",
                            weight: 3,
                            opacity: 1
                        };
                    };
                    if (feature.properties.route_id === "4" || feature.properties.route_id === "5" || feature.properties.route_id === "6") {
                        return {
                            color: "#009b2e",
                            weight: 3,
                            opacity: 1
                        };
                    };
                    if (feature.properties.route_id === "7") {
                        return {
                            color: "#ce06cb",
                            weight: 3,
                            opacity: 1
                        };
                    };
                    if (feature.properties.route_id === "A" || feature.properties.route_id === "C" || feature.properties.route_id === "E" || feature.properties.route_id === "SI" || feature.properties.route_id === "H") {
                        return {
                            color: "#fd9a00",
                            weight: 3,
                            opacity: 1
                        };
                    };
                    if (feature.properties.route_id === "Air") {
                        return {
                            color: "#ffff00",
                            weight: 3,
                            opacity: 1
                        };
                    };
                    if (feature.properties.route_id === "B" || feature.properties.route_id === "D" || feature.properties.route_id === "F" || feature.properties.route_id === "M") {
                        return {
                            color: "#ffff00",
                            weight: 3,
                            opacity: 1
                        };
                    };
                    if (feature.properties.route_id === "G") {
                        return {
                            color: "#9ace00",
                            weight: 3,
                            opacity: 1
                        };
                    };
                    if (feature.properties.route_id === "FS" || feature.properties.route_id === "GS") {
                        return {
                            color: "#6e6e6e",
                            weight: 3,
                            opacity: 1
                        };
                    };
                    if (feature.properties.route_id === "J" || feature.properties.route_id === "Z") {
                        return {
                            color: "#976900",
                            weight: 3,
                            opacity: 1
                        };
                    };
                    if (feature.properties.route_id === "L") {
                        return {
                            color: "#969696",
                            weight: 3,
                            opacity: 1
                        };
                    };
                    if (feature.properties.route_id === "N" || feature.properties.route_id === "Q" || feature.properties.route_id === "R") {
                        return {
                            color: "#ffff00",
                            weight: 3,
                            opacity: 1
                        };
                    };
                },
                onEachFeature: function (feature, layer) {
                    if (feature.properties) {
                        var content =   "<table class='table table-striped table-bordered table-condensed'>"+
                                            "<tr><th>Division</th><td>" + feature.properties.Division + "</td></tr>"+
                                            "<tr><th>Line</th><td>" + feature.properties.Line + "</td></tr>"+
                                        "<table>";
                        if (document.body.clientWidth <= 767) {
                            layer.on({
                                click: function(e) {
                                    $("#feature-title").html(feature.properties.Line);
                                    $("#feature-info").html(content);
                                    $("#featureModal").modal("show");
                                }
                            });

                        } else {
                            layer.bindPopup(content, {
                                maxWidth: "auto",
                                closeButton: false
                            });
                        };
                    }
                    layer.on({
                        mouseover: function(e) {
                            var layer = e.target;
                            layer.setStyle({
                                weight: 3,
                                color: "#00FFFF",
                                opacity: 1
                            });
                            if (!L.Browser.ie && !L.Browser.opera) {
                                layer.bringToFront();
                            }
                        },
                        mouseout: function(e) {
                            subwayLines.resetStyle(e.target);
                        }
                    });
                }
            });
            $.getJSON("data/subways.geojson", function (data) {
                subwayLines.addData(data);
            });

            var theaters = L.geoJson(null, {
                pointToLayer: function (feature, latlng) {
                    return L.marker(latlng, {
                        icon: L.icon({
                            iconUrl: "img/theater.png",
                            iconSize: [24, 28],
                            iconAnchor: [12, 28],
                            popupAnchor: [0, -25]
                        }),
                        title: feature.properties.NAME,
                        riseOnHover: true
                    });
                },
                onEachFeature: function (feature, layer) {
                    if (feature.properties) {
                        var content =   "<table class='table table-striped table-bordered table-condensed'>"+
                                            "<tr><th>Name</th><td>" + feature.properties.NAME + "</td></tr>"+
                                            "<tr><th>Phone</th><td>" + feature.properties.TEL + "</td></tr>"+
                                            "<tr><th>Address</th><td>" + feature.properties.ADDRESS1 + "</td></tr>"+
                                            "<tr><th>Website</th><td><a class='url-break' href='" + feature.properties.URL + "' target='_blank'>" + feature.properties.URL + "</a></td></tr>"+
                                        "<table>";

                        if (document.body.clientWidth <= 767) {
                            layer.on({
                                click: function(e) {
                                    $("#feature-title").html(feature.properties.NAME);
                                    $("#feature-info").html(content);
                                    $("#featureModal").modal("show");
                                }
                            });

                        } else {
                            layer.bindPopup(content, {
                                maxWidth: "auto",
                                closeButton: false
                            });
                        };
                        theaterSearch.push({
                            name: layer.feature.properties.NAME,
                            source: "Theaters",
                            id: L.stamp(layer),
                            lat: layer.feature.geometry.coordinates[1],
                            lng: layer.feature.geometry.coordinates[0]
                        });
                    }
                }
            });
            $.getJSON("data/DOITT_THEATER_01_13SEPT2010.geojson", function (data) {
                theaters.addData(data);
            });

            var museums = L.geoJson(null, {
                pointToLayer: function (feature, latlng) {
                    return L.marker(latlng, {
                        icon: L.icon({
                            iconUrl: "img/museum.png",
                            iconSize: [24, 28],
                            iconAnchor: [12, 28],
                            popupAnchor: [0, -25]
                        }),
                        title: feature.properties.NAME,
                        riseOnHover: true
                    });
                },
                onEachFeature: function (feature, layer) {
                    if (feature.properties) {
                        var content =   "<table class='table table-striped table-bordered table-condensed'>"+
                                            "<tr><th>Name</th><td>" + feature.properties.NAME + "</td></tr>"+
                                            "<tr><th>Phone</th><td>" + feature.properties.TEL + "</td></tr>"+
                                            "<tr><th>Address</th><td>" + feature.properties.ADRESS1 + "</td></tr>"+
                                            "<tr><th>Website</th><td><a class='url-break' href='" + feature.properties.URL + "' target='_blank'>" + feature.properties.URL + "</a></td></tr>"+
                                        "<table>";
                        if (document.body.clientWidth <= 767) {
                            layer.on({
                                click: function(e) {
                                    $("#feature-title").html(feature.properties.NAME);
                                    $("#feature-info").html(content);
                                    $("#featureModal").modal("show");
                                }
                            });

                        } else {
                            layer.bindPopup(content, {
                                maxWidth: "auto",
                                closeButton: false
                            });
                        };
                        museumSearch.push({
                            name: layer.feature.properties.NAME,
                            source: "Museums",
                            id: L.stamp(layer),
                            lat: layer.feature.geometry.coordinates[1],
                            lng: layer.feature.geometry.coordinates[0]
                        });
                    }
                }
            });
            $.getJSON("data/DOITT_MUSEUM_01_13SEPT2010.geojson", function (data) {
                museums.addData(data);
            });

            map = L.map("map", {
                zoom: 10,
                center: [40.702222, -73.979378],
                layers: [mapquestOSM, boroughs, subwayLines, theaters]
            });
            // Hack to preserver layer order in Layer control
            map.removeLayer(subwayLines);

            // Larger screens get expanded layer control
            if (document.body.clientWidth <= 767) {
                var isCollapsed = true;
            } else {
                var isCollapsed = false;
            };

            var baseLayers = {
                "Streets": mapquestOSM,
                "Imagery": mapquestOAM,
                "Hybrid": mapquestHYB
            };

            var overlays = {
                "Boroughs": boroughs,
                "Subway Lines": subwayLines,
                "<img src='img/theater.png' width='24' height='28'>&nbsp;Theaters": theaters,
                "<img src='img/museum.png' width='24' height='28'>&nbsp;Museums": museums
            };

            var layerControl = L.control.layers(baseLayers, overlays, {
                collapsed: isCollapsed
            }).addTo(map);

            var sidebar = L.control.sidebar("sidebar", {
                closeButton: true,
                position: "left"
            }).addTo(map);

            // Highlight search box text on click
            $("#searchbox").click(function () {
                $(this).select();
            });

            // Typeahead search functionality
            $(document).one("ajaxStop", function () {
                map.fitBounds(boroughs.getBounds());
                $("#loading").hide();

                var boroughsBH = new Bloodhound({
                    name: "Boroughs",
                    datumTokenizer: function (d) {
                        return Bloodhound.tokenizers.whitespace(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: boroughSearch,
                    limit: 10
                });

                var theatersBH = new Bloodhound({
                    name: "Theaters",
                    datumTokenizer: function (d) {
                        return Bloodhound.tokenizers.whitespace(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: theaterSearch,
                    limit: 10
                });

                var museumsBH = new Bloodhound({
                    name: "Museums",
                    datumTokenizer: function (d) {
                        return Bloodhound.tokenizers.whitespace(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: museumSearch,
                    limit: 10
                });

                var geonamesBH = new Bloodhound({
                    name: "GeoNames",
                    datumTokenizer: function (d) {
                        return Bloodhound.tokenizers.whitespace(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: "http://api.geonames.org/searchJSON?username=bootleaf&featureClass=P&maxRows=5&countryCode=US&name_startsWith=%QUERY",
                        filter: function (data) {
                            return $.map(data.geonames, function (result) {
                                return {
                                    name: result.name + ", " + result.adminCode1,
                                    lat: result.lat,
                                    lng: result.lng,
                                    source: "GeoNames"
                                };
                            });
                        },
                        ajax: {
                            beforeSend: function (jqXhr, settings) {
                                settings.url += "&east=" + map.getBounds().getEast() + "&west=" + map.getBounds().getWest() + "&north=" + map.getBounds().getNorth() + "&south=" + map.getBounds().getSouth();
                                $("#searchicon").removeClass("fa-search").addClass("fa-refresh fa-spin");
                            },
                            complete: function (jqXHR, status) {
                                $('#searchicon').removeClass("fa-refresh fa-spin").addClass("fa-search");
                            }
                        }
                    },
                    limit: 10
                });
                boroughsBH.initialize();
                theatersBH.initialize();
                museumsBH.initialize();
                geonamesBH.initialize();

                // instantiate the typeahead UI
                $("#searchbox").typeahead({
                    minLength: 3,
                    highlight: true,
                    hint: false
                }, {
                    name: "Boroughs",
                    displayKey: "name",
                    source: boroughsBH.ttAdapter(),
                    templates: {
                        header: "<h4 class='typeahead-header'>Boroughs</h4>"
                    }
                }, {
                    name: "Theaters",
                    displayKey: "name",
                    source: theatersBH.ttAdapter(),
                    templates: {
                        header: "<h4 class='typeahead-header'><img src='img/theater.png' width='24' height='28'>&nbsp;Theaters</h4>"
                    }
                }, {
                    name: "Museums",
                    displayKey: "name",
                    source: museumsBH.ttAdapter(),
                    templates: {
                        header: "<h4 class='typeahead-header'><img src='img/museum.png' width='24' height='28'>&nbsp;Museums</h4>"
                    }
                }, {
                    name: "GeoNames",
                    displayKey: "name",
                    source: geonamesBH.ttAdapter(),
                    templates: {
                        header: "<h4 class='typeahead-header'><img src='img/globe.png' width='25' height='25'>&nbsp;GeoNames</h4>"
                    }
                }).on("typeahead:selected", function (obj, datum) {
                    if (datum.source === "Boroughs") {
                        map.fitBounds(datum.bounds);
                    };
                    if (datum.source === "Theaters") {
                        if (!map.hasLayer(theaters)) {
                            map.addLayer(theaters);
                        };
                        map.setView([datum.lat, datum.lng], 17);
                        if (map._layers[datum.id]) {
                            map._layers[datum.id].fire("click");
                        };
                    };
                    if (datum.source === "Museums") {
                        if (!map.hasLayer(museums)) {
                            map.addLayer(museums);
                        };
                        map.setView([datum.lat, datum.lng], 17);
                        if (map._layers[datum.id]) {
                            map._layers[datum.id].fire("click");
                        };
                    };
                    if (datum.source === "GeoNames") {
                        map.setView([datum.lat, datum.lng], 14);
                    };
                    if ($(".navbar-collapse").height() > 50) {
                        $(".navbar-collapse").collapse("hide");
                    };
                }).on("typeahead:opened", function () {
                    $(".navbar-collapse.in").css("max-height", $(document).height() - $(".navbar-header").height());
                    $(".navbar-collapse.in").css("height", $(document).height() - $(".navbar-header").height());
                }).on("typeahead:closed", function () {
                    $(".navbar-collapse.in").css("max-height", "");
                    $(".navbar-collapse.in").css("height", "");
                });
                $(".twitter-typeahead").css("position", "static");
                $(".twitter-typeahead").css("display", "block");
            });

            // Placeholder hack for IE
            if (navigator.appName == "Microsoft Internet Explorer") {
                $("input").each( function () {
                    if ($(this).val() == "" && $(this).attr("placeholder") != "") {
                        $(this).val($(this).attr("placeholder"));
                        $(this).focus(function () {
                            if ($(this).val() == $(this).attr("placeholder")) $(this).val("");
                        });
                        $(this).blur(function () {
                            if ($(this).val() == "") $(this).val($(this).attr("placeholder"));
                        });
                    }
                });
            }
        </script>
    </body>
</html>
