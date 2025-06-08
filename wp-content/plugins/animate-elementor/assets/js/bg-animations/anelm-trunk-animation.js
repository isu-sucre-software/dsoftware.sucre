jQuery(function ($) {
    class ANELM_Trunk_Animation {
        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', this.initializeTrunkAnimation.bind(this));
        }

        initializeTrunkAnimation(scope) {
            this.section_id = scope.data('id');
            let wrapper = $(scope);
            let settings = {};

            if (window.isEditMode || window.elementorFrontend.isEditMode()) {
                const targetElement = window.elementor.elements.find(el => el.id === this.section_id || el.id === scope.closest('.elementor-top-section').data('id'));
                const widget_settings = targetElement?.attributes?.settings?.attributes || {};

                if (!widget_settings.animate_elementor_bg_enable) return;

                settings = {
                    bg_type: widget_settings.animate_elementor_bg_type,
                    mouseControls: widget_settings.anelm_trunk_mouse_controls ?? true,
                    touchControls: widget_settings.anelm_trunk_touch_controls ?? true,
                    gyroControls: widget_settings.anelm_trunk_gyro_controls ?? false,
                    scale: parseFloat(widget_settings.anelm_trunk_scale) || 1.0,
                    scaleMobile: parseFloat(widget_settings.anelm_trunk_scale_mobile) || 1.0,
                    color: widget_settings.anelm_trunk_color || '#a44461',
                    backgroundColor: widget_settings.anelm_trunk_background_color || '#222428',
                    spacing: parseFloat(widget_settings.anelm_trunk_spacing) || 1.0,
                    chaos: parseFloat(widget_settings.anelm_trunk_chaos) || 2.0,
                };
            } else {
                settings = {
                    bg_type: wrapper.data('bg-type'),
                    mouseControls: wrapper.data('mouse-controls'),
                    touchControls: wrapper.data('touch-controls'),
                    gyroControls: wrapper.data('gyro-controls'),
                    scale: parseFloat(wrapper.data('scale')) || 1.0,
                    scaleMobile: parseFloat(wrapper.data('scale-mobile')) || 1.0,
                    color: wrapper.data('color') || '#a44461',
                    backgroundColor: wrapper.data('background-color') || '#222428',
                    spacing: parseFloat(wrapper.data('spacing')) || 1.0,
                    chaos: parseFloat(wrapper.data('chaos')) || 2.0,
                };
            }

            if (settings.bg_type === 'trunk') {
                this.applyTrunkAnimation(settings);
            }
        }

        applyTrunkAnimation(settings) {
            const element = '.elementor-element-' + this.section_id;
            var animation = VANTA.TRUNK({
                el: element,
                ...settings
            });
            this.resize_Animation(animation);
        }

        resize_Animation(animation) {
            window.addEventListener("resize", () => {
                animation.restart();
            }, false);
        }
    }

    new ANELM_Trunk_Animation();
});
