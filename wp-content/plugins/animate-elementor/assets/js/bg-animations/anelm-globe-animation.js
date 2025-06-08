jQuery(function ($) {
    class ANELM_Globe_Animation {
        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', this.initializeGlobeAnimation.bind(this));
        }

        initializeGlobeAnimation(scope) {
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
                    mouseControls: widget_settings.anelm_globe_mouse_controls !== undefined ? widget_settings.anelm_globe_mouse_controls : true,
                    touchControls: widget_settings.anelm_globe_touch_controls !== undefined ? widget_settings.anelm_globe_touch_controls : true,
                    gyroControls: widget_settings.anelm_globe_gyro_controls !== undefined ? widget_settings.anelm_globe_gyro_controls : false,
                    scale: parseFloat(widget_settings.anelm_globe_scale) || 1.0,
                    scaleMobile: parseFloat(widget_settings.anelm_globe_scale_mobile) || 1.0,
                    color: widget_settings.anelm_globe_color || '#d92967',
                    color2: widget_settings.anelm_globe_color2 || '#b91414',
                    size: parseFloat(widget_settings.anelm_globe_size) || 1.3,
                    backgroundColor: widget_settings.anelm_globe_background_color || '#856fb3'
                };
            } else {
                settings = {
                    bg_type: wrapper.data('bg-type'),
                    mouseControls: wrapper.data('mouse-controls') !== undefined ? wrapper.data('mouse-controls') : true,
                    touchControls: wrapper.data('touch-controls') !== undefined ? wrapper.data('touch-controls') : true,
                    gyroControls: wrapper.data('gyro-controls') !== undefined ? wrapper.data('gyro-controls') : false,
                    scale: parseFloat(wrapper.data('scale')) || 1.0,
                    scaleMobile: parseFloat(wrapper.data('scale-mobile')) || 1.0,
                    color: wrapper.data('color') || '#d92967',
                    color2: wrapper.data('color2') || '#b91414',
                    size: parseFloat(wrapper.data('size')) || 1.3,
                    backgroundColor: wrapper.data('background-color') || '#856fb3'
                };
            }

            if (settings.bg_type === 'globe') {
                this.applyGlobeAnimation(settings);
            }
        }

        applyGlobeAnimation(settings) {
            var animation = VANTA.GLOBE({
                el: '.elementor-element-' + this.section_id,
                mouseControls: settings.mouseControls,
                touchControls: settings.touchControls,
                gyroControls: settings.gyroControls,
                scale: settings.scale,
                scaleMobile: settings.scaleMobile,
                color: settings.color,
                color2: settings.color2,
                size: settings.size,
                backgroundColor: settings.backgroundColor
            });
            this.resize_Animation(animation);
        }

        resize_Animation(animation) {
            window.addEventListener("resize", () => {
                animation.restart();
            }, false);
        }
    }

    new ANELM_Globe_Animation();
});
