<?php
/**
 * Template Name: Product Detail
 * Template Post Type: page
 *
 * For child pages of a Products page: specs/content + sidebar (other products, contact card, quote button).
 * Tip: use the "Nova → Product Specifications" pattern for a spec table.
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
			'eyebrow' => $gpi_parent_id ? get_the_title( $gpi_parent_id ) : esc_html__( 'Product', 'gp-industry' ),
			'align'   => 'left',
		)
	);
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page template-product-single' ); ?>>
		<?php get_template_part( 'template-parts/page/detail-layout', null, array( 'nav_title_fallback' => esc_html__( 'Products', 'gp-industry' ) ) ); ?>
	</article>
	<?php
	get_template_part( 'template-parts/sections/cta' );

endwhile;

get_footer();
