<?php
include 'functions.php';

if (isset($_GET['pname'])){

	$path_parts = pathinfo($site_root.$_GET['pname'])))
	$proj_path = $site_root.$path_parts['basename'];

	$files = scandir($proj_path);
	foreach ($files as $f) {
		readfile($f);
	}
	
	header("Location: ".home_url("project"));
}


?>