<?php
/**
 * Horizontal_Header_Nav_Walker class.
 *
 * @since 0.1.0
 * @package colby-navigation
 */

namespace Colby\Plugins\Colby_Navigation;

use \Walker_Nav_Menu as Walker_Nav_Menu;

/**
 * Handles a simple horizontal nav with a site home link appended.
 *
 * @since 0.1.0
 */
class Horizontal_Header_Nav_Walker extends Walker_Nav_Menu {
	/**
	 * Ends the element output, if needed.
	 *
	 * The $args parameter holds additional values that may be used with the child class methods.
	 *
	 * @since 0.1.0
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param object $object The data object.
	 * @param int    $depth  Depth of the item.
	 * @param array  $args   An array of additional arguments.
	 */
	public function end_el( &$output, $object, $depth = 0, $args = array() ) {
		parent::end_lvl( $output, $depth, $args );

		$output .= sprintf(
			'<a class="%s__home-link" href="%s">%s</a>',
			esc_attr( $args->menu_class ),
			esc_url( get_bloginfo( 'url' ) ),
			esc_html( get_bloginfo() )
		);
	}
}
