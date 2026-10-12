<?php
/**
 * GP-Industry functions and definitions.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GPI_THEME_VERSION', '3.2.4' );
define( 'GPI_THEME_DIR', get_template_directory() );

/**
 * Protocol-adaptive theme URI helper to prevent ERR_CERT_AUTHORITY_INVALID
 * when domain has no/invalid SSL cert and visitor is on HTTP.
 */
function gpi_get_theme_uri() {
	$uri = get_template_directory_uri();
	if ( ! is_ssl() && ! empty( $_SERVER['HTTP_HOST'] ) ) {
		$uri = str_replace( 'https://' . $_SERVER['HTTP_HOST'], 'http://' . $_SERVER['HTTP_HOST'], $uri );
	}
	// Automatically strip legacy /wordpress/ subfolder if files are in root
	$uri = str_replace( '/wordpress/wp-content', '/wp-content', $uri );
	return $uri;
}
define( 'GPI_THEME_URI', gpi_get_theme_uri() );

// Auto-correct asset URLs if WordPress was moved from /wordpress/ to root
add_filter( 'template_directory_uri', function( $uri ) {
	return str_replace( '/wordpress/wp-content', '/wp-content', $uri );
}, 99 );
add_filter( 'stylesheet_uri', function( $uri ) {
	return str_replace( '/wordpress/wp-content', '/wp-content', $uri );
}, 99 );
add_filter( 'style_loader_src', function( $src ) {
	return str_replace( '/wordpress/wp-content', '/wp-content', $src );
}, 99 );
add_filter( 'script_loader_src', function( $src ) {
	return str_replace( '/wordpress/wp-content', '/wp-content', $src );
}, 99 );

/**
 * Adapt any internal media or asset URL to match current request protocol.
 *
 * @param string $url URL to filter.
 * @return string Filtered URL.
 */
function gpi_protocol_adaptive_url( $url ) {
	if ( empty( $url ) || ! is_string( $url ) ) {
		return $url;
	}
	if ( ! is_ssl() && ! empty( $_SERVER['HTTP_HOST'] ) ) {
		$host = sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) );
		if ( false !== strpos( $url, 'https://' . $host ) ) {
			return str_replace( 'https://' . $host, 'http://' . $host, $url );
		}
	}
	return $url;
}
add_filter( 'wp_get_attachment_url', 'gpi_protocol_adaptive_url', 99 );
add_filter( 'wp_get_attachment_image_src', function( $image ) {
	if ( is_array( $image ) && ! empty( $image[0] ) ) {
		$image[0] = gpi_protocol_adaptive_url( $image[0] );
	}
	return $image;
}, 99 );
add_filter( 'wp_calculate_image_srcset', function( $sources ) {
	if ( is_array( $sources ) ) {
		foreach ( $sources as &$source ) {
			if ( isset( $source['url'] ) ) {
				$source['url'] = gpi_protocol_adaptive_url( $source['url'] );
			}
		}
	}
	return $sources;
}, 99 );
add_filter( 'theme_file_uri', 'gpi_protocol_adaptive_url', 99 );

/**
 * Front-end output filter: when visitor is on HTTP, ensures any internal
 * https://{host}/wp-content/ or uploads links are safely rewritten to http://{host}/
 * so the browser never blocks images or styles due to untrusted/missing SSL certificates.
 */
add_action( 'template_redirect', function() {
	if ( is_admin() ) {
		return;
	}
	if ( ! is_ssl() && ! empty( $_SERVER['HTTP_HOST'] ) ) {
		ob_start( function( $html ) {
			if ( ! is_string( $html ) || empty( $html ) ) {
				return $html;
			}
			$host = preg_quote( sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ), '#' );
			return preg_replace( '#https://(' . $host . '/wp-content/[^"\'\s)>]+)#i', 'http://$1', $html );
		} );
	}
} );

require_once GPI_THEME_DIR . '/inc/theme-setup.php';
require_once GPI_THEME_DIR . '/inc/icons.php';
require_once GPI_THEME_DIR . '/inc/template-functions.php';
require_once GPI_THEME_DIR . '/inc/template-tags.php';
require_once GPI_THEME_DIR . '/inc/enqueue.php';
require_once GPI_THEME_DIR . '/inc/customizer.php';
require_once GPI_THEME_DIR . '/inc/customizer-home.php';
require_once GPI_THEME_DIR . '/inc/block-patterns.php';
require_once GPI_THEME_DIR . '/inc/auto-layout.php';
require_once GPI_THEME_DIR . '/inc/setup-page.php';
require_once GPI_THEME_DIR . '/inc/contact-form.php';
require_once GPI_THEME_DIR . '/inc/makers-mark.php';
