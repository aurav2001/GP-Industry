<?php
/**
 * Appearance → GP-Industry Setup: one-click demo pages, template repair, menu.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Map a page template file from another theme to the closest GP-Industry template.
 *
 * @param string $old Old template path.
 * @param string $title Page title (used as a hint).
 * @return string
 */
function gpi_map_old_template( $old, $title = '' ) {
	$hint = strtolower( $old . ' ' . $title );
	if ( false !== strpos( $hint, 'contact' ) ) {
		return 'page-templates/contact.php';
	}
	if ( false !== strpos( $hint, 'product' ) ) {
		return 'page-templates/products.php';
	}
	if ( false !== strpos( $hint, 'service' ) ) {
		return 'page-templates/services.php';
	}
	if ( false !== strpos( $hint, 'about' ) ) {
		return 'page-templates/about.php';
	}
	if ( false !== strpos( $hint, 'blank' ) || false !== strpos( $hint, 'landing' ) ) {
		return 'page-templates/blank-canvas.php';
	}
	return 'page-templates/auto-design.php';
}

/**
 * Re-point pages that use templates from a previous theme.
 *
 * @return int Number of pages updated.
 */
function gpi_repair_page_templates() {
	$available = array_keys( wp_get_theme()->get_page_templates( null, 'page' ) );
	$fixed     = 0;

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'private', 'pending' ),
			'posts_per_page' => -1,
			'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'fields'         => 'ids',
		)
	);

	foreach ( $pages as $id ) {
		$tpl = get_post_meta( $id, '_wp_page_template', true );
		if ( ! $tpl || 'default' === $tpl || in_array( $tpl, $available, true ) ) {
			continue;
		}
		update_post_meta( $id, '_wp_page_template', gpi_map_old_template( $tpl, get_the_title( $id ) ) );
		$fixed++;
	}

	return $fixed;
}

/**
 * Repair templates automatically when the theme is activated.
 */
function gpi_on_theme_activation() {
	gpi_repair_page_templates();
	set_transient( 'gpi_show_setup_notice', 1, WEEK_IN_SECONDS );
}
add_action( 'after_switch_theme', 'gpi_on_theme_activation' );

/**
 * Admin menu entry.
 */
function gpi_setup_menu() {
	add_theme_page(
		esc_html__( 'GP-Industry Setup', 'gp-industry' ),
		esc_html__( 'GP-Industry Setup', 'gp-industry' ),
		'edit_theme_options',
		'gpi-setup',
		'gpi_setup_page_render'
	);
}
add_action( 'admin_menu', 'gpi_setup_menu' );

/**
 * Welcome notice after activation.
 */
function gpi_setup_notice() {
	if ( ! get_transient( 'gpi_show_setup_notice' ) || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( $screen && 'appearance_page_gpi-setup' === $screen->id ) {
		return;
	}
	printf(
		'<div class="notice notice-info is-dismissible"><p><strong>%1$s</strong> %2$s <a class="button button-primary" href="%3$s">%4$s</a></p></div>',
		esc_html__( 'GP-Industry is active.', 'gp-industry' ),
		esc_html__( 'Import ready-made demo pages (Home, About, Products, Services, Industries, Projects, Contact) and set up the menu in one click.', 'gp-industry' ),
		esc_url( admin_url( 'themes.php?page=gpi-setup' ) ),
		esc_html__( 'Open Setup', 'gp-industry' )
	);
}
add_action( 'admin_notices', 'gpi_setup_notice' );

/**
 * Handle the setup form.
 */
function gpi_setup_handle() {
	if ( ! isset( $_POST['gpi_setup_action'] ) || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	check_admin_referer( 'gpi_setup' );

	$action = sanitize_key( wp_unslash( $_POST['gpi_setup_action'] ) );
	$msg    = '';

	if ( 'import' === $action ) {
		$result = gpi_import_demo_pages();
		/* translators: 1: created count, 2: skipped count */
		$msg = sprintf( esc_html__( 'Demo import finished: %1$d pages created, %2$d already existed and were kept. Front page, blog page and primary menu are set.', 'gp-industry' ), $result['created'], $result['skipped'] );
	} elseif ( 'repair' === $action ) {
		$n = gpi_repair_page_templates();
		/* translators: %d: number of pages */
		$msg = sprintf( esc_html__( 'Templates repaired on %d page(s).', 'gp-industry' ), $n );
	}

	delete_transient( 'gpi_show_setup_notice' );
	set_transient( 'gpi_setup_message', $msg, 60 );
	wp_safe_redirect( admin_url( 'themes.php?page=gpi-setup&done=1' ) );
	exit;
}
add_action( 'admin_init', 'gpi_setup_handle' );

/**
 * Render the setup page.
 */
function gpi_setup_page_render() {
	$msg = get_transient( 'gpi_setup_message' );
	if ( $msg ) {
		delete_transient( 'gpi_setup_message' );
		echo '<div class="notice notice-success"><p>' . esc_html( $msg ) . '</p></div>';
	}

	$available = array_keys( wp_get_theme()->get_page_templates( null, 'page' ) );
	$broken    = 0;
	foreach ( get_posts( array( 'post_type' => 'page', 'posts_per_page' => -1, 'post_status' => 'any', 'fields' => 'ids' ) ) as $id ) {
		$tpl = get_post_meta( $id, '_wp_page_template', true );
		if ( $tpl && 'default' !== $tpl && ! in_array( $tpl, $available, true ) ) {
			$broken++;
		}
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'GP-Industry Setup', 'gp-industry' ); ?></h1>

		<div style="max-width:820px">
			<div class="card" style="max-width:none">
				<h2><?php esc_html_e( '1. Import demo pages', 'gp-industry' ); ?></h2>
				<p><?php esc_html_e( 'Creates fully designed pages you can simply edit: Home (front page), About Us, Products (+3 product pages), Services (+3 service pages), Industries, Projects, Contact, News. Pages that already exist with the same slug are left untouched. Also sets the front page, blog page and the primary menu.', 'gp-industry' ); ?></p>
				<form method="post">
					<?php wp_nonce_field( 'gpi_setup' ); ?>
					<input type="hidden" name="gpi_setup_action" value="import">
					<?php submit_button( esc_html__( 'Import demo pages', 'gp-industry' ), 'primary', 'submit', false ); ?>
				</form>
			</div>

			<div class="card" style="max-width:none">
				<h2><?php esc_html_e( '2. Repair page templates from a previous theme', 'gp-industry' ); ?></h2>
				<p>
					<?php
					/* translators: %d: number of pages */
					printf( esc_html__( 'Pages that still point to a template file from your old theme fall back to a plain layout. Currently: %d page(s). This maps them to the matching GP-Industry template (contact → Contact Page, services → Services Page, about → About Page, others → Designed Sections).', 'gp-industry' ), (int) $broken );
					?>
				</p>
				<form method="post">
					<?php wp_nonce_field( 'gpi_setup' ); ?>
					<input type="hidden" name="gpi_setup_action" value="repair">
					<?php submit_button( esc_html__( 'Repair templates', 'gp-industry' ), 'secondary', 'submit', false ); ?>
				</form>
			</div>

			<div class="card" style="max-width:none">
				<h2><?php esc_html_e( 'How pages get their design', 'gp-industry' ); ?></h2>
				<ul style="list-style:disc;padding-left:1.2em">
					<li><?php esc_html_e( 'Pick a template in the page editor sidebar: About Page, Services Page, Products Page, Contact Page or "Designed Sections (Auto)".', 'gp-industry' ); ?></li>
					<li><?php esc_html_e( 'H2 = section title · H3 + paragraph = card (add an image under the H3 for an image card) · bullet list = checklist · short line before a heading = small label.', 'gp-industry' ); ?></li>
					<li><?php esc_html_e( 'For richer sections use the block inserter → Patterns → "GP-Industry Sections" (pricing, process, certifications, gallery, team, FAQ…).', 'gp-industry' ); ?></li>
					<li><?php esc_html_e( 'Services / Products: create child pages under the Services or Products page — they appear as cards automatically.', 'gp-industry' ); ?></li>
				</ul>
				<p><a class="button" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Open Customizer', 'gp-industry' ); ?></a></p>
			</div>
		</div>
	</div>
	<?php
}

/* ------------------------------------------------------------------------- */

/**
 * Create a page if its slug does not exist yet.
 *
 * @param array $args   wp_insert_post args (post_title, post_name, post_content, post_parent, menu_order).
 * @param string $template Template file.
 * @param array  $result   Counters (by reference).
 * @return int Page ID.
 */
function gpi_demo_page( $args, $template, &$result ) {
	$existing = get_page_by_path( $args['post_name'], OBJECT, 'page' );
	if ( $existing ) {
		$result['skipped']++;
		return $existing->ID;
	}

	$id = wp_insert_post(
		wp_parse_args(
			$args,
			array(
				'post_type'   => 'page',
				'post_status' => 'publish',
				'post_author' => get_current_user_id(),
			)
		)
	);

	if ( $id && ! is_wp_error( $id ) ) {
		if ( $template ) {
			update_post_meta( $id, '_wp_page_template', $template );
		}
		$result['created']++;
		return $id;
	}
	return 0;
}

/**
 * Import the demo pages, set front/blog pages and the primary menu.
 *
 * @return array
 */
function gpi_import_demo_pages() {
	$result = array( 'created' => 0, 'skipped' => 0 );
	$img    = esc_url( GPI_THEME_URI . '/assets/images/placeholder.svg' );
	$avatar = esc_url( GPI_THEME_URI . '/assets/images/avatar.svg' );

	$p = function ( $text ) {
		return '<!-- wp:paragraph --><p>' . $text . '</p><!-- /wp:paragraph -->' . "\n";
	};
	$h = function ( $text, $level = 2 ) {
		return '<!-- wp:heading {"level":' . $level . '} --><h' . $level . ' class="wp-block-heading">' . $text . '</h' . $level . '>' . '<!-- /wp:heading -->' . "\n";
	};
	$ul = function ( $items ) {
		$o = '<!-- wp:list --><ul class="wp-block-list">';
		foreach ( $items as $i ) {
			$o .= '<!-- wp:list-item --><li>' . $i . '</li><!-- /wp:list-item -->';
		}
		return $o . '</ul><!-- /wp:list -->' . "\n";
	};

	/* Home: front-page.php renders hero/features/stats/news/CTA; content adds sections between. */
	$home = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Home', 'gp-industry' ),
			'post_name'    => 'home',
			'post_content' => gpi_pattern_industries() . "\n" . gpi_pattern_process() . "\n" . gpi_pattern_certifications(),
		),
		'',
		$result
	);

	/* About */
	$about_content  = $p( esc_html__( 'Who we are', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'A manufacturing partner you can depend on', 'gp-industry' ) );
	$about_content .= $p( esc_html__( 'Founded in 1998, GP-Industry has grown from a single workshop into a multi-plant manufacturer serving automotive, energy, construction and infrastructure customers across 40 countries. Edit this text with your company story.', 'gp-industry' ) );
	$about_content .= $p( esc_html__( 'Our mission is simple: deliver precision components and reliable industrial solutions with uncompromising quality, safety and on-time performance.', 'gp-industry' ) );
	$about_content .= $p( esc_html__( 'Our strengths', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Why clients choose us', 'gp-industry' ) );
	$about_content .= $p( esc_html__( 'Every part we ship is backed by certified processes, modern machinery and an experienced team.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Certified Quality', 'gp-industry' ), 3 ) . $p( esc_html__( 'ISO 9001:2015 quality systems with in-house CMM, hardness and NDT testing on every batch.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Modern Infrastructure', 'gp-industry' ), 3 ) . $p( esc_html__( 'CNC machining centres, automated fabrication lines and 3-shift capacity for large orders.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Experienced Team', 'gp-industry' ), 3 ) . $p( esc_html__( 'Engineers and technicians with decades of hands-on industry experience.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Our certifications', 'gp-industry' ) );
	$about_content .= $ul( array( 'ISO 9001:2015 Quality Management', 'ISO 14001 Environmental Management', 'ISO 45001 Occupational Health & Safety', 'CE Marking for exported equipment' ) );
	$about_content .= gpi_pattern_process() . "\n" . gpi_pattern_team( $avatar ) . "\n" . gpi_pattern_faq();

	$about = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'About Us', 'gp-industry' ),
			'post_name'    => 'about-us',
			'post_excerpt' => esc_html__( 'Serving industry since 1998 with certified quality and on-time delivery.', 'gp-industry' ),
			'post_content' => $about_content,
			'menu_order'   => 10,
		),
		'page-templates/about.php',
		$result
	);

	/* Products + children */
	$products = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Products', 'gp-industry' ),
			'post_name'    => 'products',
			'post_excerpt' => esc_html__( 'Engineered components and equipment built to your specification.', 'gp-industry' ),
			'post_content' => '',
			'menu_order'   => 20,
		),
		'page-templates/products.php',
		$result
	);
	$product_items = array(
		array( 'precision-machined-parts', esc_html__( 'Precision Machined Parts', 'gp-industry' ), esc_html__( 'CNC turned and milled components in steel, aluminium and brass to ±0.01 mm.', 'gp-industry' ) ),
		array( 'industrial-fasteners', esc_html__( 'Industrial Fasteners', 'gp-industry' ), esc_html__( 'Bolts, nuts, studs and custom fasteners in grades 8.8, 10.9, 12.9 and stainless.', 'gp-industry' ) ),
		array( 'fabricated-assemblies', esc_html__( 'Fabricated Assemblies', 'gp-industry' ), esc_html__( 'Welded structures, enclosures and sub-assemblies built to your drawings.', 'gp-industry' ) ),
	);
	foreach ( $product_items as $i => $item ) {
		$content  = $p( $item[2] );
		$content .= $h( esc_html__( 'Key features', 'gp-industry' ) );
		$content .= $ul( array( esc_html__( 'Material test certificate with every batch', 'gp-industry' ), esc_html__( 'Custom sizes and finishes on request', 'gp-industry' ), esc_html__( 'Prototype to high-volume production', 'gp-industry' ), esc_html__( 'Export packing available', 'gp-industry' ) ) );
		$content .= gpi_pattern_specs();
		gpi_demo_page(
			array(
				'post_title'   => $item[1],
				'post_name'    => $item[0],
				'post_excerpt' => $item[2],
				'post_content' => $content,
				'post_parent'  => $products,
				'menu_order'   => $i + 1,
			),
			'page-templates/product-single.php',
			$result
		);
	}

	/* Services + children */
	$services = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Services', 'gp-industry' ),
			'post_name'    => 'services',
			'post_excerpt' => esc_html__( 'From design and prototyping to production, maintenance and supply.', 'gp-industry' ),
			'post_content' => '',
			'menu_order'   => 30,
		),
		'page-templates/services.php',
		$result
	);
	$service_items = array(
		array( 'contract-manufacturing', esc_html__( 'Contract Manufacturing', 'gp-industry' ), esc_html__( 'End-to-end production from prototyping to high-volume runs.', 'gp-industry' ) ),
		array( 'maintenance-repair', esc_html__( 'Maintenance & Repair', 'gp-industry' ), esc_html__( 'Preventive maintenance, breakdown support and spare parts supply.', 'gp-industry' ) ),
		array( 'design-engineering', esc_html__( 'Design & Engineering', 'gp-industry' ), esc_html__( 'CAD/CAM design, reverse engineering and DFM consultation.', 'gp-industry' ) ),
	);
	foreach ( $service_items as $i => $item ) {
		$content  = $p( $item[2] );
		$content .= $h( esc_html__( 'What is included', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Consultation', 'gp-industry' ), 3 ) . $p( esc_html__( 'We review your drawings and requirements and propose the best approach.', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Execution', 'gp-industry' ), 3 ) . $p( esc_html__( 'Skilled teams deliver the work with in-process quality checks.', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Support', 'gp-industry' ), 3 ) . $p( esc_html__( 'Documentation, training and after-delivery support.', 'gp-industry' ) );
		$content .= gpi_pattern_faq();
		gpi_demo_page(
			array(
				'post_title'   => $item[1],
				'post_name'    => $item[0],
				'post_excerpt' => $item[2],
				'post_content' => $content,
				'post_parent'  => $services,
				'menu_order'   => $i + 1,
			),
			'page-templates/service-single.php',
			$result
		);
	}

	/* Industries, Projects, Contact, News */
	$industries = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Industries', 'gp-industry' ),
			'post_name'    => 'industries',
			'post_excerpt' => esc_html__( 'Proven supply experience across regulated and high-volume sectors.', 'gp-industry' ),
			'post_content' => gpi_pattern_industries() . "\n" . gpi_pattern_stats() . "\n" . gpi_pattern_testimonials(),
			'menu_order'   => 40,
		),
		'page-templates/auto-design.php',
		$result
	);
	$projects = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Projects', 'gp-industry' ),
			'post_name'    => 'projects',
			'post_excerpt' => esc_html__( 'A selection of recent work from our plant floor.', 'gp-industry' ),
			'post_content' => gpi_pattern_projects( $img ) . "\n" . gpi_pattern_certifications(),
			'menu_order'   => 50,
		),
		'page-templates/auto-design.php',
		$result
	);
	$contact = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Contact', 'gp-industry' ),
			'post_name'    => 'contact',
			'post_excerpt' => esc_html__( 'Send us your drawings or requirements — we reply within one business day.', 'gp-industry' ),
			'post_content' => $p( esc_html__( 'Install a form plugin (Contact Form 7, WPForms, Fluent Forms…) and paste its shortcode or block here to show the quote form in this card.', 'gp-industry' ) ),
			'menu_order'   => 60,
		),
		'page-templates/contact.php',
		$result
	);
	$news = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'News', 'gp-industry' ),
			'post_name'    => 'news',
			'post_content' => '',
			'menu_order'   => 70,
		),
		'',
		$result
	);

	/* Reading settings */
	if ( $home ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home );
	}
	if ( $news ) {
		update_option( 'page_for_posts', $news );
	}

	/* Primary menu (only if none is assigned yet) */
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( empty( $locations['primary-menu'] ) ) {
		$menu_id = wp_create_nav_menu( esc_html__( 'Primary Menu', 'gp-industry' ) );
		if ( ! is_wp_error( $menu_id ) ) {
			$order = 1;
			foreach ( array( $home, $about, $products, $services, $industries, $projects, $news, $contact ) as $page_id ) {
				if ( ! $page_id ) {
					continue;
				}
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'     => get_the_title( $page_id ),
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $page_id,
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => $order++,
					)
				);
			}
			$locations['primary-menu'] = $menu_id;
			$locations['footer-menu']  = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}

	return $result;
}
