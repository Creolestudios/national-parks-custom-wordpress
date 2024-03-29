<?php
/**
 * Template Name: National Park Page
 *
 * Custom template for the national park page.
 *
 * @version 1.0.0
 * @package npx
 */
get_header();

// Get all the continents.
$continent_args = [
	'post_type'      => 'continent',
	'posts_per_page' => -1,
	'fields'         => 'ids',
	'oderby'         => 'title',
	'order'          => 'ASC',
];

// Get the post IDs.
$continent_ids        = get_posts( $continent_args );
$first_continent_id   = $continent_ids[0];
$first_continent      = get_post( $first_continent_id );
$first_continent_name = $first_continent->post_title;

if ( isset( $_GET['category'] ) ) {
	$term_slug            = $_GET['category'];
	$continent            = get_page_by_path( $term_slug, OBJECT, 'continent' );
	$first_continent_id   = $continent->ID;
	$first_continent_name = $continent->post_title;
}
?>
<main>
	<div class="category-main-container">
		<?php get_template_part( 'template-parts/page', 'introduction' ); ?>
		<div class="category-page-wrapper">
			<div class="container">
				<div class="search-wrapper">
					<input type="text" placeholder="Search" id="animal-category-search">
				</div>
				<div class="category-tab-wrapper">
					<ul class="category-tab">
						<?php
						// Display continents.
						if ( ! empty( $continent_ids ) && isset( $continent_ids ) ) {
							foreach ( $continent_ids as $continent_id ) {
								$continent_name = get_the_title( $continent_id );
								$active_class   = $continent_id === $first_continent_id ? 'active' : '';
								?>
									<li class="category-tab-item country-category-list <?php echo esc_attr( $active_class ); ?>" data-term-id="<?php echo esc_attr( $continent_id ); ?>">
										<?php echo esc_html( $continent_name ); ?>
									</li>
								<?php
							}
						}
						?>
					</ul>
				</div>
				<div class="filter-group">
					<?php
					$country_args = [
						'post_type'      => 'country',
						'post_status'    => 'publish',
						'posts_per_page' => -1,
						'meta_query'     => [
							[
								'key'     => 'select_continent',
								'value'   => $first_continent_id,
								'compare' => '=',
							],
						],
						'orderby'        => 'title',
						'order'          => 'ASC',
					];
					$country_qry  = new WP_Query( $country_args );
					if ( $country_qry->have_posts() ) {
						?>
							<div class="country-wrapper">
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
							</div>
						<?php
					}
					?>
					<div class="sorting-wrapper">
						<div class="sorting-btn" data-sort="DESC"><?php echo esc_html( 'SORT Z TO A' ); ?></div>
					</div>
				</div>
				<div class="category-listing-wrapper">
					<?php
					$category_args   = [
						'post_type'      => 'national_park',
						'post_status'    => 'publish',
						'posts_per_page' => 12,
						'orderby'        => 'title',
						'order'          => 'ASC',
						'meta_query'     => [
							[
								'key'     => 'select_continent',
								'value'   => $first_continent_id,
								'compare' => '=',
							],
						],
					];
					$get_countries   = new WP_Query( $category_args );
					$total_countries = $get_countries->found_posts;

					if ( $get_countries->have_posts() ) {
						?>
							<div class="category-listing-card-wrapper" data-park-track="<?php echo esc_attr( $total_countries ); ?>">
								<?php
								while ( $get_countries->have_posts() ) {
									$get_countries->the_post();
									get_template_part( 'template-parts/national', 'park-listing' );
								}
								wp_reset_postdata();
								?>
							</div>
						<?php
					} else {
						?>
							<div class="category-listing-card-wrapper">
								<h3><?php echo esc_html( 'No Data Found' ); ?></h3>
							</div>
						<?php
					}
					?>
					<div class="btn-wrapper">
						<a class="btn btn-brown load-more-country-category" href="#">
							<?php echo esc_html( 'Load More' ); ?>
						</a>
					</div>
					<div class="loader country-category-loader" style="display:none">
						<img src="<?php echo esc_attr( NPX_THEME_URI . '/dist/assets/images/loader.gif' ); ?>" alt="loader">
					</div>
				</div>
				<div class="loader animal-search-loader" style="display:none">
					<img src="<?php echo esc_attr( NPX_THEME_URI . '/dist/assets/images/loader.gif' ); ?>" alt="loader">
				</div>

				<!-- Favorite National Parks -->
				<div class="favorite-farm-animal-wrapper">
					<?php
					$favorite_args  = [
						'post_type'      => 'national_park',
						'posts_per_page' => 4,
						'meta_query'     => [
							[
								'key'     => 'select_continent',
								'value'   => $first_continent_id,
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
						?>
							<h2 class="title-curve black"><?php echo esc_html( 'Favorite ' . $first_continent_name ); ?></h2>
							<div class="farm-animal-list-wrapper">
								<?php
								while ( $favorite_parks->have_posts() ) {
									$favorite_parks->the_post();
									get_template_part( 'template-parts/favorite', 'national-park' );
								}
								?>
							</div>
						<?php
					}
					wp_reset_postdata();
					?>
				</div>
			</div>
		</div>

		<?php
		// Explore wildlife stories.
		$stories_args  = [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 3,
		];
		$stories_query = new WP_Query( $stories_args );
		$blog_page     = get_page_by_title( 'Blogs' );
		$blog_page_url = get_permalink( $blog_page->ID );
		if ( $stories_query->have_posts() ) {
			?>
				<div class="explore-wild-life-wrapper">
					<div class="container">
						<h2 class="title-curve white center"><?php echo esc_html( 'Explore the Parks and Beyond' ); ?></h2>
					</div>
					<div class="explore-wild-life-slider slider">
						<?php
						while ( $stories_query->have_posts() ) {
							$stories_query->the_post();
							$blog_id          = get_the_ID();
							$blog_url         = get_permalink( $blog_id );
							$blog_name        = get_the_title( $blog_id );
							$blog_img         = get_the_post_thumbnail_url( $blog_id, 'large' );
							$blog_author_id   = get_post_field( 'post_author', $blog_id );
							$blog_author_name = get_the_author_meta( 'display_name', $blog_author_id );
							$read_time        = ! empty( get_field( 'read_time', $blog_id ) ) ? get_field( 'read_time', $blog_id ) : '5';
							?>
								<div class="explore-wild-life-slider-item">
									<div class="explore-wild-life-slider-item-img-wrapper">
										<img class="img-cover" src="<?php echo esc_url( $blog_img ); ?>" alt="<?php echo esc_attr( npx_get_img_alt( $blog_id ) ); ?>">
									</div>
									<div class="explore-wild-life-slider-item-content">
										<a href="<?php echo esc_url( $blog_url ); ?>">
											<h6><?php echo esc_html( $blog_name ); ?></h6>
										</a>
										<div class="explore-wild-life-slider-item-author-details">
											<span><?php echo esc_html( $read_time . ' min read |' ); ?></span>
											<span><?php echo esc_html( 'By ' ); ?><strong><?php echo esc_html( $blog_author_name ); ?></strong></span>
										</div>
									</div>
								</div>
							<?php
						}
						wp_reset_postdata();
						?>
					</div>
					<a class="btn btn-white" href="<?php echo esc_url( $blog_page_url ); ?>">
						<?php echo esc_html( 'Read More' ); ?>
					</a>
				</div>
			<?php
		}
		?>
	</div>
</main>
<?php

get_footer();
