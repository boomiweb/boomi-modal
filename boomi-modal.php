<?php
/**
 * Plugin Name: Boomi Modal
 * Plugin URI:
 * Description: A simply awesome modal popup
 * Version: 1.2.0
 * Author:
 * Author URI:
 * Requires at least: 4.0
 * Tested up to: 5.2.1
 * Text Domain: boomi-modal
 *
 * @package boomi-modal
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! defined( 'BOOMI_MODAL_PLUGIN_FILE' ) ) {
    define( 'BOOMI_MODAL_PLUGIN_FILE', __FILE__ );
}

// Include the main Boomi_Modal class.
if ( ! class_exists( 'Boomi_Modal' ) ) {
    include_once dirname( __FILE__ ) . '/class-boomi-modal.php';
}

/**
 * Boomi Modal function.
 *
 * @access public
 * @return boomi modal instance
 */
function boomi_modal() {
    return Boomi_Modal::instance();
}

// Global for backwards compatibility.
$GLOBALS['boomi_modal'] = boomi_modal();
