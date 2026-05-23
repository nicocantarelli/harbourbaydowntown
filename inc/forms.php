<?php
/**
 * Lead-capture forms — a single shared handler for the four enquiry forms
 * (Contact, Advertising, Sales & Leasing, and Live & Work "Enquire About Space").
 *
 * The form patterns post via AJAX to admin-ajax.php. Each submission is emailed
 * to the right inbox (routed by topic) AND stored as an "Enquiry" post so no lead
 * is lost if the email fails to deliver.
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The three destination inboxes. Filterable so the addresses can be changed in
 * code without touching the routing logic.
 *
 * @return array<string,string> Keyed by role: info | media | lease.
 */
function hbd_form_recipients() {
	return apply_filters(
		'hbd_form_recipients',
		array(
			'info'  => 'info@citrabuanaprakarsa.com',
			'media' => 'marcomm@citrabuanaprakarsa.com',
			'lease' => 'lease.mgr@harbourbaydowntown.com',
		)
	);
}

/**
 * Human-readable labels for each form id (used in emails + the admin list).
 *
 * @return array<string,string>
 */
function hbd_form_labels() {
	return array(
		'contact'       => __( 'Contact', 'harbour-bay-downtown' ),
		'advertising'   => __( 'Advertising', 'harbour-bay-downtown' ),
		'sales-leasing' => __( 'Sales & Leasing', 'harbour-bay-downtown' ),
		'live-work'     => __( 'Live & Work', 'harbour-bay-downtown' ),
	);
}

/**
 * Resolve the destination email for a submission.
 *
 * Topic wins over the per-form default: an enquiry-type mentioning "media" routes
 * to marcomm; one mentioning "sales"/"leasing" routes to lease. Otherwise the
 * form's own default applies (Contact/Advertising → info; S&L/Live & Work → lease).
 *
 * @param string $form Form id (contact|advertising|sales-leasing|live-work).
 * @param string $type Submitted enquiry-type value.
 * @return string Email address.
 */
function hbd_form_recipient( $form, $type ) {
	$inboxes = hbd_form_recipients();
	$topic   = strtolower( $type );

	if ( false !== strpos( $topic, 'media' ) ) {
		return $inboxes['media'];
	}
	if ( false !== strpos( $topic, 'sales' ) || false !== strpos( $topic, 'leasing' ) ) {
		return $inboxes['lease'];
	}

	switch ( $form ) {
		case 'sales-leasing':
		case 'live-work':
			return $inboxes['lease'];
		case 'advertising':
		case 'contact':
		default:
			return $inboxes['info'];
	}
}

/**
 * Register the Enquiry CPT — the stored backup of every form submission.
 * Records are created only by the handler, so the "Add New" UI is disabled.
 */
function hbd_register_enquiries() {
	register_post_type(
		'hbd_enquiry',
		array(
			'labels'              => array(
				'name'          => __( 'Enquiries', 'harbour-bay-downtown' ),
				'singular_name' => __( 'Enquiry', 'harbour-bay-downtown' ),
				'menu_name'     => __( 'Enquiries', 'harbour-bay-downtown' ),
				'edit_item'     => __( 'View Enquiry', 'harbour-bay-downtown' ),
				'not_found'     => __( 'No enquiries yet.', 'harbour-bay-downtown' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'menu_icon'           => 'dashicons-email-alt',
			'menu_position'       => 27,
			'supports'            => array( 'title' ),
			'map_meta_cap'        => true,
			'capabilities'        => array(
				'create_posts' => 'do_not_allow', // Submissions only — no manual "Add New".
			),
		)
	);
}
add_action( 'init', 'hbd_register_enquiries' );

/**
 * Admin list columns for Enquiries.
 *
 * @param array<string,string> $columns Existing columns.
 * @return array<string,string>
 */
function hbd_enquiry_columns( $columns ) {
	return array(
		'cb'              => isset( $columns['cb'] ) ? $columns['cb'] : '',
		'title'          => __( 'Name', 'harbour-bay-downtown' ),
		'hbd_enq_form'   => __( 'Form', 'harbour-bay-downtown' ),
		'hbd_enq_type'   => __( 'Type', 'harbour-bay-downtown' ),
		'hbd_enq_email'  => __( 'Email', 'harbour-bay-downtown' ),
		'date'           => __( 'Received', 'harbour-bay-downtown' ),
	);
}
add_filter( 'manage_hbd_enquiry_posts_columns', 'hbd_enquiry_columns' );

/**
 * Render the custom Enquiry columns.
 *
 * @param string $column  Column id.
 * @param int    $post_id Enquiry id.
 */
function hbd_enquiry_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'hbd_enq_form':
			$form   = (string) get_post_meta( $post_id, '_hbd_enq_form', true );
			$labels = hbd_form_labels();
			echo esc_html( isset( $labels[ $form ] ) ? $labels[ $form ] : $form );
			break;
		case 'hbd_enq_type':
			echo esc_html( (string) get_post_meta( $post_id, '_hbd_enq_type', true ) );
			break;
		case 'hbd_enq_email':
			$email = (string) get_post_meta( $post_id, '_hbd_enq_email', true );
			if ( $email ) {
				printf( '<a href="%1$s">%2$s</a>', esc_url( 'mailto:' . $email ), esc_html( $email ) );
			}
			break;
	}
}
add_action( 'manage_hbd_enquiry_posts_custom_column', 'hbd_enquiry_column_content', 10, 2 );

/**
 * Show the full submission (all fields) inside a meta box on the Enquiry editor,
 * since the CPT only "supports" a title.
 */
function hbd_enquiry_meta_box() {
	add_meta_box(
		'hbd_enquiry_details',
		__( 'Enquiry details', 'harbour-bay-downtown' ),
		'hbd_render_enquiry_details',
		'hbd_enquiry',
		'normal',
		'high'
	);

	// Enquiries are submission records, not editable posts — replace the default
	// "Publish" box (Status / Visibility / Update) with a simple info + delete box.
	remove_meta_box( 'submitdiv', 'hbd_enquiry', 'side' );
	add_meta_box(
		'hbd_enquiry_manage',
		__( 'Enquiry', 'harbour-bay-downtown' ),
		'hbd_render_enquiry_manage',
		'hbd_enquiry',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'hbd_enquiry_meta_box' );

/**
 * Side box for an enquiry — when it arrived, plus a Trash link. Replaces the
 * stock Publish box so there's no confusing "Publish / Update".
 *
 * @param WP_Post $post Enquiry post.
 */
function hbd_render_enquiry_manage( $post ) {
	$format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
	echo '<p style="margin:6px 0 12px;">';
	echo esc_html__( 'Received:', 'harbour-bay-downtown' ) . ' <strong>' . esc_html( get_post_time( $format, false, $post, true ) ) . '</strong>';
	echo '</p>';

	$trash = get_delete_post_link( $post->ID );
	if ( $trash ) {
		echo '<a href="' . esc_url( $trash ) . '" class="submitdelete" style="color:#b32d2e;">' . esc_html__( 'Move to Trash', 'harbour-bay-downtown' ) . '</a>';
	}
}

/**
 * Render the read-only enquiry details.
 *
 * @param WP_Post $post Enquiry post.
 */
function hbd_render_enquiry_details( $post ) {
	$labels = hbd_form_labels();
	$form   = (string) get_post_meta( $post->ID, '_hbd_enq_form', true );
	$rows   = array(
		__( 'Form', 'harbour-bay-downtown' )       => isset( $labels[ $form ] ) ? $labels[ $form ] : $form,
		__( 'Enquiry type', 'harbour-bay-downtown' ) => (string) get_post_meta( $post->ID, '_hbd_enq_type', true ),
		__( 'Name', 'harbour-bay-downtown' )       => (string) get_post_meta( $post->ID, '_hbd_enq_name', true ),
		__( 'Company', 'harbour-bay-downtown' )    => (string) get_post_meta( $post->ID, '_hbd_enq_company', true ),
		__( 'Email', 'harbour-bay-downtown' )      => (string) get_post_meta( $post->ID, '_hbd_enq_email', true ),
		__( 'Phone', 'harbour-bay-downtown' )      => (string) get_post_meta( $post->ID, '_hbd_enq_phone', true ),
		__( 'Sent to', 'harbour-bay-downtown' )    => (string) get_post_meta( $post->ID, '_hbd_enq_recipient', true ),
		__( 'Page', 'harbour-bay-downtown' )       => (string) get_post_meta( $post->ID, '_hbd_enq_source_url', true ),
	);
	$message = (string) get_post_meta( $post->ID, '_hbd_enq_message', true );

	echo '<table class="widefat striped" style="margin-bottom:12px;"><tbody>';
	foreach ( $rows as $label => $value ) {
		if ( '' === trim( (string) $value ) ) {
			continue;
		}
		echo '<tr><th style="width:140px;text-align:left;">' . esc_html( $label ) . '</th><td>' . esc_html( $value ) . '</td></tr>';
	}
	echo '</tbody></table>';

	if ( '' !== trim( $message ) ) {
		echo '<p><strong>' . esc_html__( 'Message', 'harbour-bay-downtown' ) . '</strong></p>';
		echo '<p style="white-space:pre-wrap;">' . esc_html( $message ) . '</p>';
	}
}

/**
 * Whether a form requires the enquiry-type field. The Live & Work form leaves it
 * optional ("I'm interested in"); the rest mark it required.
 *
 * @param string $form Form id.
 * @return bool
 */
function hbd_form_requires_type( $form ) {
	return 'live-work' !== $form;
}

/**
 * The success payload returned to the frontend (title + message for the panel).
 *
 * @return array{title:string,message:string}
 */
function hbd_form_success_payload() {
	return array(
		'title'   => __( 'Message sent', 'harbour-bay-downtown' ),
		'message' => __( 'Thank you for reaching out — our team has received your message and will be in touch shortly.', 'harbour-bay-downtown' ),
	);
}

/**
 * Send the confirmation (autoresponder) email to the person who submitted.
 * Reply-To is the team inbox the enquiry was routed to, so their reply lands
 * with the right people.
 *
 * @param string $email     Submitter email.
 * @param string $name      Submitter name.
 * @param string $type      Enquiry type.
 * @param string $message   Submitted message.
 * @param string $recipient Team inbox the enquiry was routed to.
 */
function hbd_send_form_acknowledgement( $email, $name, $type, $message, $recipient ) {
	$site = get_bloginfo( 'name' );

	/* translators: %s: site name. */
	$subject = sprintf( __( 'We’ve received your message — %s', 'harbour-bay-downtown' ), $site );

	$lines = array(
		/* translators: %s: submitter first name or full name. */
		sprintf( __( 'Hi %s,', 'harbour-bay-downtown' ), $name ),
		'',
		/* translators: %s: site name. */
		sprintf( __( 'Thank you for contacting %s. We’ve received your message and our team will get back to you shortly.', 'harbour-bay-downtown' ), $site ),
		'',
		__( 'For your records, here’s a copy of what you sent:', 'harbour-bay-downtown' ),
		'',
	);
	if ( '' !== $type ) {
		$lines[] = sprintf( __( 'Enquiry type: %s', 'harbour-bay-downtown' ), $type );
	}
	$lines[] = __( 'Message:', 'harbour-bay-downtown' );
	$lines[] = $message;
	$lines[] = '';
	$lines[] = __( 'Warm regards,', 'harbour-bay-downtown' );
	$lines[] = $site;

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( $recipient && is_email( $recipient ) ) {
		$headers[] = sprintf( 'Reply-To: %s', $recipient );
	}

	wp_mail( $email, $subject, implode( "\n", $lines ), $headers );
}

/**
 * AJAX handler — validate, email, and store a form submission.
 */
function hbd_handle_form_submit() {
	check_ajax_referer( 'hbd_form', 'nonce' );

	// Honeypot: real users never fill this. Pretend success and drop the bot.
	if ( ! empty( $_POST['hbd_hp'] ) ) {
		wp_send_json_success( hbd_form_success_payload() );
	}

	$labels = hbd_form_labels();
	$form   = isset( $_POST['form'] ) ? sanitize_key( wp_unslash( $_POST['form'] ) ) : 'contact';
	if ( ! isset( $labels[ $form ] ) ) {
		$form = 'contact';
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$company = isset( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$type    = isset( $_POST['enquiry_type'] ) ? sanitize_text_field( wp_unslash( $_POST['enquiry_type'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	// Validate required fields.
	$errors = array();
	if ( '' === $name ) {
		$errors[] = __( 'Please enter your name.', 'harbour-bay-downtown' );
	}
	if ( '' === $email || ! is_email( $email ) ) {
		$errors[] = __( 'Please enter a valid email address.', 'harbour-bay-downtown' );
	}
	if ( '' === $message ) {
		$errors[] = __( 'Please enter a message.', 'harbour-bay-downtown' );
	}
	if ( hbd_form_requires_type( $form ) && '' === $type ) {
		$errors[] = __( 'Please select an enquiry type.', 'harbour-bay-downtown' );
	}

	if ( $errors ) {
		wp_send_json_error( array( 'message' => implode( ' ', $errors ) ), 422 );
	}

	$recipient = hbd_form_recipient( $form, $type );
	$form_name = $labels[ $form ];

	// Store the lead first — this is the backup if email delivery fails.
	$title   = trim( $name . ' — ' . $form_name );
	$post_id = wp_insert_post(
		array(
			'post_type'   => 'hbd_enquiry',
			'post_status' => 'publish',
			'post_title'  => $title,
		),
		true
	);

	if ( ! is_wp_error( $post_id ) && $post_id ) {
		update_post_meta( $post_id, '_hbd_enq_form', $form );
		update_post_meta( $post_id, '_hbd_enq_type', $type );
		update_post_meta( $post_id, '_hbd_enq_name', $name );
		update_post_meta( $post_id, '_hbd_enq_company', $company );
		update_post_meta( $post_id, '_hbd_enq_email', $email );
		update_post_meta( $post_id, '_hbd_enq_phone', $phone );
		update_post_meta( $post_id, '_hbd_enq_message', $message );
		update_post_meta( $post_id, '_hbd_enq_recipient', $recipient );
		update_post_meta( $post_id, '_hbd_enq_source_url', isset( $_POST['source_url'] ) ? esc_url_raw( wp_unslash( $_POST['source_url'] ) ) : '' );
	}

	// Build and send the notification email.
	$subject = sprintf(
		/* translators: 1: form name, 2: sender name. */
		__( '[Harbour Bay Downtown] New %1$s enquiry from %2$s', 'harbour-bay-downtown' ),
		$form_name,
		$name
	);

	$lines = array(
		sprintf( __( 'Form: %s', 'harbour-bay-downtown' ), $form_name ),
	);
	if ( '' !== $type ) {
		$lines[] = sprintf( __( 'Enquiry type: %s', 'harbour-bay-downtown' ), $type );
	}
	$lines[] = sprintf( __( 'Name: %s', 'harbour-bay-downtown' ), $name );
	if ( '' !== $company ) {
		$lines[] = sprintf( __( 'Company: %s', 'harbour-bay-downtown' ), $company );
	}
	$lines[] = sprintf( __( 'Email: %s', 'harbour-bay-downtown' ), $email );
	if ( '' !== $phone ) {
		$lines[] = sprintf( __( 'Phone: %s', 'harbour-bay-downtown' ), $phone );
	}
	$lines[] = '';
	$lines[] = __( 'Message:', 'harbour-bay-downtown' );
	$lines[] = $message;

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		sprintf( 'Reply-To: %s <%s>', $name, $email ),
	);

	wp_mail( $recipient, $subject, implode( "\n", $lines ), $headers );

	// Confirmation email to the person who submitted.
	hbd_send_form_acknowledgement( $email, $name, $type, $message, $recipient );

	wp_send_json_success( hbd_form_success_payload() );
}
add_action( 'wp_ajax_hbd_form_submit', 'hbd_handle_form_submit' );
add_action( 'wp_ajax_nopriv_hbd_form_submit', 'hbd_handle_form_submit' );
