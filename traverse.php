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
		$count=0;
		$array=array();
	
	/* load in a directory and read in the list of files contained in it */
	//if ($handle = opendir("/var/www/$dir")) {
//	if ($handle = opendir("/Users/anzor/mp3")) {
	if ($handle = opendir("mp3")) {


	   // echo "<a href='/'>Go Home</a> || <a href='/?dir=$parent'>Go Up a level</a><br /><br />";
	  //  echo "<b>Songs:</b> <br />";
	//	echo '<ul id="list">';
	  /*  echo "DIR IS AS FOLLOWS: $dir <br />"; */
	    $jsonString = 0;
		echo '[';
	    while (false !== ($file = readdir($handle))) {
		$pathfromroot = "$dir/$file"; /* Create a varible that will hold the entire path from / */
	
		
			if (preg_match("/mp3$/", "$file")){
				// Analyze file and store returned data in $ThisFileInfo
				$ThisFileInfo = $getID3->analyze($pathfromroot);
				getid3_lib::CopyTagsToComments($ThisFileInfo);				
				$artist = $ThisFileInfo['comments_html']['artist'][0];
				$title = $ThisFileInfo['tags']['id3v2']['title'][0];

				//here we build the JSON string				
				//if ID3 tags are empty - display file name
				if($artist == '' OR $title == '')
						$jsonString = '{"dir": "'.$dir.'", "filename": "'.$file.'", "artist": "Unknown Artist", "album": "'.$album.'","title": "'.$file.'"},';
				else		
						$jsonString = '{"dir": "'.$dir.'", "filename": "'.$file.'", "artist": "'.$artist.'", "album": "'.$album.'","title": "'.$title.'"},';

				//$jsonString = '{"dir": "'.$dir.'", "filename": "'.$file.'", "artist": "'.$artist.'", "album": "'.$album.'","title": "'.$title.'"},';
				echo $jsonString;
				
				$array[$count] = "/?dir=$dir&play=$pathfromroot";
				$count=$count+1;
		
			}
			else
				{
					/* This block is used for non mp3 files which it presumes are folders. Error checking needs to be implmented. */
				  //		if ($file != '.' && $file != '..'){
				  //		echo "<a href='/?dir=$pathfromroot'>$file</a> <br />";
				  //	}
				}
		}
		echo '{"dir": "0" , "filename": "0", "artist": "0", "album": "0","title": "0"}]';
		
    		closedir($handle);
	}
	/* Motherfucking cocksucking christ, I spent like 30 minutes learning that one should not code after 2 am. 'While' loops how do they work??!?!?!?! */
	//shuffle($array);
	/* <!-- This script is used to pull the status of the ending of a song. --> */
	?>