<?php

// date | steps | meals | events | thoughts

require("access.php");

if($_GET['action']=='update'){
	$meals = '';
	$meals .= $_POST['breakfast']? 'breakfast:'.$_POST['breakfast']."\n" : "";
	$meals .= $_POST['brunch']? 'brunch:'.$_POST['brunch']."\n" : "";
	$i = 0;
	while(isset($_POST['morning_meal'.$i])){
		if($_POST['morning_meal'.$i]==""){$i++; continue;}
		$meals .= 'morning_meal'.$i.':'.$_POST['morning_meal'.$i]."\n";
		$i++;
	}
	$meals .= $_POST['lunch']? 'lunch:'.$_POST['lunch']."\n" : "";
	$i = 0;
	while(isset($_POST['afternoon_meal'.$i])){
		if($_POST['afternoon_meal'.$i]==""){$i++; continue;}
		$meals .= 'afternoon_meal'.$i.':'.$_POST['afternoon_meal'.$i]."\n";
		$i++;
	}
	$meals .= $_POST['supper']? 'supper:'.$_POST['supper']."\n" : "";
	$i = 0;
	while(isset($_POST['evening_meal'.$i])){
		if($_POST['evening_meal'.$i]==""){$i++; continue;}
		$meals .= 'evening_meal'.$i.':'.$_POST['evening_meal'.$i]."\n";
		$i++;
	}
	$meals = rtrim($meals);
	$events = '';
	$i = 0;
	while(isset($_POST['hap'.$i])){
		if($_POST['hap'.$i]==""){$i++; continue;}
		$events .= $_POST['hap'.$i] . "\n";
		$i++;
	}
	$events = rtrim($events);
	if($db->query("SELECT * FROM daily WHERE date=".$_REQUEST['date'])->fetch_array()){
		$q = "UPDATE daily SET";
		$q .= " steps=";
		$q .= $_POST['steps'] ? $_POST['steps'] : "''";
		$q .= ", meals='" . $meals . "'";
		$q .= ", events='" . $events . "'";
		$q .= ", thoughts='" . $_POST['thoughts'] . "'";
		$q .= " WHERE date=" . $_REQUEST['date'];
	}
	else{
		$q = "INSERT INTO daily VALUES (";
		$q .= $_REQUEST['date'];
		$q .= ', ';
		$q .= $_POST['steps'] ? $_POST['steps'] : "''";
		$q .= ', ';
		$q .= $meals ? "'".$meals."'" : "''";
		$q .= ', ';
		$q .= $events ? "'".$events."'" : "''";
		$q .= ', ';
		$q .= $_POST['thoughts'] ? "'".$_POST['thoughts']."'" : "''";
		$q .= ")";
	}
	$res = $db->query($q);
	if($res) echo $res;
	else{
		echo $db->error . "<br />";
		echo nl2br($q);
	}
	//print_r($_POST);
}
else if($_GET['action']=='access'){
	$date = $_GET['date'] ? $_GET['date'] : date('Y-m-d');
	$res = $db->query("SELECT * FROM daily WHERE date='$date' LIMIT 1");
	$line = $res->fetch_array();
	if($line){
		echo json_encode($line);
	}
	else {
		echo '';
	}
}

$db->close();

?>