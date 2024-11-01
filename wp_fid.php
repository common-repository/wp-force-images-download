<?php
/**
 * Plugin Name: WP-Force Images Download
 * Plugin URI: https://wordpress.org/plugins/wp-force-image-download/
 * Description: Put wp_fid(); template tag or [wpfid] shortcode where you want to appear the download button. For more details and usage see description.
 * Author: Nazakat Ali
 * Author URL: https://profiles.wordpress.org/nazakatali32
 * Version: 1.8
 * License: GPL2
 */
 /*  Copyright 2014  Nazakat Ali  (email : nazakatali32@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
defined('ABSPATH') or die("No script kiddies please...!");
require_once('inc.php');
require_once('func.php');



function wpfid_nonce_chk(){
if ( ! empty( $_POST['pic_url_nonce'] ) && !wp_verify_nonce( 'pic_url2', 'pic_url_nonce' )
	){
		exit('Sorry, your nonce did not verify.');
	}
	if ( ! empty( $_POST['pic_url_nonce'] ) && !wp_verify_nonce( 'new_name2', 'new_name_nonce' )
	){
   exit('Sorry, your nonce did not verify.');
   } 
   
}

add_action('admin_init','wpfid_nonce_chk',999);


function wpfid_styles(){
wp_register_style('wpfid', plugins_url('style.css', __FILE__), array(), 'all');
wp_enqueue_style('wpfid');

}add_action('wp_enqueue_scripts','wpfid_styles',999);

function wpfid_custom_css() {
	//custom css
$wpfid_options = get_option( 'wp_force_images_download_options');


if( is_array($wpfid_options) ) {
$wpfid_custom_css = htmlspecialchars(trim($wpfid_options['wpfid_custom_css']));
}


if(isset($wpfid_custom_css) and !empty($wpfid_custom_css)){
 wp_deregister_style( 'wpfid' );
  $wpfid_custom_css = str_replace(";"," !important;",$wpfid_custom_css);
echo "<style type=\"text/css\">".$wpfid_custom_css."</style>";
 wp_add_inline_style( 'wpfid', $wpfid_custom_css );
}
}add_action( 'wp_enqueue_scripts', 'wpfid_custom_css' );




function wp_fid_short($atts){
	global $wpfid_icon;
	global $image_size_fid;
	global $style_fid;
extract( shortcode_atts(
		array(
			'title' => 'Download',
			'color' => 'gray',
			'link' => '',
			'class' => '',
			'new_name' => ''
		), $atts )
	);
	

	if (empty($link) && has_post_thumbnail() )
	{
			
			global $post;
			$filelink = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			$filelink = $filelink[0];
		
	}
	else
	{
		 $filelink = $link;
		#$filesize = filesize($filelink );
	}
		//get form values
		$wpfid_options = get_option( 'wp_force_images_download_options');
		
		global $wpfid_field;
		if(isset($wpfid_options['wpfid_single']))
		{
			$wpfid_field = sanitize_text_field($wpfid_options['wpfid_single']);
	
		};
		if(isset($wpfid_options['size_check_box']))
		{
			$wpfid_image_size = sanitize_text_field($wpfid_options['size_check_box']);
	
		};
		if(isset($wpfid_options['icon_check_box']))
		{ 
			$wpfid_icon = sanitize_text_field($wpfid_options['icon_check_box']);
		};
		if(isset($wpfid_options['button_styles']))
		{ 
			$wpfid_btn_style = sanitize_text_field(($wpfid_options['button_styles']));
		}
		if(isset($wpfid_options['wpfid_custom_css']))
		{ 
			$wpfid_custom_css = htmlspecialchars(trim($wpfid_options['wpfid_custom_css']));
		};
			
		
		

		
		//style															//since v 1.5
		if(isset($wpfid_btn_style)){
		
		if($wpfid_btn_style == 1){
			$btn_style = "style=\"background: none;\"";
			$btn_style .= " class=\"$class\"";
			}
		if($wpfid_btn_style == 2){
			if($wpfid_icon == 0){
				$btn_style = "style=\"background: none repeat scroll 0% 0% $color;\"";
				$btn_style .= " class=\"wpfid_button $class none \"";
			}else{
				$btn_style = "style=\"background: none repeat scroll 0% 0% $color;\"";
				$btn_style .= " class=\"wpfid_button $class\"";
			}
			}
		if($wpfid_btn_style == 3){
			if($wpfid_icon == 0){
				$btn_style = "class=\"wpfid_button $class button none button-$color\"";
			}else{
				$btn_style = "class=\"wpfid_button  $class button button-$color\" style=\"height:46px;\"";
			}
			
			}
		}else{
			$btn_style = "style=\"background: none repeat scroll 0% 0% $color;\"";
			$btn_style .= " class=\"$class\"";
		}
		

		//filesize 														//since v 1.5
	if(isset($wpfid_image_size) and $wpfid_image_size == 1){
			
		//Get Image size in (B, Kb, Mb, Gbs, etc)	
			// Assume failure.
			$result = -1;

			$curl = curl_init( $filelink );

			// Issue a HEAD request and follow any redirects.
			curl_setopt( $curl, CURLOPT_NOBODY, true );
			curl_setopt( $curl, CURLOPT_HEADER, true );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
			#curl_setopt( $curl, CURLOPT_USERAGENT, get_user_agent_string() );

			$data = curl_exec( $curl );
			curl_close( $curl );

			if( $data ) {
				$content_length = "unknown";
				$status = "unknown";

				if( preg_match( "/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches ) ) {
				$status = (int)$matches[1];
				}

				if( preg_match( "/Content-Length: (\d+)/", $data, $matches ) ) {
				$content_length = (int)$matches[1];
				}

				// http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
				if( $status == 200 || ($status > 300 && $status <= 308) ) {
				$size_result = $content_length;
			}
			}
			//File Size Result
			$size_result;
			
			#$image_size_fid = (isset($wpfid_image_size)? print '<br/> <span class=\'size\'>27.6Mb'.@wpfid_sizes(filesize($filelink)).'</span>' : print'');
			#$image_size_fid = '<br/><span class=\'size\'>'.@wpfid_sizes(remote_filesize($filelink)).'</span>';
			$image_size_fid = '<br/><span class=\'size\'>'.@wpfid_sizes($size_result).'</span>';
			if($wpfid_btn_style == 3){
			$style_fid = 'style="line-height: 16px !important;"';
		}
		}else{
			$style_fid = 'style="line-height: 30px;"';
			#($wpfid_image_size == 0 ?  print "style=\"line-height: 30px;\"" : print '')
		}
		
		//rename 														//since v 1.4
			$meta = array('%site_name%','%post_title%','%timestamp%','%post_id%','%rand%','%md5%','%filename%');
			$values = array
			(
				get_bloginfo( 'blogname'),
				get_the_title(),
				current_time('timestamp'),
				get_the_id(),
				mt_rand(0,100000),										//php 4.2.0
				md5(basename($filelink)),
				array_shift(explode(".", basename($filelink))),			//basename($filelink)
			);
			
		
		//output														// since v 1.5
		if(isset($new_name) and !empty($new_name))
		{
				$new_name_opt = str_replace ($meta, $values, $new_name);
		}
		else
		{
			$new_name_opt = str_replace ($meta, $values, $wpfid_field);
			
		}
		
wp_nonce_field('pic_url2','pic_url_nonce'); 
wp_nonce_field('new_name2','new_name_nonce'); 


//shortcode
$table_contents = "<table id=\"wpfid-table\" width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"><tr><td align=\"center\">";
$table_contents .="<form id=\"wpfid-form\" method=\"post\" action=\"".plugins_url('wpfid.php',__FILE__)."\">"; 
$table_contents .=		"<input name=\"wpfid_pic_url\" type=\"hidden\" value=\"".$filelink."\" />";
$table_contents .=		"<input name=\"new_name\" type=\"hidden\" value=\"".esc_attr($new_name_opt)."\" />";
			//<input  id=\"wpfid_button\" class=\"wpfid_button\" type=\"submit\" title=\"". $title."\" value=\"".$title."\" />
$table_contents .= "<button $btn_style id=\"wpfid_button\" type=\"submit\" title=\"". esc_attr($title)."\" ><span $style_fid class=\"wpfid_title\">".esc_html($title)."</span>$image_size_fid</button>";
$table_contents .=	"</form></td></tr></table>";
return $table_contents;

}
if (!is_admin()) {
     add_shortcode( 'wpfid' , 'wp_fid_short' );
}


//template Tag
function wp_fid($btn_text = "Download",$btn_color = "gray",$new_name=""){
if(has_post_thumbnail()){
$filelink = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
$filelink = $filelink[0];
echo "<table id=\"wpfid-table\" width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
echo "<tr><td align=\"center\">
<form id=\"wpfid-form\" method=\"post\" action=\"".plugins_url('wpfid.php',__FILE__)."\">
<input name=\"new_name\" type=\"hidden\" value=\"$new_name\" />
 <input name=\"wpfid_pic_url\" type=\"hidden\" value=\"$filelink\" />
 <input id=\"wp_fid_button\" class=\"wpfid_button\" type=\"submit\" title=\"". $btn_text."\" value=\"".$btn_text."\" />
 </form></td></tr>";
echo "</table>";
echo "<style type=\"text/css\">table#wpfid-table input#wp_fid_button{background: none repeat scroll 0% 0%  $btn_color;}table#wpfid-table input#wp_fid_button:hover {background: $btn_color;}</style>";
}
};
	

	if(isset($_POST['wpfid_pic_url']) && !empty($_POST['wpfid_pic_url'])){
//get filedata
$file_url = esc_url_raw(stripslashes(trim($_POST['wpfid_pic_url'])));
$file_new_name =  sanitize_file_name($_POST['new_name']);

//get filename
$file_name = basename($file_url );

//get fileextension
$file_extension = pathinfo($file_name);


//security check
$fileName = strtolower($file_url);
$whitelist = array('png', 'gif', 'tiff', 'jpeg', 'jpg','bmp','svg');
if(!in_array(end(explode('.', $fileName)), $whitelist))
{
	exit('Invalid file! or No image file found!');
}
if(strpos( $file_url , '.php' ) == true)
{
	header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
    #die( header( 'location: /error.php' ) );
	die("Invalid file!");
}

//check if file exist
if(file_exists( $file_url  ) == false){
	#exit("File Not Found!");
}

//rename                                                              //since 1.4
if(isset($file_new_name) and !empty($file_new_name))  {
	$file_new_name = $file_new_name.".".$file_extension['extension'];
} else{
	$file_new_name = $file_name;
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

}

?>
