<?php
/**
 * Class Horizontal_Header_Nav
 *
 * @since 0.1.0
 * @package colby-navigation
 */

namespace Colby\Plugins\Colby_Navigation;

use \stdClass as stdClass;

/**
 * Horizontal_Header_Nav class
 *
 * @since 0.1.0
 */
class Horizontal_Header_Nav {
	const THEME_LOCATION = 'colby_navigation_horizontal_header_nav';

	/**
	 * Provides the configuration for a default horizontal header nav.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function get_configuration() : array {
		return [
			'args'           => [ 'depth' => 1 ],
			'css_file'       => 'dist/horizontal-header-nav.css',
			'description'    => __( 'Horizontal header nav', 'colby-navigation' ),
			'id'             => 'horizontal-header-nav',
			'is_critical'    => true,
			'theme_location' => self::THEME_LOCATION,
			'filters'        => [
				[ 'wp_nav_menu_items', [ $this, 'append_site_title_to_nav_items_html' ], 10, 2 ],
				[ 'wp_nav_menu_objects', [ $this, 'slice_menu_objects' ], 10, 2 ],
			],
		];
	}

	/**
	 * Adds a site home link to the menu HTML.
	 *
	 * @since 0.1.0
	 * @param string   $html Menu HTML within the container element.
	 * @param stdClass $args Args object.
	 * @return string
	 */
	public function append_site_title_to_nav_items_html( string $html, stdClass $args ) : string {
		if ( self::THEME_LOCATION !== $args->theme_location ) {
			return $html;
		}

		$html .= sprintf(
			'<li class="menu-item menu-item--home-link"><a class="%s__home-link" href="%s">%s</a></li>',
			esc_attr( $args->container_class ),
			esc_url( get_bloginfo( 'url' ) ),
			esc_html( get_bloginfo() )
		);

		return $html;
	}

	/**
	 * For display purposes, limits the number of menu items to show in this nav by cutting off after a max number.
	 *
	 * @since 0.1.0
	 * @param array    $objects The list of nav menu items.
	 * @param stdClass $args Args objects.
	 * @return array Filtered objects.
	 */
	public function slice_menu_objects( array $objects, stdClass $args ) : array {
		if ( self::THEME_LOCATION !== $args->theme_location ) {
			return $objects;
		}

		/**
		 * Filters the maximum number of items this menu can display.
		 *
		 * @param int Default 4.
		 */
		$max_items = apply_filters( self::THEME_LOCATION . '_max_items', 4 );

		return array_slice( $objects, 0, $max_items );
	}
}
