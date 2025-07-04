<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'ANELM' ) ) :

    /**
     * Main ANELM Class
     *
     * @class ANELM
     * @version 1.0.0
     */
    final class ANELM {

        /**
         * The single instance of the class.
         *
         * @var ANELM
         */
        protected static $instance = null;

        /**
         * Constructor for the class.
         */
        public function __construct() {
            $this->init_hooks();
        }

        
        /**
         * Initialize hooks and filters.
         */
        private function init_hooks() {
            // Hook to install the plugin after plugins are loaded
            add_action( 'plugins_loaded', array( $this, 'load_plugin' ), 11 );
            add_action( 'anelm_init', array( $this, 'includes' ), 11 );
        }

        /**
         * Function to display admin notice if Elementor is not active.
         */
        public function admin_notice() {
            ?>
            <div class="error">
                <p><?php esc_html_e( 'Animate Elementor is enabled but not effective. It requires Elementor to work.', 'animate-elementor' ); ?></p>
            </div>
            <?php
        }

        /**
         * Function to initialize the plugin after Elementor is loaded.
         */
        public function load_plugin() {
            if ( ! did_action( 'elementor/loaded' ) ) {
                // Elementor is not active.
                add_action( 'admin_notices', array( $this, 'admin_notice' ) );
                return;
            }

            // Elementor is active. Proceed with initialization.
            do_action( 'anelm_init' );
        }

        /**
         * Main ANELM Instance.
         *
         * Ensures only one instance of ANELM is loaded or can be loaded.
         *
         * @static
         * @return ANELM - Main instance.
         */
        public static function instance() {
            if ( is_null( self::$instance ) ) :
                self::$instance         = new self();

                /**
                 * Fire a custom action to allow dependencies
                 * after the successful plugin setup
                 */
                do_action( 'anelm_plugin_loaded' );
            endif;
            return self::$instance;
        }

        /**
         * Include required files.
         *
         * @access private
         */
        public function includes() {
            /**
             * Core
             */
            include_once ANELM_PATH . 'includes/elementor/class-anelm-aos.php';
            include_once ANELM_PATH . 'includes/elementor/class-anelm-tilt.php';

            include_once ANELM_PATH . 'includes/elementor/background-animations/class-anelm-fog-animation.php';
            include_once ANELM_PATH . 'includes/elementor/background-animations/class-anelm-birds-animation.php';
            include_once ANELM_PATH . 'includes/elementor/background-animations/class-anelm-globe-animation.php';
            include_once ANELM_PATH . 'includes/elementor/background-animations/class-anelm-particles-net-animation.php';
            include_once ANELM_PATH . 'includes/elementor/background-animations/class-anelm-cells-animation.php';
            include_once ANELM_PATH . 'includes/elementor/background-animations/class-anelm-trunk-animation.php';
            include_once ANELM_PATH . 'includes/elementor/background-animations/class-anelm-topology-animation.php';
            include_once ANELM_PATH . 'includes/elementor/background-animations/class-anelm-dots-animation.php';
            include_once ANELM_PATH . 'includes/elementor/background-animations/class-anelm-rings-animation.php';
            include_once ANELM_PATH . 'includes/elementor/background-animations/class-anelm-halo-animation.php';
            include_once ANELM_PATH . 'includes/elementor/background-animations/class-anelm-geometry-wave-animation.php';
            include_once ANELM_PATH . 'includes/elementor/class-anelm-background-animation.php';

            if( is_admin() ) :
                $this->includes_admin();
            endif;
        }

        /**
         * Include Admin required files.
         *
         * @access private
         */
        public function includes_admin() {
            include_once ANELM_PATH . 'includes/class-anelm-install.php';
        }

    }

endif;
