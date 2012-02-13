<html>
	<head>
		<title>gate</title>
		<style type="text/css">
			.primary {height:100px;width:100px;}
			#clearing {height:100px;width:50px;}
			#confirm {height:100px;width:150px;}
		</style>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript">
			function convert(v){
				$('#packet').val(v.replace(" ", "").replace("&nbsp;", "").replace(String.fromCharCode(160), ""));
			}
			$(function (){
				var d = new Date();
				var key = d.getDate();
				$('.primary').click(function (){
					var n = $(this).attr('id').substr(1);
					$('#box').text($('#box').text()+n);
					//possible 'encryption' here
				});
				$('#clearing').click(function (){
					$('#box').html("&nbsp;");
				});
				$('#confirm').click(function (){
					//pressed enter
					convert($('#box').text());
					$('#box').html("&nbsp;");
					$('#package').submit();
				});
			});
		</script>
	</head>
	<body>
	
	<div>
	This website requires special access. Please enter the short or the long code to access.
	</div>
	
	<div id="box">&nbsp;</div>
	
	<button id="b7" class="primary">7</button>
	<button id="b8" class="primary">8</button>
	<button id="b9" class="primary">9</button>
	<br />
	<button id="b4" class="primary">4</button>
	<button id="b5" class="primary">5</button>
	<button id="b6" class="primary">6</button>
	<br />
	<button id="b1" class="primary">1</button>
	<button id="b2" class="primary">2</button>
	<button id="b3" class="primary">3</button>
	<br />
	<button id="b0" class="primary">0</button>
	<button id="clearing">X</button>
	<button id="confirm">ENTER</button>
	
	<form id="package" method="POST" action="index.php">
	<input type="hidden" name="access" value="freehappens" />
	<input type="hidden" name="packet" id="packet" />
	</form>
	
	</body>
</html>
<?php
exit();
?>
