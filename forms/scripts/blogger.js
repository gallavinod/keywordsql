function twitter(twitters) {
	document.getElementById('loading').style.visibility = 'visible';
	var statusHTML;
	var pos;
	var neg;
	var neutral;
	twitter.pos=0;
	twitter.neg=0;
	twitter.neutral = 0;
	twitter.statusHTML = [];
	var res = twitters.results;
	if(res!=''){
	for (var i=0; i<10 && i<res.length; i++){
	
		var username = res[i].from_user;
		var status = res[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
			return '<a href="'+url+'">'+url+'</a>';
			}).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
			return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
		});
		twitter.statusHTML.push('<li class="tweet"><table><tr><td><a href="http://twitter.com/'+username+'"> <img src="'+res[i].profile_image_url+'"width=50px height=50px></img></a></td><td class="tweettext"><a href="http://twitter.com/'+username+'"><span style="font-size:130%">'+username+'</span></a>:<span>'+status+'</span><br/><a style="font-size:75%" href="http://twitter.com/'+username+'/statuses/'+res[i].id+'">'+relative_time(res[i].created_at)+'</a></td>');
		
		var tweetfor = res[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
			return ' ';
		}).replace(/\B@([_a-z0-9]+)/ig,' ');
		
		polarityprint(tweetfor);
		
		twitter.statusHTML.push('</tr></table></li>');
		
	}
	paint(res);
	
	}else
	{
	twitter.statusHTML.push('<li class="tweet">No Results Returned</li>');
	document.getElementById('twitter_update_list').innerHTML = twitter.statusHTML.join('');
	document.getElementById('loading').style.visibility = 'hidden';
	
	}
	
}

function paint(res){
	
	for(var i=0;i<res.length;i++){
		var tweetfor = res[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
			return ' ';
		}).replace(/\B@([_a-z0-9]+)/ig,' ');
		
		polarity(tweetfor);
	}
	
	var total = twitter.pos + twitter.neg + twitter.neutral;
	var pospercent = parseInt((twitter.pos/total)*100);
	var negpercent = parseInt((twitter.neg/total)*100);
	var neupercent = parseInt((twitter.neutral/total)*100);
	var myvalues=new Array(); // regular array (add an optional integer
	myvalues[0]=pospercent;       // argument to control array's size)
	myvalues[1]=negpercent;
	myvalues[2]=neupercent;
	
	

	//document.write('<div class="pos">'+eliminurl.pos+'</div>');
	//document.write('<div class="neg">'+eliminurl.neg+'</div>');
	//document.write('<div class="neutral">'+eliminurl.neutral+'</div>');
	//configure the jstat

	//$('.dynamicpie').sparkline(myvalues, {type: 'pie', barColor: 'green',height: '200px'} );

	var api = new jGCharts.Api(); 
	jQuery('<img>') 
	.attr('src', api.make({ 
	data : myvalues,  
   //source 
   legend      : ['Positive','Negative','Neutral'], 
   axis_labels : ['Positive','Negative','Neutral'],
   colors :['FF0000','0000FF','00FF00'],
   //options  
   size        : '500x200', 
   type        : 'p3', 
   bg            : 'FFFFFF', 
   bg_angle      : 45, 
   bg_offset     : '999999', 
   bg_width      : 30 
	})).appendTo("#dynamicpie");
	document.getElementById('twitter_update_list').innerHTML = twitter.statusHTML.join('');
	document.getElementById('percent').innerHTML = 'Your Query is <br/>'+pospercent+'% Positive <br/>'+negpercent+'% Negative <br/>'+neupercent+'% Neutral <br/>';
	document.getElementById('loading').style.visibility = 'hidden';
}

function polarityprint(test){
		$.ajax({
			type: "POST",
			url: "code.php",
			data: "values=" + test,
			async: false,
			success: function(msg){
			  //alert( "Data Saved: " + msg );
			  var cnt;
			  cnt = parseInt(msg);
			  if (cnt>0){
				twitter.statusHTML.push('<td class="positive">This is '+cnt+'% Positive </td>');
				//twitter.pos = twitter.pos + 1;
			  }else if(cnt<0){
				cnt = -cnt;
				twitter.statusHTML.push('<td class="negative">This is '+cnt+'% Negative</td>');
				//twitter.neg = twitter.neg + 1;
			  }else{
				twitter.statusHTML.push('<td class="neutral">This is Neutral</td>');
				//twitter.neutral = twitter.neutral + 1;
			  }
			}
		});
}

function polarity(test){
		$.ajax({
			type: "POST",
			url: "code.php",
			data: "values=" + test,
			async: false,
			success: function(msg){
			  //alert( "Data Saved: " + msg );
			  var cnt;
			  cnt = parseInt(msg);
			  if (cnt>0){
				twitter.pos = twitter.pos + 1;
			  }else if(cnt<0){
				cnt = -cnt;
				twitter.neg = twitter.neg + 1;
			  }else{
				twitter.neutral = twitter.neutral + 1;
			  }
			}
		});
}


function relative_time(time_value) {
  var values = time_value.split(" ");
  time_value = values[2] + " " + values[1] + ", " + values[3] + " " + values[4];
  var parsed_date = Date.parse(time_value);
  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
  delta = delta + (relative_to.getTimezoneOffset() * 60);

  if (delta < 60) {
    return 'less than a minute ago';
  } else if(delta < 120) {
    return 'about a minute ago';
  } else if(delta < (60*60)) {
    return (parseInt(delta / 60)).toString() + ' minutes ago';
  } else if(delta < (120*60)) {
    return 'about an hour ago';
  } else if(delta < (24*60*60)) {
    return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
  } else if(delta < (48*60*60)) {
    return '1 day ago';
  } else {
    return (parseInt(delta / 86400)).toString() + ' days ago';
  }
}
