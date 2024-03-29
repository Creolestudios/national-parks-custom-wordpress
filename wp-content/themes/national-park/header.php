<?php
/**
 * Header section of theme.
 *
 * @version 1.0.0
 *
 * @package npx
 */

$default_header_logo = NPX_THEME_URI . '/dist/assets/images/NPA-horizontal.png';
$header_logo         = ! empty( get_field( 'header_logo', 'option' ) ) ? get_field( 'header_logo', 'option' ) : $default_header_logo;
$contact_page        = get_page_by_title( 'Contact' );
$contact_page_url    = get_permalink( $contact_page->ID );
?>

<!Doctype html>
<html <?php language_attributes(); ?>>

<head>
	<link rel="icon" href="<?php echo esc_url( NPX_THEME_URI . '/dist/assets/images/NPA-favicon.png' ); ?>">
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'wp_body_open' ); ?>
	<header>
		<div class="container">
			<div class="header-wrap-main">
				<div class="header-left">
					<div class="logo-wrapper">
						<a href="<?php echo esc_url( home_url() ); ?>">
							<img src="<?php echo esc_url( $header_logo ); ?>" alt="logo">
						</a>
					</div>
					<div class="menu-wrapper">
						<div class="mobile-hamburger-menu">
							<div class="menu-icon" data-menu="1">
								<div class="icon-left"></div>
								<div class="icon-right"></div>
							</div>
						</div>

						<!-- /* for mobile */ -->
						<?php
						$continent_args = [
							'post_type'      => 'continent',
							'posts_per_page' => -1,
							'fields'         => 'ids',
							'oderby'         => 'title',
							'order'          => 'ASC',
						];
						$continent_ids  = get_posts( $continent_args );
						?>
						<div class="mobile-menu">
							<ul>
								<?php
								if ( isset( $continent_ids ) && ! empty( $continent_ids ) ) {
									$first_continent_id = $continent_ids[0];
									foreach ( $continent_ids as $continent_id ) {
										$continent_name = get_the_title( $continent_id );
										$continent_slug = get_post_field( 'post_name', $continent_id );
										$active_class   = $continent_id === $first_continent_id ? 'active' : '';
										?>
											<li class="<?php echo esc_attr( $active_class ); ?>">
												<label>	
													<span><?php echo esc_html( $continent_name ); ?></span>
												</label>
												<ul>
													<?php
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
														while ( $filtered_posts->have_posts() ) {
															$filtered_posts->the_post();

															$post_title = get_the_title();
															$permalink  = get_permalink();
															?>
																<li>
																	<label>	
																		<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $post_title ); ?></a>
																	</label>
																</li>
															<?php
														}
													}
													wp_reset_postdata();
													?>
													<li>
														<label>	
															<a class="seeall-category" data-cat-id="<?php echo esc_attr( $continent_slug ); ?>" href="#"><?php echo esc_html( 'See All ' . $continent_name ); ?></a>
														</label>
													</li>
												</ul>
											</li>
										<?php
									}
								}

								$header_mobile_menu_items = wp_get_nav_menu_items( 'header-mobile-menu' );
								if ( $header_mobile_menu_items ) {
									foreach ( $header_mobile_menu_items as $mobile_item ) {
										$menu_url  = $mobile_item->url;
										$menu_name = $mobile_item->title;
										?>
											<li class="no-ul">
												<label>	
													<a href="<?php echo esc_url( $menu_url ); ?>"><?php echo esc_html( $menu_name ); ?></a>
												</label>
											</li>
										<?php
									}
								}
								?>
							</ul>
						</div>


						<?php
						// Get the menu items for the "header-menu" location.
						$header_menu_items = wp_get_nav_menu_items( 'header-menu' );
						if ( $header_menu_items ) {
							?>
							<ul class="menu-list-item-wrapper">
								<?php
								foreach ( $header_menu_items as $menu_item ) {
									$menu_url     = $menu_item->url;
									$menu_name    = $menu_item->title;
									$has_dropdown = get_field( 'has_dropdown_icon', $menu_item->ID ) ? 'has-subchild' : '';
									$custom_class = get_field( 'custom_class', $menu_item->ID ) ? get_field( 'custom_class', $menu_item->ID ) : '';
									?>
										<li class="<?php echo esc_attr( $has_dropdown ) . ' ' . esc_attr( $custom_class ); ?>">
											<a class="menu-link-main-header" href="<?php echo esc_url( $menu_url ); ?>"><?php echo esc_html( $menu_name ); ?></a>
										</li>
									<?php
								}
								?>
							</ul>
							<?php
						}
						?>
						<!-- Include mega menu  -->
						<?php get_template_part( 'template-parts/header', 'mega-menu' ); ?>
					</div>
				</div>
				<div class="header-right">
					<div class="search-input-wrapper">
						<div class="search-input">
							<input type="text" id="akd-global-search" placeholder="search...">
						</div>
						<a href="<?php echo esc_url( $contact_page_url ); ?>">
							<button class="btn">
								<?php echo esc_html( 'Contact Us' ); ?>
							</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- <svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="0" width="0">
		<defs>
			<filter id="turbulence">
				<feTurbulence type="fractalNoise" baseFrequency=".05" numOctaves="4" />
			</filter>
			<filter id="displacement">
				<feDisplacementMap in="SourceGraphic" scale="6" />
			</filter>
			<filter id="combined">
				<feTurbulence type="fractalNoise" baseFrequency=".05" numOctaves="4" />
				<feDisplacementMap in="SourceGraphic" scale="6" />
			</filter>
		</defs>
	</svg> -->
