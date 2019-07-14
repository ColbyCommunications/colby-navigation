<?php
/**
 * Class Colby_Navigation
 *
 * @since 0.1.0
 * @package colby-navigation
 */

namespace Colby\Plugins\Colby_Navigation;

/**
 * Colby_Navigation class.
 *
 * @since 0.1.0
 */
class Colby_Navigation {
	/**
	 * Plugin configuration.
	 *
	 * @var array
	 */
	private $config;

	/**
	 * Instances of Navigation_Menu provided by the plugin..
	 *
	 * @since 0.1.0
	 * @var array
	 */
	private $menus;

	/**
	 * Class constructor.
	 *
	 * @since 0.1.0
	 * @param array $config Plugin configuration.
	 */
	public function __construct( $config ) {
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
	 * Provides an array menus provided by the plugin.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function get_menus() : array {
		if ( is_null( $this->menus ) ) {
			$this->menus = array_map( [ $this, 'create_menu' ], (array) $this->get( 'menu_configurations' ) );
		}

		return $this->menus;
	}

	/**
	 * Creates a menu.
	 *
	 * @since 0.1.0
	 * @param array $config Menu configuration.
	 * @return Navigation_Menu
	 */
	public function create_menu( array $config ) : Navigation_Menu {
		/**
		 * Filters configuration options when creationg a Navigation_Menu instance.
		 *
		 * @param array The configuration options array.
		 */
		$config = (array) apply_filters( 'colby_navigation_menu_config', $config );

		$navigation_menu = new Navigation_Menu( $config );
		$navigation_menu->init();

		return $navigation_menu;
	}

	/**
	 * Registers menu locations.
	 *
	 * @since 0.1.0
	 * @return array Menus after registration.
	 */
	public function register_locations() : array {
		return array_map(
			function( Navigation_Menu $menu ) : Navigation_Menu {
				$menu->register();
				return $menu;
			},
			$this->get_menus()
		);
	}

	/**
	 * Prints the CSS for any critical nav menus in the document head.
	 *
	 * @since 0.1.0
	 *
	 * @action wp_head
	 */
	public function print_critical_css() {
		$css = array_reduce( $this->get_menus(), [ $this, 'add_critical_css' ], '' );

		/**
		 * Filters critical nav CSS to be printed in the head.
		 *
		 * @param string
		 */
		$css = apply_filters( 'colby_navigation_critical_css', $css );

		echo wp_kses( sprintf( '<style>%s</style>', $css ), [ 'style' => [] ] );
	}

	/**
	 * Adds to critical CSS output.
	 *
	 * @param string          $output CSS to print in head.
	 * @param Navigation_Menu $menu Menu instance.
	 * @return string Updated CSS to print in head.
	 */
	public function add_critical_css( string $output, Navigation_Menu $menu ) : string {
		if ( true !== $menu->get( 'is_critical' ) ) {
			return $output;
		}

		$css_file = $menu->get( 'css' );
		if ( empty( $css_file ) ) {
			return $output;
		}

		$file = sprintf(
			'%s%s',
			trailingslashit(
				strval( $this->get( 'plugin_path' ) )
			),
			$css_file
		);
		if ( ! file_exists( $file ) ) {
			return $output;
		}

		ob_start();
		require_once $file;
		return $output . ob_get_clean();
	}

	/**
	 * Filters nav menu args if the theme location is one provided by this plugin.
	 *
	 * @since 0.2.0
	 * @param array $args Nav menu args.
	 * @return array Filtered args.
	 */
	public function filter_nav_menu_args( array $args ) : array {
		$menu = null;
		foreach ( $this->get_menus() as $menu_instance ) {
			if ( $menu_instance->get( 'theme_location' ) === $args['theme_location'] ) {
				$menu = $menu_instance;
				break;
			}
		}

		if ( is_null( $menu ) ) {
			return $args;
		}

		$walker = $menu->get( 'walker' );
		if ( $walker ) {
			$args['walker'] = is_callable( $walker ) ? $walker() : $walker;
		}

		$id                      = $menu->get( 'id' );
		$args['container_class'] = $id ?: $args['container_class'];
		$args['menu_class']      = $id ? sprintf( '%s__menu', $id ) : $args['menu_class'];

		$args_config = $menu->get( 'args' ) ?: [];
		$args        = wp_parse_args( $args_config, $args );

		return $args;
	}
}
