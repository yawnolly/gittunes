<?php

	//path from site root, used for php functions
	$site_root = "wp-content/themes/blankslate-child/projects/";
	$server_root = "~/gittunes/".$site_root;

	$date = date("Y-m-d H:i:s");

function reArrayFiles($file){
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

function fetch_all_projects(){
	global $wpdb;
	return $wpdb->get_results("SELECT * FROM wp_projects", "ARRAY_N");
}

function fetch_project_info($id){
	global $wpdb;
	return $wpdb->get_row("SELECT * FROM wp_projects WHERE id = ".$id);
}

function fetch_tracks($pid){
	global $wpdb;
	return $wpdb->get_results("SELECT * FROM wp_tracks WHERE project_id = ".$pid, "ARRAY_A");
}

function push_project($wavs,$post){
	global $wpdb;

	$results = $wpdb->insert('wp_projects',array('date' => date("Y-m-d H:i:s"),'description' => $post['description'],'name' => $post['pname'],'user' => $post['uname']));

	$pid = $wpdb->get_var("SELECT id FROM wp_projects ORDER BY id DESC LIMIT 1");

	foreach($wavs as $i){
		$wpdb->insert('wp_tracks',array('name' => $i['name'], 'project_id' => $pid));
	}

	return $pid;

}

function wavDur($file) {
  $fp = fopen($file, 'r');
  if (fread($fp,4) == "RIFF") {
    fseek($fp, 20);
    $rawheader = fread($fp, 16);
    $header = unpack('vtype/vchannels/Vsamplerate/Vbytespersec/valignment/vbits',$rawheader);
    $pos = ftell($fp);
    while (fread($fp,4) != "data" && !feof($fp)) {
      $pos++;
      fseek($fp,$pos);
    }
    $rawheader = fread($fp, 4);
    $data = unpack('Vdatasize',$rawheader);
    $sec = $data[datasize]/$header[bytespersec];
    $minutes = intval(($sec / 60) % 60);
    $seconds = intval($sec % 60);
    return str_pad($minutes,2,"0", STR_PAD_LEFT).":".str_pad($seconds,2,"0", STR_PAD_LEFT);
  }
}
?>