<?php

require("accept.php");
$okay = false;
if($_COOKIE['daily']=='brandonjournal'){
	$okay = true;
	setcookie('daily', 'brandonjournal', time()+21600);
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
<style type="text/css">
body {
	font-family:"myriad pro",tahoma,arial,sans-serif;
	background-color:#ddddee;
}
h1 {
	display:inline;
}
#h1link {
	color:black;
	text-decoration:none;
}
h3#datewords {
	display:inline;
}
div#subtitle {
	margin-left:10px;
	margin-top:10px;
	font-style:italic;
}
.act {
	display:inline;
	font-size:x-small;
	padding:1px;
	color:blue;
}
.act:hover {
	cursor:pointer;
	color:red;
}
.label {
	width:150px;
	float: left;
	text-align:right;
	padding-right:10px;
}
.ml .label {
	width:150px;
	text-align:right;
	position:relative;
	left:100px;
	float:left;
}
.ml input {
	position:relative;
	left:100px;
	display:inline;
	width:250px;
}
.ml .act {
	position:relative;
	left:100px;
}
#events input {
	width:400px;
}
#eventsbox input {
	position:relative;
	left:160px;
}
#thoughts {
	height:100px;
	width:400px;
}
#submit {
	font-size: 120%;
	font-weight: bold;
	width: 200;
}
#reset {
	font-size: 90%;
	width: 75;
}
</style>
<script type="text/javascript">
function addit(label, location, content){
	quant = $('#'+location + ' input').length;
	node = '<br />';
	node += label.indexOf('meal')!=-1 ? '<div class="label">meal</div>' : '';
	quant += label.indexOf('hap')!=-1 ? 1 : 0;
	node += '<input name="'+label+quant+'"';
	node += ' />';
	$('#'+location).append(node);
	if(content) $("input[name='"+label+quant+"']").val(content);
	$("input[name='"+label+quant+"']").focus();
	return false;
}
function slate(){
	var sections = ['meals_first', 'meals_second', 'meals_third', 'eventsbox'];
	for(var i=0; i<sections.length; i++){
		$('#'+sections[i]).html('');
	}
	document.forms[0].reset.click();
}
function writeup(stuff){
	slate();
	//steps
	$('input[name="steps"]').val(stuff['steps']);
	//meals
	food = stuff['meals'].indexOf("\r\n")!=-1 ? stuff['meals'].split("\r\n") : stuff['meals'].split("\n");
	for(var i=0; i<food.length; i++){
		if(food[i].indexOf(':')==-1) continue;
		var nomen = food[i].split(':', 1)[0];
		if(nomen=='breakfast'||nomen=='brunch'||nomen=='lunch'||nomen=='supper'){
			$('input[name="'+nomen+'"]').val(food[i].substr(food[i].indexOf(':')+1));
		}
		else if(nomen.indexOf('_meal')!=-1){
			if($('input[name="'+nomen+'"]').length){
				$('input[name="'+nomen+'"]').val(food[i].substr(food[i].indexOf(':')+1));
			}
			else{
				if(nomen.split('_',1)=='morning'){
					addit('morning_meal','meals_first',food[i].substr(food[i].indexOf(':')+1));
				}
				else if(nomen.split('_',1)=='afternoon'){
					addit('afternoon_meal','meals_second',food[i].substr(food[i].indexOf(':')+1));
				}
				else if(nomen.split('_',1)=='evening'){
					addit('evening_meal','meals_third',food[i].substr(food[i].indexOf(':')+1));
				}
			}
		}
	}
	food = stuff['meals'].indexOf("\r\n")!=-1 ? stuff['meals'].split("\r\n") : stuff['meals'].split("\n");
	//sleep
	$('input#sleep').val(stuff['sleep']);
	//events
	ev = stuff['events'].indexOf("\r\n")!=-1 ? stuff['events'].split("\r\n") : stuff['events'].split("\n");
	if(ev.length > 0) $('input[name="hap0"]').val(ev[0]);
	if(ev.length > 1){
		for(var i=1; i<ev.length; i++){
			if($('input[name="hap'+i+'"]').length){$('input[name="hap'+i+'"]').val(ev[i]);}
			else{addit('hap','eventsbox', ev[i]);}
		}
	}
	//thoughts
	$('textarea#thoughts').val(stuff['thoughts']);
	window.blur();
}
function access(date){
	var url = 'recorder.php?action=access';
	if(date){url += '&date='+date}
	$.ajax({
		'url': url,
		'type': 'GET',
		'datatype': 'json',
		'success': function (comeback){
			if(comeback){
				/*alert('got something!! how exciting!!!<br /><pre>'+comeback.replace(/","/g, '",<br />"').replace(/\\r\\n/g, "<br />\t")+'</pre>');*/
				writeup(JSON.parse(comeback));
			}
			$('img#waiter').hide();
		}
	});
}
$(function (){
	$('#results img').hide();
	$(window).load(function (){
		access();
		return false;
	});
	$('#hiddendate').datepicker({
		'showOn':'button',
		'buttonImage':'calendar.gif',
		'buttonImageOnly': true,
		'showAnim': 'slideDown',
		'showButtonPanel': true,
		'dateFormat': 'yymmdd',
		'altField': '#hiddendatewords',
		'altFormat': 'DD, d MM, yy',
		'changeMonth': true,
		'changeYear': true
	});
	$('img.ui-datepicker-trigger').attr('alt', 'click to change date');
	$('img.ui-datepicker-trigger').attr('title', 'change date');
	$('#ui-datepicker-div').css('font-size', 'small');
	$('#hiddendate').change(function (){
		$('#datewords').text(' - '+$('#hiddendatewords').val()+' ');
		slate();
		$('img#waiter').show();
		access($('#hiddendate').val());
	});
	$('#events').keypress(function (e){
		if(e.which==13 || e.keyCode==13 /*keyCode==IE*/){
			addit('hap', 'eventsbox');
			return false;
		}
	});
	$('form').submit(function (){
		return false;
	});
	$('#submit').click(function (){
		$('#results img').show();
		$('#results span').hide();
		$('#results span').text('');
		$.ajax({
			'url': 'recorder.php?action=update&date='+$('#hiddendate').val(),
			'type': 'POST',
			'data': $('form').serializeArray(),
			'success': function (comeback){
				$('#results img').hide();
				if(comeback==1){
					$('#results span').text('successfully updated!');
					$('#results span').show();
					$('#results span').fadeOut(5000);
				}
				else{
					$('#results span').text(comeback);
					$('#results span').show();
				}
			}
		});
		return false;
	});
	$('#reset').click(slate);
});
</script>
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


<!--
<day date="" steps="">
	<meals>
		<breakfast></breakfast>
		<lunch></lunch>
		<food></food>
		<supper></supper>
	</meals>
	<events>
		<event></event>
		<event></event>
	</events>
	<thoughts></thoughts>
</day>
-->
<?php
// signature
echo '<div style="text-align:center;letter-spacing:0.5em;">';
echo 'Brandon Wong &copy;' . date('Y');
echo '</div>';
?>
<br />
</body>
</html>
