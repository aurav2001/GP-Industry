<?php
/**
 * Site navigation bar (floating "island" or classic full-width).
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_cta_text = gpi_get_option( 'header_cta_text', esc_html__( 'Get a Quote', 'gp-industry' ) );
$gpi_cta_url  = gpi_get_option( 'header_cta_url', '#contact' );
?>

<div class="nova-container header-wrap">
	<div class="header-inner">
		<div class="site-branding">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				?>
				<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="site-title-mark" aria-hidden="true"><?php echo esc_html( mb_substr( get_bloginfo( 'name' ), 0, 1 ) ); ?></span>
					<span class="site-title-text"><?php bloginfo( 'name' ); ?></span>
				</a>
				<?php
			}
			?>
		</div>

		<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'gp-industry' ); ?>">
			<div class="mobile-nav-header">
				<span class="mobile-nav-title"><?php esc_html_e( 'Menu', 'gp-industry' ); ?></span>
				<button class="icon-btn mobile-nav-close" type="button" data-nav-close aria-label="<?php esc_attr_e( 'Close menu', 'gp-industry' ); ?>"><?php gpi_the_icon( 'close', 20 ); ?></button>
			</div>

			<?php
			if ( has_nav_menu( 'primary-menu' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary-menu',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'nav-menu',
						'container'      => false,
						'depth'          => 3,
					)
				);
			} else {
				?>
				<ul id="primary-menu" class="nav-menu">
					<li class="menu-item<?php echo is_front_page() ? ' current-menu-item' : ''; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'gp-industry' ); ?></a></li>
					<?php
					wp_list_pages(
						array(
							'title_li' => '',
							'depth'    => 1,
							'number'   => 5,
						)
					);
					?>
					<?php if ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) : ?>
						<li class="menu-item"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>"><?php esc_html_e( 'Add a menu', 'gp-industry' ); ?></a></li>
					<?php endif; ?>
				</ul>
				<?php
			}
			?>

			<div class="mobile-nav-footer">
				<?php if ( $gpi_cta_text ) : ?>
					<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="btn btn-primary btn-block"><?php echo esc_html( $gpi_cta_text ); ?><?php gpi_the_icon( 'arrow-right', 16 ); ?></a>
				<?php endif; ?>
				<div class="mobile-nav-tools">
					<?php gpi_theme_toggle( esc_html__( 'Theme', 'gp-industry' ) ); ?>
				</div>
				<?php gpi_social_links( 'social-links mobile-social' ); ?>
			</div>
		</nav>

		<div class="header-actions">
			<?php if ( gpi_get_option( 'show_search', true ) ) : ?>
				<button class="icon-btn search-toggle" type="button" aria-label="<?php esc_attr_e( 'Open search', 'gp-industry' ); ?>" aria-controls="search-modal" aria-expanded="false"><?php gpi_the_icon( 'search', 20 ); ?></button>
			<?php endif; ?>

			<?php gpi_theme_toggle(); ?>

			<?php if ( $gpi_cta_text ) : ?>
				<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="btn btn-primary btn-sm header-cta"><?php echo esc_html( $gpi_cta_text ); ?><?php gpi_the_icon( 'arrow-right', 16 ); ?></a>
			<?php endif; ?>

			<button class="icon-btn menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open menu', 'gp-industry' ); ?>">
				<span class="menu-toggle-bars" aria-hidden="true"><span></span><span></span><span></span></span>
			</button>
		</div>
	</div>
</div>
<div class="nav-backdrop" data-nav-close></div>
