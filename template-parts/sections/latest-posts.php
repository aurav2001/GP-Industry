<?php
/**
 * Homepage latest posts.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_query = new WP_Query(
	array(
		'posts_per_page'      => absint( gpi_get_option( 'home_posts_count', 6 ) ),
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

if ( ! $gpi_query->have_posts() ) {
	return;
}

$gpi_blog_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
$gpi_eyebrow  = gpi_get_option( 'home_posts_eyebrow', esc_html__( 'News & updates', 'gp-industry' ) );
$gpi_title    = gpi_get_option( 'home_posts_title', esc_html__( 'Latest from the plant floor', 'gp-industry' ) );
?>

<section id="articles" class="posts-section section-pad">
	<div class="nova-container">
		<div class="section-header" data-reveal>
			<div>
				<?php if ( $gpi_eyebrow ) : ?>
					<span class="section-eyebrow"><?php echo esc_html( $gpi_eyebrow ); ?></span>
				<?php endif; ?>
				<h2 class="section-title"><?php echo esc_html( $gpi_title ); ?></h2>
			</div>
			<?php if ( get_option( 'page_for_posts' ) ) : ?>
				<a href="<?php echo esc_url( $gpi_blog_url ); ?>" class="btn btn-ghost"><?php esc_html_e( 'View all', 'gp-industry' ); ?><?php gpi_the_icon( 'arrow-right', 16 ); ?></a>
			<?php endif; ?>
		</div>

		<div class="posts-grid">
			<?php
			$gpi_index = 0;
			while ( $gpi_query->have_posts() ) :
				$gpi_query->the_post();
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
