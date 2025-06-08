<?php
/**
 * Topology Animation Class for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes\Background_Animation
 */

defined( 'ABSPATH' ) || exit;

class ANELM_Topology_Animation {

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
            'anelm-vanta-topology',
            ANELM_URL . 'assets/js/vendor/vanta.topology.min.js',
            array( 'anelm-three' ),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );

        wp_register_script(
            'anelm-topology-animation',
            ANELM_URL . 'assets/js/bg-animations/anelm-topology-animation.js',
            array( 'anelm-vanta-topology' ),
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
        wp_enqueue_script( 'anelm-vanta-topology' );
        wp_enqueue_script( 'anelm-topology-animation' );
    }

    public function get_animation_label() {
        return 'Topology';
    }

    public function get_animation_type() {
        return 'topology';
    }

    public function register_controls( $element ) {
        $element->add_control('anelm_topology_mouse_controls', [
            'label' => __('Enable Mouse Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'topology',
            ],
        ]);

        $element->add_control('anelm_topology_touch_controls', [
            'label' => __('Enable Touch Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'topology',
            ],
        ]);

        $element->add_control('anelm_topology_gyro_controls', [
            'label' => __('Enable Gyro Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'no',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'topology',
            ],
        ]);

        $element->add_control('anelm_topology_scale', [
            'label' => __('Scale', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'topology',
            ],
        ]);

        $element->add_control('anelm_topology_scale_mobile', [
            'label' => __('Scale Mobile', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'topology',
            ],
        ]);

        $element->add_control('anelm_topology_color', [
            'label' => __('Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#8c9d50',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'topology',
            ],
        ]);

        $element->add_control('anelm_topology_background_color', [
            'label' => __('Background Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#22525',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'topology',
            ],
        ]);
    }

    public function render_animation($element) {
        $settings = $element->get_settings_for_display();
        if (!empty($settings['animate_elementor_bg_enable']) && 'topology' === $settings['animate_elementor_bg_type']) :
            wp_enqueue_script( 'anelm-p5' );
            wp_enqueue_script( 'anelm-three' );
            wp_enqueue_script( 'anelm-vanta-topology' );
            wp_enqueue_script( 'anelm-topology-animation' );

            $element->add_render_attribute('_wrapper', 'data-bg-type', 'topology');
            $element->add_render_attribute('_wrapper', 'data-mouse-controls', $settings['anelm_topology_mouse_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-touch-controls', $settings['anelm_topology_touch_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-gyro-controls', $settings['anelm_topology_gyro_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-scale', $settings['anelm_topology_scale']);
            $element->add_render_attribute('_wrapper', 'data-scale-mobile', $settings['anelm_topology_scale_mobile']);
            $element->add_render_attribute('_wrapper', 'data-color', $settings['anelm_topology_color']);
            $element->add_render_attribute('_wrapper', 'data-background-color', $settings['anelm_topology_background_color']);
        endif;
    }
}
