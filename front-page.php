<?php
/**
 * Front page template: hero, features, static page content, latest posts, CTA.
 *
 * @package GPIndustry
 */

get_header();

if ( gpi_get_option( 'show_hero', true ) ) {
	get_template_part( 'template-parts/sections/hero' );
}

if ( gpi_get_option( 'show_features', true ) ) {
	get_template_part( 'template-parts/sections/features' );
}

if ( gpi_get_option( 'show_stats', true ) ) {
	get_template_part( 'template-parts/sections/stats' );
}

if ( gpi_get_option( 'show_home_about', true ) ) {
	get_template_part( 'template-parts/sections/home-about' );
}

if ( gpi_get_option( 'show_home_products', true ) ) {
	get_template_part( 'template-parts/sections/home-products' );
}

if ( gpi_get_option( 'show_home_industries', true ) ) {
	get_template_part( 'template-parts/sections/home-industries' );
}

if ( gpi_get_option( 'show_home_process', true ) ) {
	get_template_part( 'template-parts/sections/home-process' );
}

// If a static front page is set and has content, show it between sections.
if ( is_page() && have_posts() ) {
	while ( have_posts() ) {
		the_post();
		$gpi_content = trim( get_the_content() );
		if ( $gpi_content ) {
			?>
			<section class="front-page-content section-pad">
				<div class="nova-container">
					<div class="entry-content is-wide">
						<?php the_content(); ?>
					</div>
				</div>
			</section>
			<?php
		}
	}
	wp_reset_postdata();
}

if ( gpi_get_option( 'show_home_testimonials', true ) ) {
	get_template_part( 'template-parts/sections/home-testimonials' );
}

if ( gpi_get_option( 'show_home_clients', true ) ) {
	get_template_part( 'template-parts/sections/home-clients' );
}

if ( gpi_get_option( 'show_home_faq', true ) ) {
	get_template_part( 'template-parts/sections/home-faq' );
}

if ( gpi_get_option( 'show_home_posts', true ) ) {
	get_template_part( 'template-parts/sections/latest-posts' );
}

if ( gpi_get_option( 'show_cta', true ) ) {
	get_template_part( 'template-parts/sections/cta' );
}

get_footer();
