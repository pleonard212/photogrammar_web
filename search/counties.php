<?php
header('Content-type: application/json');

require_once 'login.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);

if(!$db_server) die("Unable to connect to MySQL: " .mysql_error());

mysql_select_db($db_database) or die('Unable to connect to MySQL: ' . mysql_error());

$countyquery = "SELECT DISTINCT county FROM photo2 WHERE state =\"" . $_GET['state'] . "\" ORDER BY county ASC LIMIT 0,99";
$countyresult = mysql_query($countyquery) or die(mysql_error());
while($row = mysql_fetch_array($countyresult)){

        $answer[] = array("id"=>$row['county'],"text"=>$row['county']);

// finally encode the answer to json and send back the result.
}
echo '{ "results":';
echo json_encode($answer);
?>
}
