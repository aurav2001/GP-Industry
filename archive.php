<?php
/**
 * Archive template.
 *
 * @package GPIndustry
 */

get_header();
?>

<section class="page-hero">
	<div class="nova-container">
		<?php gpi_breadcrumbs(); ?>
		<?php
		if ( is_author() ) {
			echo '<div class="archive-author">' . get_avatar( get_the_author_meta( 'ID' ), 96, '', '', array( 'class' => 'archive-avatar' ) ) . '</div>';
		}
		the_archive_title( '<h1 class="page-hero-title">', '</h1>' );
		the_archive_description( '<div class="page-hero-text">', '</div>' );
		?>
		<p class="page-hero-count">
			<?php
			global $wp_query;
			$gpi_total = (int) $wp_query->found_posts;
			/* translators: %s: number of posts */
			echo esc_html( sprintf( _n( '%s article', '%s articles', $gpi_total, 'gp-industry' ), number_format_i18n( $gpi_total ) ) );
			?>
		</p>
	</div>
</section>

<div class="nova-container section-pad">
	<?php get_template_part( 'template-parts/layout/posts-loop' ); ?>
</div>

<?php
get_footer();
