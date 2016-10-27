<?php
include_once 'functions.php';

$pid = $_GET['pid'];
$data = fetch_project_info($pid);

$tracks = fetch_tracks($pid);
$json = json_encode($tracks);
//echo "<script type='text/javascript'>alert('".$json."');</script>";

$path_parts = pathinfo($site_root.$data->name);
$proj_path = $site_root.$path_parts['basename'];
$shell_path = $server_root.$path_parts['basename']."/";

chdir($proj_path);
exec("git log", $op);
$log = parseLog($op);
ChromePhp::log($log);

if (isset($_POST['download']) && $_POST['download'] = 1){
	ignore_user_abort(true);

	$zip = new ZipArchive();
	$filename = $data->name.".zip";
	$zip->open($site_root.$filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

	$files = preg_grep('/^([^.])/', scandir($proj_path));

	foreach ($files as $f) {
		$zip->addfile($proj_path."/".$f, $data->name."/".$f);
	}

	$zip->close();

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"".$filename."\"");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($site_root.$filename));
	ob_end_flush();
	readfile($site_root.$filename);

	unlink($site_root.$filename);
}

elseif (isset($_POST["commit"])){

	foreach ($_FILES['files']['name'] as $i) {
		$type = pathinfo($proj_path.$i,PATHINFO_EXTENSION);
		if ($type != "wav" && $type != "mp3" && $type != "pit"){
			echo "<script type='text/javascript'>$('#file-type-error').show()</script>";
			$valid = 0;
		}
	}

	//data allocation
	global $wpdb;

	$f = $_FILES['files'];
	$files = reArrayFiles($f);
	foreach ($files as $i => $f) {
		$f['name'] = str_replace(' ', '_', $f['name']);
		$f['name'] = str_replace("'", "", $f['name']);
		move_uploaded_file($f['tmp_name'], $proj_path.'/'.$f['name']);
		$wpdb->insert('wp_tracks',array('name' => $_POST['track'.$i], 'filename' => $f['name'], 'project_id' => $pid));
	}

	$_POST['msg'] = str_replace("\n", " ", $_POST['msg']);
	exec('wp-content/themes/blankslate-child/shellscripts/commit.sh '.$data->name.' '.'"'.$_POST['msg'].'"');

	header("Refresh:0");
}


get_header(); 
?>


<script type="text/javascript">

alert

var audioCtx = new (window.AudioContext || window.webkitAudioContext)();

var sources = [];
var isPlaying = false;
var seek;

var channelVolume = [];
var vol = audioCtx.createGain();

var trackLength = 0;
var init = true;
var curTime = 0;
var paths = [];

$(document).ready(function(){
	var obj = JSON.parse('<?php echo $json ?>');

	var audioPath = "../wp-content/themes/blankslate-child/projects/"+"<?php echo $data->name ?>"+"/";

	// for(var i = 0; i<obj.length;i++){
	// 	audio.push(new Audio());
	// 	audio[i].src = audioPath+obj[i].name;
	// 	audio[i].loop = true;
	// 	audio[i].mediaGroup = "g";
	// 	sources.push(audioCtx.createMediaElementSource(audio[i]));
	// 	channelVolume.push(audioCtx.createGain());
	// 	sources[i].connect(channelVolume[i]);
	// 	channelVolume[i].connect(vol);
	// }

	
	
	for(var i = 0; i<obj.length;i++){
		paths.push(audioPath+obj[i].filename);
		sources.push(audioCtx.createBufferSource());
		channelVolume.push(audioCtx.createGain());
		sources[i].connect(channelVolume[i]);
		channelVolume[i].connect(vol);
	}

	sources[0].addEventListener("ended", resetProject);

	var loader = new BufferLoader(audioCtx,paths,finishLoading);

	loader.load();

	vol.connect(audioCtx.destination);
	// audio[0].preload = "metadata";

	// audio[0].onloadedmetadata = function(){
	// 	trackLength = audio[0].duration;
	// 	$("#seek").attr("max", trackLength);
	// 	for (var i = 0;i<trackLength;i=i+10){
	// 		$('#steplist').append("<option>"+i+"</option>");
	// 	}
	// }

	
})



function finishLoading(bufferList){
	for (var i = 0; i<bufferList.length; i++){
		sources[i].buffer = bufferList[i];
	}
	if (init){
		trackLength = sources[0].buffer.duration;
		$("#seek").attr("max", trackLength);
		for (i = 0;i<trackLength;i=i+30){
			$('#steplist').append("<option>"+i+"</option>");
		}
		init = false;
	}

	sources[0].onended = resetProject;
}



function volume(level){
	vol.gain.value = level/100;
}


</script>

<div class="fluid-container body">
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="well proj-head">
				<div class="col-lg-6">

					<h1 style="display:inline-block; float:left;"><?php echo $data->name."--".$msg ?></h1>
					&nbsp;
					&nbsp;
					<ul class="list-inline project-info" style="display:inline-block;">
						<li>
							<h4>
								Artist: <?php echo $data->user; ?> </br>
								Date: <?php echo $data->date; ?> </br>
								Branches: <?php echo $data->branches; ?>
							</h4>
						</li>
						<li>
							<h4>
								Tracks: </br>
								Commits: <?php echo $data->commits; ?></br>
								Length: 3:24
							</h4>
						</li>
					</ul>
				</div>
				<div class="col-lg-6">
					<div id="track-section-header">
						<ul class="list-inline">
							<li style="float:right;">
								<form action="" method="POST" role="form" class="form-inline">
									<input type="hidden" name="download" value="1" />
									<button type="submit" id="download" class="btn btn-warning")>
											Download Project
									</button>
								</form>
							</li>
							<li style="float:right;">
								<button id="upload" class="btn btn-success">
											Upload Track
								</button>
							</li>							
							<li>
								<ul class="list-inline" id="transport-box">
									<li>
										<button class="play-button" onclick="playProject()" accesskey=" "><i class="fa fa-play"></i></button>
										<button class="pause-button" onclick="pauseProject()" hidden><i class="fa fa-pause"></i></button>
									</li>
									<li>
										<div class="input-group">
											<label for="vol">Master Volume</label>
											<input id="vol" class="vol-slider" type="range" oninput="volume(this.value)" min="0" max="200" />
										</div>
									</li>
								</ul>
							</li>
							<li id="successful-commit">
								<div class="alert alert-success">
									Successfully Commited!
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								</div>
							</li>
							<li id="no-file-commit">
								<div class="alert alert-danger">
									Please Include At least 1 file.
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								</div>
							</li>
							<li id="no-comment-commit">
								<div class="alert alert-danger">
									Please Include commit message.
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								</div>
							</li>
							<li id="file-type-error">
								<div class="alert alert-danger">
									Incorrect File Type
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div id="commit-form-wrapper">
			<form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="commit-form">
				<div class="form-group has-feedback">
					<div class="col-lg-offset-2 col-lg-2">
						<input type="file" name="files[]" id="commit-file"  class="form-control" multiple />
					</div>
				</div>


				<span id="list-of-tracks"></span>


				<div class="form-group has-feedback">
					<div class="col-lg-offset-2 col-lg-6">
						<div class="input-group">

							<input name="msg" id="commit-msg" placeholder="Commit Message" type="text" class="form-control" />

							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit" name="commit" id="commit-button">Commit</button>
							</span>
						</div>				
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="col-lg-2 col-md-2" id="trackheads">
				<div class="detailBox">
				<?php 
					foreach ($tracks as $i => $t) {
						echo '<div class="track-head" id="th'.$i.'">
								<label>'.$t['name'].'</label>
								<button type="button" class="btn btn-warning close" data-toggle="button" aria-pressed="false" id="solo">S</button>
								<button type="button" class="close mute" aria-hidden="true"><span class="glyphicon glyphicon-volume-off"></span></button>
								<button type="button" class="close unmute" aria-hidden="true" hidden><span class="glyphicon glyphicon-volume-up"></span></button>
							</div>';
					}
					
				?>
				</div>
			</div>
			<div class="col-lg-10 col-md-10" id="trackbods">
				<input id="seek" type="range" min="0" value="0" list="steplist" />
				<datalist id="steplist">
				</datalist>
				<?php
					foreach ($tracks as $i => $t) {
						echo '<div class="track-box" id="tb'.$i.'"></div>';
					}	
				?>
			</div>
		</div>
	</div>

	<div class="row" id="community-content">
		<div class="col-lg-12 col-md-12">
			<div class="col-lg-6">
				<div class="detailBox" style="height:298px;">
					<div class="titleBox">
					<label>Commit History</label>
					&nbsp; <!--
					<div class="form-group" style="display:inline-block; margin-bottom:-5px">
						<select class="form-control" >
							<option active>branch1</option>
							<option>branc21</option>
							<option>branch3</option>
							<option>branch4</option>
						</select>
					</div> -->
					</div>
					<table class="table table-bordered" id="commit-table">
						<thead>
							<tr>
								<th>#</th>
								<th>Message</th>
								<th>User</th>
								<th>Date</th>
							</tr>
						</thead>

						<tbody>
						<?php foreach ($log as $i => $commit) { ?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $commit['message'] ?></td>
								<td><?php echo $commit['author'] ?></td>
								<td><?php echo $commit['date'] ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>		
			</div>
			<div class="col-lg-6">
				<div class="detailBox">
					<div class="titleBox">
						<label>Comment Box</label>
						<button type="button" class="close" aria-hidden="true">&times;</button>
					</div>
					<div class="actionBox">
						<ul class="commentList">
							<li>
								<div class="commenterImage">
								  <img src="http://placekitten.com/50/50" />
								</div>
								<div class="commentText">
									<p class="">Hello this is a test comment.</p> <span class="date sub-text">on March 5th, 2014</span>

								</div>
							</li>
							<li>
								<div class="commenterImage">
								  <img src="http://placekitten.com/45/45" />
								</div>
								<div class="commentText">
									<p class="">Hello this is a test comment and this comment is particularly very long and it goes on and on and on.</p> <span class="date sub-text">on March 5th, 2014</span>

								</div>
							</li>
							<li>
								<div class="commenterImage">
								  <img src="http://placekitten.com/40/40" />
								</div>
								<div class="commentText">
									<p class="">Hello this is a test comment.</p> <span class="date sub-text">on March 5th, 2014</span>

								</div>
							</li>
							<li>
								<div class="commenterImage">
								  <img src="http://placekitten.com/40/40" />
								</div>
								<div class="commentText">
									<p class="">Hello this is a test comment.</p> <span class="date sub-text">on March 5th, 2014</span>

								</div>
							</li>
							<li>
								<div class="commenterImage">
								  <img src="http://placekitten.com/40/40" />
								</div>
								<div class="commentText">
									<p class="">Hello this is a test comment.</p> <span class="date sub-text">on March 5th, 2014</span>

								</div>
							</li>
						</ul>
						<form class="form-inline" role="form">
							<div class="form-group">
								<input class="form-control" type="text" placeholder="Your comments" style="width:100%"/>
							</div>
							<div class="form-group">
								<button class="btn btn-default">Add</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php get_footer(); ?>
</div>
</body>
</html>
