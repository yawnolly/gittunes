<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />

<!--music player -->
<link rel="stylesheet" href="/wp-content/themes/blankslate-child/assets/bootstrap3_player.css">

<!-- BOOTSTRAP IMPORT -
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous"> -->
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/> 

<!--custom styles -->
<link rel="stylesheet" href="/wp-content/themes/blankslate-child/style.css"> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="/wp-content/themes/blankslate-child/assets/BufferLoader.js"></script>
<!-- <script src="/wp-content/themes/blankslate-child/assets/SoundJS-0.6.2/src/soundjs/Sound.js"></script> 
<script src="/wp-content/themes/blankslate-child/assets/web-audio-recorder-js-master/lib/WebAudioRecorder.js"></script> -->

<?php wp_head(); ?>
</head>

<body <?php body_class();?>>
	<div class="container-fluid" >
		<nav class="navbar navbar-default navbar-fixed-top" id="top-bar">
			<div class="navbar-header">
				<a href=<?php echo home_url(); ?> class="navbar-brand">GitTunes</a>
			</div>
				<ul class="nav navbar-nav"> <!--
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#"><?php echo home_url(); ?></a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Separated link</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">One more separated link</a></li>
						</ul>
					</li> -->
					<li>
						<p class="navbar-btn">
							<a href=<?php echo home_url("upload"); ?> class="btn btn-success">Upload Project</a>
						</p>
					</li>
			<!--	<li>
						<audio controls>
							<source src="" type="audio/wav" />
						</audio>
					</li> -->
				</ul>
				<ul class="nav navbar-right navbar-search" id="nav-right">
					
					<li>
						<form action="">
							<input type="text" placeholder="Search Projects" class="search-query span2">
						</form>
					</li>
				</ul>
		</nav>
	</div>
