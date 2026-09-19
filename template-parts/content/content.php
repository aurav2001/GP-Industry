<?php
/**
 * Post card used in grids.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_delay = (int) get_query_var( 'gpi_reveal_delay', 0 );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?> data-reveal data-reveal-delay="<?php echo esc_attr( $gpi_delay ); ?>">
	<?php gpi_post_thumbnail(); ?>

	<div class="post-card-body">
		<?php gpi_entry_categories( 2 ); ?>

		<h3 class="post-card-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h3>

		<div class="post-excerpt">
			<?php the_excerpt(); ?>
		</div>

		<div class="post-card-footer">
			<div class="post-card-meta">
				<?php gpi_posted_by( true ); ?>
				<?php gpi_posted_on(); ?>
			</div>
			<span class="post-card-reading"><?php gpi_reading_time_tag(); ?></span>
		</div>
	</div>
</article>
