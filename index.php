<html>
	<head>
		<title>Player</title>
		<script src="js/script.js" type="text/javascript"></script>
		<link href="css/style.css" rel="stylesheet"/>
	</head>
	<body>
		<div id="playerdiv">
			<div class="meta">
				<div id="controls" style="float:left">
					<div id="prevBtn" class="btn"></div>
					<div id="playBtn" class="btn"></div>
					<div id="nextBtn" class="btn"></div>
				</div>
				<div id="titleSpan">Title</div>

				<div class="progressBar" style="float:right">
					<span id ="currentTime" style="float:left">00:00</span><div id="bar"><div id="handle"></div></div><span id ="totalTime">00:00</span>
				</div>
			</div>
						<div id="display">
				<div class="container window">
						<div style="border-right:1px solid rgba(173, 58, 211, 0.4)"></div>
						<div></div>
				</div>		
			</div>
			
			
			
			
			<div id="playlist">
			<!-- The actual music player business. -->
<?php
		/* Pull in all of the variables off of the url string and parse out any URL encoding. */
		//$root = "player";
		require_once('getid3/getid3.php');
		$getID3 = new getID3;
		
		$dir= "mp3".($_GET['dir']);
		$dir=(urldecode($dir));
		$play=($_GET['play']);
		$play=(urldecode($play));

		/* This is used to create the $parrent variable which is the current directory minus the last subdirectory */
		$explode=array();
		$explode = explode("/",$dir);
		$total = count($explode);
		$total=$total-1;
		unset($explode[$total]);
		foreach($explode as &$i) {
			$parent .= "/$i";
		}
?>
		<audio style='display:none' id='player' src='<?php echo"$play";?>' type='audio/mp3' controls='controls'></audio>
		</div>

<div>
<?php
$count=0;
$array=array();
	
	/* load in a directory and read in the list of files contained in it */
	//if ($handle = opendir("/var/www/$dir")) {
	if ($handle = opendir("$dir")) {

	    echo "<a href='/'>Go Home</a> || <a href='/?dir=$parent'>Go Up a level</a><br /><br />";
	    echo "<b>Songs:</b> <br />";
		echo '<ul id="list">';
	  /*  echo "DIR IS AS FOLLOWS: $dir <br />"; */
	    
	    while (false !== ($file = readdir($handle))) {
		$pathfromroot = "$dir/$file"; /* Create a varible that will hold the entire path from / */
	
		
		if (preg_match("/mp3$/", "$file")){
			// Analyze file and store returned data in $ThisFileInfo
			$ThisFileInfo = $getID3->analyze($pathfromroot);
			getid3_lib::CopyTagsToComments($ThisFileInfo);
			
			$artist = $ThisFileInfo['comments_html']['artist'][0];
			$title = $ThisFileInfo['tags']['id3v2']['title'][0];
						
			/* This block is used for handling links that end in .mp3 */
			//echo "<a href='/player/?dir=$dir&play=$pathfromroot'>$file</a><br />";
			//if ID3 tags are empty - display file name
			if($artist == '' OR $title == '')
				echo "<li data-dir='".$dir."' data-filename='".$file."' data-id= '".$count."' data-artist='".$artist."' data-title='".$title."' data-url='$pathfromroot'>".$file."</a></li>";
			else
				echo "<li data-dir='".$dir."' data-filename='".$file."' data-id= '".$count."' data-artist='".$artist."' data-title='".$title."' data-url='$pathfromroot'>".$artist." - ".$title."</a></li>";

			$array[$count] = "/?dir=$dir&play=$pathfromroot";
			$count=$count+1;
		}
		else
			{
				/* This block is used for non mp3 files which it presumes are folders. Error checking needs to be implmented. */
        			if ($file != '.' && $file != '..'){
					echo "<a href='/?dir=$pathfromroot'>$file</a> <br />";
				}
			}
		}
		echo '</ul>';
    		closedir($handle);
	}
	/* Motherfucking cocksucking christ, I spent like 30 minutes learning that one should not code after 2 am. 'While' loops how do they work??!?!?!?! */
	//shuffle($array);
	/* <!-- This script is used to pull the status of the ending of a song. --> */
	?>
	</div>
	</div>

	</body>
</html>

