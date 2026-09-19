<?php
/**
 * GP-Industry functions and definitions.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GPI_THEME_VERSION', '2.6.0' );
define( 'GPI_THEME_DIR', get_template_directory() );
define( 'GPI_THEME_URI', get_template_directory_uri() );

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
