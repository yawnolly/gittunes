<?php 
include_once 'functions.php';

if (isset($_POST["upload"])){
	set_time_limit(600);
	ini_set('memory_limit', '256M');
	ini_set('max_execution_time', 0);

	$_POST['pname'] = str_replace(' ', '_', $_POST['pname']);
	$_POST['pname'] = str_replace("'", "", $_POST['pname']);

	//path from site root, used for php functions
	$php_path = $site_root.$_POST['pname']."/";

	$date = date("Y-m-d H:i:s");

	//VALIDATION
	$valid = 1;
	$name_er = $type_er = $nofile_er = "";

	if (file_exists($php_path)){
		$name_er = "Project name already exists. ";
		$valid = 0;
	}
	
	foreach ($_FILES['files']['name'] as $i) {
		$type = pathinfo($php_path.$i,PATHINFO_EXTENSION);
		if ($type != "wav" && $type != "mp3" && $type != "pit"){
			$type_er = "All files must be .wav, .mp3 or .pit (for some reason).";
			$valid = 0;
		}
	}

	if ($_FILES['files']['size'] == 0){
		$nofile_er = "Please upload at least one file";
		$valid = 0;
	}

	$w = $_FILES['files'];
	$wavs = reArrayFiles($w);

	if ($valid == 1){
		$o = mkdir($php_path);
		shell_exec("git init ".$php_path);

		global $wpdb;

		$wpdb->insert('wp_projects',array('date' => date("Y-m-d H:i:s"),'description' => $_POST['description'],'name' => $_POST['pname'],'user' => $_POST['uname']));
		$pid = $wpdb->get_var("SELECT id FROM wp_projects ORDER BY id DESC LIMIT 1");
	
		foreach($wavs as $i => $aud){
			$t = $_POST["track".$i];
			$aud['name'] = str_replace(' ', '_', $aud['name']);
			$aud['name'] = str_replace("'", "", $aud['name']);
			move_uploaded_file($aud['tmp_name'], $php_path.$aud['name']);
			$wpdb->insert('wp_tracks',array('name' => $t, 'filename' => $aud['name'], 'project_id' => $pid));
		}
		
		shell_exec("git add *");
		shell_exec("git commit -m '".$_POST['description']."'");

		header("Location: ".home_url("project?pid=".$pid));

	} else{
		echo "<script type='text/javascript'>alert('".$name_er.$type_er."');</script>";
	}
}



get_header(); ?>

<div class="container-fluid body">
	<div class="row headroom">
		<div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">Upload a Project (all fields are required) <?php echo $o ?></div>

				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action=<?php echo home_url("upload"); ?>>
						
						<div class="form-group">
							<label class="col-md-4 control-label">User Name</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="uname">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Project Name</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="pname">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Description</label>

							<div class="col-md-6">
								<textarea  rows="4" style="width:100%" name="description"></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Files (wav,mp3)</label>

							<div class="col-md-6">
								<div class="input-group">

									<input id="upload-file" type="file" class="form-control" name="files[]" multiple>
								</div>
							</div>
						</div>

						<span id="list-of-tracks"></span>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" name="upload" class="btn btn-primary">
									Upload
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php get_footer(); ?>
</div>
</body>
</html>