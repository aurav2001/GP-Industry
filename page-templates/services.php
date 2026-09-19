<?php
/**
 * Template Name: Services Page
 * Template Post Type: page
 *
 * Modern landing-page layout: hero + trust strip → quick "at a glance" nav →
 * alternating image/text sections for every child page (service) →
 * your own content (auto-designed) → process → testimonials → FAQ → CTA.
 *
 * Create child pages (Page Attributes → Parent = this page) to add services.
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
			'eyebrow' => esc_html__( 'What we do', 'gp-industry' ),
		)
	);
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page template-services' ); ?>>

		<?php get_template_part( 'template-parts/page/trust-strip' ); ?>

		<?php
		$gpi_has_children = (bool) get_pages( array( 'parent' => get_the_ID(), 'number' => 1 ) );

		if ( $gpi_has_children ) {
			get_template_part(
				'template-parts/page/child-zigzag',
				null,
				array(
					'link_text' => esc_html__( 'Explore service', 'gp-industry' ),
					'icon'      => 'wrench',
				)
			);
		} elseif ( current_user_can( 'edit_pages' ) ) {
			?>
			<div class="nova-container">
				<div class="template-hint">
					<?php gpi_the_icon( 'sparkles', 18 ); ?>
					<?php
					printf(
						wp_kses(
							/* translators: %s: new page URL */
							__( 'Tip: create <a href="%s">child pages</a> under this page (Page Attributes → Parent = this page). Each one becomes a full image + text section here — give it a featured image, an excerpt and a bullet list of highlights. This note is only visible to editors.', 'gp-industry' ),
							array( 'a' => array( 'href' => array() ) )
						),
						esc_url( admin_url( 'post-new.php?post_type=page' ) )
					);
					?>
				</div>
			</div>
			<?php
		}
		?>

		<?php gpi_the_auto_layout(); ?>

		<?php
		if ( gpi_get_option( 'services_show_process', true ) ) {
			get_template_part( 'template-parts/sections/home-process' );
		}
		if ( gpi_get_option( 'services_show_testimonials', true ) ) {
			get_template_part( 'template-parts/sections/home-testimonials' );
		}
		if ( gpi_get_option( 'services_show_faq', true ) ) {
			get_template_part( 'template-parts/sections/home-faq' );
		}
		?>
	</article>

	<?php
	get_template_part( 'template-parts/sections/cta' );

endwhile;

get_footer();
