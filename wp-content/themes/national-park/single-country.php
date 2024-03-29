<?php
/**
 * The template for displaying detail page of Countries.
 *
 * @version 1.0.0
 * @package npx
 */

get_header();

$country_id         = get_the_ID();
$country_name       = get_the_title( $country_id );
$country_gallery    = get_field( 'country_gallery', $country_id );
$feature_image      = get_the_post_thumbnail_url( $country_id );
$no_image_thumbnail = get_field( 'default_post_thumbnail_image', 'option' );
$country_faqs       = get_field( 'faqs_of_country', $country_id );
$national_parks     = get_field( 'national_parks', $country_id );
?>

<main>
	<div class="animaldetail-container">
		<div class="animal-detail-banner-slider-wrapper">
			<div class="banner-inner-title"><?php the_title(); ?></div>
			<?php
			if ( ! empty( $country_gallery ) ) {
				?>
					<div class="animal-detail-banner-slider sldier">
						<?php
						foreach ( $country_gallery as $image ) {
							?>
								<a class="animal-detail-banner-slider-item image-popup-vertical-fit" href="<?php echo esc_url( $image ); ?>">
									<img class="img-cover" src="<?php echo esc_url( $image ); ?>" alt="animal-gallery">
								</a>
							<?php
						}
						?>
					</div>
				<?php
			} else {
				?>
					<div class="animal-detail-banner-slider sldier single-item">
						<?php
						if ( ! empty( $feature_image ) ) {
							?>
								<div class="animal-detail-banner-slider-item modal-popup">
									<img class="img-cover" src="<?php echo esc_url( $feature_image ); ?>" alt="<?php echo esc_attr( npx_get_img_alt( $country_id ) ); ?>">
								</div>
							<?php
						} else {
							?>
								<div class="animal-detail-banner-slider-item">
									<img class="img-cover" src="<?php echo esc_url( $no_image_thumbnail ); ?>" alt="thumbnail-image">
								</div>
							<?php
						}
						?>
					</div>
				<?php
			}
			?>
		</div>

		<?php echo do_shortcode( '[ads_section_layout layout="horizontal-banner"]' ); ?>

		<div class="container">
			<div class="about-animal-detail-wrapper">
				<div class="about-animal-detail">
					<h2 class="title-curve black"><?php echo esc_html( 'About ' . $country_name . ' National Parks' ); ?></h2>
					<div class="animal-content">
						<?php the_content(); ?>
					</div>
				</div>
				<div class="about-animal-detail-sidebar">
					<?php echo do_shortcode( '[ads_section_layout layout="vertical-banner" class="vertical"]' ); ?>
				</div>
			</div>
		</div>

		<?php
		// National Parks.
		if ( ! empty( $national_parks ) ) {
			?>
				<div class="types-of-cat">
					<div class="container">
						<h2 class="title-curve white"><?php echo esc_html( $country_name . "'s National Parks" ); ?></h2>
						<div class="type-of-cat-item-wrapper">
							<?php
							foreach ( $national_parks as $detail ) {
								$np_name    = $detail['title'];
								$np_image   = $detail['image'];
								$np_content = $detail['description'];
								$np_id      = $detail['select_page'][0];
								?>
									<div class="type-of-cat-item">
										<div class="type-of-cat-img-wrapper combined">
											<?php
											if ( ! empty( $np_image ) ) {
												?>
													<img class="img-cover modal-popup" src="<?php echo esc_url( $np_image ); ?>" alt="<?php echo esc_attr( npx_get_img_alt( $np_id ) ); ?>">
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
											<h4><?php echo esc_html( $np_name ); ?></h4>
											<p><?php echo esc_html( $np_content ); ?></p>
											<?php
											if ( ! empty( $np_id ) ) {
												$species_url = get_permalink( $np_id );
												?>
													<a href="<?php echo esc_url( $species_url ); ?>" class="btn btn-transparent-white"><?php echo esc_html( 'Explore Now' ); ?></a>
												<?php
											}
											?>
										</div>
									</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			<?php
		}

		// Country's faq section
		if ( ! empty( $country_faqs ) ) {
			?>
				<div class="faq-wrapper">
					<div class="container">
						<h2 class="title-curve black"><?php echo esc_html( 'FAQ’s' ); ?></h2>
						<div class="faqs">
							<?php
							$faq_index = 1;
							foreach ( $country_faqs as $faq ) {
								$question = $faq['question'];
								$answer   = $faq['answer'];
								$active   = $faq_index == 1 ? 'active' : '';
								?>
									<div class="faq <?php echo esc_attr( $active ); ?>">
										<div class="header">
											<h3><?php echo esc_html( $faq_index . '. ' . $question ); ?></h3>
											<div class="arrow"></div>
										</div>
										<div class="content">
											<p><?php echo wp_kses_post( $answer ); ?></p>
										</div>
									</div>
								<?php
								$faq_index++;
							}
							?>
						</div>
					</div>
				</div>
			<?php
		}
		?>
	</div>
</main>
<?php
get_footer();
