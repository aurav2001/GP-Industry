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
function gpi_demo_image( $label, $seed = 0, $w = 1600, $h = 1000 ) {
	if ( ! function_exists( 'imagecreatetruecolor' ) ) {
		return 0;
	}

	$slug     = sanitize_title( 'gpi-demo-' . $label );
	$existing = get_posts( array( 'post_type' => 'attachment', 'name' => $slug, 'posts_per_page' => 1, 'fields' => 'ids', 'post_status' => 'inherit' ) );
	if ( $existing ) {
		return (int) $existing[0];
	}

	$palettes = array(
		array( array( 99, 102, 241 ), array( 236, 72, 153 ) ),
		array( array( 6, 182, 212 ), array( 99, 102, 241 ) ),
		array( array( 245, 158, 11 ), array( 236, 72, 153 ) ),
		array( array( 16, 185, 129 ), array( 6, 182, 212 ) ),
		array( array( 139, 92, 246 ), array( 59, 130, 246 ) ),
		array( array( 244, 63, 94 ), array( 251, 146, 60 ) ),
	);
	list( $c1, $c2 ) = $palettes[ $seed % count( $palettes ) ];

	$im = imagecreatetruecolor( $w, $h );
	for ( $x = 0; $x < $w; $x += 4 ) {
		$t   = $x / $w;
		$col = imagecolorallocate( $im, (int) ( $c1[0] + ( $c2[0] - $c1[0] ) * $t ), (int) ( $c1[1] + ( $c2[1] - $c1[1] ) * $t ), (int) ( $c1[2] + ( $c2[2] - $c1[2] ) * $t ) );
		imagefilledrectangle( $im, $x, 0, $x + 4, $h, $col );
	}
	// Dark vignette band at the bottom + subtle grid.
	$dark = imagecolorallocatealpha( $im, 5, 8, 18, 70 );
	imagefilledrectangle( $im, 0, (int) ( $h * 0.62 ), $w, $h, $dark );
	$line = imagecolorallocatealpha( $im, 255, 255, 255, 110 );
	for ( $x = 0; $x < $w; $x += 80 ) {
		imageline( $im, $x, 0, $x, $h, $line );
	}
	for ( $y = 0; $y < $h; $y += 80 ) {
		imageline( $im, 0, $y, $w, $y, $line );
	}
	// Circles / "machinery" shapes.
	$ring = imagecolorallocatealpha( $im, 255, 255, 255, 95 );
	imagesetthickness( $im, 6 );
	imageellipse( $im, (int) ( $w * 0.72 ), (int) ( $h * 0.38 ), (int) ( $h * 0.7 ), (int) ( $h * 0.7 ), $ring );
	imageellipse( $im, (int) ( $w * 0.72 ), (int) ( $h * 0.38 ), (int) ( $h * 0.45 ), (int) ( $h * 0.45 ), $ring );
	imageellipse( $im, (int) ( $w * 0.72 ), (int) ( $h * 0.38 ), (int) ( $h * 0.2 ), (int) ( $h * 0.2 ), $ring );

	// Label (built-in font scaled up = pixel look, still readable).
	$white = imagecolorallocate( $im, 255, 255, 255 );
	$scale = max( 3, (int) round( $w / 400 ) );
	$fw    = imagefontwidth( 5 ) * strlen( $label );
	$tmp   = imagecreatetruecolor( $fw + 4, imagefontheight( 5 ) + 4 );
	imagealphablending( $tmp, false );
	imagesavealpha( $tmp, true );
	imagefill( $tmp, 0, 0, imagecolorallocatealpha( $tmp, 0, 0, 0, 127 ) );
	imagestring( $tmp, 5, 2, 2, $label, imagecolorallocate( $tmp, 255, 255, 255 ) );
	imagecopyresized( $im, $tmp, (int) ( $w * 0.06 ), (int) ( $h * 0.78 ), 0, 0, ( $fw + 4 ) * $scale, ( imagefontheight( 5 ) + 4 ) * $scale, $fw + 4, imagefontheight( 5 ) + 4 );
	imagedestroy( $tmp );
	imagefilledrectangle( $im, (int) ( $w * 0.06 ), (int) ( $h * 0.74 ), (int) ( $w * 0.06 ) + 90, (int) ( $h * 0.74 ) + 8, $white );

	$upload = wp_upload_dir();
	$file   = trailingslashit( $upload['path'] ) . $slug . '.jpg';
	imagejpeg( $im, $file, 82 );
	imagedestroy( $im );

	$id = wp_insert_attachment(
		array(
			'post_mime_type' => 'image/jpeg',
			'post_title'     => $label,
			'post_name'      => $slug,
			'post_status'    => 'inherit',
		),
		$file
	);
	if ( ! $id || is_wp_error( $id ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );
	return (int) $id;
}

/**
 * Attach a generated demo image as featured image (only if the page has none).
 *
 * @param int    $page_id Page ID.
 * @param string $label   Image label.
 * @param int    $seed    Palette seed.
 */
function gpi_demo_featured( $page_id, $label, $seed = 0 ) {
	if ( ! $page_id || has_post_thumbnail( $page_id ) ) {
		return;
	}
	$img = gpi_demo_image( $label, $seed );
	if ( $img ) {
		set_post_thumbnail( $page_id, $img );
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
	$about_content  = $p( esc_html__( 'Who we are', 'gp-industry' ) );
	/* translators: %s: company name */
	$about_content .= $h( sprintf( esc_html__( '%s — your partner for people, compliance and facilities', 'gp-industry' ), $company ) );
	/* translators: %s: company name */
	$about_content .= $p( sprintf( esc_html__( '%s is a corporate consultancy that helps organisations run smoothly. We recruit, train and manage personnel, keep every statutory obligation in order, and operate facilities that are clean, safe and secure — so our clients can focus on their core business. Edit this text with your own story.', 'gp-industry' ), $company ) );
	$about_content .= $p( esc_html__( 'Our approach is simple: understand the client’s sites, shifts and risks first; design a solution around them; then deliver it with dedicated supervision, transparent reporting and complete accountability.', 'gp-industry' ) );
	$about_content .= $p( esc_html__( 'Corporate Solutions', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Comprehensive facilities & staffing ecosystem', 'gp-industry' ) );
	$about_content .= $p( esc_html__( 'Tailored corporate services designed to accelerate business productivity, guarantee 100% statutory compliance and ensure robust operational security.', 'gp-industry' ) );
	$about_content .= $p( esc_html__( 'Workforce Solutions', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'HR Staffing & Payroll Management', 'gp-industry' ), 3 ) . $p( esc_html__( 'Trained and vetted personnel, manager-level staff, a dedicated in-house Resource Cell and 100% statutory payroll.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Statutory Compliance', 'gp-industry' ), 3 ) . $p( esc_html__( 'PF, ESIC, professional tax, labour licences and monthly filings — audit-ready, every month.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Manpower Outsourcing', 'gp-industry' ), 3 ) . $p( esc_html__( 'Skilled, semi-skilled and support staff deployed on your payroll or ours, with on-site supervision.', 'gp-industry' ) );
	$about_content .= $p( esc_html__( 'Facility Solutions', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Housekeeping & Hygiene', 'gp-industry' ), 3 ) . $p( esc_html__( 'Mechanised cleaning, pest control and waste management for offices, plants and hospitals.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Security Services', 'gp-industry' ), 3 ) . $p( esc_html__( 'Trained guards, supervisors and access control aligned with PSARA requirements.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Facility Management', 'gp-industry' ), 3 ) . $p( esc_html__( 'Front-office, pantry, technical maintenance and vendor management under one contract.', 'gp-industry' ) );
	$about_content .= $h( esc_html__( 'Our credentials', 'gp-industry' ) );
	$about_content .= $ul( array( esc_html__( 'ISO 9001:2015 certified quality management', 'gp-industry' ), esc_html__( 'PSARA licensed security operations', 'gp-industry' ), esc_html__( 'Registered under Contract Labour, PF and ESIC acts', 'gp-industry' ), esc_html__( 'MSME and Startup India recognised', 'gp-industry' ) ) );
	$about_content .= gpi_pattern_process() . "\n" . gpi_pattern_team( $avatar ) . "\n" . gpi_pattern_faq();

	$about = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'About Us', 'gp-industry' ),
			'post_name'    => 'about-us',
			'post_excerpt' => esc_html__( 'Corporate staffing, compliance and facility consultancy you can rely on.', 'gp-industry' ),
			'post_content' => $about_content,
			'menu_order'   => 10,
		),
		'page-templates/about.php',
		$result
	);
	gpi_demo_featured( $about, esc_html__( 'About Us', 'gp-industry' ), 1 );

	/* Solutions (Products template) + children */
	$products = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Solutions', 'gp-industry' ),
			'post_name'    => 'solutions',
			'post_excerpt' => esc_html__( 'Packaged solutions for workforce, compliance and facility needs.', 'gp-industry' ),
			'post_content' => '',
			'menu_order'   => 20,
		),
		'page-templates/products.php',
		$result
	);
	$product_items = array(
		array( 'workforce-outsourcing', esc_html__( 'Workforce Outsourcing', 'gp-industry' ), esc_html__( 'Skilled and support staff on our payroll — recruited, verified, trained and supervised for you.', 'gp-industry' ), array( esc_html__( 'Background & police verification', 'gp-industry' ), esc_html__( 'Role-specific induction and training', 'gp-industry' ), esc_html__( 'Replacement guarantee within 48 hours', 'gp-industry' ), esc_html__( 'Attendance & MIS reporting', 'gp-industry' ) ) ),
		array( 'payroll-compliance', esc_html__( 'Payroll & Statutory Compliance', 'gp-industry' ), esc_html__( 'End-to-end payroll processing with PF, ESIC, PT, LWF and labour-law compliance.', 'gp-industry' ), array( esc_html__( 'Monthly payroll and payslips', 'gp-industry' ), esc_html__( 'PF / ESIC registrations and challans', 'gp-industry' ), esc_html__( 'Labour licence and register maintenance', 'gp-industry' ), esc_html__( 'Audit support and compliance calendar', 'gp-industry' ) ) ),
		array( 'integrated-facility-management', esc_html__( 'Integrated Facility Management', 'gp-industry' ), esc_html__( 'Housekeeping, security, pantry, front-office and maintenance under a single accountable contract.', 'gp-industry' ), array( esc_html__( 'Mechanised housekeeping & hygiene', 'gp-industry' ), esc_html__( 'PSARA-compliant security', 'gp-industry' ), esc_html__( 'Technical & soft services', 'gp-industry' ), esc_html__( 'Single point of contact & SLAs', 'gp-industry' ) ) ),
	);
	foreach ( $product_items as $i => $item ) {
		$content  = $p( $item[2] );
		$content .= $ul( $item[3] );
		$content .= $h( esc_html__( 'What you get', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Dedicated account manager', 'gp-industry' ), 3 ) . $p( esc_html__( 'One owner for service quality, escalations and monthly reviews.', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Transparent pricing', 'gp-industry' ), 3 ) . $p( esc_html__( 'Clear per-head or per-site costing with no hidden charges.', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Compliance you can prove', 'gp-industry' ), 3 ) . $p( esc_html__( 'Audit-ready documentation shared every month.', 'gp-industry' ) );
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
		gpi_demo_featured( $pid, $item[1], $i );
	}
	gpi_demo_featured( $products, esc_html__( 'Solutions', 'gp-industry' ), 4 );

	/* Services + children */
	$services = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Services', 'gp-industry' ),
			'post_name'    => 'services',
			'post_excerpt' => esc_html__( 'Staffing, compliance, housekeeping and security — delivered with accountability.', 'gp-industry' ),
			'post_content' => '',
			'menu_order'   => 30,
		),
		'page-templates/services.php',
		$result
	);
	$service_items = array(
		array( 'hr-staffing-payroll', esc_html__( 'HR Staffing & Payroll Management', 'gp-industry' ), esc_html__( 'Trained, vetted personnel and manager-level staff from our in-house National Resource Cell, with 100% statutory payroll.', 'gp-industry' ), array( esc_html__( 'Sourcing, screening and induction', 'gp-industry' ), esc_html__( 'Statutory payroll with PF & ESIC', 'gp-industry' ), esc_html__( 'Attendance and leave management', 'gp-industry' ), esc_html__( 'Monthly MIS and compliance reports', 'gp-industry' ) ) ),
		array( 'housekeeping-hygiene', esc_html__( 'Housekeeping & Hygiene', 'gp-industry' ), esc_html__( 'Mechanised cleaning, pest control, waste management and hygiene audits for offices, plants and hospitals.', 'gp-industry' ), array( esc_html__( 'Trained housekeeping staff with supervisors', 'gp-industry' ), esc_html__( 'Mechanised equipment and eco-friendly consumables', 'gp-industry' ), esc_html__( 'Daily checklists and hygiene audits', 'gp-industry' ), esc_html__( 'Pest control and waste management', 'gp-industry' ) ) ),
		array( 'security-services', esc_html__( 'Security Services', 'gp-industry' ), esc_html__( 'PSARA-compliant guards, supervisors and access control for corporate, industrial and residential sites.', 'gp-industry' ), array( esc_html__( 'Verified and trained security personnel', 'gp-industry' ), esc_html__( 'Access control and visitor management', 'gp-industry' ), esc_html__( '24×7 supervision and patrolling', 'gp-industry' ), esc_html__( 'Incident reporting and escalation', 'gp-industry' ) ) ),
	);
	foreach ( $service_items as $i => $item ) {
		$content  = $p( $item[2] );
		$content .= $ul( $item[3] );
		$content .= $h( esc_html__( 'How it works', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Assessment', 'gp-industry' ), 3 ) . $p( esc_html__( 'We visit your site, understand shifts, headcount and risks, and define SLAs.', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Deployment', 'gp-industry' ), 3 ) . $p( esc_html__( 'Verified, trained staff mobilised with a supervisor and clear checklists.', 'gp-industry' ) );
		$content .= $h( esc_html__( 'Review', 'gp-industry' ), 3 ) . $p( esc_html__( 'Monthly reports, audits and a dedicated manager for continuous improvement.', 'gp-industry' ) );
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
		gpi_demo_featured( $sid, $item[1], $i + 1 );
	}
	gpi_demo_featured( $services, esc_html__( 'Services', 'gp-industry' ), 5 );

	/* Training + children */
	$courses = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Training', 'gp-industry' ),
			'post_name'    => 'training',
			'post_excerpt' => esc_html__( 'Induction, skill and compliance training programs for your workforce.', 'gp-industry' ),
			'post_content' => '',
			'menu_order'   => 55,
		),
		'page-templates/courses.php',
		$result
	);
	$course_items = array(
		array( 'workplace-safety-compliance', esc_html__( 'Workplace Safety & Compliance', 'gp-industry' ), esc_html__( 'Fire safety, first aid, POSH awareness and statutory compliance essentials for staff and supervisors.', 'gp-industry' ) ),
		array( 'housekeeping-hospitality-skills', esc_html__( 'Housekeeping & Hospitality Skills', 'gp-industry' ), esc_html__( 'Professional cleaning methods, equipment handling, hygiene standards and guest etiquette.', 'gp-industry' ) ),
		array( 'supervisor-development', esc_html__( 'Supervisor Development Program', 'gp-industry' ), esc_html__( 'Team leadership, shift planning, reporting and client communication for site supervisors.', 'gp-industry' ) ),
	);
	foreach ( $course_items as $i => $item ) {
		$cid = gpi_demo_page(
			array(
				'post_title'   => $item[1],
				'post_name'    => $item[0],
				'post_excerpt' => $item[2],
				'post_content' => '',
				'post_parent'  => $courses,
				'menu_order'   => $i + 1,
			),
			'page-templates/course-single.php',
			$result
		);
		gpi_demo_featured( $cid, $item[1], $i + 2 );
	}
	gpi_demo_featured( $courses, esc_html__( 'Training', 'gp-industry' ), 2 );

	/* Why choose us — auto-layout demo */
	$why  = $p( esc_html__( 'Our advantages', 'gp-industry' ) );
	/* translators: %s: company name */
	$why .= $h( sprintf( esc_html__( 'Why businesses choose %s', 'gp-industry' ), $company ) );
	$why .= $p( esc_html__( 'This page is written as plain headings and paragraphs — the "Designed Sections (Auto)" template turns them into sections, cards and checklists automatically.', 'gp-industry' ) );
	$why .= $p( esc_html__( 'Core strengths', 'gp-industry' ) );
	$why .= $h( esc_html__( 'Vetted Workforce', 'gp-industry' ), 3 ) . $p( esc_html__( 'Background-verified, trained and supervised staff from our own resource cell.', 'gp-industry' ) );
	$why .= $h( esc_html__( '100% Compliance', 'gp-industry' ), 3 ) . $p( esc_html__( 'PF, ESIC, labour law and payroll compliance handled end-to-end.', 'gp-industry' ) );
	$why .= $h( esc_html__( 'Rapid Deployment', 'gp-industry' ), 3 ) . $p( esc_html__( 'Teams mobilised within days with on-site supervision from day one.', 'gp-industry' ) );
	$why .= $h( esc_html__( 'Our commitments', 'gp-industry' ) );
	$why .= $p( esc_html__( 'Every client, large or small, gets the same attention to service quality, documentation and response time.', 'gp-industry' ) );
	$why .= $ul( array( esc_html__( 'Proposal within 24 hours', 'gp-industry' ), esc_html__( 'Replacement guarantee within 48 hours', 'gp-industry' ), esc_html__( 'Monthly MIS and compliance reports', 'gp-industry' ), esc_html__( 'Dedicated account manager', 'gp-industry' ) ) );
	$why .= '<!-- wp:quote --><blockquote class="wp-block-quote"><!-- wp:paragraph --><p>' . esc_html__( 'Take care of your people and your people will take care of your business.', 'gp-industry' ) . '</p><!-- /wp:paragraph --><cite>' . esc_html__( 'Our founding principle', 'gp-industry' ) . '</cite></blockquote><!-- /wp:quote -->';
	$why_id = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Why Choose Us', 'gp-industry' ),
			'post_name'    => 'why-choose-us',
			'post_excerpt' => esc_html__( 'Plain content, automatically designed.', 'gp-industry' ),
			'post_content' => $why,
			'menu_order'   => 15,
		),
		'page-templates/auto-design.php',
		$result
	);
	gpi_demo_featured( $why_id, esc_html__( 'Why Choose Us', 'gp-industry' ), 3 );

	/* Industries, Case studies, Contact, Insights */
	$industries = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Industries', 'gp-industry' ),
			'post_name'    => 'industries',
			'post_excerpt' => esc_html__( 'Proven experience across corporate, industrial and service sectors.', 'gp-industry' ),
			'post_content' => gpi_pattern_industries() . "\n" . gpi_pattern_stats() . "\n" . gpi_pattern_testimonials(),
			'menu_order'   => 40,
		),
		'page-templates/auto-design.php',
		$result
	);
	gpi_demo_featured( $industries, esc_html__( 'Industries', 'gp-industry' ), 0 );
	$projects = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Case Studies', 'gp-industry' ),
			'post_name'    => 'case-studies',
			'post_excerpt' => esc_html__( 'A selection of recent engagements and results.', 'gp-industry' ),
			'post_content' => gpi_pattern_projects( $img ) . "\n" . gpi_pattern_certifications(),
			'menu_order'   => 50,
		),
		'page-templates/auto-design.php',
		$result
	);
	gpi_demo_featured( $projects, esc_html__( 'Case Studies', 'gp-industry' ), 3 );
	$contact = gpi_demo_page(
		array(
			'post_title'   => esc_html__( 'Contact', 'gp-industry' ),
			'post_name'    => 'contact',
			'post_excerpt' => esc_html__( 'Tell us about your requirement — we reply within one business day.', 'gp-industry' ),
			'post_content' => '',
			'menu_order'   => 60,
		),
		'page-templates/contact.php',
		$result
	);
	gpi_demo_featured( $contact, esc_html__( 'Contact', 'gp-industry' ), 1 );
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

	/* Demo images for Customizer-driven sections (only when nothing is set yet) */
	if ( ! gpi_get_option( 'hero_bg_1', '' ) ) {
		foreach ( array( 1 => esc_html__( 'Corporate Consultancy', 'gp-industry' ), 2 => esc_html__( 'Workforce Solutions', 'gp-industry' ), 3 => esc_html__( 'Facility Management', 'gp-industry' ) ) as $n => $label ) {
			$img = gpi_demo_image( $label, $n + 3, 1920, 1080 );
			if ( $img ) {
				set_theme_mod( 'gpi_hero_bg_' . $n, wp_get_attachment_url( $img ) );
			}
		}
	}
	if ( ! gpi_get_option( 'home_about_image', '' ) ) {
		$img = gpi_demo_image( esc_html__( 'Our Team', 'gp-industry' ), 1, 1200, 1000 );
		if ( $img ) {
			set_theme_mod( 'gpi_home_about_image', wp_get_attachment_url( $img ) );
		}
	}
	if ( ! gpi_get_option( 'contact_phone', '' ) ) {
		set_theme_mod( 'gpi_contact_address', $company . "\n" . "3rd Floor, Corporate Park, Sector 62\nNoida, Uttar Pradesh 201301" );
		set_theme_mod( 'gpi_contact_phone', '+91 98765 43210' );
		set_theme_mod( 'gpi_contact_email', 'info@example.com' );
		set_theme_mod( 'gpi_contact_hours', "Mon – Sat: 9:00 – 18:00\nSunday: Closed" );
	}

	/* Primary menu: create one, or add the demo pages to the existing one */
	$menu_pages = array( $home, $about, $why_id, $products, $services, $industries, $projects, $courses, $news, $contact );
	$locations  = get_theme_mod( 'nav_menu_locations', array() );
	$menu_id    = ! empty( $locations['primary-menu'] ) ? (int) $locations['primary-menu'] : 0;
	if ( ! $menu_id || ! wp_get_nav_menu_object( $menu_id ) ) {
		$menu_id = wp_create_nav_menu( esc_html__( 'Primary Menu', 'gp-industry' ) );
		if ( is_wp_error( $menu_id ) ) {
			$menu_id = 0;
		} else {
			$locations['primary-menu'] = $menu_id;
			if ( empty( $locations['footer-menu'] ) ) {
				$locations['footer-menu'] = $menu_id;
			}
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}
	if ( $menu_id ) {
		$in_menu = array();
		foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $mi ) {
			if ( 'page' === $mi->object ) {
				$in_menu[] = (int) $mi->object_id;
			}
		}
		$order = count( $in_menu ) + 1;
		foreach ( $menu_pages as $page_id ) {
			if ( ! $page_id || in_array( (int) $page_id, $in_menu, true ) ) {
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
	}

	return $result;
}
