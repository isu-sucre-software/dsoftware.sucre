<?php
/**
 * Geometry Waves Animation Class for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes\Background_Animation
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class ANELM_Geometry_Waves_Animation
 */
class ANELM_Geometry_Waves_Animation {

    /**
     * Initialize hooks for script enqueue and rendering.
     */
    public function __construct() {
        $this->initialize_script();
        add_action( 'elementor/preview/enqueue_scripts', array( $this, 'maybe_enqueue_scripts' ) );
        add_action( 'elementor/frontend/before_render', array( $this, 'render_animation' ), 1000, 1 );
    }

    /**
     * Enqueue required JS scripts for geometry waves animation.
     */
    public function initialize_script() {
        wp_register_script(
            'anelm-vanta-geometry-waves',
            ANELM_URL . 'assets/js/vendor/vanta.waves.min.js', // Update with actual file name
            array( 'anelm-three' ),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );

        wp_register_script(
            'anelm-geometry-waves-animation',
            ANELM_URL . 'assets/js/bg-animations/anelm-geometry-waves-animation.js',
            array( 'anelm-vanta-geometry-waves' ),
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
        wp_enqueue_script( 'anelm-vanta-geometry-waves' );
        wp_enqueue_script( 'anelm-geometry-waves-animation' );
    }

    /**
     * Get animation type label.
     */
    public function get_animation_label() {
        return 'Geometry Waves';
    }

    /**
     * Get animation type.
     *
     * @return string
     */
    public function get_animation_type() {
        return 'geometry_waves';
    }

    /**
     * Register geometry waves controls in Elementor.
     *
     * @param \Elementor\Element_Base $element
     */
    public function register_controls( $element ) {

        $element->add_control('anelm_geometry_wave_color', [
            'label' => __('Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ff0080',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'geometry_waves',
            ],
        ]);

        $element->add_control('anelm_geometry_wave_shininess', [
            'label' => __('Shininess', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 50,
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'geometry_waves',
            ],
        ]);

        $element->add_control('anelm_geometry_wave_height', [
            'label' => __('Wave Height', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 20,
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'geometry_waves',
            ],
        ]);

        $element->add_control('anelm_geometry_wave_speed', [
            'label' => __('Wave Speed', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'step' => 0.1,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'geometry_waves',
            ],
        ]);

        $element->add_control('anelm_geometry_wave_zoom', [
            'label' => __('Zoom', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'min' => 0.1,
            'max' => 5,
            'step' => 0.1,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'geometry_waves',
            ],
        ]);

        $element->add_control('anelm_geometry_wave_scale', [
            'label' => __('Scale', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'min' => 0.1,
            'max' => 5,
            'step' => 0.1,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'geometry_waves',
            ],
        ]);

        $element->add_control('anelm_geometry_wave_scale_mobile', [
            'label' => __('Scale (Mobile)', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'min' => 0.1,
            'max' => 5,
            'step' => 0.1,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'geometry_waves',
            ],
        ]);

        $element->add_control('anelm_geometry_wave_mouse_controls', [
            'label' => __('Enable Mouse Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'geometry_waves',
            ],
        ]);

        $element->add_control('anelm_geometry_wave_touch_controls', [
            'label' => __('Enable Touch Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'geometry_waves',
            ],
        ]);

        $element->add_control('anelm_geometry_wave_gyro_controls', [
            'label' => __('Enable Gyro Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'no',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'geometry_waves',
            ],
        ]);
    }

    /**
     * Render geometry waves attributes on frontend.
     *
     * @param \Elementor\Element_Base $element
     */
    public function render_animation( $element ) {
        $settings = $element->get_settings_for_display();

        if ( ! empty( $settings['animate_elementor_bg_enable'] ) && 'geometry_waves' === $settings['animate_elementor_bg_type'] ) :
            wp_enqueue_script( 'anelm-three' );
            wp_enqueue_script( 'anelm-vanta-geometry-waves' );
            wp_enqueue_script( 'anelm-geometry-waves-animation' );

            $element->add_render_attribute('_wrapper', 'data-bg-type', 'geometry_waves');
            $element->add_render_attribute('_wrapper', 'data-color', $settings['anelm_geometry_wave_color']);
            $element->add_render_attribute('_wrapper', 'data-shininess', $settings['anelm_geometry_wave_shininess']);
            $element->add_render_attribute('_wrapper', 'data-wave-height', $settings['anelm_geometry_wave_height']);
            $element->add_render_attribute('_wrapper', 'data-wave-speed', $settings['anelm_geometry_wave_speed']);
            $element->add_render_attribute('_wrapper', 'data-zoom', $settings['anelm_geometry_wave_zoom']);
            $element->add_render_attribute('_wrapper', 'data-scale', $settings['anelm_geometry_wave_scale']);
            $element->add_render_attribute('_wrapper', 'data-scale-mobile', $settings['anelm_geometry_wave_scale_mobile']);
            $element->add_render_attribute('_wrapper', 'data-mouse-controls', $settings['anelm_geometry_wave_mouse_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-touch-controls', $settings['anelm_geometry_wave_touch_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-gyro-controls', $settings['anelm_geometry_wave_gyro_controls'] ? 'true' : 'false');
        endif;
    }
}
