<?php
/**
 * Fog Animation Class for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes\Background_Animation
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class ANELM_Fog_Animation
 */
class ANELM_Fog_Animation {

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
            'anelm-vanta-fog',
            ANELM_URL . 'assets/js/vendor/vanta.fog.min.js',
            array( 'anelm-three' ),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );
        wp_register_script(
            'anelm-fog-animation',
            ANELM_URL . 'assets/js/bg-animations/anelm-fog-animation.js',
            array( 'anelm-vanta-fog' ),
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
        wp_enqueue_script( 'anelm-vanta-fog' );
        wp_enqueue_script( 'anelm-fog-animation' );
    }

    /**
     * Get animation type label.
     */
    public function get_animation_label() {
        return 'Fog';
    }

    /**
     * Get animation type.
     *
     * @return string
     */
    public function get_animation_type() {
        return 'fog';
    }

    /**
     * Register fog animation controls in Elementor.
     *
     * @param \Elementor\Element_Base $element
     */
    public function register_controls( $element ) {
        // Existing controls...
        // Add new Vanta.js fog animation controls below:
        
        $element->add_control('animate_elementor_bg_highlight_color', [
            'label' => __('Highlight Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffc300',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'fog',
            ],
        ]);

        $element->add_control('animate_elementor_bg_midtone_color', [
            'label' => __('Midtone Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ff1f00',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'fog',
            ],
        ]);

        $element->add_control('animate_elementor_bg_lowlight_color', [
            'label' => __('Lowlight Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#2d00ff',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'fog',
            ],
        ]);

        $element->add_control('animate_elementor_bg_base_color', [
            'label' => __('Base Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffebeb',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'fog',
            ],
        ]);

        $element->add_control('animate_elementor_bg_zoom', [
            'label' => __('Zoom', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'fog',
            ],
        ]);

        $element->add_control('animate_elementor_bg_blur_factor', [
            'label' => __('Blur', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0.8,
            'min' => 0,      // Minimum value
            'max' => 1,     // Maximum value
            'step' => 0.01,   // Increment step
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'fog',
            ],
        ]);

        $element->add_control('animate_elementor_bg_speed', [
            'label' => __('Speed', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'fog',
            ],
        ]);

        $element->add_control('animate_elementor_bg_mouse_controls', [
            'label' => __('Enable Mouse Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'fog',
            ],
        ]);


        $element->add_control('animate_elementor_bg_touch_controls', [
            'label' => __('Enable Touch Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'fog',
            ],
        ]);

        $element->add_control('animate_elementor_bg_gyro_controls', [
            'label' => __('Enable Gyro Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'no',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'fog',
            ],
        ]);
    }

    /**
     * Render fog animation attributes in frontend.
     *
     * @param \Elementor\Element_Base $element
     */
    public function render_animation($element) {
        $settings = $element->get_settings_for_display();
        if (!empty($settings['animate_elementor_bg_enable']) && 'fog' === $settings['animate_elementor_bg_type']) :
            
            wp_enqueue_script( 'anelm-three' );
            wp_enqueue_script( 'anelm-vanta-fog' );
            wp_enqueue_script( 'anelm-fog-animation' );

            $element->add_render_attribute('_wrapper', 'data-bg-type', 'fog');
            $element->add_render_attribute('_wrapper', 'data-highlight-color', $settings['animate_elementor_bg_highlight_color']);
            $element->add_render_attribute('_wrapper', 'data-midtone-color', $settings['animate_elementor_bg_midtone_color']);
            $element->add_render_attribute('_wrapper', 'data-lowlight-color', $settings['animate_elementor_bg_lowlight_color']);
            $element->add_render_attribute('_wrapper', 'data-base-color', $settings['animate_elementor_bg_base_color']);
            $element->add_render_attribute('_wrapper', 'data-blur-factor', $settings['animate_elementor_bg_blur_factor']);
            $element->add_render_attribute('_wrapper', 'data-zoom', $settings['animate_elementor_bg_zoom']);
            $element->add_render_attribute('_wrapper', 'data-speed', $settings['animate_elementor_bg_speed']);
            $element->add_render_attribute('_wrapper', 'data-mouse-controls', $settings['animate_elementor_bg_mouse_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-touch-controls', $settings['animate_elementor_bg_touch_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-gyro-controls', $settings['animate_elementor_bg_gyro_controls'] ? 'true' : 'false');
        endif;
    }
}
