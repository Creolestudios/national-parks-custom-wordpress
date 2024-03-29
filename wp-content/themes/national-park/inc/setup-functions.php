<?php
/**
 * Theme Setup functions.
 *
 * @version 1.0.0
 *
 * @package npx
 */

/**
 * Enable custom support in the theme.
 *
 * @version 1.0.0
 */
function npx_custom_theme_setup() {
	// Enable menu support.
	add_theme_support( 'menus' );
	// Enable feature image support.
	add_theme_support( 'post-thumbnails' );
	/*
	* Let WordPress manage the document title.
	* By adding theme support, we declare that this theme does not use a
	* hard-coded <title> tag in the document head, and expect WordPress to
	* provide it for us.
	*/
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'npx_custom_theme_setup' );

/**
 * Register custom menus in the theme.
 *
 * @version 1.0.0
 */
function npx_register_custom_menus() {
	register_nav_menus(
		[
			'header-menu'        => 'Header Menu',
			'header-mobile-menu' => 'Header Mobile Menu',
			'footer-menu'        => 'Footer Menu',
		]
	);
}
add_action( 'init', 'npx_register_custom_menus' );

/**
 * Allow SVG Support
 *
 * @param array $mimes Array of allowed mime types.
 * @return array Modified array of allowed mime types.
 */
function npx_allow_svg_support( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}
add_filter( 'upload_mimes', 'npx_allow_svg_support' );

/**
 * Register a custom post type called "National Parks".
 *
 * @version 1.0.0
 */
function npx_register_posttype_national_park() {
	$national_park_labels = [
		'name'                  => _x( 'National Parks', 'National Parks', 'npx' ),
		'singular_name'         => _x( 'National Park', 'National Park', 'npx' ),
		'menu_name'             => _x( 'National Parks', 'Admin Menu text', 'npx' ),
		'name_admin_bar'        => _x( 'National Park', 'Add New on Toolbar', 'npx' ),
		'add_new'               => __( 'Add New', 'npx' ),
		'add_new_item'          => __( 'Add New National Park', 'npx' ),
		'new_item'              => __( 'New National Park', 'npx' ),
		'edit_item'             => __( 'Edit National Park', 'npx' ),
		'view_item'             => __( 'View National Park', 'npx' ),
		'all_items'             => __( 'All National Parks', 'npx' ),
		'search_items'          => __( 'Search National Park', 'npx' ),
		'parent_item_colon'     => __( 'Parent National Park:', 'npx' ),
		'not_found'             => __( 'No National Park found.', 'npx' ),
		'not_found_in_trash'    => __( 'No National Park found in Trash.', 'npx' ),
		'featured_image'        => _x( 'National Park Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'npx' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'npx' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'npx' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'npx' ),
	];

	$national_park_args = [
		'labels'             => $national_park_labels,
		'has_archive'        => true,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'menu_icon'          => 'dashicons-palmtree',
		'menu_position'      => 9,
		'rewrite'            => [ 'slug' => 'national-park' ],
		'supports'           => [ 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields' ],
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
	];

	register_post_type( 'national_park', $national_park_args );
}
add_action( 'init', 'npx_register_posttype_national_park' );

/**
 * Register a custom post type called "Continents".
 *
 * @version 1.0.0
 */
function npx_register_posttype_continent() {
	$national_park_labels = [
		'name'                  => _x( 'Continents', 'Continents', 'npx' ),
		'singular_name'         => _x( 'Continent', 'Continent', 'npx' ),
		'menu_name'             => _x( 'Continents', 'Admin Menu text', 'npx' ),
		'name_admin_bar'        => _x( 'Continent', 'Add New on Toolbar', 'npx' ),
		'add_new'               => __( 'Add New', 'npx' ),
		'add_new_item'          => __( 'Add New Continent', 'npx' ),
		'new_item'              => __( 'New Continent', 'npx' ),
		'edit_item'             => __( 'Edit Continent', 'npx' ),
		'view_item'             => __( 'View Continent', 'npx' ),
		'all_items'             => __( 'All Continents', 'npx' ),
		'search_items'          => __( 'Search Continent', 'npx' ),
		'parent_item_colon'     => __( 'Parent Continent:', 'npx' ),
		'not_found'             => __( 'No Continent found.', 'npx' ),
		'not_found_in_trash'    => __( 'No Continent found in Trash.', 'npx' ),
		'featured_image'        => _x( 'Continent Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'npx' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'npx' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'npx' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'npx' ),
	];

	$national_park_args = [
		'labels'             => $national_park_labels,
		'has_archive'        => true,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'menu_icon'          => 'dashicons-admin-site',
		'menu_position'      => 7,
		'rewrite'            => [ 'slug' => 'continent' ],
		'supports'           => [ 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields' ],
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
	];

	register_post_type( 'continent', $national_park_args );
}
add_action( 'init', 'npx_register_posttype_continent' );

/**
 * Register a custom post type called "Country".
 *
 * @version 1.0.0
 */
function npx_register_posttype_country() {
	$national_park_labels = [
		'name'                  => _x( 'Countries', 'Countries', 'npx' ),
		'singular_name'         => _x( 'Country', 'Country', 'npx' ),
		'menu_name'             => _x( 'Countries', 'Admin Menu text', 'npx' ),
		'name_admin_bar'        => _x( 'Country', 'Add New on Toolbar', 'npx' ),
		'add_new'               => __( 'Add New', 'npx' ),
		'add_new_item'          => __( 'Add New Country', 'npx' ),
		'new_item'              => __( 'New Country', 'npx' ),
		'edit_item'             => __( 'Edit Country', 'npx' ),
		'view_item'             => __( 'View Country', 'npx' ),
		'all_items'             => __( 'All Countries', 'npx' ),
		'search_items'          => __( 'Search Country', 'npx' ),
		'parent_item_colon'     => __( 'Parent Country:', 'npx' ),
		'not_found'             => __( 'No Country found.', 'npx' ),
		'not_found_in_trash'    => __( 'No Country found in Trash.', 'npx' ),
		'featured_image'        => _x( 'Country Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'npx' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'npx' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'npx' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'npx' ),
	];

	$national_park_args = [
		'labels'             => $national_park_labels,
		'has_archive'        => true,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'menu_icon'          => 'dashicons-admin-site',
		'menu_position'      => 8,
		'rewrite'            => [ 'slug' => 'country' ],
		'supports'           => [ 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields' ],
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
	];

	register_post_type( 'country', $national_park_args );
}
add_action( 'init', 'npx_register_posttype_country' );

/**
 * Register a custom post type called "Places to Stay".
 *
 * @version 1.0.0
 */
function npx_register_posttype_place_to_stay() {
	$place_to_stay_labels = [
		'name'                  => _x( 'Places to Stay', 'Places to Stay', 'npx' ),
		'singular_name'         => _x( 'Place to Stay', 'Place to Stay', 'npx' ),
		'menu_name'             => _x( 'Places to Stay', 'Admin Menu text', 'npx' ),
		'name_admin_bar'        => _x( 'Place to Stay', 'Add New on Toolbar', 'npx' ),
		'add_new'               => __( 'Add New', 'npx' ),
		'add_new_item'          => __( 'Add New Place to Stay', 'npx' ),
		'new_item'              => __( 'New Place to Stay', 'npx' ),
		'edit_item'             => __( 'Edit Place to Stay', 'npx' ),
		'view_item'             => __( 'View Place to Stay', 'npx' ),
		'all_items'             => __( 'All Places to Stay', 'npx' ),
		'search_items'          => __( 'Search Place to Stay', 'npx' ),
		'parent_item_colon'     => __( 'Parent Place to Stay:', 'npx' ),
		'not_found'             => __( 'No Place to Stay found.', 'npx' ),
		'not_found_in_trash'    => __( 'No Place to Stay found in Trash.', 'npx' ),
		'featured_image'        => _x( 'Place to Stay Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'npx' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'npx' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'npx' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'npx' ),
	];

	$place_to_stay_args = [
		'labels'             => $place_to_stay_labels,
		'has_archive'        => true,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'menu_icon'          => 'dashicons-admin-home',
		'menu_position'      => 9,
		'rewrite'            => [ 'slug' => 'place-to-stay' ],
		'supports'           => [ 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields' ],
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
	];

	register_post_type( 'place_to_stay', $place_to_stay_args );
}
add_action( 'init', 'npx_register_posttype_place_to_stay' );


/**
 * Additional custom taxonomies.
 *
 * @version 1.0.0
 */
function npx_add_custom_taxonomies() {

	// National Park Tags taxonomy.
	register_taxonomy(
		'national_park_tag',
		'national_park',
		[
			'label'             => __( 'Tags' ),
			'rewrite'           => [ 'slug' => 'national-park-tag' ],
			'hierarchical'      => true,
			'has_archive'       => false,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
		]
	);

	// Place to stay category.
	register_taxonomy(
		'place_to_stay_categories',
		'place_to_stay',
		[
			'label'             => __( 'Place to Stay Categories' ),
			'rewrite'           => [ 'slug' => 'place-to-stay-categories' ],
			'hierarchical'      => true,
			'public'            => true,
			'has_archive'       => false,
			'show_admin_column' => true,
			'show_in_rest'      => true,
		]
	);
}
add_action( 'init', 'npx_add_custom_taxonomies' );

/**
 * Function to add custom column to the country,national_park post type.
 *
 * @version 1.0.0
 */
function npx_continent( $columns ) {
	$columns['npx_selected_continent'] = 'Continent';
	return $columns;
}
add_filter( 'manage_country_posts_columns', 'npx_continent' );
add_filter( 'manage_national_park_posts_columns', 'npx_continent' );

/**
 * Function to add custom column to the national_park post type.
 *
 * @version 1.0.0
 */
function npx_country( $columns ) {
	$columns['npx_selected_country'] = 'Country';
	return $columns;
}
add_filter( 'manage_national_park_posts_columns', 'npx_country' );

/**
 * Function to display values to custom column for country,national_park post type.
 *
 * @version 1.0.0
 */
function acf_display_continent_column_value( $column_name, $post_id ) {
	if ( $column_name === 'npx_selected_continent' ) {
		$field_value = get_field( 'select_continent', $post_id );
		echo $field_value->post_title;
	}
}
add_action( 'manage_country_posts_custom_column', 'acf_display_continent_column_value', 10, 2 );
add_action( 'manage_national_park_posts_custom_column', 'acf_display_continent_column_value', 10, 2 );

/**
 * Function to display values to custom column for national_park post type.
 *
 * @version 1.0.0
 */
function acf_display_country_column_value( $column_name, $post_id ) {
	if ( $column_name === 'npx_selected_country' ) {
		$field_value = get_field( 'select_country', $post_id );
		echo $field_value->post_title;
	}
}
add_action( 'manage_national_park_posts_custom_column', 'acf_display_country_column_value', 10, 2 );

/**
 * Custom rewrite rules for national park post type.
 *
 * @param array $rules Existing rewrite rules.
 * @return array Modified rewrite rules.
 */
// function npx_national_park_rewrite_rules( $rules ) {
// $new_rules = [];

// Check if we are in the draft phase
// $draft_phase = isset( $_GET['preview'] ) && 'true' === $_GET['preview'];

// Set post status based on draft phase
// $post_status = $draft_phase ? 'draft' : 'publish';

// Retrieve all national park posts.
// $national_parks = get_posts(
// [
// 'post_type'      => 'national_park',
// 'posts_per_page' => -1,
// 'post_status'    => [ 'publish', 'draft', 'auto-draft' ],
// ]
// );

// Loop through each national park post.
// foreach ( $national_parks as $national_park ) {
// $country_id   = get_post_meta( $national_park->ID, 'select_country', true );
// $country_name = str_replace( ' ', '-', strtolower( get_the_title( $country_id ) ) );

// if ( ! empty( $country_name ) ) {
// $new_rules[ $country_name . '/([^/]+)/?$' ] = 'index.php?national_park=$matches[1]';
// }
// }

// Merge new rules with existing rules.
// $rules = $new_rules + $rules;

// Return modified rewrite rules.
// return $rules;
// }
// add_filter( 'rewrite_rules_array', 'npx_national_park_rewrite_rules' );

/**
 * Modify permalink for national park post type.
 *
 * @param string $permalink The post permalink.
 * @param object $post The post object.
 * @return string Modified post permalink.
 */
function npx_national_park_post_link( $permalink, $post ) {
	if ( 'national_park' === get_post_type( $post ) && $post->post_status !== 'draft' ) {
		// Get the country ID associated with the national park.
		$country_id   = get_post_meta( $post->ID, 'select_country', true );
		$country_name = str_replace( ' ', '-', strtolower( get_the_title( $country_id ) ) );

		if ( ! empty( $country_name ) ) {
			$permalink = home_url( $country_name . '/' . $post->post_name );
		}
	}

	// Return modified post permalink.
	return $permalink;
}
add_filter( 'post_type_link', 'npx_national_park_post_link', 10, 2 );

/**
 * Add custom rewrite rules.
 */
function npx_add_rewrite_rules() {
	$national_parks = get_posts(
		[
			'post_type'   => 'national_park', // Adjust post type as per your setup.
			'numberposts' => -1, // Retrieve all posts.
		]
	);

	$new_rules = [];

	foreach ( $national_parks as $national_park ) {
		$country_id   = get_post_meta( $national_park->ID, 'select_country', true );
		$country_name = str_replace( ' ', '-', strtolower( get_the_title( $country_id ) ) );

		if ( ! empty( $country_name ) ) {
			$new_rules[ $country_name . '/([^/]+)/?$' ] = 'index.php?national_park=$matches[1]';
		}
	}

	foreach ( $new_rules as $rule => $rewrite ) {
		add_rewrite_rule( $rule, $rewrite, 'top' );
	}

	// Flush rewrite rules on activation.
	flush_rewrite_rules();
}
add_action( 'init', 'npx_add_rewrite_rules' );
