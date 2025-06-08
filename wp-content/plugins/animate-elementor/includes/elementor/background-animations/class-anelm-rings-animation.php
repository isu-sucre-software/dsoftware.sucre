<?php 
/**
 * Dots Animation Class for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes\Background_Animation
 */

defined( 'ABSPATH' ) || exit;

class ANELM_Rings_Animation {

    public function __construct() {
        $this->initialize_script();
        add_action( 'elementor/preview/enqueue_scripts', array( $this, 'maybe_enqueue_scripts' ) );
        add_action( 'elementor/frontend/before_render', array( $this, 'render_animation' ), 1000, 1 );
    }

    public function initialize_script() {
        wp_register_script(
            'anelm-vanta-rings',
            ANELM_URL . 'assets/js/vendor/vanta.rings.min.js',
            array('anelm-three'),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );

        wp_register_script(
            'anelm-rings-animation',
            ANELM_URL . 'assets/js/bg-animations/anelm-rings-animation.js',
            array('anelm-vanta-rings'),
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
        wp_enqueue_script( 'anelm-vanta-rings' );
        wp_enqueue_script( 'anelm-rings-animation' );
    }

    public function get_animation_label() {
        return 'Rings';
    }

    public function get_animation_type() {
        return 'rings';
    }

    public function register_controls($element) {
        $element->add_control('anelm_rings_background_color', [
            'label' => __('Background Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#21262a',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'rings',
            ],
        ]);

        $element->add_control('anelm_rings_color', [
            'label' => __('Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#84f208',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'rings',
            ],
        ]);

        $element->add_control('anelm_rings_scale', [
            'label' => __('Scale', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'rings',
            ],
        ]);

        $element->add_control('anelm_rings_scale_mobile', [
            'label' => __('Scale Mobile', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'rings',
            ],
        ]);

        $element->add_control('anelm_rings_mouse_controls', [
            'label' => __('Enable Mouse Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'rings',
            ],
        ]);

        $element->add_control('anelm_rings_touch_controls', [
            'label' => __('Enable Touch Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'rings',
            ],
        ]);

        $element->add_control('anelm_rings_gyro_controls', [
            'label' => __('Enable Gyro Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'no',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'rings',
            ],
        ]);
    }

    public function render_animation($element) {
        $settings = $element->get_settings_for_display();

        if (!empty($settings['animate_elementor_bg_enable']) && 'rings' === $settings['animate_elementor_bg_type']) :
            wp_enqueue_script( 'anelm-three' );
            wp_enqueue_script( 'anelm-vanta-rings' );
            wp_enqueue_script( 'anelm-rings-animation' );

            $element->add_render_attribute('_wrapper', 'data-bg-type', 'rings');
            $element->add_render_attribute('_wrapper', 'data-background-color', $settings['anelm_rings_background_color']);
            $element->add_render_attribute('_wrapper', 'data-color', $settings['anelm_rings_color']);
            $element->add_render_attribute('_wrapper', 'data-scale', $settings['anelm_rings_scale']);
            $element->add_render_attribute('_wrapper', 'data-scale-mobile', $settings['anelm_rings_scale_mobile']);
            $element->add_render_attribute('_wrapper', 'data-mouse-controls', $settings['anelm_rings_mouse_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-touch-controls', $settings['anelm_rings_touch_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-gyro-controls', $settings['anelm_rings_gyro_controls'] ? 'true' : 'false');
        endif;
    }
}
