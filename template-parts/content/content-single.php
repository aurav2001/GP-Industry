<?php
/**
 * Single post content.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article' ); ?>>
	<header class="article-header">
		<div class="nova-container article-header-inner">
			<?php gpi_breadcrumbs(); ?>
			<?php gpi_entry_categories( 3 ); ?>
			<h1 class="article-title"><?php the_title(); ?></h1>

			<?php if ( has_excerpt() ) : ?>
				<p class="article-lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>

			<div class="article-meta">
				<?php gpi_posted_by( true ); ?>
				<?php gpi_posted_on(); ?>
				<?php gpi_reading_time_tag(); ?>
				<?php if ( comments_open() || get_comments_number() ) : ?>
					<a class="meta-item meta-comments" href="#comments"><?php gpi_the_icon( 'message', 16 ); ?><?php comments_number( esc_html__( 'No comments', 'gp-industry' ), esc_html__( '1 comment', 'gp-industry' ), esc_html__( '% comments', 'gp-industry' ) ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="nova-container">
			<figure class="article-featured-image">
				<?php the_post_thumbnail( 'nova-wide', array( 'loading' => 'eager', 'fetchpriority' => 'high' ) ); ?>
				<?php
				$gpi_caption = get_the_post_thumbnail_caption();
				if ( $gpi_caption ) :
					?>
					<figcaption><?php echo esc_html( $gpi_caption ); ?></figcaption>
				<?php endif; ?>
			</figure>
		</div>
	<?php endif; ?>

	<div class="nova-container">
		<div class="article-body entry-content">
			<?php
			the_content();

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

		<footer class="article-footer">
			<?php gpi_entry_tags(); ?>
			<?php
			if ( gpi_get_option( 'show_share', true ) ) {
				gpi_share_buttons();
			}
			?>
		</footer>
	</div>
</article>
