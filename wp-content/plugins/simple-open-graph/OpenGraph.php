<?php
/*
    Plugin Name: Simple Open Graph
    Plugin URI: http://ispeakl33t.com/opengraph
    Description: Simple Open Graph adds Open Graph metadata to your blog's head
    Author: Kevin Bowers
    Version: 2.4
    Author URI: http://ispeakl33t.com
    License: GPL2

	Copyright 2011  Kevin Bowers  (email : kevin@ispeakl33t.com)

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
function ogsitename(){
	echo '<meta property="og:site_name" content="'.get_bloginfo('name').'"/>'.PHP_EOL;
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
	global $options;
	$options = get_option('ogtype');
	$ogtype = $options['ogtype'];
	$custom_value = get_post_custom_values( 'og_type' );
	if (is_home() && (!empty($ogtype))) {
		echo '<meta property="og:type" content="'.$ogtype.'"/>'.PHP_EOL;
	} elseif (is_home()) {
		$ogtype="website";
		echo '<meta property="og:type" content="'.$ogtype.'"/>'.PHP_EOL;
	} elseif (is_single() && (!empty($custom_value))) {
		foreach ( $custom_value as $key => $value ) {
			echo '<meta property="og:type" content="'.$value.'" />'.PHP_EOL;
		}
	} elseif (is_single() && (empty($ogtype)) && (empty($custom_value))) {
		echo '<meta property="og:type" content="article"/>'.PHP_EOL;
	} else {
		echo "";
}	
}

/*Add og:url element*/
function ogurl(){
	if (is_home()) {
		$url = home_url();
	} else {
		$url = get_permalink();
	}
	echo '<meta property="og:url" content="'.$url.'"/>'.PHP_EOL;
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
		}
	}
	if (empty($fbimage) && empty($image))
		echo "";
	elseif (empty($image))
		echo  '<meta property="og:image" content="'.$fbimage.'"/>'.PHP_EOL;
	else
		echo '<meta property="og:image" content="'.$image.'"/>'.PHP_EOL;
}

/*Add Description */
function ogdescription(){
	global $options;
	$options = get_option('ogdescription');
	$ogdescription = $options['ogdescription'];
	$custom_value = get_post_custom_values( 'og_description' );
	$excerpt = get_the_excerpt();
	if (is_home() && (empty($ogdescription))) {
		echo '<meta property="og:description" content="'.get_bloginfo('description').'"/>'.PHP_EOL;
	} elseif (is_home() && (!empty($ogdescription))) {
		echo '<meta property="og:description" content="'.$ogdescription.'"/>'.PHP_EOL;
	} elseif (is_single() && (!empty($custom_value))) {
		foreach ( $custom_value as $key => $value ); {
			echo '<meta property="og:description" content="'.$value.'"/>'.PHP_EOL;
		}
	} else {
		echo '<meta property="og:description" content="'.get_the_title().'"/>'.PHP_EOL;
	}
}

/*Add fb:admins*/
function fbadmins(){
	global $options;
	$options = get_option('fbadmin');
	$fbadmins = $options['fbadmins'];
	if (!empty($fbadmins))
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


/*Adding the action to the header*/
$functions = array("ogtitle","ogtype","ogurl","ogimage","ogsitename","fbappid","fbadmins","pageid","ogdescription");
reset($functions);
while (list($key,$val) = each($functions))
{
	add_action('wp_head',$val);
}
?>
