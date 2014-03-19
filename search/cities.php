<?php
header('Content-type: application/json');

require_once 'login.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);

if(!$db_server) die("Unable to connect to MySQL: " .mysql_error());

mysql_select_db($db_database) or die('Unable to connect to MySQL: ' . mysql_error());

$cityquery = "SELECT DISTINCT city FROM photo2 WHERE state =\"" . $_GET['state'] . "\"";
if ($_GET['county'] !="") { $cityquery .= " AND county =\"" . $_GET['county'] . "\"";};

$cityquery .= "AND city !=\"\" ORDER BY city ASC";
/* echo $cityquery; */
$cityresult = mysql_query($cityquery) or die(mysql_error());
while($row = mysql_fetch_array($cityresult)){

        $answer[] = array("id"=>$row['city'],"text"=>$row['city']);

// finally encode the answer to json and send back the result.
}
echo '{ "results":';
echo json_encode($answer);
?>
}
