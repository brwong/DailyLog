<?php

$okay = false;
if($_COOKIE['daily']=='brandonjournal'){
	$okay = true;
}
elseif(isset($_POST['access']) && $_POST['access']=="freehappens"){
	if(isset($_POST['packet'])){
		if($_POST['packet']=="5147481572"){
			$okay = true;
			setcookie('daily', 'brandonjournal', time()+3600);
		}
		else{
			$badattempt = true;
		}
	}
}
if(!$okay){
	if($_REQUEST['alt']=='key'){
		require('gate-numpad.php');
	}
	else{
		require("gate.php");
	}
}

?>
<html>
<head>
	<meta name="ROBOTS" content="NONE, NOINDEX, NOFOLLOW, NOARCHIVE" />
	<title>Daily Log</title>
</head>
<body>
<!--<pre style="_word-wrap:break-word;white-space:pre-wrap;">-->
<pre>
<?php

require("access.php");
$res = $db->query("SELECT * FROM daily ORDER BY date DESC");
$notfirst = false;
while($line = $res->fetch_array()){
	$ds = explode('-', $line['date']);
	echo "<b>" . date("l, F j, Y", mktime(0,0,0, $ds[1], $ds[2], $ds[0])) . "</b><br />";
	//echo $line['date'] . "<br />";
	if($line['steps']) echo "\tsteps: ".$line['steps'] . "<br />";
	if($line['meals']){
		$food = $line['meals'];
		$food = str_replace("\n", "\n\t\t", $food);
		$food = str_replace("morning_meal", "morning meal ", $food);
		$food = str_replace("afternoon_meal", "afternoon meal ", $food);
		$food = str_replace("evening_meal", "evening meal ", $food);
		echo "\tmeals:\n\t\t" . $food . "<br />";
	}
	if($line['sleep']) echo "\tsleep: ".$line['sleep'] . "<br />";
	if($line['events']) echo "\tevents:\n\t\t" . str_replace("\n", "\n\t\t", $line['events']) . "<br />";
	if($line['thoughts']) echo "\tthoughts:\n" . $line['thoughts'] . "<br />";
	echo "<br />";
	$notfirst = true;
}


?>
</pre>
</body>
</html>
