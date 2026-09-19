<?php
/**
 * Template Name: Blank Canvas (No Title)
 * Template Post Type: page
 *
 * Landing-page style template: no page title, content starts right below the header.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'blank-canvas' ); ?>>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
