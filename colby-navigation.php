<?php
/**
 * Plugin Name: Colby Navigation
 * Description: Navigation menus for WordPress.
 * Version: 0.1.0
 * Author: Colby Communications
 * Author URI: https://www.colby.edu/communicationsoffice
 * Text Domain: colby-navigation
 *
 * @package colby-navigation
 */

use Colby\Plugins\Colby_Navigation\{Colby_Navigation, Navigation_Menu};
use function Colby\Plugins\Colby_Navigation\horizontal_header_nav_configuration;

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/default-navs.php';

/**
 * Initiates the plugin and provides the plugin class instance.
 *
 * @since 0.1.0
 * @param boolean $new Whether to force creation of a new instance.
 * @return Colby_Navigation
 */
function colby_navigation( bool $new = false ) : Colby_Navigation {
	static $colby_navigation;

	if ( true === $new || is_null( $colby_navigation ) ) {
		$plugin_url  = plugin_dir_url( __FILE__ );
		$plugin_path = plugin_dir_path( __FILE__ );

		$default_menu_configurations = [ horizontal_header_nav_configuration() ];

		/**
		 * Filters configuration for menus provided by the plugin.
		 *
		 * @since 0.1.0
		 * @param array $menu_configurations
		 */
		$menu_configurations = apply_filters( 'colby_navigation_menus', $default_menu_configurations );

		/**
		 * Filters plugin configuration options.
		 *
		 * @since 0.1.0
		 * @param array
		 */
		$plugin_config = apply_filters(
			'colby_navigation_plugin_config',
			compact(
				'plugin_url',
				'plugin_path',
				'menu_configurations'
			)
		);

		$colby_navigation = new Colby_Navigation( $plugin_config );

		/**
		 * Fires after the main plugin class instance has been created.
		 *
		 * @since 0.1.0
		 * @param Colby_Navigation
		 */
		do_action( 'colby_navigation_init', $colby_navigation );
	}

	return $colby_navigation;
}

/**
 * Registers a navigation menu.
 *
 * @param array $config An array of configuration options.
 * @return Navigation_Menu
 */
function register_colby_navigation_menu( array $config ) : Navigation_Menu {
	return colby_navigation()->register_menu( $config );
}

add_action( 'after_setup_theme', [ colby_navigation(), 'register_locations' ] );
add_action( 'wp_head', [ colby_navigation(), 'print_critical_css' ] );
add_filter( 'wp_nav_menu_args', [ colby_navigation(), 'filter_nav_menu_args' ] );
add_action( 'wp_enqueue_scripts', [ colby_navigation(), 'enqueue_nav_assets' ] );
