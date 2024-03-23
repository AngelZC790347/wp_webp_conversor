<?php
/*
 * Plugin Name: Webpc Conversor
 */

function webpc_conversor_start($baseDir){
	if($baseDir == ""){
		$baseDir = wp_get_upload_dir()['basedir'];
	}	
	$files = scandir($baseDir);	
	foreach ($files as $file) {			
		if (is_numeric($file)){
			webpc_conversor_start($baseDir.'/'.$file);
		}elseif(preg_match("#\.(jpg|jpeg|gif|png)$# i",$baseDir.'/'.$file)){
			convert_to_webp($baseDir.'/'.$file);
		}
	}
}
add_action('admin_notices', 'webpc_conversor_start');
function convert_to_webp(string $imagePath){	
	$newImagePath =preg_replace("#\.(jpg|jpeg|gif|png)$# i",'.webp',$imagePath);
	$command = "/opt/homebrew/bin/cwebp -o '$newImagePath'"." '$imagePath'".' 2>&1';
	system("sudo -S ".$command,$result_code);			
}