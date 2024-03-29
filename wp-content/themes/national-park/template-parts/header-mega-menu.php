<?php
/**
 * Template for national park mega menu.
 */

// Get all the continents.
$continent_args = [
	'post_type'      => 'continent',
	'posts_per_page' => -1,
	'fields'         => 'ids',
	'oderby'         => 'title',
	'order'          => 'ASC',
];

// Get the post IDs.
$continent_ids      = get_posts( $continent_args );
$first_continent_id = $continent_ids[0];
?>

<div class="menu-popup-wrapper">
	<div class="menu-popup-category-wrapper">
		<ul>
			<?php
			// Display continents.
			if ( ! empty( $continent_ids ) && isset( $continent_ids ) ) {
				foreach ( $continent_ids as $continent_id ) {
					$continent_name = get_the_title( $continent_id );
					$active_class   = $continent_id === $first_continent_id ? 'active' : '';
					?>
						<a href="#">
							<li class="animal-category <?php echo esc_attr( $active_class ); ?>" data-term-id="<?php echo esc_attr( $continent_id ); ?>">
								<?php echo esc_attr( $continent_name ); ?>
							</li>
						</a>
					<?php
				}
			}
			?>
		</ul>
	</div>
		
	<div class="megamenu-category-item-wrapper">
		<?php
		if ( ! empty( $continent_ids ) && isset( $continent_ids ) ) {
			foreach ( $continent_ids as $continent_id ) {
				$continent_name = get_the_title( $continent_id );
				$continent_slug = get_post_field( 'post_name', $continent_id );
				$active_class   = $continent_id === $first_continent_id ? 'flex' : 'none';

				$args = [
					'post_type'      => 'country',
					'posts_per_page' => 14,
					'meta_query'     => [
						[
							'key'     => 'show_on_mega_menu',
							'value'   => true,
							'compare' => '=',
							'type'    => 'BOOLEAN',
						],
						[
							'key'     => 'select_continent',
							'value'   => $continent_id,
							'compare' => '=',
						],
					],
					'orderby'        => 'title',
					'order'          => 'ASC',
				];

				$filtered_posts = new WP_Query( $args );
				if ( $filtered_posts->have_posts() ) {
					?>
					<ul class="megamenu-category-item" data-term-id="<?php echo esc_attr( $continent_id ); ?>" style="display:<?php echo $active_class; ?>">
						<?php
						while ( $filtered_posts->have_posts() ) {
							$filtered_posts->the_post();

							$post_id    = get_the_ID();
							$post_title = get_the_title();
							$post_img   = get_the_post_thumbnail_url( $post_id, 'large' );
							$permalink  = get_permalink();
							?>
							<li>
								<a href="<?php echo esc_url( $permalink ); ?>">
									<?php
									if ( $post_img ) {
										?>
											<img class="img-cover" src="<?php echo esc_url( $post_img ); ?>" alt="<?php echo esc_attr( npx_get_img_alt( $post_id ) ); ?>">
										<?php
									} else {
										$no_image_thumbnail = get_field( 'default_post_thumbnail_image', 'option' );
										?>
											<img class="img-cover" src="<?php echo esc_url( $no_image_thumbnail ); ?>" alt="no-image-thumbnail">
										<?php
									}
									?>
									<span><?php echo esc_html( $post_title ); ?></span>
								</a>
							</li>
							<?php
						}
						?>
						<li class="seeall-cat">
							<a class="seeall-category" data-cat-id="<?php echo esc_attr( $continent_slug ); ?>" href="#"><?php echo esc_html( 'See All ' . $continent_name ); ?></a>
						</li>
					</ul>
					<?php
					wp_reset_postdata();
				}
			}
		}
		?>
	</div>
</div>
