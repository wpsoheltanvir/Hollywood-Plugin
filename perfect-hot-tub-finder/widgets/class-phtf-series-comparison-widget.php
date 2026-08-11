<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

class PHTF_Series_Comparison_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'phtf_series_comparison';
	}

	public function get_title() {
		return esc_html__( 'Hot Tub Series Comparison', 'perfect-hot-tub-finder' );
	}

	public function get_icon() {
		return 'eicon-table';
	}

	public function get_categories() {
		return [ 'phtf-widgets' ];
	}

	public function get_keywords() {
		return [ 'hot tub', 'spa', 'comparison', 'series', 'table', 'features' ];
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
			'section_title',
			[
				'label' => esc_html__( 'Header', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
				'default'     => esc_html__( 'Hot Tub Series Comparison.', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'condition'   => [ 'show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'mobile_intro_text',
			[
				'label'       => esc_html__( 'Tablet / Mobile Intro Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Want to go into more detail on each of our series?', 'perfect-hot-tub-finder' ),
				'rows'        => 3,
				'label_block' => true,
			]
		);

		$this->add_control(
			'mobile_open_text',
			[
				'label'       => esc_html__( 'Tablet / Mobile Button Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'See the Differences', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_columns',
			[
				'label' => esc_html__( 'Table Columns', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'benefits_heading',
			[
				'label'       => esc_html__( 'Benefits Column Heading', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Benefits', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'features_heading',
			[
				'label'       => esc_html__( 'Features Column Heading', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Features', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'series_1_heading',
			[
				'label'       => esc_html__( 'Series 1 Heading', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Utopia® Series', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'series_2_heading',
			[
				'label'       => esc_html__( 'Series 2 Heading', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Paradise® Series', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'series_3_heading',
			[
				'label'       => esc_html__( 'Series 3 Heading', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Vacanza® Series', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'series_4_heading',
			[
				'label'       => esc_html__( 'Series 4 Heading', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Fantasy™ Series', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_rows',
			[
				'label' => esc_html__( 'Comparison Rows', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'check_token_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Use [check] in any cell to show the included icon. Each row can belong to a Benefit Group such as Comfort, Design, or Performance.', 'perfect-hot-tub-finder' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'benefit_group',
			[
				'label'       => esc_html__( 'Benefit Group', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Comfort', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'feature',
			[
				'label'       => esc_html__( 'Feature', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Hot Tub Circuit Therapy®', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'series_1_cell',
			[
				'label'       => esc_html__( 'Series 1 Cell', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '[check]',
				'rows'        => 3,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'series_2_cell',
			[
				'label'       => esc_html__( 'Series 2 Cell', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'rows'        => 3,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'series_3_cell',
			[
				'label'       => esc_html__( 'Series 3 Cell', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'rows'        => 3,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'series_4_cell',
			[
				'label'       => esc_html__( 'Series 4 Cell', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'rows'        => 3,
				'label_block' => true,
			]
		);

		$this->add_control(
			'comparison_rows_v2',
			[
				'label'       => esc_html__( 'Rows', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $this->get_default_rows(),
				'title_field' => '{{{ feature }}}',
				'prevent_empty' => false,
			]
		);

		$this->add_control(
			'enable_sticky_header',
			[
				'label'        => esc_html__( 'Sticky Table Header', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'enable_sticky_columns',
			[
				'label'        => esc_html__( 'Sticky Benefits & Features Columns', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	private function register_style_controls() {
		

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Section Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 18,
					'right'    => 46,
					'bottom'   => 28,
					'left'     => 46,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .phtc-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'layout_quick_heading',
			[
				'label'     => esc_html__( 'Easy Layout', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'table_alignment',
			[
				'label'   => esc_html__( 'Table Alignment', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'margin-left: auto; margin-right: auto;',
				'options' => [
					'margin-left: 0; margin-right: auto;'    => esc_html__( 'Left', 'perfect-hot-tub-finder' ),
					'margin-left: auto; margin-right: auto;' => esc_html__( 'Center', 'perfect-hot-tub-finder' ),
					'margin-left: auto; margin-right: 0;'    => esc_html__( 'Right', 'perfect-hot-tub-finder' ),
				],
				'selectors' => [
					'{{WRAPPER}} .phtc-table-wrap' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'table_width_help',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Tip: set Table Width smaller than the section to see the left / center / right alignment clearly. Keep Table Minimum Width close to the total column width for clean horizontal scrolling.', 'perfect-hot-tub-finder' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_responsive_control(
			'table_width',
			[
				'label'      => esc_html__( 'Table Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 600, 'max' => 1600 ],
					'%'  => [ 'min' => 40, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1400 ],
				'selectors'  => [
					'{{WRAPPER}} .phtc-table-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_min_width',
			[
				'label'      => esc_html__( 'Table Minimum Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 560, 'max' => 1400 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 980 ],
				'selectors'  => [
					'{{WRAPPER}} .phtc-table' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'scrollbar_heading',
			[
				'label'     => esc_html__( 'Bottom Scrollbar', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'scrollbar_height',
			[
				'label'      => esc_html__( 'Scrollbar Height', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 6, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .phtc-widget' => '--phtc-scrollbar-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'scrollbar_track_color',
			[
				'label'     => esc_html__( 'Scrollbar Track Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#EAF8F9',
				'selectors' => [
					'{{WRAPPER}} .phtc-widget' => '--phtc-scrollbar-track: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scrollbar_thumb_color',
			[
				'label'     => esc_html__( 'Scrollbar Thumb Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .phtc-widget' => '--phtc-scrollbar-thumb: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scrollbar_thumb_hover_color',
			[
				'label'     => esc_html__( 'Scrollbar Thumb Hover Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtc-widget' => '--phtc-scrollbar-thumb-hover: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'cell_padding',
			[
				'label'      => esc_html__( 'Cell Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 6,
					'right'    => 14,
					'bottom'   => 6,
					'left'     => 14,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .phtc-table th, {{WRAPPER}} .phtc-table td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'benefits_column_width',
			[
				'label'      => esc_html__( 'Benefits Column Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 50, 'max' => 180 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 135 ],
				'selectors'  => [
					'{{WRAPPER}} .phtc-col-benefits' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .phtc-widget' => '--phtc-benefits-col-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'features_column_width',
			[
				'label'      => esc_html__( 'Features Column Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 120, 'max' => 360 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 253 ],
				'selectors'  => [
					'{{WRAPPER}} .phtc-col-features' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .phtc-widget' => '--phtc-features-col-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'series_column_width',
			[
				'label'      => esc_html__( 'Series Column Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 160, 'max' => 340 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 253 ],
				'selectors'  => [
					'{{WRAPPER}} .phtc-col-series' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .phtc-widget' => '--phtc-series-col-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_table_card_style',
			[
				'label' => esc_html__( 'Table Card', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'table_card_background',
			[
				'label'     => esc_html__( 'Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .phtc-table-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'unit' => 'px', 'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .phtc-table-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'table_card_shadow',
				'selector' => '{{WRAPPER}} .phtc-table-wrap',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'title_align',
			[
				'label'     => esc_html__( 'Alignment', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [ 'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .phtc-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtc-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 66 ],
				'selectors'  => [
					'{{WRAPPER}} .phtc-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .phtc-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_table_header_style',
			[
				'label' => esc_html__( 'Table Header', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'table_header_bg',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtc-table thead th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_header_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .phtc-table thead th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_header_padding',
			[
				'label'      => esc_html__( 'Header Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => 12,
					'right'    => 14,
					'bottom'   => 11,
					'left'     => 14,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .phtc-table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_header_alignment',
			[
				'label'   => esc_html__( 'Text Alignment', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .phtc-table thead th' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_header_vertical_alignment',
			[
				'label'   => esc_html__( 'Vertical Alignment', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'middle',
				'options' => [
					'top'    => esc_html__( 'Top', 'perfect-hot-tub-finder' ),
					'middle' => esc_html__( 'Middle', 'perfect-hot-tub-finder' ),
					'bottom' => esc_html__( 'Bottom', 'perfect-hot-tub-finder' ),
				],
				'selectors' => [
					'{{WRAPPER}} .phtc-table thead th' => 'vertical-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_header_text_wrap',
			[
				'label'   => esc_html__( 'Header Text Wrapping', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'nowrap',
				'options' => [
					'nowrap' => esc_html__( 'No Wrap', 'perfect-hot-tub-finder' ),
					'normal' => esc_html__( 'Allow Wrap', 'perfect-hot-tub-finder' ),
				],
				'selectors' => [
					'{{WRAPPER}} .phtc-table thead th' => 'white-space: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_header_top_radius',
			[
				'label'      => esc_html__( 'Top Corner Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 80 ],
					'%'  => [ 'min' => 0, 'max' => 50 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .phtc-table thead th:first-child' => 'border-top-left-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .phtc-table thead th:last-child'  => 'border-top-right-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sticky_header_top_offset',
			[
				'label'      => esc_html__( 'Sticky Top Offset', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 0 ],
				'condition'  => [ 'enable_sticky_header' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}} .phtc-widget' => '--phtc-sticky-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'table_header_typography',
				'selector' => '{{WRAPPER}} .phtc-table thead th',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'table_header_border',
				'label'    => esc_html__( 'Header Border', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtc-table thead th',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_body_style',
			[
				'label' => esc_html__( 'Table Body', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cell_text_color',
			[
				'label'     => esc_html__( 'Cell Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .phtc-table tbody td' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_responsive_control(
			'series_cell_align',
			[
				'label'   => esc_html__( 'Series Cell Alignment', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .phtc-series-cell' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'feature_cell_align',
			[
				'label'   => esc_html__( 'Feature Cell Alignment', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .phtc-feature-cell' => 'text-align: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'feature_text_color',
			[
				'label'     => esc_html__( 'Feature Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .phtc-feature-cell' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cell_background_color',
			[
				'label'     => esc_html__( 'Cell Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .phtc-table tbody td:not(.phtc-benefit-cell)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'alt_row_background_color',
			[
				'label'     => esc_html__( 'Alternate Row Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#F1F2F2',
				'selectors' => [
					'{{WRAPPER}} .phtc-table tbody tr:nth-child(even) td:not(.phtc-benefit-cell)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cell_typography',
				'selector' => '{{WRAPPER}} .phtc-table tbody td',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'table_border',
				'label'    => esc_html__( 'Table Border', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtc-table, {{WRAPPER}} .phtc-table th, {{WRAPPER}} .phtc-table td',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'table_shadow',
				'label'    => esc_html__( 'Table Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtc-table-wrap',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_benefit_style',
			[
				'label' => esc_html__( 'Benefit Labels', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'benefit_label_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtc-benefit-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'benefit_label_bg',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#F1F2F2',
				'selectors' => [
					'{{WRAPPER}} .phtc-benefit-cell--alt' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'benefit_label_typography',
				'selector' => '{{WRAPPER}} .phtc-benefit-label',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_check_style',
			[
				'label' => esc_html__( 'Included Icon', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'check_primary_color',
			[
				'label'     => esc_html__( 'Primary Icon Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .phtc-check' => '--phtc-check-gray: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'check_secondary_color',
			[
				'label'     => esc_html__( 'Secondary Icon Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtc-check' => '--phtc-check-secondary: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'check_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 19 ],
				'selectors'  => [
					'{{WRAPPER}} .phtc-check' => 'width: {{SIZE}}{{UNIT}}; height: calc({{SIZE}}{{UNIT}} * .9);',
				],
			]
		);

		$this->end_controls_section();
	}

	private function get_default_rows() {
		return [
			[ 'benefit_group' => 'Comfort', 'feature' => 'Hot Tub Circuit Therapy®', 'series_1_cell' => '6-8 Stations', 'series_2_cell' => '4-6 Stations', 'series_3_cell' => '2-5 Stations', 'series_4_cell' => '0 Stations' ],
			[ 'benefit_group' => 'Comfort', 'feature' => 'Hip Jets', 'series_1_cell' => '[check]', 'series_2_cell' => '', 'series_3_cell' => '', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Comfort', 'feature' => 'Wrist Jets', 'series_1_cell' => '[check]', 'series_2_cell' => '', 'series_3_cell' => '', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Comfort', 'feature' => 'Atlas® Neck Jet', 'series_1_cell' => '[check]', 'series_2_cell' => '', 'series_3_cell' => '', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Comfort', 'feature' => 'Euphoria Jets', 'series_1_cell' => '[check]', 'series_2_cell' => '[check]', 'series_3_cell' => '', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Comfort', 'feature' => 'Foot Well Massage', 'series_1_cell' => '[check]', 'series_2_cell' => '[check]', 'series_3_cell' => '[check]', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Comfort', 'feature' => 'Contoured Pillows', 'series_1_cell' => '[check]', 'series_2_cell' => '[check]', 'series_3_cell' => '[check]', 'series_4_cell' => '[check]' ],
			[ 'benefit_group' => 'Comfort', 'feature' => 'Handrail Assist', 'series_1_cell' => '[check]', 'series_2_cell' => '[check]', 'series_3_cell' => '', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Design', 'feature' => 'Advanced Cabinet Design', 'series_1_cell' => '[check]', 'series_2_cell' => '[check]', 'series_3_cell' => '[check]', 'series_4_cell' => '[check]' ],
			[ 'benefit_group' => 'Design', 'feature' => 'Backlit Waterfall', 'series_1_cell' => '[check]', 'series_2_cell' => '[check]', 'series_3_cell' => '', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Design', 'feature' => 'Exterior Lighting', 'series_1_cell' => '[check]', 'series_2_cell' => '', 'series_3_cell' => '', 'series_4_cell' => '[check]' ],
			[ 'benefit_group' => 'Design', 'feature' => 'Diagnostic Indicator Light', 'series_1_cell' => '[check]', 'series_2_cell' => '', 'series_3_cell' => '', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Design', 'feature' => 'Touchscreen Control Panel', 'series_1_cell' => '[check]', 'series_2_cell' => '', 'series_3_cell' => '', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Design', 'feature' => 'Auxiliary Control Panel', 'series_1_cell' => '[check]', 'series_2_cell' => '', 'series_3_cell' => '', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Design', 'feature' => 'Optional Integrated Speakers', 'series_1_cell' => '[check]', 'series_2_cell' => '[check]', 'series_3_cell' => '[check]', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Performance', 'feature' => 'Water Care System', 'series_1_cell' => "FreshWater® IQ Ready Salt +\nSmart Monitoring Included |\nDosing Optional", 'series_2_cell' => 'FreshWater® IQ Ready', 'series_3_cell' => 'FreshWater® Salt Ready', 'series_4_cell' => "FROG® Sanitizing System\nReady" ],
			[ 'benefit_group' => 'Performance', 'feature' => 'Premium Insulated Cover', 'series_1_cell' => '[check]', 'series_2_cell' => '[check]', 'series_3_cell' => '[check]', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Performance', 'feature' => 'FiberCor® Insulation', 'series_1_cell' => '[check]', 'series_2_cell' => '[check]', 'series_3_cell' => '[check]', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Performance', 'feature' => 'Sound Dampening Design', 'series_1_cell' => '[check]', 'series_2_cell' => '[check]', 'series_3_cell' => '[check]', 'series_4_cell' => '[check]' ],
			[ 'benefit_group' => 'Performance', 'feature' => "EnergyPro® Circulation\nSystem", 'series_1_cell' => '[check]', 'series_2_cell' => '[check]', 'series_3_cell' => '[check]', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Performance', 'feature' => 'GFCI Protection Sub-Panel', 'series_1_cell' => '[check]', 'series_2_cell' => '[check]', 'series_3_cell' => '[check]', 'series_4_cell' => '' ],
			[ 'benefit_group' => 'Performance', 'feature' => 'Total Jets', 'series_1_cell' => '43-74', 'series_2_cell' => '31-46', 'series_3_cell' => '14-45', 'series_4_cell' => '11-40' ],
			[ 'benefit_group' => 'Performance', 'feature' => 'ReliaFlo® Pumps', 'series_1_cell' => '2-3', 'series_2_cell' => '1-2', 'series_3_cell' => '1-2', 'series_4_cell' => '0' ],
		];
	}

	private function render_cell_content( $content ) {
		$content = (string) $content;
		$content = str_replace( [ "\r\n", "\r" ], "\n", $content );
		$output  = nl2br( esc_html( $content ) );
		$icon    = '<span class="phtc-check" role="img" aria-label="' . esc_attr__( 'Included', 'perfect-hot-tub-finder' ) . '"><span></span><span></span><span></span><span></span></span>';
		$output  = str_replace( [ '[check]', '[check]' ], $icon, $output );

		return $output;
	}

	private function get_group_rowspans( $rows ) {
		$rowspans = [];
		$total    = count( $rows );

		for ( $i = 0; $i < $total; $i++ ) {
			$group = isset( $rows[ $i ]['benefit_group'] ) ? (string) $rows[ $i ]['benefit_group'] : '';
			$prev  = $i > 0 && isset( $rows[ $i - 1 ]['benefit_group'] ) ? (string) $rows[ $i - 1 ]['benefit_group'] : null;

			if ( $i > 0 && $group === $prev ) {
				continue;
			}

			$count = 1;
			for ( $j = $i + 1; $j < $total; $j++ ) {
				$next_group = isset( $rows[ $j ]['benefit_group'] ) ? (string) $rows[ $j ]['benefit_group'] : '';
				if ( $next_group !== $group ) {
					break;
				}
				$count++;
			}

			$rowspans[ $i ] = $count;
		}

		return $rowspans;
	}

	private function render_table( $settings, $rows, $rowspans, $mobile = false ) {
		$group_index = -1;
		?>
		<div class="phtc-table-wrap">
			<table class="phtc-table">
				<colgroup>
					<col class="phtc-col-benefits">
					<col class="phtc-col-features">
					<col class="phtc-col-series">
					<col class="phtc-col-series">
					<col class="phtc-col-series">
					<col class="phtc-col-series">
				</colgroup>
				<thead>
					<tr>
						<th class="phtc-benefit-heading" scope="col"><?php echo esc_html( $settings['benefits_heading'] ?? esc_html__( 'Benefits', 'perfect-hot-tub-finder' ) ); ?></th>
						<th class="phtc-feature-heading" scope="col"><?php echo esc_html( $settings['features_heading'] ?? esc_html__( 'Features', 'perfect-hot-tub-finder' ) ); ?></th>
						<th scope="col"><?php echo esc_html( $settings['series_1_heading'] ?? esc_html__( 'Utopia® Series', 'perfect-hot-tub-finder' ) ); ?></th>
						<th scope="col"><?php echo esc_html( $settings['series_2_heading'] ?? esc_html__( 'Paradise® Series', 'perfect-hot-tub-finder' ) ); ?></th>
						<th scope="col"><?php echo esc_html( $settings['series_3_heading'] ?? esc_html__( 'Vacanza® Series', 'perfect-hot-tub-finder' ) ); ?></th>
						<th scope="col"><?php echo esc_html( $settings['series_4_heading'] ?? esc_html__( 'Fantasy™ Series', 'perfect-hot-tub-finder' ) ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rows as $index => $row ) :
						$group = $row['benefit_group'] ?? '';
						if ( $mobile && isset( $rowspans[ $index ] ) ) :
							$group_index++;
							?>
							<tr class="phtc-mobile-group-row"><td colspan="6"><button type="button" data-phtc-mobile-group-toggle="<?php echo esc_attr( $group_index ); ?>" aria-expanded="<?php echo 0 === $group_index ? 'true' : 'false'; ?>"><?php echo esc_html( $group ); ?><span aria-hidden="true"></span></button></td></tr>
						<?php endif; ?>
						<tr<?php echo $mobile ? ' data-phtc-mobile-group="' . esc_attr( $group_index ) . '"' . ( 0 === $group_index ? '' : ' hidden' ) : ''; ?>>
							<?php if ( isset( $rowspans[ $index ] ) ) :
								$benefit_class = $mobile && 0 === $group_index % 2 ? ' phtc-benefit-cell--alt' : '';
								?>
								<td class="phtc-benefit-cell<?php echo esc_attr( $benefit_class ); ?>" rowspan="<?php echo esc_attr( $rowspans[ $index ] ); ?>"><span class="phtc-benefit-label"><?php echo esc_html( $group ); ?></span></td>
							<?php endif; ?>
							<td class="phtc-feature-cell"><?php echo $this->render_cell_content( $row['feature'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
							<td class="phtc-series-cell"><?php echo $this->render_cell_content( $row['series_1_cell'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
							<td class="phtc-series-cell"><?php echo $this->render_cell_content( $row['series_2_cell'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
							<td class="phtc-series-cell"><?php echo $this->render_cell_content( $row['series_3_cell'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
							<td class="phtc-series-cell"><?php echo $this->render_cell_content( $row['series_4_cell'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$rows     = ! empty( $settings['comparison_rows_v2'] ) && is_array( $settings['comparison_rows_v2'] ) ? $settings['comparison_rows_v2'] : ( ! empty( $settings['comparison_rows'] ) && is_array( $settings['comparison_rows'] ) ? $settings['comparison_rows'] : $this->get_default_rows() );
		$rowspans = $this->get_group_rowspans( $rows );
		$widget_classes = [ 'phtc-widget' ];
		if ( 'yes' === ( $settings['enable_sticky_header'] ?? 'yes' ) ) {
			$widget_classes[] = 'phtc--sticky-head';
		}
		if ( 'yes' === ( $settings['enable_sticky_columns'] ?? 'yes' ) ) {
			$widget_classes[] = 'phtc--sticky-cols';
		}
		?>
		<section class="<?php echo esc_attr( implode( ' ', $widget_classes ) ); ?>">
			<?php if ( 'yes' === ( $settings['show_title'] ?? 'yes' ) && ! empty( $settings['title'] ) ) : ?>
				<h2 class="phtc-title"><?php echo esc_html( $settings['title'] ); ?></h2>
			<?php endif; ?>

			<div class="phtc-desktop-table">
				<?php $this->render_table( $settings, $rows, $rowspans ); ?>
			</div>

			<div class="phtc-mobile-summary">
				<?php if ( ! empty( $settings['title'] ) ) : ?>
					<h2 class="phtc-mobile-summary-title"><?php echo esc_html( $settings['title'] ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $settings['mobile_intro_text'] ) ) : ?>
					<p class="phtc-mobile-summary-copy"><?php echo esc_html( $settings['mobile_intro_text'] ); ?></p>
				<?php endif; ?>
				<button type="button" class="phtc-mobile-open" data-phtc-mobile-open aria-expanded="false"><?php echo esc_html( $settings['mobile_open_text'] ?? esc_html__( 'See the Differences', 'perfect-hot-tub-finder' ) ); ?> <span aria-hidden="true">›</span></button>
			</div>

			<div class="phtc-mobile-drawer" data-phtc-mobile-drawer aria-hidden="true">
				<div class="phtc-mobile-drawer-header"><button type="button" class="phtc-mobile-close" data-phtc-mobile-close aria-label="<?php esc_attr_e( 'Close comparison', 'perfect-hot-tub-finder' ); ?>">‹ <?php esc_html_e( 'Back', 'perfect-hot-tub-finder' ); ?></button></div>
				<div class="phtc-mobile-series-headings" aria-hidden="true">
					<span><?php echo esc_html( $settings['series_1_heading'] ?? '' ); ?></span><span><?php echo esc_html( $settings['series_2_heading'] ?? '' ); ?></span><span><?php echo esc_html( $settings['series_3_heading'] ?? '' ); ?></span><span><?php echo esc_html( $settings['series_4_heading'] ?? '' ); ?></span>
				</div>
				<?php $this->render_table( $settings, $rows, $rowspans, true ); ?>
			</div>
		</section>
		<?php
	}
}
