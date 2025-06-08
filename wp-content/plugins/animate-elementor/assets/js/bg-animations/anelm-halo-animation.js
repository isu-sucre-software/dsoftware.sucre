jQuery(function ($) {
    class ANELM_Halo_Animation {

        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', this.initializeHaloAnimation.bind(this));
        }

        initializeHaloAnimation(scope) {
            this.section_id = scope.data('id');
            var _this = this,
                wrapper = $(scope),
                settings = {};

            if (window.isEditMode || window.elementorFrontend.isEditMode()) {
                if (!window.elementor.hasOwnProperty('elements') || !window.elementor.elements.models) return false;

                const targetElement = window.elementor.elements.find(el => el.id === _this.section_id || el.id === scope.closest('.elementor-top-section').data('id')),
                    widget_settings = targetElement.attributes.settings.attributes;

                if (!widget_settings.animate_elementor_bg_enable) return;

                var settings = {
                    bg_type: widget_settings.animate_elementor_bg_type,
                    backgroundColor: widget_settings.anelm_halo_background_color || '#1e2866',
                    baseColor: widget_settings.anelm_halo_base_color || '#04174a',
                    amplitudeFactor: parseFloat(widget_settings.anelm_halo_amplitude_factor) || 1.10,
                    xOffset: parseFloat(widget_settings.anelm_halo_x_offset) || 0,
                    yOffset: parseFloat(widget_settings.anelm_halo_y_offset) || 0,
                    size: parseFloat(widget_settings.anelm_halo_size) || 1.20,
                    mouseControls: widget_settings.anelm_halo_mouse_controls !== undefined ? widget_settings.anelm_halo_mouse_controls : true,
                    touchControls: widget_settings.anelm_halo_touch_controls !== undefined ? widget_settings.anelm_halo_touch_controls : true,
                    gyroControls: widget_settings.anelm_halo_gyro_controls !== undefined ? widget_settings.anelm_halo_gyro_controls : false,
                };
            } else {
                var settings = {
                    bg_type: wrapper.data('bg-type'),
                    backgroundColor: wrapper.data('background-color') || '#1e2866',
                    baseColor: wrapper.data('base-color') || '#04174a',
                    amplitudeFactor: parseFloat(wrapper.data('amplitude-factor')) || 1,
                    xOffset: parseFloat(wrapper.data('x-offset')) || 0,
                    yOffset: parseFloat(wrapper.data('y-offset')) || 0,
                    size: parseFloat(wrapper.data('size')) || 1,
                    mouseControls: wrapper.data('mouse-controls') !== undefined ? wrapper.data('mouse-controls') : true,
                    touchControls: wrapper.data('touch-controls') !== undefined ? wrapper.data('touch-controls') : true,
                    gyroControls: wrapper.data('gyro-controls') !== undefined ? wrapper.data('gyro-controls') : false,
                };
            }

            if (settings.bg_type === 'halo') {
                this.applyHaloAnimation(settings);
            }
        }

        applyHaloAnimation(settings) {
            var animation = VANTA.HALO({
                el: '.elementor-element-' + this.section_id,
                baseColor: settings.baseColor,
                backgroundColor: settings.backgroundColor,
                amplitudeFactor: settings.amplitudeFactor,
                xOffset: settings.xOffset,
                yOffset: settings.yOffset,
                size: settings.size,
                mouseControls: settings.mouseControls,
                touchControls: settings.touchControls,
                gyroControls: settings.gyroControls,
            });
            this.resize_Animation(animation);
        }

        resize_Animation(animation) {
            window.addEventListener("resize", () => {
                animation.restart();
            }, false);
        }
    }

    new ANELM_Halo_Animation();
});
