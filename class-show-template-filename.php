<?php
/**
 * Show Current Template
 *
 * @package     Show_Current_Template
 * @author      JOTAKI Taisuke + Ben Rothman
 * @copyright   2022 JOTAKI Taisuke
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Show Current Template
 * Plugin URI: https://wp.tekapo.com/
 * Description: Show the current template file name in the tool bar. <a href="https://wp.tekapo.com/is-my-plugin-useful/">Is this useful for you?</a>
 * Author: JOTAKI Taisuke + Ben Rothman
 * Version: 0.5.0
 * Author URI: https://tekapo.com/
 * Text Domain: show-current-template
 * Domain Path: /languages/
 * License: Released under the GPL license
 * */

define( 'WPSCT_VERSION', '0.5.0' );

load_plugin_textdomain( 'show-current-template', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


	/**
	 * Class to instantiate the plugin as an object
	 *
	 * @since 0.5.0
	 */
class Show_Template_Filename {

	/**
	 * Constructor: run the code that is the plugin
	 *
	 * @since 0.5.0
	 */
	public function __construct() {

		add_action( 'admin_bar_menu', array( $this, 'wpsct_show_template_filename_on_top' ), 9999 );
		add_action( 'wp_footer', array( $this, 'wpsct_get_included_files_at_footer' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'wpsct_add_current_template_stylesheet' ), 9999 );
		add_action( 'wp_enqueue_scripts', array( $this, 'wpsct_add_current_template_js' ), 9999 );

	}

	/**
	 * Build and add the new menu to the admin bar
	 *
	 * @param {object} $wp_admin_bar global variable to refer to the universal admin bar.
	 *
	 * @since 0.5.0
	 */
	public function wpsct_show_template_filename_on_top( $wp_admin_bar ) {

		if ( is_admin() || ! is_super_admin() ) {
			return;
		}

		global $template;

		$template_file_name     = basename( $template );
		$template_relative_path = str_replace( ABSPATH . 'wp-content/', '', $template );

		$current_theme      = wp_get_theme();
		$current_theme_name = $current_theme->name;
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

		$included_files_list = '';
		foreach ( $included_files as $filename ) {
			if ( strstr( $filename, 'themes' ) ) {
				$filepath = strstr( $filename, 'themes' );
				if ( $template_relative_path === $filepath ) {
					$included_files_list .= '';
				} else {
					$included_files_list .= '<li>' . $filepath . '</li>';
				}
			}
		}

		global $wp_admin_bar;
		$args = array(
			'id'    => 'show_template_filename_on_top',
			'title' => __( 'Template:', 'show-current-template' )
			. '<span class="show-template-name"> ' . $template_file_name . '</span>',
		);

		$wp_admin_bar->add_node( $args );

		$wp_admin_bar->add_menu(
			array(
				'parent' => 'show_template_filename_on_top',
				'id'     => 'template_relative_path',
				'title'  => __( 'Template relative path:', 'show-current-template' )
				. '<span class="show-template-name"> ' . $template_relative_path . '</span>',
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'parent' => 'show_template_filename_on_top',
				'id'     => 'is_child_theme',
				'title'  => $parent_or_child,
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'parent' => 'show_template_filename_on_top',
				'id'     => 'included_files_path',
				'title'  => __( 'Also, below template files are included:', 'show-current-template' )
				. '<br /><ul id="included-files-list">'
				. $included_files_list
				. '</ul>',
			)
		);
	}

	/**
	 * Get any files included in the footer
	 *
	 * @since 0.5.0
	 */
	public function wpsct_get_included_files_at_footer() {

		if ( is_admin() || ! is_super_admin() ) {
			return;
		}

		$enqueued       = $this->wpsct_print_scripts_styles();
		$included_files = array_merge( get_included_files(), $enqueued );
		global $template;

		$template_relative_path = str_replace( ABSPATH . 'wp-content/', '', $template );

		sort( $included_files );

		$included_files_list = '';
		foreach ( $included_files as $filename ) {

			if ( strstr( $filename, 'themes' . DIRECTORY_SEPARATOR ) ) {
				$filepath = strstr( $filename, 'themes' );

				if ( $template_relative_path === $filepath ) {
					$included_files_list .= '';
				} else {
					if ( strstr( $filepath, '.css' ) ) {
						$included_files_list .= '<li style="color: green;">CSS: ' . $filepath . '</li>';
					} elseif ( strstr( $filepath, '.js' ) ) {
						$included_files_list .= '<li style="color: orange;">JS: ' . $filepath . '</li>';
					} elseif ( strstr( $filepath, '.php' ) ) {
						$included_files_list .= '<li style="color: red;">PHP: ' . $filepath . '</li>';
					} else {
						$included_files_list .= '<li>' . $filepath . '</li>';
					}
				}
			}
		}
		$included_files_format = '<ol id="included-files-fie-on-wp-footer">'
				. '%s'
				. '</ol>';
		$included_files_html   = sprintf( $included_files_format, $included_files_list );

		echo wp_kses_post( $included_files_html );
	}

	/**
	 * Register and enqueue stylesheets for this plugin
	 *
	 * @since 0.5.0
	 */
	public function wpsct_add_current_template_stylesheet() {

		if ( is_admin() || ! is_super_admin() ) {
			return;
		}

		$wp_version = get_bloginfo( 'version' );

		if ( $wp_version >= '3.8' ) {
			$is_older_than_3_8 = '';
		} else {
			$is_older_than_3_8 = '-old';
		}

		$stylesheet_path = plugins_url( 'css/style' . $is_older_than_3_8 . '.css', __FILE__ );
		wp_register_style( 'current-template-style', $stylesheet_path, array(), WPSCT_VERSION );
		wp_enqueue_style( 'current-template-style' );
	}

	/**
	 * Register and enqueue scripts for this plugin
	 *
	 * @since 0.5.0
	 */
	public function wpsct_add_current_template_js() {

		if ( is_admin() || ! is_super_admin() || ! is_admin_bar_showing() ) {
			return;
		}

		$wp_version = get_bloginfo( 'version' );

		if ( $wp_version >= '5.4' ) {
			$js_path = plugins_url( 'assets/js/replace.js', __FILE__ );
			wp_register_script( 'current-template-js', $js_path, array( 'jquery' ), WPSCT_VERSION, true );
			wp_enqueue_script( 'current-template-js' );
		} else {
			return;
		}
	}

	/**
	 * Get all of the enqueued scripts and stylesheets being used on the current page
	 *
	 * @since 0.5.0j
	 */
	public function wpsct_print_scripts_styles() {

		$result = array();

		// Get all loaded Scripts (js).
		global $wp_scripts;
		foreach ( $wp_scripts->queue as $script ) {
			if ( $wp_scripts->registered[ $script ]->src ) {
				array_push( $result, $wp_scripts->registered[ $script ]->src );
			}
		}
		// Get all loaded Styles (css).
		global $wp_styles;
		foreach ( $wp_styles->queue as $style ) {
			if ( $wp_styles->registered[ $style ]->src ) {
				array_push( $result, $wp_styles->registered[ $style ]->src );
			}
		}

		return $result;
	}


}

$obj = new Show_Template_Filename();
