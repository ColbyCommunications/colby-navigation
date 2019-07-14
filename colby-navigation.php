<?php
/**
 * Plugin Name: Colby Navigation
 *
 * @package colby-navigation
 */

use Colby\Plugins\Colby_Navigation\{Colby_Navigation, Horizontal_Header_Nav_Walker};

require_once 'vendor/autoload.php';

/**
 * Initiates the plugin and provides the plugin class instance.
 *
 * @since 0.1.0
 * @return Colby\Plugins\Colby_Navigation\Colby_Navigation
 */
function colby_navigation() {
	static $colby_navigation;

	if ( is_null( $colby_navigation ) ) {
		$plugin_config = [
			'plugin_url'          => plugin_dir_url( __FILE__ ),
			'plugin_path'         => plugin_dir_path( __FILE__ ),
			'menu_configurations' => [
				[
					'args'           => [ 'depth' => 1 ],
					'css'            => 'dist/horizontal-header-nav.css',
					'description'    => __( 'Horizontal header nav', 'colby-navigation' ),
					'id'             => 'horizontal-header-nav',
					'is_critical'    => true,
					'theme_location' => 'colby_navigation_horizontal_header_nav',
					'walker'         => new Horizontal_Header_Nav_Walker(),
				],
			],
		];

		/**
		 * Filters plugin configuration options.
		 *
		 * @param array
		 */
		$plugin_config = apply_filters( 'colby_navigation_plugin_config', $plugin_config );

		$colby_navigation = new Colby_Navigation( $plugin_config );
	}

	return $colby_navigation;
}

add_action( 'after_setup_theme', [ colby_navigation(), 'register_locations' ] );
add_action( 'wp_head', [ colby_navigation(), 'print_critical_css' ] );
add_filter( 'wp_nav_menu_args', [ colby_navigation(), 'filter_nav_menu_args' ] );
