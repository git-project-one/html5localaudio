<html>
	<head>
		<title>Player</title>
		<script src="js/script.js" type="text/javascript"></script>
		<link href="css/style.css" rel="stylesheet"/>
	</head>
	<body>
		<div id="playerdiv">
			<div id="controls">
				<div id="prevBtn" class="btn"></div>
				<div id="playBtn" class="btn"></div>
				<div id="nextBtn" class="btn"></div>
			</div>
			
			<div id="display">
				<div class="container window">
						<div style="border-right:1px solid rgba(173, 58, 211, 0.4)"></div>
						<div></div>
				</div>		
			</div>
			
			<div class="progressBar">
				<span id ="currentTime" style="float:left">00:00</span><div id="bar"><div id="handle"></div></div><span id ="totalTime">00:00</span>
			</div>
			<!-- The actual music player business. -->
<?php
		/* Pull in all of the variables off of the url string and parse out any URL encoding. */
		$dir=($_GET['dir']);
		$dir=(urldecode($dir));
		$play=($_GET['play']);
		$play=(urldecode($play));
		$explode=array();
		$explode = explode("/",$dir);
		$total = count($explode);
		$total=$total-1;
		unset($explode[$total]);
		foreach($explode as &$i) {
			$parent .= "/$i";
		}
?>
		<audio style='display:none' id='player' src='<?php echo"$play";?>' type='audio/mp3' controls='controls' autoplay='autoplay'></audio>
		</div>

<div>
<?php
$count=0;
$array=array();
	
	/* load in a directory and read in the list of files contained in it */
	if ($handle = opendir("/var/www/$dir")) {
	    echo "<a href='http://localhost/'>Go Home</a> || <a href='http://localhost/?dir=$parent'>Go Up a level</a><br /><br />";
	    echo "<b>Songs:</b> <br />";
	  /*  echo "DIR IS AS FOLLOWS: $dir <br />"; */
	    
	    while (false !== ($file = readdir($handle))) {
		$pathfromroot = "$dir/$file"; /* Create a varible that will hold the entire path from / */
	
		
		if (preg_match("/mp3$/", "$file")){
			/* This block is used for handling links that end in .mp3 */
			echo "<a href='http://localhost/?dir=$dir&play=$pathfromroot'>$file</a><br />";
			$array[$count] = "http://localhost/?dir=$dir&play=$pathfromroot";
			$count=$count+1;
		}
		else
			{
				/* This block is used for non mp3 files which it presumes are folders. Error checking needs to be implmented. */
        			if ($file != '.' && $file != '..'){
					echo "<a href='http://localhost/?dir=$pathfromroot'>$file</a> <br />";
				}
			}
		}

    		closedir($handle);
	}
	/* Motherfucking cocksucking christ, I spent like 30 minutes learning that one should not code after 2 am. 'While' loops how do they work??!?!?!?! */
	shuffle($array);
	/* <!-- This script is used to pull the status of the ending of a song. --> */
	?>
		<script>
			var audio = document.getElementsByTagName('audio')[0];
			audio.addEventListener('ended', function () {
			window.location='<?php echo"$array[0]"; ?>'
			} );
		</script>
	</div>

	</body>
</html>

