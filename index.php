<?php
/**
 * Plugin Name: WPYog Documents
 * Plugin URI:  https://poppinsdigital.com/
 * Description: A complete document management solution for WordPress — upload, categorize, and publish files with secure downloads, category filters, and a flexible shortcode.
 * Author:      poppinsdigital.com
 * Author URI:  https://poppinsdigital.com/
 * Version:     1.5.1
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wpyog-documents
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPYOG_DOCUMENTS_VERSION', '1.5.1' );

if ( ! defined( 'WPYOG_RESEARCH_PLUGIN_DIR' ) ) {
	define( 'WPYOG_RESEARCH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WPYOG_RESEARCH_PLUGIN_URL' ) ) {
	define( 'WPYOG_RESEARCH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// -------------------------------------------------------------------------
// Post Type & Taxonomy Registration
// -------------------------------------------------------------------------

add_action( 'init', 'wpyog_research_education', 1 );
function wpyog_research_education() {

	$document_labels = array(
		'name'               => __( 'WPYog Documents', 'wpyog-documents' ),
		'singular_name'      => __( 'WPYog Document', 'wpyog-documents' ),
		'add_new'            => __( 'Add Document', 'wpyog-documents' ),
		'add_new_item'       => __( 'Add New Document', 'wpyog-documents' ),
		'edit_item'          => __( 'Edit Document', 'wpyog-documents' ),
		'new_item'           => __( 'New Document', 'wpyog-documents' ),
		'view_item'          => __( 'View Document', 'wpyog-documents' ),
		'search_items'       => __( 'Search Documents', 'wpyog-documents' ),
		'not_found'          => __( 'No Documents found', 'wpyog-documents' ),
		'not_found_in_trash' => __( 'No Documents found in Trash', 'wpyog-documents' ),
		'parent_item_colon'  => '',
		'menu_name'          => __( 'Documents', 'wpyog-documents' ),
	);

	$document_args = array(
		'labels'              => $document_labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var'           => true,
		'rewrite'             => array(
			'slug'       => 'wpyog_document',
			'with_front' => false,
		),
		'capability_type'     => 'post',
		'has_archive'         => true,
		'hierarchical'        => false,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-wpyog-icon',
		'supports'            => array( 'title', 'editor', 'thumbnail', 'author', 'revisions' ),
		'show_in_rest'        => true,
		'taxonomies'          => array( 'wpyog_document_category' ),
	);

	register_post_type( 'wpyog_document', $document_args );

	register_taxonomy(
		'wpyog_document_category',
		array( 'wpyog_document' ),
		array(
			'label'             => __( 'Category', 'wpyog-documents' ),
			'rewrite'           => array( 'slug' => 'wpyog_document-category' ),
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'labels'            => array(
				'singular_name'              => __( 'Category', 'wpyog-documents' ),
				'all_items'                  => __( 'All Categories', 'wpyog-documents' ),
				'edit_item'                  => __( 'Edit Category', 'wpyog-documents' ),
				'view_item'                  => __( 'View Category', 'wpyog-documents' ),
				'update_item'                => __( 'Update Category', 'wpyog-documents' ),
				'add_new_item'               => __( 'Add New Category', 'wpyog-documents' ),
				'new_item_name'              => __( 'New Category Name', 'wpyog-documents' ),
				'search_items'               => __( 'Search Categories', 'wpyog-documents' ),
				'popular_items'              => __( 'Popular Categories', 'wpyog-documents' ),
				'separate_items_with_commas' => __( 'Separate categories with commas', 'wpyog-documents' ),
				'choose_from_most_used'      => __( 'Choose from most used categories', 'wpyog-documents' ),
				'not_found'                  => __( 'No categories found', 'wpyog-documents' ),
			),
		)
	);

	register_taxonomy_for_object_type( 'wpyog_document_category', 'wpyog_document' );
}

// -------------------------------------------------------------------------
// Admin Submenu – Shortcode Generator
// -------------------------------------------------------------------------

add_action( 'admin_menu', 'wpyog_register_shortcode_ref_page', 1 );
function wpyog_register_shortcode_ref_page() {
	add_submenu_page(
		'edit.php?post_type=wpyog_document',
		__( 'Shortcode Generator', 'wpyog-documents' ),
		__( 'Shortcode Generator', 'wpyog-documents' ),
		'manage_options',
		'document-shortcode-ref',
		'wpyog_document_ref_page_callback'
	);
}

function wpyog_document_ref_page_callback() {
	$categories = get_terms( array(
		'taxonomy'   => 'wpyog_document_category',
		'hide_empty' => false,
	) );
	?>
	<div class="wrap">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Shortcode Generator', 'wpyog-documents' ); ?></h1>
		<hr class="wp-header-end" style="margin-bottom:20px;">
		<div style="display:flex;gap:20px;max-width:1100px;align-items:flex-start;flex-wrap:wrap;">

			<!-- Configure panel -->
			<div style="flex:1;min-width:320px;background:#fff;padding:24px 28px;border:1px solid #c3c4c7;border-radius:6px;box-shadow:0 1px 2px rgba(0,0,0,.05);">
				<h2 style="margin-top:0;font-size:.9rem;text-transform:uppercase;letter-spacing:.06em;color:#50575e;"><?php esc_html_e( 'Configure', 'wpyog-documents' ); ?></h2>
				<table class="form-table" style="margin:0;">
					<tbody>
						<tr>
							<th style="width:140px;font-weight:600;"><label for="sc-category"><?php esc_html_e( 'Category', 'wpyog-documents' ); ?></label></th>
							<td>
								<select id="sc-category" onchange="wpyogBuild()" style="min-width:210px;">
									<option value=""><?php esc_html_e( 'All categories', 'wpyog-documents' ); ?></option>
									<?php if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) : foreach ( $categories as $cat ) : ?>
										<option value="<?php echo esc_attr( $cat->term_id ); ?>"><?php echo esc_html( $cat->name ); ?> (ID: <?php echo esc_html( $cat->term_id ); ?>)</option>
									<?php endforeach; endif; ?>
								</select>
							</td>
						</tr>
						<tr>
							<th><label for="sc-columns"><?php esc_html_e( 'Columns', 'wpyog-documents' ); ?></label></th>
							<td>
								<select id="sc-columns" onchange="wpyogBuild()">
									<option value="1"><?php esc_html_e( '1 column (default)', 'wpyog-documents' ); ?></option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
							</td>
						</tr>
						<tr>
							<th><label for="sc-limit"><?php esc_html_e( 'Limit', 'wpyog-documents' ); ?></label></th>
							<td><input type="number" id="sc-limit" value="" min="1" max="999" placeholder="<?php esc_attr_e( 'Show all', 'wpyog-documents' ); ?>" style="width:110px;" oninput="wpyogBuild()"></td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Sort', 'wpyog-documents' ); ?></th>
							<td style="display:flex;gap:8px;">
								<select id="sc-orderby" onchange="wpyogBuild()">
									<option value="date"><?php esc_html_e( 'Date', 'wpyog-documents' ); ?></option>
									<option value="title"><?php esc_html_e( 'Title', 'wpyog-documents' ); ?></option>
									<option value="menu_order"><?php esc_html_e( 'Custom order', 'wpyog-documents' ); ?></option>
								</select>
								<select id="sc-order" onchange="wpyogBuild()">
									<option value="DESC"><?php esc_html_e( 'Newest first', 'wpyog-documents' ); ?></option>
									<option value="ASC"><?php esc_html_e( 'Oldest first', 'wpyog-documents' ); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Display', 'wpyog-documents' ); ?></th>
							<td>
								<label style="display:block;margin-bottom:6px;"><input type="checkbox" id="sc-desc" onchange="wpyogBuild()"> <?php esc_html_e( 'Show description', 'wpyog-documents' ); ?></label>
								<label style="display:block;margin-bottom:6px;"><input type="checkbox" id="sc-date" onchange="wpyogBuild()"> <?php esc_html_e( 'Show date', 'wpyog-documents' ); ?></label>
								<label style="display:block;"><input type="checkbox" id="sc-download" onchange="wpyogBuild()"> <?php esc_html_e( 'Show download button', 'wpyog-documents' ); ?></label>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!-- Output panel -->
			<div style="flex:1;min-width:300px;background:#fff;padding:24px 28px;border:1px solid #c3c4c7;border-radius:6px;box-shadow:0 1px 2px rgba(0,0,0,.05);">
				<h2 style="margin-top:0;font-size:.9rem;text-transform:uppercase;letter-spacing:.06em;color:#50575e;"><?php esc_html_e( 'Your Shortcode', 'wpyog-documents' ); ?></h2>
				<div id="sc-output" style="background:#f6f7f7;border:1px solid #ddd;border-left:4px solid #2271b1;border-radius:4px;padding:14px 16px;font-family:monospace;font-size:.95rem;word-break:break-all;min-height:48px;color:#1e1e1e;line-height:1.5;">[wpyog-document-list]</div>
				<div style="margin-top:12px;display:flex;align-items:center;gap:10px;">
					<button type="button" class="button button-primary" onclick="wpyogCopy()"><?php esc_html_e( 'Copy Shortcode', 'wpyog-documents' ); ?></button>
					<span id="sc-copied" style="color:#00a32a;font-weight:500;display:none;">&#10003; <?php esc_html_e( 'Copied!', 'wpyog-documents' ); ?></span>
				</div>
				<hr style="margin:22px 0 18px;">
				<h3 style="font-size:.9rem;margin:0 0 5px;font-weight:600;"><?php esc_html_e( 'Single document shortcode', 'wpyog-documents' ); ?></h3>
				<p style="font-size:.83rem;color:#666;margin:0 0 8px;"><?php esc_html_e( 'Copy the ID from the Documents list (Shortcode column), then use:', 'wpyog-documents' ); ?></p>
				<code style="background:#f6f7f7;border:1px solid #ddd;padding:8px 12px;border-radius:4px;display:block;font-size:.9rem;">[wpyog-document id=42]</code>
				<hr style="margin:18px 0;">
				<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=wpyog_document' ) ); ?>" class="button">&#8592; <?php esc_html_e( 'All Documents', 'wpyog-documents' ); ?></a>
			</div>
		</div>

		<!-- More Plugins from the Developer -->
		<div style="max-width:1100px;margin-top:28px;">
			<h2 style="font-size:.9rem;text-transform:uppercase;letter-spacing:.06em;color:#50575e;margin-bottom:14px;"><?php esc_html_e( 'More free plugins from the developer', 'wpyog-documents' ); ?></h2>
			<div style="display:flex;gap:16px;flex-wrap:wrap;">

				<div style="flex:1;min-width:240px;background:#fff;border:1px solid #c3c4c7;border-radius:6px;padding:18px 20px;box-shadow:0 1px 2px rgba(0,0,0,.05);display:flex;gap:14px;align-items:flex-start;">
					<div style="flex-shrink:0;width:40px;height:40px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;">
						<span class="dashicons dashicons-groups" style="color:#4f46e5;font-size:22px;"></span>
					</div>
					<div style="flex:1;min-width:0;">
						<strong style="font-size:.95rem;display:block;margin-bottom:4px;">WPYog Team</strong>
						<p style="font-size:.83rem;color:#50575e;margin:0 0 10px;line-height:1.5;"><?php esc_html_e( 'Display your team members beautifully on any post or page with a simple shortcode.', 'wpyog-documents' ); ?></p>
						<a href="https://wordpress.org/plugins/wpyog-team/" target="_blank" rel="noopener noreferrer" class="button button-small"><?php esc_html_e( 'View on WordPress.org', 'wpyog-documents' ); ?></a>
					</div>
				</div>

				<div style="flex:1;min-width:240px;background:#fff;border:1px solid #c3c4c7;border-radius:6px;padding:18px 20px;box-shadow:0 1px 2px rgba(0,0,0,.05);display:flex;gap:14px;align-items:flex-start;">
					<div style="flex-shrink:0;width:40px;height:40px;background:#f0fdf4;border-radius:8px;display:flex;align-items:center;justify-content:center;">
						<span class="dashicons dashicons-megaphone" style="color:#16a34a;font-size:22px;"></span>
					</div>
					<div style="flex:1;min-width:0;">
						<strong style="font-size:.95rem;display:block;margin-bottom:4px;">WPYog News</strong>
						<p style="font-size:.83rem;color:#50575e;margin:0 0 10px;line-height:1.5;"><?php esc_html_e( 'Manage and display news articles and announcements on your WordPress site.', 'wpyog-documents' ); ?></p>
						<a href="https://wordpress.org/plugins/wpyog-news/" target="_blank" rel="noopener noreferrer" class="button button-small"><?php esc_html_e( 'View on WordPress.org', 'wpyog-documents' ); ?></a>
					</div>
				</div>

				<div style="flex:1;min-width:240px;background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);border-radius:6px;padding:18px 20px;display:flex;gap:14px;align-items:flex-start;">
					<div style="flex-shrink:0;width:40px;height:40px;background:rgba(255,255,255,.15);border-radius:8px;display:flex;align-items:center;justify-content:center;">
						<span class="dashicons dashicons-external" style="color:#fff;font-size:22px;"></span>
					</div>
					<div style="flex:1;min-width:0;">
						<strong style="font-size:.95rem;display:block;margin-bottom:4px;color:#fff;">poppinsdigital.com</strong>
						<p style="font-size:.83rem;color:rgba(255,255,255,.85);margin:0 0 10px;line-height:1.5;"><?php esc_html_e( 'Browse all our WordPress plugins and tools.', 'wpyog-documents' ); ?></p>
						<a href="https://popswidgets.com/plugins/" target="_blank" rel="noopener noreferrer" style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.4);color:#fff;padding:4px 12px;border-radius:4px;text-decoration:none;font-size:.8rem;"><?php esc_html_e( 'Visit Website', 'wpyog-documents' ); ?></a>
					</div>
				</div>

			</div>
		</div>

		<script>
		function wpyogBuild() {
			var sc  = '[wpyog-document-list';
			var cat = document.getElementById('sc-category').value;
			var col = document.getElementById('sc-columns').value;
			var lim = document.getElementById('sc-limit').value.trim();
			var oby = document.getElementById('sc-orderby').value;
			var ord = document.getElementById('sc-order').value;
			var dsc = document.getElementById('sc-desc').checked;
			var dat = document.getElementById('sc-date').checked;
			var dl  = document.getElementById('sc-download').checked;
			if ( cat )            sc += ' category="' + cat + '"';
			if ( col !== '1' )    sc += ' columns="' + col + '"';
			if ( lim !== '' )     sc += ' limit="' + lim + '"';
			if ( oby !== 'date' ) sc += ' orderby="' + oby + '"';
			if ( ord !== 'DESC' ) sc += ' order="' + ord + '"';
			if ( dsc )            sc += ' desc="1"';
			if ( dat )            sc += ' date="1"';
			if ( dl )             sc += ' download="1"';
			sc += ']';
			document.getElementById('sc-output').textContent = sc;
			document.getElementById('sc-copied').style.display = 'none';
		}
		function wpyogCopy() {
			var text = document.getElementById('sc-output').textContent;
			if ( navigator.clipboard ) {
				navigator.clipboard.writeText( text ).then( wpyogShowCopied );
			} else {
				var el = document.createElement('textarea');
				el.value = text; document.body.appendChild(el); el.select();
				document.execCommand('copy'); document.body.removeChild(el);
				wpyogShowCopied();
			}
		}
		function wpyogShowCopied() {
			var el = document.getElementById('sc-copied');
			el.style.display = 'inline';
			setTimeout( function(){ el.style.display = 'none'; }, 2000 );
		}
		</script>
	</div>
	<?php
}

// -------------------------------------------------------------------------
// Admin Scripts & Styles — scoped to WPYog Document screens only
// -------------------------------------------------------------------------

add_action( 'admin_enqueue_scripts', 'wpyog_document_admin_script' );
function wpyog_document_admin_script( $hook ) {
	global $post;

	$screen = get_current_screen();
	if ( ! $screen ) {
		return;
	}

	// Only load on wpyog_document post type screens (list & edit).
	if ( 'wpyog_document' !== $screen->post_type ) {
		return;
	}

	wp_register_style( 'wpyog_document_admin_css', plugin_dir_url( __FILE__ ) . 'css/wpyog-document.css', array(), WPYOG_DOCUMENTS_VERSION );
	wp_enqueue_style( 'wpyog_document_admin_css' );

	wp_register_script( 'wpyog_document_admin_js', plugin_dir_url( __FILE__ ) . 'js/document-js.js', array( 'jquery' ), WPYOG_DOCUMENTS_VERSION, true );
	wp_enqueue_script( 'wpyog_document_admin_js' );

	wp_enqueue_script( 'media-upload' );

	if ( is_object( $post ) ) {
		wp_enqueue_media( array( 'post' => $post->ID ) );
	} else {
		wp_enqueue_media();
	}
}

// -------------------------------------------------------------------------
// Admin Sidebar Icon — must load on ALL admin pages, not just CPT screens
// -------------------------------------------------------------------------

add_action( 'admin_head', 'wpyog_admin_sidebar_icon_style' );
function wpyog_admin_sidebar_icon_style() {
	$fonts_url = plugin_dir_url( __FILE__ ) . 'css/fonts/';
	?>
	<style>
		@font-face {
			font-family: 'wpyog';
			src: url('<?php echo esc_url( $fonts_url ); ?>wpyog.eot');
			src: url('<?php echo esc_url( $fonts_url ); ?>wpyog.eot?#iefix') format('embedded-opentype'),
			     url('<?php echo esc_url( $fonts_url ); ?>wpyog.woff') format('woff'),
			     url('<?php echo esc_url( $fonts_url ); ?>wpyog.ttf') format('truetype'),
			     url('<?php echo esc_url( $fonts_url ); ?>wpyog.svg#wpyog') format('svg');
			font-weight: normal;
			font-style: normal;
		}
		#adminmenu .menu-icon-wpyog_document div.wp-menu-image:before {
			font-family: 'wpyog' !important;
			content: '\61' !important;
			color: #a7aaad;
		}
		#adminmenu li.menu-icon-wpyog_document:hover div.wp-menu-image:before,
		#adminmenu li.menu-icon-wpyog_document.wp-has-current-submenu div.wp-menu-image:before,
		#adminmenu li.menu-icon-wpyog_document.current div.wp-menu-image:before {
			color: #ffffff !important;
		}
	</style>
	<?php
}

// -------------------------------------------------------------------------
// Meta Box – Document File Upload
// -------------------------------------------------------------------------

add_action( 'add_meta_boxes', 'wpyog_document_meta_box' );
function wpyog_document_meta_box() {
	add_meta_box( 'wpyog_additional_attribute', __( 'Document File', 'wpyog-documents' ), 'wpyog_additional_attribute', 'wpyog_document' );
}

function wpyog_additional_attribute( $post ) {
	$document_link = get_post_meta( $post->ID, 'document_link', true );

	if ( ! empty( $document_link ) ) {
		?>
		<div class="post-option">
			<label class="post-option-label"><?php esc_html_e( 'Uploaded Document', 'wpyog-documents' ); ?></label>
			<div class="post-option-value">
				<a href="<?php echo esc_url( $document_link ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $document_link ); ?></a>
				<a href="javascript:void(0);" class="button btn-danger" id="removeDoc"><?php esc_html_e( 'Remove', 'wpyog-documents' ); ?></a>
			</div>
		</div>
		<?php
	}
	?>
	<div class="post-option" id="uploadDoc" style="display:<?php echo ( ! empty( $document_link ) ) ? 'none' : 'block'; ?>;">
		<label class="post-option-label"><?php esc_html_e( 'Upload Document (required)', 'wpyog-documents' ); ?></label>
		<div class="post-option-value">
			<?php wp_nonce_field( 'wpyog_document_link', 'wpyog_document_link_nonce' ); ?>
			<input id="upload-document" type="button" class="button" value="<?php esc_attr_e( 'Upload Document', 'wpyog-documents' ); ?>" />
			<span id="showLink"></span>
			<input type="hidden" name="document_link" class="large-text required" id="document_link" value="<?php echo ! empty( $document_link ) ? esc_url( $document_link ) : ''; ?>"/>
			<label class="error" id="fileError"></label>
		</div>
	</div>
	<?php
}

// -------------------------------------------------------------------------
// Save Post Meta
// -------------------------------------------------------------------------

add_action( 'save_post', 'wpyog_save_document_meta_data', 1, 2 );
function wpyog_save_document_meta_data( $post_id, $post ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( 'wpyog_document' !== $post->post_type ) {
		return;
	}

	if ( ! isset( $_POST['wpyog_document_link_nonce'] ) ) {
		return;
	}

	if ( ! check_admin_referer( 'wpyog_document_link', 'wpyog_document_link_nonce' ) ) {
		return;
	}

	$document_link = ! empty( $_POST['document_link'] ) ? sanitize_text_field( wp_unslash( $_POST['document_link'] ) ) : '';
	update_post_meta( $post_id, 'document_link', $document_link );
}

// -------------------------------------------------------------------------
// Admin Columns – Shortcode
// -------------------------------------------------------------------------

add_filter( 'manage_wpyog_document_posts_columns', function ( $defaults ) {
	$defaults['shortcode'] = __( 'Shortcode', 'wpyog-documents' );
	return $defaults;
} );

add_action( 'manage_wpyog_document_posts_custom_column', function ( $column_name, $post_id ) {
	if ( 'shortcode' === $column_name ) {
		echo esc_html( '[wpyog-document id=' . $post_id . ']' );
	}
}, 10, 2 );

// -------------------------------------------------------------------------
// Shortcode: [wpyog-document-list]
// -------------------------------------------------------------------------

add_shortcode( 'wpyog-document-list', 'wpyog_research_document_list' );
function wpyog_research_document_list( $atts, $content = null ) {
	// Flag that frontend assets are needed.
	wpyog_enqueue_front_scripts();

	$atts = shortcode_atts(
		array(
			'category' => '',
			'desc'     => 0,
			'date'     => 0,
			'orderby'  => 'date',
			'order'    => 'DESC',
			'limit'    => -1,
			'download' => 0,
			'columns'  => 1,
		),
		$atts,
		'wpyog-document-list'
	);

	$category = sanitize_text_field( $atts['category'] );
	$desc     = intval( $atts['desc'] );
	$date     = intval( $atts['date'] );
	$orderby  = sanitize_key( $atts['orderby'] );
	$order    = in_array( strtoupper( $atts['order'] ), array( 'ASC', 'DESC' ), true ) ? strtoupper( $atts['order'] ) : 'DESC';
	$limit    = intval( $atts['limit'] );
	$download = intval( $atts['download'] );
	$columns  = max( 1, min( 4, intval( $atts['columns'] ) ) );

	$cat = ! empty( $category ) ? array_map( 'intval', explode( ',', $category ) ) : array();

	$args = array(
		'post_type'      => 'wpyog_document',
		'post_status'    => 'publish',
		'posts_per_page' => $limit,
		'orderby'        => $orderby,
		'order'          => $order,
	);

	if ( ! empty( $cat ) ) {
		// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'wpyog_document_category',
				'field'    => 'term_id',
				'terms'    => $cat,
			),
		);
	}

	$query = new WP_Query( $args );

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'templates/research-document-list.php';
	wp_reset_postdata();

	return ob_get_clean();
}

// -------------------------------------------------------------------------
// Shortcode: [wpyog-document id="X"]
// -------------------------------------------------------------------------

add_shortcode( 'wpyog-document', 'wpyog_get_wpyog_document' );
function wpyog_get_wpyog_document( $atts = array() ) {
	wpyog_enqueue_front_scripts();

	$document_ids = array();
	if ( ! empty( $atts['id'] ) ) {
		$document_ids = array_map( 'intval', explode( ',', $atts['id'] ) );
	}

	$args = array(
		'post_type'      => 'wpyog_document',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'order'          => 'DESC',
	);

	if ( ! empty( $document_ids ) ) {
		$args['post__in'] = $document_ids;
	}

	$query = new WP_Query( $args );

	ob_start();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_id       = get_the_ID();
			$document_link = get_post_meta( $post_id, 'document_link', true );
			$ext           = pathinfo( $document_link, PATHINFO_EXTENSION );
			$icon_class    = wpyog_fileExtention( strtolower( $ext ) );
			?>
			<div class="wpyog-doc-box">
				<div class="wpyog-doc-box-title">
					<i class="wpyog-doc-icon fa <?php echo esc_attr( $icon_class ); ?>" aria-hidden="true"></i>
					<a href="<?php echo esc_url( $document_link ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( get_the_title() ); ?></a>
				</div>
				<div class="wpyog-doc-box-content">
					<?php the_content(); ?>
				</div>
			</div>
			<?php
		}
	} else {
		if ( ! empty( $document_ids ) ) {
			echo '<p>' . esc_html( '[wpyog-document id=' . implode( ',', $document_ids ) . ']' ) . '</p>';
		}
	}

	wp_reset_postdata();

	return ob_get_clean();
}

// -------------------------------------------------------------------------
// File Extension → Font Awesome Icon Class
// -------------------------------------------------------------------------

function wpyog_fileExtention( $ext ) {
	$map = array(
		'doc'  => 'fa-file-word-o',
		'docx' => 'fa-file-word-o',
		'pdf'  => 'fa-file-pdf-o',
		'txt'  => 'fa-file-text-o',
		'zip'  => 'fa-file-zip-o',
		'rar'  => 'fa-file-zip-o',
		'tar'  => 'fa-file-zip-o',
		'7z'   => 'fa-file-zip-o',
		'gz'   => 'fa-file-zip-o',
		'ppt'  => 'fa-file-powerpoint-o',
		'pptx' => 'fa-file-powerpoint-o',
		'xls'  => 'fa-file-excel-o',
		'csv'  => 'fa-file-excel-o',
		'xlsx' => 'fa-file-excel-o',
		'png'  => 'fa-file-image-o',
		'jpg'  => 'fa-file-image-o',
		'jpeg' => 'fa-file-image-o',
		'gif'  => 'fa-file-image-o',
		'tiff' => 'fa-file-image-o',
		'webp' => 'fa-file-image-o',
		'svg'  => 'fa-file-image-o',
		'mp4'  => 'fa-file-video-o',
		'webm' => 'fa-file-video-o',
		'flv'  => 'fa-file-video-o',
		'avi'  => 'fa-file-video-o',
		'wmv'  => 'fa-file-video-o',
		'mov'  => 'fa-file-video-o',
		'mp3'  => 'fa-file-audio-o',
		'wav'  => 'fa-file-audio-o',
	);

	return isset( $map[ $ext ] ) ? $map[ $ext ] : 'fa-file-o';
}

// -------------------------------------------------------------------------
// Frontend Scripts & Styles — lazy (only when shortcode renders)
// -------------------------------------------------------------------------

function wpyog_enqueue_front_scripts() {
	static $enqueued = false;
	if ( $enqueued ) {
		return;
	}
	$enqueued = true;

	wp_enqueue_style( 'wpyog_font_awesome_css', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), WPYOG_DOCUMENTS_VERSION );
	wp_enqueue_style( 'wpyog_document_front_css', plugin_dir_url( __FILE__ ) . 'css/wpyog_document.min.css', array(), WPYOG_DOCUMENTS_VERSION );
}

add_filter( 'widget_text', 'do_shortcode' );

// -------------------------------------------------------------------------
// Admin List – Category Filter
// -------------------------------------------------------------------------

add_action( 'restrict_manage_posts', 'wpyog_filter_post_type_by_taxonomy' );
function wpyog_filter_post_type_by_taxonomy() {
	global $typenow;
	if ( 'wpyog_document' !== $typenow ) {
		return;
	}
	$taxonomy      = 'wpyog_document_category';
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only admin list filter
	$selected      = isset( $_GET[ $taxonomy ] ) ? sanitize_text_field( wp_unslash( $_GET[ $taxonomy ] ) ) : '';
	$info_taxonomy = get_taxonomy( $taxonomy );
	wp_dropdown_categories(
		array(
			/* translators: %s: taxonomy label */
			'show_option_all' => sprintf( __( 'Show all %s', 'wpyog-documents' ), $info_taxonomy->label ),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		)
	);
}

add_filter( 'parse_query', 'wpyog_convert_id_to_term_in_query' );
function wpyog_convert_id_to_term_in_query( $query ) {
	global $pagenow;
	$taxonomy = 'wpyog_document_category';
	$q_vars   = &$query->query_vars;
	if (
		'edit.php' === $pagenow &&
		isset( $q_vars['post_type'] ) && 'wpyog_document' === $q_vars['post_type'] &&
		isset( $q_vars[ $taxonomy ] ) && is_numeric( $q_vars[ $taxonomy ] ) && 0 !== intval( $q_vars[ $taxonomy ] )
	) {
		$term               = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );
		$q_vars[ $taxonomy ] = $term->slug;
	}
}

// -------------------------------------------------------------------------
// AJAX File Download
// -------------------------------------------------------------------------

add_action( 'wp_ajax_wpyog_download_file', 'wpyog_download_file' );
add_action( 'wp_ajax_nopriv_wpyog_download_file', 'wpyog_download_file' );

function wpyog_download_file() {

	if ( ! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'wpyog_download_file' ) ) {
		wp_die( esc_html__( 'Invalid nonce', 'wpyog-documents' ), 403 );
	}

	if ( empty( $_REQUEST['document'] ) ) {
		wp_die( esc_html__( 'Invalid request', 'wpyog-documents' ) );
	}

	$encoded_id = sanitize_text_field( wp_unslash( $_REQUEST['document'] ) );
	// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode
	$post_id    = intval( base64_decode( urldecode( $encoded_id ) ) );

	if ( empty( $post_id ) ) {
		wp_die( esc_html__( 'Invalid document', 'wpyog-documents' ) );
	}

	$document_link = get_post_meta( $post_id, 'document_link', true );

	if ( empty( $document_link ) ) {
		wp_die( esc_html__( 'File not found', 'wpyog-documents' ) );
	}

	$filename    = basename( $document_link );
	$upload_dirs = wp_upload_dir();
	$relative    = str_replace( $upload_dirs['baseurl'], '', $document_link );
	$physical    = $upload_dirs['basedir'] . $relative;

	if ( ! file_exists( $physical ) ) {
		wp_die( esc_html__( 'File not found', 'wpyog-documents' ) );
	}

	$mime_type = mime_content_type( $physical );
	if ( empty( $mime_type ) ) {
		$mime_type = 'application/octet-stream';
	}

	header( 'Content-Description: File Transfer' );
	header( 'Content-Type: ' . $mime_type );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
	header( 'Expires: 0' );
	header( 'Cache-Control: must-revalidate' );
	header( 'Pragma: public' );
	header( 'Content-Length: ' . filesize( $physical ) );
	flush();
	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_readfile, WordPress.WP.AlternativeFunctions.file_system_operations_readfile
	readfile( $physical );
	exit;
}

// -------------------------------------------------------------------------
// Plugin Upgrade — migrate legacy table data (pre-CPT versions)
// -------------------------------------------------------------------------

add_action( 'upgrader_process_complete', 'wpyog_plugin_upgrade_completed', 10, 2 );
function wpyog_plugin_upgrade_completed( $upgrader_object, $options ) {
	global $wpdb;

	$our_plugin = plugin_basename( __FILE__ );

	if ( 'update' !== $options['action'] || 'plugin' !== $options['type'] || ! isset( $options['plugins'] ) ) {
		return;
	}

	foreach ( $options['plugins'] as $plugin ) {
		if ( $plugin !== $our_plugin ) {
			continue;
		}

		$table_name = $wpdb->prefix . 'wpyog_documents';
		$safe_table = esc_sql( $table_name );

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) ) ) === $table_name ) {

			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter
			$rows = $wpdb->get_results( "SELECT * FROM `{$safe_table}`", OBJECT );

			if ( ! empty( $rows ) ) {
				foreach ( $rows as $row ) {
					$new_post = array(
						'post_title'   => sanitize_text_field( $row->title ),
						'post_type'    => 'wpyog_document',
						'post_content' => ! empty( $row->description ) ? wp_kses_post( $row->description ) : sanitize_text_field( $row->title ),
						'post_status'  => 'publish',
						'post_date'    => gmdate( 'Y-m-d H:i:s', strtotime( $row->created ) ),
					);
					$post_id  = wp_insert_post( $new_post );
					if ( $post_id && ! is_wp_error( $post_id ) ) {
						update_post_meta( $post_id, 'document_link', esc_url_raw( $row->document_link ) );
					}
				}
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange, PluginCheck.Security.DirectDB.UnescapedDBParameter
				$wpdb->query( "DROP TABLE IF EXISTS `{$safe_table}`" );
			}
		}

		set_transient( 'wp_upe_updated', 1 );
	}
}

// -------------------------------------------------------------------------
// Admin Notices
// -------------------------------------------------------------------------

add_action( 'admin_notices', 'wpyog_upe_display_update_notice' );
function wpyog_upe_display_update_notice() {
	if ( get_transient( 'wp_upe_updated' ) ) {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'WPYog Documents updated successfully.', 'wpyog-documents' ) . '</p></div>';
		delete_transient( 'wp_upe_updated' );
	}
}

add_action( 'admin_notices', 'wpyog_upe_display_install_notice' );
function wpyog_upe_display_install_notice() {
	if ( get_transient( 'wp_upe_activated' ) ) {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'WPYog Documents activated. Go to WPYog Documents to add your first document.', 'wpyog-documents' ) . '</p></div>';
		delete_transient( 'wp_upe_activated' );
	}
}

register_activation_hook( __FILE__, 'wpyog_upe_activate' );
function wpyog_upe_activate() {
	set_transient( 'wp_upe_activated', 1 );
}
