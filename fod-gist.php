<?php
/*
Plugin Name:    Gist Shortcode
Plugin URI:     http://www.fullondesign.co.uk/
Description:    Provides Gist embed shortcodes. Usage: <code>[gist id="1751763"]</code>
Version:        1.1.0
Author:         Mike Rogers
Author URI:    	http://www.fullondesign.co.uk/
Text Domain:    fod_gist

Copyright 2012 Mike Rogers

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
*/

// Prevents loading file directly
if (!class_exists('WP')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    die();
}

// Set up localisation
$locale = get_locale();
if (empty($locale)) $locale = 'en_US';
load_theme_textdomain('fod_gist', dirname (__FILE__).'/locale/'.$locale.'.mo');

// Plugin version
define('FOD_GIST_VERSION', '1.1.0');

function fod_gist_embed($file){
	$return = '<noscript><pre>';
	$return .= htmlentities($file->content);
	$return .= '</pre>
	'.$file->filename.'
	</noscript>';
	
	return $return;
}

function fod_gist_func($atts){
	// Get the variables passed.
	extract(shortcode_atts(array('id' => '1751763', 'file' => null), $atts ));
	
	$return = get_transient('gist-'.$id.'-'.$file);
	if($return){
		return $return;
	}
	
	$gistResponse = wp_remote_get( 'https://api.github.com/gists/'.$id);
	$gistResponse = json_decode($gistResponse['body']);
	
	if($file != null){
		$return = fod_gist_embed($gistResponse->files->$file).'<script src="https://gist.github.com/'.$id.'.js?file='.$file.'"> </script>';
		set_transient( 'gist-'.$id.'-'.$file, $return, 25200 );
		return $return;
	}
	
	$content = '';
	foreach($gistResponse->files as $_file){
		$content .= fod_gist_embed($_file);
	}
	
	$return = $content.'<script src="https://gist.github.com/'.$id.'.js"> </script>';
	
	set_transient( 'gist-'.$id.'-'.$file, $return, 25200 );
	return $return;
}
add_shortcode('gist', 'fod_gist_func');
?>