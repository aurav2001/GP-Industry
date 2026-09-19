<?php
/**
 * Template Name: Full Width
 * Template Post Type: page, post
 *
 * Content spans the full container width with no max-width limit.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/content/content-page' );
endwhile;

get_footer();
