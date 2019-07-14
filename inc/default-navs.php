<?php
/**
 * Provides default nav configurations.
 *
 * @since 0.1.0
 * @package colby-navigation
 */

namespace Colby\Plugins\Colby_Navigation;

/**
 * Provides the configuration for a default horizontal header nav.
 *
 * @since 0.1.0
 * @return array
 */
function horizontal_header_nav_configuration() : array {
	return ( new Horizontal_Header_Nav() )->get_configuration();
}
