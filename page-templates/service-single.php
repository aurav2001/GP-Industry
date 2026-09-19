<?php
/**
 * Template Name: Service Detail
 * Template Post Type: page
 *
 * For child pages of a Services page: content + sidebar (sibling services, contact card, quote button).
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();

	$gpi_parent_id = wp_get_post_parent_id( get_the_ID() );

	get_template_part(
		'template-parts/page/page-hero',
		null,
		array(
			'eyebrow' => $gpi_parent_id ? get_the_title( $gpi_parent_id ) : esc_html__( 'Service', 'gp-industry' ),
			'align'   => 'left',
		)
	);
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page template-service-single' ); ?>>
		<?php get_template_part( 'template-parts/page/detail-layout', null, array( 'nav_title_fallback' => esc_html__( 'Services', 'gp-industry' ) ) ); ?>
	</article>
	<?php
	get_template_part( 'template-parts/sections/cta' );

endwhile;

get_footer();
