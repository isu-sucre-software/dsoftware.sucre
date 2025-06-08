<?php
/**
 * Tilt Animation for Elementor Widgets.
 *
 * @package Animate_Elementor\Includes
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'ANELM_Tilt' ) ) :

	/**
	 * Class ANELM_Tilt
	 */
	class ANELM_Tilt {

		/**
		 * Constructor to hook into WordPress and Elementor actions.
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_tilt_assets' ) );
			add_action( 'elementor/element/before_section_end', array( $this, 'add_tilt_controls' ), 10, 3 );
			add_action( 'elementor/frontend/before_render', array( $this, 'add_tilt_attributes' ), 1001 );
		}

		/**
		 * Enqueue the Vanilla Tilt JS library.
		 */
		public function enqueue_tilt_assets() {
			wp_enqueue_script(
				'vanilla-tilt',
				ANELM_URL . 'assets/js/vendor/tilt.jquery.min.js',
				array(),
				ANELM_VERSION,
				true
			);
		}

		/**
		 * Add custom tilt animation controls to Elementor elements.
		 *
		 * @param \Elementor\Element_Base $element The Elementor element instance.
		 * @param string                  $section_id The ID of the current section.
		 * @param array                   $args Additional arguments.
		 */
		public function add_tilt_controls( $element, $section_id, $args ) {
			if ( 'animate_elementor_aos_section' !== $section_id ) :
				return;
			endif;

			$element->add_control(
				'animate_elementor_tilt_heading',
				array(
					'type'      => \Elementor\Controls_Manager::HEADING,
					'label'     => __( 'Tilt Animation', 'animate-elementor' ),
					'separator' => 'before',
				)
			);

			$element->add_control(
				'animate_elementor_tilt_enable',
				array(
					'label'        => __( 'Enable Tilt Animation', 'animate-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'animate-elementor' ),
					'label_off'    => __( 'No', 'animate-elementor' ),
					'return_value' => 'yes',
					'default'      => '',
					'description'  => __( 'Turn on to apply a 3D tilt effect on hover.', 'animate-elementor' ),
				)
			);

			$element->add_control(
				'animate_elementor_tilt_max',
				array(
					'label'       => __( 'Max Tilt Angle', 'animate-elementor' ),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'default'     => 20,
					'description' => __( 'Maximum tilt rotation in degrees.', 'animate-elementor' ),
					'condition'   => array( 'animate_elementor_tilt_enable' => 'yes' ),
				)
			);

			$element->add_control(
				'animate_elementor_tilt_perspective',
				array(
					'label'       => __( 'Perspective', 'animate-elementor' ),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'default'     => 1000,
					'description' => __( 'Lower values create a more intense effect.', 'animate-elementor' ),
					'condition'   => array( 'animate_elementor_tilt_enable' => 'yes' ),
				)
			);

			$element->add_control(
				'animate_elementor_tilt_easing',
				array(
					'label'       => __( 'Tilt Easing', 'animate-elementor' ),
					'description' => __( 'Speed curve of the animation.', 'animate-elementor' ),
					'type'        => \Elementor\Controls_Manager::SELECT,
					'default'     => 'cubic-bezier(.03,.98,.52,.99)',
					'options'     => $this->get_tilt_easing_options(),
					'condition'   => array( 'animate_elementor_tilt_enable' => 'yes' ),
				)
			);

			$element->add_control(
				'animate_elementor_tilt_scale',
				array(
					'label'       => __( 'Scale on Hover', 'animate-elementor' ),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'default'     => 1,
					'step'        => 0.1,
					'description' => __( 'Zoom level on hover. 1 = no scale.', 'animate-elementor' ),
					'condition'   => array( 'animate_elementor_tilt_enable' => 'yes' ),
				)
			);

			$element->add_control(
				'animate_elementor_tilt_speed',
				array(
					'label'       => __( 'Transition Speed (ms)', 'animate-elementor' ),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'default'     => 300,
					'description' => __( 'Speed of hover in/out transition.', 'animate-elementor' ),
					'condition'   => array( 'animate_elementor_tilt_enable' => 'yes' ),
				)
			);

			$element->add_control(
				'animate_elementor_tilt_transition',
				array(
					'label'        => __( 'Enable Transition', 'animate-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'true',
					'description'  => __( 'Smooth transition between tilt states.', 'animate-elementor' ),
					'condition'    => array( 'animate_elementor_tilt_enable' => 'yes' ),
				)
			);

			$element->add_control(
				'animate_elementor_tilt_disable_axis',
				array(
					'label'       => __( 'Disable Axis', 'animate-elementor' ),
					'type'        => \Elementor\Controls_Manager::SELECT,
					'options'     => array(
						''  => __( 'None', 'animate-elementor' ),
						'x' => __( 'Disable X Axis', 'animate-elementor' ),
						'y' => __( 'Disable Y Axis', 'animate-elementor' ),
					),
					'default'     => '',
					'description' => __( 'Select an axis to disable (optional).', 'animate-elementor' ),
					'condition'   => array( 'animate_elementor_tilt_enable' => 'yes' ),
				)
			);

			$element->add_control(
				'animate_elementor_tilt_reset',
				array(
					'label'        => __( 'Reset on Exit', 'animate-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'true',
					'description'  => __( 'Reset position when hover ends.', 'animate-elementor' ),
					'condition'    => array( 'animate_elementor_tilt_enable' => 'yes' ),
				)
			);

			$element->add_control(
				'animate_elementor_tilt_glare',
				array(
					'label'        => __( 'Enable Glare', 'animate-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'default'      => '',
					'return_value' => 'true',
					'description'  => __( 'Adds shiny glare effect.', 'animate-elementor' ),
					'condition'    => array( 'animate_elementor_tilt_enable' => 'yes' ),
				)
			);

			$element->add_control(
				'animate_elementor_tilt_max_glare',
				array(
					'label'       => __( 'Max Glare Intensity', 'animate-elementor' ),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'default'     => 1,
					'min'         => 0,
					'max'         => 1,
					'step'        => 0.1,
					'description' => __( '0 = none, 1 = full glare.', 'animate-elementor' ),
					'condition'   => array(
						'animate_elementor_tilt_enable' => 'yes',
						'animate_elementor_tilt_glare'  => 'true',
					),
				)
			);
		}

		/**
		 * Returns easing options for tilt animation.
		 *
		 * @return array
		 */
		public function get_tilt_easing_options() {
			return array(
				'linear'                            => __( 'Linear', 'animate-elementor' ),
				'ease'                              => __( 'Ease', 'animate-elementor' ),
				'ease-in'                           => __( 'Ease In', 'animate-elementor' ),
				'ease-out'                          => __( 'Ease Out', 'animate-elementor' ),
				'ease-in-out'                       => __( 'Ease In Out', 'animate-elementor' ),
				'cubic-bezier(.03,.98,.52,.99)'     => __( 'Tilt Default (Smooth)', 'animate-elementor' ),
				'cubic-bezier(0.25,0.46,0.45,0.94)' => __( 'Ease In Quad (Bezier)', 'animate-elementor' ),
				'cubic-bezier(0.55,0.085,0.68,0.53)' => __( 'Ease In Cubic (Bezier)', 'animate-elementor' ),
				'cubic-bezier(0.165,0.84,0.44,1)'   => __( 'Ease Out Cubic (Bezier)', 'animate-elementor' ),
				'cubic-bezier(0.77,0,0.175,1)'      => __( 'Ease In Out (Sharp)', 'animate-elementor' ),
			);
		}

		/**
		 * Adds data attributes to the wrapper for front-end rendering.
		 *
		 * @param \Elementor\Element_Base $element The Elementor element instance.
		 */
		public function add_tilt_attributes( $element ) {
			$settings = $element->get_settings_for_display();

			if ( empty( $settings['animate_elementor_tilt_enable'] ) || 'yes' !== $settings['animate_elementor_tilt_enable'] ) :
				return;
			endif;

			$element->add_render_attribute( '_wrapper', 'data-tilt', '' );

			$map = array(
				'animate_elementor_tilt_max'         => 'data-tilt-max',
				'animate_elementor_tilt_perspective' => 'data-tilt-perspective',
				'animate_elementor_tilt_easing'      => 'data-tilt-easing',
				'animate_elementor_tilt_scale'       => 'data-tilt-scale',
				'animate_elementor_tilt_speed'       => 'data-tilt-speed',
				'animate_elementor_tilt_disable_axis'=> 'data-tilt-disable-axis',
			);

			foreach ( $map as $key => $attr ) :
				if ( ! empty( $settings[ $key ] ) ) :
					$element->add_render_attribute( '_wrapper', $attr, $settings[ $key ] );
				endif;
			endforeach;

			$element->add_render_attribute( '_wrapper', 'data-tilt-transition', ! empty( $settings['animate_elementor_tilt_transition'] ) ? 'true' : 'false' );
			$element->add_render_attribute( '_wrapper', 'data-tilt-reset', ! empty( $settings['animate_elementor_tilt_reset'] ) ? 'true' : 'false' );

			if ( ! empty( $settings['animate_elementor_tilt_glare'] ) ) :
				$element->add_render_attribute( '_wrapper', 'data-tilt-glare', 'true' );
				$element->add_render_attribute( '_wrapper', 'data-tilt-max-glare', ! empty( $settings['animate_elementor_tilt_max_glare'] ) ? $settings['animate_elementor_tilt_max_glare'] : 1 );
			endif;
		}
	}

	new ANELM_Tilt();

endif;
