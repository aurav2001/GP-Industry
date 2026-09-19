<?php
/**
 * Homepage: product / service cards from a page's child pages.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_parent = gpi_home_products_page_id();
if ( ! $gpi_parent ) {
	return;
}

$gpi_query = new WP_Query(
	array(
		'post_type'      => 'page',
		'post_parent'    => $gpi_parent,
		'posts_per_page' => absint( gpi_get_option( 'home_products_count', 6 ) ),
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);
if ( ! $gpi_query->have_posts() ) {
	return;
}
?>

<section id="products" class="home-products section-pad">
	<div class="nova-container">
		<div class="section-header" data-reveal>
			<div>
				<?php if ( gpi_get_option( 'home_products_eyebrow' ) ) : ?>
					<span class="section-eyebrow"><?php echo esc_html( gpi_get_option( 'home_products_eyebrow' ) ); ?></span>
				<?php endif; ?>
				<h2 class="section-title"><?php echo esc_html( gpi_get_option( 'home_products_title' ) ); ?></h2>
			</div>
			<a href="<?php echo esc_url( get_permalink( $gpi_parent ) ); ?>" class="btn btn-ghost"><?php esc_html_e( 'View all', 'gp-industry' ); ?><?php gpi_the_icon( 'arrow-right', 16 ); ?></a>
		</div>

		<div class="services-grid">
			<?php
			$gpi_i = 0;
			while ( $gpi_query->have_posts() ) :
				$gpi_query->the_post();
				?>
				<a class="service-card" href="<?php the_permalink(); ?>" data-reveal data-reveal-delay="<?php echo esc_attr( $gpi_i * 70 ); ?>">
					<div class="service-card-media">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'nova-card', array( 'loading' => 'lazy' ) );
						} else {
							echo '<span class="service-card-icon">' . gpi_icon( 'package', 26 ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						?>
					</div>
					<div class="service-card-body">
						<h3 class="service-card-title"><?php the_title(); ?></h3>
						<?php if ( has_excerpt() ) : ?>
							<p class="service-card-text"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>
						<span class="service-card-link"><?php esc_html_e( 'View details', 'gp-industry' ); ?><?php gpi_the_icon( 'arrow-right', 16 ); ?></span>
					</div>
				</a>
				<?php
				$gpi_i++;
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
