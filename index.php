<?php
/**
 * The main template file (blog index).
 *
 * @package GPIndustry
 */

get_header();
?>

<section class="page-hero">
	<div class="nova-container">
		<?php gpi_breadcrumbs(); ?>
		<h1 class="page-hero-title">
			<?php
			if ( is_home() && ! is_front_page() ) {
				single_post_title();
			} else {
				esc_html_e( 'News & Updates', 'gp-industry' );
			}
			?>
		</h1>
		<p class="page-hero-text"><?php esc_html_e( 'Company news, project highlights and industry insights.', 'gp-industry' ); ?></p>
	</div>
</section>

<div class="nova-container section-pad">
	<?php get_template_part( 'template-parts/layout/posts-loop' ); ?>
</div>

<?php
get_footer();
