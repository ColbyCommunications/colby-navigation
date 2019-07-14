<?php
/**
 * Class Navigation_Menu
 *
 * @since 0.1.0
 * @package colby-navigation
 */

namespace Colby\Plugins\Colby_Navigation;

/**
 * Navigation_Menu class.
 *
 * @since 0.1.0
 */
class Navigation_Menu {
	/**
	 * Configuration options.
	 *
	 * @since 0.1.0
	 * @var array
	 */
	private $config;

	/**
	 * Whether the location was added.
	 *
	 * @since 0.1.0
	 * @var boolean
	 */
	private $registered = false;

	/**
	 * Class constructor.
	 *
	 * @since 0.1.0
	 * @param array $config Configuration options.
	 */
	public function __construct( array $config ) {
		$this->config = $config;
	}

	/**
	 * Returns a configuration option.
	 *
	 * @since 0.1.0
	 * @param string $key The configuration key.
	 * @return mixed
	 */
	public function get( string $key ) {
		return $this->config[ $key ] ?? null;
	}

	/**
	 * Returns whether the menu item was registered.
	 *
	 * @since 0.1.0
	 * @return bool
	 */
	public function was_registered() : bool {
		return $this->registered;
	}

	/**
	 * Registers the nav menu location.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		register_nav_menu( $this->get( 'theme_location' ), $this->get( 'description' ) );
		$this->registered = true;
	}
}
