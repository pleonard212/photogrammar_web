<?php
require_once 'login.php';
$page = search; 
include '../header.php';
echo <<<_END

    <link rel="shortcut icon" href="http://cartodb.com/assets/favicon.ico" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<style>
#search-content {
	margin:0 auto;
	padding:0;
	width:1100px;
}
.search-row {
	margin:0 0 10px;
}
.search-label {
	display:inline-block;
	width:180px;
}
.search-field {
	display:inline-block;
}
#search-content h3 {
	display:inline;
	font-family: Arial, Helvetica, sans-serif;
	font-size:1.1em;
	font-weight:normal;
}
#search-content input {
	font-size:1em;
	width:300px;
}
#search-full .search-field input {
	width: 600px;
}
#search-button {
	margin:20px 0 0 182px;
}
#search-button button {
	font-family: Arial, Helvetica, sans-serif;
	font-size:1.4em;
	font-weight:bold;
	padding:5px 10px;
}
</style>
 
<link href="select2/select2.css" rel="stylesheet"/>
<style>
div.select2-result-label, .select2-choice, .select2-searching, .select2-no-results {font-family:sans-serif;}
</style>
<script src="select2/select2.js"></script>
    
    <script>
    history.navigationMode = 'compatible';
    window.onunload = function(){};
    
        $('document').ready(function(){
 
        	    $(window).bind('pageshow', function() { 
        	    
        	      $('#state').select2("val", null);
        	      $('input#county').val(null);
        	      $('input#city').val(null);
				
				 });
	
				
						   	 
			$("#van").select2({
            	placeholder: "Choose a Classification",
				allowClear: true,
				minimumInputLength: 3,
				ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
	                url: "http://dh.library.yale.edu/projects/photogrammar/tags.php",
	                dataType: 'json',
	                data: function (term, page) {
	                    return {
	                        q: term, // search term
	                    };
	                },
                results: function (data, page) { // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to alter remote JSON data
                    return {results: data.results};
                }
            }
        });

     
                $("#pname").select2({
               		 placeholder: "Choose a Photographer",
			   		 allowClear: true
			   	 });

                $("#lot").select2({
               		 placeholder: "Lot Number",
			   		 allowClear: true
			   	 });


			    $('#state').select2({
               	 placeholder: "Choose a State",
			   	 allowClear: true
			   	 }).on("change", function() {
			   	 	 if($('#state').val()=="Louisiana") {
			   	 	 
			   	 	 	$('#county').attr('placeholder', 'Choose a Parish');
			   	 	 }
			   	 	 else if($('#state').val()=="Alaska") {
			   	 	 	$('#county').attr('placeholder', 'Choose a Borough');

			   	 	 }
			   	 	 else {
			   	 	 	$('#county').attr('placeholder', 'Choose a County');
				   	 	 
			   	 	 };
		   	 		 $("#county").select2('val', ''); 
		   	 		 $("#city").select2('val', '');
		   	 		 $.ajax('counties.php?state=' + $('#state').val()).success(function(countyData) {						
			   	 		 $('#county').select2({ 
				   	 		 placeholder: "Choose a County",
				   	 		 data: countyData,
				   	 		 allowClear: true
				   	     }).on("change", function() {
							$("#city").select2('val', '');
							$.ajax('cities.php?state=' + $('#state').val() + '&county=' + $('#county').val()).success(function(cityData) {						
			   	 		 $('#city').select2({ 
				   	 		 placeholder: "Choose a City",
				   	 		 data: cityData,
				   	 		 allowClear: true
				   	     })}); 

						 })}); 
		   	 		 $.ajax('cities.php?state=' + $('#state').val() + '&county=' + $('#county').val()).success(function(cityData) {						
			   	 		 $('#city').select2({ 
				   	 		 placeholder: "Choose a City",
				   	 		 data: cityData,
				   	 		 allowClear: true
				   	     })}); 


			
					}).on("select2-loaded", function(e) { log ("loaded (data property omitted for brevitiy)");});
			    
			     
			    });
			   
       </script>
 

<div id="wrapper" class="clearfix">

<div id="content-wrapper" class="clearfix">

<div id="search-content">

<h2 class="page-title">Search</h2>

_END;

$db_server = mysql_connect($db_hostname, $db_username, $db_password);

if(!$db_server) die("Unable to connect to MySQL: " .mysql_error());

mysql_select_db($db_database) or die('Unable to connect to MySQL: ' . mysql_error());

$fval = array('pname'=>'', 'month_start'=>'', 'month_stop'=>'', 'year_start'=>'', 'year_stop'=>'', 'van'=>'', 'lot'=>'', 'city'=>'', 'county'=>'', 'state'=>'', 'title'=>'', 'start'=>0);

echo <<<_END

<form action='results.php' method='get' id='photosearch' class='clearfix'>
<input type ="hidden" id="start" name="start" value=0>
<fieldset>
<div>
<legend style="font-family:sans-serif;font-weight:bold;">Full Text</legend>
<div id="search-full" class="search-row">

    <div class="search-field">
    	<input type ="text" name="search"/> <button class="button" style='	font-family: Arial, Helvetica, sans-serif;
	font-size:0.8em;
	font-weight:bold;
	padding:5px 10px;' type='submit' value='Search'/>Search</button>
    </div>
</div><!--/#search-full-->
</fieldset>

<fieldset  style="margin-top:30px;">
<legend style="font-family:sans-serif;font-weight:bold;">Advanced</legend>

<div id="search-photographer" class="search-row">
	<div class="search-label">
    	<h3>Photographer</h3>
    </div>
    <div class="search-field">
     <select id="pname" name="pname" style="width:400px;">
_END;
    $pnamequery = "SELECT DISTINCT pname FROM photo2 ORDER BY pname ASC";
	$pnameresult = mysql_query($pnamequery) or die(mysql_error());
	while($row = mysql_fetch_array($pnameresult)){
		echo "<option value=\"" . $row['pname'] . "\">" . $row['pname'] . "</option>";
		}
echo <<<_END
 
   	</select>
    </div>
           
</div><!--/#search-photographer-->

<div id="search-lot" class="search-row">
	<div class="search-label">
    	<h3>Lot Number</h3>
    </div>
    <div class="search-field">
   
     <select id="lot" name="lot" style="width:200px;">
     <option></option>
_END;
    $pnamequery = "SELECT DISTINCT lotnum FROM photo2 WHERE lotnum !='0' ORDER BY lotnum ASC";
	$pnameresult = mysql_query($pnamequery) or die(mysql_error());
	while($row = mysql_fetch_array($pnameresult)){
		echo "<option value=\"" . $row['lotnum'] . "\">" . $row['lotnum'] . "</option>";
		}
echo <<<_END
 
   	</select>
    </div>
     <br><div class="clearfix" style="margin-left:190px;width:600px;color:grey;font-size:.8em;font-family:sans-serif;">88,000 photographs were assigned a lot number, indicating a set of photographs organized primarily around a shooting assignment. As a result, lots tend to feature one photographer&rsquo;s set of photographs in a single place. For example, <a style="color:black;" href="/search/results.php?start=0&search=&pname=&lot=1070&van=&state=&county=&city=&year_start=1935&month_start=1&year_stop=1945&month_stop=12">Lot 1070</a> features Arthur Rothstein&rsquo;s set in Clinton, Indiana in February 1940.  Paul Vanderbilt developed the lot system. </div>

</div><!--/#search-lot-->

<div id="search-classification" class="search-row clearfix">
    <div class="search-label">
    	<h3>Classification Tags</h3>
    </div>
    <div class="search-field">
        <input type="hidden" id ="van" name="van" style="width:800px;" />

    </div><!--/.search-field-->
   <br><div style="margin-left:190px;width:600px;color:grey;font-size:.8em;font-family:sans-serif;">88,000 photographs in the collection have tags assigned.  There are twelve main subject headings (ex. THE LAND) and 1300 sub-headings (ex. Mountains, Deserts, Foothills, Plains).   Paul Vanderbilt began to develop the classification system in 1942. </div>
</div><!--/#search-classification-->

<div id="search-place">
    <div id="search-state" class="search-row">
        <div class="search-label">
            <h3>Location</h3>
        </div>
        <div class="search-field">
     <select id="state" name="state" style="width:200px;">
_END;
    $statequery = "SELECT DISTINCT state FROM photo2 ORDER BY state ASC";
	$stateresult = mysql_query($statequery) or die(mysql_error());
	while($row = mysql_fetch_array($stateresult)){
		echo "<option value=\"" . $row['state'] . "\">" . $row['state'] . "</option>";
		}
echo <<<_END
 
   	</select>  
   	<input id="county" type="hidden"  style="width:200px;" name="county"/>  
   	<input id="city" type="hidden" style="width:200px;" name="city"/>    
   	</div>
    
</div><!--/#search-place-->

<div id="search-year" class="search-row">
    <div class="search-label">
        <h3>From</h3>
    </div>
    <div class="search-field">
        <select name="year_start"> 
            <option value=1935 selected>1935</option>
            <option value=1936>1936</option>
            <option value=1937>1937</option>
            <option value=1938>1938</option>
            <option value=1939>1939</option>
            <option value=1940>1940</option>
            <option value=1941>1941</option>
            <option value=1942>1942</option>
            <option value=1943>1943</option>
            <option value=1944>1944</option>
            <option value=1945>1945</option>
    	</select>
    	<span> / </span>
        <select name="month_start"> 
            <option value=0 selected>Choose a Month</option>

            <option value=1>January</option>
            <option value=2>February</option>
            <option value=3>March</option>
            <option value=4>April</option>
            <option value=5>May</option>
            <option value=6>June</option>
            <option value=7>July</option>
            <option value=8>August</option>
            <option value=9>September</option>
            <option value=10>October</option>
            <option value=11>November</option>
            <option value=12>December</option>
        </select>
    </div>
</div><!--/#search-year-->
<div id="search-month" class="search-row">
    <div class="search-label">
    	<h3>To</h3>
    </div>
    <div class="search-field">
        <select name="year_stop"> 
            <option value=1935>1935</option>
            <option value=1936>1936</option>
            <option value=1937>1937</option>
            <option value=1938>1938</option>
            <option value=1939>1939</option>
            <option value=1940>1940</option>
            <option value=1941>1941</option>
            <option value=1942>1942</option>
            <option value=1943>1943</option>
            <option value=1944>1944</option>
            <option value=1945 selected>1945</option>
        </select>
        <span> / </span>
        <select name="month_stop"> 
            <option value=1 selected>January</option>
            <option value=2>February</option>
            <option value=3>March</option>
            <option value=4>April</option>
            <option value=5>May</option>
            <option value=6>June</option>
            <option value=7>July</option>
            <option value=8>August</option>
            <option value=9>September</option>
            <option value=10>October</option>
            <option value=11>November</option>
            <option value=12 selected>December</option>
        </select>
    </div>
</div><!--/#search-month-->

<div id="search-button">
	<button type='submit' value='Search'/>Search</button>
</div><!--/#search-button-->
</fieldset>
</form>
</div>
_END;


mysql_close($db_server);

function get_post($var)
{
    return mysql_real_escape_string($_GET[$var]);
}

echo <<<_END

</div><!--/#search-content-->

</div><!--/#content-wrapper-->

</div><!--/#wrapper-->

</body>

</html>
_END;

?>
