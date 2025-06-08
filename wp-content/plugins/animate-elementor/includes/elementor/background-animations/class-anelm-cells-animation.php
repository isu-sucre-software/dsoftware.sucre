<?php
/**
 * Cells Animation Class for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes\Background_Animation
 */

defined( 'ABSPATH' ) || exit;

class ANELM_Cells_Animation {

    public function __construct() {
        $this->initialize_script();
        add_action( 'elementor/preview/enqueue_scripts', array( $this, 'maybe_enqueue_scripts' ) );
        add_action( 'elementor/frontend/before_render', array( $this, 'render_animation' ), 1000, 1 );
    }

    public function initialize_script() {
        wp_register_script(
            'anelm-vanta-cells',
            ANELM_URL . 'assets/js/vendor/vanta.cells.min.js',
            array( 'anelm-three' ),
            ANELM_VERSION,
            [
                'strategy' => 'defer',
                'in_footer' => true,
            ]
        );
        wp_register_script(
            'anelm-cells-animation',
            ANELM_URL . 'assets/js/bg-animations/anelm-cells-animation.js',
            array( 'anelm-vanta-cells' ),
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
        wp_enqueue_script( 'anelm-vanta-cells' );
        wp_enqueue_script( 'anelm-cells-animation' );
    }


    /**
     * Get animation type label.
     */
    public function get_animation_label() {
        return 'Cells';
    }

    public function get_animation_type() {
        return 'cells';
    }

    public function register_controls( $element ) {
        $element->add_control('anelm_cells_mouse_controls', [
            'label' => __('Enable Mouse Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'cells',
            ],
        ]);

        $element->add_control('anelm_cells_touch_controls', [
            'label' => __('Enable Touch Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'cells',
            ],
        ]);

        $element->add_control('anelm_cells_gyro_controls', [
            'label' => __('Enable Gyro Controls', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'no',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'cells',
            ],
        ]);

        $element->add_control('anelm_cells_scale', [
            'label' => __('Scale', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1.00,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'cells',
            ],
        ]);

        $element->add_control('anelm_cells_color1', [
            'label' => __('Color 1', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#089b9b',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'cells',
            ],
        ]);

        $element->add_control('anelm_cells_color2', [
            'label' => __('Color 2', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#f2e629',
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'cells',
            ],
        ]);

        $element->add_control('anelm_cells_speed', [
            'label' => __('Speed', 'animate-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0.80,
            'condition' => [
                'animate_elementor_bg_enable' => 'yes',
                'animate_elementor_bg_type'   => 'cells',
            ],
        ]);
    }

    public function render_animation($element) {
        $settings = $element->get_settings_for_display();
        if (!empty($settings['animate_elementor_bg_enable']) && 'cells' === $settings['animate_elementor_bg_type']) :
            
            wp_enqueue_script( 'anelm-three' );
            wp_enqueue_script( 'anelm-vanta-cells' );
            wp_enqueue_script( 'anelm-cells-animation' );

            $element->add_render_attribute('_wrapper', 'data-bg-type', 'cells');
            $element->add_render_attribute('_wrapper', 'data-mouse-controls', $settings['anelm_cells_mouse_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-touch-controls', $settings['anelm_cells_touch_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-gyro-controls', $settings['anelm_cells_gyro_controls'] ? 'true' : 'false');
            $element->add_render_attribute('_wrapper', 'data-scale', $settings['anelm_cells_scale']);
            $element->add_render_attribute('_wrapper', 'data-color1', $settings['anelm_cells_color1']);
            $element->add_render_attribute('_wrapper', 'data-color2', $settings['anelm_cells_color2']);
            $element->add_render_attribute('_wrapper', 'data-speed', $settings['anelm_cells_speed']);
        endif;
    }
}
