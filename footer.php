<?php
/**
 * The footer.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_tagline     = gpi_get_option( 'footer_tagline', '' );
$gpi_tagline     = $gpi_tagline ? $gpi_tagline : get_bloginfo( 'description' );
$gpi_has_widgets = is_active_sidebar( 'footer-col-1' ) || is_active_sidebar( 'footer-col-2' ) || is_active_sidebar( 'footer-col-3' );
?>
	</main><!-- #primary -->

	<footer id="colophon" class="site-footer">
		<div class="footer-glow" aria-hidden="true"></div>
		<div class="nova-container">
			<div class="footer-widgets-grid<?php echo $gpi_has_widgets ? '' : ' no-widgets'; ?>">
				<div class="footer-brand">
					<?php if ( has_custom_logo() ) : ?>
						<div class="footer-logo"><?php the_custom_logo(); ?></div>
					<?php else : ?>
						<a class="footer-site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php endif; ?>

					<?php if ( $gpi_tagline ) : ?>
						<p class="footer-tagline"><?php echo esc_html( $gpi_tagline ); ?></p>
					<?php endif; ?>

					<?php gpi_social_links(); ?>
				</div>

				<?php for ( $gpi_i = 1; $gpi_i <= 3; $gpi_i++ ) : ?>
					<?php if ( is_active_sidebar( 'footer-col-' . $gpi_i ) ) : ?>
						<div class="footer-widget-col">
							<?php dynamic_sidebar( 'footer-col-' . $gpi_i ); ?>
						</div>
					<?php endif; ?>
				<?php endfor; ?>

				<?php if ( ! $gpi_has_widgets && has_nav_menu( 'footer-menu' ) ) : ?>
					<div class="footer-widget-col">
						<h4 class="footer-widget-title"><?php esc_html_e( 'Quick Links', 'gp-industry' ); ?></h4>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer-menu',
								'menu_class'     => 'footer-menu',
								'container'      => false,
								'depth'          => 1,
							)
						);
						?>
					</div>
				<?php endif; ?>
			</div>

			<?php get_template_part( 'template-parts/footer/footer-bottom' ); ?>
		</div>
	</footer>
</div><!-- #page -->

<?php if ( gpi_get_option( 'show_back_to_top', true ) ) : ?>
	<button class="back-to-top" type="button" aria-label="<?php esc_attr_e( 'Back to top', 'gp-industry' ); ?>"><?php gpi_the_icon( 'arrow-up', 20 ); ?></button>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
