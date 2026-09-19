<?php
/**
 * Grid of child pages as cards (used by Services / Products templates).
 *
 * $args: eyebrow, title, link_text, icon, cta_label
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	isset( $args ) ? $args : array(),
	array(
		'eyebrow'   => esc_html__( 'Our services', 'gp-industry' ),
		'title'     => esc_html__( 'Explore what we offer', 'gp-industry' ),
		'link_text' => esc_html__( 'Learn more', 'gp-industry' ),
		'icon'      => 'layers',
		'anchor'    => 'items',
	)
);

$gpi_children = new WP_Query(
	array(
		'post_type'      => 'page',
		'post_parent'    => get_the_ID(),
		'posts_per_page' => -1,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);

if ( $gpi_children->have_posts() ) :
	?>
	<section id="<?php echo esc_attr( $args['anchor'] ); ?>" class="services-section section-pad">
		<div class="nova-container">
			<?php gpi_section_heading( $args['eyebrow'], $args['title'] ); ?>

			<div class="services-grid">
				<?php
				$gpi_i = 0;
				while ( $gpi_children->have_posts() ) :
					$gpi_children->the_post();
					?>
					<a class="service-card" href="<?php the_permalink(); ?>" data-reveal data-reveal-delay="<?php echo esc_attr( $gpi_i * 70 ); ?>">
						<div class="service-card-media">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'nova-card', array( 'loading' => 'lazy' ) );
							} else {
								echo '<span class="service-card-icon">' . gpi_icon( $args['icon'], 26 ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							}
							?>
						</div>
						<div class="service-card-body">
							<h3 class="service-card-title"><?php the_title(); ?></h3>
							<?php if ( has_excerpt() ) : ?>
								<p class="service-card-text"><?php echo esc_html( get_the_excerpt() ); ?></p>
							<?php endif; ?>
							<span class="service-card-link"><?php echo esc_html( $args['link_text'] ); ?><?php gpi_the_icon( 'arrow-right', 16 ); ?></span>
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
	<?php
elseif ( current_user_can( 'edit_pages' ) ) :
	?>
	<div class="nova-container">
		<div class="template-hint">
			<?php gpi_the_icon( 'sparkles', 18 ); ?>
			<?php
			printf(
				wp_kses(
					/* translators: %s: new page URL */
					__( 'Tip: create <a href="%s">child pages</a> under this page (Page Attributes → Parent = this page) and they will appear here automatically as cards with their featured image and excerpt. Or insert a "GP-Industry Sections" pattern in the editor. This note is only visible to editors.', 'gp-industry' ),
					array( 'a' => array( 'href' => array() ) )
				),
				esc_url( admin_url( 'post-new.php?post_type=page' ) )
			);
			?>
		</div>
	</div>
	<?php
endif;
