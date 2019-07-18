# colby-navigation [![Build Status](https://travis-ci.org/ColbyCommunications/colby-navigation.svg?branch=master)](https://travis-ci.org/ColbyCommunications/colby-navigation)

Provides markup and styling common types of navigation menus and provides a simple API for the registration of repeatable menus through WordPress.

## Register menus

There are two primary ways to register menus through the plugin:

### 1. `register_colby_navigation_menu` function

The `register_colby_navigation_menu` function should be run on the `colby_navigation_init` WordPress action:

```PHP

function register_my_menu() {
    register_colby_navigation_menu(
        [
            // Configuration array.
        ]
    );
}
add_action( 'colby_navigation_init', 'register_my_menu' );
```

The function takes an array accepting the configuration options outlined below.

### 2. `colby_navigation_menus` filter

The `colby_navigation_menus` filter receives the array of default menus registered with the plugin. This allows default menus to be filtered out, or for additional configurations to be added:

```PHP
function add_my_menu( $menus ) {
    $menus[] = [
        // Configuration array.
    ];
}
add_filter( 'colby_navigation_menus', 'add_my_menu' );
```

## Configuration options

- `args` array: Arguments to override any instance of the menu rendered with `wp_nav_menu`. 
- `description` string: A description of the menu location, to be shown in the admin Menus UI.
- `filters` array: An array of filters to be set up when the menu is registered. Each item should be an array of arguments to pass to the WordPress `add_filter` function via `call_user_func_array`.
- `id` string *(required)*: A unique identifier for the menu. Used, e.g., in CSS classes and as the handle for associated assets.
- `theme_location` string *(required)*: The name of the location to be used with `wp_nav_menu` to render the menu in themes.


### Internal options

The following options should only be used for registering defualt menus within this plugin.

- `css_file` string: Path to the navigation menu's CSS file relative to the plugin root directory.
- `is_critical` boolean: Whether the menu's CSS should be considered critical. Critical CSS is printed in the document head.

## Default menus

The plugin provides the following menus by default:

### `colby_navigation_horizontal_header_nav`

A navigation menu intended for use in site header nav bars. It accepts only one level and truncates the list after 4 items by default (which number can be modified using the `colby_navigation_horizontal_header_nav_max_items` filter). The WordPress site name is automatically added as the last item in the list.