jQuery(function ($) {
    class ANELM_Dots_Animation {

        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', this.initializeDotsAnimation.bind(this));
        }

        initializeDotsAnimation(scope) {
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
                    mouseControls: widget_settings.anelm_dots_mouse_controls !== undefined ? widget_settings.anelm_dots_mouse_controls : true,
                    touchControls: widget_settings.anelm_dots_touch_controls !== undefined ? widget_settings.anelm_dots_touch_controls : true,
                    gyroControls: widget_settings.anelm_dots_gyro_controls !== undefined ? widget_settings.anelm_dots_gyro_controls : false,
                    scale: parseFloat(widget_settings.anelm_dots_scale) || 1.0,
                    scaleMobile: parseFloat(widget_settings.anelm_dots_scale_mobile) || 1.0,
                    color: widget_settings.anelm_dots_color || '#e87e20',
                    color2: widget_settings.anelm_dots_color2 || '#f57c14',
                    backgroundColor: widget_settings.anelm_dots_background_color || '#1e1e1e',
                    size: parseFloat(widget_settings.anelm_dots_size) || 3.4,
                    spacing: parseFloat(widget_settings.anelm_dots_spacing) || 26.0,
                };
            } else {
                settings = {
                    bg_type: wrapper.data('bg-type'),
                    mouseControls: wrapper.data('mouse-controls'),
                    touchControls: wrapper.data('touch-controls'),
                    gyroControls: wrapper.data('gyro-controls'),
                    scale: parseFloat(wrapper.data('scale')) || 1.0,
                    scaleMobile: parseFloat(wrapper.data('scale-mobile')) || 1.0,
                    color: wrapper.data('color') || '#e87e20',
                    color2: wrapper.data('color2') || '#f57c14',
                    backgroundColor: wrapper.data('background-color') || '#1e1e1e',
                    size: parseFloat(wrapper.data('size')) || 3.4,
                    spacing: parseFloat(wrapper.data('spacing')) || 26.0,
                };
            }

            if (settings.bg_type === 'dots') {
                this.applyDotsAnimation(settings);
            }
        }

        applyDotsAnimation(settings) {
            var _this = this,
                animation = VANTA.DOTS({
                    el: '.elementor-element-' + _this.section_id,
                    mouseControls: settings.mouseControls,
                    touchControls: settings.touchControls,
                    gyroControls: settings.gyroControls,
                    scale: settings.scale,
                    scaleMobile: settings.scaleMobile,
                    color: settings.color,
                    color2: settings.color2,
                    backgroundColor: settings.backgroundColor,
                    size: settings.size,
                    spacing: settings.spacing,
                });
            this.resize_Animation(animation);
        }

        resize_Animation(animation) {
            window.addEventListener("resize", () => {
                animation.restart();
            }, false);
        }
    }

    new ANELM_Dots_Animation();
});
