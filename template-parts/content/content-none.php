<?php
/**
 * Empty state.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="no-results not-found">
	<div class="no-results-icon"><?php gpi_the_icon( 'search', 40 ); ?></div>
	<h2 class="no-results-title"><?php esc_html_e( 'Nothing found', 'gp-industry' ); ?></h2>
	<p class="no-results-text">
		<?php
		if ( is_search() ) {
			esc_html_e( 'Sorry, nothing matched your search. Try a different keyword or browse the latest articles.', 'gp-industry' );
		} elseif ( is_home() && current_user_can( 'publish_posts' ) ) {
			printf(
				wp_kses(
					/* translators: %s: link to new post screen */
					__( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'gp-industry' ),
					array( 'a' => array( 'href' => array() ) )
				),
				esc_url( admin_url( 'post-new.php' ) )
			);
		} else {
			esc_html_e( 'It seems we can’t find what you’re looking for. Perhaps searching can help.', 'gp-industry' );
		}
		?>
	</p>
	<div class="no-results-search"><?php get_search_form(); ?></div>
</div>
