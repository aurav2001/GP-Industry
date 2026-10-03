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
 * Automatically set up demo content and GP-Industry menu on theme activation.
 */
function gpi_on_theme_activation() {
	gpi_auto_setup_theme_content();
	set_transient( 'gpi_show_setup_notice', 1, WEEK_IN_SECONDS );
}
add_action( 'after_switch_theme', 'gpi_on_theme_activation' );

/**
 * Ensure theme content and menu are initialized even if theme was activated before update.
 */
function gpi_maybe_auto_setup() {
	if ( ! get_option( 'gpi_auto_setup_completed_v7' ) ) {
		gpi_auto_setup_theme_content();
		update_option( 'gpi_auto_setup_completed_v7', 1 );
	}
}
add_action( 'init', 'gpi_maybe_auto_setup' );

/**
 * Main auto setup function.
 */
function gpi_auto_setup_theme_content() {
	gpi_repair_page_templates();
	gpi_cleanup_synthetic_images();
	gpi_import_demo_pages();
}

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
				<p><?php esc_html_e( 'Creates fully designed pages you can simply edit: Home (front page), About Us, Why Choose Us (auto-layout demo), Solutions (+3), Services (+3), Industries, Case Studies, Training (+3), Contact, Insights — with generated placeholder images (hero slideshow, featured images) and sample contact details. Pages that already exist with the same slug are left untouched. Also sets the front page, blog page and the primary menu.', 'gp-industry' ); ?></p>
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
 * Generate a branded placeholder image (gradient + label) in the media library.
 * Returns the attachment ID, or 0 when GD is unavailable.
 *
 * @param string $label Text drawn on the image.
 * @param int    $seed  Changes the gradient colours.
 * @param int    $w     Width.
 * @param int    $h     Height.
 * @return int
 */
/**
 * Remove legacy GD-generated synthetic placeholder attachments and ensure all pages
 * have real high-resolution bundled industrial photography.
 */
function gpi_cleanup_synthetic_images() {
	global $wpdb;

	// 1. Delete all attachments created with gpi-demo- slug or filename
	$synthetic_ids = $wpdb->get_col(
		"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND (post_name LIKE 'gpi-demo-%' OR guid LIKE '%gpi-demo-%')"
	);

	if ( ! empty( $synthetic_ids ) ) {
		if ( ! function_exists( 'wp_delete_attachment' ) ) {
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
		}

		foreach ( $synthetic_ids as $att_id ) {
			wp_delete_attachment( (int) $att_id, true );
		}
	}

	// 2. Map of page slugs to bundled photo filenames
	$page_image_map = array(
		'home'                             => 'hero-industrial.jpg',
		'about-us'                         => 'about-facility.jpg',
		'about'                            => 'about-facility.jpg',
		'products'                         => 'heavy-machinery.jpg',
		'heavy-industrial-machinery'       => 'heavy-machinery.jpg',
		'precision-cnc-components'         => 'precision-components.jpg',
		'industrial-automation'            => 'industrial-automation.jpg',
		'workforce-outsourcing'            => 'workforce-outsourcing.jpg',
		'payroll-statutory-compliance'     => 'payroll-compliance.jpg',
		'payroll-compliance'               => 'payroll-compliance.jpg',
		'integrated-facility-management'   => 'facility-management.jpg',
		'facility-management'              => 'facility-management.jpg',
		'services'                         => 'custom-fabrication.jpg',
		'custom-fabrication'               => 'custom-fabrication.jpg',
		'plant-maintenance'                => 'plant-maintenance.jpg',
		'engineering-prototyping'          => 'engineering-cad.jpg',
		'industries'                       => 'industries-sectors.jpg',
		'case-studies'                     => 'case-studies-projects.jpg',
		'projects'                         => 'case-studies-projects.jpg',
		'contact'                          => 'contact-facility.jpg',
		'contact-us'                       => 'contact-facility.jpg',
	);

	// 3. For each mapped slug, find matching pages and ensure their featured image is set to the real photo
	foreach ( $page_image_map as $slug => $img_file ) {
		$found_pages = get_posts(
			array(
				'post_type'      => 'page',
				'name'           => $slug,
				'post_status'    => 'any',
				'posts_per_page' => 5,
				'fields'         => 'ids',
			)
		);
		foreach ( $found_pages as $pid ) {
			$current_thumb = get_post_thumbnail_id( $pid );
			$needs_update  = false;
			if ( ! $current_thumb ) {
				$needs_update = true;
			} else {
				$att = get_post( $current_thumb );
				if ( ! $att || false !== strpos( $att->post_name, 'gpi-demo-' ) || false !== strpos( (string) $att->guid, 'gpi-demo-' ) ) {
					$needs_update = true;
				}
			}
			if ( $needs_update ) {
				gpi_demo_featured( $pid, get_the_title( $pid ), $img_file );
			}
		}
	}
}

/**
 * Legacy GD image generator disabled in favor of real high-res photography.
 *
 * @param string $label Text label.
 * @param int    $seed  Seed.
 * @param int    $w     Width.
 * @param int    $h     Height.
 * @return int 0
 */
function gpi_demo_image( $label, $seed = 0, $w = 1600, $h = 1000 ) {
	return 0;
}

/**
 * Attach a bundled industrial demo image as featured image.
 *
 * @param int    $page_id    Page ID.
 * @param string $label      Image label.
 * @param string $image_file Bundled filename in assets/images/ (e.g. 'about-facility.jpg').
 */
function gpi_demo_featured( $page_id, $label, $image_file = '' ) {
	if ( ! $page_id ) {
		return;
	}

	if ( ! $image_file ) {
		$lbl_lower = strtolower( $label );
		$keyword_map = array(
			'workforce'   => 'workforce-outsourcing.jpg',
			'outsourcing' => 'workforce-outsourcing.jpg',
			'payroll'     => 'payroll-compliance.jpg',
			'statutory'   => 'payroll-compliance.jpg',
			'compliance'  => 'payroll-compliance.jpg',
			'facility'    => 'facility-management.jpg',
			'machin'      => 'heavy-machinery.jpg',
			'cnc'         => 'precision-components.jpg',
			'precision'   => 'precision-components.jpg',
			'auto'        => 'industrial-automation.jpg',
			'robot'       => 'industrial-automation.jpg',
			'fabricat'    => 'custom-fabrication.jpg',
			'weld'        => 'custom-fabrication.jpg',
			'maint'       => 'plant-maintenance.jpg',
			'cad'         => 'engineering-cad.jpg',
			'industr'     => 'industries-sectors.jpg',
			'project'     => 'case-studies-projects.jpg',
			'contact'     => 'contact-facility.jpg',
			'about'       => 'about-facility.jpg',
		);
		foreach ( $keyword_map as $key => $file ) {
			if ( false !== strpos( $lbl_lower, $key ) ) {
				$image_file = $file;
				break;
			}
		}
		if ( ! $image_file ) {
			$image_file = 'heavy-machinery.jpg';
		}
	}

	if ( $image_file && file_exists( GPI_THEME_DIR . '/assets/images/' . $image_file ) ) {
		$slug     = sanitize_title( 'gpi-asset-' . pathinfo( $image_file, PATHINFO_FILENAME ) );
		$existing = get_posts(
			array(
				'post_type'      => 'attachment',
				'name'           => $slug,
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'post_status'    => 'inherit',
			)
		);

		if ( ! empty( $existing ) ) {
			set_post_thumbnail( $page_id, (int) $existing[0] );
			return;
		}

		$upload = wp_upload_dir();
		$target = trailingslashit( $upload['path'] ) . $image_file;
		copy( GPI_THEME_DIR . '/assets/images/' . $image_file, $target );

		if ( file_exists( $target ) ) {
			$filetype      = wp_check_filetype( basename( $target ), null );
			$attachment_id = wp_insert_attachment(
				array(
					'guid'           => trailingslashit( $upload['url'] ) . basename( $target ),
					'post_mime_type' => $filetype['type'] ? $filetype['type'] : 'image/jpeg',
					'post_title'     => $label ? $label : pathinfo( $image_file, PATHINFO_FILENAME ),
					'post_name'      => $slug,
					'post_status'    => 'inherit',
				),
				$target,
				$page_id
			);

			if ( ! is_wp_error( $attachment_id ) && $attachment_id > 0 ) {
				require_once ABSPATH . 'wp-admin/includes/image.php';
				$attach_data = wp_generate_attachment_metadata( $attachment_id, $target );
				wp_update_attachment_metadata( $attachment_id, $attach_data );
				set_post_thumbnail( $page_id, $attachment_id );
				return;
			}
		}
	}
}

/**
 * Create a page if its slug does not exist yet.
 *
 * @param array $args   wp_insert_post args (post_title, post_name, post_content, post_parent, menu_order).
 * @param string $template Template file.
 * @param array  $result   Counters (by reference).
 * @return int Page ID.
 */
function gpi_demo_page( $args, $template, &$result ) {
	// Child pages live at parent-slug/slug.
	$path = $args['post_name'];
	if ( ! empty( $args['post_parent'] ) ) {
		$parent = get_post( $args['post_parent'] );
		if ( $parent ) {
			$path = $parent->post_name . '/' . $args['post_name'];
		}
	}
	$existing = get_page_by_path( $path, OBJECT, 'page' );
	if ( ! $existing ) {
		// Fallback: same slug under the same parent regardless of status.
		$found = get_posts( array( 'post_type' => 'page', 'name' => $args['post_name'], 'post_parent' => isset( $args['post_parent'] ) ? (int) $args['post_parent'] : 0, 'post_status' => 'any', 'posts_per_page' => 1 ) );
		$existing = $found ? $found[0] : null;
	}
	if ( $existing ) {
		if ( ! empty( $args['post_content'] ) || ! empty( $args['post_excerpt'] ) ) {
			wp_update_post(
				array(
					'ID'           => $existing->ID,
					'post_title'   => $args['post_title'],
					'post_content' => $args['post_content'],
					'post_excerpt' => isset( $args['post_excerpt'] ) ? $args['post_excerpt'] : '',
				)
			);
		}
		if ( $template ) {
			update_post_meta( $existing->ID, '_wp_page_template', $template );
		}
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
	$fig = function ( $img_name, $caption = '' ) {
		$src = esc_url( GPI_THEME_URI . '/assets/images/' . $img_name );
		$out = '<!-- wp:image {"sizeSlug":"large","className":"gpi-page-figure"} --><figure class="wp-block-image size-large gpi-page-figure"><img src="' . $src . '" alt="' . esc_attr( $caption ) . '" loading="lazy"/>';
		if ( $caption ) {
			$out .= '<figcaption class="wp-element-caption">' . esc_html( $caption ) . '</figcaption>';
		}
		$out .= '</figure><!-- /wp:image -->' . "\n";
		return $out;
	};

	$company = get_bloginfo( 'name' );

	/* Home: front-page.php renders hero/features/stats/about/…; content adds sections in between. */
	$home = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Home', 'gp-industry' ),
			'post_name'    => 'home',
			'post_content' => gpi_pattern_certifications(),
		),
		'',
		$result
	);

	/* About */
	$about_content  = $p( esc_html__( 'Industrial Heritage & Advanced Infrastructure', 'gp-industry' ) );
	$about_content .= $h( sprintf( esc_html__( '%s — Precision Manufacturing & Heavy Engineering', 'gp-industry' ), $company ) );
	$about_content .= $p( sprintf( esc_html__( '%s is an ISO 9001:2015 and ASME-certified heavy manufacturing powerhouse. Operating across a 150,000 sq.ft state-of-the-art facility, we specialize in high-precision 5-axis CNC machining, structural steel fabrication, industrial automation, and turnkey engineering solutions.', 'gp-industry' ), $company ) );
	$about_content .= $fig( 'about-facility.jpg', sprintf( esc_html__( '%s 150,000 sq.ft precision manufacturing plant and heavy assembly bays', 'gp-industry' ), $company ) );
	$about_content .= $p( esc_html__( 'Our engineering philosophy merges decades of manufacturing craftsmanship with Industry 4.0 automation. We achieve extreme tolerances down to ±0.005mm, full metallurgical traceability, and zero-defect quality across demanding automotive, aerospace, defense, energy, and heavy infrastructure sectors.', 'gp-industry' ) );
	$about_content .= $p( esc_html__( 'Manufacturing Capabilities', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'State-of-the-art industrial production infrastructure', 'gp-industry' ) );
	$about_content .= $p( esc_html__( 'Integrated facilities designed to handle projects from prototype engineering to high-volume production with total reliability.', 'gp-industry' ) );
	$about_content .= $p( esc_html__( 'Machining & Fabrication', 'gp-industry' ) );
	$about_content .= $h( esc_html__( '5-Axis Precision CNC Machining', 'gp-industry' ), 3 ) . $p( esc_html__( 'Multi-axis high-speed CNC milling and turning centers delivering micron-level tolerances on titanium, Inconel, duplex, and alloy steels.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Heavy Structural Steel Fabrication', 'gp-industry' ), 3 ) . $p( esc_html__( 'Heavy plate rolling, high-precision fiber laser cutting up to 30mm, and ASME-coded robotic and submerged arc welding.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Turnkey Industrial Automation', 'gp-industry' ), 3 ) . $p( esc_html__( 'Robotic welding cells, material handling conveyor systems, and custom PLC control consoles for smart factories.', 'gp-industry' ) );
	$about_content .= $fig( 'precision-components.jpg', esc_html__( 'High-tolerance aerospace and defense precision machined components', 'gp-industry' ) );
	$about_content .= $p( esc_html__( 'Quality Assurance', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'CMM Metrology & Metallurgical Lab', 'gp-industry' ), 3 ) . $p( esc_html__( 'Temperature-controlled inspection room equipped with coordinate measuring machines (CMM) and surface roughness testers.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Non-Destructive Testing (NDT)', 'gp-industry' ), 3 ) . $p( esc_html__( 'ASNT Level II certified ultrasonic, magnetic particle, dye penetrant, and hydrostatic pressure testing.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Material Traceability & Compliance', 'gp-industry' ), 3 ) . $p( esc_html__( '100% heat-number traceability with EN 10204 3.1 chemical and mechanical inspection certificates.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Industry Certifications & Accreditations', 'gp-industry' ) );
	$about_content .= $ul( array(
		esc_html__( 'ISO 9001:2015 certified Quality Management System', 'gp-industry' ),
		esc_html__( 'ISO 14001:2015 certified Environmental Management', 'gp-industry' ),
		esc_html__( 'ASME Section VIII Div 1 & Div 2 Code Stamp certified', 'gp-industry' ),
		esc_html__( 'CE marking & EN 1090 structural steel execution compliance', 'gp-industry' ),
	) );
	$about_content .= gpi_pattern_process() . "\n" . gpi_pattern_team( $avatar ) . "\n" . gpi_pattern_faq();

	$about = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'About Us', 'gp-industry' ),
			'post_name'    => 'about-us',
			'post_excerpt' => esc_html__( 'Leading precision CNC machining, heavy industrial fabrication, and turnkey engineering solutions.', 'gp-industry' ),
			'post_content' => $about_content,
			'menu_order'   => 10,
		),
		'page-templates/about.php',
		$result
	);
	gpi_demo_featured( $about, esc_html__( 'About Us', 'gp-industry' ), 'about-facility.jpg' );

	/* Products (Products template) + 3 children */
	$products = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Products', 'gp-industry' ),
			'post_name'    => 'products',
			'post_excerpt' => esc_html__( 'High-performance heavy industrial machinery, precision CNC components, and automation systems.', 'gp-industry' ),
			'post_content' => $fig( 'heavy-machinery.jpg', esc_html__( 'High-performance heavy machinery and precision manufactured systems', 'gp-industry' ) ),
			'menu_order'   => 20,
		),
		'page-templates/products.php',
		$result
	);
	gpi_demo_featured( $products, esc_html__( 'Products', 'gp-industry' ), 'heavy-machinery.jpg' );

	$product_items = array(
		array(
			'heavy-industrial-machinery',
			esc_html__( 'Heavy Industrial Machinery', 'gp-industry' ),
			esc_html__( 'High-capacity hydraulic stamping presses, automated material handling conveyors, industrial crushers, and heavy planetary gearboxes built for extreme duty.', 'gp-industry' ),
			array(
				esc_html__( '50 to 2,000-tonne hydraulic press load capacities', 'gp-industry' ),
				esc_html__( 'Siemens / Allen-Bradley PLC automated controls', 'gp-industry' ),
				esc_html__( 'Heavy-duty vibration damped structural steel frame', 'gp-industry' ),
				esc_html__( '24/7 continuous duty cycle with safety interlocks', 'gp-industry' ),
			),
			'heavy-machinery.jpg',
		),
		array(
			'precision-cnc-components',
			esc_html__( 'Precision CNC Components', 'gp-industry' ),
			esc_html__( 'High-tolerance milled and turned parts in titanium, Inconel, stainless steel, and aerospace-grade aluminum for mission-critical assemblies.', 'gp-industry' ),
			array(
				esc_html__( 'Tolerances down to ±0.005 mm (5 microns)', 'gp-industry' ),
				esc_html__( '5-Axis simultaneous CNC milling & live-tool turning', 'gp-industry' ),
				esc_html__( 'Full CMM dimensional inspection and surface reports', 'gp-industry' ),
				esc_html__( 'Complete EN 10204 3.1 material test certificates', 'gp-industry' ),
			),
			'precision-components.jpg',
		),
		array(
			'industrial-automation',
			esc_html__( 'Industrial Automation Systems', 'gp-industry' ),
			esc_html__( 'Turnkey robotic welding cells, pick-and-place automation, SCADA integration, and Industry 4.0 smart factory monitoring.', 'gp-industry' ),
			array(
				esc_html__( 'Fanuc & ABB robotic integration for welding and assembly', 'gp-industry' ),
				esc_html__( 'Custom PLC control panels with safety relay systems', 'gp-industry' ),
				esc_html__( 'Real-time telemetry and predictive maintenance sensors', 'gp-industry' ),
				esc_html__( 'Modular skid design for rapid factory deployment', 'gp-industry' ),
			),
			'industrial-automation.jpg',
		),
	);
	$product_child_ids = array();
	foreach ( $product_items as $i => $item ) {
		$content  = $fig( $item[4], $item[1] );
		$content .= $p( $item[2] );
		$content .= $ul( $item[3] );
		$content .= $h( esc_html__( 'Technical Specifications', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Engineering Quality Guarantee', 'gp-industry' ), 3 ) . $p( esc_html__( 'Every manufactured unit passes 100% factory acceptance testing (FAT) before shipment.', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Material Certification', 'gp-industry' ), 3 ) . $p( esc_html__( 'Supplied with EN 10204 3.1 mill test certificates, ultrasonic NDT reports, and dimensional logs.', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Turnkey Support', 'gp-industry' ), 3 ) . $p( esc_html__( 'On-site installation, commissioning, operator training, and annual maintenance contracts (AMC).', 'gp-industry' ) );
		$content .= gpi_pattern_specs();
		$pid = gpi_demo_page(
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
		if ( $pid ) {
			$product_child_ids[] = $pid;
		}
		gpi_demo_featured( $pid, $item[1], $item[4] );
	}
	gpi_demo_featured( $products, esc_html__( 'Products', 'gp-industry' ), 'heavy-machinery.jpg' );

	// If legacy demo child pages exist from older import, give them authentic photography
	$legacy_cards = array(
		'workforce-outsourcing'          => array( 'Workforce Outsourcing', 'workforce-outsourcing.jpg' ),
		'payroll-statutory-compliance'   => array( 'Payroll & Statutory Compliance', 'payroll-compliance.jpg' ),
		'payroll-compliance'             => array( 'Payroll & Statutory Compliance', 'payroll-compliance.jpg' ),
		'integrated-facility-management' => array( 'Integrated Facility Management', 'facility-management.jpg' ),
		'facility-management'            => array( 'Integrated Facility Management', 'facility-management.jpg' ),
	);
	foreach ( $legacy_cards as $l_slug => $l_info ) {
		$l_pages = get_posts( array( 'post_type' => 'page', 'name' => $l_slug, 'post_status' => 'any', 'posts_per_page' => 1, 'fields' => 'ids' ) );
		if ( ! empty( $l_pages ) ) {
			gpi_demo_featured( $l_pages[0], $l_info[0], $l_info[1] );
		}
	}

	/* Services + 3 children */
	$services = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Services', 'gp-industry' ),
			'post_name'    => 'services',
			'post_excerpt' => esc_html__( 'Custom metal fabrication, plant maintenance, dynamic balancing, and turnkey engineering design.', 'gp-industry' ),
			'post_content' => $fig( 'custom-fabrication.jpg', esc_html__( 'Turnkey custom structural metal fabrication and field engineering', 'gp-industry' ) ),
			'menu_order'   => 30,
		),
		'page-templates/services.php',
		$result
	);
	gpi_demo_featured( $services, esc_html__( 'Services', 'gp-industry' ), 'custom-fabrication.jpg' );

	$service_items = array(
		array(
			'custom-fabrication',
			esc_html__( 'Custom Metal Fabrication', 'gp-industry' ),
			esc_html__( 'Structural steel fabrication, heavy plate rolling, fiber laser cutting up to 30mm, and ASME-coded robotic and manual welding.', 'gp-industry' ),
			array(
				esc_html__( 'High-precision 12kW fiber laser cutting and beveling', 'gp-industry' ),
				esc_html__( 'Coded TIG, MIG, and Submerged Arc Welding (SAW)', 'gp-industry' ),
				esc_html__( 'Heavy pressure vessel and storage tank fabrication', 'gp-industry' ),
				esc_html__( 'In-house grit blasting and epoxy industrial coatings', 'gp-industry' ),
			),
			'custom-fabrication.jpg',
		),
		array(
			'plant-maintenance',
			esc_html__( 'Plant Maintenance & Overhaul', 'gp-industry' ),
			esc_html__( 'Comprehensive preventive maintenance, turbine and compressor overhauls, laser shaft alignment, and 24/7 shutdown response.', 'gp-industry' ),
			array(
				esc_html__( 'On-site dynamic rotor balancing and vibration analysis', 'gp-industry' ),
				esc_html__( 'Laser optical alignment for gearboxes and drivetrains', 'gp-industry' ),
				esc_html__( 'Planned plant shutdown and turnaround management', 'gp-industry' ),
				esc_html__( '24/7 emergency repair and on-site line boring', 'gp-industry' ),
			),
			'plant-maintenance.jpg',
		),
		array(
			'engineering-prototyping',
			esc_html__( 'Engineering & Prototyping', 'gp-industry' ),
			esc_html__( 'CAD/CAM modeling, Finite Element Analysis (FEA) stress simulation, Design for Manufacturability (DFM), and rapid metal prototyping.', 'gp-industry' ),
			array(
				esc_html__( 'SolidWorks & CATIA parametric 3D CAD modeling', 'gp-industry' ),
				esc_html__( 'FEA structural, thermal, and fatigue simulations', 'gp-industry' ),
				esc_html__( 'Rapid functional metal prototyping within 5-7 days', 'gp-industry' ),
				esc_html__( 'Cost optimization and material substitution studies', 'gp-industry' ),
			),
			'engineering-cad.jpg',
		),
	);
	$service_child_ids = array();
	foreach ( $service_items as $i => $item ) {
		$content  = $fig( $item[4], $item[1] );
		$content .= $p( $item[2] );
		$content .= $ul( $item[3] );
		$content .= $h( esc_html__( 'Our Engineering Process', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Technical Review & DFM', 'gp-industry' ), 3 ) . $p( esc_html__( 'We analyze CAD drawings, material properties, and operational parameters to optimize for durability and cost.', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Precision Execution', 'gp-industry' ), 3 ) . $p( esc_html__( 'Manufactured using calibrated CNC equipment with in-process dimensional verifications.', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Inspection & Documentation', 'gp-industry' ), 3 ) . $p( esc_html__( 'Full dimensional inspection reports, material test certificates, and on-site testing.', 'gp-industry' ) );
		$content .= gpi_pattern_faq();
		$sid = gpi_demo_page(
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
		if ( $sid ) {
			$service_child_ids[] = $sid;
		}
		gpi_demo_featured( $sid, $item[1], $item[4] );
	}
	gpi_demo_featured( $services, esc_html__( 'Services', 'gp-industry' ), 'custom-fabrication.jpg' );

	/* Industries, Projects (Case studies), Contact */
	$industries = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Industries', 'gp-industry' ),
			'post_name'    => 'industries',
			'post_excerpt' => esc_html__( 'Critical manufacturing and engineering solutions across automotive, aerospace, energy, and heavy infrastructure.', 'gp-industry' ),
			'post_content' => $fig( 'industries-sectors.jpg', esc_html__( 'Global Industrial Sectors: Power, Infrastructure, Automotive & Aerospace', 'gp-industry' ) ) . gpi_pattern_industries() . "\n" . gpi_pattern_stats() . "\n" . gpi_pattern_testimonials(),
			'menu_order'   => 40,
		),
		'page-templates/auto-design.php',
		$result
	);
	gpi_demo_featured( $industries, esc_html__( 'Industries', 'gp-industry' ), 'industries-sectors.jpg' );

	$projects = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Projects', 'gp-industry' ),
			'post_name'    => 'case-studies',
			'post_excerpt' => esc_html__( 'A portfolio of recent heavy manufacturing, CNC machining, and turnkey engineering projects.', 'gp-industry' ),
			'post_content' => gpi_pattern_projects() . "\n" . gpi_pattern_certifications(),
			'menu_order'   => 50,
		),
		'page-templates/auto-design.php',
		$result
	);
	gpi_demo_featured( $projects, esc_html__( 'Projects', 'gp-industry' ), 'case-studies-projects.jpg' );

	$contact = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Contact', 'gp-industry' ),
			'post_name'    => 'contact',
			'post_excerpt' => esc_html__( 'Submit your CAD drawings or technical requirements for quotation and engineering feasibility.', 'gp-industry' ),
			'post_content' => $fig( 'contact-facility.jpg', esc_html__( 'Global Manufacturing Facility & Corporate Campus', 'gp-industry' ) ),
			'menu_order'   => 60,
		),
		'page-templates/contact.php',
		$result
	);
	gpi_demo_featured( $contact, esc_html__( 'Contact', 'gp-industry' ), 'contact-facility.jpg' );

	$news = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Insights', 'gp-industry' ),
			'post_name'    => 'insights',
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

	/* Demo images for Customizer-driven sections */
	set_theme_mod( 'gpi_hero_bg_1', esc_url( GPI_THEME_URI . '/assets/images/hero-industrial.jpg' ) );
	set_theme_mod( 'gpi_hero_bg_2', esc_url( GPI_THEME_URI . '/assets/images/heavy-machinery.jpg' ) );
	set_theme_mod( 'gpi_hero_bg_3', esc_url( GPI_THEME_URI . '/assets/images/industrial-automation.jpg' ) );
	set_theme_mod( 'gpi_home_about_image', esc_url( GPI_THEME_URI . '/assets/images/about-facility.jpg' ) );
	if ( ! gpi_get_option( 'contact_phone', '' ) || '+91 98765 43210' === gpi_get_option( 'contact_phone' ) ) {
		set_theme_mod( 'gpi_contact_address', $company . " Manufacturing Plant\nPlot 42, Heavy Industrial Zone, Phase II\nGreater Noida, Uttar Pradesh 201306" );
		set_theme_mod( 'gpi_contact_phone', '+91 (120) 456-7890' );
		set_theme_mod( 'gpi_contact_email', 'rfq@gp-industry.com' );
		set_theme_mod( 'gpi_contact_hours', "Mon – Sat: 08:00 – 19:00\nSunday: Plant Maintenance Only" );
	}

	/* Primary menu: create/assign the dedicated GP-Industry hierarchical menu */
	$pages_data = array(
		'home'              => $home,
		'about'             => $about,
		'products'          => $products,
		'solution_children' => $product_child_ids,
		'services'          => $services,
		'service_children'  => $service_child_ids,
		'industries'        => $industries,
		'case_studies'      => $projects,
		'contact'           => $contact,
	);
	gpi_setup_primary_menu( $pages_data );

	return $result;
}

/**
 * Helper to resolve a page ID by slug/path.
 *
 * @param string $slug Page slug or path.
 * @return int
 */
function gpi_get_page_id_by_slug( $slug ) {
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $page && isset( $page->ID ) ) {
		return (int) $page->ID;
	}
	$parts = explode( '/', trim( $slug, '/' ) );
	$last  = end( $parts );
	$posts = get_posts(
		array(
			'post_type'      => 'page',
			'name'           => $last,
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'post_status'    => 'any',
		)
	);
	return ! empty( $posts ) ? (int) $posts[0] : 0;
}

/**
 * Create or reset the dedicated GP-Industry Primary Menu with full hierarchical structure.
 *
 * @param array $pages Array of page IDs mapped by key.
 * @return int Menu term ID.
 */
function gpi_setup_primary_menu( $pages = array() ) {
	$menu_name = esc_html__( 'GP-Industry Primary Menu', 'gp-industry' );
	$menu_obj  = wp_get_nav_menu_object( $menu_name );

	if ( ! $menu_obj ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = $menu_obj->term_id;
	}

	if ( is_wp_error( $menu_id ) || ! $menu_id ) {
		return 0;
	}

	// Force-assign this GP-Industry menu to theme locations
	$locations                 = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary-menu'] = $menu_id;
	$locations['footer-menu']  = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	// Resolve page IDs
	$home_id       = ! empty( $pages['home'] ) ? $pages['home'] : gpi_get_page_id_by_slug( 'home' );
	$about_id      = ! empty( $pages['about'] ) ? $pages['about'] : gpi_get_page_id_by_slug( 'about-us' );
	$products_id   = ! empty( $pages['products'] ) ? $pages['products'] : gpi_get_page_id_by_slug( 'products' );
	$services_id   = ! empty( $pages['services'] ) ? $pages['services'] : gpi_get_page_id_by_slug( 'services' );
	$industries_id = ! empty( $pages['industries'] ) ? $pages['industries'] : gpi_get_page_id_by_slug( 'industries' );
	$projects_id   = ! empty( $pages['case_studies'] ) ? $pages['case_studies'] : gpi_get_page_id_by_slug( 'case-studies' );
	$contact_id    = ! empty( $pages['contact'] ) ? $pages['contact'] : gpi_get_page_id_by_slug( 'contact' );

	// Clear previous items to avoid duplicate or obsolete links
	$existing_items = wp_get_nav_menu_items( $menu_id );
	if ( ! empty( $existing_items ) ) {
		foreach ( $existing_items as $item ) {
			wp_delete_post( $item->ID, true );
		}
	}

	$order = 1;

	// 1. Home
	if ( $home_id ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => esc_html__( 'Home', 'gp-industry' ),
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $home_id,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-position'  => $order++,
			)
		);
	}

	// 2. About Us
	if ( $about_id ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => esc_html__( 'About Us', 'gp-industry' ),
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $about_id,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-position'  => $order++,
			)
		);
	}

	// 3. Products (with child dropdown)
	if ( $products_id ) {
		$prod_menu_id = wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => esc_html__( 'Products', 'gp-industry' ),
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $products_id,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-position'  => $order++,
			)
		);

		$prod_children = ! empty( $pages['solution_children'] ) ? $pages['solution_children'] : array(
			gpi_get_page_id_by_slug( 'products/heavy-industrial-machinery' ),
			gpi_get_page_id_by_slug( 'products/precision-cnc-components' ),
			gpi_get_page_id_by_slug( 'products/industrial-automation' ),
		);
		foreach ( $prod_children as $cid ) {
			if ( $cid ) {
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'     => get_the_title( $cid ),
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $cid,
						'menu-item-parent-id' => $prod_menu_id,
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => $order++,
					)
				);
			}
		}
	}

	// 4. Services (with child dropdown)
	if ( $services_id ) {
		$srv_menu_id = wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => esc_html__( 'Services', 'gp-industry' ),
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $services_id,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-position'  => $order++,
			)
		);

		$srv_children = ! empty( $pages['service_children'] ) ? $pages['service_children'] : array(
			gpi_get_page_id_by_slug( 'services/custom-fabrication' ),
			gpi_get_page_id_by_slug( 'services/plant-maintenance' ),
			gpi_get_page_id_by_slug( 'services/engineering-prototyping' ),
		);
		foreach ( $srv_children as $cid ) {
			if ( $cid ) {
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'     => get_the_title( $cid ),
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $cid,
						'menu-item-parent-id' => $srv_menu_id,
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => $order++,
					)
				);
			}
		}
	}

	// 5. Industries
	if ( $industries_id ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => esc_html__( 'Industries', 'gp-industry' ),
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $industries_id,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-position'  => $order++,
			)
		);
	}

	// 6. Projects
	if ( $projects_id ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => esc_html__( 'Projects', 'gp-industry' ),
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $projects_id,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-position'  => $order++,
			)
		);
	}

	// 7. Contact
	if ( $contact_id ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => esc_html__( 'Contact', 'gp-industry' ),
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $contact_id,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-position'  => $order++,
			)
		);
	}

	return $menu_id;
}
