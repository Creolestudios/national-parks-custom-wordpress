<?php
/**
 * The template for displaying detail page of National Parks.
 *
 * @version 1.0.0
 * @package npx
 */

get_header();

// Getting required metadata for national park.
$np_id                    = get_the_ID();
$np_name                  = get_the_title( $np_id );
$feature_image            = get_the_post_thumbnail_url( $np_id );
$no_image_thumbnail       = get_field( 'default_post_thumbnail_image', 'option' );
$np_characteristics_title = get_field( 'national_park_characteristics_main_title', $np_id );
$np_characteristics       = get_field( 'national_park_characteristics', $np_id );
$np_popup_gallery         = get_field( 'national_park_popup_gallery', $np_id );
$places_to_stay           = get_field( 'places_to_stay', $np_id );
$faqs_np                  = get_field( 'national_park_faqs', $np_id );
$offering_faqs            = get_field( 'offering_faqs', $np_id );
$latitude                 = trim( get_field( 'latitude', $np_id ) );
$longitude                = trim( get_field( 'longitude', $np_id ) );
$sources                  = get_field( 'sources', $np_id );
$country_obj              = get_field( 'select_country', $np_id );
$continent_obj            = get_field( 'select_continent', $np_id );
$np_trails                = get_field( 'national_park_trails', $np_id );
$np_highlights            = get_field( 'national_park_np_highlights', $np_id );
$country_id               = $country_obj->ID;
$country_name             = $country_obj->post_title;
$continent_name           = $continent_obj->post_title;
$national_park_address    = npx_get_location_from_coordinates( $latitude, $longitude );
$related_national_park    = get_field( 'related_national_park', $np_id );
$overview_title           = str_ireplace( 'National Park', '', $np_name );

if ( isset( $national_park_address['address'] ) ) {
	// Extract country and administrative area names.
	$country = isset( $national_park_address['address']['country'] ) ? $national_park_address['address']['country'] : '';
	$state   = isset( $national_park_address['address']['state'] ) ? $national_park_address['address']['state'] : '';

	// Combine state and country into one array.
	$location = array_filter( [ $state, $country ] );
}

// Places to stay based on national park.
$places_args      = [
	'post_type'  => 'place_to_stay',
	'meta_query' => [
		[
			'key'     => 'national_park_for_place',
			'value'   => $np_id,
			'compare' => 'LIKE',
		],
	],
	'fields'     => 'ids',
];
$available_places = new WP_Query( $places_args );
?>
<main>
	<div class="animaldetail-container">
		<div class="animal-detail-banner-slider-wrapper">
			<div class="banner-inner-title">
				<h1><?php echo esc_html( $np_name ); ?></h1>
				<?php
				// Location of national park from coodinates.
				if ( ! empty( $location ) ) {
					$display_address = implode( ', ', $location );
					?>
						<span><?php echo esc_html( $display_address ); ?></span>
					<?php
				}
				?>
			</div>
			<div class="animal-detail-banner-slider sldier single-item">
				<?php
				if ( ! empty( $feature_image ) ) {
					?>
						<div class="animal-detail-banner-slider-item modal-popup">
							<img class="img-cover " src="<?php echo esc_url( $feature_image ); ?>" alt="<?php echo esc_attr( npx_get_img_alt( $np_id ) ); ?>">
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
		</div>

		<?php echo do_shortcode( '[ads_section_layout layout="horizontal-banner"]' ); ?>

		<?php // National Park main details. ?>
		<div class="species-about-detail">
			<div class="container">
				<div class="species-about-detail-left">
					<h2 class="title-curve black"><?php echo esc_html( trim( $overview_title ) . ' Overview' ); ?></h2>
					<p><?php the_content(); ?></p>
				</div>
				<div class="species-about-detail-right">
					<div class="add-banner square">
						<img class="img-cover" src="<?php echo esc_url( NPX_THEME_URI . '/dist/assets/images/google-ads-sqaure.png' ); ?>" alt="advertisement banner">
					</div>
					<?php
					if ( ! empty( $latitude ) && ! empty( $longitude ) ) {
						?>
							<div class="google-map-direction">
								<h6 class="black"><?php echo esc_html( 'Park Map' ); ?></h6>
								<iframe
									width="450"
									height="250"
									frameborder="0" style="border:0"
									referrerpolicy="no-referrer-when-downgrade"
									src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCnREG7FgQ586zeDgvAWT7D2hFKDCtjOaI&q=<?php echo esc_html( $latitude . ',' . $longitude ); ?>&zoom=7"
									allowfullscreen>
								</iframe>
							</div>
						<?php
					}
					?>
					<div class="add-banner square">
						<img class="img-cover" src="<?php echo esc_url( NPX_THEME_URI . '/dist/assets/images/google-ads-sqaure.png' ); ?>" alt="advertisement banner">
					</div>
				</div>
			</div>
		</div>

		<?php
		// National Park Highlights.
		if ( ! empty( $np_highlights ) ) {
			?>
				<div class="highlights-wrapper">
					<div class="container">
						<h2 class="title-curve black"><?php echo esc_html( $np_name . ' Highlights' ); ?></h2>
					</div>
					<div class="species-characteristics-detail">
						<div class="container">
							<div class="species-characteristics-left">
								<section class="tabs-wrapper">
									<div class="tabs-container">
										<div class="tabs-block">
											<div class="tabs">
												<?php
												$tab_index = 1;
												foreach ( $np_highlights as $np_highlight ) {
													$np_highligh_title   = $np_highlight['highlight_title'];
													$np_inner_highlights = $np_highlight['inner_highlight'];
													$tab_check           = 1 === $tab_index ? 'checked="checked"' : '';
													$tab_class           = 1 === count( $np_inner_highlights ) ? 'single-inner-item' : '';
													?>
														<input type="radio" name="tabs" id="tab<?php echo esc_attr( $tab_index ); ?>" <?php echo esc_attr( $tab_check ); ?>/>
														<label for="tab<?php echo esc_attr( $tab_index ); ?>"><?php echo esc_html( $np_highligh_title ); ?></label>
														<div class="highlighttab tab">
															<div class="hightlight-slider-wrapper <?php echo esc_attr( $tab_class ); ?>">
																<?php
																foreach ( $np_inner_highlights as $np_inner_highlight ) {
																	$inner_highlight_title  = $np_inner_highlight['inner_highlight_title'];
																	$inner_highlight_detail = $np_inner_highlight['inner_highlight_detail'];
																	$inner_highlight_img    = $np_inner_highlight['inner_highlight_image'];
																	?>
																		<div class="item">
																			<div class="left">
																				<div class="jagged modal-popup grey" style="background-image: url(<?php echo esc_url( $inner_highlight_img ); ?>)"> </div>
																			</div>
																			<div class="right">
																				<h5><?php echo esc_html( $inner_highlight_title ); ?></h5>
																				<?php echo wp_kses_post( $inner_highlight_detail ); ?>
																			</div>
																		</div>
																	<?php
																	$tab_index++;
																}
																?>
															</div>
														</div>
												<?php } ?>
											</div>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
			<?php
		}

		// National Park Gallery.
		if ( ! empty( $np_popup_gallery ) ) {
				$gallery_class = count( $np_popup_gallery ) == 3 ? 'picture-gallery' : '';
			?>
				<div class="see-all-picture-wrapper <?php echo esc_attr( $gallery_class ); ?> ">
					<div class="container">
						<h2 class="title-curve white"><?php echo esc_html( $np_name . ' Pictures' ); ?></h2>
						<div class="see-all-picture-item-wrapper img-gallery-magnific">
							<?php
							foreach ( $np_popup_gallery as $key => $image ) {
								?>
								<div class="magnific-img">
									<a class="image-popup-vertical-fit" href="<?php echo esc_url( $image ); ?>" title="">
										<div class="see-all-picture-item">
											<!-- <img class="img-cover" src="<?php // echo esc_url( $image ); ?>" alt="gallery-image"> -->
											<div class="jagged texture-green" style="background-image: url(<?php echo esc_url( $image ); ?>)"> </div>
										</div>
									</a>
								</div>
								<?php
							}
							?>
						</div>
						<div class="btn-wrapper">
							<a href="#" class="btn btn-white see-all-pictures"><?php echo esc_html( 'See All Pictures' ); ?></a>
						</div>
					</div>
				</div>
			<?php
		}
		?>

		<?php // National Park new gallery design. ?>
		<!--<div class="yala-national-park-wrapper see-all-picture-wrapper">
			<div class="container">
				<h2 class="title-curve black"><?php echo esc_html( 'Yala National Park Pictures' ); ?></h2>-->
				<!-- <div class="yala-national-picture-wrapper">
					<div class="yala-national-picture-item">
						<div class="jagged modal-popup white" style="background-image: url(<?php echo esc_url( NPX_THEME_URI . '/dist/assets/images/blog-detail-banner.png' ); ?>)"> </div>
					</div>
					<div class="yala-national-picture-item">
						<div class="jagged modal-popup white" style="background-image: url(<?php echo esc_url( NPX_THEME_URI . '/dist/assets/images/blog-detail-banner.png' ); ?>)"> </div>
					</div>
					<div class="yala-national-picture-item">
						<div class="jagged modal-popup white" style="background-image: url(<?php echo esc_url( NPX_THEME_URI . '/dist/assets/images/blog-detail-banner.png' ); ?>)"> </div>
					</div>
				</div> -->

					<!-- <div class="see-all-picture-item-wrapper img-gallery-magnific">
						<div class="magnific-img">
							<a class="image-popup-vertical-fit">
								<div class="see-all-picture-item">
									<div class="jagged modal-popup white" style="background-image: url(<?php echo esc_url( NPX_THEME_URI . '/dist/assets/images/blog-detail-banner.png' ); ?>)"> </div>
								</div>
							</a>
						</div>
						<div class="magnific-img">
							<a class="image-popup-vertical-fit">
								<div class="see-all-picture-item">
									<div class="jagged modal-popup white" style="background-image: url(<?php echo esc_url( NPX_THEME_URI . '/dist/assets/images/blog-detail-banner.png' ); ?>)"> </div>
								</div>
							</a>
						</div>
						<div class="magnific-img">
							<a class="image-popup-vertical-fit">
								<div class="see-all-picture-item">
									<div class="jagged modal-popup white" style="background-image: url(<?php echo esc_url( NPX_THEME_URI . '/dist/assets/images/blog-detail-banner.png' ); ?>)"> </div>
								</div>
							</a>
						</div>
						<div class="magnific-img">
							<a class="image-popup-vertical-fit">
								<div class="see-all-picture-item">
									<div class="jagged modal-popup white" style="background-image: url(<?php echo esc_url( NPX_THEME_URI . '/dist/assets/images/blog-detail-banner.png' ); ?>)"> </div>
								</div>
							</a>
						</div>
					</div>

				<div class="btn-wrapper">
					<a href="#" class="btn see-all-pictures"><?php echo esc_html( 'See All Pictures' ); ?></a>
				</div>
			</div>
		</div> -->

		<?php
		// National Park Characterstics (Adventure).
		if ( ! empty( $np_characteristics ) ) {
			?>
				<div class="adventure-activity-wrapper">
					<div class="container">
						<h2 class="title-curve black"><?php echo esc_html( $np_characteristics_title ); ?></h2>
					</div>
					<div class="species-characteristics-detail">
						<div class="container">
							<div class="species-characteristics-left">
								<section class="tabs-wrapper">
									<div class="tabs-container">
										<div class="tabs-block">
											<div class="tabs">
												<?php
												$tab_index = 1;
												foreach ( $np_characteristics as $detail ) {
													$characteristic_np       = $detail['characteristic_np'];
													$characteristic_title_np = $detail['characteristic_title_np'];
													$characteristic_detail   = $detail['characteristic_detail_np'];
													$char_np_image           = $detail['national_park_image'];
													$tab_check               = $tab_index == 1 ? 'checked="checked"' : '';
													?>
														<input type="radio" name="characteristic_tabs" id="characteristic_tab<?php echo esc_attr( $tab_index ); ?>" <?php echo esc_attr( $tab_check ); ?>/>
														<label for="characteristic_tab<?php echo esc_attr( $tab_index ); ?>"><?php echo esc_html( $characteristic_np ); ?></label>
														<div class="tab">
															<div class="activity-slider-wrapper">
																<div class="item">
																	<div class="right">
																		<div class="jagged modal-popup white" style="background-image: url(<?php echo esc_url( $char_np_image ); ?>)"> </div>
																	</div>
																	<div class="left">
																		<h5><?php echo esc_html( $characteristic_title_np ); ?></h5>
																		<?php echo wp_kses_post( $characteristic_detail ); ?>
																	</div>
																</div>
															</div>
														</div>
													<?php
													$tab_index++;
												}
												?>
											</div>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
			<?php
		}

		// Places to stay (Lodging and Campsite).
		if ( $available_places->have_posts() ) {
			?>
				<div class="stay-places-wrapper">
					<div class="container">
						<h2 class="title-curve black"><?php echo esc_html( 'Places to Stay' ); ?></h2>
					</div>
					<div class="species-characteristics-detail">
						<div class="container">
							<div class="species-characteristics-left">
								<section class="tabs-wrapper">
									<div class="tabs-container">
										<div class="tabs-block">
											<div class="tabs">
												<?php
												$place_terms = get_terms(
													[
														'taxonomy' => 'place_to_stay_categories',
														'hide_empty' => false,
													]
												);
												if ( ! empty( $place_terms ) ) {
													$tab_index = 0;
													foreach ( $place_terms as $term ) {
														$place_term_id   = $term->term_id;
														$place_term_name = $term->name;
														unset( $places_args['tax_query'] );
														$tax_query                  = [
															[
																'taxonomy' => 'place_to_stay_categories',
																'field'    => 'id',
																'terms'    => $place_term_id,
															],
														];
														$places_args['tax_query'][] = $tax_query;
														$places_query               = new WP_Query( $places_args );
														$places_to_stay             = $places_query->posts;
														if ( ! empty( $places_to_stay ) ) {
															$active_tab = 0 === $tab_index ? 'checked' : '';
															?>
																<input type="radio" name="tab2" id="tab<?php echo esc_attr( $place_term_id ); ?>" <?php echo esc_attr( $active_tab ); ?> />
																<label for="tab<?php echo esc_attr( $place_term_id ); ?>"><?php echo esc_html( $place_term_name ); ?></label>
																<div class="highlighttab tab">
																	<div class="stay-place-slider-wrapper">
																		<?php
																		foreach ( $places_to_stay as $place_to_stay ) {
																			$rating = get_field( 'rating', $place_to_stay );
																			?>
																				<div class="item">
																					<div class="item-content">
																						<div class="left">
																							<div class="jagged modal-popup" style="background-image: url(<?php echo esc_url( NPX_THEME_URI . '/dist/assets/images/blog-detail-banner.png' ); ?>)"> </div>
																						</div>
																						<div class="right">
																							<h5><?php echo esc_html( get_the_title( $place_to_stay ) ); ?></h5>
																							<div class="star-wrapper">
																								<div class='rating-stars'>
																									<ul id='stars'>
																										<?php
																										for ( $rate_index = 1; $rate_index <= 5; $rate_index++ ) {
																											$selected = $rate_index <= $rating ? 'selected' : '';
																											?>
																												<li class='star <?php echo esc_attr( $selected ); ?>' data-value='<?php echo esc_attr( $rate_index ); ?>'>
																													<i class='fa fa-star fa-fw'></i>
																												</li>
																											<?php
																										}
																										?>
																									</ul>
																								</div>
																								<div class="success-box"><?php echo esc_html( $rating ); ?>
																								</div>
																							</div>
																							<?php echo get_post_field( 'post_content', $place_to_stay ); ?>
																							<div class="btn-wrapper">
																								<a href="#" class="btn"><?php echo esc_html( 'Learn More' ); ?></a>
																							</div>
																						</div>
																					</div>
																				</div>
																			<?php
																		}
																		?>
																	</div>
																</div>
															<?php
															$tab_index++;
															wp_reset_postdata();
														}
													}
												}
												?>
											</div>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
			<?php
		}

		// National Park Trails.
		if ( ( ! empty( $np_trails ) ) ) {
			?>
				<div class="national-park-trail">
						<div class="container">
							<h2 class="title-curve black"><?php echo esc_html( $np_name . ' Trails' ); ?></h2>
						</div>
						<div class="national-park-content-wrapper">
							<div class="container">
								<div class="national-park-content-area">
									<div class="national-slider-area">
										<?php foreach ( $np_trails as $np_trail ) { ?>
										<div class="item">
											<div class="left">
												<h5><?php echo esc_html( $np_trail['title'] ); ?></h5>
												<?php echo wp_kses_post( $np_trail['description'] ); ?>
											</div>
											<?php
											if ( ! empty( $np_trail['image'] ) ) {
												?>
													<div class="right">
														<div class="image-area">
															<img src="<?php echo esc_url( $np_trail['image'] ); ?>" alt="national-park-trail-image" />
														</div>
													</div>
												<?php
											}
											?>
										</div>
										<?php } ?>
										<!-- <div class="item">
											<div class="left">
												<h5>Maligne Canyon Loop Trail 2</h5>
												<p>This is a 2.8-mile (4.50 km) loop trail with an elevation gain of 505 feet (153.92 m). The trail travels through dense forests and along with two different scenic bodies of water. A wooden footbridge carries you across a marshy area given you more views of the wilderness area.</p>
											</div>
											<div class="right">
												<div class="image-area">
													<img src="<?php echo esc_url( NPX_THEME_URI . '/dist/assets/images/national-trail-img.png' ); ?>" alt="national-park-trail-image" />
												</div>
											</div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
				</div>
			<?php
		}

		// National Park FAQ's.
		if ( ! empty( $faqs_np ) ) {
			?>
				<div class="faq-wrapper">
					<div class="container">
						<h2 class="title-curve black"><?php echo esc_html( 'FAQ’s' ); ?></h2>
						<div class="faqs">
							<?php
							$faq_index = 1;
							foreach ( $faqs_np as $faq ) {
								$question = $faq['question_np'];
								$answer   = $faq['answer_np'];
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

		// Related national parks.
		if ( ! empty( $related_national_park ) ) {
			?>
				<div class="explore-the-diversity">
					<div class="container">
						<h2 class="title-curve black"><?php echo esc_html( 'Related National Parks' ); ?></h2>
						<div class="explore-the-diversity-card-wrapper">
							<?php
							foreach ( $related_national_park as $related_parks_id ) {
								if ( $related_parks_id != $np_id ) {
									$related_parks_name  = get_the_title( $related_parks_id );
									$related_parks_image = get_the_post_thumbnail_url( $related_parks_id, 'large' );
									$related_parks_image = ! empty( $related_parks_image ) ? $related_parks_image : $no_image_thumbnail;
									$related_parks_url   = get_the_permalink( $related_parks_id );
									?>
										<a href="<?php echo esc_url( $related_parks_url ); ?>" class="explore-the-diversity-card-item">
											<div class="explore-the-diversity-card-img-wrapper">
												<img class="img-cover" src="<?php echo esc_url( $related_parks_image ); ?>" alt="<?php echo esc_attr( npx_get_img_alt( $np_id ) ); ?>">
											</div>
											<h5 class="explore-the-diversity-card-content white"><?php echo esc_html( $related_parks_name ); ?></h5>
										</a>
									<?php
								}
							}
							?>
						</div>
					</div>
				</div>
			<?php
		}

		// Sources.
		if ( ! empty( $sources ) ) {
			?>
				<div class="source-wrapper">
					<div class="container">
						<h6><?php echo esc_html( 'Sources' ); ?></h6>
						<ul>
							<?php
							foreach ( $sources as $source ) {
								?>
									<li><?php echo esc_html( $source['detail'] ); ?></li>
								<?php
							}
							?>
						</ul>
					</div>
				</div>
			<?php
		}

		// National Park Gallery see all div.
		if ( ! empty( $np_popup_gallery ) ) {
			?>
				<div class="animal-gallery-popup-main" style="display:none">
					<div class="animal-gallery-popup-wrapper">
						<div>
							<a href="javascript:void(0)" class="close"></a>
							<div class="slider slider-for">
								<?php
								foreach ( $np_popup_gallery as $image ) {
									?>
										<div><img src="<?php echo esc_url( $image ); ?>" alt="gallery-image"></div>
									<?php
								}
								?>
							</div>
							<!-- <div class="slider slider-nav">
								<?php
								foreach ( $np_popup_gallery as $image ) {
									?>
										<div><img src="<?php echo esc_url( $image ); ?>" alt="gallery-image"></div>
									<?php
								}
								?>
							</div> -->
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
