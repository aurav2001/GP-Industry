<?php
/**
 * Page content.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-page' ); ?>>
	<header class="page-hero">
		<div class="nova-container">
			<?php gpi_breadcrumbs(); ?>
			<h1 class="page-hero-title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="page-hero-text"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="nova-container">
			<figure class="article-featured-image">
				<?php the_post_thumbnail( 'nova-wide' ); ?>
			</figure>
		</div>
	<?php endif; ?>

	<div class="nova-container">
		<div class="page-body entry-content">
			<?php
			$gpi_raw = get_the_content();
			// If plain content has headings and is not already pre-assembled with complex columns/patterns
			if ( function_exists( 'gpi_auto_layout' ) && preg_match( '/<h[2-4]/i', $gpi_raw ) && ! has_block( 'core/columns' ) ) {
				echo gpi_auto_layout( $gpi_raw ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				the_content();
			}

			wp_link_pages(
				array(
					'before'      => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'gp-industry' ) . '"><span class="page-links-title">' . esc_html__( 'Pages:', 'gp-industry' ) . '</span>',
					'after'       => '</nav>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
				)
			);
			?>
		</div>
	</div>
</article>
