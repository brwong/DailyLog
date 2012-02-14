<?php

require("accept.php");
$okay = false;
if($_COOKIE['daily']=='brandonjournal'){
	$okay = true;
}
elseif(isset($_POST['access']) && $_POST['access']=="freehappens"){
	if(isset($_POST['packet'])){
		if($_POST['packet']==$accepted){
			$okay = true;
			setcookie('daily', 'brandonjournal', time()+21600);
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
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<link rel="stylesheet" href="daily.css" />
<script type="text/javascript" src="daily.js"></script>
</head>
<body>
<form action="" method="POST">
<h1>Da<a href="view.php" target="_blank" id="h1link">i</a>ly Log - NEW</h1>
<h3 id="datewords"> - <?php echo date("l, F j, Y"); ?> </h3>
<input type="hidden" id="hiddendatewords" value="<?php echo date('l, F j, Y'); ?>" />
<input type="hidden" id="hiddendate" value="<?php echo date('Ymd'); ?>" />
<img id="waiter" src="ajax-loader2.gif" />
<br />
<div id="subtitle">Record the events and your thoughts of today.</div>
<br />
<div class="label">steps:</div><input name="steps" /><br />
<div class="label">meals:</div><br />
<span class="ml">
	<div class="label">breakfast:</div>
	<input type="text" name="breakfast" /><br />
	<div class="label">brunch:</div>
	<input type="text" name="brunch" />
	<span id="meals_first"></span>
	<a href="#" class="act" onclick="return addit('morning_meal','meals_first');">add</a>
</span><br />
<span class="ml">
	<div class="label">lunch:</div>
	<input type="text" name="lunch" />
	<span id="meals_second"></span>
	<a href="#" class="act" onclick="return addit('afternoon_meal','meals_second');">add</a>
</span><br />
<span class="ml">
	<div class="label">supper:</div>
	<input type="text" name="supper" />
	<span id="meals_third"></span>
	<a href="#" class="act" onclick="return addit('evening_meal','meals_third');">add</a>
</span><br />
<span id="sleep">
	<div class="label">sleep:</div>
	<input type="text" id="sleep" name="sleep" />
</span><br />
<span id="events">
	<div class="label">events:</div>
	<input type="text" name="hap0" /><a href="#" class="act" onclick="return addit('hap','eventsbox');">add</a>
	<span id="eventsbox">
	</span>
	<!--<div class="act" onclick="addit('hap','eventsbox');">add</div>-->
</span><br />
<span id="thoughtsbox">
	<div class="label">thoughts:</div>
	<textarea id="thoughts" name="thoughts"></textarea>
</span><br /><br />
<input type="button" name="submit" value="Enter Information" id="submit" />
<input type="reset" value="Reset" id="reset" />
<span id="results"><img src="ajax-loader1.gif" /><span></span></span>

</form>

<?php
// signature
echo '<div style="text-align:center;letter-spacing:0.5em;">';
echo 'Brandon Wong &copy;' . date('Y');
echo '</div>';
?>
<br />
</body>
</html>
