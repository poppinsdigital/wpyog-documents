<?php
/**
 * Template: Document List
 * Used by the [wpyog-document-list] shortcode.
 *
 * Available variables (set by wpyog_research_document_list):
 *   $query    WP_Query instance
 *   $desc     int  1 = show description
 *   $date     int  1 = show date
 *   $download int  1 = show download button
 *   $columns  int  number of columns (1–4)
 *   $wpyog_pagination_html string pagination markup (already escaped), may be empty
 *   $wpyog_instance int list instance number on the page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wpyog_cols_class = ( $columns > 1 ) ? ' wpyog-cols-' . intval( $columns ) : '';
?>
<div id="wpyog-docs-<?php echo esc_attr( isset( $wpyog_instance ) ? $wpyog_instance : 1 ); ?>" class="wpyog-doc-list<?php echo esc_attr( $wpyog_cols_class ); ?>" role="region" aria-label="<?php esc_attr_e( 'Document list', 'wpyog-documents' ); ?>">
	<ul class="wpyog-doc-items">
		<?php if ( $query->have_posts() ) : ?>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php
				$post_id       = get_the_ID();
				$wpyog_document_link = get_post_meta( $post_id, 'document_link', true );
				$wpyog_ext           = strtolower( pathinfo( $wpyog_document_link, PATHINFO_EXTENSION ) );
				$wpyog_icon_class    = wpyog_fileExtention( $wpyog_ext );
				$wpyog_download_link = '';

				if ( 1 === intval( $download ) && ! empty( $wpyog_document_link ) ) {
					$wpyog_doc_encoded   = urlencode( base64_encode( $post_id ) );
					$wpyog_nonce         = wp_create_nonce( 'wpyog_download_file' );
					$wpyog_download_link = admin_url( "admin-ajax.php?action=wpyog_download_file&document={$wpyog_doc_encoded}&nonce={$wpyog_nonce}" );
				}
				?>
				<li class="wpyog-doc-item">
					<i class="wpyog-doc-icon fa <?php echo esc_attr( $wpyog_icon_class ); ?>" aria-hidden="true"></i>
					<span class="wpyog-doc-title">
						<a class="wpyog-doc-link" href="<?php echo esc_url( $wpyog_document_link ); ?>" target="_blank" rel="noopener noreferrer">
							<?php echo esc_html( get_the_title() ); ?>
						</a>

						<?php if ( ! empty( $wpyog_download_link ) ) : ?>
							<a class="wpyog-doc-download" href="<?php echo esc_url( $wpyog_download_link ); ?>" aria-label="<?php /* translators: %s: document title */ echo esc_attr( sprintf( __( 'Download %s', 'wpyog-documents' ), get_the_title() ) ); ?>">
								<i class="fa fa-download" aria-hidden="true"></i>
							</a>
						<?php endif; ?>

						<?php if ( 1 === intval( $date ) ) : ?>
							<span class="wpyog-doc-date entry-date">
								<?php echo esc_html( get_the_date() ); ?>
							</span>
						<?php endif; ?>
					</span>

					<?php if ( 1 === intval( $desc ) ) : ?>
						<div class="wpyog-doc-description">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>
				</li>
			<?php endwhile; ?>
		<?php else : ?>
			<li class="wpyog-doc-item wpyog-no-docs">
				<?php esc_html_e( 'No documents found.', 'wpyog-documents' ); ?>
			</li>
		<?php endif; ?>
	</ul>
	<?php
	if ( ! empty( $wpyog_pagination_html ) ) {
		echo wp_kses_post( $wpyog_pagination_html );
	}
	?>
</div>
