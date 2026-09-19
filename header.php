<?php
/**
 * The header.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site-wrapper">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'gp-industry' ); ?></a>

	<?php if ( is_singular( 'post' ) && gpi_get_option( 'show_reading_progress', true ) ) : ?>
		<div class="reading-progress" aria-hidden="true"><span></span></div>
	<?php endif; ?>

	<?php
	$gpi_topbar_text = gpi_get_option( 'topbar_text', '' );
	if ( gpi_get_option( 'show_topbar', false ) && $gpi_topbar_text ) :
		$gpi_topbar_link = gpi_get_option( 'topbar_link_url', '' );
		$gpi_topbar_cta  = gpi_get_option( 'topbar_link_text', '' );
		?>
		<div class="topbar" data-topbar-id="<?php echo esc_attr( md5( $gpi_topbar_text . $gpi_topbar_link ) ); ?>">
			<div class="nova-container topbar-inner">
				<span class="topbar-text"><?php gpi_the_icon( 'sparkles', 14 ); ?><?php echo esc_html( $gpi_topbar_text ); ?></span>
				<?php if ( $gpi_topbar_link && $gpi_topbar_cta ) : ?>
					<a class="topbar-link" href="<?php echo esc_url( $gpi_topbar_link ); ?>"><?php echo esc_html( $gpi_topbar_cta ); ?><?php gpi_the_icon( 'arrow-right', 14 ); ?></a>
				<?php endif; ?>
				<button class="topbar-close" type="button" aria-label="<?php esc_attr_e( 'Dismiss', 'gp-industry' ); ?>"><?php gpi_the_icon( 'close', 14 ); ?></button>
			</div>
		</div>
	<?php endif; ?>

	<header id="masthead" class="site-header<?php echo gpi_get_option( 'sticky_header', true ) ? ' is-sticky' : ''; ?>">
		<?php get_template_part( 'template-parts/header/site-nav' ); ?>
	</header>

	<?php if ( gpi_get_option( 'show_search', true ) ) : ?>
		<div class="search-modal" id="search-modal" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search', 'gp-industry' ); ?>" hidden>
			<div class="search-modal-backdrop" data-search-close></div>
			<div class="search-modal-panel">
				<button class="icon-btn search-modal-close" type="button" data-search-close aria-label="<?php esc_attr_e( 'Close search', 'gp-industry' ); ?>"><?php gpi_the_icon( 'close', 22 ); ?></button>
				<p class="search-modal-title"><?php esc_html_e( 'What are you looking for?', 'gp-industry' ); ?></p>
				<?php get_search_form(); ?>
				<p class="search-modal-hint"><?php esc_html_e( 'Press Esc to close', 'gp-industry' ); ?></p>
			</div>
		</div>
	<?php endif; ?>

	<main id="primary" class="site-main">
