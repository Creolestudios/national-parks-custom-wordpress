<?php
/**
 * Load JS and CSS files of theme.
 *
 * @version 1.0.0
 *
 * @package npx
 */

/**
 * Load needed js and css files of theme.
 *
 * @version 1.0.0
 */
function npx_enqueue_scripts_styles() {

	$national_park     = get_page_by_title( 'National Parks' );
	$national_park_url = get_permalink( $national_park->ID );

	// Load CSS files.
	wp_enqueue_style( 'slick-min', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css' );
	wp_enqueue_style( 'slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css' );
	wp_enqueue_style( 'fontawesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' );
	wp_enqueue_style( 'all-style', NPX_THEME_URI . '/dist/assets/css/app.min.css', [], '1.0.0' );

	// Load JS files.
	wp_enqueue_script( 'global-script', NPX_THEME_URI . '/assets/js/global.js', [ 'jquery' ], '1.0.0', false );
	wp_localize_script(
		'global-script',
		'globalScript',
		[
			'home_url'          => home_url( '/' ),
			'national_park_url' => $national_park_url,
			'ajax_url'          => admin_url( 'admin-ajax.php' ),
			'nonce'             => wp_create_nonce( 'auth-token' ),
		]
	);
	if ( is_page_template( 'template/template-contactus.php' ) ) {
		wp_enqueue_script( 'contact-form-script', NPX_THEME_URI . '/assets/js/contact-form.js', [ 'jquery' ], '1.0.0', false );
		wp_localize_script(
			'contact-form-script',
			'contactScript',
			[
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'auth-token' ),
			]
		);
	}
	if ( is_page_template( 'template/template-national-parks.php' ) ) {
		wp_enqueue_script( 'national-park-list', NPX_THEME_URI . '/assets/js/national-park-list.js', [ 'jquery' ], '1.0.0', false );
		wp_localize_script(
			'national-park-list',
			'parkListScript',
			[
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'auth-token' ),
			]
		);
		wp_enqueue_script( 'np-select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', [ 'jquery' ], '', true );
		wp_enqueue_style( 'np-select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css' );
	}
	if ( is_single() ) {
		wp_enqueue_script( 'blog-detail-script', NPX_THEME_URI . '/assets/js/blog-detail.js', [ 'jquery' ], '1.0.0', false );
		wp_localize_script(
			'blog-detail-script',
			'blogDetailScript',
			[
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'auth-token' ),
			]
		);
	}
	if ( is_search() ) {
		wp_enqueue_script( 'search-script', NPX_THEME_URI . '/assets/js/search.js', [ 'jquery' ], '1.0.0', false );
		wp_localize_script(
			'search-script',
			'searchScript',
			[
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'auth-token' ),
			]
		);
	}
	wp_enqueue_script( 'jquery-validator-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js', [], '1.0.0', false );
	wp_enqueue_script( 'fontawesome-js', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js', [], '1.0.0', false );
	wp_enqueue_script( 'slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', [ 'jquery' ], '1.0.0', false );
	wp_enqueue_script( 'magnific-popup', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', [ 'jquery' ], '1.0.0', false );
	wp_enqueue_script( 'custom-js', NPX_THEME_URI . '/dist/assets/js/custom.js', [ 'jquery' ], '1.0.0', false );
}
add_action( 'wp_enqueue_scripts', 'npx_enqueue_scripts_styles' );
