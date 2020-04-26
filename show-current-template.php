<?php
/**
Plugin Name: Show Current Template
Plugin URI: https://wp.tekapo.com/
Description: Show the current template file name in the tool bar. <a href="hhttps://wp.tekapo.com/is-my-plugin-useful/">Is this useful for you?</a>
Author: JOTAKI Taisuke
Version: 2.0.0-a
Author URI: https://tekapo.com/
Text Domain: show-current-template
Domain Path: /languages/

License:
Released under the GPL license
http://www.gnu.org/copyleft/gpl.html

Copyright 2013 (email : tekapo@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
**/

// TODO:
// show current template 表示部に
//header.phpを表示させる
// footer.phpを表示させる


define( 'SCT_DEBUG_MODE', true );
// define( 'SCT_DEBUG_MODE', false );

//load_template();


load_plugin_textdomain( 'show-current-template', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

new Show_Template_File_Name();

class Show_Template_File_Name {

	public function __construct() {
		$this->run_add_actions();
		$this->run_add_filters();
	}

	public function run_add_actions() {

		// if (!SCT_DEBUG_MODE) {
		// if (is_admin() or!is_super_admin()) {
		// return;
		// }
		// }

		add_action( 'admin_bar_menu', array( &$this, 'show_template_file_name_on_top' ), 9999 );
		add_action( 'wp_enqueue_scripts', array( &$this, 'add_current_template_stylesheet' ), 9999 );
		add_action( 'wp_enqueue_scripts', array( &$this, "add_current_template_js" ), 9999 );
		 
		add_action( 'wp_head', array( $this, 'fire_on_header' ), 10, 3 );
		add_action( 'wp_footer', array( $this, 'fire_on_footer' ), 10, 3 );
		add_action( 'get_sidebar', array( $this, 'fire_on_sidebar' ), 10, 3 );
		add_action( 'get_template_part', array( $this, 'action_get_template_part' ), 10, 3 );
	}

	public function run_add_filters() {
		if ( SCT_DEBUG_MODE ) {
			add_filter( 'show_admin_bar', '__return_true', 1000 );
		}
	}

	public function action_get_template_part() {
		$t = debug_backtrace( false );
		// var_dump($t);
		$template_name = $t[0]['args'][2][0];
		$str_format = '<div class="on-hover-pop">%s</div>';
		$template_name_in_html_tag = sprintf($str_format, $template_name);
		echo $template_name_in_html_tag;
		return $template_name;
	}

	public function fire_on_header() {
		$t = debug_backtrace( false );
//		var_dump($t);
//		echo 'sct::' . $t[7]['args'][0][0];
		$header_file_name = $t[7]['args'][0][0];
		$str_format = '<div class="on-hover-pop">%s</div>';
		$template_name_in_html_tag = sprintf($str_format, $header_file_name);
		echo $template_name_in_html_tag;
		return $header_file_name;
	}
	
	public function get_header_file() {
		$t = debug_backtrace( false );
		// var_dump($t);

		$n = array_column( $t, 'function' );
		// var_dump($n);
		$array_num = array_search( 'locate_template', $n );

		$header_file_name = $t[ $array_num ]['args'][0][0];

		return $header_file_name;

	}
	
	public function fire_on_footer() {
		$t = debug_backtrace( false );
		$footer_file_name = $t[7]['args'][0][0];
//		echo 'sct::' . $t[7]['args'][0][0];
		return $footer_file_name;
	}

	public function fire_on_sidebar( $name ) {

//		var_dump( $name );

		echo 'siiiidebaaaar::' . $name;
		$t = debug_backtrace( false );
//		var_dump( $t );
	}

	public function show_template_file_name_on_top( $wp_admin_bar ) {

		if ( SCT_DEBUG_MODE ) {
			if ( is_admin() ) {
				return;
			}
		} elseif ( ! SCT_DEBUG_MODE ) {
			if ( is_admin() or ! is_super_admin() ) {
				return;
			}
		}

		global $template;

		// var_dump($template);

		$template_file_name     = basename( $template );
		$template_relative_path = str_replace( ABSPATH . 'wp-content/', '', $template );

		$current_theme      = wp_get_theme();
		$current_theme_name = $current_theme->Name;
		$parent_theme_name  = '';

		if ( is_child_theme() ) {
			$child_theme_name  = __( 'Theme name: ', 'show-current-template' )
					. $current_theme_name;
			$parent_theme_name = $current_theme->parent()->Name;
			$parent_theme_name = ' (' . $parent_theme_name
					. __( "'s child", 'show-current-template' ) . ')';
			$parent_or_child   = $child_theme_name . $parent_theme_name;
		} else {
			$parent_or_child = __( 'Theme name: ', 'show-current-template' )
					. $current_theme_name . ' (' . __( 'NOT a child theme', 'show-current-template' ) . ')';
		}

		$included_files = get_included_files();

		sort( $included_files );
		// var_dump($included_files);

		$included_files_list = '';
		
//		$included_files_list .= $this->fire_on_header();
//		$included_files_list .= $this->fire_on_footer();
//		$aaaaa = $this->action_get_template_part();
//		var_dump($aaaaa);
		
//		var_dump($included_files_list);
		
		$header_file = $this->get_header_file();
		
		$included_files_list = '<li>' . "$header_file" . '</li>';
		
				
		foreach ( $included_files as $filename ) {
			if ( strstr( $filename, 'themes' ) ) {
				$filepath = strstr( $filename, 'themes' );
				if ( $template_relative_path == $filepath ) {
					$included_files_list .= '';
				} else {
					$included_files_list .= '<li>' . "$filepath" . '</li>';
				}
			}
		}

		global $wp_admin_bar;
		$args = array(
			'id'    => 'show_template_file_name_on_top',
			'title' => __( 'Template:', 'show-current-template' )
			. '<span class="show-template-name"> ' . $template_file_name . '</span>',
		);

		$wp_admin_bar->add_node( $args );

		$wp_admin_bar->add_menu(
			array(
				'parent' => 'show_template_file_name_on_top',
				'id'     => 'template_relative_path',
				'title'  => __( 'Template relative path:', 'show-current-template' )
				. '<span class="show-template-name"> ' . $template_relative_path . '</span>',
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'parent' => 'show_template_file_name_on_top',
				'id'     => 'is_child_theme',
				'title'  => $parent_or_child,
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'parent' => 'show_template_file_name_on_top',
				'id'     => 'included_files_path',
				'title'  => __( 'Also, below template files are included:', 'show-current-template' )
				. '<br /><ul id="included-files-list">'
				. $included_files_list
				. '</ul>',
			)
		);
	}

	public function add_current_template_stylesheet() {

		if ( ! SCT_DEBUG_MODE ) {
			if ( is_admin() or ! is_super_admin() ) {
				return;
			}
		}

		$wp_version = get_bloginfo( 'version' );

		if ( $wp_version >= '3.8' ) {
			$is_older_than_3_8 = '';
		} else {
			$is_older_than_3_8 = '-old';
		}

		$stylesheet_path = plugins_url( 'css/style' . $is_older_than_3_8 . '.css', __FILE__ );
		wp_register_style( 'current-template-style', $stylesheet_path );
		wp_enqueue_style( 'current-template-style' );
	}

	public function add_current_template_js() {
		if ( ! SCT_DEBUG_MODE ) {
			if ( is_admin() or ! is_super_admin() ) {
				return;
			}
		}

		$js_path = plugins_url( 'js/greeter.js', __FILE__ );
		wp_register_script( 'current-template-js', $js_path, '', 1, true );
		wp_enqueue_script( 'current-template-js' );
	}

}

// function get_functions_in_file( $file, $sort = FALSE ) {
// $file = file( $file );
// var_dump($file);
// $functions = array();
//
// foreach ( $file as $line ) {
//
// $findme = 'get_template_part';
//
// if ( $aaaa = strpos( $line, $findme ) ) {
// var_dump( $aaaa );
// $line = trim( $line );
//
// preg_match( '/get_template_part\((.*)\)/', $line, $matches );
// print_r( $matches );
//
// $functions[] = $line;
// }
// }
//
// if ( $sort ) {
// asort( $functions );
// $functions = array_values( $functions );
// }
//
// return $functions;
// }

$template = 'wp-content/themes/twentytwenty/singular.php';

// $fff = get_functions_in_file( $template );
// var_dump( $fff );

function a_test( $str ) {
	// echo "\nHi: $str";
	// var_dump(debug_backtrace());
	foreach ( debug_backtrace() as $t ) {
		echo ' calls ' . $t['function'] . '()<br/>';
	}
}
