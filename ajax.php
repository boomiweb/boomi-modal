<?php
/**
 * AJAX functions.
 *
 * @package boomi-modal
 */

/**
 * AJAX request for the modal url.
 *
 * @access public
 * @return void
 */
function ajax_boomi_modal_url_request() {
    check_ajax_referer( 'bmur', 'security' );

    if ( isset( $_POST['url'] ) ) :
        $url = sanitize_text_field( wp_unslash( $_POST['url'] ) );
    else :
        $url = '';
    endif;

    if ( empty( $url ) ) :
        wp_send_json_error( 'invalid url' );
    else :
        $request = wp_remote_get( $url );

        if ( is_array( $request ) && ! is_wp_error( $request ) ) :
            $headers = $request['headers']; // array of http header lines.
            $body    = $request['body']; // use the content.

            wp_send_json_success( $body );
        else :
            wp_send_json_error( 'requested url failed to respond' );
        endif;
    endif;

    wp_die();
}
add_action( 'wp_ajax_boomi_modal_url_request', 'ajax_boomi_modal_url_request' );
add_action( 'wp_ajax_nopriv_boomi_modal_url_request', 'ajax_boomi_modal_url_request' );
