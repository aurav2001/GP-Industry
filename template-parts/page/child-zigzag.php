<?php
/**
 * Alternating image / text feature sections built from child pages
 * (modern "landing page" layout). Each child page supplies:
 *   featured image → visual · title · excerpt → description ·
 *   first bullet list in its content → feature checklist.
 *
 * $args: eyebrow_prefix (string), link_text (string), icon (string)
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	isset( $args ) ? $args : array(),
	array(
		'link_text' => esc_html__( 'Learn more', 'gp-industry' ),
		'icon'      => 'wrench',
	)
);

$gpi_children = get_pages(
	array(
		'parent'      => get_the_ID(),
		'sort_column' => 'menu_order,post_title',
	)
);

if ( ! $gpi_children ) {
	return;
}

$gpi_icons = gpi_auto_icons();
?>

<!-- At a glance: quick icon navigation -->
<section class="glance-section">
	<div class="nova-container">
		<div class="glance-grid" data-reveal>
			<?php foreach ( $gpi_children as $gpi_i => $gpi_child ) : ?>
				<a class="glance-item" href="#<?php echo esc_attr( $gpi_child->post_name ); ?>">
					<span class="glance-icon"><?php gpi_the_icon( $gpi_icons[ $gpi_i % count( $gpi_icons ) ], 20 ); ?></span>
					<span class="glance-title"><?php echo esc_html( $gpi_child->post_title ); ?></span>
					<?php gpi_the_icon( 'arrow-right', 14, 'glance-arrow' ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Zigzag feature sections -->
<div class="zigzag">
	<?php foreach ( $gpi_children as $gpi_i => $gpi_child ) : ?>
		<?php
		$gpi_excerpt = $gpi_child->post_excerpt ? $gpi_child->post_excerpt : wp_trim_words( wp_strip_all_tags( strip_shortcodes( $gpi_child->post_content ) ), 40 );
		$gpi_bullets = array();
		if ( preg_match( '/<ul[^>]*>(.*?)<\/ul>/is', $gpi_child->post_content, $gpi_m ) && preg_match_all( '/<li[^>]*>(.*?)<\/li>/is', $gpi_m[1], $gpi_li ) ) {
			$gpi_bullets = array_slice( array_map( 'wp_strip_all_tags', $gpi_li[1] ), 0, 4 );
		}
		$gpi_thumb = get_the_post_thumbnail( $gpi_child->ID, 'nova-wide', array( 'loading' => 'lazy' ) );
		?>
		<section id="<?php echo esc_attr( $gpi_child->post_name ); ?>" class="zigzag-item<?php echo $gpi_i % 2 ? ' is-reversed' : ''; ?>">
			<div class="nova-container zigzag-inner">
				<div class="zigzag-media" data-reveal>
					<div class="zigzag-frame">
						<?php if ( $gpi_thumb ) : ?>
							<?php echo $gpi_thumb; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php else : ?>
							<div class="zigzag-placeholder">
								<span class="zigzag-placeholder-icon"><?php gpi_the_icon( $gpi_icons[ $gpi_i % count( $gpi_icons ) ], 48 ); ?></span>
								<span class="zigzag-placeholder-lines"><span></span><span></span><span></span></span>
							</div>
						<?php endif; ?>
					</div>
					<span class="zigzag-number" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $gpi_i + 1 ) ); ?></span>
				</div>

				<div class="zigzag-content" data-reveal data-reveal-delay="120">
					<span class="section-eyebrow"><?php echo esc_html( sprintf( /* translators: %s: number */ __( 'Service %s', 'gp-industry' ), sprintf( '%02d', $gpi_i + 1 ) ) ); ?></span>
					<h2 class="zigzag-title"><?php echo esc_html( $gpi_child->post_title ); ?></h2>
					<?php if ( $gpi_excerpt ) : ?>
						<p class="zigzag-text"><?php echo esc_html( $gpi_excerpt ); ?></p>
					<?php endif; ?>

					<?php if ( $gpi_bullets ) : ?>
						<ul class="zigzag-list">
							<?php foreach ( $gpi_bullets as $gpi_b ) : ?>
								<li><span class="zigzag-check"><?php gpi_the_icon( 'check', 12 ); ?></span><?php echo esc_html( $gpi_b ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<div class="zigzag-actions">
						<a class="btn btn-primary" href="<?php echo esc_url( get_permalink( $gpi_child ) ); ?>"><?php echo esc_html( $args['link_text'] ); ?><?php gpi_the_icon( 'arrow-right', 16 ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( gpi_get_option( 'header_cta_url' ) ); ?>"><?php esc_html_e( 'Request a proposal', 'gp-industry' ); ?></a>
					</div>
				</div>
			</div>
		</section>
	<?php endforeach; ?>
</div>
