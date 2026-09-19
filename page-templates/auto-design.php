<?php
/**
 * Template Name: Designed Sections (Auto)
 * Template Post Type: page
 *
 * Writes plain content? This template turns it into a designed page automatically:
 * H2 = section title, H3 + text = cards with icons/images, lists = checklists, images = wide media.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();

	get_template_part(
		'template-parts/page/page-hero',
		null,
		array(
			'align' => has_post_thumbnail() ? 'left' : 'center',
			'image' => true,
		)
	);
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page template-auto' ); ?>>
		<?php gpi_the_auto_layout(); ?>
	</article>

	<?php
	get_template_part( 'template-parts/sections/cta' );

endwhile;

get_footer();
