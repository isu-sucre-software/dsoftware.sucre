jQuery(function ($) {
    class ANELM_Topology_Animation {

        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', this.initializeTopologyAnimation.bind(this));
        }

        initializeTopologyAnimation(scope) {
            this.section_id = scope.data('id');
            var _this = this,
                wrapper = $(scope),
                settings = {};

            if (window.isEditMode || window.elementorFrontend.isEditMode()) {
                if (!window.elementor.hasOwnProperty('elements') || !window.elementor.elements.models) return false;

                const targetElement = window.elementor.elements.find(el => el.id === _this.section_id || el.id === scope.closest('.elementor-top-section').data('id')),
                    widget_settings = targetElement.attributes.settings.attributes;

                if (!widget_settings.animate_elementor_bg_enable) return;

                settings = {
                    bg_type: widget_settings.animate_elementor_bg_type,
                    mouseControls: widget_settings.anelm_topology_mouse_controls !== undefined ? widget_settings.anelm_topology_mouse_controls : true,
                    touchControls: widget_settings.anelm_topology_touch_controls !== undefined ? widget_settings.anelm_topology_touch_controls : true,
                    gyroControls: widget_settings.anelm_topology_gyro_controls !== undefined ? widget_settings.anelm_topology_gyro_controls : false,
                    scale: parseFloat(widget_settings.anelm_topology_scale) || 1.0,
                    scaleMobile: parseFloat(widget_settings.anelm_topology_scale_mobile) || 1.0,
                    color: widget_settings.anelm_topology_color || '#8c9d50',
                    backgroundColor: widget_settings.anelm_topology_background_color || '#22525'
                };
            } else {
                settings = {
                    bg_type: wrapper.data('bg-type'),
                    mouseControls: wrapper.data('mouse-controls') !== undefined ? wrapper.data('mouse-controls') : true,
                    touchControls: wrapper.data('touch-controls') !== undefined ? wrapper.data('touch-controls') : true,
                    gyroControls: wrapper.data('gyro-controls') !== undefined ? wrapper.data('gyro-controls') : false,
                    scale: parseFloat(wrapper.data('scale')) || 1.0,
                    scaleMobile: parseFloat(wrapper.data('scale-mobile')) || 1.0,
                    color: wrapper.data('color') || '#8c9d50',
                    backgroundColor: wrapper.data('background-color') || '#22525'
                };
            }

            if (settings.bg_type === 'topology') {
                this.applyTopologyAnimation(settings);
            }
        }

        applyTopologyAnimation(settings) {
            var topologyani = VANTA.TOPOLOGY({
                el: '.elementor-element-' + this.section_id,
                mouseControls: settings.mouseControls,
                touchControls: settings.touchControls,
                gyroControls: settings.gyroControls,
                scale: settings.scale,
                scaleMobile: settings.scaleMobile,
                color: settings.color,
                backgroundColor: settings.backgroundColor
            });
            this.resize_Animation(topologyani);
        }

        resize_Animation(animation) {
            window.addEventListener("resize", () => {
                animation.restart();
            }, false);
        }
    }

    new ANELM_Topology_Animation();
});
