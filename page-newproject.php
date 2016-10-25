<?php
include 'functions.php';


/*
	'user' => $_POST['uname'], 
	'project' => $_POST['pname'],
	'description' => $_POST['description'],
	'files' => $_POST['files']);
*/

$target_dir = "~/public_html/staging/wp-content/themes/blankslate-child/projects/". $_POST['pname'];
//path from site root, used for php functions
$php_path = "wp-content/themes/blankslate-child/projects/".$_POST['pname']."/";

$date = date("Y-m-d H:i:s");

$valid = 1;

if (file_exists($php_path)){
	//echo "Project name already exists";
	$valid = 0;
}

$w = $_FILES['files'];
$wavs = reArrayFiles($w);

if ($valid == 1){
	shell_exec('mkdir ' . $target_dir . '');

	foreach($wavs as $i){
		//shell_exec('cd ' . $target_dir );
		if(move_uploaded_file($i['tmp_name'], $php_path.$i['name'])){}
	}
/*
	$conn = new mysqli("staging.thestarvingsailor.ca","starvingsailordb","sailor","starvingsailorstagingdb");
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT into Projects (date,description,Name,owner) VALUES ('".$date."', '".$_POST['description']."', '".$_POST['pname']."', '".$_POST['uname']."')";

	if ($conn->query($sql) === TRUE) {
    	echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
*/

} else{
	//echo "<script type='text/javascript'>alert('INVALID! try again bitch.');</script>";
	$re = home_url("upload");
	header('Location: '.$re);
}

function reArrayFiles($file)
{
    $file_ary = array();
    $file_count = count($file['name']);
    $file_key = array_keys($file);
    
    for($i=0;$i<$file_count;$i++)
    {
        foreach($file_key as $val)
        {
            $file_ary[$i][$val] = $file[$val][$i];
        }
    }
    return $file_ary;
}



get_header();

?>

<div class="fluid-container body">
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="well proj-head">
				<div class="col-lg-6">
					<h1 style="display:inline-block; vertical-align:10px">Project 1</h1>
					&nbsp;
					&nbsp;
					<ul class="list-inline project-info" style="display:inline-block;">
						<li>
							<h4>
								Artist: jim </br>
								Date: July 19, 2016 </br>
								Branches: 2
							</h4>
						</li>
						<li>
							<h4>
							Tracks: 12</br>
							Commits: 8</br>
							Length: 3:24
							</h4>
						</li>
					</ul>
				</div>
				<div class="col-lg-6">
					<audio controls>
						<source src="http://www.w3schools.com/html/horse.ogg" type="audio/ogg" />
						<source src="http://www.w3schools.com/html/horse.mp3" type="audio/mpeg" />
						<a href="http://www.w3schools.com/html/horse.mp3">horse</a>
					</audio>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
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
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Message</th>
								<th>User</th>
								<th>Date</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>Added bass</td>
								<td>magellin</td>
								<td>July 16, 2016</td>
							</tr>
							<tr>
								<td>Added bass</td>
								<td>magellin</td>
								<td>July 16, 2016</td>
							</tr>
							<tr>
								<td>Added bass</td>
								<td>magellin</td>
								<td>July 16, 2016</td>
							</tr>
							<tr>
								<td>Added bass</td>
								<td>magellin</td>
								<td>July 16, 2016</td>
							</tr>
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
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div id="track-section-header">
				<ul class="list-inline">
					<li>
						<h2>Tracks</h2>
					</li>
					<li>
						<button id="download" class="btn btn-warning">
									Download Project
						</button>
					</li>
					<li>
						<button id="upload" class="btn btn-success">
									Upload Track
						</button>
					</li>
					<li>
						<form class="form-inline" id="commit-form">
							<div class="form-group has-feedback">
								<input id="upload-file" type="file" class="form-control" multiple/>
							</div>
							<div class="form-group has-feedback">
								<input id="commit-msg" placeholder="Commit Message" type="text" class="form-control" />
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary">
											Commit
								</button>
							</div>
						</form>
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

				</ul>


			</div>
			
		</div>
	</div>
	<div class="row" id="tracks">
		<div class="col-lg-12 col-md-12">
			<div class="col-lg-2 col-md-2" id="trackheads">
				<div class="detailBox">
					<div class="track-head" id="th1">
						<label>Bass</label>
						<button type="button" class="btn btn-warning close" data-toggle="button" aria-pressed="false" id="solo">S</button>
						<button type="button" class="close mute" aria-hidden="true"><span class="glyphicon glyphicon-volume-off"></span></button>
						<button type="button" class="close unmute" aria-hidden="true" hidden><span class="glyphicon glyphicon-volume-up"></span></button>
						
					</div>
					<div class="track-head" id="th2">
						<label>Drumz</label>
						<button type="button" class="btn btn-warning close" data-toggle="button" aria-pressed="false" id="solo">S</button>
						<button type="button" class="close mute"  aria-hidden="true"><span class="glyphicon glyphicon-volume-off"></span></button>
						<button type="button" class="close unmute" aria-hidden="true" hidden><span class="glyphicon glyphicon-volume-up"></span></button>
					</div>
					<div class="track-head" id="th3">
						<label>tamborine</label>
						<button type="button" class="btn btn-warning close" data-toggle="button" aria-pressed="false" id="solo">S</button>
						<button type="button" class="close mute"  aria-hidden="true"><span class="glyphicon glyphicon-volume-off"></span></button>
						<button type="button" class="close unmute" aria-hidden="true" hidden><span class="glyphicon glyphicon-volume-up"></span></button>
					</div>
					<div class="track-head" id="th4">
						<label>Vox</label>
						<button type="button" class="btn btn-warning close" data-toggle="button" aria-pressed="false" id="solo">S</button>
						<button type="button" class="close mute" aria-hidden="true"><span class="glyphicon glyphicon-volume-off"></span></button>
						<button type="button" class="close unmute" aria-hidden="true" hidden><span class="glyphicon glyphicon-volume-up"></span></button>
					</div>
					<div class="track-head" id="th5">
						<label>Guitar</label>
						<button type="button" class="btn btn-warning close" data-toggle="button" aria-pressed="false" id="solo">S</button>
						<button type="button" class="close mute" aria-hidden="true"><span class="glyphicon glyphicon-volume-off"></span></button>
						<button type="button" class="close unmute" aria-hidden="true" hidden><span class="glyphicon glyphicon-volume-up"></span></button>
					</div>
					<div class="track-head" id="th6">
						<label>Guitar</label>
						<button type="button" class="btn btn-warning close" data-toggle="button" aria-pressed="false" id="solo">S</button>
						<button type="button" class="close mute" aria-hidden="true"><span class="glyphicon glyphicon-volume-off"></span></button>
						<button type="button" class="close unmute" aria-hidden="true" hidden><span class="glyphicon glyphicon-volume-up"></span></button>
					</div>
				</div>
			</div>
			<div class="col-lg-10 col-md-10" id="trackbods">
				<div class="track-box" id="tb1">
					
				</div>
				<div class="track-box" id="tb2">
					
				</div>
				<div class="track-box" id="tb3">
					
				</div>
				<div class="track-box" id="tb4">
					
				</div>
				<div class="track-box" id="tb5">
					
				</div>
				<div class="track-box" id="tb6">
					
				</div>
			</div>
		</div>
	</div>
	<?php get_footer(); ?>
</div>
</body>
</html>