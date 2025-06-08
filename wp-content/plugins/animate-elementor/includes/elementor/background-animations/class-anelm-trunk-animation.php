<?php
/**
 * Trunk Animation Class for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes\Background_Animation
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class ANELM_Trunk_Animation
 */
class ANELM_Trunk_Animation {

    public function __construct() {
        $this->initialize_script();
        add_action( 'elementor/preview/enqueue_scripts', array( $this, 'maybe_enqueue_scripts' ) );
        add_action( 'elementor/frontend/before_render', array( $this, 'render_animation' ), 1000, 1 );
    }

    public function initialize_script() {
        wp_register_script(
            'anelm-p5',
            ANELM_URL . 'assets/js/vendor/p5.min.js',
            array(),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );
        wp_register_script(
            'anelm-vanta-trunk',
            ANELM_URL . 'assets/js/vendor/vanta.trunk.min.js',
            array( 'anelm-p5' ),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );
        wp_register_script(
            'anelm-trunk-animation',
            ANELM_URL . 'assets/js/bg-animations/anelm-trunk-animation.js',
            array( 'anelm-vanta-trunk' ),
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
        wp_enqueue_script( 'anelm-p5' );
        wp_enqueue_script( 'anelm-three' );
        wp_enqueue_script( 'anelm-vanta-trunk' );
        wp_enqueue_script( 'anelm-trunk-animation' );
    }

    public function get_animation_label() {
        return 'Trunk';
    }

    public function get_animation_type() {
        return 'trunk';
    }

    public function register_controls( $element ) {
        $element->add_control('anelm_trunk_mouse_controls', [
            'label' => __('Enable Mouse Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'trunk',
            ],
        ]);

        $element->add_control('anelm_trunk_touch_controls', [
            'label' => __('Enable Touch Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'trunk',
            ],
        ]);

        $element->add_control('anelm_trunk_gyro_controls', [
            'label' => __('Enable Gyro Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'no',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'trunk',
            ],
        ]);

        $element->add_control('anelm_trunk_scale', [
            'label' => __('Scale', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.00,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'trunk',
            ],
        ]);

        $element->add_control('anelm_trunk_scale_mobile', [
            'label' => __('Scale Mobile', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.00,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'trunk',
            ],
        ]);

        $element->add_control('anelm_trunk_color', [
            'label' => __('Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#a44461',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'trunk',
            ],
        ]);

        $element->add_control('anelm_trunk_background_color', [
            'label' => __('Background Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#222428',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'trunk',
            ],
        ]);

        $element->add_control('anelm_trunk_spacing', [
            'label' => __('Spacing', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.00,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'trunk',
            ],
        ]);

        $element->add_control('anelm_trunk_chaos', [
            'label' => __('Chaos', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 2.00,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'trunk',
            ],
        ]);
    }

    public function render_animation($element) {
        $settings = $element->get_settings_for_display();
        if (!empty($settings['animate_elementor_bg_enable']) && 'trunk' === $settings['animate_elementor_bg_type']) :
            wp_enqueue_script( 'anelm-p5' );
            wp_enqueue_script( 'anelm-three' );
            wp_enqueue_script( 'anelm-vanta-trunk' );
            wp_enqueue_script( 'anelm-trunk-animation' );
            
            $element->add_render_attribute('_wrapper', 'data-bg-type', 'trunk');
            $element->add_render_attribute('_wrapper', 'data-mouse-controls', $settings['anelm_trunk_mouse_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-touch-controls', $settings['anelm_trunk_touch_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-gyro-controls', $settings['anelm_trunk_gyro_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-scale', $settings['anelm_trunk_scale']);
            $element->add_render_attribute('_wrapper', 'data-scale-mobile', $settings['anelm_trunk_scale_mobile']);
            $element->add_render_attribute('_wrapper', 'data-color', $settings['anelm_trunk_color']);
            $element->add_render_attribute('_wrapper', 'data-background-color', $settings['anelm_trunk_background_color']);
            $element->add_render_attribute('_wrapper', 'data-spacing', $settings['anelm_trunk_spacing']);
            $element->add_render_attribute('_wrapper', 'data-chaos', $settings['anelm_trunk_chaos']);
        endif;
    }
}
