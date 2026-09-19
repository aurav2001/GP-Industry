<?php
/**
 * Shared posts loop with optional sidebar + pagination.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_sidebar = gpi_has_sidebar();
?>

<div class="content-area<?php echo $gpi_sidebar ? ' with-sidebar' : ''; ?>">
	<div class="content-primary">
		<?php if ( have_posts() ) : ?>
			<div class="posts-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/content', get_post_format() );
				endwhile;
				?>
			</div>

			<?php gpi_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content/content-none' ); ?>
		<?php endif; ?>
	</div>

	<?php
	if ( $gpi_sidebar ) {
		get_sidebar();
	}
	?>
</div>
