jQuery(function ($) {
    class ANELM_Cells_Animation {

        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', this.initializeAnimation.bind(this));
        }

        initializeAnimation(scope) {
            this.section_id = scope.data('id');
            const wrapper = $(scope);
            let settings = {};

            if (window.isEditMode || window.elementorFrontend.isEditMode()) {
                if (!window.elementor.hasOwnProperty('elements') || !window.elementor.elements.models) return;

                const targetElement = window.elementor.elements.find(el => el.id === this.section_id || el.id === scope.closest('.elementor-top-section').data('id')),
                    widget_settings = targetElement.attributes.settings.attributes;

                if (!widget_settings.animate_elementor_bg_enable) return;

                settings = {
                    bg_type: widget_settings.animate_elementor_bg_type,
                    mouseControls: widget_settings.anelm_cells_mouse_controls !== undefined ? widget_settings.anelm_cells_mouse_controls : true,
                    touchControls: widget_settings.anelm_cells_touch_controls !== undefined ? widget_settings.anelm_cells_touch_controls : true,
                    gyroControls: widget_settings.anelm_cells_gyro_controls !== undefined ? widget_settings.anelm_cells_gyro_controls : false,
                    scale: parseFloat(widget_settings.anelm_cells_scale) || 1.0,
                    color1: widget_settings.anelm_cells_color1 || '#089b9b',
                    color2: widget_settings.anelm_cells_color2 || '#f2e629',
                    speed: parseFloat(widget_settings.anelm_cells_speed) || 0.8,
                };
            } else {
                settings = {
                    bg_type: wrapper.data('bg-type'),
                    mouseControls: wrapper.data('mouse-controls'),
                    touchControls: wrapper.data('touch-controls'),
                    gyroControls: wrapper.data('gyro-controls'),
                    scale: parseFloat(wrapper.data('scale')) || 1.0,
                    color1: wrapper.data('color1') || '#089b9b',
                    color2: wrapper.data('color2') || '#f2e629',
                    speed: parseFloat(wrapper.data('speed')) || 0.8,
                };
            }
            if (settings.bg_type === 'cells') {
                this.applyCellsAnimation(settings);
            }
        }

        applyCellsAnimation(settings) {
            var animation = VANTA.CELLS({
                el: '.elementor-element-' + this.section_id,
                mouseControls: settings.mouseControls,
                touchControls: settings.touchControls,
                gyroControls: settings.gyroControls,
                scale: settings.scale,
                color1: settings.color1,
                color2: settings.color2,
                speed: settings.speed,
            });
            this.resize_Animation(animation);
        }

        resize_Animation(animation) {
            window.addEventListener("resize", () => {
                animation.restart();
            }, false);
        }
    }

    new ANELM_Cells_Animation();
});
