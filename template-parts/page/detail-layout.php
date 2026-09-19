<?php
/**
 * Detail page layout: content + sticky sidebar (siblings, contact card, CTA).
 *
 * $args: nav_title_fallback, quote_button
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	isset( $args ) ? $args : array(),
	array(
		'nav_title_fallback' => esc_html__( 'Services', 'gp-industry' ),
		'quote_button'       => esc_html__( 'Request a Quote', 'gp-industry' ),
	)
);

$gpi_parent_id = wp_get_post_parent_id( get_the_ID() );
?>

<div class="nova-container">
	<div class="service-layout">
		<div class="service-main">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="service-featured"><?php the_post_thumbnail( 'nova-wide' ); ?></figure>
			<?php endif; ?>

			<div class="auto-layout-narrow">
				<?php gpi_the_auto_layout(); ?>
			</div>
		</div>

		<aside class="service-sidebar">
			<div class="service-sidebar-inner">
				<?php
				$gpi_siblings = get_pages(
					array(
						'parent'      => $gpi_parent_id ? $gpi_parent_id : get_the_ID(),
						'sort_column' => 'menu_order,post_title',
					)
				);
				if ( $gpi_siblings && count( $gpi_siblings ) > 1 ) :
					?>
					<div class="service-nav-card" data-reveal>
						<h3 class="service-nav-title"><?php echo $gpi_parent_id ? esc_html( get_the_title( $gpi_parent_id ) ) : esc_html( $args['nav_title_fallback'] ); ?></h3>
						<ul class="service-nav">
							<?php foreach ( $gpi_siblings as $gpi_sib ) : ?>
								<li class="<?php echo get_the_ID() === $gpi_sib->ID ? 'is-current' : ''; ?>">
									<a href="<?php echo esc_url( get_permalink( $gpi_sib ) ); ?>"><?php echo esc_html( $gpi_sib->post_title ); ?><?php gpi_the_icon( 'chevron-right', 14 ); ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php get_template_part( 'template-parts/page/contact-card', null, array( 'compact' => true ) ); ?>

				<?php if ( $args['quote_button'] ) : ?>
					<a class="btn btn-primary btn-block btn-lg" href="<?php echo esc_url( gpi_get_option( 'header_cta_url', '#contact' ) ); ?>"><?php gpi_the_icon( 'file', 18 ); ?><?php echo esc_html( $args['quote_button'] ); ?></a>
				<?php endif; ?>
			</div>
		</aside>
	</div>
</div>
