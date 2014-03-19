<?php
$page = search;
$bodyopts = 'onload="initialize()"';
include '../header.php';
require_once 'login.php';

$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if(!$db_server) die("Unable to connect to MySQL: " .mysql_error());

mysql_select_db($db_database) or die('Unable to connect to MySQL: ' . mysql_error());
if(isset($_GET['record']))
{
$fval['record'] = $_GET['record'];
$thispic = $_GET['record'];

    $query = "SELECT * FROM photo2 WHERE cnumber='" . $thispic . "'";
    $result = mysql_query($query);
    $ptitle = mysql_result($result, 0, 'title');
    $pnom = mysql_result($result, 0, 'pname');
    $pcall = mysql_result($result, 0, 'cnumber2');
    
}
echo <<<_END

    <style>
#record-content {
	margin: 0 auto;
	padding: 20px 0 0 0;
	width:1100px;
}
#record-meta {
	float: left;
	padding:0 5% 0 0;
	width: 30%;
}
#record-meta p {
	margin:0 0 5px;
}
#record-image {
	float:right;
	text-align:right;
	width:65%;
}
#record-image img {
	max-width:700px;
}
#record-photographer {
	margin:10px 0 0;
}
.record-heading {
	border-bottom:1px dotted #DD4B39;
	display:block;
	font-family:Arial, Helvetica, sans-serif;
	font-size:.9em;
	font-weight:bold;
	margin:15px 0 5px 0;
}
.record-heading.first {
	margin:0 0 5px 0;
}
.record-text {
	color:#333333;
	font-family:Arial, Helvetica, sans-serif;
	font-size:.8em;
}
    </style>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery.google_menu.js"></script>
    
    <script>
            $('document').ready(function(){
                $('.menu').fixedMenu();
            });
    </script>
    
    <script type="text/javascript" src="../js/mapping.js"></script>
    <style>
    
    ul {list-style-type:square;
	    padding-left:20px;
	    margin-top:0;
    }
    </style>

<div id="wrapper" class="clearfix" style="padding:75px">

<div id="content-wrapper" class="clearfix">

<div id="record-content" class="clearfix">
_END;

$db_server = mysql_connect($db_hostname, $db_username, $db_password);

if(!$db_server) die("Unable to connect to MySQL: " .mysql_error());

mysql_select_db($db_database) or die('Unable to connect to MySQL: ' . mysql_error());

$fval = array('record'=>'');
$mons = array('1'=>'January ', '2'=>'February ', '3'=>'March ', '4'=>'April ', '5'=>'May ', '6'=>'June ', '7'=>'July ', '8'=>'August ',
                 '9'=>'September ', '10'=>'October ', '11'=>'November ', '12'=>'December ', '0'=>'');
echo <<<_END

_END;

if(isset($_GET['record']))
{
    $fval['record'] = $_GET['record'];

    $query = "SELECT * FROM photo2 WHERE cnumber='" . get_post('record'). "'";
    //echo $query;
    //echo '<br />';
    //$query = "SELECT * FROM photo";
    $result = mysql_query($query);
    $ptitle = mysql_result($result, 0, 'title');
    $pnom = mysql_result($result, 0, 'pname');
    $pmon =  intval(mysql_result($result, 0, 'month'));
    $pdate = $mons[$pmon] . mysql_result($result, 0, 'year');
    $pstate = mysql_result($result, 0, 'state');
    $pcounty = mysql_result($result, 0, 'county');
    $pcity = mysql_result($result, 0, 'city');
    $ploc = '<a class="record-text" href="/search/results.php?start=0&state=' .  mysql_result($result, 0, 'state') . '&year_start=1935&month_start=0&year_stop=1945&month_stop=12"  class="record-text">' . mysql_result($result, 0, 'state') . '</a>';
    
    if(mysql_result($result, 0, 'county') != "") $ploc = '<a class="record-text" href="/search/results.php?start=0&county=' .  mysql_result($result, 0, 'county') . '&state=' .  mysql_result($result, 0, 'state') . '&year_start=1935&month_start=0&year_stop=1945&month_stop=12"  class="record-text">' . mysql_result($result, 0, 'county') . '</a>' . ", " . $ploc;
    if(mysql_result($result, 0, 'city') != "") $ploc = '<a class="record-text" href="/search/results.php?start=0&city=' .  mysql_result($result, 0, 'city') . '&county=' .  mysql_result($result, 0, 'county') . '&state=' .  mysql_result($result, 0, 'state') . '&year_start=1935&month_start=0&year_stop=1945&month_stop=12"  class="record-text">' . mysql_result($result, 0, 'city') . '</a>' . ", " . $ploc;
    
    
    $pvannum0 = mysql_result($result, 0, 'van0');
    $pvannum1 = mysql_result($result, 0, 'van1');
    $pvannum2 = mysql_result($result, 0, 'van2');

   
    $plot = intval(mysql_result($result, 0, 'lotnum'));

    if($ptitle == "") $ptitle = "None";

/*     if($pdate == "0") $pdate = "Unknown"; */
    if($ploc == "") $ploc = "Unknown";
/*     if($plot == 0) $plot = "None"; */
    if($pvannum0 == "" & $pvannum0 == "" & $pvannum0 == "") $pvannum0 = "None";

    if (!$result) die ("Database access failed: " . mysql_error());

    echo '<div id="record-meta"><!--<h2>Record Information</h2>-->';
    echo '<div id="record-title"><h3 class="record-heading first">Caption <span style="font-size:.8em; color:grey; font-weight:normal;">(Original Description)</span></h3><span class="record-text">' . $ptitle . '</div><!--/#record-title--><div id="record-photographer"><h3 class="record-heading">Photographer</h3>';


     if($pnom != "") {
   
    echo '<a href="/search/results.php?start=0&pname=' .  $pnom . '&year_start=1935&month_start=0&year_stop=1945&month_stop=12" class="record-text">' .  $pnom . '</a>';
    }

     if($pnom == "") {
   
    echo '<span class="record-text">Unknown</span>';
    }    
    
    echo '</div><!--/#record-photographer-->';
    echo '<div id="record-created" class="record-field"><h3 class="record-heading">Created</h3>';
    if($pdate != "0") {
  	  echo '<a class="record-text" href="/search/results.php?start=0&year_start=' . mysql_result($result, 0, 'year') . '&month_start=' . $pmon . '&year_stop=' . mysql_result($result, 0, 'year') . '&month_stop=' . $pmon . '">' . $pdate . '</a>';
    }
    if($pdate == "0") { echo '<span class="record-text">Unknown</span>';};
    echo '</div><!--/#record-created-->';
    
    
     
    echo '<div id="record-notes" class="record-field"><h3 class="record-heading">Location</h3><span >' . $ploc . '</span></div><!--/#record-notes-->';
	if ($pvannum1!="") {
    echo '<div id="record-classification" class="record-field"><h3 class="record-heading">Classification<span style="font-size:.8em;color:grey; font-weight:normal;"> (Original Tagging System)</span></h3><span class="record-text"><ul><li><a class="record-text" style="font-size:1em;" href="/search/results.php?start=0&year_start=1935&month_start=0&year_stop=1945&month_stop=12&van=A' . $pvannum0 . '" >' .  $pvannum0 . '</a><ul><li><a class="record-text" style="font-size:1em;" href="/search/results.php?start=0&year_start=1935&month_start=0&year_stop=1945&month_stop=12&van=B' . $pvannum1 . '" >' .  $pvannum1 . '</a><ul><li><a class="record-text" style="font-size:1em;" href="/search/results.php?start=0&year_start=1935&month_start=0&year_stop=1945&month_stop=12&van=C' . $pvannum2 . '" >' .  $pvannum2 . '</a></li></ul></li></ul></li></ul></span></div><!--/#record-classification-->';
	};
    echo '<div id="record-notes" class="record-field"><h3 class="record-heading">Lot Number<span style="font-size:.8em;color:grey; font-weight:normal;"> (Shooting Assignment)</span></h3>';
    if($plot != "0") {
    	echo '<a class="record-text" href="/search/results.php?start=0&lot=' .  $plot . '&year_start=1935&month_start=0&year_stop=1945&month_stop=12">' . $plot . '</a>';
    };
    if($plot == "0") {
    echo '<span class="record-text">None</span>';
    }
    echo '</div><!--/#record-notes-->';
//    echo '<div id="record-notes" class="record-field"><h3 class="record-heading">Notes</h3><span class="record-text"><p>' .  mysql_result($result, 0, 'pname') . '</p></span></div><!--/#record-notes-->';
//    echo '<div id="record-subjects" class="record-field"><h3 class="record-heading">Subjects</h3><span class="record-text">' .  mysql_result($result, 0, 'pname') . '</span></div><!--/#record-subjects-->';
//    echo '<div id="record-medium" class="record-field"><h3 class="record-heading">Medium</h3><span class="record-text">1 transparency : color.</span></div><!--/#record-medium-->';
//    echo '<div id="record-call" class="record-field"><h3 class="record-heading">Call Number</h3><span class="record-text">LC-USW36-80</span></div><!--/#record-call-->';
//    echo '<div id="record-reproduction" class="record-field"><h3 class="record-heading">Reproduction Number</h3><span class="record-text">LC-DIG-fsac-1a34889 DLC (digital file from original transparency)<br />LC-USW361-80 DLC (color film copy slide)</span></div><!--/#record-reproduction-->';
//    echo '<div id="record-terms" class="record-field"><h3 class="record-heading">Special Terms of Use</h3><span class="record-text">No known restrictions on publication.</span></div><!--/#record-terms-->';
//    echo '<div id="record-partof" class="record-field"><h3 class="record-heading">Part of</h3><span class="record-text">Farm Security Administration - Office of War Information Collection 12002-18</span></div><!--/#record-partof-->';
//    echo '<div id="record-repository" class="record-field"><h3 class="record-heading">Repository</h3><span class="record-text">Library of Congress Prints and Photographs Division Washington, D.C. 20540 USA http://hdl.loc.gov/loc.pnp/pp.print</span></div><!--/#record-repository-->';
    echo '<div id="record-digitalid" class="record-field"><h3 class="record-heading">Call Number<span style="font-size:.8em;color:grey; font-weight:normal;"> (Library of Congress)</span></h3><a class="record-text" target="_blank" href="http://www.loc.gov/pictures/item/' . $_GET['record'] . '">' . mysql_result($result, 0, 'cnumber2') . '</a></div><!--/#record-digitalid-->';
    
    echo '</div><!--/#record-meta-->';
    echo '<div id="record-image"><img src="';
    $photourl = mysql_result($result, 0, 'large_url');
    if (substr($photourl, -2) != 'NA') {
  if ($photourl == '') {
	      echo '/images/nophotolarge.png';
      }
      if ($photourl != '') {
  	  	echo 'http://maps.library.yale.edu/images/public/photogrammar/' . mysql_result($result, 0, 'large_url');
  	  }
    }
    if (substr($photourl, -2) == 'NA') {
  	  echo 'http://maps.library.yale.edu/images/public/photogrammar/' . mysql_result($result, 0, 'small_url');
    }

    
    echo '"/></div><!--/#record-image-->';

}

mysql_close($db_server);

function get_post($var)
{
    return mysql_real_escape_string($_GET[$var]);
}

echo <<<_END

</div><!--/#record-content-->

</div><!--/#content-wrapper-->


</div><!--/#wrapper-->

_END;

include '../footer.php'; ?>
