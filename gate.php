<html>
	<head>
		<title>Daily Log</title>
		<style type="text/css">
			body {margin:0px;padding:0px;background-color:lightblue;}
			#board {margin:0px;padding:0px;background-color:white;position:fixed;}
		</style>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript">
			var assignments = ['47','51','72','15','39','48'];
			var context;
			var board;
			var start = new Object;
			var end = new Object;
			var rPath = [];
			var down = false;
			var errant = <?php echo $badattempt ? "true" : "false"; ?>;
			$(function (){
				board = document.getElementById('board');
				context = board.getContext('2d');
				//context.fillText(0,0,"This site requires special access.");
				//setInterval(line, 1000/30);
				$('#board').mousedown(function (e){
					if(hit(e)!=-1){
						rPath = [];
						start.x = e.pageX;
						start.y = e.pageY;
						end.x = e.pageX;
						end.y = e.pageY;
						down = true;
					}
				});
				$('#board').mouseup(function (e){
					down = false;
					swap();
					if(rPath.length>1){
						var pack = "";
						for(var i=0;i<rPath.length;i++){
							pack += assignments[rPath[i]];
						}
						$('#packet').val(pack);
						$('#package').submit();
					}
				});
				$('#board').mousemove(function (e){
					if(down){
						end.x = e.pageX;
						end.y = e.pageY;
						var h = hit(e);
						if(h!=-1){
							if(rPath.indexOf(h)==-1){
								rPath.push(h);
								start.x = xx(h);
								start.y = yy(h);
							}
						}
						swap();
					}
				});
				buttons(errant);
				path();
				if(errant){
					setInterval(swap, 500);
				}
			});
			function xx(n){
				return 100*((n%2)+1);
			}
			function yy(n){
				return 50*(n-(n%2))+100;
			}
			function line(x1,y1,x2,y2){
				context.save();
				
				/*context.strokeStyle = "#4E7AC7";
				context.lineWidth = 12;
				context.lineCap = "round";
				context.beginPath();
				context.moveTo(x1,y1);
				context.lineTo(x2,y2);
				context.stroke();*/
				
				context.strokeStyle = "#35478C";
				context.lineWidth = 10;
				context.lineCap = "round";
				context.beginPath();
				context.moveTo(x1,y1);
				context.lineTo(x2,y2);
				context.stroke();
				
				context.restore();
			}
			function path(){
				if(rPath.length < 2){return;}
				for(var i=0;i<rPath.length-1;i++){
					var x1 = xx(rPath[i]);
					var y1 = yy(rPath[i]);
					var x2 = xx(rPath[i+1]);
					var y2 = yy(rPath[i+1]);
					line(x1,y1, x2,y2);
				}
			}
			function buttons(red){
				context.save();
				for(var i=0;i<6;i++){
					var x = xx(i);
					var y = yy(i);
					//outer circle
					if(red){
						context.fillStyle = "#FF8888";
					}
					else{
						context.fillStyle = "#96ED89";
					}
					context.beginPath();
					context.arc(x, y, 25, 0, Math.PI*2, true);
					context.closePath();
					context.fill();
					//inner circle
					if(red){
						context.fillStyle = "#FF0000";
					}
					else{
						context.fillStyle = "#45BF55";
					}
					context.beginPath();
					context.arc(x, y, 20, 0, Math.PI*2, true);
					context.closePath();
					context.fill();
				}
				context.restore();
			}
			function hit(e){
				var margin = 20;
				for(var i=0;i<6;i++){
					var x = xx(i);
					var y = yy(i);
					if(Math.abs(e.pageX - x) < margin){
						if(Math.abs(e.pageY - y) < margin){
							return i;
						}
					}
				}
				return -1;
			}
			function swap(){
				board.width = board.width;
				buttons(false);
				path();
				if(down){
					line(start.x, start.y, end.x, end.y);
				}
			}
		</script>
	</head>
	<body>
	
	<canvas id="board" height="400" width="300">
		This awesome html5 app was written from scratch (except the jquery parts) by Brandon Wong on Wednesday, May 4th, 2011.
		It was inspired by a login screen from an android phone.
		Unfortunately, if you are seeing this message, it means that it doesn't work; most likely because of your antiquated browser.
	</canvas>
	
	<form id="package" method="POST" action="">
	<input type="hidden" name="access" value="freehappens" />
	<input type="hidden" name="packet" id="packet" />
	</form>
	<?php
	if(isset($_POST['packet'])){
		echo $_POST['packet'];
	}
	?>
	<br />
	
	</body>
</html>
<?php
exit();
?>
