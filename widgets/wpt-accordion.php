<?php
namespace Elementor;

class Wpt_Accordion extends Widget_Base {

    public function get_name() {
        return 'wpt-accordion-id';
    }

    public function get_title() {
        return esc_html__( 'Accordion', 'wpt-addon' );
    }

    public function get_script_depends() {
        return [
            'wpt-category-js' // Enqueue the JS file for category functionality
        ];
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return ['wpt-for-elementor'];
    }

    public function register_controls() {
        $this->start_controls_section(
            'wpt_accr_content_section',
            [
                'label' => esc_html__( 'Accordion', 'wpt-addon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'wpt_accr_list_icon',
			[
				'label' => esc_html__( 'Icon', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
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

        $repeater->add_control(
			'wpt_accr_list_title',
			[
				'label' => esc_html__( 'Title', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'wpt-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'wpt_accr_list_content',
			[
				'label' => esc_html__( 'Content', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'List Content' , 'wpt-addon' ),
				'show_label' => false,
			]
		);

        $repeater->add_control(
			'wpt_accr_image',
			[
				'label' => esc_html__( 'Choose Image', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
			'wpt_accr_list',
			[
				'label' => esc_html__( 'Accordion List', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'wpt_accr_list_title' => esc_html__( 'Title #1', 'wpt-addon' ),
						'wpt_accr_list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'wpt-addon' ),
					],
					[
						'wpt_accr_list_title' => esc_html__( 'Title #2', 'wpt-addon' ),
						'wpt_accr_list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'wpt-addon' ),
					],
				],
				'title_field' => '{{{ wpt_accr_list_title }}}',
			]
		);

        $this->end_controls_section();

        // Style section
        $this->style_tab();
    }

    private function style_tab(){
        $this->start_controls_section(
            'wpt_accr_wrapper_section',
            [
                'label' => esc_html__( 'Wrapper', 'wpt-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Wrapper Style
        $this->add_control(
			'wpt_accr_wrapper',
			[
				'label' => esc_html__( 'Wrapper', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'wpt_accr_wrapper_border',
				'selector' => '{{WRAPPER}} .wpt-accordion-item',
			]
		);

        // Title Style
        $this->add_control(
			'wpt_accr_title_style',
			[
				'label' => esc_html__( 'Title', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // Typography
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'wpt_accr_title_typography',
				'selector' => '{{WRAPPER}} .wpt-accordion-header .wpt-accr-iocn-list .wpt-accr-icon-title h3',
			]
		);

        $this->add_control(
			'wpt_accr_title_color',
			[
				'label' => esc_html__( 'Title Color', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpt-accordion-header .wpt-accr-iocn-list .wpt-accr-icon-title h3' => 'color: {{VALUE}}',
				],
			]
		);

        // Padding
        $this->add_responsive_control(
			'wpt_accr_title_padding',
			[
				'label' => esc_html__( 'Padding', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 24,
					'right' => 16,
					'bottom' => 24,
					'left' => 16,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .wpt-accordion-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        // Icon Style
        $this->add_control(
			'wpt_accr_icon_style',
			[
				'label' => esc_html__( 'Icon', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // Icon Width
        $this->add_responsive_control(
			'wpt_accr_icon_width',
			[
				'label' => esc_html__( 'Width', 'wpt-addon' ),
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
					'{{WRAPPER}} .wpt-accordion-header .wpt-accr-iocn-list .wpt-accr-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        // Icon Height
        $this->add_responsive_control(
			'wpt_accr_icon_height',
			[
				'label' => esc_html__( 'Height', 'wpt-addon' ),
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
					'{{WRAPPER}} .wpt-accordion-header .wpt-accr-iocn-list .wpt-accr-icon svg' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        // Content Style
        $this->add_control(
			'wpt_accr_content_styel',
			[
				'label' => esc_html__( 'Content', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // Typography
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'wpt_accr_content_typography',
				'selector' => '{{WRAPPER}} .wpt-accordion-content p',
			]
		);

        $this->add_control(
			'wpt_accr_content_color',
			[
				'label' => esc_html__( 'Title Color', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpt-accordion-content p' => 'color: {{VALUE}}',
				],
			]
		);

        // Content Margin
        $this->add_responsive_control(
			'wpt_accr_content_mergin',
			[
				'label' => esc_html__( 'Margin Top', 'wpt-addon' ),
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
					'size' => -24,
				],
				'selectors' => [
					'{{WRAPPER}} .wpt-accordion-content' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

        // Content Padding
        $this->add_responsive_control(
			'wpt_accr_content_padding',
			[
				'label' => esc_html__( 'Padding', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 0,
					'right' => 16,
					'bottom' => 24,
					'left' => 80,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .wpt-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        // Image Style
        $this->add_control(
			'wpt_accr_image_styel',
			[
				'label' => esc_html__( 'Image', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // Image Width
        $this->add_responsive_control(
			'wpt_accr_image_width',
			[
				'label' => esc_html__( 'Width', 'wpt-addon' ),
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
					'size' => 350,
				],
				'selectors' => [
					'{{WRAPPER}} .wpt-accordion-content .wpt-accr-img img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        // Image Rotation
        $this->add_responsive_control(
			'wpt_accr_image_rotate',
			[
				'label' => esc_html__( 'Rotation', 'wpt-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '-6.694', 'wpt-addon' ),
				'placeholder' => esc_html__( 'rotate(-45deg)', 'wpt-addon' ),
			]
		);

        // Image Position Top
        $this->add_responsive_control(
			'wpt_accr_image_top_position',
			[
				'label' => esc_html__( 'Position Top', 'wpt-addon' ),
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
					'size' => -80,
				],
				'selectors' => [
					'{{WRAPPER}} .wpt-accordion-content .wpt-accr-img img' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

        // Image Position
        $this->add_responsive_control(
			'wpt_accr_image_right_position',
			[
				'label' => esc_html__( 'Position Right', 'wpt-addon' ),
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
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .wpt-accordion-content .wpt-accr-img img' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
            <div class="wpt-accordion">
                <?php if($settings[ 'wpt_accr_list' ]) : ?>
                    <?php foreach( $settings[ 'wpt_accr_list' ] as $item ) : ?>
                        <div class="wpt-accordion-item">
                            <div class="wpt-accordion-header active">
                                <div class="wpt-accr-iocn-list">
                                    <div class="wpt-accr-icon">
                                        <?php \Elementor\Icons_Manager::render_icon( $item['wpt_accr_list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </div>
                                    <div class="wpt-accr-icon-title">
                                        <h3><?php echo $item[ 'wpt_accr_list_title' ] ?></h3>
                                    </div>
                                </div>
                                <span class="wpt-accordion-toggle">+</span>
                            </div>
                            <div class="wpt-accordion-content" style="display: none;">
                                <div class="wpt-content-wrap">
                                    <div class="wpt-accr-desc">
                                        <?php echo $item[ 'wpt_accr_list_content' ]; ?>
                                    </div>
                                    <div class="wpt-accr-img">
                                        <img src="<?php echo esc_url( $item[ 'wpt_accr_image' ][ 'url' ] ); ?>" alt="" style="transform: rotate(<?php echo $settings[ 'wpt_accr_image_rotate' ]; ?>deg)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Wpt_Accordion() );