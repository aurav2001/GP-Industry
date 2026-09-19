<?php
/**
 * Related posts (same categories).
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_cats = wp_get_post_categories( get_the_ID(), array( 'fields' => 'ids' ) );

$gpi_related = new WP_Query(
	array(
		'post__not_in'        => array( get_the_ID() ),
		'posts_per_page'      => 3,
		'category__in'        => $gpi_cats,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'orderby'             => 'rand',
	)
);

if ( ! $gpi_related->have_posts() ) {
	wp_reset_postdata();
	return;
}
?>

<section class="related-section section-pad-sm">
	<div class="nova-container">
		<div class="section-header" data-reveal>
			<div>
				<span class="section-eyebrow"><?php esc_html_e( 'Keep reading', 'gp-industry' ); ?></span>
				<h2 class="section-title"><?php esc_html_e( 'Related Articles', 'gp-industry' ); ?></h2>
			</div>
		</div>
		<div class="posts-grid">
			<?php
			$gpi_index = 0;
			while ( $gpi_related->have_posts() ) :
				$gpi_related->the_post();
				set_query_var( 'gpi_reveal_delay', $gpi_index * 70 );
				get_template_part( 'template-parts/content/content' );
				$gpi_index++;
			endwhile;
			wp_reset_postdata();
			set_query_var( 'gpi_reveal_delay', 0 );
			?>
		</div>
	</div>
</section>
