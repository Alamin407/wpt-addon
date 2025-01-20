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
				'label' => esc_html__( 'Icon', 'textdomain' ),
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
				'label' => esc_html__( 'Title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'textdomain' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'wpt_accr_list_content',
			[
				'label' => esc_html__( 'Content', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'List Content' , 'textdomain' ),
				'show_label' => false,
			]
		);

        $repeater->add_control(
			'wpt_accr_image',
			[
				'label' => esc_html__( 'Choose Image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
			'wpt_accr_list',
			[
				'label' => esc_html__( 'Accordion List', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'wpt_accr_list_title' => esc_html__( 'Title #1', 'textdomain' ),
						'wpt_accr_list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'textdomain' ),
					],
					[
						'wpt_accr_list_title' => esc_html__( 'Title #2', 'textdomain' ),
						'wpt_accr_list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'textdomain' ),
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
                                        <img src="<?php echo esc_url( $item[ 'wpt_accr_image' ][ 'url' ] ); ?>" alt="">
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