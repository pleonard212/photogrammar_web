<?php

require_once 'login.php';
$page = search; 
$bodyopts = 'onload="initialize()"';
include '../header.php';
echo <<<_END


<style>
#results-content {
	margin:0 auto;
	padding:0;
}
#results-header {
	border-bottom:1px dotted #DD4B39;
	font-family:Arial, Helvetica, sans-serif;
	margin:20px 0 0;
	padding:0;
}
#results-footer {
	font-family:Arial, Helvetica, sans-serif;
	margin:20px 0 0;
	padding:0;
}
#results-total {
	display:inline;
}
#results-total h2 {
	display:inline;
}
#results-total span {
	display:inline-table;
}
#results-pager {
	display:inline;
	float:right;
	margin:8px 0 0;
}
#results-pager span{
	font-weight:bold;
}
#results-pager a, #results-pager a:visited {
	color:#DD4B39;
	text-decoration:none;
}
#return-link {
	padding:10px 0;
	text-align:right;
}
#return-link a, #return-link a:visited {
	color:#DD4B39;
	font-family:Arial, Helvetica, sans-serif;
	text-decoration:none;
}
#return-link a:hover {
	color:#DD4B39;
	text-decoration:underline;
}
.results-container {
	color:#666;
	display:block;
	float:left;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:.7em;
	height:272px;
	margin: 10px 0px 10px 0px;
	padding: 0px 10px 0px 10px;
	overflow: hidden;
	width:200px;
}
.results-image {
	display: table-cell;
	height: 170px;
	text-align: center;
	vertical-align: bottom;
	white-space: nowrap;
	width: 170px;
}
.results-thumb {
	max-height: 170px;
	max-width: 170px;
}
#results-meta {
	border-top:dotted 1px #DD4B39;
	margin:7px 0 0;
	padding:7px 0 0;
}
#results-title {
	font-weight:bold;
	height:52px;
	margin:0 0 5px;
}
#results-photographer {
	margin:0 0 3px;
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

<div id="wrapper" class="clearfix" style="padding:75px">

<div id="content-wrapper" class="clearfix" >

<div id="results-content" class="clearfix">

<div id="results-header" class="clearfix">
<div id="results-header-toprow">
_END;

$db_server = mysql_connect($db_hostname, $db_username, $db_password);

if(!$db_server) die("Unable to connect to MySQL: " .mysql_error());

mysql_select_db($db_database) or die('Unable to connect to MySQL: ' . mysql_error());

$fval = array('pname'=>'', 'month_start'=>'', 'month_stop'=>'', 'year_start'=>'', 'year_stop'=>'', 'van'=>'', 'lot'=>'', 'city'=>'',
                 'county'=>'', 'state'=>'', 'title'=>'', 'start'=>0);
$mons = array('1'=>'January ', '2'=>'February ', '3'=>'March ', '4'=>'April ', '5'=>'May ', '6'=>'June ', '7'=>'July ', '8'=>'August ',
                 '9'=>'September ', '10'=>'October ', '11'=>'November ', '12'=>'December ', '0'=>'');
echo <<<_END

_END;

if(isset($_GET['start']))
{

    $fval['pname'] = $_GET['pname'];
    $fval['month_start'] = $_GET['month_start'];
    $fval['month_stop'] = $_GET['month_stop'];
    $fval['year_start'] = $_GET['year_start'];
    $fval['year_stop'] = $_GET['year_stop'];
    $fval['van'] = $_GET['van'];
    $fval['lot'] = $_GET['lot'];
    $fval['city'] = $_GET['city'];
    $fval['county'] = $_GET['county'];
    $fval['state'] = $_GET['state'];
    $fval['title'] = $_GET['title'];
    $fval['start'] = $_GET['start'];

    $van_code = substr(get_post('van'), 0, 1);
    $van_string = substr(get_post('van'), 1);

    $query = "SELECT * FROM photo2 WHERE pname LIKE '%" . get_post('pname') . "%' ";
/*              "lotnum LIKE '%" . get_post('lot') . "%' AND " . */
	if ($_GET['lot']!=""){     $query .=         "AND lotnum ='" . get_post('lot') . "' ";};
	$query .= "AND city LIKE '%" . get_post('city') . "%' AND " .
             "county LIKE '%" . get_post('county') . "%' AND " .
             "state LIKE '%" . get_post('state') . "%' AND " .
             "title LIKE '%" . get_post('title') . "%' AND " .
             "year >=" . get_post('year_start') . " AND year <=" . get_post('year_stop')  . " AND " .
             "month >=" . get_post('month_start') . " AND month <=" . get_post('month_stop');

    if($van_code == "A") $query = $query . " AND van0='" . $van_string . "'";
    if($van_code == "B") $query = $query . " AND van1='" . $van_string . "'";
    if($van_code == "C") $query = $query . " AND van2='" . $van_string . "'";

    $query = $query . " ORDER BY year, month, cnumber ";
    if(get_post('search') != "") {
        $querySearch = "+" . get_post('search');
        $querySearch = str_replace(" ", " +", $querySearch);
        $querySearch = str_replace(" +NOT +", " -", $querySearch);
        $querySearch = str_replace("+NOT +", " -", $querySearch);
        $query = "SELECT * FROM photo2 WHERE MATCH(pname, van0, van1, van2, city, county, state, country, title) AGAINST('" . $querySearch . "' IN BOOLEAN MODE) ";
    }

/*     echo $query; */
    //echo '<br />';
    //$query = "SELECT * FROM photo";
    $result = mysql_query($query);
/*     echo '<span style="font-family:monospace;font-size:0.7em;color:grey;">' . $query . '</span><br>'; */
    if (!$result) die ("Database access failed: " . mysql_error());
    $rows = mysql_num_rows($result);
    if(get_post('search') != "") {
        echo '<div id="results-total"><h2>' . $rows . ' pictures of ' . get_post('search') . '</h2>';
    } else {
        echo '<div id="results-total"><h2>Advanced Search</h2><br>';
    echo '<span>';
    echo $rows . " pictures ";
   if ($fval['pname'] != '') { echo "by " . $fval['pname']; };
       if ($fval['lot'] != '') { echo " in Lot Number " . $fval['lot']; };
    echo  " from ";
    if ($fval['month_start'] != '') {echo $mons[$fval['month_start']] . " ";};
    echo $fval['year_start'] . " to " . $mons[$fval['month_stop']] . " " .  $fval['year_stop'] . ": ";


   
/*

    if ($fval['van']         != '') { echo "Classification: " . $fval['van'];		};
    if ($fval['city']        != '') { echo "City: " . $fval['city'];		};
    if ($fval['county']      != '') { echo "County: " . $fval['county'];		};
    if ($fval['state']       != '') { echo "State: " . $fval['state'];		};
*/

        echo '</span>';
       
    }


    //for Photographer:"' . get_post('photographer') . '", Lot = "' .
        //get_post('lotNum') . '"' . '", County = "' .
        //get_post('secondPolitical') . '"'  .  '", Year = "' . get_post('year') . '"' ;
    //if($rows > 200) echo ' ; Showing only first 200 results';
    if($rows != 0) {
    	echo '</div><!--/#results-total--><div id="results-pager"><span>Results: </span>';
    	if(get_post('start') != 0) {
        	$query_arr = $_GET;
        	$query_arr["start"] = max($query_arr["start"] - 60, 0);
        	$query_call = http_build_query($query_arr);
        	echo '<a href="' . 'http://photogrammar.yale.edu/search/results.php?' . $query_call . '">&laquo; </a>';
    	}
        	echo  (get_post('start') + 1)  . '-' . min(get_post('start') + 60, $rows);
    }
        if(get_post('start') + 60 < $rows) {
            $query_arr = $_GET;
            $query_arr["start"] = $query_arr["start"] + 60;
            $query_call = http_build_query($query_arr);
            echo '<a href="' . 'http://photogrammar.yale.edu/search/results.php?' . $query_call . '"> &raquo;</a>'; 
        }

    echo '</div><!--/#results-pager-->';
    echo '</div><!--/#results-header-toprow-->';
    echo '</div><!--/#results-header-->';
    echo '<div id="return-link" class="clearfix"><a href="http://photogrammar.yale.edu/search/">Start New Search</a></div><!--/#return-link-->';
    echo '<div id="results-gallery" class="clearfix">';


    for($j = get_post('start'); $j < min(get_post('start') + 60, $rows); ++$j)
    {
        $pmon =  intval(mysql_result($result, $j, 'month'));
        $pdate = $mons[$pmon] . mysql_result($result, $j, 'year');
        $ptitle = mysql_result($result, $j, 'title');
        if(strlen($ptitle) > 90) {
            $ptitle = substr($ptitle,0,85) . "...";
        }
       echo '<div class="results-container">';
       echo '<div class="results-image"><a href=http://photogrammar.yale.edu/records/index.php?record=' .mysql_result($result, $j, 'cnumber') . '>';
       //echo '<img src="http://lcweb2.loc.gov/service/pnp/fsac/1a34000/1a34300/1a34309r.jpg" height="228" />';
       echo '<img class="results-thumb" src="';
    if (substr(mysql_result($result, $j, 'thumb_url'), -2) != 'NA') {
      if (mysql_result($result, $j, 'thumb_url') == '') {
	      echo '/images/nophoto.png';
      }
      if (mysql_result($result, $j, 'thumb_url') != '') {
  	  	echo 'http://maps.library.yale.edu/images/public/photogrammar/' . mysql_result($result, $j, 'thumb_url');
  	  }
    }
    if (substr(mysql_result($result, $j, 'thumb_url'), -2) == 'NA') {
  	  echo 'http://maps.library.yale.edu/images/public/photogrammar/' . mysql_result($result, $j, 'small_url');
    }
       echo '" />';
       echo '</a></div><!--/.results-image-->';
       echo '<div id="results-meta">';
       echo '<div id="results-title">' . $ptitle . '</div>';
       echo '<div id="results-photographer">' .mysql_result($result, $j, 'pname') . '</div>';
       echo '<div id="results-date">' . $pdate . '</div>';
       if(($j - get_post('start')) % 6 == 5);
       echo '</div><!--/#results-meta-->';
       echo '</div><!--/.results-container-->';
    }
    echo '</div><!--/#results-gallery-->';
    if($rows != 0) {
        echo '<div id="results-footer" class="clearfix"><div id="results-pager"><span>Results: </span>';
        if(get_post('start') != 0) {
            $query_arr = $_GET;
            $query_arr["start"] = max($query_arr["start"] - 60, 0);
            $query_call = http_build_query($query_arr);
            echo '<a href="' . 'http://photogrammar.yale.edu/search/results.php?' . $query_call . '">&laquo; </a>';
        }
    echo  (get_post('start') + 1)  . '-' . min(get_post('start') + 60, $rows);
    }
        if(get_post('start') + 60 < $rows) {
            $query_arr = $_GET;
            $query_arr["start"] = $query_arr["start"] + 60;
            $query_call = http_build_query($query_arr);
            echo '<a href="' . 'http://photogrammar.yale.edu/search/results.php?' . $query_call . '"> &raquo;</a>'; 
    }

    echo '</div><!--/#results-pager--></div><!--/#results-footer-->';

}

mysql_close($db_server);

function get_post($var)
{
    return mysql_real_escape_string($_GET[$var]);
}

echo <<<_END

</div><!--/#results-content-->

</div><!--/#content-wrapper-->

</div><!--/#wrapper-->

</body>

</html>
_END;
include '../footer.php'; 
?>
