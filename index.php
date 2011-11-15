<html>
	<head>
		<title>Player</title>
		<script src="js/script.js" type="text/javascript"></script>
		<script src="js/json2.js" type="text/javascript"></script>

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
		<audio style='display:none' id='player' src='<?php echo"$play";?>' type='audio/mp3' controls='controls'></audio>
		</div>

<div>

	</div>
	</div>

	</body>
</html>

