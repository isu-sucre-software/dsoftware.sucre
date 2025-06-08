jQuery(function ($) {
    class ANELM_Particles_Net_Animation {
        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', this.initializeAnimation.bind(this));
        }

        initializeAnimation(scope) {
            this.section_id = scope.data('id');
            const wrapper = $(scope);
            var settings = {};

            if (window.isEditMode || window.elementorFrontend.isEditMode()) {
                if (!window.elementor?.elements?.models) return;

                const targetElement = window.elementor.elements.find(el => el.id === this.section_id || el.id === scope.closest('.elementor-top-section').data('id'));
                const widget_settings = targetElement?.attributes?.settings?.attributes;
                if (!widget_settings.animate_elementor_bg_enable) return;

                settings = {
                    bg_type: widget_settings.animate_elementor_bg_type,
                    mouseControls: widget_settings.anelm_particles_net_mouse_controls !== undefined ? widget_settings.anelm_particles_net_mouse_controls : true,
                    touchControls: widget_settings.anelm_particles_net_touch_controls !== undefined ? widget_settings.anelm_particles_net_touch_controls : true,
                    gyroControls: widget_settings.anelm_particles_net_gyro_controls,
                    scale: parseFloat(widget_settings.anelm_particles_net_scale),
                    scaleMobile: parseFloat(widget_settings.anelm_particles_net_scale_mobile),
                    color: widget_settings.anelm_particles_net_color,
                    backgroundColor: widget_settings.anelm_particles_net_background_color,
                    points: parseFloat(widget_settings.anelm_particles_net_points),
                    maxDistance: parseFloat(widget_settings.anelm_particles_net_max_distance),
                };
            } else {
                settings = {
                    bg_type: wrapper.data('bg-type'),
                    mouseControls: wrapper.data('mouse-controls'),
                    touchControls: wrapper.data('touch-controls'),
                    gyroControls: wrapper.data('gyro-controls'),
                    scale: parseFloat(wrapper.data('scale')),
                    scaleMobile: parseFloat(wrapper.data('scale-mobile')),
                    color: wrapper.data('color'),
                    backgroundColor: wrapper.data('background-color'),
                    points: parseFloat(wrapper.data('points')),
                    maxDistance: parseFloat(wrapper.data('max-distance')),
                };
            }

            if (settings.bg_type === 'particles_net') {
                this.applyAnimation(settings);
            }
        }

        applyAnimation(settings) {
            VANTA.NET({
                el: '.elementor-element-' + this.section_id,
                mouseControls: settings.mouseControls,
                touchControls: settings.touchControls,
                gyroControls: settings.gyroControls,
                scale: settings.scale,
                scaleMobile: settings.scaleMobile,
                color: settings.color,
                backgroundColor: settings.backgroundColor,
                points: settings.points,
                maxDistance: settings.maxDistance
            });

            this.resize_Animation(animation);
        }

        resize_Animation(animation) {
            window.addEventListener("resize", () => {
                animation.restart();
            }, false);
        }
    }

    new ANELM_Particles_Net_Animation();
});
