<?php
/**
 * Comments template.
 *
 * @package GPIndustry
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$gpi_count = get_comments_number();
			printf(
				/* translators: %s: comment count */
				esc_html( _n( '%s Comment', '%s Comments', $gpi_count, 'gp-industry' ) ),
				'<span class="text-gradient">' . esc_html( number_format_i18n( $gpi_count ) ) . '</span>'
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => gpi_icon( 'arrow-left', 14 ) . ' ' . esc_html__( 'Older comments', 'gp-industry' ),
				'next_text' => esc_html__( 'Newer comments', 'gp-industry' ) . ' ' . gpi_icon( 'arrow-right', 14 ),
			)
		);

		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'gp-industry' ); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php comment_form(); ?>
</div>
