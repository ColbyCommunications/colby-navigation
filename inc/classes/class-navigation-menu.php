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
	 * Runs setup tasks after the instance has been created.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$this->add_filters();

		/**
		 * Fires after the menu instance has been set up.
		 * 
		 * @param Navigation_Menu
		 */
		do_action( 'colby_navigation_nav_menu_init', $this );
	}

	/**
	 * Adds filters if set in the config.
	 *
	 * @since 0.1.0
	 */
	public function add_filters() {
		$filters = $this->get( 'filters' );
		if ( ! empty( $filters ) && is_array( $filters ) ) {
			foreach ( $filters as $add_filter_args ) {
				call_user_func_array( 'add_filter', $add_filter_args );
			}
		}
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

	/**
	 * Returns the content of the nav's CSS file as a string.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function get_css_content() : string {
		$css_file = $$this->get( 'css' );
		if ( empty( $css_file ) ) {
			return '';
		}

		$file = sprintf(
			'%s%s',
			trailingslashit(
				strval( $this->get( 'plugin_path' ) )
			),
			$css_file
		);
		if ( ! file_exists( $file ) ) {
			return '';
		}

		ob_start();
		require_once $file;
		return ob_get_clean();
	}
}
