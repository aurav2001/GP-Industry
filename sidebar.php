<?php
/**
 * Blog sidebar.
 *
 * @package GPIndustry
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'gp-industry' ); ?>">
	<div class="sidebar-inner">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
</aside>
