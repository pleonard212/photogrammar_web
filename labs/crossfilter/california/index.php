<?php $page = labs; ?>
<?php include '../../../header.php'; ?>
<script src="http://code.jquery.com/jquery-1.7.1.js"></script>
<script type="text/javascript" src="d3.js"></script>
<script type="text/javascript" src="crossfilter.js"></script>
<script type="text/javascript" src="js/dc.js"></script>
	    <link rel="stylesheet" type="text/css" href="css/dc.css"/>	
<style type="text/css">
/* .dots {border:1px dotted red;} */



div.byline {font-family: monospace;font-size: .7em;}
div#datatable {height:550px;overflow-y:scroll;}
td.dc-table-label {display:none;}
span.dc-data-count {font-size:.5em;}
span.dc-data-count {font-weight: normal;}
table#data-table-sm {
	background-color: black;
	color:white;
	text-align: center;
	padding:0;
}
.dc-chart g.row text {fill:black;}

.dc-chart g.row text {fill:black;}
.table-hover > tbody > tr:hover > td,
.table-hover > tbody > tr:hover > th {
background-color: black;
}	
</style>		
<div class="container" style="padding-top:50px">




<div id="content-wrapper" class="clearfix">

<div id="about-content" class="clearfix">

<div class="container-non-responsive" style="min-width:1100px;" >
<h2 class="page-title">Metadata Explorer: California <span class="dc-data-count">Showing <span class="filter-count"></span> of <span class="total-count"></span> photographs {<a href="javascript:dc.filterAll(); dc.renderAll(); countyLines();">reset</a>}</span>
</h2>



    <div class="row">
           

        <div id="datatable" class="col-xs-2 dots">

			<table class="table table-hover"  id="data-table-sm"> 

	        </thead>
			</table>
        </div>
        <div class="col-xs-4 dots">
        	<strong><span id="countyname"></span> County</strong>
            <div id="state-chart" ></div>
        </div>
        <div class="col-xs-6 dots">
            <div class="row">
                <div class="col-xs-12 dots">
                <strong>Month</strong>
					<div id="photo-count-chart"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 dots">
                   <strong>Photographer</strong>
                   <div id="photographer-chart" style="width:250px;"></div>
                </div>
                <div class="col-xs-6 dots">
                   <strong>Classification</strong>
                   <div id="van-chart"></div>
                </div>
            </div>
        </div>
    </div>







</div>


</div>


    </div> <!-- /container -->
<script type="text/javascript">
	var numberFormat = d3.format(".f");
	var dateFormat = d3.time.format("%Y-%m");
	d3.csv("com_photogrammar_california.csv", function (data) {
		var ndx = crossfilter(data);
		var all = ndx.groupAll();
		dc.dataCount(".dc-data-count")
		.dimension(ndx)
		.group(all);
	    data.forEach(function (d) {
	        d.dd = dateFormat.parse(d.date);
			d.year = +d.year;
			d.id = d.cnumber;
	    });
	
	var photoCountChart = dc.barChart("#photo-count-chart");
	var photographerChart = dc.pieChart("#photographer-chart");
	var stateChart = dc.geoChoroplethChart("#state-chart");
	var vanChart = dc.rowChart("#van-chart");
    var stateCount = ndx.dimension(function (d) {return d.fips;});
    var stateCountGroup = stateCount.group();
    var dateDimension = ndx.dimension(function (d) {return d.dd;});
    var dateDimensionGroup = dateDimension.group();
    var vanCount = ndx.dimension(function (d) { return d.van0; });
    var vanCountGroup = vanCount.group(); 
	var photoCount = ndx.dimension(function (d) {return d.dd;});
	var photoCountGroup = photoCount.group();
	var photographerCount = ndx.dimension(function (d) {return d.pname;});
	var photographerCountGroup = photographerCount.group();
	var dataTablesm = dc.dataTable("#data-table-sm");
 

	vanChart.width(260)
    .height(300)
    .cap(10).ordering(function(d) {return d.value})
    .margins({top: 5, left: 10, right: 20, bottom: 20})
    .dimension(vanCount)
    .group(vanCountGroup)
    .colors(d3.scale.category20b())
	.label(function (d) {return d.key; })
    .title(function(d){return d.value;})
    .elasticX(true)
    .xAxis().ticks(4);            

 
    photoCountChart.width(540).height(240)
    .margins({top: 10, right: 20, bottom: 40, left: 40})
    .dimension(photoCount)
    .group(photoCountGroup)
    .x(d3.time.scale().domain([new Date(1935, 01, 01), new Date(1944, 06, 01)]))
    .xUnits(d3.time.months)
    .renderHorizontalGridLines(true)
    .elasticY(true)
    .brushOn(true);
   
    photographerChart.slicesCap(6).radius(120).height(250)
    .dimension(photographerCount).minAngleForLabel(0.2).colors( d3.scale.category10())
    .group(photographerCountGroup).ordering(function(d) {return d.value});           
 
	dataTablesm
    .dimension(dateDimension)
	.group(function(d) { return ""
	 })
	 .size(100)
    .columns([
      function(d) { return '<a target="_blank" href="http://photogrammar.yale.edu/records/index.php?record=' + d.cnumber + '"><img src="http://maps.library.yale.edu/images/public/photogrammar/' + d.tn + '" /></a><div class="byline">' + d.city + ' ' + d.dd.getMonth() + '/' + d.dd.getFullYear().toString().substring(2) + ' ' + d.pname  + '</div>'; },
      ])
    .sortBy(function(d){ return d.yr; })
    .order(d3.ascending);


	var countyNames =new Array();

	d3.json("california.json", function (statesJson) {


var mapWidth = 350;
var mapHeight = 550;	 	 
var projection = d3.geo.albers() 
      .translate([(mapWidth/2), (mapHeight/2)]) 
      .scale(2800) 
      .rotate([112.5, -0.8, -10]) 
      .center([1.1, 37]); 

	
	statesJson.features.forEach(function(d) { countyNames[d.properties.ICPSRFIP] = d.properties.NHGISNAM } );
	
	stateChart.width(mapWidth).height(mapHeight)
	.projection(projection)
	.dimension(stateCount)
	.group(stateCountGroup)
	.colors(d3.scale.quantize().range(["#E2F2FF", "#C4E4FF", "#9ED2FF", "#81C5FF", "#6BBAFF", "#51AEFF", "#36A2FF", "#1E96FF", "#0089FF", "#0061B5"]))
	.colorDomain([0, 402])
	.colorCalculator(function (d) { return d ? stateChart.colors()(d) : '#ccc'; })
	.overlayGeoJson(statesJson.features, "state", function (d) {return String(d.properties.ICPSRFIP);})
	.title(function (d) { return countyNames[d.key] + ": " + numberFormat(d.value ? d.value : 0) + " photographs";})
	;
	
         
 
        dc.renderAll();
        
		
       		stateChart.selectAll('path').on("mouseover", function(d) {
		   		$("span#countyname").text(d.properties.NHGISNAM);
		   		});   
		   	stateChart.selectAll('path').on("mouseout", function(d) {
		   		$("span#countyname").text('');
		   		});   
		});
		
		countyLines = function() {
			stateChart.selectAll('path').on("mouseover", function(d) {
		   		$("span#countyname").text(d.properties.NHGISNAM);
		   		});   
		   	stateChart.selectAll('path').on("mouseout", function(d) {
		   		$("span#countyname").text('');
		   		});  
		};


        
    });
</script>

<?php include '../../footer.php'; ?>
