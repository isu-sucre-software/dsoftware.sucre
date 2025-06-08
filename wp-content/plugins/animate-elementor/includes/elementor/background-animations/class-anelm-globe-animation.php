<?php
/**
 * Globe Animation Class for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes\Background_Animation
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class ANELM_Globe_Animation
 */
class ANELM_Globe_Animation {

    /**
     * Initialize the manager and register animations.
     */
    public function __construct() {
        $this->initialize_script();
        add_action( 'elementor/preview/enqueue_scripts', array( $this, 'maybe_enqueue_scripts' ) );
        add_action( 'elementor/frontend/before_render', array( $this, 'render_animation' ), 1000, 1 );
    }

    /**
     * Initialize Script.
     */
    public function initialize_script() {
        wp_register_script(
            'anelm-globe',
            ANELM_URL . 'assets/js/vendor/vanta.globe.min.js',
            array( 'anelm-three' ),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );
        wp_register_script(
            'anelm-globe-animation',
            ANELM_URL . 'assets/js/bg-animations/anelm-globe-animation.js',
            array( 'anelm-globe' ),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );
    }

     /**
     * Enqueue Script.
     */
    public function maybe_enqueue_scripts() {
        wp_enqueue_script( 'anelm-three' );
        wp_enqueue_script( 'anelm-globe' );
        wp_enqueue_script( 'anelm-globe-animation' );
    }

    /**
     * Get animation type label.
     */
    public function get_animation_label() {
        return 'Globe';
    }

    /**
     * Get animation type.
     *
     * @return string
     */
    public function get_animation_type() {
        return 'globe';
    }

    /**
     * Register globe animation controls in Elementor.
     *
     * @param \Elementor\Element_Base $element
     */
    public function register_controls( $element ) {
        $element->add_control('anelm_globe_mouse_controls', [
            'label' => __('Enable Mouse Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'globe',
            ],
        ]);

        $element->add_control('anelm_globe_touch_controls', [
            'label' => __('Enable Touch Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'globe',
            ],
        ]);

        $element->add_control('anelm_globe_gyro_controls', [
            'label' => __('Enable Gyro Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'no',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'globe',
            ],
        ]);

        $element->add_control('anelm_globe_scale', [
            'label' => __('Scale', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'globe',
            ],
        ]);

        $element->add_control('anelm_globe_scale_mobile', [
            'label' => __('Scale Mobile', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'globe',
            ],
        ]);

        $element->add_control('anelm_globe_color', [
            'label' => __('Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ff3f81',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'globe',
            ],
        ]);

        $element->add_control('anelm_globe_color2', [
            'label' => __('Secondary Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'globe',
            ],
        ]);

        $element->add_control('anelm_globe_size', [
            'label' => __('Size', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'globe',
            ],
        ]);

        $element->add_control('anelm_globe_background_color', [
            'label' => __('Background Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#23153c',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'globe',
            ],
        ]);
    }

    /**
     * Render globe animation attributes in frontend.
     *
     * @param \Elementor\Element_Base $element
     */
    public function render_animation( $element ) {
        $settings = $element->get_settings_for_display();
        if ( ! empty( $settings['animate_elementor_bg_enable'] ) && 'globe' === $settings['animate_elementor_bg_type'] ) :
            wp_enqueue_script( 'anelm-three' );
            wp_enqueue_script( 'anelm-vanta-globe' );
            wp_enqueue_script( 'anelm-globe-animation' );

            $element->add_render_attribute('_wrapper', 'data-bg-type', 'globe');
            $element->add_render_attribute('_wrapper', 'data-mouse-controls', $settings['anelm_globe_mouse_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-touch-controls', $settings['anelm_globe_touch_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-gyro-controls', $settings['anelm_globe_gyro_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-scale', $settings['anelm_globe_scale']);
            $element->add_render_attribute('_wrapper', 'data-scale-mobile', $settings['anelm_globe_scale_mobile']);
            $element->add_render_attribute('_wrapper', 'data-color', $settings['anelm_globe_color']);
            $element->add_render_attribute('_wrapper', 'data-color2', $settings['anelm_globe_color2']);
            $element->add_render_attribute('_wrapper', 'data-size', $settings['anelm_globe_size']);
            $element->add_render_attribute('_wrapper', 'data-background-color', $settings['anelm_globe_background_color']);
        endif;
    }
}
