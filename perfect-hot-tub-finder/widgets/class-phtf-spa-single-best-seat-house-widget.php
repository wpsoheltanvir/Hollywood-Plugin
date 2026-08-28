<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

class PHTF_Spa_Single_Best_Seat_House_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'phtf_spa_single_best_seat_house'; }
	public function get_title() { return esc_html__( 'Spa Single Best Seat House', 'perfect-hot-tub-finder' ); }
	public function get_icon() { return 'eicon-slider-push'; }
	public function get_categories() { return [ 'phtf-widgets' ]; }
	public function get_keywords() { return [ 'spa', 'seat', 'massage', 'slider', 'single', 'best seat' ]; }
	public function get_style_depends() { return [ 'phtf-hot-tub-finder' ]; }
	public function get_script_depends() { return [ 'phtf-hot-tub-finder' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'section_header', [ 'label' => esc_html__( 'Header', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'title', [ 'label' => esc_html__( 'Title', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Best Seat in the House.', 'perfect-hot-tub-finder' ), 'label_block' => true ] );
		$this->add_control( 'title_tag', [ 'label' => esc_html__( 'HTML Tag', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SELECT, 'default' => 'h2', 'options' => [ 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'div' => 'DIV' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_slides', [ 'label' => esc_html__( 'Seat Slides', 'perfect-hot-tub-finder' ) ] );
		$repeater = new Repeater();
		$repeater->add_control( 'spa_image', [ 'label' => esc_html__( 'Spa Image', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => Utils::get_placeholder_image_src() ] ] );
		$repeater->add_control( 'spa_alt', [ 'label' => esc_html__( 'Spa Image Alt', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Spa seat view', 'perfect-hot-tub-finder' ) ] );
		$repeater->add_control( 'seat_overlay', [ 'label' => esc_html__( 'Highlighted Seat Overlay (PNG/SVG)', 'perfect-hot-tub-finder' ), 'description' => esc_html__( 'Upload a transparent image sized to match the spa image.', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::MEDIA ] );
		$repeater->add_control( 'body_image', [ 'label' => esc_html__( 'Body / Jet Diagram', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::MEDIA ] );
		$repeater->add_control( 'body_alt', [ 'label' => esc_html__( 'Body Diagram Alt Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Massage areas highlighted on the body', 'perfect-hot-tub-finder' ) ] );
		$repeater->add_control( 'seat_title', [ 'label' => esc_html__( 'Seat Title', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'ULTRAMASSAGE® LOUNGE', 'label_block' => true ] );
		$repeater->add_control( 'description', [ 'label' => esc_html__( 'Description', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 6, 'default' => esc_html__( 'Neck, shoulder, full back, calf and foot jets soothe and delight, with a customizable massage system that offers multiple jet sequences and speeds.', 'perfect-hot-tub-finder' ) ] );
		$repeater->add_control( 'video_text', [ 'label' => esc_html__( 'Video Link Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Watch Video', 'perfect-hot-tub-finder' ) ] );
		$repeater->add_control( 'video_url', [ 'label' => esc_html__( 'Video Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL, 'placeholder' => 'https://example.com/video' ] );
		$this->add_control( 'slides', [
			'label' => esc_html__( 'Slides', 'perfect-hot-tub-finder' ),
			'type' => Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(),
			'title_field' => '{{{ seat_title }}}',
			'default' => [
				[ 'seat_title' => 'ULTRAMASSAGE® LOUNGE' ],
				[ 'seat_title' => 'ECSTA SEAT' ],
				[ 'seat_title' => 'FOOT RIDGE®' ],
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_slider', [ 'label' => esc_html__( 'Slider Settings', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'show_arrows', [ 'label' => esc_html__( 'Show Arrows', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
		$this->add_control( 'show_dots', [ 'label' => esc_html__( 'Show Dots', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
		$this->add_control( 'autoplay', [ 'label' => esc_html__( 'Autoplay', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ] );
		$this->add_control( 'autoplay_speed', [ 'label' => esc_html__( 'Autoplay Speed (ms)', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::NUMBER, 'min' => 1500, 'max' => 15000, 'step' => 500, 'default' => 5000, 'condition' => [ 'autoplay' => 'yes' ] ] );
		$this->end_controls_section();

		$this->register_style_controls();
	}

	private function register_style_controls() {
		$this->start_controls_section( 'section_style_layout', [ 'label' => esc_html__( 'Layout & Branding', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'background_color', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_white' ], 'default' => '#FFFFFF', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'brand_accent_color', [ 'label' => esc_html__( 'Accent Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=secondary' ], 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => '--phtf-best-seat-accent: {{VALUE}} !important;' ] ] );
		$this->add_control( 'heading_color', [ 'label' => esc_html__( 'Heading Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => '--phtf-best-seat-heading: {{VALUE}};' ] ] );
		$this->add_control( 'text_color', [ 'label' => esc_html__( 'Body Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=text' ], 'default' => '#7A7A7A', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => '--phtf-best-seat-text: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'content_width', [ 'label' => esc_html__( 'Maximum Content Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', '%' ], 'range' => [ 'px' => [ 'min' => 700, 'max' => 1600 ], '%' => [ 'min' => 60, 'max' => 100 ] ], 'default' => [ 'size' => 1080, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__inner' => 'max-width: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'section_padding', [ 'label' => esc_html__( 'Section Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em', '%' ], 'default' => [ 'top' => 66, 'right' => 64, 'bottom' => 34, 'left' => 64, 'unit' => 'px', 'isLinked' => false ], 'tablet_default' => [ 'top' => 52, 'right' => 48, 'bottom' => 38, 'left' => 48, 'unit' => 'px', 'isLinked' => false ], 'mobile_default' => [ 'top' => 38, 'right' => 34, 'bottom' => 32, 'left' => 34, 'unit' => 'px', 'isLinked' => false ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'image_column_width', [ 'label' => esc_html__( 'Spa Image Column Width', 'perfect-hot-tub-finder' ), 'description' => esc_html__( 'Desktop and tablet only; mobile always stacks.', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ '%' ], 'range' => [ '%' => [ 'min' => 35, 'max' => 65 ] ], 'default' => [ 'size' => 52, 'unit' => '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => '--phtf-best-seat-image-column: {{SIZE}}%;' ] ] );
		$this->add_responsive_control( 'column_gap', [ 'label' => esc_html__( 'Image / Content Gap', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'em' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 120 ], 'em' => [ 'min' => 0, 'max' => 8, 'step' => .1 ] ], 'default' => [ 'size' => 48, 'unit' => 'px' ], 'tablet_default' => [ 'size' => 32, 'unit' => 'px' ], 'mobile_default' => [ 'size' => 28, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__slide' => 'gap: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'slide_min_height', [ 'label' => esc_html__( 'Slide Minimum Height', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 700 ] ], 'default' => [ 'size' => 350, 'unit' => 'px' ], 'tablet_default' => [ 'size' => 340, 'unit' => 'px' ], 'mobile_default' => [ 'size' => 0, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__slide' => 'min-height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'vertical_alignment', [ 'label' => esc_html__( 'Vertical Alignment', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::CHOOSE, 'options' => [ 'start' => [ 'title' => esc_html__( 'Top', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-v-align-top' ], 'center' => [ 'title' => esc_html__( 'Middle', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-v-align-middle' ], 'end' => [ 'title' => esc_html__( 'Bottom', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-v-align-bottom' ] ], 'default' => 'center', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__slide' => 'align-items: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'container_radius', [ 'label' => esc_html__( 'Container Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'container_border', 'selector' => '{{WRAPPER}} .phtf-best-seat' ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'container_shadow', 'selector' => '{{WRAPPER}} .phtf-best-seat' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_title', [ 'label' => esc_html__( 'Section Title', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'title_color', [ 'label' => esc_html__( 'Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=secondary' ], 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__title' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .phtf-best-seat__title' ] );
		$this->add_responsive_control( 'title_alignment', [ 'label' => esc_html__( 'Alignment', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::CHOOSE, 'options' => [ 'left' => [ 'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-left' ], 'center' => [ 'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-center' ], 'right' => [ 'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-right' ] ], 'default' => 'center', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__title' => 'text-align: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'title_margin', [ 'label' => esc_html__( 'Margin', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em', '%' ], 'default' => [ 'top' => 0, 'right' => 0, 'bottom' => 32, 'left' => 0, 'unit' => 'px', 'isLinked' => false ], 'tablet_default' => [ 'top' => 0, 'right' => 0, 'bottom' => 30, 'left' => 0, 'unit' => 'px', 'isLinked' => false ], 'mobile_default' => [ 'top' => 0, 'right' => 0, 'bottom' => 26, 'left' => 0, 'unit' => 'px', 'isLinked' => false ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_spa_image', [ 'label' => esc_html__( 'Spa Image & Overlay', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_responsive_control( 'spa_image_width', [ 'label' => esc_html__( 'Image Area Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ '%' => [ 'min' => 30, 'max' => 100 ] ], 'size_units' => [ '%' ], 'default' => [ 'size' => 100, 'unit' => '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__visual' => 'width: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'spa_image_max_width', [ 'label' => esc_html__( 'Maximum Image Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', '%' ], 'range' => [ 'px' => [ 'min' => 200, 'max' => 800 ], '%' => [ 'min' => 40, 'max' => 100 ] ], 'default' => [ 'size' => 470, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__visual' => 'max-width: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'spa_image_height', [ 'label' => esc_html__( 'Image Height', 'perfect-hot-tub-finder' ), 'description' => esc_html__( 'Leave empty to keep the natural image ratio.', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 180, 'max' => 650 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__spa-image' => 'height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'spa_image_fit', [ 'label' => esc_html__( 'Image Fit', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SELECT, 'default' => 'contain', 'options' => [ 'contain' => esc_html__( 'Contain', 'perfect-hot-tub-finder' ), 'cover' => esc_html__( 'Cover', 'perfect-hot-tub-finder' ), 'fill' => esc_html__( 'Fill', 'perfect-hot-tub-finder' ) ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__spa-image, {{WRAPPER}} .phtf-best-seat__overlay' => 'object-fit: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'spa_image_radius', [ 'label' => esc_html__( 'Image Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__visual, {{WRAPPER}} .phtf-best-seat__spa-image, {{WRAPPER}} .phtf-best-seat__overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'overlay_opacity', [ 'label' => esc_html__( 'Seat Overlay Opacity', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => .05 ] ], 'default' => [ 'size' => 1 ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__overlay' => 'opacity: {{SIZE}};' ] ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'spa_image_shadow', 'selector' => '{{WRAPPER}} .phtf-best-seat__visual' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_body_diagram', [ 'label' => esc_html__( 'Body / Jet Diagram', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_responsive_control( 'body_image_width', [ 'label' => esc_html__( 'Diagram Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 30, 'max' => 220 ] ], 'default' => [ 'size' => 76, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__body-image' => 'width: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'body_image_max_height', [ 'label' => esc_html__( 'Maximum Height', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 50, 'max' => 300 ] ], 'default' => [ 'size' => 165, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__body-image' => 'max-height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'body_image_alignment', [ 'label' => esc_html__( 'Alignment', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::CHOOSE, 'options' => [ '0 auto 0 0' => [ 'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-h-align-left' ], '0 auto' => [ 'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-h-align-center' ], '0 0 0 auto' => [ 'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-h-align-right' ] ], 'default' => '0 auto 0 0', 'mobile_default' => '0 auto', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__body-image' => 'margin: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'body_image_spacing', [ 'label' => esc_html__( 'Bottom Spacing', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'em' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ], 'em' => [ 'min' => 0, 'max' => 5, 'step' => .1 ] ], 'default' => [ 'size' => 18, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__body-image' => 'margin-bottom: {{SIZE}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_content', [ 'label' => esc_html__( 'Slide Text', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_responsive_control( 'content_max_width', [ 'label' => esc_html__( 'Content Maximum Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', '%' ], 'range' => [ 'px' => [ 'min' => 220, 'max' => 700 ], '%' => [ 'min' => 40, 'max' => 100 ] ], 'default' => [ 'size' => 430, 'unit' => 'px' ], 'mobile_default' => [ 'size' => 100, 'unit' => '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__content' => 'max-width: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'content_alignment', [ 'label' => esc_html__( 'Text Alignment', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::CHOOSE, 'options' => [ 'left' => [ 'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-left' ], 'center' => [ 'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-center' ], 'right' => [ 'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-right' ] ], 'default' => 'left', 'mobile_default' => 'center', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__content' => 'text-align: {{VALUE}};' ] ] );
		$this->add_control( 'seat_title_color', [ 'label' => esc_html__( 'Seat Title Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__seat-title' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'seat_title_typography', 'label' => esc_html__( 'Seat Title Typography', 'perfect-hot-tub-finder' ), 'selector' => '{{WRAPPER}} .phtf-best-seat__seat-title' ] );
		$this->add_responsive_control( 'seat_title_margin', [ 'label' => esc_html__( 'Seat Title Margin', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em' ], 'default' => [ 'top' => 0, 'right' => 0, 'bottom' => 14, 'left' => 0, 'unit' => 'px', 'isLinked' => false ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__seat-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_control( 'description_color', [ 'label' => esc_html__( 'Description Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => '#7A7A7A', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__description' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'description_typography', 'label' => esc_html__( 'Description Typography', 'perfect-hot-tub-finder' ), 'selector' => '{{WRAPPER}} .phtf-best-seat__description' ] );
		$this->add_control( 'link_color', [ 'label' => esc_html__( 'Video Link Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__video' => 'color: {{VALUE}} !important;' ] ] );
		$this->add_control( 'link_hover_color', [ 'label' => esc_html__( 'Video Link Hover Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__video:hover, {{WRAPPER}} .phtf-best-seat__video:focus-visible' => 'color: {{VALUE}} !important;' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'link_typography', 'label' => esc_html__( 'Video Link Typography', 'perfect-hot-tub-finder' ), 'selector' => '{{WRAPPER}} .phtf-best-seat__video' ] );
		$this->add_responsive_control( 'link_top_spacing', [ 'label' => esc_html__( 'Video Link Top Spacing', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'em' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ], 'em' => [ 'min' => 0, 'max' => 5, 'step' => .1 ] ], 'default' => [ 'size' => 16, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__video' => 'margin-top: {{SIZE}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_arrows', [ 'label' => esc_html__( 'Slide Arrows', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE, 'condition' => [ 'show_arrows' => 'yes' ] ] );
		$this->add_responsive_control( 'arrow_icon_size', [ 'label' => esc_html__( 'Arrow Icon Size', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 20, 'max' => 90 ] ], 'default' => [ 'size' => 58, 'unit' => 'px' ], 'tablet_default' => [ 'size' => 52, 'unit' => 'px' ], 'mobile_default' => [ 'size' => 46, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow' => 'font-size: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'arrow_button_size', [ 'label' => esc_html__( 'Arrow Box Size', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 28, 'max' => 100 ] ], 'default' => [ 'size' => 48, 'unit' => 'px' ], 'tablet_default' => [ 'size' => 44, 'unit' => 'px' ], 'mobile_default' => [ 'size' => 38, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'arrow_padding', [ 'label' => esc_html__( 'Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'arrow_border_width', [ 'label' => esc_html__( 'Border Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px' ], 'default' => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px', 'isLinked' => true ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'arrow_radius', [ 'label' => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'default' => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px', 'isLinked' => true ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'arrow_vertical_position', [ 'label' => esc_html__( 'Vertical Position', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ '%' ], 'range' => [ '%' => [ 'min' => 10, 'max' => 90 ] ], 'default' => [ 'size' => 54, 'unit' => '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow' => 'top: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'arrow_side_offset', [ 'label' => esc_html__( 'Arrow / Content Gap', 'perfect-hot-tub-finder' ), 'description' => esc_html__( 'Negative values move arrows outside the content area.', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => -120, 'max' => 80 ] ], 'default' => [ 'size' => -58, 'unit' => 'px' ], 'tablet_default' => [ 'size' => -48, 'unit' => 'px' ], 'mobile_default' => [ 'size' => -28, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => '--phtf-best-seat-arrow-offset: {{SIZE}}{{UNIT}};' ] ] );
		$this->start_controls_tabs( 'arrow_style_tabs' );
		$this->start_controls_tab( 'arrow_normal_tab', [ 'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'arrow_color', [ 'label' => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow' => 'color: {{VALUE}} !important;' ] ] );
		$this->add_control( 'arrow_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => 'rgba(255,255,255,0)', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow' => 'background-color: {{VALUE}} !important;' ] ] );
		$this->add_control( 'arrow_border_color', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => 'rgba(255,255,255,0)', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow' => 'border-color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'arrow_shadow', 'selector' => '{{WRAPPER}} .phtf-best-seat__arrow' ] );
		$this->end_controls_tab();
		$this->start_controls_tab( 'arrow_hover_tab', [ 'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'arrow_hover_color', [ 'label' => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow:hover, {{WRAPPER}} .phtf-best-seat__arrow:focus-visible' => 'color: {{VALUE}} !important;' ] ] );
		$this->add_control( 'arrow_hover_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => 'rgba(255,255,255,0)', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow:hover, {{WRAPPER}} .phtf-best-seat__arrow:focus-visible' => 'background-color: {{VALUE}} !important;' ] ] );
		$this->add_control( 'arrow_hover_border_color', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => 'rgba(255,255,255,0)', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow:hover, {{WRAPPER}} .phtf-best-seat__arrow:focus-visible' => 'border-color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'arrow_hover_shadow', 'selector' => '{{WRAPPER}} .phtf-best-seat__arrow:hover, {{WRAPPER}} .phtf-best-seat__arrow:focus-visible' ] );
		$this->end_controls_tab();
		$this->start_controls_tab( 'arrow_active_tab', [ 'label' => esc_html__( 'Active', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'arrow_active_color', [ 'label' => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow:active' => 'color: {{VALUE}} !important;' ] ] );
		$this->add_control( 'arrow_active_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => 'rgba(255,255,255,0)', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow:active' => 'background-color: {{VALUE}} !important;' ] ] );
		$this->add_control( 'arrow_active_border_color', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => 'rgba(255,255,255,0)', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow:active' => 'border-color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'arrow_active_shadow', 'selector' => '{{WRAPPER}} .phtf-best-seat__arrow:active' ] );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control( 'arrow_disabled_opacity', [ 'label' => esc_html__( 'Disabled Opacity', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => .01 ] ], 'default' => [ 'size' => .35 ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__arrow:disabled' => 'opacity: {{SIZE}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_dots', [ 'label' => esc_html__( 'Pagination Dots', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE, 'condition' => [ 'show_dots' => 'yes' ] ] );
		$this->add_control( 'dot_color', [ 'label' => esc_html__( 'Dot Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => '#D8D6D2', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__dot' => 'background-color: {{VALUE}} !important;' ] ] );
		$this->add_control( 'dot_active_color', [ 'label' => esc_html__( 'Active Dot Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => '#9E9A94', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__dot.is-active' => 'background-color: {{VALUE}} !important;' ] ] );
		$this->add_responsive_control( 'dot_size', [ 'label' => esc_html__( 'Dot Size', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 6, 'max' => 30 ] ], 'default' => [ 'size' => 10, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__dot' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'dot_gap', [ 'label' => esc_html__( 'Gap', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ], 'default' => [ 'size' => 20, 'unit' => 'px' ], 'mobile_default' => [ 'size' => 14, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__dots' => 'gap: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'dots_top_spacing', [ 'label' => esc_html__( 'Top Spacing', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'em' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ], 'em' => [ 'min' => 0, 'max' => 6, 'step' => .1 ] ], 'default' => [ 'size' => 18, 'unit' => 'px' ], 'mobile_default' => [ 'size' => 26, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__dots' => 'margin-top: {{SIZE}}{{UNIT}};' ] ] );
		$this->end_controls_section();
	}

	private function link_attributes( $link ) {
		if ( empty( $link['url'] ) ) { return ''; }
		$attrs = 'href="' . esc_url( $link['url'] ) . '"';
		$rel = [];
		if ( ! empty( $link['is_external'] ) ) { $attrs .= ' target="_blank"'; $rel[] = 'noopener'; $rel[] = 'noreferrer'; }
		if ( ! empty( $link['nofollow'] ) ) { $rel[] = 'nofollow'; }
		if ( $rel ) { $attrs .= ' rel="' . esc_attr( implode( ' ', array_unique( $rel ) ) ) . '"'; }
		return $attrs;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$slides = array_values( array_filter( $settings['slides'] ?? [], 'is_array' ) );
		if ( empty( $slides ) ) { return; }
		$tag = in_array( $settings['title_tag'] ?? 'h2', [ 'h1', 'h2', 'h3', 'h4', 'div' ], true ) ? $settings['title_tag'] : 'h2';
		?>
		<section class="phtf-best-seat" data-phtf-best-seat data-autoplay="<?php echo 'yes' === ( $settings['autoplay'] ?? '' ) ? 'yes' : 'no'; ?>" data-autoplay-speed="<?php echo esc_attr( absint( $settings['autoplay_speed'] ?? 5000 ) ); ?>">
			<div class="phtf-best-seat__inner">
				<?php if ( ! empty( $settings['title'] ) ) : ?><<?php echo esc_attr( $tag ); ?> class="phtf-best-seat__title"><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $tag ); ?>><?php endif; ?>
				<div class="phtf-best-seat__viewport" aria-live="polite">
					<?php foreach ( $slides as $index => $slide ) : ?>
						<article class="phtf-best-seat__slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-phtf-best-seat-slide="<?php echo esc_attr( $index ); ?>"<?php echo 0 === $index ? '' : ' hidden'; ?>>
							<div class="phtf-best-seat__visual">
								<img class="phtf-best-seat__spa-image" src="<?php echo esc_url( phtf_image_url_or_fallback( $slide['spa_image']['url'] ?? '', 'widget' ) ); ?>" alt="<?php echo esc_attr( $slide['spa_alt'] ?? '' ); ?>">
								<?php if ( ! empty( $slide['seat_overlay']['url'] ) ) : ?><img class="phtf-best-seat__overlay" src="<?php echo esc_url( $slide['seat_overlay']['url'] ); ?>" alt=""><?php endif; ?>
							</div>
							<div class="phtf-best-seat__content">
								<?php if ( ! empty( $slide['body_image']['url'] ) ) : ?><img class="phtf-best-seat__body-image" src="<?php echo esc_url( $slide['body_image']['url'] ); ?>" alt="<?php echo esc_attr( $slide['body_alt'] ?? '' ); ?>"><?php endif; ?>
								<?php if ( ! empty( $slide['seat_title'] ) ) : ?><h3 class="phtf-best-seat__seat-title"><?php echo esc_html( $slide['seat_title'] ); ?></h3><?php endif; ?>
								<?php if ( ! empty( $slide['description'] ) ) : ?><div class="phtf-best-seat__description"><?php echo wp_kses_post( wpautop( $slide['description'] ) ); ?></div><?php endif; ?>
								<?php if ( ! empty( $slide['video_text'] ) && ! empty( $slide['video_url']['url'] ) ) : ?><a class="phtf-best-seat__video" <?php echo $this->link_attributes( $slide['video_url'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $slide['video_text'] ); ?></a><?php endif; ?>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
				<?php if ( count( $slides ) > 1 && 'yes' === ( $settings['show_arrows'] ?? 'yes' ) ) : ?>
					<button class="phtf-best-seat__arrow phtf-best-seat__arrow--prev" type="button" data-phtf-best-seat-prev aria-label="<?php esc_attr_e( 'Previous seat', 'perfect-hot-tub-finder' ); ?>">‹</button>
					<button class="phtf-best-seat__arrow phtf-best-seat__arrow--next" type="button" data-phtf-best-seat-next aria-label="<?php esc_attr_e( 'Next seat', 'perfect-hot-tub-finder' ); ?>">›</button>
				<?php endif; ?>
				<?php if ( count( $slides ) > 1 && 'yes' === ( $settings['show_dots'] ?? 'yes' ) ) : ?>
					<div class="phtf-best-seat__dots" role="tablist" aria-label="<?php esc_attr_e( 'Seat slides', 'perfect-hot-tub-finder' ); ?>">
						<?php foreach ( $slides as $index => $slide ) : ?><button type="button" class="phtf-best-seat__dot<?php echo 0 === $index ? ' is-active' : ''; ?>" data-phtf-best-seat-dot="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Show slide %d', 'perfect-hot-tub-finder' ), $index + 1 ) ); ?>" aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>"></button><?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
