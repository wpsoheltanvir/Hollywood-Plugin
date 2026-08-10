<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

class PHTF_Explore_Models_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'phtf_explore_models';
	}

	public function get_title() {
		return esc_html__( 'Hollywood Explore Our Models', 'perfect-hot-tub-finder' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'phtf-widgets' ];
	}

	public function get_keywords() {
		return [ 'hot tub', 'models', 'carousel', 'products', 'explore' ];
	}

	public function get_style_depends() {
		return [ 'phtf-hot-tub-finder' ];
	}

	public function get_script_depends() {
		return [ 'phtf-hot-tub-finder' ];
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	private function register_content_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'data_source',
			[
				'label'       => esc_html__( 'Data Source', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'finder',
				'options'     => [
					'finder' => esc_html__( 'Perfect Hot Tub Finder Source ID', 'perfect-hot-tub-finder' ),
					'cpt'    => esc_html__( 'Spa Models Custom Post Type', 'perfect-hot-tub-finder' ),
				],
				'label_block' => true,
				'description' => esc_html__( 'Choose Spa Models Custom Post Type to manage models from the WordPress dashboard.', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'product_source_key',
			[
				'label'       => esc_html__( 'Product Source ID', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'main',
				'label_block' => true,
				'description' => esc_html__( 'Must match the Product Source ID in the Perfect Hot Tub Finder widget on the same page.', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'        => esc_html__( 'Show Title', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Explore Our Models.', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'condition'   => [ 'show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'show_tabs',
			[
				'label'        => esc_html__( 'Show Tabs', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$tabs = new Repeater();
		$tabs->add_control(
			'label',
			[
				'label'       => esc_html__( 'Tab Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'All Models', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);
		$tabs->add_control(
			'value',
			[
				'label'       => esc_html__( 'Tab Value', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'all',
				'label_block' => true,
				'description' => esc_html__( 'Use “all” for all products. Other values match each product’s seating value or Explore Tab Categories.', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'tabs',
			[
				'label'       => esc_html__( 'Tabs', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $tabs->get_controls(),
				'title_field' => '{{{ label }}}',
				'condition'   => [ 'show_tabs' => 'yes' ],
				'default'     => [
					[ 'label' => esc_html__( 'All Models', 'perfect-hot-tub-finder' ), 'value' => 'all' ],
					[ 'label' => esc_html__( '2-3 Seats', 'perfect-hot-tub-finder' ), 'value' => '2-3' ],
					[ 'label' => esc_html__( '4-5 Seats', 'perfect-hot-tub-finder' ), 'value' => '4-5' ],
					[ 'label' => esc_html__( '6-8 Seats', 'perfect-hot-tub-finder' ), 'value' => '6-8' ],
					[ 'label' => esc_html__( 'Lounge', 'perfect-hot-tub-finder' ), 'value' => 'lounge' ],
					[ 'label' => esc_html__( 'Salt Water System', 'perfect-hot-tub-finder' ), 'value' => 'salt-water' ],
					[ 'label' => esc_html__( 'Cold Plunge', 'perfect-hot-tub-finder' ), 'value' => 'cold-plunge' ],
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Help Me Choose', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
			]
		);

		$this->add_control(
			'empty_message',
			[
				'label'   => esc_html__( 'Empty Message', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'No models found. Add products in the Perfect Hot Tub Finder widget using the same Product Source ID.', 'perfect-hot-tub-finder' ),
			]
		);

		$this->end_controls_section();
	}

	private function register_style_controls() {
		

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-explore-title' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .phtf-explore-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tabs_style',
			[
				'label' => esc_html__( 'Tabs', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tab_typography',
				'selector' => '{{WRAPPER}} .phtf-explore-tab',
			]
		);

		$this->add_responsive_control(
			'tab_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .phtf-explore-tabs' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_gap',
			[
				'label'      => esc_html__( 'Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore-tabs' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_style_states' );

		$this->start_controls_tab(
			'tab_style_normal',
			[
				'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'tab_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-explore-tab' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'tab_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'selectors' => [ '{{WRAPPER}} .phtf-explore-tab' => 'background-color: {{VALUE}};' ],
			]
		);


		$this->add_control(
			'tab_underline_color',
			[
				'label'     => esc_html__( 'Underline Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'selectors' => [ '{{WRAPPER}} .phtf-explore-tab::after' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_style_hover',
			[
				'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'tab_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-explore-tab:hover, {{WRAPPER}} .phtf-explore-tab:focus-visible' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'tab_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'selectors' => [ '{{WRAPPER}} .phtf-explore-tab:hover, {{WRAPPER}} .phtf-explore-tab:focus-visible' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'tab_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'selectors' => [ '{{WRAPPER}} .phtf-explore-tab:hover, {{WRAPPER}} .phtf-explore-tab:focus-visible' => 'border-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'tab_hover_underline_color',
			[
				'label'     => esc_html__( 'Underline Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'selectors' => [ '{{WRAPPER}} .phtf-explore-tab:hover::after, {{WRAPPER}} .phtf-explore-tab:focus-visible::after' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_style_active',
			[
				'label' => esc_html__( 'Active', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'tab_active_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-explore-tab.is-active' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'tab_active_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'selectors' => [ '{{WRAPPER}} .phtf-explore-tab.is-active' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'tab_active_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'selectors' => [ '{{WRAPPER}} .phtf-explore-tab.is-active' => 'border-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'tab_active_underline_color',
			[
				'label'     => esc_html__( 'Underline Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-explore-tab.is-active::after' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'tab_border',
				'selector' => '{{WRAPPER}} .phtf-explore-tab',
			]
		);

		$this->add_responsive_control(
			'tab_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_padding',
			[
				'label'      => esc_html__( 'Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tab_underline_heading',
			[
				'label'     => esc_html__( 'Underline', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'tab_underline_height',
			[
				'label'      => esc_html__( 'Underline Height', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
				'default'    => [ 'size' => 2, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore-tab::after' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_underline_offset',
			[
				'label'      => esc_html__( 'Underline Offset', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => -20, 'max' => 30 ] ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore-tab::after' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_underline_inset',
			[
				'label'      => esc_html__( 'Underline Inset', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 80 ],
					'%'  => [ 'min' => 0, 'max' => 45 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore-tab::after' => 'left: {{SIZE}}{{UNIT}}; right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tab_divider_heading',
			[
				'label'     => esc_html__( 'Divider', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tab_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'selectors' => [ '{{WRAPPER}} .phtf-explore-tab + .phtf-explore-tab' => 'border-left-color: {{VALUE}};' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_card_style',
			[
				'label' => esc_html__( 'Cards', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'card_width',
			[
				'label'      => esc_html__( 'Card Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 140, 'max' => 420 ] ],
				'default'    => [ 'size' => 220, 'unit' => 'px' ],
				'tablet_default' => [ 'size' => 210, 'unit' => 'px' ],
				'mobile_default' => [ 'size' => 240, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-explore-card' => 'flex-basis: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'cards_per_view',
			[
				'label'       => esc_html__( 'Cards Per View', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 6,
				'step'        => 1,
				'default'     => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'description' => esc_html__( 'Controls how many product cards are visible before the slider moves on desktop, tablet, and mobile.', 'perfect-hot-tub-finder' ),
				'selectors'   => [
					'{{WRAPPER}} .phtf-explore' => '--phtf-explore-per-page: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_gap',
			[
				'label'      => esc_html__( 'Card Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 100 ],
					'em'  => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ],
					'rem' => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 42, 'unit' => 'px' ],
				'tablet_default' => [ 'size' => 28, 'unit' => 'px' ],
				'mobile_default' => [ 'size' => 0, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore' => '--phtf-explore-card-gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .phtf-explore-track' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'card_typography',
				'selector' => '{{WRAPPER}} .phtf-explore-card',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_arrows_style',
			[
				'label' => esc_html__( 'Slider Arrows', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'explore_arrow_carousel_gap',
			[
				'label'      => esc_html__( 'Arrow / Cards Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 100 ],
					'em'  => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ],
					'rem' => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 26, 'unit' => 'px' ],
				'tablet_default' => [ 'size' => 14, 'unit' => 'px' ],
				'mobile_default' => [ 'size' => 8, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore-carousel' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'explore_arrow_icon_size',
			[
				'label'      => esc_html__( 'Arrow Icon Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 12, 'max' => 120 ],
					'em'  => [ 'min' => 0.5, 'max' => 8, 'step' => 0.1 ],
					'rem' => [ 'min' => 0.5, 'max' => 8, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 64, 'unit' => 'px' ],
				'mobile_default' => [ 'size' => 52, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'explore_arrow_box_size',
			[
				'label'      => esc_html__( 'Arrow Box Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 20, 'max' => 120 ],
					'em'  => [ 'min' => 1, 'max' => 8, 'step' => 0.1 ],
					'rem' => [ 'min' => 1, 'max' => 8, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 44, 'unit' => 'px' ],
				'mobile_default' => [ 'size' => 30, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'explore_arrow_padding',
			[
				'label'      => esc_html__( 'Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'explore_arrow_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore-arrow' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
				],
			]
		);

		$this->add_responsive_control(
			'explore_arrow_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-explore-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'explore_arrow_style_tabs' );

		$this->start_controls_tab(
			'explore_arrow_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'explore_arrow_normal_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-explore' => '--phtf-explore-arrow-normal: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'explore_arrow_normal_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => 'rgba(255,255,255,0)',
				'selectors' => [ '{{WRAPPER}} .phtf-explore' => '--phtf-explore-arrow-bg-normal: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'explore_arrow_normal_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'default'   => 'rgba(255,255,255,0)',
				'selectors' => [ '{{WRAPPER}} .phtf-explore' => '--phtf-explore-arrow-border-normal: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'explore_arrow_normal_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-explore-arrow',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'explore_arrow_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'explore_arrow_hover_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-explore' => '--phtf-explore-arrow-hover: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'explore_arrow_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'selectors' => [ '{{WRAPPER}} .phtf-explore' => '--phtf-explore-arrow-bg-hover: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'explore_arrow_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'selectors' => [ '{{WRAPPER}} .phtf-explore' => '--phtf-explore-arrow-border-hover: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'explore_arrow_hover_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-explore-arrow:hover, {{WRAPPER}} .phtf-explore-arrow:focus-visible',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'explore_arrow_tab_active',
			[
				'label' => esc_html__( 'Active', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'explore_arrow_active_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-explore' => '--phtf-explore-arrow-active: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'explore_arrow_active_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'selectors' => [ '{{WRAPPER}} .phtf-explore' => '--phtf-explore-arrow-bg-active: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'explore_arrow_active_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'selectors' => [ '{{WRAPPER}} .phtf-explore' => '--phtf-explore-arrow-border-active: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'explore_arrow_active_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-explore-arrow:active, {{WRAPPER}} .phtf-explore-arrow.is-active',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'explore_arrow_disabled_opacity',
			[
				'label'      => esc_html__( 'Disabled Opacity', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0.05, 'max' => 1, 'step' => 0.05 ] ],
				'default'    => [ 'size' => 0.28 ],
				'selectors'  => [ '{{WRAPPER}} .phtf-explore-arrow[disabled]' => 'opacity: {{SIZE}};' ],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price_footnote_style',
			[
				'label' => esc_html__( 'Price Text & Footnotes', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'explore_price_text_color',
			[
				'label'     => esc_html__( 'MSRP Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [ '{{WRAPPER}} .phtf-explore-meta' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'explore_footnote_color',
			[
				'label'     => esc_html__( 'Footnote 1 / 2 Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-explore-meta .phtf-price-note-trigger, {{WRAPPER}} .phtf-explore-meta .phtf-price-note-trigger sup' => 'color: {{VALUE}} !important;' ],
			]
		);

		$this->add_responsive_control(
			'explore_footnote_size',
			[
				'label'      => esc_html__( 'Footnote 1 / 2 Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'em' ],
				'range'      => [ 'em' => [ 'min' => 0.4, 'max' => 2, 'step' => 0.01 ] ],
				'default'    => [ 'size' => 1.18, 'unit' => 'em' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-explore-meta .phtf-price-note-trigger sup' => 'font-size: {{SIZE}}{{UNIT}} !important;' ],
			]
		);

		$this->add_responsive_control(
			'explore_footnote_top_offset',
			[
				'label'      => esc_html__( 'Footnote 1 / 2 Top Offset', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'em' ],
				'range'      => [ 'em' => [ 'min' => -1, 'max' => 1, 'step' => 0.01 ] ],
				'default'    => [ 'size' => 0.35, 'unit' => 'em' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-explore-meta .phtf-price-note-trigger sup' => 'position: relative; top: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'explore_price_popup_width',
			[
				'label'      => esc_html__( 'Popup Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 280, 'max' => 760 ] ],
				'default'    => [ 'size' => 540, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-explore' => '--phtf-price-popup-width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'explore_price_popup_max_height',
			[
				'label'      => esc_html__( 'Popup Max Height', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 180, 'max' => 900 ] ],
				'default'    => [ 'size' => 520, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-explore' => '--phtf-price-popup-max-height: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [ '{{WRAPPER}} .phtf-explore-button' => 'color: {{VALUE}} !important;' ],
			]
		);

		$this->add_control(
			'button_background',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-explore-button' => 'background: {{VALUE}}; border-color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .phtf-explore-button',
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-explore-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .phtf-explore-button',
			]
		);

		$this->end_controls_section();
	}

	private function render_link_attrs( $link ) {
		if ( empty( $link['url'] ) ) {
			return 'href="#"';
		}

		$attrs = 'href="' . esc_url( $link['url'] ) . '"';

		if ( ! empty( $link['is_external'] ) ) {
			$attrs .= ' target="_blank"';
		}

		if ( ! empty( $link['nofollow'] ) ) {
			$attrs .= ' rel="nofollow"';
		}

		return $attrs;
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$source_key = sanitize_key( $settings['product_source_key'] ?? 'main' );
		if ( '' === $source_key ) {
			$source_key = 'main';
		}

		$cpt_products = [];
		if ( 'cpt' === ( $settings['data_source'] ?? 'finder' ) && function_exists( 'phtf_get_spa_models' ) ) {
			foreach ( phtf_get_spa_models() as $model ) {
				$cpt_products[] = [
					'brand'                => $model['title'] ?? '',
					'series'               => $model['series_display'] ?? '',
					'rating'               => $model['rating'] ?? 0,
					'reviews'              => ! empty( $model['reviews'] ) ? $model['reviews'] . ' Reviews' : '',
					'msrp'                 => $model['price'] ?? '',
					'seating'              => $model['seating_capacity'] ?? '',
					'seat'                 => $model['seating_filter'] ?? '',
					'price'                => $model['price_tier'] ?? '',
					'explore_series_label' => $model['series'] ?? '',
					'explore_categories'   => $model['explore_categories'] ?? '',
					'product_image'        => $model['image'] ?? '',
					'post_url'             => $model['url'] ?? '',
					'view_url'             => $model['url'] ?? '',
					'reviews_url'          => $model['url'] ?? '',
					'price_note_popup_content' => ! empty( $model['price_note_popup_content'] ) ? $model['price_note_popup_content'] : ( function_exists( 'phtf_default_price_note_popup_content' ) ? phtf_default_price_note_popup_content( '1' ) : '' ),
				];
			}
		}

		$tabs = [];
		if ( ! empty( $settings['tabs'] ) && is_array( $settings['tabs'] ) ) {
			foreach ( $settings['tabs'] as $tab ) {
				$label = isset( $tab['label'] ) ? trim( (string) $tab['label'] ) : '';
				$value = isset( $tab['value'] ) ? trim( (string) $tab['value'] ) : '';
				if ( '' !== $label && '' !== $value ) {
					$tabs[] = [ 'label' => $label, 'value' => $value ];
				}
			}
		}
		?>
		<section class="phtf-explore phtf-explore--standalone" data-phtf-explore data-phtf-explore-dynamic="true" data-phtf-explore-source="<?php echo esc_attr( $source_key ); ?>" data-phtf-explore-empty="<?php echo esc_attr( $settings['empty_message'] ?? '' ); ?>">
			<?php if ( ! empty( $cpt_products ) ) : ?>
				<script type="application/json" class="phtf-product-source-json" data-phtf-product-source="<?php echo esc_attr( $source_key ); ?>"><?php echo wp_json_encode( $cpt_products, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></script>
			<?php endif; ?>
			<?php if ( 'yes' === ( $settings['show_title'] ?? 'yes' ) && ! empty( $settings['title'] ) ) : ?>
				<h2 class="phtf-explore-title"><?php echo esc_html( $settings['title'] ); ?></h2>
			<?php endif; ?>

			<?php if ( 'yes' === ( $settings['show_tabs'] ?? 'yes' ) && ! empty( $tabs ) ) : ?>
				<div class="phtf-explore-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Model categories', 'perfect-hot-tub-finder' ); ?>">
					<?php foreach ( $tabs as $tab_index => $tab ) : ?>
						<button type="button" class="phtf-explore-tab<?php echo 0 === $tab_index ? ' is-active' : ''; ?>" data-phtf-explore-tab="<?php echo esc_attr( $tab['value'] ); ?>">
							<?php echo esc_html( $tab['label'] ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="phtf-explore-carousel">
				<button type="button" class="phtf-explore-arrow phtf-explore-arrow--prev" data-phtf-explore-prev aria-label="<?php esc_attr_e( 'Previous models', 'perfect-hot-tub-finder' ); ?>">‹</button>
				<div class="phtf-explore-viewport">
					<div class="phtf-explore-track" data-phtf-explore-track></div>
					<div class="phtf-explore-empty" data-phtf-explore-empty-message hidden><?php echo esc_html( $settings['empty_message'] ?? '' ); ?></div>
				</div>
				<button type="button" class="phtf-explore-arrow phtf-explore-arrow--next" data-phtf-explore-next aria-label="<?php esc_attr_e( 'Next models', 'perfect-hot-tub-finder' ); ?>">›</button>
			</div>

			<?php if ( ! empty( $settings['button_text'] ) ) : ?>
				<div class="phtf-explore-actions">
					<a class="phtf-explore-button" <?php echo $this->render_link_attrs( $settings['button_link'] ?? [] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['button_text'] ); ?></a>
				</div>
			<?php endif; ?>
		</section>
		<?php
	}
}
