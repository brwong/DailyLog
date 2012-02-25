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
	if(stuff['steps'] != "0" && stuff['steps'] != 0){
		$('input[name="steps"]').val(stuff['steps']);
	}
	else{
		$('input[name="steps"]').val('');
	}
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

