<?php
/**
 * Page template.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/content/content-page' );

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
