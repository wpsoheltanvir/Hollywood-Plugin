<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Utils;

class PHTF_Spa_Series_Models_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'phtf_spa_series_models';
	}

	public function get_title() {
		return esc_html__( 'Spa Series Models', 'perfect-hot-tub-finder' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'phtf-widgets' ];
	}

	public function get_keywords() {
		return [ 'hot tub', 'spa', 'series', 'models', 'grid', 'cards' ];
	}

	public function get_style_depends() {
		return [ 'phtf-hot-tub-finder' ];
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	private function register_content_controls() {
		$series_options = [ 'utopia' => esc_html__( 'Utopia Series', 'perfect-hot-tub-finder' ) ];
		if ( function_exists( 'phtf_compare_spa_category_options' ) ) {
			$series_options = phtf_compare_spa_category_options();
		}

		$this->start_controls_section(
			'section_data_source',
			[
				'label' => esc_html__( 'Spa Series Data Source', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'data_source',
			[
				'label'   => esc_html__( 'Content Source', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'spa_models',
				'options' => [
					'spa_models' => esc_html__( 'Spa Models (Dynamic)', 'perfect-hot-tub-finder' ),
					'manual'     => esc_html__( 'Manual Model Cards', 'perfect-hot-tub-finder' ),
				],
			]
		);
		$this->add_control(
			'series_category',
			[
				'label'       => esc_html__( 'Series', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'utopia',
				'options'     => $series_options,
				'description' => esc_html__( 'Shows every Spa Model assigned to this Spa Category / Series.', 'perfect-hot-tub-finder' ),
				'condition'   => [ 'data_source' => 'spa_models' ],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_header',
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
				'default'     => esc_html__( 'Vacanza® Models.', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'condition'   => [ 'show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'  => 'H1',
					'h2'  => 'H2',
					'h3'  => 'H3',
					'h4'  => 'H4',
					'div' => 'div',
				],
				'condition' => [ 'show_title' => 'yes' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_models',
			[
				'label' => esc_html__( 'Models', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_series_label',
			[
				'label'        => esc_html__( 'Show Series Label', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'        => esc_html__( 'Show Rating', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_meta',
			[
				'label'        => esc_html__( 'Show Seats / MSRP', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'star_text',
			[
				'label'   => esc_html__( 'Star Characters', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '★★★★★',
				'condition' => [ 'show_rating' => 'yes' ],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Model Image', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [ 'url' => phtf_get_fallback_image_url( 'widget' ) ],
			]
		);

		$repeater->add_control(
			'image_alt',
			[
				'label'       => esc_html__( 'Image Alt Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Spa model image', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'series_label',
			[
				'label'       => esc_html__( 'Series Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'VACANZA', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'model_name',
			[
				'label'       => esc_html__( 'Model Name', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Palatino<sup>®</sup>',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'reviews',
			[
				'label'   => esc_html__( 'Reviews', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '(120)',
			]
		);

		$repeater->add_control(
			'seats',
			[
				'label'   => esc_html__( 'Seats Text', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Seats 6', 'perfect-hot-tub-finder' ),
			]
		);

		$repeater->add_control(
			'price',
			[
				'label'   => esc_html__( 'MSRP / Price Text', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'MSRP: $14,999<sup>1</sup>',
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Model Link', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com/model',
			]
		);

		$this->add_control(
			'models',
			[
				'label'       => esc_html__( 'Model Cards', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ model_name }}}',
				'default'     => [
					[ 'series_label' => 'VACANZA', 'model_name' => 'Palatino<sup>®</sup>', 'reviews' => '(120)', 'seats' => 'Seats 6', 'price' => 'MSRP: $14,999<sup>1</sup>' ],
					[ 'series_label' => 'VACANZA', 'model_name' => 'Marino<sup>®</sup>', 'reviews' => '(358)', 'seats' => 'Seats 6', 'price' => 'MSRP: $12,499<sup>1</sup>' ],
					[ 'series_label' => 'VACANZA', 'model_name' => 'Vanto<sup>®</sup>', 'reviews' => '(264)', 'seats' => 'Seats 7', 'price' => 'MSRP: $12,499<sup>1</sup>' ],
					[ 'series_label' => 'VACANZA', 'model_name' => 'Tarino<sup>™</sup>', 'reviews' => '(102)', 'seats' => 'Seats 5', 'price' => 'MSRP: $11,999<sup>1</sup>' ],
					[ 'series_label' => 'VACANZA', 'model_name' => 'Celio<sup>™</sup>', 'reviews' => '(22)', 'seats' => 'Seats 3', 'price' => 'MSRP: $10,999<sup>1</sup>' ],
					[ 'series_label' => 'VACANZA', 'model_name' => 'Aventine<sup>®</sup>', 'reviews' => '(84)', 'seats' => 'Seats 2', 'price' => 'MSRP: $9,999<sup>1</sup>' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Optional Button', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'        => esc_html__( 'Show Button', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'     => esc_html__( 'Button Text', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'View All Models', 'perfect-hot-tub-finder' ),
				'condition' => [ 'show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'condition'   => [ 'show_button' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_controls() {
		

		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => esc_html__( 'Layout', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'      => esc_html__( 'Content Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 320, 'max' => 1600 ],
					'%'  => [ 'min' => 30, 'max' => 100 ],
					'vw' => [ 'min' => 30, 'max' => 100 ],
				],
				'default'    => [ 'size' => 1060, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-inner' => 'max-width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Section Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [ 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'perfect-hot-tub-finder' ),
				'type'           => Controls_Manager::NUMBER,
				'default'        => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'min'            => 1,
				'max'            => 6,
				'step'           => 1,
				'selectors'      => [ '{{WRAPPER}} .phtf-spa-models-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'      => esc_html__( 'Column Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 180 ], 'em' => [ 'min' => 0, 'max' => 10 ] ],
				'default'    => [ 'size' => 88, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-grid' => 'column-gap: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'      => esc_html__( 'Row Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 220 ], 'em' => [ 'min' => 0, 'max' => 12 ] ],
				'default'    => [ 'size' => 92, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-grid' => 'row-gap: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[
				'label'   => esc_html__( 'Text Alignment', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-card' => 'text-align: {{VALUE}};' ],
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

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-title' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .phtf-spa-models-title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 140 ], 'em' => [ 'min' => 0, 'max' => 8 ] ],
				'default'    => [ 'size' => 70, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
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

		$this->add_control(
			'card_background',
			[
				'label'     => esc_html__( 'Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-card' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .phtf-spa-models-card',
			]
		);

		$this->add_responsive_control(
			'card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_shadow',
				'selector' => '{{WRAPPER}} .phtf-spa-models-card',
			]
		);

		$this->add_control(
			'card_hover_heading',
			[
				'label'     => esc_html__( 'Hover', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'card_hover_background',
			[
				'label'     => esc_html__( 'Hover Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-card:hover' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'card_hover_lift',
			[
				'label'      => esc_html__( 'Hover Lift', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 20 ] ],
				'default'    => [ 'size' => 0, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-card:hover' => 'transform: translateY(-{{SIZE}}{{UNIT}});' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Images', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'      => esc_html__( 'Image Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 40, 'max' => 600 ], '%' => [ 'min' => 10, 'max' => 100 ] ],
				'default'    => [ 'size' => 190, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-image-wrap' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'      => esc_html__( 'Image Height', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range'      => [ 'px' => [ 'min' => 40, 'max' => 600 ], 'vw' => [ 'min' => 10, 'max' => 70 ] ],
				'default'    => [ 'size' => 176, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-image-wrap' => 'height: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_control(
			'image_fit',
			[
				'label'   => esc_html__( 'Object Fit', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'contain',
				'options' => [
					'contain' => esc_html__( 'Contain', 'perfect-hot-tub-finder' ),
					'cover'   => esc_html__( 'Cover', 'perfect-hot-tub-finder' ),
					'fill'    => esc_html__( 'Fill', 'perfect-hot-tub-finder' ),
				],
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-image' => 'object-fit: {{VALUE}};' ],
			]
		);

		$this->add_responsive_control(
			'image_spacing',
			[
				'label'      => esc_html__( 'Image Bottom Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ], 'em' => [ 'min' => 0, 'max' => 8 ] ],
				'default'    => [ 'size' => 28, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-image-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .phtf-spa-models-image',
			]
		);

		$this->add_responsive_control(
			'image_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_shadow',
				'selector' => '{{WRAPPER}} .phtf-spa-models-image',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__( 'Card Text', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'series_color',
			[
				'label'     => esc_html__( 'Series Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-series' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'series_typography',
				'selector' => '{{WRAPPER}} .phtf-spa-models-series',
			]
		);

		$this->add_control(
			'model_color',
			[
				'label'     => esc_html__( 'Model Name Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-name' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'model_typography',
				'selector' => '{{WRAPPER}} .phtf-spa-models-name',
			]
		);

		$this->add_responsive_control(
			'name_spacing',
			[
				'label'      => esc_html__( 'Model Name Bottom Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ], 'em' => [ 'min' => 0, 'max' => 4 ] ],
				'default'    => [ 'size' => 14, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-name' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_control(
			'star_color',
			[
				'label'     => esc_html__( 'Star Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#FDB72E',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-stars' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'review_color',
			[
				'label'     => esc_html__( 'Reviews Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-reviews' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'rating_typography',
				'selector' => '{{WRAPPER}} .phtf-spa-models-rating',
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__( 'Seats / MSRP Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-meta' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => esc_html__( 'MSRP Strong Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-meta strong' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'selector' => '{{WRAPPER}} .phtf-spa-models-meta',
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Meta Divider Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'default'   => '#B8B8B8',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-divider' => 'color: {{VALUE}};' ],
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

		$this->add_responsive_control(
			'button_align',
			[
				'label'   => esc_html__( 'Alignment', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-actions' => 'text-align: {{VALUE}};' ],
			]
		);

		$this->add_responsive_control(
			'button_spacing',
			[
				'label'      => esc_html__( 'Top Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 140 ], 'em' => [ 'min' => 0, 'max' => 8 ] ],
				'default'    => [ 'size' => 42, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-actions' => 'margin-top: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-button' => 'color: {{VALUE}} !important;' ],
			]
		);

		$this->add_control(
			'button_background',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-button' => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-button:hover, {{WRAPPER}} .phtf-spa-models-button:focus-visible' => 'color: {{VALUE}} !important;' ],
			]
		);

		$this->add_control(
			'button_hover_background',
			[
				'label'     => esc_html__( 'Hover Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-models-button:hover, {{WRAPPER}} .phtf-spa-models-button:focus-visible' => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .phtf-spa-models-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .phtf-spa-models-button',
			]
		);

		$this->add_responsive_control(
			'button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => 999, 'right' => 999, 'bottom' => 999, 'left' => 999, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'top' => 12, 'right' => 28, 'bottom' => 12, 'left' => 28, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-models-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .phtf-spa-models-button',
			]
		);

		$this->end_controls_section();
	}

	private function allowed_html() {
		return [
			'sup'    => [],
			'strong' => [],
			'em'     => [],
			'br'     => [],
			'span'   => [ 'class' => [] ],
		];
	}

	private function render_link_attrs( $link ) {
		if ( empty( $link['url'] ) ) {
			return '';
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

	private function render_price( $price, $popup_content ) {
		$marker = html_entity_decode( '&sup1;', ENT_QUOTES, 'UTF-8' );
		if ( false === strpos( (string) $price, $marker ) || empty( $popup_content ) ) {
			echo wp_kses( $price, $this->allowed_html() );
			return;
		}
		$price_text = str_replace( $marker, '', (string) $price );
		$popup_id = wp_unique_id( 'phtf-series-model-price-' );
		?>
		<?php echo wp_kses( $price_text, $this->allowed_html() ); ?>
		<span class="phtf-price-note-wrap"><button type="button" class="phtf-price-note-trigger" aria-expanded="false" aria-describedby="<?php echo esc_attr( $popup_id ); ?>" aria-label="<?php esc_attr_e( 'Pricing footnote', 'perfect-hot-tub-finder' ); ?>"><sup><?php echo esc_html( $marker ); ?></sup></button><span id="<?php echo esc_attr( $popup_id ); ?>" class="phtf-price-note-popup" role="tooltip"><button type="button" class="phtf-price-note-close" aria-label="<?php esc_attr_e( 'Close pricing note', 'perfect-hot-tub-finder' ); ?>">&times;</button><span class="phtf-price-note-popup-scroll"><?php echo wp_kses_post( wpautop( esc_html( $popup_content ) ) ); ?></span></span></span>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( 'spa_models' === ( $settings['data_source'] ?? 'spa_models' ) && function_exists( 'phtf_get_spa_models' ) && function_exists( 'phtf_spa_model_cards' ) ) {
			$selected_series = $settings['series_category'] ?? 'utopia';
			$models = array_filter(
				phtf_get_spa_models(),
				static function ( $model ) use ( $selected_series ) {
					return $selected_series === ( $model['compare_category_key'] ?? $model['compare_category'] ?? '' );
				}
			);
			$dynamic_cards = phtf_spa_model_cards( $models );
			if ( ! empty( $dynamic_cards ) ) {
				$settings['models'] = $dynamic_cards;
			}
			if ( function_exists( 'phtf_compare_spa_category_options' ) ) {
				$options = phtf_compare_spa_category_options();
				$series_label = $options[ $selected_series ] ?? '';
				if ( $series_label ) {
					$settings['title'] = trim( preg_replace( '/\s*Series$/i', '', wp_strip_all_tags( $series_label ) ) ) . ' ' . __( 'Models.', 'perfect-hot-tub-finder' );
				}
			}
		}
		$tag      = ! empty( $settings['title_html_tag'] ) ? $settings['title_html_tag'] : 'h2';
		$allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'div' ];
		if ( ! in_array( $tag, $allowed_tags, true ) ) {
			$tag = 'h2';
		}
		?>
		<section class="phtf-spa-models">
			<div class="phtf-spa-models-inner">
				<?php if ( 'yes' === ( $settings['show_title'] ?? 'yes' ) && ! empty( $settings['title'] ) ) : ?>
					<<?php echo esc_attr( $tag ); ?> class="phtf-spa-models-title"><?php echo wp_kses_post( $settings['title'] ); ?></<?php echo esc_attr( $tag ); ?>>
				<?php endif; ?>

				<?php if ( ! empty( $settings['models'] ) && is_array( $settings['models'] ) ) : ?>
					<div class="phtf-spa-models-grid">
						<?php foreach ( $settings['models'] as $model ) :
							$image_url = phtf_image_url_or_fallback( ! empty( $model['image']['url'] ) ? $model['image']['url'] : '', 'widget' );
							$alt       = ! empty( $model['image_alt'] ) ? $model['image_alt'] : wp_strip_all_tags( $model['model_name'] ?? '' );
							$link_attrs = $this->render_link_attrs( $model['link'] ?? [] );
							$reviews_link_attrs = $this->render_link_attrs( $model['reviews_link'] ?? [] );
							?>
							<article class="phtf-spa-models-card">
								<div class="phtf-spa-models-image-wrap">
									<?php if ( $link_attrs ) : ?><a class="phtf-spa-models-image-link" <?php echo $link_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php endif; ?><img class="phtf-spa-models-image" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>"><?php if ( $link_attrs ) : ?></a><?php endif; ?>
								</div>

								<?php if ( 'yes' === ( $settings['show_series_label'] ?? 'yes' ) && ! empty( $model['series_label'] ) ) : ?>
									<div class="phtf-spa-models-series"><?php echo esc_html( $model['series_label'] ); ?></div>
								<?php endif; ?>

								<?php if ( ! empty( $model['model_name'] ) ) : ?>
									<?php if ( $link_attrs ) : ?><a class="phtf-spa-models-name phtf-spa-models-name-link" <?php echo $link_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo wp_kses( $model['model_name'], $this->allowed_html() ); ?></a><?php else : ?><div class="phtf-spa-models-name"><?php echo wp_kses( $model['model_name'], $this->allowed_html() ); ?></div><?php endif; ?>
								<?php endif; ?>

								<?php if ( 'yes' === ( $settings['show_rating'] ?? 'yes' ) ) : ?>
									<div class="phtf-spa-models-rating" aria-label="<?php echo esc_attr( wp_strip_all_tags( $model['reviews'] ?? '' ) ); ?>">
										<span class="phtf-spa-models-stars"><?php echo esc_html( $settings['star_text'] ?? '★★★★★' ); ?></span>
									<?php if ( ! empty( $model['reviews'] ) ) : ?>
										<?php if ( $reviews_link_attrs ) : ?><a class="phtf-spa-models-reviews" <?php echo $reviews_link_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $model['reviews'] ); ?></a><?php else : ?><span class="phtf-spa-models-reviews"><?php echo esc_html( $model['reviews'] ); ?></span><?php endif; ?>
										<?php endif; ?>
									</div>
								<?php endif; ?>

								<?php if ( 'yes' === ( $settings['show_meta'] ?? 'yes' ) && ( ! empty( $model['seats'] ) || ! empty( $model['price'] ) ) ) : ?>
									<div class="phtf-spa-models-meta">
										<?php if ( ! empty( $model['seats'] ) ) : ?>
											<span class="phtf-spa-models-seats"><?php echo esc_html( $model['seats'] ); ?></span>
										<?php endif; ?>
										<?php if ( ! empty( $model['seats'] ) && ! empty( $model['price'] ) ) : ?>
											<span class="phtf-spa-models-divider">|</span>
										<?php endif; ?>
										<?php if ( ! empty( $model['price'] ) ) : ?>
											<span class="phtf-spa-models-price"><?php $this->render_price( $model['price'], $model['price_note_popup_content'] ?? '' ); ?></span>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</article>
							<?php
						endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( 'yes' === ( $settings['show_button'] ?? '' ) && ! empty( $settings['button_text'] ) ) : ?>
					<div class="phtf-spa-models-actions">
						<a class="phtf-spa-models-button" <?php echo $this->render_link_attrs( $settings['button_link'] ?? [] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['button_text'] ); ?></a>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
