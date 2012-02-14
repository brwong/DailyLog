<?php
echo "sleep fix<br />";

require("access.php");

$res = $db->query("SELECT * FROM daily WHERE thoughts LIKE 'sleep:%'");

function extracttime($string){
	return $lineend;
}

while($line = $res->fetch_array()){
	$lineend = strpos($line['thoughts'], "\n");
	$sleep = "";
	$thoughts = "";
	if($lineend===false){
		$sleep = substr($line['thoughts'], 6);
	}
	else{
		$sleep = substr($line['thoughts'], 6, ($lineend-6));
		$thoughts = substr($line['thoughts'], $lineend);
	}
	$sleep = trim($sleep);
	$thoughts = addslashes(ltrim($thoughts));
	/*$q = "UPDATE daily SET sleep='".$sleep."' WHERE date='".$line['date']."'";
	echo $q;
	$ret = $db->query($q);
	echo ' - '.$ret;*/
	//echo "thoughts: '".nl2br($line['thoughts'])."'<br />";
	//echo "thoughts: '".nl2br($thoughts)."'<br />";
	$q = "UPDATE daily SET thoughts='".$thoughts."' WHERE date='".$line['date']."'";
	echo $q;
	/*$ret = $db->query($q);
	echo ' - '.$ret;*/
	echo "<br />";
}


?>