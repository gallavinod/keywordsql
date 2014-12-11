//write a function to interpret trends
function trends(result){
var statusHTML = [];
var trendslist = result[0].trends;
if(trendslist.length)
  for (var i=0; i<trendslist.length; i++){
    var query = trendslist[i].name.replace(/#/g,'');
	
	var url = 'http://localhost/project/form.php?q='+query+'&loc=india';
	
	var promoted_content = trendslist[i].promoted_content;
	var name = trendslist[i].name;
    
	statusHTML.push('<li class="trend"><a href="'+url+'">'+name+'</a></li>');
  }
 else
 {
	statusHTML.push('<li class="trend">No Trends Returned</li>');
 }
  document.getElementById('loading').style.visibility = 'hidden';
  document.getElementById('trend_list').innerHTML = statusHTML.join('');
  
}

function trim(str){
	return str.replace(/^\s\s*/, "").replace(/\s\s*$/, "");
}