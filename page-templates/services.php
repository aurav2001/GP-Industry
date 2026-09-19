<?php
/**
 * Template Name: Services Page
 * Template Post Type: page
 *
 * Hero + your content (Nova patterns) + automatic grid of child pages as service cards + CTA.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/page/page-hero', null, array( 'eyebrow' => esc_html__( 'What we do', 'gp-industry' ) ) );
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page template-services' ); ?>>
		<?php gpi_the_auto_layout(); ?>

		<?php
		get_template_part(
			'template-parts/page/child-grid',
			null,
			array(
				'eyebrow'   => esc_html__( 'Our services', 'gp-industry' ),
				'title'     => esc_html__( 'Industrial services we provide', 'gp-industry' ),
				'link_text' => esc_html__( 'Learn more', 'gp-industry' ),
				'icon'      => 'wrench',
				'anchor'    => 'services',
			)
		);
		?>
	</article>

	<?php
	get_template_part( 'template-parts/sections/cta' );

endwhile;

get_footer();
