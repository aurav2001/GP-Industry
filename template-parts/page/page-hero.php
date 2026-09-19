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

$gpi_split = $args['image'] && has_post_thumbnail();
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
					<?php the_post_thumbnail( 'nova-wide', array( 'loading' => 'eager' ) ); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
