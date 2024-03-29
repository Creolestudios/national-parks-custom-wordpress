<?php
/**
 * Template Name: Home Page
 *
 * Custom template for the home page.
 *
 * @version 1.0.0
 * @package akd
 */
get_header();

get_template_part( 'template-parts/home/slider', 'banner' );

get_template_part( 'template-parts/home/love', 'to-explore-about' );

get_template_part( 'template-parts/home/explore', 'diversity' );

get_template_part( 'template-parts/home/highlights' );

get_template_part( 'template-parts/home/explore', 'wild-life' );

get_footer();
