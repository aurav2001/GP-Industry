<?php
/**
 * Search results template.
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
			/* translators: %s: search query */
			printf( esc_html__( 'Results for “%s”', 'gp-industry' ), '<span class="text-gradient">' . esc_html( get_search_query() ) . '</span>' );
			?>
		</h1>
		<p class="page-hero-count">
			<?php
			global $wp_query;
			$gpi_total = (int) $wp_query->found_posts;
			/* translators: %s: number of results */
			echo esc_html( sprintf( _n( '%s result found', '%s results found', $gpi_total, 'gp-industry' ), number_format_i18n( $gpi_total ) ) );
			?>
		</p>
		<div class="page-hero-search"><?php get_search_form(); ?></div>
	</div>
</section>

<div class="nova-container section-pad">
	<?php get_template_part( 'template-parts/layout/posts-loop' ); ?>
</div>

<?php
get_footer();
