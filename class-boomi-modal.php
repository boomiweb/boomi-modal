<?php
/**
 * Main modal class.
 *
 * @package boomi-modal
 */

/**
 * Main Boomi Modal Class.
 *
 * @class Boomi_Modal
 */
final class Boomi_Modal {

    /**
     * Version
     *
     * (default value: '1.0.0')
     *
     * @var string
     * @access public
     */
    public $version = '1.2.0';

    /**
     * The single instance
     *
     * (default value: null)
     *
     * @var mixed
     * @access protected
     * @static
     */
    protected static $_instance = null;

    /**
     * Instance function.
     *
     * @access public
     * @static
     * @return instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Construct function.
     *
     * @access public
     * @return void
     */
    public function __construct() {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Define_constants function.
     *
     * @access private
     * @return void
     */
    private function define_constants() {
        $this->define( 'BOOMI_MODAL_VERSION', $this->version );
        $this->define( 'BOOMI_MODAL_PATH', plugin_dir_path( __FILE__ ) );
        $this->define( 'BOOMI_MODAL_URL', plugin_dir_url( __FILE__ ) );

    }

    /**
     * Define function.
     *
     * @access private
     * @param mixed $name of define.
     * @param mixed $value of define.
     * @return void
     */
    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }

    /**
     * Includes function.
     *
     * @access public
     * @return void
     */
    public function includes() {
        include_once( BOOMI_MODAL_PATH . 'ajax.php' );
    }

    /**
     * Initial hooks function.
     *
     * @access private
     * @return void
     */
    private function init_hooks() {
        add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts_styles' ), 11 );
    }

    /**
     * Scripts and styles on the frontend function.
     *
     * @access public
     * @return void
     */
    public function frontend_scripts_styles() {
        wp_register_script( 'boomi-modal-script', BOOMI_MODAL_URL . 'js/boomi-modal.min.js', array( 'jquery' ), BOOMI_MODAL_VERSION, true );

        wp_localize_script(
            'boomi-modal-script',
            'boomiModalObject',
            array(
                'ajaxURL' => admin_url( 'admin-ajax.php', 'relative' ),
                'nonce' => wp_create_nonce( 'bmur' ),
                'path' => BOOMI_MODAL_PATH,
                'url' => BOOMI_MODAL_URL,
            )
        );

        wp_enqueue_script( 'boomi-modal-script' );

        wp_enqueue_style( 'boomi-modal-style', BOOMI_MODAL_URL . 'css/boomi-modal.min.css', '', BOOMI_MODAL_VERSION );
    }

}
