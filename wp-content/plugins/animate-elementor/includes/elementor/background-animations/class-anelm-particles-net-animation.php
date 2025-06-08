<?php
/**
 * Particles Net Animation Class for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes\Background_Animation
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class ANELM_Particles_Net_Animation
 */
class ANELM_Particles_Net_Animation {

    public function __construct() {
        $this->initialize_script();
        add_action( 'elementor/preview/enqueue_scripts', array( $this, 'maybe_enqueue_scripts' ) );
        add_action( 'elementor/frontend/before_render', array( $this, 'render_animation' ), 1000, 1 );
    }

    public function initialize_script() {
        wp_register_script(
            'anelm-vanta-net',
            ANELM_URL . 'assets/js/vendor/vanta.net.min.js',
            array( 'anelm-three' ),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );

        wp_register_script(
            'anelm-particles-net-animation',
            ANELM_URL . 'assets/js/bg-animations/anelm-particles-net-animation.js',
            array( 'anelm-vanta-net' ),
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
        wp_enqueue_script( 'anelm-vanta-net' );
        wp_enqueue_script( 'anelm-particles-net-animation' );
    }

    public function get_animation_label() {
        return 'Particles Net';
    }

    public function get_animation_type() {
        return 'particles_net';
    }

    public function register_controls( $element ) {
        $element->add_control('anelm_particles_net_mouse_controls', [
            'label' => __('Enable Mouse Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'particles_net',
            ],
        ]);

        $element->add_control('anelm_particles_net_touch_controls', [
            'label' => __('Enable Touch Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'particles_net',
            ],
        ]);

        $element->add_control('anelm_particles_net_gyro_controls', [
            'label' => __('Enable Gyro Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'no',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'particles_net',
            ],
        ]);

        $element->add_control('anelm_particles_net_scale', [
            'label' => __('Scale', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.00,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'particles_net',
            ],
        ]);

        $element->add_control('anelm_particles_net_scale_mobile', [
            'label' => __('Scale Mobile', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.00,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'particles_net',
            ],
        ]);

        $element->add_control('anelm_particles_net_color', [
            'label' => __('Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#fa4583',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'particles_net',
            ],
        ]);

        $element->add_control('anelm_particles_net_background_color', [
            'label' => __('Background Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#261643',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'particles_net',
            ],
        ]);

        $element->add_control('anelm_particles_net_points', [
            'label' => __('Points', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 11.00,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'particles_net',
            ],
        ]);

        $element->add_control('anelm_particles_net_max_distance', [
            'label' => __('Max Distance', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 26.00,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'particles_net',
            ],
        ]);
    }

    public function render_animation($element) {
        $settings = $element->get_settings_for_display();
        if (!empty($settings['animate_elementor_bg_enable']) && 'particles_net' === $settings['animate_elementor_bg_type']) :
            wp_enqueue_script( 'anelm-three' );
            wp_enqueue_script( 'anelm-vanta-net' );
            wp_enqueue_script( 'anelm-particles-net-animation' );

            $element->add_render_attribute('_wrapper', 'data-bg-type', 'particles_net');
            $element->add_render_attribute('_wrapper', 'data-mouse-controls', $settings['anelm_particles_net_mouse_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-touch-controls', $settings['anelm_particles_net_touch_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-gyro-controls', $settings['anelm_particles_net_gyro_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-scale', $settings['anelm_particles_net_scale']);
            $element->add_render_attribute('_wrapper', 'data-scale-mobile', $settings['anelm_particles_net_scale_mobile']);
            $element->add_render_attribute('_wrapper', 'data-color', $settings['anelm_particles_net_color']);
            $element->add_render_attribute('_wrapper', 'data-background-color', $settings['anelm_particles_net_background_color']);
            $element->add_render_attribute('_wrapper', 'data-points', $settings['anelm_particles_net_points']);
            $element->add_render_attribute('_wrapper', 'data-max-distance', $settings['anelm_particles_net_max_distance']);
        endif;
    }
}
