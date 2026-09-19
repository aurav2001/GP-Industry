<?php
/**
 * Search form.
 *
 * @package GPIndustry
 */

$gpi_search_id = wp_unique_id( 'search-form-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $gpi_search_id ); ?>" class="screen-reader-text"><?php esc_html_e( 'Search for:', 'gp-industry' ); ?></label>
	<span class="search-icon"><?php gpi_the_icon( 'search', 18 ); ?></span>
	<input type="search" id="<?php echo esc_attr( $gpi_search_id ); ?>" class="search-field" placeholder="<?php esc_attr_e( 'Search articles…', 'gp-industry' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off">
	<button type="submit" class="search-submit btn btn-primary btn-sm"><?php esc_html_e( 'Search', 'gp-industry' ); ?></button>
</form>
