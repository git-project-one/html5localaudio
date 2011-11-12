window.addEventListener("load",function(){
	var player = document.getElementById('player');
	var display = document.getElementById('display');
	var handle = document.getElementById('handle');
	var currentTimeSpan = document.getElementById('currentTime');
	var totalTimeSpan = document.getElementById('totalTime');
	var bar = document.getElementById('bar');
	var playBtn = document.getElementById('playBtn');
	var playing = false;
	var mousedown = false;
	
	
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

	player.addEventListener('play',function(){
		totalTimeSpan.innerText = secondsToTime(player.duration).m + ":" + secondsToTime(player.duration).s;
	});
	
	playBtn.addEventListener('click',function(){
		if(playing){
			player.pause();
			playing = false;
			this.style.backgroundImage = "url(/musiverse/public/images/play.png)";
			}
		else{
			player.play();
			playing = true;
			this.style.backgroundImage = "url(/musiverse/public/images/pause.png)";
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
	
});