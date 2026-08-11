<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

class PHTF_Reviews_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'phtf_reviews';
	}

	public function get_title() {
		return esc_html__( 'Spa Reviews', 'perfect-hot-tub-finder' );
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'phtf-widgets' ];
	}

	public function get_keywords() {
		return [ 'hot tub', 'spa', 'reviews', 'testimonials', 'slider', 'carousel' ];
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
				'default'     => esc_html__( 'Utopia® Reviews.', 'perfect-hot-tub-finder' ),
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
			'section_reviews',
			[
				'label' => esc_html__( 'Reviews', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'review_text',
			[
				'label'       => esc_html__( 'Review Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => esc_html__( "We LOVE our Caldera hot tub so much that we use it every day. We have noticed we are sleeping better and the aches and pains aren't a daily issue. Also, with the Freshwater Salt system, the amount of maintenance is minimal.", 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'author',
			[
				'label'       => esc_html__( 'Author / Location', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'GENEVA SPA OWNER, OHIO', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'rating',
			[
				'label'   => esc_html__( 'Rating', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 5,
				'step'    => 0.5,
				'default' => 5,
			]
		);

		$this->add_control(
			'reviews',
			[
				'label'       => esc_html__( 'Review Slides', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'review_text' => esc_html__( "We LOVE our Caldera hot tub so much that we use it every day. We have noticed we are sleeping better and the aches and pains aren't a daily issue. Also, with the Freshwater Salt system, the amount of maintenance is minimal. We definitely recommend the Caldera brand and are so happy with our purchase.", 'perfect-hot-tub-finder' ),
						'author'      => esc_html__( 'GENEVA SPA OWNER, OHIO', 'perfect-hot-tub-finder' ),
						'rating'      => 5,
					],
					[
						'review_text' => esc_html__( 'The spa is comfortable, quiet, and easy to maintain. It has become part of our daily routine and a great place to unwind at the end of the day.', 'perfect-hot-tub-finder' ),
						'author'      => esc_html__( 'UTOPIA SPA OWNER', 'perfect-hot-tub-finder' ),
						'rating'      => 5,
					],
					[
						'review_text' => esc_html__( 'We are very happy with the quality and design. The jets feel great, the controls are simple, and the water care has been straightforward.', 'perfect-hot-tub-finder' ),
						'author'      => esc_html__( 'CALDERA SPA OWNER', 'perfect-hot-tub-finder' ),
						'rating'      => 5,
					],
				],
				'title_field' => '{{{ author }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider',
			[
				'label' => esc_html__( 'Slider Options', 'perfect-hot-tub-finder' ),
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
				'label'     => esc_html__( 'Previous Arrow Text/Icon', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '‹',
				'condition' => [ 'show_arrows' => 'yes' ],
			]
		);

		$this->add_control(
			'next_icon',
			[
				'label'     => esc_html__( 'Next Arrow Text/Icon', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '›',
				'condition' => [ 'show_arrows' => 'yes' ],
			]
		);

		$this->add_control(
			'show_dots',
			[
				'label'        => esc_html__( 'Show Dots', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed (ms)', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1000,
				'max'       => 20000,
				'step'      => 500,
				'default'   => 5000,
				'condition' => [ 'autoplay' => 'yes' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'perfect-hot-tub-finder' ),
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
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'     => esc_html__( 'Button Text', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read All Reviews', 'perfect-hot-tub-finder' ),
				'condition' => [ 'show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '⌄',
				'condition' => [ 'show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com/reviews',
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
			'section_padding',
			[
				'label'      => esc_html__( 'Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default'    => [ 'top' => 78, 'right' => 24, 'bottom' => 86, 'left' => 24, 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [ '{{WRAPPER}} .phtf-reviews' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'      => esc_html__( 'Content Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [ 'px' => [ 'min' => 300, 'max' => 1400 ], '%' => [ 'min' => 20, 'max' => 100 ], 'vw' => [ 'min' => 20, 'max' => 100 ] ],
				'default'    => [ 'size' => 900, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-reviews-inner' => 'max-width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'   => esc_html__( 'Alignment', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [ '{{WRAPPER}} .phtf-reviews' => 'text-align: {{VALUE}};' ],
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
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-reviews-title' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .phtf-reviews-title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
				'default'    => [ 'size' => 22, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-reviews-title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_stars_style',
			[
				'label' => esc_html__( 'Stars', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'star_color',
			[
				'label'     => esc_html__( 'Active Star Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-reviews-star.is-full' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'star_inactive_color',
			[
				'label'     => esc_html__( 'Inactive Star Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'default'   => '#D8D8D8',
				'selectors' => [ '{{WRAPPER}} .phtf-reviews-star.is-empty' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_responsive_control(
			'star_size',
			[
				'label'      => esc_html__( 'Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
				'default'    => [ 'size' => 24, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-reviews-stars' => 'font-size: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'stars_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 90 ] ],
				'default'    => [ 'size' => 14, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-reviews-stars' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_review_text_style',
			[
				'label' => esc_html__( 'Review Text', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'review_text_color',
			[
				'label'     => esc_html__( 'Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [ '{{WRAPPER}} .phtf-reviews-text' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'review_text_typography',
				'selector' => '{{WRAPPER}} .phtf-reviews-text',
			]
		);

		$this->add_responsive_control(
			'review_text_width',
			[
				'label'      => esc_html__( 'Text Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [ 'px' => [ 'min' => 300, 'max' => 1200 ], '%' => [ 'min' => 20, 'max' => 100 ], 'vw' => [ 'min' => 20, 'max' => 100 ] ],
				'default'    => [ 'size' => 760, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-reviews-text' => 'max-width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'review_text_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
				'default'    => [ 'size' => 26, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-reviews-text' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_author_style',
			[
				'label' => esc_html__( 'Author', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'author_color',
			[
				'label'     => esc_html__( 'Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [ '{{WRAPPER}} .phtf-reviews-author' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'author_typography',
				'selector' => '{{WRAPPER}} .phtf-reviews-author',
			]
		);

		$this->add_responsive_control(
			'author_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
				'default'    => [ 'size' => 25, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-reviews-author' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_arrows_style',
			[
				'label' => esc_html__( 'Slide Arrows', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'arrow_box_size',
			[
				'label'      => esc_html__( 'Arrow Box Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 20, 'max' => 100 ] ],
				'default'    => [ 'size' => 54, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-reviews-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'arrow_icon_size',
			[
				'label'      => esc_html__( 'Arrow Icon Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 80 ] ],
				'default'    => [ 'size' => 60, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-reviews-arrow' => 'font-size: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'arrow_offset',
			[
				'label'      => esc_html__( 'Side Offset', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [ 'px' => [ 'min' => -150, 'max' => 250 ], '%' => [ 'min' => -15, 'max' => 15 ], 'vw' => [ 'min' => -15, 'max' => 15 ] ],
				'default'    => [ 'size' => -92, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-reviews-prev' => 'left: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .phtf-reviews-next' => 'right: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->start_controls_tabs( 'arrow_state_tabs' );
		$this->start_controls_tab( 'arrow_normal_tab', [ 'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ) ] );

		$this->add_control( 'arrow_color', [ 'label' => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=secondary' ], 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-reviews-arrow' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'selectors' => [ '{{WRAPPER}} .phtf-reviews-arrow' => 'background-color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'arrow_shadow', 'selector' => '{{WRAPPER}} .phtf-reviews-arrow' ] );

		$this->end_controls_tab();
		$this->start_controls_tab( 'arrow_hover_tab', [ 'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ) ] );

		$this->add_control( 'arrow_hover_color', [ 'label' => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-reviews-arrow:hover, {{WRAPPER}} .phtf-reviews-arrow:focus-visible' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_hover_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'selectors' => [ '{{WRAPPER}} .phtf-reviews-arrow:hover, {{WRAPPER}} .phtf-reviews-arrow:focus-visible' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_hover_border_color', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_border' ], 'selectors' => [ '{{WRAPPER}} .phtf-reviews-arrow:hover, {{WRAPPER}} .phtf-reviews-arrow:focus-visible' => 'border-color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'arrow_hover_shadow', 'selector' => '{{WRAPPER}} .phtf-reviews-arrow:hover, {{WRAPPER}} .phtf-reviews-arrow:focus-visible' ] );

		$this->end_controls_tab();
		$this->start_controls_tab( 'arrow_active_tab', [ 'label' => esc_html__( 'Active', 'perfect-hot-tub-finder' ) ] );

		$this->add_control( 'arrow_active_color', [ 'label' => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-reviews-arrow.is-active' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_active_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'selectors' => [ '{{WRAPPER}} .phtf-reviews-arrow.is-active' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'arrow_active_border_color', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_border' ], 'selectors' => [ '{{WRAPPER}} .phtf-reviews-arrow.is-active' => 'border-color: {{VALUE}};' ] ] );

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'arrow_border',
				'selector' => '{{WRAPPER}} .phtf-reviews-arrow',
			]
		);

		$this->add_responsive_control(
			'arrow_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-reviews-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dots_style',
			[
				'label' => esc_html__( 'Dots', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control( 'dot_size', [ 'label' => esc_html__( 'Dot Size', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'em', 'rem' ], 'range' => [ 'px' => [ 'min' => 4, 'max' => 32 ] ], 'default' => [ 'size' => 10, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-reviews-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'dot_gap', [ 'label' => esc_html__( 'Dot Gap', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'em', 'rem' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ], 'default' => [ 'size' => 18, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-reviews-dots' => 'gap: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_control( 'dot_color', [ 'label' => esc_html__( 'Normal Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#DDDDDD', 'selectors' => [ '{{WRAPPER}} .phtf-reviews-dot' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'dot_hover_color', [ 'label' => esc_html__( 'Hover Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=secondary' ], 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-reviews-dot:hover, {{WRAPPER}} .phtf-reviews-dot:focus-visible' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'dot_active_color', [ 'label' => esc_html__( 'Active Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-reviews-dot.is-active' => 'background-color: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'dots_spacing', [ 'label' => esc_html__( 'Bottom Spacing', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'em', 'rem' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ] ], 'default' => [ 'size' => 34, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-reviews-dots' => 'margin-bottom: {{SIZE}}{{UNIT}};' ] ] );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .phtf-reviews-button' ] );
		$this->start_controls_tabs( 'button_state_tabs' );
		$this->start_controls_tab( 'button_normal_tab', [ 'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'button_text_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_white' ], 'default' => '#FFFFFF', 'selectors' => [ '{{WRAPPER}} .phtf-reviews-button' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'button_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=secondary' ], 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-reviews-button' => 'background-color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->start_controls_tab( 'button_hover_tab', [ 'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'button_hover_text_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_white' ], 'default' => '#FFFFFF', 'selectors' => [ '{{WRAPPER}} .phtf-reviews-button:hover, {{WRAPPER}} .phtf-reviews-button:focus-visible' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'button_hover_background', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-reviews-button:hover, {{WRAPPER}} .phtf-reviews-button:focus-visible' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'button_hover_border_color', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_border' ], 'selectors' => [ '{{WRAPPER}} .phtf-reviews-button:hover, {{WRAPPER}} .phtf-reviews-button:focus-visible' => 'border-color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'button_border', 'selector' => '{{WRAPPER}} .phtf-reviews-button' ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'button_shadow', 'selector' => '{{WRAPPER}} .phtf-reviews-button' ] );
		$this->add_responsive_control( 'button_padding', [ 'label' => esc_html__( 'Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em', 'rem' ], 'default' => [ 'top' => 11, 'right' => 18, 'bottom' => 11, 'left' => 18, 'unit' => 'px', 'isLinked' => false ], 'selectors' => [ '{{WRAPPER}} .phtf-reviews-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'button_border_radius', [ 'label' => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%', 'em', 'rem' ], 'default' => [ 'top' => 999, 'right' => 999, 'bottom' => 999, 'left' => 999, 'unit' => 'px', 'isLinked' => true ], 'selectors' => [ '{{WRAPPER}} .phtf-reviews-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );

		$this->end_controls_section();
	}

	private function render_stars( $rating ) {
		$value = floatval( $rating );
		$value = max( 0, min( 5, $value ) );
		$html  = '<span class="screen-reader-text">' . esc_html( $value . ' out of 5 stars' ) . '</span>';

		for ( $i = 1; $i <= 5; $i++ ) {
			$class = $i <= round( $value ) ? 'is-full' : 'is-empty';
			$html .= '<span class="phtf-reviews-star ' . esc_attr( $class ) . '" aria-hidden="true">★</span>';
		}

		return $html;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$reviews  = ! empty( $settings['reviews'] ) && is_array( $settings['reviews'] ) ? $settings['reviews'] : [];
		$autoplay = 'yes' === ( $settings['autoplay'] ?? '' ) ? 'yes' : 'no';
		$speed    = ! empty( $settings['autoplay_speed'] ) ? absint( $settings['autoplay_speed'] ) : 5000;
		?>
		<section class="phtf-reviews" data-phtf-reviews data-phtf-reviews-autoplay="<?php echo esc_attr( $autoplay ); ?>" data-phtf-reviews-speed="<?php echo esc_attr( $speed ); ?>">
			<div class="phtf-reviews-inner">
				<?php if ( 'yes' === ( $settings['show_title'] ?? '' ) && ! empty( $settings['title'] ) ) : ?>
					<?php $tag = in_array( $settings['title_html_tag'], [ 'h1', 'h2', 'h3', 'h4', 'div' ], true ) ? $settings['title_html_tag'] : 'h2'; ?>
					<<?php echo esc_attr( $tag ); ?> class="phtf-reviews-title"><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $tag ); ?>>
				<?php endif; ?>

				<div class="phtf-reviews-slider">
					<?php if ( 'yes' === ( $settings['show_arrows'] ?? '' ) && count( $reviews ) > 1 ) : ?>
						<button type="button" class="phtf-reviews-arrow phtf-reviews-prev" data-phtf-reviews-prev aria-label="<?php esc_attr_e( 'Previous review', 'perfect-hot-tub-finder' ); ?>"><?php echo esc_html( $settings['prev_icon'] ?? '‹' ); ?></button>
					<?php endif; ?>

					<div class="phtf-reviews-track" data-phtf-reviews-track>
						<?php foreach ( $reviews as $index => $review ) : ?>
							<article class="phtf-reviews-slide <?php echo 0 === $index ? 'is-active' : ''; ?>" data-phtf-reviews-slide <?php echo 0 === $index ? '' : 'hidden'; ?>>
								<div class="phtf-reviews-stars"><?php echo $this->render_stars( $review['rating'] ?? 5 ); ?></div>
								<div class="phtf-reviews-text"><?php echo wp_kses_post( wpautop( $review['review_text'] ?? '' ) ); ?></div>
								<?php if ( ! empty( $review['author'] ) ) : ?>
									<div class="phtf-reviews-author"><?php echo esc_html( $review['author'] ); ?></div>
								<?php endif; ?>
							</article>
						<?php endforeach; ?>
					</div>

					<?php if ( 'yes' === ( $settings['show_arrows'] ?? '' ) && count( $reviews ) > 1 ) : ?>
						<button type="button" class="phtf-reviews-arrow phtf-reviews-next" data-phtf-reviews-next aria-label="<?php esc_attr_e( 'Next review', 'perfect-hot-tub-finder' ); ?>"><?php echo esc_html( $settings['next_icon'] ?? '›' ); ?></button>
					<?php endif; ?>
				</div>

				<?php if ( 'yes' === ( $settings['show_dots'] ?? '' ) && count( $reviews ) > 1 ) : ?>
					<div class="phtf-reviews-dots" data-phtf-reviews-dots>
						<?php foreach ( $reviews as $index => $review ) : ?>
							<button type="button" class="phtf-reviews-dot <?php echo 0 === $index ? 'is-active' : ''; ?>" data-phtf-reviews-dot="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Go to review %d', 'perfect-hot-tub-finder' ), $index + 1 ) ); ?>"></button>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( 'yes' === ( $settings['show_button'] ?? '' ) && ! empty( $settings['button_text'] ) ) : ?>
					<?php
					$link       = $settings['button_link'] ?? [];
					$href       = ! empty( $link['url'] ) ? $link['url'] : '#';
					$target     = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
					$rel        = array_filter( [ ! empty( $link['is_external'] ) ? 'noopener noreferrer' : '', ! empty( $link['nofollow'] ) ? 'nofollow' : '' ] );
					$nofollow   = ! empty( $rel ) ? ' rel="' . esc_attr( implode( ' ', $rel ) ) . '"' : '';
					$button_tag = ! empty( $link['url'] ) ? 'a' : 'button';
					?>
					<<?php echo esc_attr( $button_tag ); ?> class="phtf-reviews-button" <?php echo 'a' === $button_tag ? 'href="' . esc_url( $href ) . '"' . $target . $nofollow : 'type="button"'; ?>>
						<span><?php echo esc_html( $settings['button_text'] ); ?></span>
						<?php if ( ! empty( $settings['button_icon'] ) ) : ?>
							<span class="phtf-reviews-button-icon" aria-hidden="true"><?php echo esc_html( $settings['button_icon'] ); ?></span>
						<?php endif; ?>
					</<?php echo esc_attr( $button_tag ); ?>>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
