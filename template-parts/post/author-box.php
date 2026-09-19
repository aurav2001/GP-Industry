<?php
/**
 * Author box shown after a single post.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_author_id = get_the_author_meta( 'ID' );
$gpi_bio       = get_the_author_meta( 'description' );
$gpi_website   = get_the_author_meta( 'url' );
?>

<div class="author-box" data-reveal>
	<div class="author-box-avatar">
		<?php echo get_avatar( $gpi_author_id, 96 ); ?>
	</div>
	<div class="author-box-content">
		<span class="author-box-label"><?php esc_html_e( 'Written by', 'gp-industry' ); ?></span>
		<h3 class="author-box-name"><a href="<?php echo esc_url( get_author_posts_url( $gpi_author_id ) ); ?>"><?php the_author(); ?></a></h3>
		<?php if ( $gpi_bio ) : ?>
			<p class="author-box-bio"><?php echo esc_html( $gpi_bio ); ?></p>
		<?php endif; ?>
		<div class="author-box-links">
			<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( get_author_posts_url( $gpi_author_id ) ); ?>"><?php esc_html_e( 'All posts', 'gp-industry' ); ?><?php gpi_the_icon( 'arrow-right', 14 ); ?></a>
			<?php if ( $gpi_website ) : ?>
				<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( $gpi_website ); ?>" target="_blank" rel="noopener noreferrer"><?php gpi_the_icon( 'globe', 14 ); ?><?php esc_html_e( 'Website', 'gp-industry' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>
