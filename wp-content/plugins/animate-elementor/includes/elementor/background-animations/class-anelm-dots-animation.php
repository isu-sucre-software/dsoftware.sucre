<?php
/**
 * Dots Animation Class for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes\Background_Animation
 */

defined( 'ABSPATH' ) || exit;

class ANELM_Dots_Animation {

    public function __construct() {
        $this->initialize_script();
        add_action( 'elementor/preview/enqueue_scripts', array( $this, 'maybe_enqueue_scripts' ) );
        add_action( 'elementor/frontend/before_render', array( $this, 'render_animation' ), 1000, 1 );
    }

    public function initialize_script() {
        wp_register_script(
            'anelm-vanta-dots',
            ANELM_URL . 'assets/js/vendor/vanta.dots.min.js',
            array( 'anelm-three' ),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );
        wp_register_script(
            'anelm-dots-animation',
            ANELM_URL . 'assets/js/bg-animations/anelm-dots-animation.js',
            array( 'anelm-vanta-dots' ),
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
        wp_enqueue_script( 'anelm-vanta-dots' );
        wp_enqueue_script( 'anelm-dots-animation' );
    }

    public function get_animation_label() {
        return 'Dots Wave';
    }

    public function get_animation_type() {
        return 'dots';
    }

    public function register_controls( $element ) {

        $element->add_control('anelm_dots_mouse_controls', [
            'label' => __('Enable Mouse Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'dots',
            ],
        ]);

        $element->add_control('anelm_dots_touch_controls', [
            'label' => __('Enable Touch Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'dots',
            ],
        ]);

        $element->add_control('anelm_dots_gyro_controls', [
            'label' => __('Enable Gyro Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'no',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'dots',
            ],
        ]);

        $element->add_control('anelm_dots_scale', [
            'label' => __('Scale', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'dots',
            ],
        ]);

        $element->add_control('anelm_dots_scale_mobile', [
            'label' => __('Scale Mobile', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'dots',
            ],
        ]);

        $element->add_control('anelm_dots_color', [
            'label' => __('Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#e87e20',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'dots',
            ],
        ]);

        $element->add_control('anelm_dots_color2', [
            'label' => __('Color 2', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#f57c14',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'dots',
            ],
        ]);

        $element->add_control('anelm_dots_background_color', [
            'label' => __('Background Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#1e1e1e',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'dots',
            ],
        ]);

        $element->add_control('anelm_dots_size', [
            'label' => __('Dot Size', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 3.4,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'dots',
            ],
        ]);

        $element->add_control('anelm_dots_spacing', [
            'label' => __('Dot Spacing', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 26,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'dots',
            ],
        ]);
    }

    public function render_animation($element) {
        $settings = $element->get_settings_for_display();

        if ( !empty($settings['animate_elementor_bg_enable']) && 'dots' === $settings['animate_elementor_bg_type']) :
            wp_enqueue_script( 'anelm-three' );
            wp_enqueue_script( 'anelm-vanta-dots' );
            wp_enqueue_script( 'anelm-dots-animation' );
            
            $element->add_render_attribute('_wrapper', 'data-bg-type', 'dots');
            $element->add_render_attribute('_wrapper', 'data-mouse-controls', $settings['anelm_dots_mouse_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-touch-controls', $settings['anelm_dots_touch_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-gyro-controls', $settings['anelm_dots_gyro_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-scale', $settings['anelm_dots_scale']);
            $element->add_render_attribute('_wrapper', 'data-scale-mobile', $settings['anelm_dots_scale_mobile']);
            $element->add_render_attribute('_wrapper', 'data-color', $settings['anelm_dots_color']);
            $element->add_render_attribute('_wrapper', 'data-color2', $settings['anelm_dots_color2']);
            $element->add_render_attribute('_wrapper', 'data-background-color', $settings['anelm_dots_background_color']);
            $element->add_render_attribute('_wrapper', 'data-size', $settings['anelm_dots_size']);
            $element->add_render_attribute('_wrapper', 'data-spacing', $settings['anelm_dots_spacing']);
        endif;
    }
}
