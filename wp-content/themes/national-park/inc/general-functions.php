<?php
/**
 * Theme general functions.
 *
 * @version 1.0.0
 *
 * @package npx
 */


/**
 * Function for image alt.
 *
 * @param post_id $post_id ID of a post.
 *
 * @version 1.0.0
 */
function npx_get_img_alt( $post_id ) {
	$post_img_id = get_post_thumbnail_id( $post_id );
	return ( ! empty( get_post_meta( $post_img_id, '_wp_attachment_image_alt', true ) ) ) ? get_post_meta( $post_img_id, '_wp_attachment_image_alt', true ) : get_the_title( $post_id );
}

/**
 * Ajax callback to load more national park blogs.
 *
 * @version 1.0.0
 */
function npx_load_more_national_park_blogs() {
	$security_nonce   = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
	$blog_paged       = isset( $_POST['blog_paged'] ) ? sanitize_text_field( wp_unslash( $_POST['blog_paged'] ) ) : '';
	$blog_per_page    = isset( $_POST['blog_per_page'] ) ? sanitize_text_field( wp_unslash( $_POST['blog_per_page'] ) ) : '';
	$filter_sort_type = isset( $_POST['filter_sort_type'] ) ? sanitize_text_field( wp_unslash( $_POST['filter_sort_type'] ) ) : '';
	$filter_cat_value = isset( $_POST['filter_cat_value'] ) ? sanitize_text_field( wp_unslash( $_POST['filter_cat_value'] ) ) : '';
	if ( wp_verify_nonce( $security_nonce, 'auth-token' ) ) {
		$blog_args = [
			'posts_per_page' => $blog_per_page,
			'post_status'    => 'publish',
			'post_type'      => 'post',
			'paged'          => $blog_paged,
		];

		// Add args depending on sorting type.
		if ( $filter_sort_type == 'popular' ) {
			$blog_args['tag'] = 'popular';
		} elseif ( $filter_sort_type == 'favorites' ) {
			$blog_args['tag'] = 'favorites';
		} elseif ( $filter_sort_type == 'highlights' ) {
			$blog_args['tag'] = 'highlights';
		}

		// Add category id depends on filter.
		if ( $filter_cat_value !== 0 || ! empty( $filter_cat_value ) ) {
			$blog_args['category_name'] = $filter_cat_value;
		}
		$blog_query = new WP_Query( $blog_args );
		if ( $blog_query->have_posts() ) {
			ob_start();
			while ( $blog_query->have_posts() ) {
				$blog_query->the_post();

				get_template_part( 'template-parts/blog', 'listing' );
			}
		}
		$html = ob_get_clean();
		ob_end_clean();
		wp_reset_postdata();
		$response = [
			'html' => $html,
		];
		wp_send_json_success( $response );
	} else {
		wp_send_json_error( 'Nonce Verification Failed..!' );
	}
	wp_die();
}
add_action( 'wp_ajax_npx_load_more_national_park_blogs', 'npx_load_more_national_park_blogs' );
add_action( 'wp_ajax_nopriv_npx_load_more_national_park_blogs', 'npx_load_more_national_park_blogs' );

/**
 * Ajax callback to filter national park blogs.
 *
 * @version 1.0.0
 */
function npx_get_blogs_by_filter() {
	$security_nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
	$blog_per_page  = isset( $_POST['blog_per_page'] ) ? sanitize_text_field( wp_unslash( $_POST['blog_per_page'] ) ) : '';
	$sort_type      = isset( $_POST['sort_type'] ) ? sanitize_text_field( wp_unslash( $_POST['sort_type'] ) ) : '';
	$cat_value      = isset( $_POST['cat_value'] ) ? sanitize_text_field( wp_unslash( $_POST['cat_value'] ) ) : '';
	$search_value   = isset( $_POST['search_value'] ) ? sanitize_text_field( wp_unslash( $_POST['search_value'] ) ) : '';
	if ( wp_verify_nonce( $security_nonce, 'auth-token' ) ) {
		$blog_args = [
			'posts_per_page' => $blog_per_page,
			'post_status'    => 'publish',
			'post_type'      => 'post',
		];

		// Add args depending on sorting type.
		if ( $sort_type == 'popular' ) {
			$blog_args['tag'] = 'popular';
		} elseif ( $sort_type == 'favorites' ) {
			$blog_args['tag'] = 'favorites';
		} elseif ( $sort_type == 'highlights' ) {
			$blog_args['tag'] = 'highlights';
		}

		// Add category id depends on filter.
		if ( $cat_value !== 0 ) {
			$blog_args['category_name'] = $cat_value;
		}

		// If search keywords are found.
		if ( ! empty( $search_value ) ) {
			$blog_args['s'] = $search_value;
		}
		$blog_query  = new WP_Query( $blog_args );
		$total_blogs = $blog_query->found_posts;

		if ( $blog_query->have_posts() ) {
			ob_start();
			while ( $blog_query->have_posts() ) {
				$blog_query->the_post();

				get_template_part( 'template-parts/blog', 'listing' );
			}
		} else {
			?>
				<h3><?php echo esc_html( 'No Data Found' ); ?></h3>
			<?php
		}
		$html = ob_get_clean();
		ob_end_clean();
		wp_reset_postdata();
		$response = [
			'html'       => $html,
			'totalblogs' => $total_blogs,
		];
		wp_send_json_success( $response );
	} else {
		wp_send_json_error( 'Nonce Verification Failed..!' );
	}
	wp_die();
}
add_action( 'wp_ajax_npx_get_blogs_by_filter', 'npx_get_blogs_by_filter' );
add_action( 'wp_ajax_nopriv_npx_get_blogs_by_filter', 'npx_get_blogs_by_filter' );

/**
 * Ajax callback to submit contact form inquiry.
 *
 * @version 1.0.0
 */
function npx_submit_inquiry_details() {
	$security_nonce     = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
	$name               = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email              = isset( $_POST['email'] ) ? sanitize_text_field( wp_unslash( $_POST['email'] ) ) : '';
	$phone_number       = isset( $_POST['phone_number'] ) ? sanitize_text_field( wp_unslash( $_POST['phone_number'] ) ) : '';
	$phone_country_code = isset( $_POST['phone_country_code'] ) ? sanitize_text_field( wp_unslash( $_POST['phone_country_code'] ) ) : '';
	$reason             = isset( $_POST['reason'] ) ? sanitize_text_field( wp_unslash( $_POST['reason'] ) ) : '';
	$message            = isset( $_POST['message'] ) ? sanitize_text_field( wp_unslash( $_POST['message'] ) ) : '';
	if ( wp_verify_nonce( $security_nonce, 'auth-token' ) ) {
		$errors = []; // Array to store validation errors.

		// Validate name.
		if ( strlen( $name ) < 1 ) {
			$errors['name'] = 'Please enter your name.';
		} elseif ( strlen( $name ) < 2 ) {
			$errors['name'] = 'Name must be at least 2 characters long.';
		}

		// Validate email.
		if ( strlen( $email ) < 1 ) {
			$errors['email'] = 'Please enter your email.';
		} elseif ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			$errors['email'] = 'Please enter a valid email address.';
		}

		// Validate phone number.
		if ( strlen( $phone_number ) < 1 ) {
			$errors['phone_number'] = 'Please enter a phone number.';
		}

		// Validate phone country code.
		if ( strlen( $phone_country_code ) < 1 ) {
			$errors['phone_country_code'] = 'Please enter country code.';
		}

		// Validate reason.
		if ( strlen( $reason ) < 1 || $reason == 0 ) {
			$errors['reason'] = 'Please select a reason.';
		}

		// Validate message.
		if ( strlen( $message ) < 1 ) {
			$errors['message'] = 'Please enter a message.';
		} elseif ( strlen( $message ) < 2 ) {
			$errors['message'] = 'Message must be at least 2 characters long.';
		}

		if ( ! empty( $errors ) ) {
			// Send validation errors as JSON response.
			wp_send_json_error(
				[
					'message' => 'Validation errors',
					'errors'  => $errors,
				]
			);
			wp_die();
		}

		// Send inquiry details to the admin.
		$inquiry_email_id    = ! empty( get_field( 'inquiry_email_id', 'option' ) ) ? get_field( 'inquiry_email_id', 'option' ) : '';
		$multiple_recipients = [
			$inquiry_email_id,
		];

		$subj = "Inquiry - Contact Us - $name";
		$body = "
			Name: $name
			Email: $email
			Country Code: $phone_country_code
			Phone Number: $phone_number
			Reason: $reason
			Message: $message
		";
		wp_mail( $multiple_recipients, $subj, $body );

		// Prepare the response data.
		$response = [
			'response' => 'Sent successfully.',
		];

		// Send the JSON-encoded response with success status.
		wp_send_json_success( $response );
		wp_die();
	} else {
		wp_send_json_error( 'Nonce Verification Failed..!' );
	}
}
add_action( 'wp_ajax_npx_submit_inquiry_details', 'npx_submit_inquiry_details' );
add_action( 'wp_ajax_nopriv_npx_submit_inquiry_details', 'npx_submit_inquiry_details' );

/**
 * Ajax callback to loadmore related blogs.
 *
 * @version 1.0.0
 */
function akd_load_more_related_blogs() {
	$security_nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
	$post_id        = isset( $_POST['post_id'] ) ? sanitize_text_field( wp_unslash( $_POST['post_id'] ) ) : '';
	$blog_per_page  = isset( $_POST['blog_per_page'] ) ? sanitize_text_field( wp_unslash( $_POST['blog_per_page'] ) ) : '';
	$blog_paged     = isset( $_POST['blog_paged'] ) ? sanitize_text_field( wp_unslash( $_POST['blog_paged'] ) ) : '';
	if ( wp_verify_nonce( $security_nonce, 'auth-token' ) ) {
		$category_ids       = wp_get_post_categories( $post_id );
		$related_blog_args  = [
			'posts_per_page' => 3,
			'post_status'    => 'publish',
			'post_type'      => 'post',
			'category__in'   => $category_ids,
			'post__not_in'   => [ $post_id ],
			'posts_per_page' => $blog_per_page,
			'paged'          => $blog_paged,
		];
		$related_blog_query = new WP_Query( $related_blog_args );

		if ( $related_blog_query->have_posts() ) {
			ob_start();
			while ( $related_blog_query->have_posts() ) {
				$related_blog_query->the_post();

				get_template_part( 'template-parts/blog', 'listing' );
			}
		} else {
			?>
				<h3><?php echo esc_html( 'No Data Found' ); ?></h3>
			<?php
		}
		$html = ob_get_clean();
		ob_end_clean();
		wp_reset_postdata();
		$response = [
			'html' => $html,
		];
		wp_send_json_success( $response );
		wp_die();
	} else {
		wp_send_json_error( 'Nonce Verification Failed..!' );
	}
}
add_action( 'wp_ajax_akd_load_more_related_blogs', 'akd_load_more_related_blogs' );
add_action( 'wp_ajax_nopriv_akd_load_more_related_blogs', 'akd_load_more_related_blogs' );

/**
 * Ajax callback to filter national parks by continent.
 *
 * @version 1.0.0
 */
function npx_get_parks_by_continent() {
	$security_nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
	$category_id    = isset( $_POST['category_id'] ) ? sanitize_text_field( wp_unslash( $_POST['category_id'] ) ) : '';
	$per_page       = isset( $_POST['per_page'] ) ? sanitize_text_field( wp_unslash( $_POST['per_page'] ) ) : '';
	$search_term    = isset( $_POST['search_term'] ) ? sanitize_text_field( wp_unslash( $_POST['search_term'] ) ) : '';
	$sort_value     = isset( $_POST['sort_value'] ) ? sanitize_text_field( wp_unslash( $_POST['sort_value'] ) ) : '';
	$country_value  = isset( $_POST['country_value'] ) ? $_POST['country_value'] : [];

	if ( wp_verify_nonce( $security_nonce, 'auth-token' ) ) {
		$category_name = get_the_title( $category_id );

		// National parks from their continent.
		$category_args = [
			'post_type'      => 'national_park',
			'post_status'    => 'publish',
			'posts_per_page' => $per_page,
			'meta_query'     => [
				'relation' => 'AND',
				[
					'key'     => 'select_continent',
					'value'   => $category_id,
					'compare' => '=',
				],
				[
					'key'     => 'select_country',
					'value'   => $country_value,
					'compare' => 'IN',
				],
			],
		];

		// If search keywords are found.
		if ( ! empty( $search_term ) ) {
			$category_args['s'] = $search_term;
		}

		// For sorting.
		if ( isset( $sort_value ) && $sort_value == 'ASC' ) {
			$category_args['orderby'] = 'title';
			$category_args['order']   = 'ASC';
		} elseif ( isset( $sort_value ) && $sort_value == 'DESC' ) {
			$category_args['orderby'] = 'title';
			$category_args['order']   = 'DESC';
		} else {
			$category_args['orderby'] = 'title';
			$category_args['order']   = 'ASC';
		}

		$get_national_parks = new WP_Query( $category_args );
		$total_parks        = $get_national_parks->found_posts;

		if ( $get_national_parks->have_posts() ) {
			ob_start();
			while ( $get_national_parks->have_posts() ) {
				$get_national_parks->the_post();
				get_template_part( 'template-parts/national', 'park-listing' );
			}
			wp_reset_postdata();
		} else {
			?>
				<h3><?php echo esc_html( 'No Data Found' ); ?></h3>
			<?php
		}
		$html = ob_get_clean();
		ob_end_clean();

		// Favorite National parks.
		$favorite_args  = [
			'post_type'      => 'national_park',
			'posts_per_page' => 4,
			'meta_query'     => [
				[
					'key'     => 'select_continent',
					'value'   => $category_id,
					'compare' => '=',
				],
			],
			'tax_query'      => [
				[
					'taxonomy' => 'national_park_tag',
					'field'    => 'slug',
					'terms'    => 'favorites',
				],
			],
		];
		$favorite_parks = new WP_Query( $favorite_args );
		if ( $favorite_parks->have_posts() ) {
			ob_start();
			?>
				<h2 class="title-curve black"><?php echo esc_html( 'Favorite ' . $category_name ); ?></h2>
				<div class="farm-animal-list-wrapper">
					<?php
					while ( $favorite_parks->have_posts() ) {
						$favorite_parks->the_post();
						get_template_part( 'template-parts/favorite', 'national-park' );
					}
					?>
				</div>
			<?php
			wp_reset_postdata();
		}
		$fav_content = ob_get_clean();
		ob_end_clean();

		// Country dropdown.
		$country_args = [
			'post_type'      => 'country',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'meta_query'     => [
				[
					'key'     => 'select_continent',
					'value'   => $category_id,
					'compare' => '=',
				],
			],
			'orderby'        => 'title',
			'order'          => 'ASC',
		];
		$country_qry  = new WP_Query( $country_args );
		if ( $country_qry->have_posts() ) {
			ob_start();
			?>
				<select name="country" id="np-country-filter" multiple="multiple">
					<option value="">Select</option>
					<?php
					while ( $country_qry->have_posts() ) {
						$country_qry->the_post();
						?>
							<option value="<?php echo esc_attr( get_the_ID() ); ?>"><?php echo esc_html( get_the_title() ); ?></option>
						<?php
					}
					?>
				</select>
			<?php
		}
		$country_dropdown = ob_get_clean();
		ob_end_clean();

		$response = [
			'html'             => $html,
			'fav_content'      => $fav_content,
			'total_parks'      => $total_parks,
			'country_dropdown' => $country_dropdown,
		];
		wp_send_json_success( $response );
		wp_die();
	} else {
		wp_send_json_error( 'Nonce Verification Failed..!' );
	}
}
add_action( 'wp_ajax_npx_get_parks_by_continent', 'npx_get_parks_by_continent' );
add_action( 'wp_ajax_nopriv_npx_get_parks_by_continent', 'npx_get_parks_by_continent' );

/**
 * Ajax callback to loadmore national parks based on continent.
 *
 * @version 1.0.0
 */
function npx_load_more_parks_by_continent() {
	$security_nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
	$category_id    = isset( $_POST['category_id'] ) ? sanitize_text_field( wp_unslash( $_POST['category_id'] ) ) : '';
	$per_page       = isset( $_POST['per_page'] ) ? sanitize_text_field( wp_unslash( $_POST['per_page'] ) ) : '';
	$paged          = isset( $_POST['paged'] ) ? sanitize_text_field( wp_unslash( $_POST['paged'] ) ) : '';
	$search_term    = isset( $_POST['search_term'] ) ? sanitize_text_field( wp_unslash( $_POST['search_term'] ) ) : '';
	$sort_value     = isset( $_POST['sort_value'] ) ? sanitize_text_field( wp_unslash( $_POST['sort_value'] ) ) : '';
	$country_value  = isset( $_POST['country_value'] ) ? $_POST['country_value'] : [];
	if ( wp_verify_nonce( $security_nonce, 'auth-token' ) ) {
		$category_args = [
			'post_type'      => 'national_park',
			'post_status'    => 'publish',
			'posts_per_page' => $per_page,
			'paged'          => $paged,
			'meta_query'     => [
				'relation' => 'AND',
				[
					'key'     => 'select_continent',
					'value'   => $category_id,
					'compare' => '=',
				],
				[
					'key'     => 'select_country',
					'value'   => $country_value,
					'compare' => 'IN',
				],
			],
		];

		// For sorting.
		if ( isset( $sort_value ) && $sort_value == 'ASC' ) {
			$category_args['orderby'] = 'title';
			$category_args['order']   = 'ASC';
		} elseif ( isset( $sort_value ) && $sort_value == 'DESC' ) {
			$category_args['orderby'] = 'title';
			$category_args['order']   = 'DESC';
		} else {
			$category_args['orderby'] = 'title';
			$category_args['order']   = 'ASC';
		}

		// For search value.
		if ( ! empty( $search_term ) ) {
			$category_args['s'] = $search_term;
		}

		$get_animal_category = new WP_Query( $category_args );

		if ( $get_animal_category->have_posts() ) {
			ob_start();
			while ( $get_animal_category->have_posts() ) {
				$get_animal_category->the_post();

				get_template_part( 'template-parts/national', 'park-listing' );
			}
		} else {
			?>
				<h3><?php echo esc_html( 'No Data Found' ); ?></h3>
			<?php
		}
		$html = ob_get_clean();
		ob_end_clean();
		wp_reset_postdata();
		$response = [
			'html' => $html,
		];
		wp_send_json_success( $response );
		wp_die();
	} else {
		wp_send_json_error( 'Nonce Verification Failed..!' );
	}
}
add_action( 'wp_ajax_npx_load_more_parks_by_continent', 'npx_load_more_parks_by_continent' );
add_action( 'wp_ajax_nopriv_npx_load_more_parks_by_continent', 'npx_load_more_parks_by_continent' );

/**
 * Ajax callback to load more search results.
 *
 * @version 1.0.0
 */
function npx_load_more_search_results() {
	$security_nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
	$search_value   = isset( $_POST['search_value'] ) ? sanitize_text_field( wp_unslash( $_POST['search_value'] ) ) : '';
	$start_index    = isset( $_POST['start_index'] ) ? sanitize_text_field( wp_unslash( $_POST['start_index'] ) ) : '';
	if ( wp_verify_nonce( $security_nonce, 'auth-token' ) ) {
		$search_value_array = unserialize( $search_value );
		$end_index          = min( $start_index + 6 - 1, count( $search_value_array ) - 1 );
		ob_start();
		for ( $i = $start_index; $i <= $end_index;$i++ ) {
			$post_id    = $search_value_array[ $i ];
			$post_url   = get_permalink( $post_id );
			$post_title = get_the_title( $post_id );
			$post_image = get_the_post_thumbnail_url( $post_id, 'large' );
			?>
				<div class="list">
					<div class="img-content">
						<?php
						if ( $post_image ) {
							?>
								<img src="<?php echo esc_url( $post_image ); ?>" alt="<?php echo esc_attr( npx_get_img_alt( $post_id ) ); ?>" />
							<?php
						} else {
							$no_image_thumbnail = get_field( 'default_post_thumbnail_image', 'option' );
							?>
								<img src="<?php echo esc_url( $no_image_thumbnail ); ?>" alt="no-image-thumbnail">
							<?php
						}
						?>
					</div>
					<div class="content">
						<a href="<?php echo esc_url( $post_url ); ?>">
							<h4><?php echo esc_html( $post_title ); ?></h4>
						</a>
					</div>
				</div>
			<?php
		}

		$html = ob_get_contents();
		ob_end_clean();

		$response = [
			'html' => $html,
		];
		wp_send_json_success( $response );
		wp_die();
	} else {
		wp_send_json_error( 'Nonce Verification Failed..!' );
	}
}
add_action( 'wp_ajax_npx_load_more_search_results', 'npx_load_more_search_results' );
add_action( 'wp_ajax_nopriv_npx_load_more_search_results', 'npx_load_more_search_results' );

/**
 * Ajax callback to load more search results.
 *
 * @version 1.0.0
 */
function akd_load_more_animal_species() {
	$security_nonce      = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
	$species_id          = isset( $_POST['species_id'] ) ? sanitize_text_field( wp_unslash( $_POST['species_id'] ) ) : '';
	$species_start_index = isset( $_POST['species_start_index'] ) ? sanitize_text_field( wp_unslash( $_POST['species_start_index'] ) ) : '';
	if ( wp_verify_nonce( $security_nonce, 'auth-token' ) ) {
		$species_id_arr = unserialize( $species_id );
		$end_index      = min( $species_start_index + 6 - 1, count( $species_id_arr ) - 1 );

		ob_start();
		for ( $i = $species_start_index; $i <= $end_index;$i++ ) {
			$species_id      = $species_id_arr[ $i ];
			$species_name    = get_the_title( $species_id );
			$species_image   = get_the_post_thumbnail_url( $species_id, 'large' );
			$species_url     = get_the_permalink( $species_id );
			$species_content = get_post_field( 'post_content', $species_id );
			$trim_content    = wp_trim_words( $species_content, 40, '...' );
			$species_terms   = get_the_terms( $species_id, 'species-categories' );
			?>
				<div class="type-of-cat-item">
					<div class="type-of-cat-img-wrapper">
						<?php
						if ( ! empty( $species_image ) ) {
							?>
								<img class="img-cover" src="<?php echo esc_url( $species_image ); ?>" alt="<?php echo esc_attr( npx_get_img_alt( $species_id ) ); ?>">
							<?php
						} else {
							$no_image_thumbnail = get_field( 'default_post_thumbnail_image', 'option' );
							?>
								<img class="img-cover" src="<?php echo esc_url( $no_image_thumbnail ); ?>" alt="no-image-thumbnail">
							<?php
						}
						?>
					</div>
					<div class="type-of-cat-content-wrapper">
						<h4><?php echo esc_html( $species_name ); ?></h4>
						<p><?php echo esc_html( $trim_content ); ?></p>
						<div class="type-of-cat-tags">
							<?php
							if ( ! empty( $species_terms ) ) {
								foreach ( $species_terms as $term ) {
									?>
										<span><?php echo esc_html( $term->name ); ?></span>
									<?php
								}
							}
							?>
						</div>
						<a href="<?php echo esc_url( $species_url ); ?>" class="btn btn-transparent-white"><?php echo esc_html( 'Read More' ); ?></a>
					</div>
				</div>
			<?php
		}

		$html = ob_get_contents();
		ob_end_clean();

		$response = [
			'html' => $html,
		];
		wp_send_json_success( $response );
		wp_die();
	} else {
		wp_send_json_error( 'Nonce Verification Failed..!' );
	}
}
add_action( 'wp_ajax_akd_load_more_animal_species', 'akd_load_more_animal_species' );
add_action( 'wp_ajax_nopriv_akd_load_more_animal_species', 'akd_load_more_animal_species' );

/**
 * Get location of national park from longitude and latitude.
 *
 * @param latitude  $latitude latitude of national park.
 * @param longitude $longitude longitude of national park.
 * @version 1.0.0
 */
function npx_get_location_from_coordinates( $latitude, $longitude ) {
	// External API to get location.
	$url = "https://nominatim.openstreetmap.org/reverse?lat={$latitude}&lon={$longitude}&format=json&accept-language=en";

	// Set user agent in the header.
	$options = [
		'http' => [
			'user_agent' => 'NationalPark/1.0.0',
		],
	];
	$context = stream_context_create( $options );

	// Getting response from API.
	$response  = file_get_contents( $url, false, $context );
	$json_data = json_decode( $response, true );
	return $json_data;
}
