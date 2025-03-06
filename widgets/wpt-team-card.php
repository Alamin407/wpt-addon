<?php
namespace Elementor;
use WP_Query;

class Wpt_Team_Card extends Widget_Base {

    public function get_name() {
        return 'wpt-team-card-id';
    }

    public function get_title() {
        return esc_html__( 'Team Card', 'wpt-addon' );
    }

    public function get_script_depends() {
        return [
            'wpt-category-js' // Enqueue the JS file for category functionality
        ];
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return ['wpt-for-elementor'];
    }

    public function register_controls() {
        $this->start_controls_section(
            'wpt_speak_content_section',
            [
                'label' => esc_html__( 'Team', 'wpt-addon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'wpt_speak_post_per_page',
			[
				'label' => esc_html__( 'Post Per Page', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Default title', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your title here', 'textdomain' ),
			]
		);

        // Pagination
        $this->add_control(
			'show_wpt_speak_pagination',
			[
				'label' => esc_html__( 'Show Pagination', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'textdomain' ),
				'label_off' => esc_html__( 'Hide', 'textdomain' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        // Responsive Grid Columns Control.
        $this->add_responsive_control(
            'grid_columns',
            [
                'label'   => __( 'Grid Columns', 'text-domain' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '1' => __( '1 Column', 'text-domain' ),
                    '2' => __( '2 Columns', 'text-domain' ),
                    '3' => __( '3 Columns', 'text-domain' ),
                    '4' => __( '4 Columns', 'text-domain' ),
                    '5' => __( '5 Columns', 'text-domain' ),
                    '6' => __( '6 Columns', 'text-domain' ),
                ],
            ]
        );

        // Responsive Grid Gap Control.
        $this->add_responsive_control(
            'grid_gap',
            [
                'label' => __( 'Grid Gap', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
            ]
        );

        $this->end_controls_section();

        // Style section
        $this->style_tab();
    }

    private function style_tab(){
        $this->start_controls_section(
            'wpt_speak_grid_section',
            [
                'label' => esc_html__( 'Team Style', 'wpt-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
			'wpt_speak_grid_image_height',
			[
				'label' => esc_html__( 'Image Height', 'textdomain' ),
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
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}} .speaker-item .speaker-img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        // Heading
        $this->add_control(
			'wpt_speak_grid_title',
			[
				'label' => esc_html__( 'Title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // Typography
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'wpt_speak_grid_title_typography',
				'selector' => '{{WRAPPER}} .speaker-item h3',
			]
		);

        // Color
        $this->add_control(
			'wpt_speak_grid_title_color',
			[
				'label' => esc_html__( 'Title Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .speaker-item h3' => 'color: {{VALUE}}',
				],
			]
		);

        // Heading
        $this->add_control(
			'wpt_speak_grid_overlay',
			[
				'label' => esc_html__( 'Overlay Style', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // Overlay Color
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'wpt_speak_grid_overlay_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .speaker-item .speak-read-overlay',
			]
		);

        // Overlay Title
        $this->add_control(
			'wpt_speak_grid_ove_title',
			[
				'label' => esc_html__( 'Overlay Title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // Typography
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'wpt_speak_grid_ove_title_typography',
				'selector' => '{{WRAPPER}} .speaker-item .speak-read-overlay h4',
			]
		);

        // Color
        $this->add_control(
			'wpt_speak_grid_ove_title_color',
			[
				'label' => esc_html__( 'Title Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .speaker-item .speak-read-overlay h4' => 'color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'wpt_speak_popup_section',
            [
                'label' => esc_html__( 'Popup Style', 'wpt-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Popup Title
        $this->add_control(
			'wpt_speak_popup_wrap',
			[
				'label' => esc_html__( 'Wrapper', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // Width
        $this->add_responsive_control(
			'wpt_speak_popup_wrap_width',
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
					'unit' => '%',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-content' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        // Padding
        $this->add_control(
			'wpt_speak_popup_wrap_padding',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 45,
					'right' => 45,
					'bottom' => 45,
					'left' => 45,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .popup-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        // Border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'wpt_speak_popup_wrap_border',
				'selector' => '{{WRAPPER}} .popup-content',
			]
        );

        // Popup Title
        $this->add_control(
			'wpt_speak_popup_title',
			[
				'label' => esc_html__( 'Title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // Typography
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'wpt_speak_popup_title_typography',
				'selector' => '{{WRAPPER}} .speaker-detail .wpt-head h2',
			]
		);

        // Color
        $this->add_control(
			'wpt_speak_popup_title_color',
			[
				'label' => esc_html__( 'Title Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .speaker-detail .wpt-head h2' => 'color: {{VALUE}}',
				],
			]
		);

        // Popup Title Devider
        $this->add_control(
			'wpt_speak_popup_devider',
			[
				'label' => esc_html__( 'Devider', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // Devider Background
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'wpt_speak_popup_devider_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .speaker-detail .wpt-head h2::before',
			]
		);

        // Devider Width
        $this->add_responsive_control(
			'wpt_speak_popup_devider_width',
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
					'unit' => '%',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .speaker-detail .wpt-head h2::before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        // Devider Height
        $this->add_responsive_control(
			'wpt_speak_popup_devider_height',
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
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .speaker-detail .wpt-head h2::before' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        // Margin
        $this->add_responsive_control(
			'wpt_speak_popup_devider_margin',
			[
				'label' => esc_html__( 'Margin', 'textdomain' ),
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
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .speaker-detail .wpt-head' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Get the current page number from 'paged' or 'page' query variables.
        $paged = max( 1, get_query_var('paged'), get_query_var('page') );

        // Query for speaker posts.
        $args  = [
            'post_type'      => 'speaker',
            'posts_per_page' => $settings[ 'wpt_speak_post_per_page' ],
            'paged' => $paged,
        ];
        $query = new WP_Query( $args );

        // Retrieve responsive grid columns settings.
        $columns_desktop = $settings['grid_columns'];
        $columns_tablet  = isset( $settings['grid_columns_tablet'] ) && ! empty( $settings['grid_columns_tablet'] ) ? $settings['grid_columns_tablet'] : $columns_desktop;
        $columns_mobile  = isset( $settings['grid_columns_mobile'] ) && ! empty( $settings['grid_columns_mobile'] ) ? $settings['grid_columns_mobile'] : $columns_desktop;

        // Retrieve responsive grid gap settings.
        $gap_desktop = isset( $settings['grid_gap']['size'] ) ? $settings['grid_gap']['size'] . $settings['grid_gap']['unit'] : '20px';
        $gap_tablet  = isset( $settings['grid_gap_tablet']['size'] ) ? $settings['grid_gap_tablet']['size'] . $settings['grid_gap_tablet']['unit'] : $gap_desktop;
        $gap_mobile  = isset( $settings['grid_gap_mobile']['size'] ) ? $settings['grid_gap_mobile']['size'] . $settings['grid_gap_mobile']['unit'] : $gap_desktop;

        ?>
            <style>
                /* Tablet settings */
                @media (max-width: 1024px) {
                    #speaker-grid {
                        --grid-columns-tablet: <?php echo esc_attr( $columns_tablet ); ?>;
                        --grid-gap-tablet: <?php echo esc_attr( $gap_tablet ); ?>;
                    }
                }
                /* Mobile settings */
                @media (max-width: 768px) {
                    #speaker-grid {
                        --grid-columns-mobile: <?php echo esc_attr( $columns_mobile ); ?>;
                        --grid-gap-mobile: <?php echo esc_attr( $gap_mobile ); ?>;
                    }
                }
            </style>
            <?php if($query->have_posts()) : ?>
                <div id="speaker-grid" class="speaker-grid" style="--grid-columns: <?php echo esc_attr( $columns_desktop ); ?>; --grid-gap: <?php echo esc_attr( $gap_desktop ); ?>;">
                    <?php while($query->have_posts() ) : 
                        $query->the_post();
                        $speaker_id    = get_the_ID();
                        $speaker_name  = get_field( 'speaker_name' );
                        $speaker_image = get_field( 'speaker_image' );
                    ?>
                        <div class="speaker-item" data-speaker-id="<?php echo esc_attr( $speaker_id ); ?>">
                            <?php if ( $speaker_image ) : ?>
                                <div class="speaker-img" style="background: url(<?php echo esc_url($speaker_image['url'] ); ?>)">
                                    <div class="speak-read-overlay">
                                        <h4>View Profile</h4>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <h3><?php echo esc_html( $speaker_name ); ?></h3>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php
                    // Pagination with custom icon HTML for previous and next buttons.
                    $big = 999999999; // an unlikely integer
                    $pagination = paginate_links( array(
                        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format'    => '?paged=%#%',
                        'current'   => $paged,
                        'total'     => $query->max_num_pages,
                        'type'      => 'list',
                        'prev_text' => '<i class="fa-solid fa-arrow-left"></i> <span>Previous</span>',
                        'next_text' => '<span>Next</span><i class="fa-solid fa-arrow-right"></i>',
                        'add_fragment'=> '#speaker-grid'
                    ) );
                    if( $settings['show_wpt_speak_pagination'] == 'yes' ){
                        if ( $pagination ) {
                            echo '<div class="speaker-pagination">' . $pagination . '</div>';
                        }
                    }
                    wp_reset_postdata(); 
                ?>
            <?php endif; ?>
            <div id="speaker-popup" style="display:none;">
                <div class="speak-popup-wrap">
                    <div class="popup-content">
                        <span class="close-popup"><i class="fa-solid fa-xmark"></i></span>
                        <div id="speaker-details"></div>
                    </div>
                </div>
            </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Wpt_Team_Card() );