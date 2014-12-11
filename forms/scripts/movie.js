 
function stem(){
	var 	wordlist,
		ix,
		word,
		stem,
		stopmark='',
		stopremoved='',
		wordliststop,
		wordlisted,
		stemmed = [],
		test = document.getElementById('test').value;
 
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
	
	wordlisted = testmarkstop(test);
	
	for(ix in wordlisted) {
		stopmark= stopmark+' '+wordlisted[ix];
	}
	
	document.getElementById('stopoverlap').innerHTML = stopmark;
	
	wordliststop = teststop(test);
 
	for(ix in wordliststop) {
		stopremoved = stopremoved+' '+wordliststop[ix];
	}
	document.getElementById('stopremoved').innerHTML = stopremoved;
	
	wordlist = teststop(test);
 
	for(ix in wordlist) {
		stem = stemmer(wordlist[ix]);
		stemmed= stemmed+' '+stem;
	}
	document.getElementById('stemmed').innerHTML = stemmed;
}


function teststop(word){
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.open("GET","words.xml",false);
xmlhttp.send();
var xmlDoc=xmlhttp.responseXML;

wordlist = word.split(' ');
 
for(ix in wordlist) {

for(i=0;i<xmlDoc.getElementsByTagName("word").length;i++){

	if(wordlist[ix]!=xmlDoc.getElementsByTagName("word")[i].childNodes[0].nodeValue)
	  {}
	 else{wordlist[ix]=' ';}

}

}
return wordlist;
}


function testmarkstop(word){
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.open("GET","words.xml",false);
xmlhttp.send();
var xmlDoc=xmlhttp.responseXML;

wordlist = word.split(' ');
 
for(ix in wordlist) {

for(i=0;i<xmlDoc.getElementsByTagName("word").length;i++){

	if(wordlist[ix]!=xmlDoc.getElementsByTagName("word")[i].childNodes[0].nodeValue)
	  {}
	 else{
	 wordlist[ix]='<em> '+wordlist[ix]+' </em>';}

}

}
return wordlist;
}