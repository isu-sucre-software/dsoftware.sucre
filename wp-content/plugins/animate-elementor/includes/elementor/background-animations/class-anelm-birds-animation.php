<?php
/**
 * Birds Animation Class for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes\Background_Animation
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class ANELM_Birds_Animation
 */
class ANELM_Birds_Animation {
    /**
     * Static flag to conditionally enqueue scripts.
     */
    protected static $should_enqueue_scripts = false;

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
            'anelm-birds',
            ANELM_URL . 'assets/js/vendor/vanta.birds.min.js',
            array( 'anelm-three' ),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );
        wp_register_script(
            'anelm-birds-animation',
            ANELM_URL . 'assets/js/bg-animations/anelm-birds-animation.js',
            array( 'anelm-birds' ),
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
        wp_enqueue_script( 'anelm-birds' );
        wp_enqueue_script( 'anelm-birds-animation' );
    }

    /**
     * Get animation type label.
     */
    public function get_animation_label() {
        return 'Birds';
    }

    /**
     * Get animation type.
     *
     * @return string
     */
    public function get_animation_type() {
        return 'birds';
    }

    /**
     * Register birds animation controls in Elementor.
     *
     * @param \Elementor\Element_Base $element
     */
    public function register_controls( $element ) {
        $element->add_control('anelm_birds_mouse_controls', [
            'label' => __('Enable Mouse Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
        ]);

        $element->add_control('anelm_birds_touch_controls', [
            'label' => __('Enable Touch Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
        ]);

        $element->add_control('anelm_birds_gyro_controls', [
            'label' => __('Enable Gyro Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'no',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
        ]);

        $element->add_control('anelm_birds_scale', [
            'label' => __('Scale', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
            'step' => 0.01,
        ]);

        $element->add_control('anelm_birds_scale_mobile', [
            'label' => __('Scale Mobile', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
            'step' => 0.01,
        ]);

        $element->add_control('anelm_birds_background_color', [
            'label' => __('Background Color', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#07192f',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
        ]);

        $element->add_control('anelm_birds_color1', [
            'label' => __('Color 1', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ff0000',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
        ]);

        $element->add_control('anelm_birds_color2', [
            'label' => __('Color 2', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#00d1ff',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
        ]);

        $element->add_control('anelm_birds_color_mode', [
            'label' => __('Color Mode', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'varianceGradient',
            'options' => [
                'lerp'              => __('Lerp', 'animate-elementor'),
                'variance'          => __('variance', 'animate-elementor'),
                'lerpGradient'      => __('lerpGradient', 'animate-elementor'),
                'varianceGradient'  => __('varianceGradient', 'animate-elementor'),
            ],
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type' => 'birds',
            ],
        ]);

        $element->add_control('anelm_birds_bird_size', [
            'label' => __('Bird Size', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
            'step' => 0.01,
        ]);

        $element->add_control('anelm_birds_wing_span', [
            'label' => __('Wing Span', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 30.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
            'step' => 0.01,
        ]);

        $element->add_control('anelm_birds_speed_limit', [
            'label' => __('Speed Limit', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 5.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
            'step' => 0.01,
        ]);

        $element->add_control('anelm_birds_separation', [
            'label' => __('Separation', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 20.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
            'step' => 0.01,
        ]);

        $element->add_control('anelm_birds_alignment', [
            'label' => __('Alignment', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 20.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
            'step' => 0.01,
        ]);

        $element->add_control('anelm_birds_cohesion', [
            'label' => __('Cohesion', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 20.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
            'step' => 0.01,
        ]);

        $element->add_control('anelm_birds_quantity', [
            'label' => __('Quantity', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 5.0,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
            'step' => 0.01,
        ]);

        $element->add_control('anelm_birds_background_alpha', [
            'label' => __('Background Alpha', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1,
            'min' => 0,
            'max' => 1,
            'step' => 0.01,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'birds',
            ],
        ]);
    }

    /**
     * Render birds animation attributes in frontend.
     *
     * @param \Elementor\Element_Base $element
     */
    public function render_animation($element) {
        $settings = $element->get_settings_for_display();
        if ( ! empty( $settings['animate_elementor_bg_enable']) && 'birds' === $settings['animate_elementor_bg_type'] ) :
            wp_enqueue_script( 'anelm-three' );
            wp_enqueue_script( 'anelm-birds' );
            wp_enqueue_script( 'anelm-birds-animation' );
            
            $element->add_render_attribute('_wrapper', 'data-bg-type', 'birds');
            $element->add_render_attribute('_wrapper', 'data-mouse-controls', $settings['anelm_birds_mouse_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-touch-controls', $settings['anelm_birds_touch_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-gyro-controls', $settings['anelm_birds_gyro_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-scale', $settings['anelm_birds_scale']);
            $element->add_render_attribute('_wrapper', 'data-scale-mobile', $settings['anelm_birds_scale_mobile']);
            $element->add_render_attribute('_wrapper', 'data-background-color', $settings['anelm_birds_background_color']);
            $element->add_render_attribute('_wrapper', 'data-color1', $settings['anelm_birds_color1']);
            $element->add_render_attribute('_wrapper', 'data-color2', $settings['anelm_birds_color2']);
            $element->add_render_attribute('_wrapper', 'data-color-mode', $settings['anelm_birds_color_mode']);
            $element->add_render_attribute('_wrapper', 'data-bird-size', $settings['anelm_birds_bird_size']);
            $element->add_render_attribute('_wrapper', 'data-wing-span', $settings['anelm_birds_wing_span']);
            $element->add_render_attribute('_wrapper', 'data-speed-limit', $settings['anelm_birds_speed_limit']);
            $element->add_render_attribute('_wrapper', 'data-separation', $settings['anelm_birds_separation']);
            $element->add_render_attribute('_wrapper', 'data-alignment', $settings['anelm_birds_alignment']);
            $element->add_render_attribute('_wrapper', 'data-cohesion', $settings['anelm_birds_cohesion']);
            $element->add_render_attribute('_wrapper', 'data-quantity', $settings['anelm_birds_quantity']);
            $element->add_render_attribute('_wrapper', 'data-background-alpha', $settings['anelm_birds_background_alpha']);
        endif;
    }
}
