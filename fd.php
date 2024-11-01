<?php
 
if(!isset($_SERVER['HTTP_REFERER'])){
defined('ABSPATH') or die("Access Denied!");
	}
//check filetype
switch( $file_extension['extension'] ) {
		case "png": $content_type="image/png"; break;
		case "gif": $content_type="image/gif"; break;
		case "tiff": $content_type="image/tiff"; break;
		case "jpeg":
		case "jpg": $content_type="image/jpg"; break;
		default: $content_type="application/force-download";
}
header("Expires: 0");
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header('Cache-Control: pre-check=0, post-check=0, max-age=0', false); 
header("Pragma: no-cache");	
header("Content-type: {$content_type}");
header("Content-Disposition:attachment; filename={$file_new_name}");
header("Content-Type: application/force-download");
#header("Content-Type: application/download");
#header( "Content-Length: ". filesize($file_name) );
readfile("{$file_url}");
exit();
?>