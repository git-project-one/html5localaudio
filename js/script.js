window.addEventListener("load",function(){
	var player = document.getElementById('player');
	var display = document.getElementById('display');
	var handle = document.getElementById('handle');
	var currentTimeSpan = document.getElementById('currentTime');
	var totalTimeSpan = document.getElementById('totalTime');
	var bar = document.getElementById('bar');
	var playBtn = document.getElementById('playBtn');
	var titleSpan = document.getElementById('titleSpan');
	var list = document.getElementById('list');
	var currentTrack = 0;
	var listArray = list.childNodes;
	var playing = false;
	var mousedown = false;
	var http = new XMLHttpRequest();
	
		function shuffle(){
		var index = Math.floor(Math.random()*listArray.length);
		playTrack(listArray[index]);
	}
	

	for (i=0;i<listArray.length;i++){
		listArray[i].addEventListener("click",function(){
			playTrack(this);
		});
	}
	
	prevBtn.addEventListener('click',function(){
		if(parseInt(currentTrack)-1>=0)
			playTrack(listArray[--currentTrack])
	});
	
	nextBtn.addEventListener('click',function(){
		if(parseInt(currentTrack)+1<listArray.length)
			playTrack(listArray[++currentTrack])
	});
	
	
	
	function post(mp3,dir){
		var url = "convert.php";
		var params = "mp3=" + mp3 + "&dirname=mp3&width=30000&height=110&foreground=#AAAAAA&background=";

		http.open("POST", url, true);

		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//multipart/form-data
	//	http.setRequestHeader("Content-length", params.length);
	//	http.setRequestHeader("Connection", "close");

		http.onreadystatechange = function() {//Call a function when the state changes.
		
			if(http.readyState == 4 && http.status == 200) {
				
				console.log(http.responseText);
				display.style.backgroundImage = "url("+http.responseText+")";
				player.play();
			}
		}
		http.send(params);
	}

	
	function playTrack(obj){
	
	currentTrack = obj.getAttribute("data-id");
	var title = obj.getAttribute("data-title");
	var artist = obj.getAttribute("data-artist");
	var url = obj.getAttribute("data-url");
	var dir = obj.getAttribute("data-dir");
	var filename = obj.getAttribute("data-filename");
	
	//post(filename,dir);
	
	if(artist == '' || title == '')
		titleSpan.innerText = url;
	else
		titleSpan.innerText = artist + " - " + title;
	
	setSource(url);
	playBtn.style.backgroundImage = "url(/player/img/pause.png)";
	player.play();
	}

	
	player.addEventListener('ended',function(){
	if(shuffle)
		shuffle();
	});
	
	
	player.addEventListener('timeupdate',function(){
		var time = this.currentTime;
		updatePlayer(getPos());
		updateProgressBar(getBarPos());
		updateTime();
	});
	
	function updateTime(){
	var time = secondsToTime(player.currentTime);
	if(time.h>0)
		currentTimeSpan.innerText = time.h + ":" + time.m + ":" + time.s;
	else
		currentTimeSpan.innerText = time.m + ":" + time.s;
	}

	player.addEventListener('loadedmetadata',function(){
		playing=true;
//		titleSpan.innerText = this.getAttribute("alt");
		totalTimeSpan.innerText = secondsToTime(player.duration).m + ":" + secondsToTime(player.duration).s;
	});
	
	playBtn.addEventListener('click',function(){
		if(playing){
			player.pause();
			playing = false;
			this.style.backgroundImage = "url(/player/img/play.png)";
			}
		else{
			player.play();
			playing = true;
			this.style.backgroundImage = "url(/player/img/pause.png)";
		}
	});
	
	
	function updatePlayer(posComp){
		display.style.backgroundPosition = posComp;
	}
	function updateProgressBar(posComp){
		handle.style.left = posComp;
	}
	function getPos(){
		var duration = player.duration;
		var currentTime = player.currentTime;
		var percent = currentTime/duration;
		var pos = Math.ceil(30000 * percent);
		var posComp = -pos-4+496+"px 0px";
		return posComp;
	}
	
	function getBarPos(){
		var duration = player.duration;
		var currentTime = player.currentTime;
		var percent = currentTime/duration;
		var pos = Math.ceil(200 * percent);
		return pos;
	}
	
	display.addEventListener('mousedown', function(e) {
					var x = e.pageX,
						offset = this.offsetLeft,
						width = display.style.width,
						newTime = 0,
						percentage = 0,
						time = 0,
						change = 0,
						perSec = 0,
						pixelsPerSec = 0,
						increase = 0,
						duration = 0;
						duration = player.duration;
						time = player.currentTime;
						change = ((x - offset)-496);
						pixelsPerSec = 30000/duration;
						increase = time+change/pixelsPerSec
						player.currentTime = increase;
						
		});
		
	bar.addEventListener('mousedown', function(e) {
					mousedown = true;
					var x = e.pageX,
						offset = this.offsetLeft,
						width = this.style.width,
						time = player.currentTime,
						duration = player.duration;
						var change = (x - offset);
						player.currentTime = ((x-offset)/200)*duration;
						
		});
		
		bar.addEventListener('mouseup', function(e) {
			mousedown = false;
		});
		
		
		bar.addEventListener('mousemove', function(e) {
			if(mousedown){
				var x = e.pageX,
				offset = this.offsetLeft;	
				var duration = player.duration;				
				player.currentTime = ((x-offset)/200)*duration;
			}	
		});
	
	function getClientWidth() {
  return document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientWidth:document.body.clientWidth;
}


function secondsToTime(secs)
{
    var hours = Math.floor(secs / (60 * 60));
   
    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);
	if(minutes <10)
		minutes = "0" + minutes;
    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);
	if(seconds <10)
		seconds = "0" + seconds;
   
    var obj = {
        "h": hours,
        "m": minutes,
        "s": seconds
    };
    return obj;
}
function setSource(url) {
	
		// Fix for IE9 which can't set .src when there are <source> elements. Awesome, right?
		var 
			existingSources = player.getElementsByTagName('source');
		while (existingSources.length > 0){
			player.removeChild(existingSources[0]);
		}
	
		if (typeof url == 'string') {
			player.src = url;
		} else {
			var i, media;

			for (i=0; i<url.length; i++) {
				media = url[i];
				if (player.canPlayType(media.type)) {
					player.src = media.src;
				}
			}
		}
		//player.play();
}
});

function findIndex(obj,value){
var ctr = "";
for (var i=0; i < obj.length; i++) {
// use === to check for Matches. ie., identical (===), ;
if (obj[i] === value) {
return i;
}
}
return ctr;
};


