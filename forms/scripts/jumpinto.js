function twitterCallback2(twitters) {
  var statusHTML = [];
  var res = twitters.results;
  for (var i=0; i<res.length; i++){
    var username = res[i].from_user;
    var status = res[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
      return '<a href="'+url+'">'+url+'</a>';
    }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
      return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
    });
    statusHTML.push('<li class="tweet"><table><tr><td><a href="http://twitter.com/'+username+'"> <img src="'+res[i].profile_image_url+'"width=50px height=50px></img></a></td><td class="tweettext"><a href="http://twitter.com/'+username+'"><span style="font-size:130%">'+username+'</span></a>:<span>'+status+'</span> <a style="font-size:75%" href="http://twitter.com/'+username+'/statuses/'+res[i].id+'">'+relative_time(res[i].created_at)+'</a></td><td class="emotion">Emotion :</td></tr></table></li>');
  }
  document.getElementById('twitter_update_list').innerHTML = statusHTML.join('');
    eliminurl(res);
}

function eliminurl(res){
 var statusHTML = [];
 for (var i=0;i<res.length;i++){
	var status = res[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
      return ' ';
    }).replace(/\B@([_a-z0-9]+)/ig,' ');
	stemmed = stem(status);
	statusHTML.push('<li class="tweet"><table><tr><td class="text">'+status+'</td><td class="stem">'+stemmed+'</td></tr></table></li>');
 }
 document.getElementById('textdiv').innerHTML = statusHTML.join('');
 
}

function stem(test){
	var 	wordlist,
		ix,
		word,
		stem,
		stemmed =' ';
	
	test = test.toLowerCase();
 
	// replace smiley with some word
	test = test.replace(/:-\)|:\)|;\)|;-\)|=\)|:D|:P/g, ' smilei');
	
	// replace sad expression with other word
	test = test.replace(/:-\(|:\(/g, ' sadey');
	
	//replace question mark with other word
	
	test = test.replace(/\?/g, ' question');
	
	//replace exclamation with other word
	test = test.replace(/\!\!\!\!|\!\!\!|\!\!|\!/g, ' exclamation');
	
	//replace n't with not
	test = test.replace(/an\'t/g, 'an not');
	test = test.replace(/n\'t/g, ' not');
 
	// dump non-words
	test = test.replace(/[^\w]/g, ' ');
	// dump multiple white-space
	test = test.replace(/\s+/g, ' ');
	
	wordlist = teststop(test);
 
	for(ix in wordlist) {
		stem = stemmer(wordlist[ix]);
		stemmed= stemmed+' '+stem;
	}
	return stemmed;
}

function teststop(word){
		var url = "training.php";
		var params = "keyword=" + totalEncode(frm.uname.value);
		var connection=connect(url,params);
		connection.onreadystatechange = function(){
			if(connection.readyState == 4){
				var status = connection.responseText.getElementsByTagName("status")[0];
				status = status.childNodes[0];
				var text = connection.responseText.getElementsByTagName("txt")[0];
				text = text.childNodes[0];
				if(status == '0'){
					document.getElementById("loading").style.visibility = "visible";
					document.getElementById("error").innerHTML=connection.responseText;
					document.getElementById("error").style.visibility = "visible";
					document.getElementById("loading").style.visibility = "hidden";
				}
				else{
					window.location = text;
				}
			}
			if((connection.readyState == 2)||(connection.readyState == 3)){
			document.getElementById("error").style.visibility = "hidden";
			document.getElementById("loading").style.visibility = "visible";
			}
		}
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