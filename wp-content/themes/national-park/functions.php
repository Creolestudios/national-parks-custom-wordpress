<?php
/**
 * Theme functions and definitions
 *
 * @version 1.0.0
 *
 * @package npx
 */

/**
 * Define necessary constants.
 */
define( 'NPX_THEME_DIR', get_template_directory() );
define( 'NPX_THEME_URI', get_template_directory_uri() );

/* Loaded file for general functions. */
require NPX_THEME_DIR . '/inc/general-functions.php';

/* Loaded file for ACF functions. */
require NPX_THEME_DIR . '/inc/acf-functions.php';

/* Loaded file for to enqueue js css. */
require NPX_THEME_DIR . '/inc/render-css-js.php';

/* Loaded file for theme setup functions. */
require NPX_THEME_DIR . '/inc/setup-functions.php';

/* Loaded file for custom shortcodes. */
require NPX_THEME_DIR . '/inc/shortcodes.php';
