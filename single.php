<?php
/**
 * Single post template.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/content/content-single' );
	?>

	<div class="nova-container">
		<div class="article-extras">
			<?php
			if ( gpi_get_option( 'show_author_box', true ) ) {
				get_template_part( 'template-parts/post/author-box' );
			}

			gpi_post_navigation();
			?>
		</div>
	</div>

	<?php
	if ( gpi_get_option( 'show_related', true ) ) {
		get_template_part( 'template-parts/post/related-posts' );
	}

	if ( comments_open() || get_comments_number() ) :
		?>
		<div class="nova-container">
			<div class="comments-wrapper">
				<?php comments_template(); ?>
			</div>
		</div>
		<?php
	endif;

endwhile;

get_footer();
