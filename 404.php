<?php
/**
 * 404 template.
 *
 * @package GPIndustry
 */

get_header();
?>

<section class="error-404 not-found section-pad">
	<div class="nova-container error-inner">
		<span class="error-code text-gradient" aria-hidden="true">404</span>
		<h1 class="error-title"><?php esc_html_e( 'Page not found', 'gp-industry' ); ?></h1>
		<p class="error-text"><?php esc_html_e( 'The page you are looking for might have been removed, renamed, or is temporarily unavailable.', 'gp-industry' ); ?></p>

		<div class="error-actions">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-lg"><?php gpi_the_icon( 'home', 18 ); ?><?php esc_html_e( 'Back to home', 'gp-industry' ); ?></a>
			<button type="button" class="btn btn-secondary btn-lg" onclick="history.back()"><?php gpi_the_icon( 'arrow-left', 18 ); ?><?php esc_html_e( 'Go back', 'gp-industry' ); ?></button>
		</div>

		<div class="error-search">
			<p><?php esc_html_e( 'Or try searching for what you need:', 'gp-industry' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</div>
</section>

<?php
$gpi_recent = new WP_Query(
	array(
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
if ( $gpi_recent->have_posts() ) :
	?>
	<section class="section-pad-sm">
		<div class="nova-container">
			<div class="section-header">
				<div>
					<span class="section-eyebrow"><?php esc_html_e( 'Meanwhile', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Recent Articles', 'gp-industry' ); ?></h2>
				</div>
			</div>
			<div class="posts-grid">
				<?php
				while ( $gpi_recent->have_posts() ) :
					$gpi_recent->the_post();
					get_template_part( 'template-parts/content/content' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
	<?php
endif;

get_footer();
