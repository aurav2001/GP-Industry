<?php
/**
 * Homepage: About / intro split section.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_title = gpi_get_option( 'home_about_title' );
if ( ! $gpi_title ) {
	return;
}
$gpi_image = gpi_get_option( 'home_about_image' );
$gpi_list  = gpi_parse_lines( gpi_get_option( 'home_about_list' ), 1 );
$gpi_btn   = gpi_get_option( 'home_about_btn' );
$gpi_badge = gpi_get_option( 'home_about_badge' );
?>

<section id="about" class="home-about section-pad">
	<div class="nova-container">
		<div class="home-about-grid">
			<div class="home-about-media" data-reveal>
				<div class="home-about-frame">
					<?php if ( $gpi_image ) : ?>
						<img src="<?php echo esc_url( $gpi_image ); ?>" alt="" loading="lazy" decoding="async">
					<?php else : ?>
						<div class="home-about-placeholder"><?php gpi_the_icon( 'factory', 64 ); ?></div>
					<?php endif; ?>
				</div>
				<?php if ( $gpi_badge ) : ?>
					<div class="home-about-badge">
						<span class="home-about-badge-big"><?php echo esc_html( $gpi_badge ); ?></span>
						<span class="home-about-badge-small"><?php echo esc_html( gpi_get_option( 'home_about_badge_2' ) ); ?></span>
					</div>
				<?php endif; ?>
			</div>

			<div class="home-about-content" data-reveal data-reveal-delay="120">
				<?php if ( gpi_get_option( 'home_about_eyebrow' ) ) : ?>
					<span class="section-eyebrow"><?php echo esc_html( gpi_get_option( 'home_about_eyebrow' ) ); ?></span>
				<?php endif; ?>
				<h2 class="section-title"><?php echo esc_html( $gpi_title ); ?></h2>
				<?php if ( gpi_get_option( 'home_about_text' ) ) : ?>
					<p class="section-text"><?php echo esc_html( gpi_get_option( 'home_about_text' ) ); ?></p>
				<?php endif; ?>

				<?php if ( $gpi_list ) : ?>
					<ul class="auto-checklist home-about-list">
						<?php foreach ( $gpi_list as $gpi_item ) : ?>
							<li><?php gpi_the_icon( 'check', 16 ); ?><span><?php echo esc_html( $gpi_item[0] ); ?></span></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $gpi_btn ) : ?>
					<a class="btn btn-primary" href="<?php echo esc_url( gpi_get_option( 'home_about_url' ) ); ?>"><?php echo esc_html( $gpi_btn ); ?><?php gpi_the_icon( 'arrow-right', 16 ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
