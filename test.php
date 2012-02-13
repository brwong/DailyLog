<?php
echo "hello! test number 6<br />";

require("access.php");

$res = $db->query("SELECT * FROM daily");

for($i=20;$i<50;$i++){
	echo $i.":<br />";
	$line = $res->fetch_array();
	//$line = MYSQL_FETCH_ARRAY($res->res);
	print_r($line);
	echo "<br />";
}


?>