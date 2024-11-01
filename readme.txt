=== WP-Force Images Download === 
Donate link:https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=TNFBA9JHH6854&lc=US&item_name=Nazakat%20Ali&currency_code=USD&bn=PP%2dDonationsBF%3alogo11w%2epng%3aNonHosted
Tags: image, pictures, download, force, browser force, free, pictures, featured image, post thumbnail,featured image,download images,force download,download link,generate,button,shortcode button, shortcode force download, download button, featured imgae download, templatetag force download, pictures download button, rename images on download, on-the fly rename, pictures download button, force images download, generate download button
Requires at least: 3.0
Tested up to: 5.9.2
Stable tag: 1.8
Version : 1.8
License: GPLv2

A simple plugin that force the download of images or pictures such as jpeg,png etc.

== Description ==
This is a simple plugin that allows you to force the download of images or pictures such as jpeg, png, etc.
This plugin is very useful to those who want to download post attachments or featured images. Just put the template tag in single.php and this plugin automatically generates the download link for every post.

**Note:** The post must have a featured image because this plugin generates a download link of the attached featured image of every post, if the post(s) have not featured image the download button would not appear.
*By using shortcode you can set your “custom image link” for each button. You can use multiple shorcodes on single page/post.* 


= NEW FEATURES ADDED =
 1. Now **custom CSS class** can be added in shortcode for each button. Example
* `[wpfid class="myclass"]`
This class can be used to give customized look for each button. To add your custom CSS code
Goto `settings >> Wp-Force Images Download` page and add your CSS code here and save settings.

 2. Renaming Image file on download when using **template tag**
Now you  can rename iamge file when it is downloaded using template tag.
Note there are three parameters for **template tag**
* First one to change **TEXT** that would appear on download button. By Default its `Download`
* Second parameter to change **color scheme**
* Third parameter is to **change name of image** on download.
**How to use it: See example below**
* Example(s):
  * `<?php wp_fid("Some Text","green","NEW FILE NANME");?>`
  * `<?php wp_fid("Some Text","green",get_the_title());?>`
  * `<?php wp_fid("Some Text","green",current_time('timestamp'));?>`
  * `<?php wp_fid("Some Text","green",get_the_title().current_time('timestamp'));?>`
  
**Need Any Help? Post your Question**


Now you can rename images when downloaded.There two ways to rename.

= 1. Using Shortcode =
* `[wpfid new_name="new-name-of-file"]`
* You can use variables also like this
  * `[wpfid new_name="%post_id%"]` 
  * `[wpfid new_name="%filename%_%rand%"]` , etc.
= Note : = You have to specify name only **without file extension**.

* Have Any Question? Let me know__post your question on support page.

= 2. Bulk Rename Images =
Goto **`settings >> Wp-Force Images Download`** page and set your desired combination to rename images. e.g. `%filename%-%rand%`

* Default value:`none`
* Note: These variables will be replaced with their corresponding values.You can use any  combination.e.g. `%site_name%_%filename%-%post_id%`.
* This option will not rename original files. If you set new name in shortcode for individual images, the name in shortcode will be preferred.
* `%site_name%:` Replaced with the site title. `Goto Settings >> General >> [Site Title]` to change this value.
* `%post_title%:` Replaced with the current **post title**
* `%timestamp%:` Replaced with the current time in **unix timestamp format**
* `%post_id%:` Replaced with the current **post id**
* `%rand%:` Replaced with the 5-digit random number between **0 to 100000 e.g. 82469**
* `%md5%:` Replaced with the **md5 hash** of orginal filename
* `%filename%:` Replaced with the **orginal filename**

= Now you can set your own custom download link in shortcode. = e.g.
`[wpfid link="http://link-to/your/image.jpg"]`

= HOW TO USE THIS PLUGIN: =
 * This plugin can be used in two ways:
   1. by using template tag 
   2. by using shortcode

= 1). By Using Template Tag =
You have to put the template tag in your single.php file of your theme, where you want to appear the download button.
= There are three ways to use template tag =

1. `<?php wp_fid();?>` This is simple form with default settings.
2. `<?php wp_fid("Some Text");?>` This will allow you to set **custom text** to appear on download button. Default is *Download*
3. `<?php wp_fid("Some Text","green");?>` This will allow you to set **custom text** along with **custom color `(e.g. pink,green,yellow,purple,#ffcc66,#cccccc,#f80, rgb(255,56,35) etc)`**. Default color is `grey`
4. `<?php wp_fid("Some Text","green","NEW FILE NANME");?>` This will allow you to set **custom text**,**custom color**, **new name of image when downloaded**.
   * More Examples:
     * `<?php wp_fid("Some Text","green","NEW FILE NANME");?>`
     * `<?php wp_fid("Some Text","green",get_the_title());?>`
     * `<?php wp_fid("Some Text","green",current_time('timestamp'));?>`
     * `<?php wp_fid("Some Text","green",get_the_title().current_time('timestamp'));?>`

* Second function allows you to set custom text for download button.e.g.
 `<?php wp_fid("Image Download");?>`
* The default **title text** is **Download** and *default color* is `grey`.

* **Note:If Featured Image is not set for post the download button would not appear on page.**

= 2). By Using Shortcode =
You have to put shortcode in the post content or page, while writing post.<br>
There are five ways to use SHORTCODE.

1. `[wpfid]` This is simple form with default settings.
2. `[wpfid title="some text"]` This will allow you to set custom text to appear on download button. Default is "Download"
3. `[wpfid title="some text" color="green"]` This will allow you to set custom text along with custom color. Default color is "grey"
4. `[wpfid title="some text" color="green" link="http://link-to/your/image.jpg"]` This will allow you to set *custom text*, *custom color* and **custom download link**. 
    By Default *download button* will download **Featured image of the Post or Page** where you have added shortcode , if you have set featured image.
5. `[wpfid title="some text" color="green" link="http://link-to/your/image.jpg" class="my_custom_class"]` This will allow you to set *custom text*, *custom color*, **custom download link** and **custom CSS class**.
    This class can be used to give customized look for each button. To add your custom CSS code
    Goto `settings >> Wp-Force Images Download` page and add your **custom CSS code** here and save settings.

== Installation ==

Upload the **WP-Force Images Download** plugin to your blog, Activate it, and you're done!

You have to put this code in theme file.

`<?php wp_fid();?>`

or use shortcode.

`[wpfid]`
== Frequently Asked Questions == 
No questions yet
== FAQ ==
You can Set Custom Color in three ways:

* You can use **color names** e.g. `(pink,green,yellow,purple, etc)`
* You can use **HEX color codes** e.g. `(#33ff66, #666666, #ff7700, etc)`
* You can use **RGB color codes** e.g. `( rgb(255, 255, 255),rgb(24, 45, 68), etc)`
* *Feel Free To Ask Questions*
== Screenshots ==
1. Buttons in different colors

2. New button styles

== Changelog ==

= 1.8 =

  * [HOW TO] : Added more detailed and clear documentation for each function
  *	**Issues fixed ✔✔:**
	* double download button 
	* button apearing at top of page
	* improved code
	* fast loading
  * Bugs Fixed
  * Security enhanced
  * Thoroughly Tested up to wordpress v5.9.2

= 1.7 =

  * [HOW TO] : Added more detailed and clear documentation for each function
  * New Features Added
  * [NEW] Now custom CSS class can be added in shortcode for each button. Example `[wpfid color="green" class="mybutton"]`
  * [NEW] Template Tag suppport to rename images. [See Plugin page for complete documentation]
  * Errors Fixed
  * [FIXED] Issue:Zero bytes of downloaded files 
  * [FIXED] Issue:Template tag `<?php wp_fid();?>` not downloading picture
* Tested up to wordpress v5.2.1

= 1.6 =

* RFI issue fixed
* security enhanced
* custom css code can be added to give customized look to button
* tested with wp 4.8.3

= 1.5 =

* bulk rename
  * added new variables `%rand%,%md5%,%filename%`
  * now you can use more than one variables
  * now you can use also these variables in shortcode .e.g `[wpfid new_name="%post_id%_%filename%"]`
* button themeing and styles
  * new button style with 8 different color schemes
  * added option to show file size on download button
  * added option to show file size on download-icon on button
  * added option to easily customize appearence of button
* security increased
* performance increased i.e. code is shortend to increase speed
* added more clear documentation for every function

= 1.4 =

* shortcode suppport to rename images individually
* option to set bulk new name for images in options page
* added options page in admin

= 1.3.1 =

* minor enhancements in code

= 1.3 = 

* added more image types i.e mime-types
* security increased
* Tested with wp v4.2.2

= 1.2.1 =
* enhancement in code

= 1.2 =

* added support for custom link in shortcode
* more enhancements

= 1.1.1 =

* little issues resolved
* styling issues resolved

= 1.1.0 =

* styling and colors
* shortcode support

= 1.0.0 =

* basic release

