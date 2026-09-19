<?php
/**
 * Template Name: About Page
 * Template Post Type: page
 *
 * Split hero (text + featured image) + wide content area for Nova patterns
 * (Stats, Team, Testimonials…) + CTA banner.
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
			'eyebrow' => esc_html__( 'Our company', 'gp-industry' ),
			'align'   => has_post_thumbnail() ? 'left' : 'center',
			'image'   => true,
		)
	);
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page template-about' ); ?>>
		<?php gpi_the_auto_layout(); ?>
		<div class="nova-container">
			<div class="entry-content is-wide">
				<?php
				if ( ! trim( get_the_content() ) && current_user_can( 'edit_pages' ) ) {
					echo '<div class="template-hint">' . gpi_icon( 'sparkles', 18 ) . esc_html__( 'Tip: open the editor, click "+" → Patterns → Nova and insert Our Process, Certifications, Stats, Team or FAQ sections here. This note is only visible to editors.', 'gp-industry' ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
		</div>
	</article>

	<?php
	get_template_part( 'template-parts/sections/cta' );

endwhile;

get_footer();
