jQuery(function ($) {
    class ANELM_Geometry_Waves_Animation {

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
                    color: widget_settings.anelm_geometry_wave_color,
                    shininess: widget_settings.anelm_geometry_wave_shininess,
                    waveHeight: widget_settings.anelm_geometry_wave_height,
                    waveSpeed: widget_settings.anelm_geometry_wave_speed,
                    zoom: widget_settings.anelm_geometry_wave_zoom,
                    scale: widget_settings.anelm_geometry_wave_scale,
                    scaleMobile: widget_settings.anelm_geometry_wave_scale_mobile,
                    mouseControls: widget_settings.anelm_geometry_wave_mouse_controls !== undefined ? widget_settings.anelm_geometry_wave_mouse_controls : true,
                    touchControls: widget_settings.anelm_geometry_wave_touch_controls !== undefined ? widget_settings.anelm_geometry_wave_touch_controls : true,
                    gyroControls: widget_settings.anelm_geometry_wave_gyro_controls !== undefined ? widget_settings.anelm_geometry_wave_gyro_controls : false,
                };
            }
            else {
                var settings = {
                    bg_type: wrapper.data('bg-type'),
                    color: wrapper.data('color'),
                    shininess: wrapper.data('shininess'),
                    waveHeight: wrapper.data('wave-height'),
                    waveSpeed: wrapper.data('wave-speed'),
                    zoom: wrapper.data('zoom'),
                    scale: wrapper.data('scale'),
                    scaleMobile: wrapper.data('scale-mobile'),
                    mouseControls: wrapper.data('mouse-controls') !== undefined ? wrapper.data('mouse-controls') : true,
                    touchControls: wrapper.data('touch-controls') !== undefined ? wrapper.data('touch-controls') : true,
                    gyroControls: wrapper.data('gyro-controls') !== undefined ? wrapper.data('gyro-controls') : false,
                };
            }

            if (settings.bg_type === 'geometry_waves') {
                this.applyAnimation(settings);
            }
        }

        applyAnimation(settings) {
            var _this = this,
                animation = VANTA.WAVES({
                    el: '.elementor-element-' + _this.section_id,
                    color: settings.color,
                    waveSpeed: settings.waveSpeed,
                    scale: settings.scale,
                    scaleMobile: settings.scaleMobile,
                    shininess: settings.shininess,
                    waveHeight: settings.waveHeight,
                    zoom: settings.zoom,
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

    new ANELM_Geometry_Waves_Animation();
});
