<?php
function convert($v){
	return trim($v);
}
if(isset($_COOKIE['cold_man'])){
	//user should have access
	if($_COOKIE['old_man']=="wps_aj_bl"){
	
	}
	else if($_COOKIE['old_man']=="young_man"){
	
	}
}
else if(isset($_POST['access']) && $_POST['access']=="freehappens"){
	//attempt is being made
	echo "I have a post!aaaghhh<br />";
	print_r($_POST);
	echo "<br />";
	echo "'".convert($_POST['packet'])."'<br />";
	switch(convert($_POST['packet'])){
		case "21":
			echo "It looks right.";
			break;
		case "54":
			echo "It looks good.";
			break;
		default:
			echo "no go.";
			break;
	}
	/*if(isset($_POST['packet'])){
		if(convert($_POST['packet'])==""){
		
		}
		else*/
}
else{
	//no access is granted
	require("gate.php");
	exit();
}
?>
<html>
<body>

I have the prize.

</body>
</html>
