<?php
namespace Elementor;

class Wpt_CoverFlow_Slider extends Widget_Base {

    public function get_name() {
        return 'wpt-coverflow-slider-id';
    }

    public function get_title() {
        return esc_html__( 'Coverflow Slider', 'wpt-addon' );
    }

    public function get_script_depends() {
        return [
            'wpt-category-js' // Enqueue the JS file for category functionality
        ];
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return ['wpt-for-elementor'];
    }

    public function register_controls() {
        $this->start_controls_section(
            'wpt_cat_content_section',
            [
                'label' => esc_html__( 'CoverFlow Items', 'wpt-addon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'wpt_coverflow_image',
			[
				'label' => esc_html__( 'Choose Image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $repeater->add_control(
            'wpt_coverflow_title',
			[
				'label' => esc_html__( 'Title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'textdomain' ),
				'label_block' => true,
			]
        );

        $repeater->add_control(
			'wpt_coverflow_content',
			[
				'label' => esc_html__( 'Content', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'List Content' , 'textdomain' ),
				'show_label' => false,
			]
		);

        $this->add_control(
			'wpt_coverflow_list',
			[
				'label' => esc_html__( 'Coverflow Item', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'wpt_coverflow_title' => esc_html__( 'Title #1', 'textdomain' ),
						'wpt_coverflow_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'textdomain' ),
					],
					[
						'wpt_coverflow_title' => esc_html__( 'Title #2', 'textdomain' ),
						'wpt_coverflow_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'textdomain' ),
					],
				],
				'title_field' => '{{{ wpt_coverflow_title }}}',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'wpt_coverflow_settings_section',
            [
                'label' => esc_html__( 'Settings', 'wpt-addon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

		// Autoplay
		$this->add_control(
			'wpt_coverflow_autoplay',
			[
				'label' => esc_html__( 'Autoplay Speed', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '3000',
			]
		);

		// Loop
		$this->add_control(
			'wpt_coverflow_loop',
			[
				'label' => esc_html__( 'Loop', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'textdomain' ),
				'label_off' => esc_html__( 'Off', 'textdomain' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Loop
		$this->add_control(
			'wpt_coverflow_nav',
			[
				'label' => esc_html__( 'Navigation', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'textdomain' ),
				'label_off' => esc_html__( 'Off', 'textdomain' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->end_controls_section();
		
        $this->start_controls_section(
            'wpt_coverflow_nav_section',
            [
                'label' => esc_html__( 'Navigation', 'wpt-addon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'wpt_coverflow_nav' => 'yes',
				],
            ]
        );

		// Next Icon
		$this->add_control(
			'wpt_coverflow_icon_next',
			[
				'label' => esc_html__( 'Next Icon', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'circle',
						'dot-circle',
						'square-full',
					],
					'fa-regular' => [
						'circle',
						'dot-circle',
						'square-full',
					],
				],
			]
		);

		// Prev Icon
		$this->add_control(
			'wpt_coverflow_icon_prev',
			[
				'label' => esc_html__( 'Prev Icon', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-arrow-left',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'circle',
						'dot-circle',
						'square-full',
					],
					'fa-regular' => [
						'circle',
						'dot-circle',
						'square-full',
					],
				],
			]
		);

        $this->end_controls_section();

        // Style section
        $this->style_tab();
    }

    private function style_tab(){
        $this->start_controls_section(
            'wpt_coverflow_wrapper_section',
            [
                'label' => esc_html__( 'Wrapper', 'wpt-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
			'wpt_coverflow_wrapper_padding',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 50,
					'right' => 0,
					'bottom' => 140,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'wpt_coverflow_item_section',
            [
                'label' => esc_html__( 'Coverflow Items', 'wpt-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'wpt_coverflow_item_style',
			[
				'label' => esc_html__( 'Items Style', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
			'wpt_coverflow_item_width',
			[
				'label' => esc_html__( 'Width', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'wpt_coverflow_item_image',
			[
				'label' => esc_html__( 'Image Style', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
			'wpt_coverflow_image_width',
			[
				'label' => esc_html__( 'Width', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide .wpt-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'wpt_coverflow_image_height',
			[
				'label' => esc_html__( 'Height', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide .wpt-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'wpt_coverflow_item_content',
			[
				'label' => esc_html__( 'Content Wrapper', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'wpt_coverflow_content_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide .content',
			]
		);

		$this->add_responsive_control(
			'wpt_coverflow_content_margin',
			[
				'label' => esc_html__( 'Margin Top', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => -30,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide .content' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'wpt_coverflow_content_radius',
			[
				'label' => esc_html__( 'Border Radius', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 16,
					'right' => 16,
					'bottom' => 16,
					'left' => 16,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'wpt_coverflow_content_padding',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 12,
					'right' => 12,
					'bottom' => 24,
					'left' => 12,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'wpt_coverflow_item_content_title',
			[
				'label' => esc_html__( 'Title Style', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'wpt_coverflow_title_typography',
				'selector' => '{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide .content h3',
			]
		);

		$this->add_control(
			'wpt_coverflow_title_color',
			[
				'label' => esc_html__( 'Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide .content h3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wpt_coverflow_title_margin',
			[
				'label' => esc_html__( 'Specing', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 16,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide .content h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'wpt_coverflow_item_content_text',
			[
				'label' => esc_html__( 'Text Style', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'wpt_coverflow_text_typography',
				'selector' => '{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide .content p',
			]
		);

		$this->add_control(
			'wpt_coverflow_text_color',
			[
				'label' => esc_html__( 'Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide .content p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wpt_coverflow_text_margin',
			[
				'label' => esc_html__( 'Specing', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .swiper-slide .content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'wpt_coverflow_nav_section_style',
            [
                'label' => esc_html__( 'Navigation', 'wpt-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

		// Width
		$this->add_control(
			'wpt_coverflow_nav_width',
			[
				'label' => esc_html__( 'Width', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 48,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .wp-slide-nav .swiper-button-next, .swiper.wpt-coverflow .wp-slide-nav .swiper-button-prev' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Width
		$this->add_control(
			'wpt_coverflow_nav_height',
			[
				'label' => esc_html__( 'Height', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 48,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .wp-slide-nav .swiper-button-next, .swiper.wpt-coverflow .wp-slide-nav .swiper-button-prev' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		// Icon Size
		$this->add_control(
			'wpt_coverflow_nav_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .wp-slide-nav .swiper-button-next svg, .swiper.wpt-coverflow .wp-slide-nav .swiper-button-prev svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Control Tab
		$this->start_controls_tabs(
			'wpt_coverflow_nav_style_tabs'
		);
		
		$this->start_controls_tab(
			'wpt_coverflow_nav_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'textdomain' ),
			]
		);

		// Icon Color
		$this->add_control(
			'wpt_coverflow_nav_normal_color',
			[
				'label' => esc_html__( 'Icon Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .wp-slide-nav .swiper-button-next svg path, .swiper.wpt-coverflow .wp-slide-nav .swiper-button-prev svg path' => 'fill: {{VALUE}}',
				],
			]
		);

		// Background
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'wpt_coverflow_nav_normal_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .swiper.wpt-coverflow .wp-slide-nav .swiper-button-next, .swiper.wpt-coverflow .wp-slide-nav .swiper-button-prev',
			]
		);

		// Border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'wpt_coverflow_nav_normal_border',
				'selector' => '{{WRAPPER}} .swiper.wpt-coverflow .wp-slide-nav .swiper-button-next, .swiper.wpt-coverflow .wp-slide-nav .swiper-button-prev',
			]
		);
		
		$this->end_controls_tab();

		$this->start_controls_tab(
			'wpt_coverflow_nav_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'textdomain' ),
			]
		);

		// Icon Color
		$this->add_control(
			'wpt_coverflow_nav_hover_color',
			[
				'label' => esc_html__( 'Icon Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .wp-slide-nav .swiper-button-next svg path, .swiper.wpt-coverflow .wp-slide-nav .swiper-button-prev svg path' => 'fill: {{VALUE}}',
				],
			]
		);

		// Background
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'wpt_coverflow_nav_hover_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .swiper.wpt-coverflow .wp-slide-nav .swiper-button-next, .swiper.wpt-coverflow .wp-slide-nav .swiper-button-prev',
			]
		);

		// Icon Color
		$this->add_control(
			'wpt_coverflow_nav_hover_border',
			[
				'label' => esc_html__( 'Border Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .wp-slide-nav .swiper-button-next, .swiper.wpt-coverflow .wp-slide-nav .swiper-button-prev' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		// Border Radius
		$this->add_control(
			'wpt_coverflow_nav_radius',
			[
				'label' => esc_html__( 'Border Radius', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 50,
					'right' => 50,
					'bottom' => 50,
					'left' => 50,
					'unit' => '%',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper.wpt-coverflow .wp-slide-nav .swiper-button-next, .swiper.wpt-coverflow .wp-slide-nav .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
		$this->add_render_attribute(
            'wpt_coverflow_slider_options',
            [
                'data-loop'   => $settings[ 'wpt_coverflow_loop' ],
                'data-autoplay'   => $settings[ 'wpt_coverflow_autoplay' ],
            ]
        );
        ?>
            <div class="swiper wpt-coverflow" <?php echo $this->get_render_attribute_string('wpt_coverflow_slider_options'); ?>>
                <div class="swiper-wrapper">
                    <?php if( $settings[ 'wpt_coverflow_list' ] ) : ?>
                        <?php foreach( $settings[ 'wpt_coverflow_list' ] as $item ) : ?>
                            <div class="swiper-slide">
                                <div class="wpt-img" style="background: url(<?php echo esc_url( $item[ 'wpt_coverflow_image' ][ 'url' ] ); ?>) no-repeat;">
                                </div>
                                <div class="content">
                                    <h3><?php echo $item[ 'wpt_coverflow_title' ]; ?></h3>
                                    <p><?php echo $item[ 'wpt_coverflow_content' ]; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
				<?php if( 'yes' == $settings[ 'wpt_coverflow_nav' ] ) : ?>
					<div class="wp-slide-nav">
						<div class="swiper-button-next">
							<?php \Elementor\Icons_Manager::render_icon( $settings['wpt_coverflow_icon_next'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
						<div class="swiper-button-prev">
							<?php \Elementor\Icons_Manager::render_icon( $settings['wpt_coverflow_icon_prev'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					</div>
				<?php endif; ?>
            </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Wpt_CoverFlow_Slider() );