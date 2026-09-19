<?php
/**
 * Auto layout: turns plain page content (headings, paragraphs, lists, images)
 * into designed sections — section headings, icon/image cards, checklists,
 * split text blocks — without the user having to use patterns.
 *
 * Rules (top-level content only; block patterns / columns / groups pass through untouched):
 *  - H2 (or H1)         → starts a new section. A short paragraph right before it becomes the eyebrow,
 *                         the first paragraph after it becomes the section intro.
 *  - H3 / H4 + text     → a card. Consecutive cards form a grid. An image right after the heading
 *                         becomes the card image, otherwise an industrial icon is assigned.
 *  - UL / OL            → checklist grid (inside a card: card list).
 *  - Figure / IMG       → wide framed image.
 *  - Blockquote         → highlight quote.
 *  - Paragraphs only    → split layout (heading left, text right).
 *  - Sections alternate a subtle background band.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icons cycled through for cards that have no image.
 *
 * @return array
 */
function gpi_auto_icons() {
	return array( 'award', 'cog', 'users', 'truck', 'target', 'hardhat', 'wrench', 'package', 'shield', 'layers', 'ruler', 'leaf', 'chart', 'globe', 'bolt', 'star' );
}

/**
 * Render post content as designed sections.
 *
 * @param string|null $content Raw content (defaults to current post).
 * @return string HTML.
 */
function gpi_auto_layout( $content = null ) {
	if ( null === $content ) {
		$content = get_the_content();
	}
	$html = apply_filters( 'the_content', $content );
	$html = str_replace( ']]>', ']]&gt;', $html );

	if ( '' === trim( wp_strip_all_tags( $html ) ) && false === strpos( $html, '<img' ) ) {
		return '';
	}

	if ( ! class_exists( 'DOMDocument' ) ) {
		return '<div class="entry-content is-wide">' . $html . '</div>';
	}

	$dom = new DOMDocument();
	libxml_use_internal_errors( true );
	$dom->loadHTML( '<?xml encoding="utf-8" ?><div id="gpi-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
	libxml_clear_errors();

	$root = $dom->getElementById( 'gpi-root' );
	if ( ! $root ) {
		return '<div class="entry-content is-wide">' . $html . '</div>';
	}

	/* ---- Pass 1: flatten top-level nodes into typed items ---- */
	$items = array();
	foreach ( iterator_to_array( $root->childNodes ) as $node ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		if ( XML_TEXT_NODE === $node->nodeType ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			if ( '' !== trim( $node->textContent ) ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				$items[] = array( 'type' => 'p', 'html' => '<p>' . esc_html( trim( $node->textContent ) ) . '</p>', 'text' => trim( $node->textContent ) ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			}
			continue;
		}
		if ( XML_ELEMENT_NODE !== $node->nodeType ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			continue;
		}

		$tag   = strtolower( $node->nodeName ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$outer = $dom->saveHTML( $node );
		$inner = '';
		foreach ( $node->childNodes as $child ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$inner .= $dom->saveHTML( $child );
		}
		$text = trim( $node->textContent ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

		switch ( $tag ) {
			case 'h1':
			case 'h2':
				$items[] = array( 'type' => 'section', 'html' => $inner, 'text' => $text );
				break;
			case 'h3':
			case 'h4':
			case 'h5':
			case 'h6':
				$items[] = array( 'type' => 'card', 'html' => $inner, 'text' => $text );
				break;
			case 'p':
				// A paragraph that only wraps an image.
				if ( '' === $text && $node->getElementsByTagName( 'img' )->length ) {
					$items[] = array( 'type' => 'image', 'html' => $outer, 'text' => '' );
				} elseif ( '' !== $text || $node->getElementsByTagName( 'img' )->length ) {
					$items[] = array( 'type' => 'p', 'html' => $outer, 'text' => $text );
				}
				break;
			case 'ul':
			case 'ol':
				$items[] = array( 'type' => 'list', 'html' => $outer, 'text' => $text, 'node' => $node );
				break;
			case 'figure':
			case 'img':
				$items[] = array( 'type' => 'image', 'html' => $outer, 'text' => $text );
				break;
			case 'blockquote':
				$items[] = array( 'type' => 'quote', 'html' => $outer, 'text' => $text );
				break;
			case 'hr':
			case 'br':
				break;
			default:
				$items[] = array( 'type' => 'raw', 'html' => $outer, 'text' => $text );
		}
	}

	if ( empty( $items ) ) {
		return '';
	}

	/* ---- Pass 2: group into sections ---- */
	$sections = array();
	$current  = array( 'title' => '', 'eyebrow' => '', 'intro' => '', 'blocks' => array() );
	$count    = count( $items );

	for ( $i = 0; $i < $count; $i++ ) {
		$item = $items[ $i ];

		if ( 'section' === $item['type'] ) {
			// Close the current section.
			if ( $current['title'] || $current['blocks'] ) {
				$sections[] = $current;
			}
			$current = array( 'title' => $item['html'], 'eyebrow' => '', 'intro' => '', 'blocks' => array() );

			// Short paragraph directly before → eyebrow (steal it from the previous section).
			if ( ! empty( $sections ) ) {
				$prev = &$sections[ count( $sections ) - 1 ];
				$last = end( $prev['blocks'] );
				if ( $last && 'p' === $last['type'] && gpi_strlen( $last['text'] ) <= 40 && ! preg_match( '/[.!?]$/u', $last['text'] ) ) {
					$current['eyebrow'] = $last['text'];
					array_pop( $prev['blocks'] );
				}
				unset( $prev );
			}

			// First paragraph after → intro.
			if ( isset( $items[ $i + 1 ] ) && 'p' === $items[ $i + 1 ]['type'] && ! ( isset( $items[ $i + 2 ] ) && 'card' === $items[ $i + 2 ]['type'] && gpi_strlen( $items[ $i + 1 ]['text'] ) > 220 ) ) {
				$current['intro'] = $items[ $i + 1 ]['html'];
				$i++;
			}
			continue;
		}

		if ( 'card' === $item['type'] ) {
			// A short label paragraph right before a card group becomes a group label.
			$last = end( $current['blocks'] );
			if ( $last && 'p' === $last['type'] && gpi_strlen( $last['text'] ) <= 40 && ! preg_match( '/[.!?]$/u', $last['text'] ) ) {
				array_pop( $current['blocks'] );
				$current['blocks'][] = array( 'type' => 'label', 'html' => $last['text'], 'text' => $last['text'] );
			}
			$card = array( 'type' => 'card', 'title' => $item['html'], 'body' => array(), 'image' => '' );
			// Collect everything until the next heading.
			while ( isset( $items[ $i + 1 ] ) && ! in_array( $items[ $i + 1 ]['type'], array( 'section', 'card', 'raw' ), true ) ) {
				$i++;
				$next = $items[ $i ];
				if ( 'image' === $next['type'] && '' === $card['image'] ) {
					$card['image'] = $next['html'];
				} else {
					$card['body'][] = $next;
				}
			}
			$current['blocks'][] = $card;
			continue;
		}

		$current['blocks'][] = $item;
	}
	if ( $current['title'] || $current['blocks'] ) {
		$sections[] = $current;
	}

	/* ---- Pass 3: render ---- */
	$out        = '';
	$icons      = gpi_auto_icons();
	$icon_index = 0;
	$sec_index  = 0;

	foreach ( $sections as $section ) {
		$has_cards = false;
		$has_only_text = true;
		foreach ( $section['blocks'] as $b ) {
			if ( 'card' === $b['type'] ) {
				$has_cards = true;
			}
			if ( ! in_array( $b['type'], array( 'p', 'list', 'quote', 'label' ), true ) ) {
				$has_only_text = false;
			}
		}

		$classes = array( 'auto-section' );
		if ( $sec_index % 2 === 1 ) {
			$classes[] = 'auto-section-alt';
		}
		if ( ! $section['title'] ) {
			$classes[] = 'auto-section-lead';
		}
		if ( $section['title'] && $has_only_text && ! empty( $section['blocks'] ) ) {
			$classes[] = 'auto-section-split';
		}

		$out .= '<section class="' . esc_attr( implode( ' ', $classes ) ) . '"><div class="nova-container auto-section-inner">';

		if ( $section['title'] ) {
			$align = ( $has_cards || empty( $section['blocks'] ) ) ? 'center' : 'left';
			$out  .= '<div class="section-heading auto-heading align-' . $align . '" data-reveal>';
			if ( $section['eyebrow'] ) {
				$out .= '<span class="section-eyebrow">' . esc_html( $section['eyebrow'] ) . '</span>';
			}
			$out .= '<h2 class="section-title">' . wp_kses_post( $section['title'] ) . '</h2>';
			if ( $section['intro'] ) {
				$out .= '<div class="section-text">' . wp_kses_post( $section['intro'] ) . '</div>';
			}
			$out .= '</div>';
		}

		$out .= '<div class="auto-body">';

		$card_buffer = array();
		$flush_cards = function () use ( &$card_buffer, &$out, &$icon_index, $icons ) {
			if ( empty( $card_buffer ) ) {
				return;
			}
			$n     = count( $card_buffer );
			$out  .= '<div class="auto-cards auto-cards-' . min( 4, max( 1, $n ) ) . '">';
			$delay = 0;
			foreach ( $card_buffer as $card ) {
				$out .= '<div class="auto-card' . ( $card['image'] ? ' has-image' : '' ) . '" data-reveal data-reveal-delay="' . esc_attr( $delay ) . '">';
				if ( $card['image'] ) {
					$out .= '<div class="auto-card-image">' . wp_kses_post( $card['image'] ) . '</div>';
				} else {
					$out .= '<div class="feature-icon">' . gpi_icon( $icons[ $icon_index % count( $icons ) ], 24 ) . '</div>';
					$icon_index++;
				}
				$out .= '<div class="auto-card-body"><h3 class="auto-card-title">' . wp_kses_post( $card['title'] ) . '</h3>';
				foreach ( $card['body'] as $b ) {
					$out .= gpi_auto_render_block( $b, true );
				}
				$out .= '</div></div>';
				$delay += 70;
			}
			$out        .= '</div>';
			$card_buffer = array();
		};

		foreach ( $section['blocks'] as $block ) {
			if ( 'card' === $block['type'] ) {
				$card_buffer[] = $block;
				continue;
			}
			$flush_cards();
			$out .= gpi_auto_render_block( $block, false );
		}
		$flush_cards();

		$out .= '</div></div></section>';
		$sec_index++;
	}

	return $out;
}

/**
 * Render a single non-card block.
 *
 * @param array $block   Block item.
 * @param bool  $in_card Inside a card.
 * @return string
 */
function gpi_auto_render_block( $block, $in_card = false ) {
	switch ( $block['type'] ) {
		case 'list':
			$node  = isset( $block['node'] ) ? $block['node'] : null;
			$items = array();
			if ( $node ) {
				foreach ( $node->childNodes as $li ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					if ( XML_ELEMENT_NODE === $li->nodeType && 'li' === strtolower( $li->nodeName ) ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
						$inner = '';
						foreach ( $li->childNodes as $c ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
							$inner .= $li->ownerDocument->saveHTML( $c ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
						}
						$items[] = $inner;
					}
				}
			}
			if ( empty( $items ) ) {
				return '<div class="auto-prose">' . wp_kses_post( $block['html'] ) . '</div>';
			}
			$html = '<ul class="' . ( $in_card ? 'auto-card-list' : 'auto-checklist' ) . '">';
			foreach ( $items as $li ) {
				$html .= '<li>' . gpi_icon( 'check', 16 ) . '<span>' . wp_kses_post( $li ) . '</span></li>';
			}
			return $html . '</ul>';

		case 'image':
			return $in_card
				? '<div class="auto-card-image">' . wp_kses_post( $block['html'] ) . '</div>'
				: '<figure class="auto-media" data-reveal>' . wp_kses_post( $block['html'] ) . '</figure>';

		case 'quote':
			return '<div class="auto-quote" data-reveal>' . gpi_icon( 'sparkles', 20 ) . wp_kses_post( $block['html'] ) . '</div>';

		case 'raw':
			return '<div class="entry-content is-wide auto-raw">' . $block['html'] . '</div>';

		case 'label':
			return '<h3 class="auto-group-label">' . esc_html( $block['text'] ) . '</h3>';

		case 'p':
		default:
			return '<div class="auto-prose' . ( $in_card ? ' auto-card-text' : '' ) . '">' . wp_kses_post( $block['html'] ) . '</div>';
	}
}

/**
 * Output the auto layout for the current post, falling back to plain content.
 */
function gpi_the_auto_layout() {
	$html = gpi_auto_layout();
	if ( $html ) {
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from wp_kses_post()'d fragments.
	}
}

/**
 * Multibyte-safe strlen with a fallback when mbstring is unavailable.
 *
 * @param string $s String.
 * @return int
 */
function gpi_strlen( $s ) {
	return function_exists( 'mb_strlen' ) ? mb_strlen( $s ) : strlen( $s );
}
