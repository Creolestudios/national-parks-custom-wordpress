<?php
/**
 * Templpate part for national park listing.
 */

$park_id   = get_the_ID();
$park_url  = get_permalink( $park_id );
$park_name = get_the_title( $park_id );
$park_img  = get_the_post_thumbnail_url( $park_id, 'large' );
?>
<a href="<?php echo esc_url( $park_url ); ?>" class="category-listing-card-item">
	<div class="category-listing-card-img-wrapper">
		<?php
		if ( $park_img ) {
			?>
				<img class="img-cover" src="<?php echo esc_url( $park_img ); ?>" alt="<?php echo esc_attr( npx_get_img_alt( $park_id ) ); ?>">
			<?php
		} else {
			$no_image_thumbnail = get_field( 'default_post_thumbnail_image', 'option' );
			?>
				<img class="img-cover" src="<?php echo esc_url( $no_image_thumbnail ); ?>" alt="no-image-thumbnail">
			<?php
		}
		?>
	</div>
	<h6 class="category-listing-card-content"><?php echo esc_html( $park_name ); ?></h6>
</a>
<?php
