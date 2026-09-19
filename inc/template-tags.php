<?php
/**
 * Custom template tags for this theme.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gpi_posted_on' ) ) :
	/**
	 * Post date with icon.
	 */
	function gpi_posted_on() {
		printf(
			'<span class="meta-item meta-date">%1$s<a href="%2$s" rel="bookmark"><time class="entry-date published updated" datetime="%3$s">%4$s</time></a></span>',
			gpi_icon( 'calendar', 16 ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			esc_url( get_permalink() ),
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);
	}
endif;

if ( ! function_exists( 'gpi_posted_by' ) ) :
	/**
	 * Post author with avatar.
	 *
	 * @param bool $avatar Show avatar.
	 */
	function gpi_posted_by( $avatar = false ) {
		$author_id = get_the_author_meta( 'ID' );
		printf(
			'<span class="meta-item meta-author">%1$s<a class="url fn n" href="%2$s">%3$s</a></span>',
			$avatar ? get_avatar( $author_id, 32, '', '', array( 'class' => 'meta-avatar' ) ) : gpi_icon( 'user', 16 ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			esc_url( get_author_posts_url( $author_id ) ),
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'gpi_reading_time_tag' ) ) :
	/**
	 * Reading time meta.
	 */
	function gpi_reading_time_tag() {
		$minutes = gpi_reading_time();
		printf(
			'<span class="meta-item meta-reading">%1$s%2$s</span>',
			gpi_icon( 'clock', 16 ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			/* translators: %d: minutes */
			esc_html( sprintf( _n( '%d min read', '%d min read', $minutes, 'gp-industry' ), $minutes ) )
		);
	}
endif;

if ( ! function_exists( 'gpi_entry_categories' ) ) :
	/**
	 * Category pills.
	 *
	 * @param int $limit Max categories.
	 */
	function gpi_entry_categories( $limit = 1 ) {
		$categories = get_the_category();
		if ( empty( $categories ) ) {
			return;
		}
		echo '<div class="entry-categories">';
		foreach ( array_slice( $categories, 0, $limit ) as $cat ) {
			printf(
				'<a class="category-pill" href="%1$s">%2$s</a>',
				esc_url( get_category_link( $cat->term_id ) ),
				esc_html( $cat->name )
			);
		}
		echo '</div>';
	}
endif;

if ( ! function_exists( 'gpi_entry_tags' ) ) :
	/**
	 * Tag list for single posts.
	 */
	function gpi_entry_tags() {
		$tags = get_the_tags();
		if ( empty( $tags ) || is_wp_error( $tags ) ) {
			return;
		}
		echo '<div class="entry-tags">';
		echo gpi_icon( 'tag', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		foreach ( $tags as $tag ) {
			printf( '<a class="tag-pill" href="%1$s">#%2$s</a>', esc_url( get_tag_link( $tag->term_id ) ), esc_html( $tag->name ) );
		}
		echo '</div>';
	}
endif;

if ( ! function_exists( 'gpi_share_buttons' ) ) :
	/**
	 * Share buttons for single posts.
	 */
	function gpi_share_buttons() {
		$url   = rawurlencode( get_permalink() );
		$title = rawurlencode( get_the_title() );
		$links = array(
			'x'        => array( 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title, 'X' ),
			'facebook' => array( 'https://www.facebook.com/sharer/sharer.php?u=' . $url, 'Facebook' ),
			'linkedin' => array( 'https://www.linkedin.com/sharing/share-offsite/?url=' . $url, 'LinkedIn' ),
		);
		echo '<div class="share-buttons"><span class="share-label">' . esc_html__( 'Share', 'gp-industry' ) . '</span>';
		foreach ( $links as $icon => $data ) {
			printf(
				'<a class="share-btn" href="%1$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s">%3$s</a>',
				esc_url( $data[0] ),
				/* translators: %s: network name */
				esc_attr( sprintf( __( 'Share on %s', 'gp-industry' ), $data[1] ) ),
				gpi_icon( $icon, 16 ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
		printf(
			'<button class="share-btn copy-link" type="button" data-url="%1$s" aria-label="%2$s" data-copied="%3$s">%4$s</button>',
			esc_url( get_permalink() ),
			esc_attr__( 'Copy link', 'gp-industry' ),
			esc_attr__( 'Copied!', 'gp-industry' ),
			gpi_icon( 'link', 16 ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
		echo '</div>';
	}
endif;

if ( ! function_exists( 'gpi_post_thumbnail' ) ) :
	/**
	 * Card thumbnail with placeholder fallback.
	 *
	 * @param string $size Image size.
	 */
	function gpi_post_thumbnail( $size = 'nova-card' ) {
		if ( post_password_required() || is_attachment() ) {
			return;
		}
		echo '<div class="post-thumbnail-wrap">';
		echo '<a class="post-thumbnail" href="' . esc_url( get_permalink() ) . '" aria-hidden="true" tabindex="-1">';
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( $size, array( 'loading' => 'lazy', 'alt' => the_title_attribute( array( 'echo' => false ) ) ) );
		} else {
			echo '<span class="thumb-placeholder">' . gpi_icon( 'sparkles', 36 ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo '</a>';
		if ( is_sticky() && ! is_paged() ) {
			echo '<span class="sticky-badge">' . gpi_icon( 'star', 12 ) . esc_html__( 'Featured', 'gp-industry' ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo '</div>';
	}
endif;

if ( ! function_exists( 'gpi_breadcrumbs' ) ) :
	/**
	 * Simple breadcrumb trail.
	 */
	function gpi_breadcrumbs() {
		if ( is_front_page() || ! gpi_get_option( 'show_breadcrumbs', true ) ) {
			return;
		}

		$items   = array();
		$items[] = '<a href="' . esc_url( home_url( '/' ) ) . '">' . gpi_icon( 'home', 14 ) . '<span>' . esc_html__( 'Home', 'gp-industry' ) . '</span></a>';

		if ( is_home() ) {
			$items[] = '<span aria-current="page">' . esc_html( single_post_title( '', false ) ) . '</span>';
		} elseif ( is_singular( 'post' ) ) {
			$cats = get_the_category();
			if ( ! empty( $cats ) ) {
				$items[] = '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cats[0]->name ) . '</a>';
			}
			$items[] = '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>';
		} elseif ( is_page() ) {
			$ancestors = array_reverse( get_post_ancestors( get_the_ID() ) );
			foreach ( $ancestors as $ancestor ) {
				$items[] = '<a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a>';
			}
			$items[] = '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>';
		} elseif ( is_singular() ) {
			$items[] = '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>';
		} elseif ( is_search() ) {
			$items[] = '<span aria-current="page">' . esc_html__( 'Search', 'gp-industry' ) . '</span>';
		} elseif ( is_404() ) {
			$items[] = '<span aria-current="page">' . esc_html__( 'Not found', 'gp-industry' ) . '</span>';
		} elseif ( is_archive() ) {
			$items[] = '<span aria-current="page">' . wp_strip_all_tags( get_the_archive_title() ) . '</span>';
		}

		echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'gp-industry' ) . '">';
		echo implode( '<span class="crumb-sep">' . gpi_icon( 'chevron-right', 12 ) . '</span>', $items ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</nav>';
	}
endif;

if ( ! function_exists( 'gpi_pagination' ) ) :
	/**
	 * Numbered pagination.
	 */
	function gpi_pagination() {
		the_posts_pagination(
			array(
				'mid_size'           => 1,
				'prev_text'          => gpi_icon( 'arrow-left', 16 ) . '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'gp-industry' ) . '</span>',
				'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Next page', 'gp-industry' ) . '</span>' . gpi_icon( 'arrow-right', 16 ),
				'screen_reader_text' => esc_html__( 'Posts navigation', 'gp-industry' ),
				'class'              => 'nova-pagination',
			)
		);
	}
endif;

if ( ! function_exists( 'gpi_post_navigation' ) ) :
	/**
	 * Previous / next post cards.
	 */
	function gpi_post_navigation() {
		$prev = get_previous_post();
		$next = get_next_post();
		if ( ! $prev && ! $next ) {
			return;
		}
		echo '<nav class="post-navigation" aria-label="' . esc_attr__( 'Post navigation', 'gp-industry' ) . '">';
		if ( $prev ) {
			printf(
				'<a class="post-nav-card prev" href="%1$s"><span class="post-nav-label">%2$s %3$s</span><span class="post-nav-title">%4$s</span></a>',
				esc_url( get_permalink( $prev ) ),
				gpi_icon( 'arrow-left', 14 ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				esc_html__( 'Previous', 'gp-industry' ),
				esc_html( get_the_title( $prev ) )
			);
		} else {
			echo '<span></span>';
		}
		if ( $next ) {
			printf(
				'<a class="post-nav-card next" href="%1$s"><span class="post-nav-label">%2$s %3$s</span><span class="post-nav-title">%4$s</span></a>',
				esc_url( get_permalink( $next ) ),
				esc_html__( 'Next', 'gp-industry' ),
				gpi_icon( 'arrow-right', 14 ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				esc_html( get_the_title( $next ) )
			);
		}
		echo '</nav>';
	}
endif;

if ( ! function_exists( 'gpi_social_links' ) ) :
	/**
	 * Social icon links from Customizer.
	 *
	 * @param string $class Wrapper class.
	 */
	function gpi_social_links( $class = 'social-links' ) {
		$output = '';
		foreach ( gpi_social_networks() as $key => $label ) {
			$url = gpi_get_option( 'social_' . $key, '' );
			if ( ! $url ) {
				continue;
			}
			$output .= sprintf(
				'<a href="%1$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s">%3$s</a>',
				esc_url( $url ),
				esc_attr( $label ),
				gpi_icon( $key, 18 )
			);
		}
		if ( $output ) {
			echo '<div class="' . esc_attr( $class ) . '">' . $output . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif;

if ( ! function_exists( 'gpi_theme_toggle' ) ) :
	/**
	 * Dark / light toggle button.
	 */
	function gpi_theme_toggle( $label = '' ) {
		if ( ! gpi_get_option( 'show_theme_toggle', true ) ) {
			return;
		}
		printf(
			'<button class="%4$s" type="button" aria-label="%1$s" title="%1$s">%2$s%3$s%5$s</button>',
			esc_attr__( 'Toggle dark / light mode', 'gp-industry' ),
			gpi_icon( 'sun', 20, 'icon-sun' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			gpi_icon( 'moon', 20, 'icon-moon' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$label ? 'btn btn-secondary btn-sm theme-toggle theme-toggle-labelled' : 'icon-btn theme-toggle',
			$label ? '<span>' . esc_html( $label ) . '</span>' : ''
		);
	}
endif;

if ( ! function_exists( 'gpi_section_heading' ) ) :
	/**
	 * Section eyebrow + title + optional text.
	 *
	 * @param string $eyebrow Small label.
	 * @param string $title   Heading.
	 * @param string $text    Paragraph.
	 * @param string $align   center|left.
	 */
	function gpi_section_heading( $eyebrow, $title, $text = '', $align = 'center' ) {
		if ( ! $title && ! $eyebrow ) {
			return;
		}
		echo '<div class="section-heading align-' . esc_attr( $align ) . '" data-reveal>';
		if ( $eyebrow ) {
			echo '<span class="section-eyebrow">' . esc_html( $eyebrow ) . '</span>';
		}
		if ( $title ) {
			echo '<h2 class="section-title">' . esc_html( $title ) . '</h2>';
		}
		if ( $text ) {
			echo '<p class="section-text">' . esc_html( $text ) . '</p>';
		}
		echo '</div>';
	}
endif;
