<?php
/**
 * Dots Animation Class for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes\Background_Animation
 */

defined( 'ABSPATH' ) || exit;

class ANELM_Halo_Animation {

    public function __construct() {
        $this->initialize_script();
        add_action( 'elementor/preview/enqueue_scripts', array( $this, 'maybe_enqueue_scripts' ) );
        add_action( 'elementor/frontend/before_render', array( $this, 'render_animation' ), 1000, 1 );
    }

    public function initialize_script() {
        wp_register_script(
            'anelm-vanta-halo',
            ANELM_URL . 'assets/js/vendor/vanta.halo.min.js',
            array('anelm-three'),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );

        wp_register_script(
            'anelm-halo-animation',
            ANELM_URL . 'assets/js/bg-animations/anelm-halo-animation.js',
            array('anelm-vanta-halo'),
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
        wp_enqueue_script( 'anelm-vanta-halo' );
        wp_enqueue_script( 'anelm-halo-animation' );
    }

    public function get_animation_label() {
        return 'Halo';
    }

    public function get_animation_type() {
        return 'halo';
    }

    public function register_controls($element) {
        $element->add_control('anelm_halo_background_color', [
            'label' => __('Background Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#1e2866',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'halo',
            ],
        ]);

        $element->add_control('anelm_halo_base_color', [
            'label' => __('Base Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#04174a',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'halo',
            ],
        ]);

        $element->add_control('anelm_halo_amplitude_factor', [
            'label' => __('Amplitude Factor', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'halo',
            ],
        ]);

        $element->add_control('anelm_halo_x_offset', [
            'label' => __('X Offset', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'halo',
            ],
        ]);
        
        $element->add_control('anelm_halo_y_offset', [
            'label' => __('Y Offset', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'halo',
            ],
        ]);

        $element->add_control('anelm_halo_size', [
            'label' => __('Size', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'halo',
            ],
        ]);

        $element->add_control('anelm_halo_mouse_controls', [
            'label' => __('Enable Mouse Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'halo',
            ],
        ]);

        $element->add_control('anelm_halo_touch_controls', [
            'label' => __('Enable Touch Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'halo',
            ],
        ]);

        $element->add_control('anelm_halo_gyro_controls', [
            'label' => __('Enable Gyro Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'no',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'halo',
            ],
        ]);
    }

    public function render_animation($element) {
        $settings = $element->get_settings_for_display();

        if (!empty($settings['animate_elementor_bg_enable']) && 'halo' === $settings['animate_elementor_bg_type']) :
            wp_enqueue_script( 'anelm-three' );
            wp_enqueue_script( 'anelm-vanta-halo' );
            wp_enqueue_script( 'anelm-halo-animation' );
            
            $element->add_render_attribute('_wrapper', 'data-bg-type', 'halo');
            $element->add_render_attribute('_wrapper', 'data-background-color', $settings['anelm_halo_background_color']);
            $element->add_render_attribute('_wrapper', 'data-base-color', $settings['anelm_halo_base_color']);
            $element->add_render_attribute('_wrapper', 'data-amplitude-factor', $settings['anelm_halo_amplitude_factor']);
            $element->add_render_attribute('_wrapper', 'data-x-offset', $settings['anelm_halo_x_offset']);
            $element->add_render_attribute('_wrapper', 'data-y-offset', $settings['anelm_halo_y_offset']);
            $element->add_render_attribute('_wrapper', 'data-size', $settings['anelm_halo_size']);
            $element->add_render_attribute('_wrapper', 'data-mouse-controls', $settings['anelm_halo_mouse_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-touch-controls', $settings['anelm_halo_touch_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-gyro-controls', $settings['anelm_halo_gyro_controls'] ? 'true' : 'false');
        endif;
    }
}
