<?php
/**
 * Template Name: Products Page
 * Template Post Type: page
 *
 * Hero + your content + automatic grid of child pages as product cards + Request a Quote CTA.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/page/page-hero', null, array( 'eyebrow' => esc_html__( 'Our solutions', 'gp-industry' ) ) );
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page template-products' ); ?>>
		<?php gpi_the_auto_layout(); ?>

		<?php
		get_template_part(
			'template-parts/page/child-grid',
			null,
			array(
				'eyebrow'   => esc_html__( 'Solutions', 'gp-industry' ),
				'title'     => esc_html__( 'Choose the solution that fits your business', 'gp-industry' ),
				'link_text' => esc_html__( 'View details', 'gp-industry' ),
				'icon'      => 'package',
				'anchor'    => 'products',
			)
		);
		?>
	</article>

	<?php
	get_template_part( 'template-parts/sections/cta' );

endwhile;

get_footer();
