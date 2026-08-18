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

class PHTF_Spa_Colors_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'phtf_spa_colors';
	}

	public function get_title() {
		return esc_html__( 'WP P Customize Spa Colors', 'perfect-hot-tub-finder' );
	}

	public function get_icon() {
		return 'eicon-paint-brush';
	}

	public function get_categories() {
		return [ 'phtf-widgets' ];
	}

	public function get_keywords() {
		return [ 'hot tub', 'spa', 'colors', 'customizer', 'cabinet', 'shell' ];
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
				'default'     => esc_html__( 'Make It Yours.', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'condition'   => [ 'show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'show_subtitle',
			[
				'label'        => esc_html__( 'Show Subtitle', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'CUSTOMIZE YOUR SPA COLORS', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'condition'   => [ 'show_subtitle' => 'yes' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_main_image',
			[
				'label' => esc_html__( 'Main Spa Image', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'main_image',
			[
				'label'   => esc_html__( 'Default Image', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [ 'url' => phtf_get_fallback_image_url( 'widget' ) ],
			]
		);

		$this->add_control(
			'image_alt',
			[
				'label'       => esc_html__( 'Image Alt Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Customized spa color preview', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cabinets',
			[
				'label' => esc_html__( 'Cabinet Colors', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_cabinets',
			[
				'label'        => esc_html__( 'Show Cabinet Colors', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'cabinets_label',
			[
				'label'       => esc_html__( 'Cabinet Group Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'CABINETS', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'condition'   => [ 'show_cabinets' => 'yes' ],
			]
		);

		$cabinets = new Repeater();
		$this->add_swatch_repeater_controls( $cabinets );

		$this->add_control(
			'cabinet_colors',
			[
				'label'       => esc_html__( 'Cabinet Options', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $cabinets->get_controls(),
				'title_field' => '{{{ name }}}',
				'condition'   => [ 'show_cabinets' => 'yes' ],
				'default'     => [
					[ 'name' => esc_html__( 'Parchment', 'perfect-hot-tub-finder' ), 'swatch_color' => '#d6d1ca', 'active' => 'yes' ],
					[ 'name' => esc_html__( 'Ash', 'perfect-hot-tub-finder' ), 'swatch_color' => '#8f9694', 'active' => '' ],
					[ 'name' => esc_html__( 'Java', 'perfect-hot-tub-finder' ), 'swatch_color' => '#292623', 'active' => '' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_shells',
			[
				'label' => esc_html__( 'Shell Colors', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_shells',
			[
				'label'        => esc_html__( 'Show Shell Colors', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'shells_label',
			[
				'label'       => esc_html__( 'Shell Group Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'SHELLS', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'condition'   => [ 'show_shells' => 'yes' ],
			]
		);

		$shells = new Repeater();
		$this->add_swatch_repeater_controls( $shells );

		$this->add_control(
			'shell_colors',
			[
				'label'       => esc_html__( 'Shell Options', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $shells->get_controls(),
				'title_field' => '{{{ name }}}',
				'condition'   => [ 'show_shells' => 'yes' ],
				'default'     => [
					[ 'name' => esc_html__( 'Arctic White', 'perfect-hot-tub-finder' ), 'swatch_color' => '#f0f0ec', 'active' => '' ],
					[ 'name' => esc_html__( 'White Pearl', 'perfect-hot-tub-finder' ), 'swatch_color' => '#d9d8d2', 'active' => '' ],
					[ 'name' => esc_html__( 'Desert', 'perfect-hot-tub-finder' ), 'swatch_color' => '#b8aa98', 'active' => '' ],
					[ 'name' => esc_html__( 'Tuscan Sun', 'perfect-hot-tub-finder' ), 'swatch_color' => '#8c7765', 'active' => '' ],
					[ 'name' => esc_html__( 'Midnight Canyon', 'perfect-hot-tub-finder' ), 'swatch_color' => '#2b2a27', 'active' => 'yes' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_footer',
			[
				'label' => esc_html__( 'Footer / Button', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_cover_text',
			[
				'label'        => esc_html__( 'Show Cover Colors Text', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'cover_text',
			[
				'label'     => esc_html__( 'Cover Colors Text', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Cover Colors', 'perfect-hot-tub-finder' ),
				'condition' => [ 'show_cover_text' => 'yes' ],
			]
		);

		$this->add_control(
			'show_info_icon',
			[
				'label'        => esc_html__( 'Show Info Icon', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_cover_text' => 'yes' ],
			]
		);

		$this->add_control(
			'info_text',
			[
				'label'     => esc_html__( 'Info Tooltip Text', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Cover colors may vary by model and availability.', 'perfect-hot-tub-finder' ),
				'condition' => [ 'show_info_icon' => 'yes' ],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'View Model in 360°', 'perfect-hot-tub-finder' ),
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

		$this->end_controls_section();
	}

	private function add_swatch_repeater_controls( $repeater ) {
		$repeater->add_control(
			'name',
			[
				'label'       => esc_html__( 'Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Color Name', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'swatch_image',
			[
				'label' => esc_html__( 'Swatch Image', 'perfect-hot-tub-finder' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);

		$repeater->add_control(
			'swatch_color',
			[
				'label'   => esc_html__( 'Fallback Swatch Color', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#dddddd',
			]
		);

		$repeater->add_control(
			'preview_image',
			[
				'label'       => esc_html__( 'Main Image When Selected', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => esc_html__( 'Optional. If set, clicking this swatch changes the large spa preview image.', 'perfect-hot-tub-finder' ),
			]
		);

		$repeater->add_control(
			'active',
			[
				'label'        => esc_html__( 'Active by Default', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
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
			'wrapper_max_width',
			[
				'label'      => esc_html__( 'Content Max Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 500, 'max' => 1600 ], '%' => [ 'min' => 50, 'max' => 100 ] ],
				'default'    => [ 'size' => 1180, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-colors-inner' => 'max-width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'wrapper_padding',
			[
				'label'      => esc_html__( 'Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [ 'top' => 35, 'right' => 20, 'bottom' => 35, 'left' => 20, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-colors' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'header_gap',
			[
				'label'      => esc_html__( 'Header Bottom Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
				'default'    => [ 'size' => 55, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-colors-header' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'image_bottom_gap',
			[
				'label'      => esc_html__( 'Image Bottom Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
				'default'    => [ 'size' => 18, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-preview' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'groups_gap',
			[
				'label'      => esc_html__( 'Cabinet / Shell Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 160 ] ],
				'default'    => [ 'size' => 70, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-options-row' => 'gap: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_header_style',
			[
				'label' => esc_html__( 'Header Text', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-title' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .phtf-spa-title',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-subtitle' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .phtf-spa-subtitle',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Main Image', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'      => esc_html__( 'Image Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 200, 'max' => 1000 ], '%' => [ 'min' => 20, 'max' => 100 ] ],
				'default'    => [ 'size' => 520, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-main-image' => 'max-width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'image_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-main-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_shadow',
				'selector' => '{{WRAPPER}} .phtf-spa-main-image',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_swatch_style',
			[
				'label' => esc_html__( 'Color Swatches', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'swatch_size',
			[
				'label'      => esc_html__( 'Swatch Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 34, 'max' => 130 ] ],
				'default'    => [ 'size' => 74, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-swatch-button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'swatch_gap',
			[
				'label'      => esc_html__( 'Swatch Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 80 ] ],
				'default'    => [ 'size' => 30, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-swatches' => 'gap: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_control(
			'group_label_color',
			[
				'label'     => esc_html__( 'Group Label Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-group-title' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'group_label_typography',
				'selector' => '{{WRAPPER}} .phtf-spa-group-title',
			]
		);

		$this->add_control(
			'swatch_label_color',
			[
				'label'     => esc_html__( 'Swatch Label Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-swatch-label' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'swatch_label_typography',
				'selector' => '{{WRAPPER}} .phtf-spa-swatch-label',
			]
		);

		$this->start_controls_tabs( 'swatch_state_tabs' );

		$this->start_controls_tab(
			'swatch_normal_tab',
			[ 'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ) ]
		);
		$this->add_control(
			'swatch_normal_border',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'default'   => 'transparent',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-swatch-button' => 'border-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'swatch_hover_tab',
			[ 'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ) ]
		);
		$this->add_control(
			'swatch_hover_border',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-swatch-button:hover, {{WRAPPER}} .phtf-spa-swatch-button:focus-visible' => 'border-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'swatch_active_tab',
			[ 'label' => esc_html__( 'Active', 'perfect-hot-tub-finder' ) ]
		);
		$this->add_control(
			'swatch_active_border',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-swatch.is-active .phtf-spa-swatch-button' => 'border-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'swatch_active_ring',
			[
				'label'     => esc_html__( 'Outer Ring Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-swatch.is-active .phtf-spa-swatch-button::after' => 'border-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'swatch_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
				'default'    => [ 'size' => 2, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-swatch-button' => 'border-width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_control(
			'swatch_ring_gap',
			[
				'label'      => esc_html__( 'Active Ring Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 12 ] ],
				'default'    => [ 'size' => 4, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-swatch-button::after' => 'inset: -{{SIZE}}{{UNIT}};' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_footer_style',
			[
				'label' => esc_html__( 'Footer / Button', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cover_text_color',
			[
				'label'     => esc_html__( 'Cover Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-cover-text' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cover_typography',
				'selector' => '{{WRAPPER}} .phtf-spa-cover-text',
			]
		);

		$this->add_control(
			'info_color',
			[
				'label'     => esc_html__( 'Info Icon Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-info' => 'color: {{VALUE}}; border-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Center Divider Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'default'   => '#dddddd',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-divider' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_responsive_control(
			'divider_height',
			[
				'label'      => esc_html__( 'Divider Height', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
				'default'    => [ 'size' => 75, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-divider' => 'height: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .phtf-spa-button',
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab(
			'button_normal_tab',
			[ 'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ) ]
		);
		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#ffffff',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-button' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-button' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-button' => 'border-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover_tab',
			[ 'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ) ]
		);
		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#ffffff',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-button:hover, {{WRAPPER}} .phtf-spa-button:focus-visible' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'button_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-button:hover, {{WRAPPER}} .phtf-spa-button:focus-visible' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-spa-button:hover, {{WRAPPER}} .phtf-spa-button:focus-visible' => 'border-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Button Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'top' => 12, 'right' => 32, 'bottom' => 12, 'left' => 32, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'button_radius',
			[
				'label'      => esc_html__( 'Button Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => 28, 'right' => 28, 'bottom' => 28, 'left' => 28, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-spa-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .phtf-spa-button',
			]
		);

		$this->end_controls_section();
	}

	private function render_link_attrs( $link ) {
		$attrs = 'href="#"';

		if ( ! empty( $link['url'] ) ) {
			$attrs = 'href="' . esc_url( $link['url'] ) . '"';
		}
		$rel = [];

		if ( ! empty( $link['is_external'] ) ) {
			$attrs .= ' target="_blank"';
			$rel[] = 'noopener';
			$rel[] = 'noreferrer';
		}

		if ( ! empty( $link['nofollow'] ) ) {
			$rel[] = 'nofollow';
		}

		if ( ! empty( $rel ) ) {
			$attrs .= ' rel="' . esc_attr( implode( ' ', array_unique( $rel ) ) ) . '"';
		}

		return $attrs;
	}

	private function render_swatches( $items, $group ) {
		if ( empty( $items ) || ! is_array( $items ) ) {
			return;
		}

		$has_active = false;
		foreach ( $items as $item ) {
			if ( 'yes' === ( $item['active'] ?? '' ) ) {
				$has_active = true;
				break;
			}
		}

		foreach ( $items as $index => $item ) :
			$name        = $item['name'] ?? '';
			$active      = 'yes' === ( $item['active'] ?? '' ) || ( ! $has_active && 0 === $index );
			$swatch_url  = $item['swatch_image']['url'] ?? '';
			$preview_url = $item['preview_image']['url'] ?? '';
			$color       = $item['swatch_color'] ?? '#dddddd';
			$style       = 'background-color:' . esc_attr( $color ) . ';';
			if ( ! empty( $swatch_url ) ) {
				$style .= 'background-image:url(' . esc_url( $swatch_url ) . ');';
			}
			?>
			<div class="phtf-spa-swatch<?php echo $active ? ' is-active' : ''; ?>" data-phtf-spa-swatch-wrap="<?php echo esc_attr( $group ); ?>">
				<button type="button" class="phtf-spa-swatch-button" style="<?php echo esc_attr( $style ); ?>" data-phtf-spa-swatch data-phtf-spa-group="<?php echo esc_attr( $group ); ?>" data-phtf-spa-image="<?php echo esc_url( $preview_url ); ?>" aria-label="<?php echo esc_attr( $name ); ?>" aria-pressed="<?php echo $active ? 'true' : 'false'; ?>"></button>
				<?php if ( ! empty( $name ) ) : ?>
					<span class="phtf-spa-swatch-label"><?php echo esc_html( $name ); ?></span>
				<?php endif; ?>
			</div>
			<?php
		endforeach;
	}

	protected function render() {
		// This is a manual customizer: preserve the image, swatches, and link selected in Elementor.
		$settings = $this->get_settings_for_display();
		$image_url  = phtf_image_url_or_fallback( $settings['main_image']['url'] ?? '', 'widget' );
		$image_alt  = $settings['image_alt'] ?? '';
		$uid        = 'phtf-spa-colors-' . $this->get_id();
		?>
		<section id="<?php echo esc_attr( $uid ); ?>" class="phtf-spa-colors" data-phtf-spa-colors>
			<div class="phtf-spa-colors-inner">
				<?php if ( 'yes' === ( $settings['show_title'] ?? 'yes' ) || 'yes' === ( $settings['show_subtitle'] ?? 'yes' ) ) : ?>
					<div class="phtf-spa-colors-header">
						<?php if ( 'yes' === ( $settings['show_title'] ?? 'yes' ) && ! empty( $settings['title'] ) ) : ?>
							<h2 class="phtf-spa-title"><?php echo esc_html( $settings['title'] ); ?></h2>
						<?php endif; ?>

						<?php if ( 'yes' === ( $settings['show_subtitle'] ?? 'yes' ) && ! empty( $settings['subtitle'] ) ) : ?>
							<div class="phtf-spa-subtitle"><?php echo esc_html( $settings['subtitle'] ); ?></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="phtf-spa-preview">
					<img class="phtf-spa-main-image" data-phtf-spa-main-image src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
				</div>

				<div class="phtf-spa-options-row">
					<?php if ( 'yes' === ( $settings['show_cabinets'] ?? 'yes' ) ) : ?>
						<div class="phtf-spa-option-group phtf-spa-option-group--cabinets">
							<?php if ( ! empty( $settings['cabinets_label'] ) ) : ?>
								<div class="phtf-spa-group-title"><?php echo esc_html( $settings['cabinets_label'] ); ?></div>
							<?php endif; ?>
							<div class="phtf-spa-swatches">
								<?php $this->render_swatches( $settings['cabinet_colors'] ?? [], 'cabinet' ); ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( 'yes' === ( $settings['show_cabinets'] ?? 'yes' ) && 'yes' === ( $settings['show_shells'] ?? 'yes' ) ) : ?>
						<span class="phtf-spa-divider" aria-hidden="true"></span>
					<?php endif; ?>

					<?php if ( 'yes' === ( $settings['show_shells'] ?? 'yes' ) ) : ?>
						<div class="phtf-spa-option-group phtf-spa-option-group--shells">
							<?php if ( ! empty( $settings['shells_label'] ) ) : ?>
								<div class="phtf-spa-group-title"><?php echo esc_html( $settings['shells_label'] ); ?></div>
							<?php endif; ?>
							<div class="phtf-spa-swatches">
								<?php $this->render_swatches( $settings['shell_colors'] ?? [], 'shell' ); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( 'yes' === ( $settings['show_cover_text'] ?? 'yes' ) || ! empty( $settings['button_text'] ) ) : ?>
					<div class="phtf-spa-footer">
						<?php if ( 'yes' === ( $settings['show_cover_text'] ?? 'yes' ) && ! empty( $settings['cover_text'] ) ) : ?>
							<div class="phtf-spa-cover-text">
								<span><?php echo esc_html( $settings['cover_text'] ); ?></span>
								<?php if ( 'yes' === ( $settings['show_info_icon'] ?? 'yes' ) ) : ?>
									<span class="phtf-spa-info" title="<?php echo esc_attr( $settings['info_text'] ?? '' ); ?>" aria-label="<?php echo esc_attr( $settings['info_text'] ?? '' ); ?>">i</span>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['button_text'] ) ) : ?>
							<a class="phtf-spa-button" <?php echo $this->render_link_attrs( $settings['button_link'] ?? [] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['button_text'] ); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
