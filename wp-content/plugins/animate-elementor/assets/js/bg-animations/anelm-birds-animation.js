jQuery(function ($) {
    class ANELM_Birds_Animation {

        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', this.initializeBirdsAnimation.bind(this));
        }

        initializeBirdsAnimation(scope) {
            this.section_id = scope.data('id');
            var _this = this,
                wrapper = $(scope),
                settings = {};

            if (window.isEditMode || window.elementorFrontend.isEditMode()) {
                if (!window.elementor.hasOwnProperty('elements') || !window.elementor.elements.models) return false;

                const targetElement = window.elementor.elements.find(el => el.id === _this.section_id || el.id === scope.closest('.elementor-top-section').data('id')),
                    widget_settings = targetElement.attributes.settings.attributes;

                if (!widget_settings.animate_elementor_bg_enable && !widget_settings.animate_elementor_bg_type === 'birds') return;

                settings = {
                    bg_type: widget_settings.animate_elementor_bg_type,
                    mouseControls: widget_settings.anelm_birds_mouse_controls !== undefined ? widget_settings.anelm_birds_mouse_controls : true,
                    touchControls: widget_settings.anelm_birds_touch_controls !== undefined ? widget_settings.anelm_birds_touch_controls : true,
                    gyroControls: widget_settings.anelm_birds_gyro_controls !== undefined ? widget_settings.anelm_birds_gyro_controls : false,
                    scale: parseFloat(widget_settings.anelm_birds_scale),
                    scaleMobile: parseFloat(widget_settings.anelm_birds_scale_mobile),
                    backgroundColor: widget_settings.anelm_birds_background_color,
                    color1: widget_settings.anelm_birds_color1,
                    color2: widget_settings.anelm_birds_color2,
                    colorMode: widget_settings.anelm_birds_color_mode,
                    birdSize: parseFloat(widget_settings.anelm_birds_bird_size),
                    wingSpan: parseFloat(widget_settings.anelm_birds_wing_span),
                    speedLimit: parseFloat(widget_settings.anelm_birds_speed_limit),
                    separation: parseFloat(widget_settings.anelm_birds_separation),
                    alignment: parseFloat(widget_settings.anelm_birds_alignment),
                    cohesion: parseFloat(widget_settings.anelm_birds_cohesion),
                    quantity: parseFloat(widget_settings.anelm_birds_quantity),
                    backgroundAlpha: parseFloat(widget_settings.anelm_birds_background_alpha),
                };
            }
            else {
                settings = {
                    bg_type: wrapper.data('bg-type'),
                    mouseControls: wrapper.data('mouse-controls') !== undefined ? wrapper.data('mouse-controls') : true,
                    touchControls: wrapper.data('touch-controls') !== undefined ? wrapper.data('touch-controls') : true,
                    gyroControls: wrapper.data('gyro-controls') !== undefined ? wrapper.data('gyro-controls') : false,
                    scale: parseFloat(wrapper.data('scale')),
                    scaleMobile: parseFloat(wrapper.data('scale-mobile')),
                    backgroundColor: wrapper.data('background-color'),
                    color1: wrapper.data('color1'),
                    color2: wrapper.data('color2'),
                    colorMode: wrapper.data('color-mode'),
                    birdSize: parseFloat(wrapper.data('bird-size')),
                    wingSpan: parseFloat(wrapper.data('wing-span')),
                    speedLimit: parseFloat(wrapper.data('speed-limit')),
                    separation: parseFloat(wrapper.data('separation')),
                    alignment: parseFloat(wrapper.data('alignment')),
                    cohesion: parseFloat(wrapper.data('cohesion')),
                    quantity: parseFloat(wrapper.data('quantity')),
                    backgroundAlpha: parseFloat(wrapper.data('background-alpha')),
                };
            }

            if (settings.bg_type === 'birds') {
                this.applyBirdsAnimation(settings);
            }
        }

        applyBirdsAnimation(settings) {
            var _this = this,
                animation = VANTA.BIRDS({
                    el: '.elementor-element-' + _this.section_id,
                    mouseControls: settings.mouseControls,
                    touchControls: settings.touchControls,
                    gyroControls: settings.gyroControls,
                    scale: settings.scale,
                    scaleMobile: settings.scaleMobile,
                    backgroundColor: settings.backgroundColor,
                    color1: settings.color1,
                    color2: settings.color2,
                    colorMode: settings.colorMode,
                    birdSize: settings.birdSize,
                    wingSpan: settings.wingSpan,
                    speedLimit: settings.speedLimit,
                    separation: settings.separation,
                    alignment: settings.alignment,
                    cohesion: settings.cohesion,
                    quantity: settings.quantity,
                    backgroundAlpha: settings.backgroundAlpha,
                });
            this.resize_Animation(animation);
        }

        resize_Animation(animation) {
            window.addEventListener("resize", () => {
                animation.restart();
            }, false);
        }
    }

    new ANELM_Birds_Animation();
});
