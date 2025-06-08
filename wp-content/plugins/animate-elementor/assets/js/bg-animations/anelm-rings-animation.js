jQuery(function ($) {
    class ANELM_Rings_Animation {

        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', this.initializeRingsAnimation.bind(this));
        }

        initializeRingsAnimation(scope) {
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
                    backgroundColor: widget_settings.anelm_rings_background_color || '#21262a',
                    color: widget_settings.anelm_rings_color || '#84f208',
                    scale: parseFloat(widget_settings.anelm_rings_scale) || 1.0,
                    scaleMobile: parseFloat(widget_settings.anelm_rings_scale_mobile) || 1.0,
                    mouseControls: widget_settings.anelm_rings_mouse_controls !== undefined ? widget_settings.anelm_rings_mouse_controls : true,
                    touchControls: widget_settings.anelm_rings_touch_controls !== undefined ? widget_settings.anelm_rings_touch_controls : true,
                    gyroControls: widget_settings.anelm_rings_gyro_controls !== undefined ? widget_settings.anelm_rings_gyro_controls : false,
                };
            } else {
                var settings = {
                    bg_type: wrapper.data('bg-type'),
                    backgroundColor: wrapper.data('background-color') || '#21262a',
                    color: wrapper.data('color') || '#84f208',
                    scale: parseFloat(wrapper.data('scale')) || 1.0,
                    scaleMobile: parseFloat(wrapper.data('scale-mobile')) || 1.0,
                    mouseControls: wrapper.data('mouse-controls') !== undefined ? wrapper.data('mouse-controls') : true,
                    touchControls: wrapper.data('touch-controls') !== undefined ? wrapper.data('touch-controls') : true,
                    gyroControls: wrapper.data('gyro-controls') !== undefined ? wrapper.data('gyro-controls') : false,
                };
            }

            if (settings.bg_type === 'rings') {
                this.applyRingsAnimation(settings);
            }
        }

        applyRingsAnimation(settings) {
            var animation = VANTA.RINGS({
                el: '.elementor-element-' + this.section_id,
                scale: settings.scale,
                scaleMobile: settings.scaleMobile,
                backgroundColor: settings.backgroundColor,
                color: settings.color,
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

    new ANELM_Rings_Animation();
});
