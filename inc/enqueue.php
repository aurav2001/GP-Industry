<?php
/**
 * Enqueue scripts and styles.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end assets.
 */
function gpi_theme_scripts() {
	wp_enqueue_style( 'nova-google-fonts', gpi_google_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
	wp_enqueue_style( 'nova-variables', GPI_THEME_URI . '/assets/css/variables.css', array(), GPI_THEME_VERSION );
	wp_enqueue_style( 'nova-main', GPI_THEME_URI . '/assets/css/main.css', array( 'nova-variables' ), GPI_THEME_VERSION );
	wp_enqueue_style( 'nova-style', get_stylesheet_uri(), array( 'nova-main' ), GPI_THEME_VERSION );

	wp_add_inline_style( 'nova-variables', gpi_customizer_css() );

	wp_enqueue_script( 'nova-main', GPI_THEME_URI . '/assets/js/main.js', array(), GPI_THEME_VERSION, true );
	wp_localize_script(
		'nova-main',
		'gpiSettings',
		array(
			'i18n' => array(
				'copied'   => esc_html__( 'Link copied', 'gp-industry' ),
				'openMenu' => esc_html__( 'Open menu', 'gp-industry' ),
				'closeMenu' => esc_html__( 'Close menu', 'gp-industry' ),
			),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gpi_theme_scripts' );

/**
 * Build CSS custom properties from Customizer values.
 *
 * @return string
 */
function gpi_customizer_css() {
	$primary = gpi_sanitize_hex( gpi_get_option( 'accent_color', '#6366f1' ), '#6366f1' );
	$accent  = gpi_sanitize_hex( gpi_get_option( 'accent_color_2', '#ec4899' ), '#ec4899' );
	$radius  = absint( gpi_get_option( 'radius', 16 ) );

	$css  = ':root{';
	$css .= '--color-primary:' . $primary . ';';
	$css .= '--color-primary-rgb:' . gpi_hex_to_rgb( $primary ) . ';';
	$css .= '--color-primary-hover:' . gpi_adjust_brightness( $primary, -20 ) . ';';
	$css .= '--color-accent:' . $accent . ';';
	$css .= '--color-accent-rgb:' . gpi_hex_to_rgb( $accent ) . ';';
	$css .= '--radius-lg:' . $radius . 'px;';
	$css .= '--radius-md:' . max( 6, $radius - 4 ) . 'px;';
	$css .= '--radius-xl:' . ( $radius + 8 ) . 'px;';
	$css .= '}';

	return $css;
}

/**
 * Print the color scheme bootstrap script before styles load to avoid a flash.
 */
function gpi_color_scheme_script() {
	$default = gpi_get_option( 'color_scheme', 'dark' );
	$allow   = gpi_get_option( 'show_theme_toggle', true ) ? 'true' : 'false';
	?>
	<script>
	(function(){
		var d=document.documentElement,def=<?php echo wp_json_encode( $default ); ?>,allow=<?php echo $allow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>,s=null;
		try{ if(allow){ s=localStorage.getItem('gp-industry'); } }catch(e){}
		if(!s){ s = def==='system' ? (window.matchMedia&&window.matchMedia('(prefers-color-scheme: light)').matches?'light':'dark') : def; }
		d.setAttribute('data-theme',s);
	})();
	</script>
	<?php
}
add_action( 'wp_head', 'gpi_color_scheme_script', 0 );

/**
 * Resource hints for Google Fonts.
 *
 * @param array  $urls          URLs.
 * @param string $relation_type Relation.
 * @return array
 */
function gpi_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'gpi_resource_hints', 10, 2 );

/**
 * Customizer live-preview script.
 */
function gpi_customize_preview_js() {
	wp_enqueue_script( 'nova-customizer-preview', GPI_THEME_URI . '/assets/js/customizer-preview.js', array( 'customize-preview' ), GPI_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'gpi_customize_preview_js' );

/**
 * Block editor: apply Customizer colors and the chosen color scheme to the editor canvas.
 * add_editor_style() rewrites ":root" to ".editor-styles-wrapper", so we mirror that here.
 */
function gpi_block_editor_styles() {
	if ( ! is_admin() ) {
		return;
	}

	$css = str_replace( ':root', 'body .editor-styles-wrapper', gpi_customizer_css() );

	$scheme = gpi_get_option( 'color_scheme', 'dark' );
	if ( 'light' === $scheme ) {
		$vars = file_get_contents( GPI_THEME_DIR . '/assets/css/variables.css' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		if ( $vars && preg_match( '/\[data-theme="light"\]\s*\{([^}]+)\}/', $vars, $m ) ) {
			$css .= 'body .editor-styles-wrapper{' . $m[1] . '}';
		}
	}

	wp_register_style( 'nova-editor-vars', false, array(), GPI_THEME_VERSION );
	wp_enqueue_style( 'nova-editor-vars' );
	wp_add_inline_style( 'nova-editor-vars', $css );
}
add_action( 'enqueue_block_assets', 'gpi_block_editor_styles' );
