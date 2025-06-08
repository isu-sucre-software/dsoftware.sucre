<?php
/**
 * Background Animation Manager for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes\Background_Animation
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class ANELM_Background_Animation
 */
class ANELM_Background_Animation {

    /**
     * Holds registered animations.
     *
     * @var array
     */
    private $animations = [];

    /**
     * Singleton instance.
     *
     * @var ANELM_Background_Animation
     */
    private static $instance = null;

    /**
     * Get the singleton instance.
     *
     * @return ANELM_Background_Animation
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) :
            self::$instance = new self();
        endif;

        return self::$instance;
    }

    /**
     * Initialize the manager and register animations.
     */
    public function __construct() {
        $this->register_animations();
        add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'initialize_script' ) );
        add_action( 'elementor/element/before_section_end', array( $this, 'register_controls' ), 1000, 3 );
    }

    /**
     * Initialize Script.
     */
    public function initialize_script() {
        wp_register_script(
            'anelm-three',
            ANELM_URL . 'assets/js/vendor/three.min.js',
            array(),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );
        wp_localize_script( 'anelm-three', 'anelm_param',
            array( 
                'plugin_url' => ANELM_URL
            ) 
        );
    }
    
    /**
     * Register available background animations.
     */
    private function register_animations() {
        $this->animations = apply_filters('anelm_register_animations', [
            new ANELM_Particles_Net_Animation(),
            new ANELM_Fog_Animation(),
            new ANELM_Geometry_Waves_Animation(),
            new ANELM_Birds_Animation(),
            new ANELM_Globe_Animation(),
            new ANELM_Cells_Animation(),
            new ANELM_Trunk_Animation(),
            new ANELM_Topology_Animation(),
            new ANELM_Dots_Animation(),
            new ANELM_Rings_Animation(),
            new ANELM_Halo_Animation(),
        ]);
        
    }

    /**
     * Register background animation controls in Elementor.
     *
     * @param \Elementor\Element_Base $element
     */
    public function register_controls(  $element, $section_id, $args ) {
        if ( 'animate_elementor_aos_section' !== $section_id ) :
            return;
        endif;

        $element->add_control(
            'animate_elementor_background_animation_heading',
            array(
                'type'      => \Elementor\Controls_Manager::HEADING,
                'label'     => __( 'Background Animation', 'animate-elementor' ),
                'separator' => 'before',
            )
        );

        $element->add_control('animate_elementor_bg_enable', [
            'label'     => __('Enable Background Animation', 'animate-elementor'),
            'type'      => \Elementor\Controls_Manager::SWITCHER,
            'label_on'  => __('Yes', 'animate-elementor'),
            'label_off' => __('No', 'animate-elementor'),
            'default'   => ''
        ]);

        $element->add_control('animate_elementor_bg_type', [
            'label'     => __('Animation Type', 'animate-elementor'),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'options'   => $this->get_animation_types(),
            'condition' => ['animate_elementor_bg_enable' => 'yes'],
            'default'   => ''
        ]);

        if( is_array( $this->animations ) ) :
            foreach ( $this->animations as $animation ) :
                $animation->register_controls( $element );
            endforeach;
        endif;
    }

    /**
     * Get all registered animation types.
     *
     * @return array
     */
    private function get_animation_types() {
        $types = ['' => 'None'];

        foreach ( $this->animations as $animation ) :
            $types[ $animation->get_animation_type() ] = $animation->get_animation_label();
        endforeach;

        return $types;
    }
}

// Initialize the manager.
ANELM_Background_Animation::instance();
