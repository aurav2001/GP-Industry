<?php
/**
 * Reusable page hero for page templates.
 *
 * Accepts $args: eyebrow, title, text, align (center|left), image (bool: show featured image split).
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	isset( $args ) ? $args : array(),
	array(
		'eyebrow' => '',
		'title'   => get_the_title(),
		'text'    => has_excerpt() ? get_the_excerpt() : '',
		'align'   => 'center',
		'image'   => false,
	)
);

$gpi_hero_img = '';
$hero_thumb_id = get_post_thumbnail_id( get_the_ID() );
$hero_thumb_post = $hero_thumb_id ? get_post( $hero_thumb_id ) : null;
$hero_is_synth = $hero_thumb_post && ( false !== strpos( $hero_thumb_post->post_name, 'gpi-demo-' ) || false !== strpos( (string) $hero_thumb_post->guid, 'gpi-demo-' ) );
if ( ! $hero_is_synth && has_post_thumbnail() ) {
	$gpi_hero_img = get_the_post_thumbnail( get_the_ID(), 'nova-wide', array( 'loading' => 'eager' ) );
} else {
	$img_url = function_exists( 'gpi_get_page_image_url' ) ? gpi_get_page_image_url( get_the_ID() ) : '';
	if ( $img_url ) {
		$gpi_hero_img = '<img src="' . esc_url( $img_url ) . '" alt="' . the_title_attribute( array( 'echo' => false ) ) . '" loading="eager">';
	}
}

$gpi_split = (bool) ( $args['image'] && $gpi_hero_img );
?>

<section class="page-hero page-hero-template<?php echo $gpi_split ? ' page-hero-split' : ''; ?> align-<?php echo esc_attr( $args['align'] ); ?>">
	<div class="hero-orbs" aria-hidden="true"><span class="orb orb-1"></span><span class="orb orb-2"></span></div>
	<div class="nova-container page-hero-inner">
		<div class="page-hero-content">
			<?php gpi_breadcrumbs(); ?>
			<?php if ( $args['eyebrow'] ) : ?>
				<span class="section-eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></span>
			<?php endif; ?>
			<h1 class="page-hero-title"><?php echo esc_html( $args['title'] ); ?></h1>
			<?php if ( $args['text'] ) : ?>
				<p class="page-hero-text"><?php echo esc_html( $args['text'] ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( $gpi_split ) : ?>
			<div class="page-hero-media" data-reveal data-reveal-delay="150">
				<div class="hero-media-frame">
					<?php echo $gpi_hero_img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
