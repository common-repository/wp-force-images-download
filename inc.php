<?php
defined('ABSPATH') or die("No script kiddies please...!");
/* register menu item */
function wp_force_images_download_admin_menu_setup(){
add_submenu_page(
 'options-general.php', //parent_slug
 'WP-Force Images Download:Settings',//page_title
 'WP-Force Images Download',//menu_title
 'manage_options',//capability
 'wp-force-images-download',//slug
 'wp_force_images_download'//function to use
 );
}
add_action('admin_menu', 'wp_force_images_download_admin_menu_setup'); //menu setup

/* display page content */
function wp_force_images_download() {
 global $submenu;
// access page settings 
 $page_data = array();
 foreach($submenu['options-general.php'] as $i => $menu_item) {
 if($submenu['options-general.php'][$i][2] == 'wp-force-images-download')
 $page_data = $submenu['options-general.php'][$i];
 }

// output 
?>
<div class="wrap">
<?php screen_icon();?>
<h2><?php echo $page_data[3];?></h2>
<form id="wp_force_images_download_options" action="options.php" method="post">
<?php
//
wp_nonce_field('wpfid_data','wpfid_nonce_field'); 
if(isset($_POST['wp_force_images_download_options[wpfid_single]'])) { 
    if ( !empty($_POST['wp_force_images_download_options[wpfid_single]']) && check_admin_referer( 'wpfid_data', 'wpfid_nonce_field' )){
        // you're output
    }else{
        wp_die('Security check fail'); 
    }
}


settings_fields('wp_force_images_download_options');
do_settings_sections('wp-force-images-download'); 
submit_button('Save options', 'primary', 'wp_force_images_download_options_submit');
?>
 </form><hr></hr>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="36%" valign="top">
	<h4>Feel free to ask questions on <a href="https://wordpress.org/support/plugin/wp-force-images-download/" target="_new">support page. 😊</a></h4></td>
    <td valign="top"><h3>Support Me! 🦾</h3>
	<h4>Please make a <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=TNFBA9JHH6854&lc=US&item_name=Nazakat%20Ali&currency_code=USD&bn=PP%2dDonationsBF%3alogo11w%2epng%3aNonHosted" target="_new">donation</a> and/or give it a <a href="https://wordpress.org/support/view/plugin-reviews/wp-force-images-download/" target="_new">5-star rating.</a><br/>

Your generous support encourages me to continue developing free plugins and other wordpress resources for free. Thanks! </h4></td>
 <tr><td></td><td></td></tr>
 </tr>
</table>
</div>
<?php
}
/* settings link in plugin management screen */
function wp_force_images_download_link($actions, $file) {
if(false !== strpos($file, 'wp-force-images-download'))
 $actions['settings'] = '<a href="options-general.php?page=wp-force-images-download">Settings</a>';
return $actions; 
}
add_filter('plugin_action_links', 'wp_force_images_download_link', 2, 2);

/* register settings */
function wp_force_images_download_init(){

register_setting(
 'wp_force_images_download_options',
 'wp_force_images_download_options',
 'wp_force_images_download_options_validate'
 );

add_settings_section(
 'wp_force_images_download_fields_group',
 'How To Use', 
 'wp_force_images_download_desc',
 'wp-force-images-download'
 );
add_settings_field(
    'wpfid_icon',
    'Display download icon on button',
    'wpfid_icon_function',
    'wp-force-images-download',
    'wp_force_images_download_fields_group'
 );add_settings_field(
    'wpfid_size',
    'Display filesize on button',
    'wpfid_size_function',
    'wp-force-images-download',
    'wp_force_images_download_fields_group'
 );add_settings_field(
    'wpfid_button_styles',
    'Choose Button Style',
    'wpfid_button_styles_callback',
    'wp-force-images-download',
    'wp_force_images_download_fields_group'
 );add_settings_field(
    'wpfid_css',
    'Custom CSS code for button',
    'wpfid_custom_css_callback',
    'wp-force-images-download',
    'wp_force_images_download_fields_group'
 );
add_settings_field(
 'wp_force_images_download_single',
 'Bulk Rename Images:', 
 'wp_force_images_download_field_single',
 'wp-force-images-download',
 'wp_force_images_download_fields_group'
 );
}

add_action('admin_init', 'wp_force_images_download_init');

/* validate input */
function wp_force_images_download_options_validate($input){
if(isset($input))
return $input;
}

/* description text */
function wp_force_images_download_desc(){
echo "<h4>For complete documentation visit plugin site. <a target=\"_new\" href=\"https://wordpress.org/plugins/wp-force-images-download/\">click here</a> or you can contact on <a href=\"https://wordpress.org/support/plugin/wp-force-images-download/\" target=\"_new\">support page</a>, Thanks. 😊</h4><hr></hr>";
}

/* filed output */
function wp_force_images_download_field_single() {
 $options = get_option('wp_force_images_download_options');
 $wpfidsingle = (isset($options['wpfid_single'])) ? $options['wpfid_single'] : '';
 $wpfidsingle = esc_textarea($wpfidsingle); //sanitise output
?>
 <input id="wpfid_single" name="wp_force_images_download_options[wpfid_single]" class="large-text code"
 value="<?php echo $wpfidsingle;?>"/>
Default value: <code>none</code><br/>

 <p><b style="color:maroon;font-weight:800;">Note:</b> These variables are replaced with their corresponding values.You can use any combination.e.g.<code>%site_name%_%filename%-%post_id%</code>
This option will not rename original files. </p>
 <ul style="font-size:13px;">
 <li><code>%site_name%</code>:  Replaced with the <i>site title</i>. Goto <code>Settings >> General >> [Site Title]</code> to change this value.</li>
 <li><code>%post_title%</code>:  Replaced with the current <i>post title</i></li>
 <li><code>%timestamp%</code>: Replaced with the current time in <i>unix timestamp format</i> e.g. current time in unix timestamp format is <code><?php echo current_time('timestamp'); ?></code></li>
 <li><code>%post_id%</code>: Replaced with the current <i>post id</i></li>
 <li><code>%rand%</code>: Replaced with the 5-digit <i>random</i> number between <i>0 to 100000</i> e.g. <code><?php echo mt_rand(0,100000); ?></code></li>
 <li><code>%md5%</code>: Replaced with the <i>md5 hash</i> of orginal filename</li>
 <li><code>%filename%</code>: Replaced with the orginal filename</li>
 </ul>
 


<?php
}
/* CSS */
function wpfid_custom_css_callback() {
 $options = get_option('wp_force_images_download_options');
 $wpfidcustomcss = (isset($options['wpfid_custom_css'])) ? $options['wpfid_custom_css'] : '';
 $wpfidcustomcss = esc_textarea($wpfidcustomcss); //sanitise output
?><hr></hr>
<textarea  id="wpfid_custom_css" name="wp_force_images_download_options[wpfid_custom_css]"
 placeholder="Custom CSS Code" cols="45" rows="5"><?php echo $wpfidcustomcss;?></textarea><br/>
    <label for="wpfid_custom_css"><code>Note:this will override other options.</code><br/>Add custom css code to customize look of download button.<br>
	<code>class: <b>.wpfid_button</b></code><code>ID: <b>#wpfid_button</b><br/></code></label><br/>
	<b>Example:</b>
	<code>.wpfid_button{
color:#fff;
background-color:maroon;
}</code>
<hr></hr>
<?php
}

//Check Box
function  wpfid_size_function(){
	$options = get_option('wp_force_images_download_options');
	#$size_check_box = (isset($options['size_check_box'])) ? $options['size_check_box'] : '';
     ?>
   <input type="checkbox" id="size_check_box" name="wp_force_images_download_options[size_check_box]" 
   value="1" <?php echo checked( 1, (isset($options['size_check_box'])), false ) ?>/>
   <label for="size_check_box">Check this box to show <b><i>filesize</i></b> of image on download button.</label><br/>
   <hr></hr>
<?php
}

//Check Box 2
function  wpfid_icon_function(){
	$options = get_option('wp_force_images_download_options');?>
   <input type="checkbox" id="icon_check_box" name="wp_force_images_download_options[icon_check_box]" 
   value="1" <?php echo checked( 1, (isset($options['icon_check_box'])), false ) ?>/>
   <label for="icon_check_box">Check this box to show <b><i>download-icon</i></b> on button.</label><hr></hr><br/>
     
<?php }
//Button Styles
function  wpfid_button_styles_callback(){
	$options = get_option('wp_force_images_download_options');?>
   <input type="radio" id="button_style_1" name="wp_force_images_download_options[button_styles]" 
   value="1" 
   <?php  
		$options['button_styles'] ??= 'default value';
		 $options['button_styles'];
		checked( 1, ($options['button_styles']), true ); ?>
   />
   <label for="button_style_1">Show Only Text</label><br/><br/>
   <input type="radio" id="button_style_2" name="wp_force_images_download_options[button_styles]" 
   value="2" <?php   checked( 2, ($options['button_styles']), true ); ?>/>
   <label for="button_style_2">Classical Style</label><img width="6%" align="right"src="<?php echo plugins_url('img/orig.png',__FILE__)?>"/><br/><br/>
   <input type="radio" id="button_style_3" name="wp_force_images_download_options[button_styles]" 
   value="3" <?php   checked( 3, ($options['button_styles']), true );?>/>
   <label for="button_style_3">Latest style. click to see more <a title="More Examples" href="https://wordpress.org/plugins/wp-force-images-download/screenshots/">examples</a></label><img width="30%" align="right"src="<?php echo plugins_url('img/new_style.png',__FILE__)?>"/>
   <br/><br/><b>Classical Style:</b> With this button style you can set any color in any format i.e. you can use <ol><li><b>Hex color code e.g. <code>#00ff00, #ff7700, #008000, etc</code> <br/>Example: <code>[wpfid color="green"]</code></b></br><br/> </li><li><b>RGB color code <code>rgb(0, 128, 128), rgb(0, 255, 255), rgb(0, 128, 0), etc</code><br/> Example: <code>[wpfid color="rgb(0, 128, 128)"]</code></b> <br/> <br/> </li><li><b> Color names e.g. <code>Aqua, Teal, Emrald, etc</code><br/> Example: <code>[wpfid color="Teal"]</code></b></li></ol> 
   <br/><b>Latest Style:</b> This button style has only <b><i>8 colour schemes</i></b> i.e <code>green, red, blue, orange, pink, gray, darkblue, purple</code>. You can use one of them in shortcode .e.g <code>[wpfid color="green"]</code>. Default color is <code>gray</code>
<?php }
function wpfid_values(){
	$wpfid_options = get_option( 'wp_force_images_download_options');
	$single_author = trim($wpfid_options['wpfid_single']);
	$singular_author = trim($wpfid_options['wpfid_singular']);
}

#add_action('wp_head', 'wpfid_values');

//Notice
add_action('admin_notices', 'wpfid_admin_notice');
function wpfid_admin_notice() {
if ( current_user_can( 'install_plugins' ) )
   {
     global $current_user ;
        $user_id = $current_user->ID; 
		//Check that the user hasn't already clicked to ignore the message 
     if ( ! get_user_meta($user_id, 'wpfid_ignore_notice') ) {
        echo '<div class="updated"><p>';
        printf(__('Go to settings page to configure the <b><a href="options-general.php?page=wp-force-images-download">WP-Force Images Download</a>, Thanks</b> | <a href="%1$s">[Hide Notice]</a>'), 'options-general.php?page=wp-force-images-download&wpfid_nag_ignore=0');
        echo "</p></div>";
     }
    }
}

add_action('admin_init', 'wpfid_nag_ignore');

function wpfid_nag_ignore() {
     global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['wpfid_nag_ignore']) && '0' == $_GET['wpfid_nag_ignore'] ) {
             add_user_meta($user_id, 'wpfid_ignore_notice', 'true', true);
     }
}


?>
