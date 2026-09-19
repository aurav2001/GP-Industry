<?php
/**
 * Theme setup, supports, menus, widgets and image sizes.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gpi_theme_setup' ) ) :
	/**
	 * Register theme supports.
	 */
	function gpi_theme_setup() {
		load_theme_textdomain( 'gp-industry', GPI_THEME_DIR . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );
		add_editor_style( array( 'assets/css/variables.css', 'assets/css/editor-style.css', gpi_google_fonts_url() ) );

		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
		);

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 64,
				'width'       => 240,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		add_theme_support(
			'post-formats',
			array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio' )
		);

		set_post_thumbnail_size( 1200, 675, true );
		add_image_size( 'nova-card', 720, 405, true );
		add_image_size( 'nova-wide', 1600, 900, true );
		add_image_size( 'nova-thumb', 160, 160, true );

		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary Menu', 'gp-industry' ),
				'footer-menu'  => esc_html__( 'Footer Menu', 'gp-industry' ),
			)
		);

		// Content width fallback for oEmbeds.
		$GLOBALS['content_width'] = 780;
	}
endif;
add_action( 'after_setup_theme', 'gpi_theme_setup' );

/**
 * Google Fonts URL.
 *
 * @return string
 */
function gpi_google_fonts_url() {
	return 'https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap';
}

/**
 * Register widget areas.
 */
function gpi_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'gp-industry' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Shown next to the blog, archive and search pages when "Blog Layout" is set to "With Sidebar".', 'gp-industry' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar(
			array(
				/* translators: %d: footer column number */
				'name'          => sprintf( esc_html__( 'Footer Column %d', 'gp-industry' ), $i ),
				'id'            => 'footer-col-' . $i,
				'description'   => esc_html__( 'Widgets shown in the site footer.', 'gp-industry' ),
				'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="footer-widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}
}
add_action( 'widgets_init', 'gpi_theme_widgets_init' );
