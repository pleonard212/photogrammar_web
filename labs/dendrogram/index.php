<?php $page = labs; ?>
<?php include '../../header.php'; ?>

       <style>

  	#chart {
			width: 1100px;

			padding-top:150px;
			margin: 1px auto;
			position: relative;
			-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
					box-sizing: border-box;
		}
            h2.switcher a:link, h2.switcher a:visited {
	            color:black;
            }

            .node circle {
              fill: #fff;
              stroke: steelblue;
              stroke-width: 1.5px;
            }



            .node {
              font: 10px sans-serif;
            }

            .link {
              fill: none;
              stroke: #f0f0f0;
              stroke-width: 1.5px;
            }

            .nodelink:hover {
	            font-weight: bold;
	            cursor:pointer;
            }
	</style>

    <div id="chart">

    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.7.1.js"></script>
    <script>
    var width = 1100,
        height = 16000;

    var cluster = d3.layout.cluster()
        .size([height, width - 280]);

    var diagonal = d3.svg.diagonal()
        .projection(function(d) { return [d.y, d.x]; });

    var svg = d3.select("div#chart").append("svg")
        .attr("width", width)
        .attr("height", height)
      .append("g")
        .attr("transform", "translate(90,0)");

    d3.json("classifications.json", function(error, root) {
      var nodes = cluster.nodes(root),
          links = cluster.links(nodes);

      var link = svg.selectAll(".link")
          .data(links)
        .enter().append("path")
          .attr("class", "link")
          .attr("d", diagonal);

      var node = svg.selectAll(".node")
          .data(nodes)
        .enter().append("g")
          .attr("class", "node")
          .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
	      
      node.append("circle")
          .attr("r", 4.5).attr("stroke","black");



      node.append("text")
          .attr("dx", function(d) { return d.children ? -8 : 8; })
          .attr("dy", 3)
          .style("text-anchor", function(d) { return d.children ? "end" : "start"; })
          .text(function(d) { return d.name; })
          
          
          
          
          .attr("class", "nodelink").on("click", function(d) { 
					    if(!d.children){
						    window.open(d.url); 
					    }
				    });
    });

    d3.select(self.frameElement).style("height", height + "px");
    </script>

      <hr>

      <footer>
        <p>&copy;</p>
      </footer>
    </div> <!-- /container -->


<?php include '../../footer.php'; ?>
