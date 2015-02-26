<?php
/*
    Plugin Name: Simple Open Graph
    Plugin URI: http://analteredreality.com/opengraph
    Description: Plugin displays simple open graph data
    Author: K. Bowers
    Version: 2.3
    Author URI: http://analteredreality.com
    License: GPL2

	Copyright 2011  Kevin Bowers  (email : pcfrk256@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

/*Include the Options Page*/
include('simpleopengraph_options.php');
?>
<?php
/*Add Site_Name from bloginfo*/
function sitename(){
	$site_name = get_bloginfo('name');
	echo '<meta property="og:site_name" content="'.$site_name.'"/>'.PHP_EOL;
}
/*Add og:title element */
function ogtitle(){
	if (is_home())
		echo '<meta property="og:title" content="'.get_bloginfo('name').'"/>'.PHP_EOL;
	elseif (is_singular())
		echo'<meta property="og:title" content="'.get_the_title().'"/>'.PHP_EOL;
}
/*Add og:type element */
function ogtype(){
	if (is_home())
		$ogtype="website";
	elseif (is_singular())
		$ogtype = "article";
	echo '<meta property="og:type" content="'.$ogtype.'"/>'.PHP_EOL;
}
/*Add og:url element*/
function ogurl(){
	if (is_home())
		$url = home_url();
	elseif (is_singular())
		$url = get_permalink();
	echo '<meta property="og:url" content="'.$url.'"/>'.PHP_EOL;
}
/*Add fb:admins*/
function fbadmins(){
	global $options;
	$options = get_option('fbadmin');
	$fbadmins = $options['fbadmins'];
	if (empty($fbadmins))
		echo "";
	else
		echo '<meta property="fb:admins" content="'.$fbadmins.'"/>'.PHP_EOL;
}
/*Add fb:pageid*/
function pageid(){
	global $options;
	$options = get_option('fbpageid');
	$fbpage = $options['fbpageid'];
	if (empty($fbpage))
		echo "";
	else
		echo '<meta property="fb:page_id" content="'.$fbpage.'"/>'.PHP_EOL;
}
/*Add FB App ID*/
function fbappid(){
	global $options;
	$options = get_option('fbappid');
	$fbapp = $options['fbapp'];
	if (empty($fbapp))
		echo "";
	else
		echo '<meta property="fb:app_id" content="'.$fbapp.'"/>'.PHP_EOL;
}
/*Add Image*/
function ogimage(){
	global $post;
	$fallback = get_option('fbimage');
	$fbimage = $fallback['fallbackimage'];
	if (is_singular() && empty($image) && has_post_thumbnail($post->ID)){
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail');
		if ($thumbnail) {
			$image = $thumbnail[0];
		}}
	if (empty($fbimage) && empty($image))
		echo "";
	elseif (empty($image))
		echo  '<meta property="og:image" content="'.$fbimage.'"/>'.PHP_EOL;
	else
		echo '<meta property="og:image" content="'.$image.'"/>'.PHP_EOL;
	}
/*Add Description */
function ogdescription(){
	$excerpt = get_the_excerpt();
	if (is_single()) $description = strip_tags($excerpt);
	elseif (is_home()) $description = get_bloginfo('description');
	if (empty($description))
		echo "";
	else
		echo '<meta property="og:description" content="'.$description.'"/>'.PHP_EOL;
}
/*Adding the action to the header*/
$functions = array("ogtitle","ogtype","ogurl","ogimage","sitename","fbappid","fbadmins","pageid","ogdescription");
reset($functions);
while (list($key,$val) = each($functions))
{
add_action('wp_head',$val);
}
?>
