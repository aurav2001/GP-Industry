<?php
/**
 * Homepage hero.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_badge    = gpi_get_option( 'hero_badge', esc_html__( 'ISO 9001:2015 Certified Manufacturer', 'gp-industry' ) );
$gpi_title    = gpi_get_option( 'hero_title', 'Engineering excellence for <span>every industry</span>' );
$gpi_subtitle = gpi_get_option( 'hero_subtitle', esc_html__( 'Precision manufacturing, industrial solutions and reliable supply — delivered on time, every time. Trusted by leading companies for over two decades.', 'gp-industry' ) );
$gpi_btn1     = gpi_get_option( 'hero_btn1_text', esc_html__( 'Request a Quote', 'gp-industry' ) );
$gpi_btn1_url = gpi_get_option( 'hero_btn1_url', '#contact' );
$gpi_btn2     = gpi_get_option( 'hero_btn2_text', esc_html__( 'Our Products', 'gp-industry' ) );
$gpi_btn2_url = gpi_get_option( 'hero_btn2_url', '#products' );
$gpi_image    = gpi_get_option( 'hero_image', '' );

$gpi_slides = array();
if ( gpi_get_option( 'hero_slider_enable', true ) ) {
	for ( $gpi_i = 1; $gpi_i <= 5; $gpi_i++ ) {
		$gpi_slide = gpi_get_option( "hero_bg_{$gpi_i}", '' );
		if ( $gpi_slide ) {
			$gpi_slides[] = $gpi_slide;
		}
	}
}
$gpi_has_slider = ! empty( $gpi_slides );
$gpi_overlay    = min( 90, absint( gpi_get_option( 'hero_slider_overlay', 60 ) ) ) / 100;
$gpi_classes    = 'hero-section';
if ( $gpi_has_slider ) {
	$gpi_classes .= ' has-slider';
	if ( gpi_get_option( 'hero_slider_kenburns', true ) ) {
		$gpi_classes .= ' has-kenburns';
	}
}
?>

<section class="<?php echo esc_attr( $gpi_classes ); ?>" id="hero"<?php echo $gpi_has_slider ? ' style="--hero-overlay:' . esc_attr( $gpi_overlay ) . '"' : ''; ?>>
	<?php if ( $gpi_has_slider ) : ?>
		<div class="hero-slides" aria-hidden="true" data-interval="<?php echo esc_attr( max( 2, absint( gpi_get_option( 'hero_slider_interval', 5 ) ) ) * 1000 ); ?>">
			<?php foreach ( $gpi_slides as $gpi_index => $gpi_slide ) : ?>
				<?php if ( 0 === $gpi_index ) : ?>
					<div class="hero-slide is-active" style="background-image:url('<?php echo esc_url( $gpi_slide ); ?>')"></div>
				<?php else : ?>
					<div class="hero-slide" data-bg="<?php echo esc_url( $gpi_slide ); ?>"></div>
				<?php endif; ?>
			<?php endforeach; ?>
			<div class="hero-overlay"></div>
		</div>
		<?php if ( count( $gpi_slides ) > 1 && gpi_get_option( 'hero_slider_dots', true ) ) : ?>
			<div class="hero-dots" aria-label="<?php esc_attr_e( 'Slides', 'gp-industry' ); ?>">
				<?php foreach ( $gpi_slides as $gpi_index => $gpi_slide ) : ?>
					<?php /* translators: %d: slide number */ ?>
					<button class="hero-dot<?php echo 0 === $gpi_index ? ' is-active' : ''; ?>" type="button" data-slide="<?php echo esc_attr( $gpi_index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'gp-industry' ), $gpi_index + 1 ) ); ?>"></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<div class="hero-orbs" aria-hidden="true">
		<span class="orb orb-1"></span>
		<span class="orb orb-2"></span>
		<span class="orb orb-3"></span>
	</div>
	<div class="hero-grid" aria-hidden="true"></div>

	<div class="nova-container hero-inner">
		<?php if ( $gpi_badge ) : ?>
			<div class="hero-badge" data-reveal><?php gpi_the_icon( 'sparkles', 14 ); ?><span class="hero-badge-text"><?php echo esc_html( $gpi_badge ); ?></span></div>
		<?php endif; ?>

		<h1 class="hero-title" data-reveal data-reveal-delay="100"><?php echo wp_kses( $gpi_title, gpi_hero_allowed_html() ); ?></h1>

		<?php if ( $gpi_subtitle ) : ?>
			<p class="hero-subtitle" data-reveal data-reveal-delay="200"><?php echo esc_html( $gpi_subtitle ); ?></p>
		<?php endif; ?>

		<?php if ( $gpi_btn1 || $gpi_btn2 ) : ?>
			<div class="hero-actions" data-reveal data-reveal-delay="300">
				<?php if ( $gpi_btn1 ) : ?>
					<a href="<?php echo esc_url( $gpi_btn1_url ); ?>" class="btn btn-primary btn-lg"><?php echo esc_html( $gpi_btn1 ); ?><?php gpi_the_icon( 'arrow-right', 18 ); ?></a>
				<?php endif; ?>
				<?php if ( $gpi_btn2 ) : ?>
					<a href="<?php echo esc_url( $gpi_btn2_url ); ?>" class="btn btn-secondary btn-lg"><?php echo esc_html( $gpi_btn2 ); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $gpi_image ) : ?>
			<div class="hero-media" data-reveal data-reveal-delay="400">
				<div class="hero-media-frame">
					<img src="<?php echo esc_url( $gpi_image ); ?>" alt="" loading="eager" decoding="async">
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
