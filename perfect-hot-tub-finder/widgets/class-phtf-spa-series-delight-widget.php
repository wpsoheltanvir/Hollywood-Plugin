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

class PHTF_Spa_Series_Delight_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'phtf_spa_series_delight';
	}

	public function get_title() {
		return esc_html__( 'WP P Spa Series Delight', 'perfect-hot-tub-finder' );
	}

	public function get_icon() {
		return 'eicon-tabs';
	}

	public function get_categories() {
		return [ 'phtf-widgets' ];
	}

	public function get_keywords() {
		return [ 'hot tub', 'spa', 'series', 'delight', 'features', 'tabs', 'slider' ];
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
				'default'     => esc_html__( 'Designed to Delight.', 'perfect-hot-tub-finder' ),
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
			'section_tabs',
			[
				'label' => esc_html__( 'Tabs / Slides', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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

		$this->add_control(
			'show_tab_dividers',
			[
				'label'        => esc_html__( 'Show Tab Dividers', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_tabs' => 'yes' ],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_label',
			[
				'label'       => esc_html__( 'Tab Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Seats & Jets', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [ 'url' => phtf_get_fallback_image_url( 'widget' ) ],
			]
		);

		$repeater->add_control(
			'image_alt',
			[
				'label'       => esc_html__( 'Image Alt Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Spa feature image', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'content_heading',
			[
				'label'       => esc_html__( 'Content Heading', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'SEATS & JETS', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'content_text',
			[
				'label'       => esc_html__( 'Content Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 7,
				'default'     => esc_html__( 'Take a seat. You’ll immediately feel the Caldera difference, thanks to the unique, body-hugging contours and ergonomically designed configurations. Utopia Series spas take jet massage to a new level with added hip, wrist, and neck jets for a full body experience.', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'items',
			[
				'label'       => esc_html__( 'Delight Items', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ tab_label }}}',
				'default'     => [
					[
						'tab_label'       => esc_html__( 'Seats & Jets', 'perfect-hot-tub-finder' ),
						'content_heading' => esc_html__( 'SEATS & JETS', 'perfect-hot-tub-finder' ),
					],
					[
						'tab_label'       => esc_html__( 'Circuit Therapy', 'perfect-hot-tub-finder' ),
						'content_heading' => esc_html__( 'CIRCUIT THERAPY', 'perfect-hot-tub-finder' ),
						'content_text'    => esc_html__( 'Create a personalized massage experience with targeted jets and thoughtful seating designed to help your body relax.', 'perfect-hot-tub-finder' ),
					],
					[
						'tab_label'       => esc_html__( 'Water Care', 'perfect-hot-tub-finder' ),
						'content_heading' => esc_html__( 'WATER CARE', 'perfect-hot-tub-finder' ),
						'content_text'    => esc_html__( 'Enjoy easy-to-maintain water care options that help keep your spa ready for everyday wellness.', 'perfect-hot-tub-finder' ),
					],
					[
						'tab_label'       => esc_html__( 'Cabinet', 'perfect-hot-tub-finder' ),
						'content_heading' => esc_html__( 'CABINET', 'perfect-hot-tub-finder' ),
					],
					[
						'tab_label'       => esc_html__( 'Controls', 'perfect-hot-tub-finder' ),
						'content_heading' => esc_html__( 'CONTROLS', 'perfect-hot-tub-finder' ),
					],
					[
						'tab_label'       => esc_html__( 'Lighting', 'perfect-hot-tub-finder' ),
						'content_heading' => esc_html__( 'LIGHTING', 'perfect-hot-tub-finder' ),
					],
					[
						'tab_label'       => esc_html__( 'Entertainment', 'perfect-hot-tub-finder' ),
						'content_heading' => esc_html__( 'ENTERTAINMENT', 'perfect-hot-tub-finder' ),
					],
					[
						'tab_label'       => esc_html__( 'Efficiency', 'perfect-hot-tub-finder' ),
						'content_heading' => esc_html__( 'EFFICIENCY', 'perfect-hot-tub-finder' ),
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_arrows',
			[
				'label' => esc_html__( 'Slider Arrows', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_arrows',
			[
				'label'        => esc_html__( 'Show Arrows', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'prev_icon',
			[
				'label'     => esc_html__( 'Previous Icon/Text', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '‹',
				'condition' => [ 'show_arrows' => 'yes' ],
			]
		);

		$this->add_control(
			'next_icon',
			[
				'label'     => esc_html__( 'Next Icon/Text', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '›',
				'condition' => [ 'show_arrows' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_controls() {
		

		$this->start_controls_section(
			'style_layout',
			[
				'label' => esc_html__( 'Layout', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'container_width',
			[
				'label'      => esc_html__( 'Content Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 600, 'max' => 1600 ], '%' => [ 'min' => 50, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 1030 ],
				'selectors'  => [ '{{WRAPPER}} .phtf-delight-inner' => 'max-width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'wrapper_padding',
			[
				'label'      => esc_html__( 'Section Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [ 'top' => 42, 'right' => 24, 'bottom' => 48, 'left' => 24, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-delight' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'panel_gap',
			[
				'label'      => esc_html__( 'Image / Text Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 160 ] ],
				'default'    => [ 'size' => 58, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-delight-panel' => 'gap: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'      => esc_html__( 'Image Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 160, 'max' => 760 ], '%' => [ 'min' => 20, 'max' => 100 ] ],
				'default'    => [ 'size' => 393, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-delight-image-wrap' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'      => esc_html__( 'Image Height', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 120, 'max' => 650 ] ],
				'default'    => [ 'size' => 294, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-delight-image-wrap' => 'height: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_control(
			'image_fit',
			[
				'label'   => esc_html__( 'Image Fit', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [ 'cover' => esc_html__( 'Cover', 'perfect-hot-tub-finder' ), 'contain' => esc_html__( 'Contain', 'perfect-hot-tub-finder' ), 'fill' => esc_html__( 'Fill', 'perfect-hot-tub-finder' ) ],
				'selectors' => [ '{{WRAPPER}} .phtf-delight-image' => 'object-fit: {{VALUE}};' ],
			]
		);

		$this->add_responsive_control(
			'text_width',
			[
				'label'      => esc_html__( 'Text Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 160, 'max' => 620 ], '%' => [ 'min' => 20, 'max' => 100 ] ],
				'default'    => [ 'size' => 330, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-delight-content' => 'max-width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_title',
			[
				'label' => esc_html__( 'Title', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control( 'title_color', [ 'label' => esc_html__( 'Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-delight-title' => 'color: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'title_spacing', [ 'label' => esc_html__( 'Bottom Spacing', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ] ], 'default' => [ 'size' => 34, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .phtf-delight-title', 'fields_options' => [ 'font_family' => [ 'default' => 'Questrial' ], 'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 30 ] ], 'font_weight' => [ 'default' => '700' ] ] ] );
		$this->end_controls_section();

		$this->start_controls_section(
			'style_tabs',
			[
				'label' => esc_html__( 'Tabs', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'tab_typography', 'selector' => '{{WRAPPER}} .phtf-delight-tab', 'fields_options' => [ 'font_family' => [ 'default' => 'Questrial' ], 'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 18 ] ], 'font_weight' => [ 'default' => '700' ] ] ] );
		$this->add_responsive_control( 'tabs_gap', [ 'label' => esc_html__( 'Tab Gap', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ], 'default' => [ 'size' => 22, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-tabs' => 'gap: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'tab_padding', [ 'label' => esc_html__( 'Tab Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em' ], 'default' => [ 'top' => 0, 'right' => 0, 'bottom' => 12, 'left' => 0, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_control( 'tab_divider_color', [ 'label' => esc_html__( 'Divider Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_border' ], 'default' => '#D8D8D8', 'selectors' => [ '{{WRAPPER}} .phtf-delight-tab-item:not(:last-child)::after' => 'background-color: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'tabs_spacing', [ 'label' => esc_html__( 'Tabs Bottom Spacing', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 110 ] ], 'default' => [ 'size' => 42, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-tabs-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};' ] ] );

		$this->start_controls_tabs( 'tab_style_states' );
		$this->start_controls_tab( 'tab_normal', [ 'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'tab_normal_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=secondary' ], 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-delight-tab' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'tab_normal_bg', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_white' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-tab' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'tab_normal_underline', [ 'label' => esc_html__( 'Underline Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_border' ], 'default' => 'transparent', 'selectors' => [ '{{WRAPPER}} .phtf-delight-tab::after' => 'background-color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->start_controls_tab( 'tab_hover', [ 'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'tab_hover_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-delight-tab:hover' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'tab_hover_bg', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=secondary' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-tab:hover' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'tab_hover_underline', [ 'label' => esc_html__( 'Underline Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=secondary' ], 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-delight-tab:hover::after' => 'background-color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->start_controls_tab( 'tab_active', [ 'label' => esc_html__( 'Active', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'tab_active_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-delight-tab.is-active' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'tab_active_bg', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_white' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-tab.is-active' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'tab_active_underline', [ 'label' => esc_html__( 'Underline Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-delight-tab.is-active::after' => 'background-color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section( 'style_image', [ 'label' => esc_html__( 'Image', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'image_border', 'selector' => '{{WRAPPER}} .phtf-delight-image-wrap' ] );
		$this->add_responsive_control( 'image_radius', [ 'label' => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-image-wrap, {{WRAPPER}} .phtf-delight-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'image_shadow', 'selector' => '{{WRAPPER}} .phtf-delight-image-wrap' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_content', [ 'label' => esc_html__( 'Content Text', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'heading_color', [ 'label' => esc_html__( 'Heading Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-delight-heading' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'heading_typography', 'selector' => '{{WRAPPER}} .phtf-delight-heading', 'fields_options' => [ 'font_family' => [ 'default' => 'Questrial' ], 'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 18 ] ], 'font_weight' => [ 'default' => '700' ], 'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 4 ] ] ] ] );
		$this->add_control( 'body_color', [ 'label' => esc_html__( 'Body Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=text' ], 'default' => '#7A7A7A', 'selectors' => [ '{{WRAPPER}} .phtf-delight-text' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'body_typography', 'selector' => '{{WRAPPER}} .phtf-delight-text', 'fields_options' => [ 'font_family' => [ 'default' => 'Questrial' ], 'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 20 ] ], 'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.5 ] ] ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_arrows', [ 'label' => esc_html__( 'Slide Arrows', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_responsive_control( 'arrow_box_size', [ 'label' => esc_html__( 'Arrow Box Size', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 20, 'max' => 100 ] ], 'default' => [ 'size' => 52, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'arrow_icon_size', [ 'label' => esc_html__( 'Arrow Icon Size', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 12, 'max' => 80 ] ], 'default' => [ 'size' => 58, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow' => 'font-size: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'arrow_radius', [ 'label' => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'arrow_border_width', [ 'label' => esc_html__( 'Border Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 10 ] ], 'default' => [ 'size' => 0, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow' => 'border-width: {{SIZE}}{{UNIT}};' ] ] );

		$this->start_controls_tabs( 'arrow_style_tabs' );
		$this->start_controls_tab( 'arrow_normal', [ 'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'arrow_normal_color', [ 'label' => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=secondary' ], 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_normal_bg', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_white' ], 'default' => 'transparent', 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_normal_border', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_border' ], 'default' => 'transparent', 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow' => 'border-color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'arrow_normal_shadow', 'selector' => '{{WRAPPER}} .phtf-delight-arrow' ] );
		$this->end_controls_tab();
		$this->start_controls_tab( 'arrow_hover', [ 'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'arrow_hover_color', [ 'label' => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow:hover' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_hover_bg', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=secondary' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow:hover' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_hover_border', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_border' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow:hover' => 'border-color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'arrow_hover_shadow', 'selector' => '{{WRAPPER}} .phtf-delight-arrow:hover' ] );
		$this->end_controls_tab();
		$this->start_controls_tab( 'arrow_active', [ 'label' => esc_html__( 'Active', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'arrow_active_color', [ 'label' => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow.is-active' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_active_bg', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow.is-active' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_active_border', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_border' ], 'selectors' => [ '{{WRAPPER}} .phtf-delight-arrow.is-active' => 'border-color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'arrow_active_shadow', 'selector' => '{{WRAPPER}} .phtf-delight-arrow.is-active' ] );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items    = ! empty( $settings['items'] ) && is_array( $settings['items'] ) ? $settings['items'] : [];
		$show_title        = $settings['show_title'] ?? 'yes';
		$show_tabs         = $settings['show_tabs'] ?? 'yes';
		$show_tab_dividers = $settings['show_tab_dividers'] ?? 'yes';
		$show_arrows       = $settings['show_arrows'] ?? 'yes';
		$prev_icon         = $settings['prev_icon'] ?? '‹';
		$next_icon         = $settings['next_icon'] ?? '›';

		if ( empty( $items ) ) {
			return;
		}

		$title_tag = ! empty( $settings['title_html_tag'] ) ? $settings['title_html_tag'] : 'h2';
		$title_tag = in_array( $title_tag, [ 'h1', 'h2', 'h3', 'h4', 'div' ], true ) ? $title_tag : 'h2';
		?>
		<section class="phtf-delight" data-phtf-delight>
			<div class="phtf-delight-inner">
				<?php if ( 'yes' === $show_title && ! empty( $settings['title'] ) ) : ?>
					<<?php echo esc_attr( $title_tag ); ?> class="phtf-delight-title"><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $title_tag ); ?>>
				<?php endif; ?>

				<?php if ( 'yes' === $show_tabs ) : ?>
					<nav class="phtf-delight-tabs-wrap <?php echo ( 'yes' === $show_tab_dividers ) ? 'has-dividers' : ''; ?>" aria-label="<?php echo esc_attr__( 'Spa feature tabs', 'perfect-hot-tub-finder' ); ?>">
						<ul class="phtf-delight-tabs">
							<?php foreach ( $items as $index => $item ) : ?>
								<li class="phtf-delight-tab-item">
									<button type="button" class="phtf-delight-tab <?php echo 0 === $index ? 'is-active' : ''; ?>" data-phtf-delight-tab="<?php echo esc_attr( $index ); ?>">
										<?php echo esc_html( $item['tab_label'] ?? '' ); ?>
									</button>
								</li>
							<?php endforeach; ?>
						</ul>
					</nav>
				<?php endif; ?>

				<div class="phtf-delight-stage">
					<?php if ( 'yes' === $show_arrows && count( $items ) > 1 ) : ?>
						<button type="button" class="phtf-delight-arrow phtf-delight-prev" data-phtf-delight-prev aria-label="<?php echo esc_attr__( 'Previous feature', 'perfect-hot-tub-finder' ); ?>"><?php echo esc_html( $prev_icon ); ?></button>
					<?php endif; ?>

					<div class="phtf-delight-panels">
						<?php foreach ( $items as $index => $item ) :
							$image = phtf_image_url_or_fallback( $item['image']['url'] ?? '', 'widget' );
							$alt   = ! empty( $item['image_alt'] ) ? $item['image_alt'] : ( $item['content_heading'] ?? '' );
							?>
							<article class="phtf-delight-panel <?php echo 0 === $index ? 'is-active' : ''; ?>" data-phtf-delight-panel="<?php echo esc_attr( $index ); ?>" <?php echo 0 === $index ? '' : 'hidden'; ?>>
								<div class="phtf-delight-image-wrap">
									<img class="phtf-delight-image" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
								</div>
								<div class="phtf-delight-content">
									<?php if ( ! empty( $item['content_heading'] ) ) : ?>
										<h3 class="phtf-delight-heading"><?php echo esc_html( $item['content_heading'] ); ?></h3>
									<?php endif; ?>
									<?php if ( ! empty( $item['content_text'] ) ) : ?>
										<div class="phtf-delight-text"><?php echo wp_kses_post( wpautop( $item['content_text'] ) ); ?></div>
									<?php endif; ?>
								</div>
							</article>
						<?php endforeach; ?>
					</div>

					<?php if ( 'yes' === $show_arrows && count( $items ) > 1 ) : ?>
						<button type="button" class="phtf-delight-arrow phtf-delight-next" data-phtf-delight-next aria-label="<?php echo esc_attr__( 'Next feature', 'perfect-hot-tub-finder' ); ?>"><?php echo esc_html( $next_icon ); ?></button>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
