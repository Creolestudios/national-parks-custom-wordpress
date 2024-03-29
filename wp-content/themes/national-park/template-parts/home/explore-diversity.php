<?php
/**
 * Template for explore diversity section.
 */

$selected_post_ids  = get_field( 'explore_the_diversity', get_the_ID() );
$national_parks     = get_page_by_title( 'National Parks' );
$national_parks_url = get_permalink( $national_parks->ID );

if ( ! empty( $selected_post_ids ) && isset( $selected_post_ids ) ) {
	?>
		<div class="explore-the-diversity">
			<div class="container">
				<div class="title-wrapper">
					<h2 class="title-curve black"><?php echo esc_html( "Explore the World's Nationals Parks" ); ?></h2>
					<a class="btn btn-transparent-brown" href="<?php echo esc_url( $national_parks_url ); ?>">
						<?php echo esc_html( 'Explore Now' ); ?>
					</a>
				</div>
				<div class="explore-the-diversity-card-wrapper">
					<?php
					foreach ( $selected_post_ids as $post_id ) {
						$post_slug  = get_post_field( 'post_name', $post_id );
						$post_name  = get_the_title( $post_id );
						$post_url   = $national_parks_url . "?category=$post_slug";
						$post_image = get_the_post_thumbnail_url( $post_id, 'large' );
						?>
							<a href="<?php echo esc_url( $post_url ); ?>" class="explore-the-diversity-card-item diversity-category-detail">
								<div class="explore-the-diversity-card-img-wrapper">
									<?php
									if ( ! empty( $post_image ) ) {
										?>
											<img class="img-cover" src="<?php echo esc_url( $post_image ); ?>" alt="continent-img" >
										<?php
									} else {
										$no_image_thumbnail = get_field( 'default_post_thumbnail_image', 'option' );
										?>
											<img class="img-cover" src="<?php echo esc_url( $no_image_thumbnail ); ?>" alt="no-image-thumbnail" >
										<?php
									}
									?>
								</div>
								<h5 class="explore-the-diversity-card-content"><?php echo esc_html( $post_name ); ?></h5>
							</a>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	<?php
}
?>
