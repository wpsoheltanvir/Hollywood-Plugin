<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

/** Elementor hero/gallery for a single spa series page. */
class PHTF_Spa_Series_Slider_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'phtf_spa_series_slider'; }
	public function get_title() { return esc_html__( 'Series Hero', 'perfect-hot-tub-finder' ); }
	public function get_icon() { return 'eicon-slider-push'; }
	public function get_categories() { return [ 'phtf-widgets' ]; }
	public function get_keywords() { return [ 'spa', 'hot tub', 'series', 'hero', 'gallery', 'slider' ]; }
	public function get_style_depends() { return [ 'phtf-hot-tub-finder' ]; }
	public function get_script_depends() { return [ 'phtf-hot-tub-finder' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'header', [ 'label' => esc_html__( 'Header / Breadcrumb', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'show_header', [ 'label' => esc_html__( 'Show Header', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Yes', 'perfect-hot-tub-finder' ), 'label_off' => esc_html__( 'No', 'perfect-hot-tub-finder' ), 'return_value' => 'yes', 'default' => 'yes' ] );
		$this->add_control( 'show_breadcrumb', [ 'label' => esc_html__( 'Show Breadcrumb', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Yes', 'perfect-hot-tub-finder' ), 'label_off' => esc_html__( 'No', 'perfect-hot-tub-finder' ), 'return_value' => 'yes', 'default' => 'yes', 'condition' => [ 'show_header' => 'yes' ] ] );
		$breadcrumb_repeater = new Repeater();
		$breadcrumb_repeater->add_control( 'label', [ 'label' => esc_html__( 'Label', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Home', 'perfect-hot-tub-finder' ), 'label_block' => true, 'dynamic' => [ 'active' => true ] ] );
		$breadcrumb_repeater->add_control( 'link', [ 'label' => esc_html__( 'Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL, 'dynamic' => [ 'active' => true ] ] );
		$this->add_control( 'breadcrumb_items', [ 'label' => esc_html__( 'Breadcrumb Items', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::REPEATER, 'fields' => $breadcrumb_repeater->get_controls(), 'title_field' => '{{{ label }}}', 'default' => [ [ 'label' => 'Home' ], [ 'label' => 'Shop' ] ], 'condition' => [ 'show_header' => 'yes', 'show_breadcrumb' => 'yes' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'content', [ 'label' => esc_html__( 'Series Content', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'title', [ 'label' => esc_html__( 'Title', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Utopia® Series', 'label_block' => true ] );
		$this->add_control( 'reviews', [ 'label' => esc_html__( 'Reviews Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => '852 Reviews' ] );
		$this->add_control( 'reviews_url', [ 'label' => esc_html__( 'Reviews Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL ] );
		$this->add_control( 'description', [ 'label' => esc_html__( 'Description', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 7, 'default' => 'The Utopia series features architecturally inspired cabinetry, easy-to-use touchscreen controls, and a top-of-the-line hydrotherapy experience. Every Utopia Series spa includes the FreshWater® IQ Salt and Smart Monitoring Systems, with the option to add precision Dosing for even simpler water care.' ] );
		$this->add_control( 'brochure_text', [ 'label' => esc_html__( 'Brochure Button Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Download Brochure' ] );
		$this->add_control( 'brochure_url', [ 'label' => esc_html__( 'Brochure Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL ] );
		$this->add_control( 'pricing_text', [ 'label' => esc_html__( 'Pricing Button Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Get Local Pricing' ] );
		$this->add_control( 'pricing_url', [ 'label' => esc_html__( 'Pricing Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL ] );
		$this->end_controls_section();

		$this->start_controls_section( 'gallery', [ 'label' => esc_html__( 'Gallery Slides', 'perfect-hot-tub-finder' ) ] );
		$repeater = new Repeater();
		$repeater->add_control( 'image', [ 'label' => esc_html__( 'Image', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => Utils::get_placeholder_image_src() ] ] );
		$repeater->add_control( 'image_alt', [ 'label' => esc_html__( 'Image Alt Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Spa series image' ] );
		$this->add_control( 'gallery_slides', [ 'label' => esc_html__( 'Gallery Slides', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'title_field' => '{{{ image_alt }}}', 'default' => [ [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => 'Gallery Slide 1' ], [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => 'Gallery Slide 2' ], [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => 'Gallery Slide 3' ] ] ] );
		$this->end_controls_section();

		$this->register_complete_style_controls();
		$this->register_responsive_style_controls();
	}

	private function register_complete_style_controls() {
		$this->start_controls_section( 'style_layout', [ 'label' => esc_html__( 'Layout', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'layout_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider, {{WRAPPER}} .phtf-series-slider__content' => 'background-color: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'layout_content_width', [ 'label' => esc_html__( 'Desktop Content Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ '%' ], 'range' => [ '%' => [ 'min' => 30, 'max' => 65 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider' => '--phtf-series-content-width: {{SIZE}}%;' ] ] );
		$this->add_responsive_control( 'layout_content_padding', [ 'label' => esc_html__( 'Content Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'layout_radius', [ 'label' => esc_html__( 'Container Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'layout_border', 'selector' => '{{WRAPPER}} .phtf-series-slider' ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'layout_shadow', 'selector' => '{{WRAPPER}} .phtf-series-slider' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_breadcrumb', [ 'label' => esc_html__( 'Breadcrumb', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'breadcrumb_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__breadcrumb' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'breadcrumb_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__breadcrumb' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'breadcrumb_link_color', [ 'label' => esc_html__( 'Link Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__breadcrumb-item a' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'breadcrumb_link_hover_color', [ 'label' => esc_html__( 'Link Hover Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__breadcrumb-item a:hover, {{WRAPPER}} .phtf-series-slider__breadcrumb-item a:focus' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'breadcrumb_separator_color', [ 'label' => esc_html__( 'Separator Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__breadcrumb-separator' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'breadcrumb_typography', 'selector' => '{{WRAPPER}} .phtf-series-slider__breadcrumb' ] );
		$this->add_responsive_control( 'breadcrumb_gap', [ 'label' => esc_html__( 'Item Gap', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__breadcrumb' => 'gap: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'breadcrumb_margin', [ 'label' => esc_html__( 'Margin', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__breadcrumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'breadcrumb_padding', [ 'label' => esc_html__( 'Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__breadcrumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_title', [ 'label' => esc_html__( 'Title', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'title_color', [ 'label' => esc_html__( 'Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__title' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .phtf-series-slider__title' ] );
		$this->add_responsive_control( 'title_margin', [ 'label' => esc_html__( 'Margin', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'title_padding', [ 'label' => esc_html__( 'Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_reviews', [ 'label' => esc_html__( 'Reviews', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'reviews_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__reviews' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'reviews_hover_color', [ 'label' => esc_html__( 'Hover Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__reviews:hover, {{WRAPPER}} .phtf-series-slider__reviews:focus' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'reviews_stars_color', [ 'label' => esc_html__( 'Stars Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__reviews span' => 'color: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'reviews_stars_size', [ 'label' => esc_html__( 'Star Icon Size', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'em', 'rem' ], 'range' => [ 'px' => [ 'min' => 8, 'max' => 60 ], 'em' => [ 'min' => 0.5, 'max' => 4, 'step' => 0.05 ], 'rem' => [ 'min' => 0.5, 'max' => 4, 'step' => 0.05 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__reviews span' => 'font-size: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'reviews_typography', 'selector' => '{{WRAPPER}} .phtf-series-slider__reviews' ] );
		$this->add_responsive_control( 'reviews_padding', [ 'label' => esc_html__( 'Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__reviews' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_description', [ 'label' => esc_html__( 'Description', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'description_color', [ 'label' => esc_html__( 'Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__description' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .phtf-series-slider__description' ] );
		$this->add_responsive_control( 'description_width', [ 'label' => esc_html__( 'Maximum Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', '%' ], 'range' => [ 'px' => [ 'min' => 200, 'max' => 900 ], '%' => [ 'min' => 30, 'max' => 100 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__description' => 'max-width: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'description_margin', [ 'label' => esc_html__( 'Margin', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'description_padding', [ 'label' => esc_html__( 'Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_buttons', [ 'label' => esc_html__( 'Buttons Shared Layout', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'buttons_typography', 'selector' => '{{WRAPPER}} .phtf-series-slider__button' ] );
		$this->add_responsive_control( 'buttons_gap', [ 'label' => esc_html__( 'Button Gap', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__actions' => 'gap: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'buttons_padding', [ 'label' => esc_html__( 'Button Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'buttons_radius', [ 'label' => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'actions_padding', [ 'label' => esc_html__( 'Button Row Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__actions' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->start_controls_tabs( 'button_style_tabs' );
		$this->start_controls_tab( 'button_primary_tab', [ 'label' => esc_html__( 'Primary', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'primary_text_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--solid' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'primary_background', [ 'label' => esc_html__( 'Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--solid' => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ] ] );
		$this->add_control( 'primary_hover_text_color', [ 'label' => esc_html__( 'Hover Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--solid:hover, {{WRAPPER}} .phtf-series-slider__button--solid:focus' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'primary_hover_background', [ 'label' => esc_html__( 'Hover Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--solid:hover, {{WRAPPER}} .phtf-series-slider__button--solid:focus' => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->start_controls_tab( 'button_secondary_tab', [ 'label' => esc_html__( 'Secondary', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'secondary_text_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--outline' => 'color: {{VALUE}}; border-color: {{VALUE}};' ] ] );
		$this->add_control( 'secondary_background', [ 'label' => esc_html__( 'Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--outline' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'secondary_hover_text_color', [ 'label' => esc_html__( 'Hover Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--outline:hover, {{WRAPPER}} .phtf-series-slider__button--outline:focus' => 'color: {{VALUE}}; border-color: {{VALUE}};' ] ] );
		$this->add_control( 'secondary_hover_background', [ 'label' => esc_html__( 'Hover Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--outline:hover, {{WRAPPER}} .phtf-series-slider__button--outline:focus' => 'background-color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section( 'style_primary_button', [ 'label' => esc_html__( 'Primary Button', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'primary_individual_typography', 'selector' => '{{WRAPPER}} .phtf-series-slider__button--solid' ] );
		$this->add_responsive_control( 'primary_individual_padding', [ 'label' => esc_html__( 'Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--solid' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'primary_individual_radius', [ 'label' => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--solid' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'primary_individual_min_height', [ 'label' => esc_html__( 'Minimum Height', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 24, 'max' => 100 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--solid' => 'min-height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'primary_individual_border', 'selector' => '{{WRAPPER}} .phtf-series-slider__button--solid' ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'primary_individual_shadow', 'selector' => '{{WRAPPER}} .phtf-series-slider__button--solid' ] );
		$this->start_controls_tabs( 'primary_individual_tabs' );
		$this->start_controls_tab( 'primary_individual_normal', [ 'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'primary_individual_text', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--solid' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'primary_individual_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--solid' => 'background-color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->start_controls_tab( 'primary_individual_hover', [ 'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'primary_individual_hover_text', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--solid:hover, {{WRAPPER}} .phtf-series-slider__button--solid:focus' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'primary_individual_hover_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--solid:hover, {{WRAPPER}} .phtf-series-slider__button--solid:focus' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'primary_individual_hover_border', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--solid:hover, {{WRAPPER}} .phtf-series-slider__button--solid:focus' => 'border-color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section( 'style_secondary_button', [ 'label' => esc_html__( 'Secondary Button', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'secondary_individual_typography', 'selector' => '{{WRAPPER}} .phtf-series-slider__button--outline' ] );
		$this->add_responsive_control( 'secondary_individual_padding', [ 'label' => esc_html__( 'Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--outline' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'secondary_individual_radius', [ 'label' => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--outline' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'secondary_individual_min_height', [ 'label' => esc_html__( 'Minimum Height', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 24, 'max' => 100 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--outline' => 'min-height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'secondary_individual_border', 'selector' => '{{WRAPPER}} .phtf-series-slider__button--outline' ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'secondary_individual_shadow', 'selector' => '{{WRAPPER}} .phtf-series-slider__button--outline' ] );
		$this->start_controls_tabs( 'secondary_individual_tabs' );
		$this->start_controls_tab( 'secondary_individual_normal', [ 'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'secondary_individual_text', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--outline' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'secondary_individual_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--outline' => 'background-color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->start_controls_tab( 'secondary_individual_hover', [ 'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'secondary_individual_hover_text', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--outline:hover, {{WRAPPER}} .phtf-series-slider__button--outline:focus' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'secondary_individual_hover_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--outline:hover, {{WRAPPER}} .phtf-series-slider__button--outline:focus' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'secondary_individual_hover_border', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__button--outline:hover, {{WRAPPER}} .phtf-series-slider__button--outline:focus' => 'border-color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section( 'style_gallery', [ 'label' => esc_html__( 'Gallery & Curve', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'gallery_background', [ 'label' => esc_html__( 'Gallery Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__gallery' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'gallery_size_heading', [ 'label' => esc_html__( 'Gallery Size & Image', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );
		$this->add_responsive_control( 'responsive_gallery_width', [ 'label' => esc_html__( 'Gallery Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ '%', 'px', 'vw' ], 'range' => [ '%' => [ 'min' => 20, 'max' => 100 ], 'px' => [ 'min' => 240, 'max' => 1600 ], 'vw' => [ 'min' => 20, 'max' => 100 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__gallery' => 'width: {{SIZE}}{{UNIT}}; max-width: 100%;' ] ] );
		$this->add_responsive_control( 'responsive_gallery_height', [ 'label' => esc_html__( 'Gallery Height', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'vh' ], 'range' => [ 'px' => [ 'min' => 240, 'max' => 900 ], 'vh' => [ 'min' => 25, 'max' => 100 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__gallery' => '--phtf-series-gallery-height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'gallery_horizontal_align', [ 'label' => esc_html__( 'Horizontal Alignment', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SELECT, 'options' => [ 'start' => esc_html__( 'Start', 'perfect-hot-tub-finder' ), 'center' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'end' => esc_html__( 'End', 'perfect-hot-tub-finder' ), 'stretch' => esc_html__( 'Stretch', 'perfect-hot-tub-finder' ) ], 'default' => 'stretch', 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__gallery' => 'justify-self: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'gallery_image_position', [ 'label' => esc_html__( 'Image Position', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SELECT, 'options' => [ 'center center' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'center top' => esc_html__( 'Top', 'perfect-hot-tub-finder' ), 'center bottom' => esc_html__( 'Bottom', 'perfect-hot-tub-finder' ), 'left center' => esc_html__( 'Left', 'perfect-hot-tub-finder' ), 'right center' => esc_html__( 'Right', 'perfect-hot-tub-finder' ) ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__image' => 'object-position: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'gallery_radius', [ 'label' => esc_html__( 'Gallery Border Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__gallery' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'gallery_border', 'selector' => '{{WRAPPER}} .phtf-series-slider__gallery' ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'gallery_shadow', 'selector' => '{{WRAPPER}} .phtf-series-slider__gallery' ] );
		$this->add_control( 'curve_color', [ 'label' => esc_html__( 'Curve Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider' => '--phtf-series-curve-color: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'desktop_curve_width', [ 'label' => esc_html__( 'Desktop Curve Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 40, 'max' => 320 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider' => '--phtf-series-desktop-curve-width: {{SIZE}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_navigation', [ 'label' => esc_html__( 'Arrows & Thumbnails', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'arrow_color', [ 'label' => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__arrow' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_background', [ 'label' => esc_html__( 'Arrow Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__arrow' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_hover_color', [ 'label' => esc_html__( 'Arrow Hover Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__arrow:hover, {{WRAPPER}} .phtf-series-slider__arrow:focus' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_hover_background', [ 'label' => esc_html__( 'Arrow Hover Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__arrow:hover, {{WRAPPER}} .phtf-series-slider__arrow:focus' => 'background-color: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'arrow_icon_size', [ 'label' => esc_html__( 'Arrow Icon Size', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'em', 'rem' ], 'range' => [ 'px' => [ 'min' => 8, 'max' => 70 ], 'em' => [ 'min' => 0.5, 'max' => 4, 'step' => 0.05 ], 'rem' => [ 'min' => 0.5, 'max' => 4, 'step' => 0.05 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__arrow' => 'font-size: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'navigation_bottom', [ 'label' => esc_html__( 'Desktop Bottom Offset', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 180 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider' => '--phtf-series-controls-bottom: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'mobile_navigation_top', [ 'label' => esc_html__( 'Mobile Vertical Position', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ '%' ], 'range' => [ '%' => [ 'min' => 10, 'max' => 90 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider' => '--phtf-series-controls-top: {{SIZE}}%;' ] ] );
		$this->add_responsive_control( 'thumbnail_size', [ 'label' => esc_html__( 'Thumbnail Size', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 30, 'max' => 120 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__thumb' => 'flex-basis: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'thumbnail_gap', [ 'label' => esc_html__( 'Thumbnail Gap', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__thumbs' => 'gap: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_control( 'thumbnail_border_color', [ 'label' => esc_html__( 'Active Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__thumb.is-active' => 'border-color: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'thumbnail_radius', [ 'label' => esc_html__( 'Thumbnail Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_control( 'thumbnail_strip_background', [ 'label' => esc_html__( 'Thumbnail Strip Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__thumbs' => 'background-color: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'thumbnail_strip_padding', [ 'label' => esc_html__( 'Thumbnail Strip Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__thumbs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'thumbnail_strip_radius', [ 'label' => esc_html__( 'Thumbnail Strip Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__thumbs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_control( 'thumbnail_background', [ 'label' => esc_html__( 'Thumbnail Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__thumb' => 'background-color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'thumbnail_border', 'selector' => '{{WRAPPER}} .phtf-series-slider__thumb' ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'thumbnail_shadow', 'selector' => '{{WRAPPER}} .phtf-series-slider__thumb' ] );
		$this->add_control( 'thumbnail_image_fit', [ 'label' => esc_html__( 'Thumbnail Image Fit', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SELECT, 'options' => [ 'cover' => esc_html__( 'Cover', 'perfect-hot-tub-finder' ), 'contain' => esc_html__( 'Contain', 'perfect-hot-tub-finder' ), 'fill' => esc_html__( 'Fill', 'perfect-hot-tub-finder' ) ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__thumb img' => 'object-fit: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'thumbnail_opacity', [ 'label' => esc_html__( 'Inactive Opacity', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__thumb:not(.is-active)' => 'opacity: {{SIZE}};' ] ] );
		$this->add_responsive_control( 'thumbnail_active_opacity', [ 'label' => esc_html__( 'Active Opacity', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__thumb.is-active' => 'opacity: {{SIZE}};' ] ] );
		$this->add_control( 'thumbnail_hover_border_color', [ 'label' => esc_html__( 'Hover Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__thumb:hover, {{WRAPPER}} .phtf-series-slider__thumb:focus' => 'border-color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'thumbnail_active_shadow', 'selector' => '{{WRAPPER}} .phtf-series-slider__thumb.is-active' ] );
		$this->end_controls_section();
	}

	private function register_responsive_style_controls() {
		$this->start_controls_section( 'responsive_layout', [ 'label' => esc_html__( 'Responsive Layout', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_responsive_control( 'responsive_content_padding', [ 'label' => esc_html__( 'Content Side Spacing', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'vw' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ], 'vw' => [ 'min' => 0, 'max' => 15 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__title, {{WRAPPER}} .phtf-series-slider__reviews, {{WRAPPER}} .phtf-series-slider__description, {{WRAPPER}} .phtf-series-slider__actions' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'responsive_title_size', [ 'label' => esc_html__( 'Title Size', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'em', 'rem' ], 'range' => [ 'px' => [ 'min' => 24, 'max' => 80 ], 'em' => [ 'min' => 1.2, 'max' => 5 ], 'rem' => [ 'min' => 1.2, 'max' => 5 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__title' => 'font-size: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'responsive_arrow_size', [ 'label' => esc_html__( 'Arrow Button Size', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 28, 'max' => 90 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'responsive_curve_height', [ 'label' => esc_html__( 'Mobile Curve Height', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 70, 'max' => 220 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-series-slider__gallery' => '--phtf-series-mobile-curve-height: {{SIZE}}{{UNIT}};' ] ] );
		$this->end_controls_section();
	}

	private function link( $link ) {
		if ( empty( $link['url'] ) ) { return ''; }
		$rel = array_filter( [ ! empty( $link['is_external'] ) ? 'noopener noreferrer' : '', ! empty( $link['nofollow'] ) ? 'nofollow' : '' ] );
		return sprintf( ' href="%s"%s%s', esc_url( $link['url'] ), ! empty( $link['is_external'] ) ? ' target="_blank"' : '', ! empty( $rel ) ? ' rel="' . esc_attr( implode( ' ', $rel ) ) . '"' : '' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$gallery_slides = $s['gallery_slides'] ?? [];
		$slides = $gallery_slides;
		if ( empty( $slides ) ) {
			$slides = [ [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => $s['title'] ?? '' ] ];
		}
		?>
		<section class="phtf-series-slider" data-phtf-series-slider>
			<div class="phtf-series-slider__content">
				<?php
				$breadcrumbs = $s['breadcrumb_items'] ?? [];
				$breadcrumb_title = trim( wp_strip_all_tags( $s['title'] ?? '' ) );
				$last_breadcrumb = end( $breadcrumbs );
				if ( '' !== $breadcrumb_title && $breadcrumb_title !== trim( wp_strip_all_tags( is_array( $last_breadcrumb ) ? ( $last_breadcrumb['label'] ?? '' ) : '' ) ) ) {
					$breadcrumbs[] = [ 'label' => $breadcrumb_title ];
				}
				if ( 'yes' === ( $s['show_header'] ?? 'yes' ) && 'yes' === ( $s['show_breadcrumb'] ?? 'yes' ) && ! empty( $breadcrumbs ) ) :
					?><nav class="phtf-series-slider__breadcrumb" aria-label="Breadcrumb"><?php foreach ( $breadcrumbs as $index => $item ) : $label = trim( (string) ( $item['label'] ?? '' ) ); if ( '' === $label ) { continue; } ?><span class="phtf-series-slider__breadcrumb-item"><?php if ( ! empty( $item['link']['url'] ) ) : ?><a<?php echo $this->link( $item['link'] ); ?>><?php echo esc_html( $label ); ?></a><?php else : ?><?php echo esc_html( $label ); ?><?php endif; ?></span><?php if ( $index < count( $breadcrumbs ) - 1 ) : ?><span class="phtf-series-slider__breadcrumb-separator" aria-hidden="true">&gt;</span><?php endif; ?><?php endforeach; ?></nav><?php endif; ?>
				<h1 class="phtf-series-slider__title"><?php echo wp_kses_post( $s['title'] ); ?></h1>
				<?php if ( $s['reviews'] ) : ?><a class="phtf-series-slider__reviews"<?php echo $this->link( $s['reviews_url'] ); ?>><span aria-hidden="true">★★★★★</span> <?php echo esc_html( $s['reviews'] ); ?></a><?php endif; ?>
				<div class="phtf-series-slider__description"><?php echo wp_kses_post( wpautop( $s['description'] ) ); ?></div>
				<div class="phtf-series-slider__actions"><?php if ( $s['brochure_text'] ) : ?><a class="phtf-series-slider__button phtf-series-slider__button--solid"<?php echo $this->link( $s['brochure_url'] ); ?>><?php echo esc_html( $s['brochure_text'] ); ?></a><?php endif; ?><?php if ( $s['pricing_text'] ) : ?><a class="phtf-series-slider__button phtf-series-slider__button--outline"<?php echo $this->link( $s['pricing_url'] ); ?>><?php echo esc_html( $s['pricing_text'] ); ?></a><?php endif; ?></div>
			</div>
			<div class="phtf-series-slider__gallery">
				<?php foreach ( $slides as $i => $slide ) : $src = $slide['image']['url'] ?? Utils::get_placeholder_image_src(); ?><img class="phtf-series-slider__image<?php echo 0 === $i ? ' is-active' : ''; ?>" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $slide['image_alt'] ?? '' ); ?>"<?php echo 0 === $i ? '' : ' hidden'; ?>><?php endforeach; ?>
				<?php if ( count( $slides ) > 1 ) : ?><div class="phtf-series-slider__controls"><button type="button" class="phtf-series-slider__arrow" data-series-prev aria-label="Previous slide">‹</button><div class="phtf-series-slider__thumbs"><?php foreach ( $slides as $i => $slide ) : $src = $slide['image']['url'] ?? Utils::get_placeholder_image_src(); ?><button type="button" class="phtf-series-slider__thumb<?php echo 0 === $i ? ' is-active' : ''; ?>" data-series-slide="<?php echo esc_attr( $i ); ?>" aria-label="<?php echo esc_attr( sprintf( 'Show slide %d', $i + 1 ) ); ?>" aria-current="<?php echo 0 === $i ? 'true' : 'false'; ?>"><img src="<?php echo esc_url( $src ); ?>" alt=""></button><?php endforeach; ?></div><button type="button" class="phtf-series-slider__arrow" data-series-next aria-label="Next slide">›</button></div><?php endif; ?>
			</div>
		</section>
		<?php
	}
}
