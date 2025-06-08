jQuery(function ($) {
    class ANELM_Fog_Animation {

        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', this.initializeFogAnimation.bind(this));
        }

        initializeFogAnimation(scope) {
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
                    highlightColor: widget_settings.animate_elementor_bg_highlight_color || '#ffc300',
                    midtoneColor: widget_settings.animate_elementor_bg_midtone_color || '#ff1f00',
                    lowlightColor: widget_settings.animate_elementor_bg_lowlight_color || '#2d00ff',
                    baseColor: widget_settings.animate_elementor_bg_base_color || '#ffebeb',
                    blurFactor: parseFloat(widget_settings.animate_elementor_bg_blur_factor) || 0.5,
                    zoom: parseFloat(widget_settings.animate_elementor_bg_zoom) || 1.0,
                    speed: parseFloat(widget_settings.animate_elementor_bg_speed) || 1.0,
                    mouseControls: widget_settings.animate_elementor_bg_mouse_controls !== undefined ? widget_settings.animate_elementor_bg_mouse_controls : true,
                    touchControls: widget_settings.animate_elementor_bg_touch_controls !== undefined ? widget_settings.animate_elementor_bg_touch_controls : true,
                    gyroControls: widget_settings.animate_elementor_bg_gyro_controls !== undefined ? widget_settings.animate_elementor_bg_gyro_controls : false,
                };
            }
            else {
                var settings = {
                    bg_type: wrapper.data('bg-type'),
                    highlightColor: wrapper.data('highlight-color') || '#ffc300',
                    midtoneColor: wrapper.data('midtone-color') || '#ff1f00',
                    lowlightColor: wrapper.data('lowlight-color') || '#2d00ff',
                    baseColor: wrapper.data('base-color') || '#ffebeb',
                    blurFactor: parseFloat(wrapper.data('blur-factor')) || 0.5,
                    zoom: parseFloat(wrapper.data('zoom')) || 1.0,
                    speed: parseFloat(wrapper.data('speed')) || 1.0,
                    mouseControls: wrapper.data('mouse-controls') !== undefined ? wrapper.data('mouse-controls') : true,
                    touchControls: wrapper.data('touch-controls') !== undefined ? wrapper.data('touch-controls') : true,
                    gyroControls: wrapper.data('gyro-controls') !== undefined ? wrapper.data('gyro-controls') : false,
                };
            }

            if (settings.bg_type === 'fog') {
                this.applyFogAnimation(settings);
            }
        }

        applyFogAnimation(settings) {
            var animation = VANTA.FOG({
                el: '.elementor-element-' + this.section_id,
                minHeight: 200.00,
                highlightColor: settings.highlightColor,
                midtoneColor: settings.midtoneColor,
                lowlightColor: settings.lowlightColor,
                baseColor: settings.baseColor,
                blurFactor: settings.blurFactor,
                zoom: settings.zoom,
                speed: settings.speed,
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

    new ANELM_Fog_Animation();
});
