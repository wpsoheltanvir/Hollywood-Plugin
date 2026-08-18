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

class PHTF_Spa_Model_Specifications_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'phtf_spa_model_specifications';
	}

	public function get_title() {
		return esc_html__( 'Spa Model Specifications', 'perfect-hot-tub-finder' );
	}

	public function get_icon() {
		return 'eicon-table';
	}

	public function get_categories() {
		return [ 'phtf-widgets' ];
	}

	public function get_keywords() {
		return [ 'hot tub', 'spa', 'model', 'specifications', 'specs', 'cantabria' ];
	}

	public function get_style_depends() {
		return [ 'phtf-hot-tub-finder' ];
	}

	protected function register_controls() {
		$this->register_source_controls();
		$this->register_content_controls();
		$this->register_style_controls();
	}

	private function register_source_controls() {
		$model_options = [ '0' => esc_html__( 'Auto: First Spa Model', 'perfect-hot-tub-finder' ) ];
		if ( function_exists( 'phtf_get_spa_models' ) ) {
			foreach ( phtf_get_spa_models() as $model ) {
				$model_options[ (string) ( $model['id'] ?? 0 ) ] = $model['title'] ?? esc_html__( 'Untitled Spa Model', 'perfect-hot-tub-finder' );
			}
		}

		$this->start_controls_section(
			'section_data_source',
			[
				'label' => esc_html__( 'Spa Model Data Source', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'data_source',
			[
				'label'   => esc_html__( 'Content Source', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'spa_model',
				'options' => [
					'spa_model' => esc_html__( 'Spa Model (Dynamic)', 'perfect-hot-tub-finder' ),
					'manual'    => esc_html__( 'Manual Widget Content', 'perfect-hot-tub-finder' ),
				],
			]
		);

		$this->add_control(
			'spa_model_id',
			[
				'label'       => esc_html__( 'Spa Model', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => $model_options,
				'description' => esc_html__( 'Select the Spa Model whose image, title, specifications, and owner manual should be shown.', 'perfect-hot-tub-finder' ),
				'condition'   => [ 'data_source' => 'spa_model' ],
			]
		);

		$this->end_controls_section();
	}

	private function default_left_rows() {
		return [
			[ 'row_label' => 'Seating<br>Capacity', 'row_value' => '8 Adults' ],
			[ 'row_label' => 'Dimensions', 'row_value' => '9\' x 7\'7" x 38" / 274cm x 231cm x 97cm' ],
			[ 'row_label' => 'Water Capacity', 'row_value' => '615 gallons / 2325 liters' ],
			[ 'row_label' => 'Weight (dry)', 'row_value' => '1310 lbs. / 595 kg' ],
			[ 'row_label' => 'Weight (filled)', 'row_value' => '7840 lbs. / 3560 kg' ],
			[ 'row_label' => 'Jet Count', 'row_value' => '74 Total Jets' ],
			[ 'row_label' => 'Jets', 'row_value' => '1 Atlas<sup>®</sup> Neck Massage<br>56 Euro<br>7 VersaSage<sup>®</sup><br>4 AdaptaSage<sup>®</sup><br>4 Euro-Pulse<sup>®</sup><br>2 OrbiSsage<sup>®</sup><br>1 Euphoria<sup>®</sup>' ],
			[ 'row_label' => 'Water Care<br>Systems', 'row_value' => 'FreshWater<sup>®</sup> IQ Ready Salt + Smart Monitoring Included | Dosing Optional' ],
			[ 'row_label' => 'Ultramasseuse<br>System', 'row_value' => '6 Jetting Sequences; 3 Speeds' ],
			[ 'row_label' => 'Jet Pump(s)', 'row_value' => '3 ReliaFlo<sup>®</sup> Pumps;<br>2 Dual-Speed 2.5 HP (5.2BHP)<br>1 Single-Speed 2.5HP (5.2 BHP)' ],
			[ 'row_label' => 'Control System', 'row_value' => 'Advent<sup>®</sup> LCD Touchscreen Control with Auxiliary panel & UltraMasseuse Panel' ],
			[ 'row_label' => 'Circulation<br>Pump', 'row_value' => 'EnergyPro<sup>®</sup> Circulation Pump' ],
			[ 'row_label' => 'Heater Output', 'row_value' => 'EnergyPro<sup>®</sup> Heater (4,000 Watts)' ],
			[ 'row_label' => 'Electrical<br>Requirements', 'row_value' => '230v/50 amp or 70 amp' ],
			[ 'row_label' => 'Gfci Sub-panel', 'row_value' => 'GFCI Sub-panel (50 amp) included' ],
			[ 'row_label' => 'Filter Size', 'row_value' => '100 sq. ft. filter' ],
			[ 'row_label' => 'Ozone System', 'row_value' => '(Optional) Corona Discharge Ozone. Not compatible with the FreshWater IQ System.' ],
			[ 'row_label' => 'Water Feature', 'row_value' => '2 Acquarella<sup>®</sup> Waterfalls with LED lighting' ],
			[ 'row_label' => 'Multi-color Led<br>Lighting', 'row_value' => 'SpaGlo<sup>®</sup> Multi-Zone LED Lighting including 7 Points-of-Interior Lights & Exterior Light Bar' ],
			[ 'row_label' => 'Energy<br>Efficiency', 'row_value' => 'Fully-insulated with FiberCor<sup>®</sup> material, 2 lb. density, CEC-compliant' ],
		];
	}

	private function default_right_rows() {
		return [
			[ 'row_label' => 'Branding', 'row_value' => 'Large acrylic logo plate with On/Ready indicator light' ],
			[ 'row_label' => 'Bottom Seal', 'row_value' => 'ABS Base Pan' ],
			[ 'row_label' => 'Insulating Cover', 'row_value' => 'WeatherPro™ 4” tapered custom fit with hinge seal' ],
			[ 'row_label' => 'Spa Shell<br>Options', 'row_value' => 'White Pearl, Platinum, Tuscan Sun, Arctic White, Midnight Canyon' ],
			[ 'row_label' => 'Cabinet Type', 'row_value' => 'EcoTech<sup>®</sup> Plus' ],
			[ 'row_label' => 'Cabinet & Step<br>Colors', 'row_value' => 'Java, Ash & Parchment' ],
			[ 'row_label' => 'Cover Lifter', 'row_value' => '(Included) ProLift<sup>®</sup> III Cover Lifter' ],
			[ 'row_label' => 'Cover Colors', 'row_value' => 'Storm, Chestnut, Black' ],
			[ 'row_label' => 'Cover Design', 'row_value' => 'Curved front skirt' ],
			[ 'row_label' => 'Music System', 'row_value' => '(Optional) Wireless Audio System with Wireless Technology; Subwoofer; 22” HD Wireless Monitor (each sold separately)' ],
			[ 'row_label' => 'Entertainment<br>System', 'row_value' => '(Optional) 22” HD Wireless Monitor' ],
			[ 'row_label' => 'Step Type', 'row_value' => '(Optional) Utopia<sup>®</sup> Step in Java, Ash & Parchment' ],
			[ 'row_label' => 'Smart Spa<br>Technology', 'row_value' => '(Optional) Caldera Spas App, Powered by the Connected Spa Kit' ],
		];
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
				'default'     => 'Cantabria<sup>®</sup> Specifications.',
				'label_block' => true,
				'condition'   => [ 'show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h2',
				'options'   => [
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
			'section_image',
			[
				'label' => esc_html__( 'Product Diagram Image', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_image',
			[
				'label'        => esc_html__( 'Show Image', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'spec_image',
			[
				'label'     => esc_html__( 'Image', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [ 'url' => phtf_get_fallback_image_url( 'widget' ) ],
				'condition' => [ 'show_image' => 'yes' ],
			]
		);

		$this->add_control(
			'show_dimension_labels',
			[
				'label'        => esc_html__( 'Show Dimension Labels', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_image' => 'yes' ],
			]
		);

		$this->add_control(
			'vertical_dimension',
			[
				'label'       => esc_html__( 'Vertical Dimension Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '7\'7"',
				'label_block' => true,
				'condition'   => [ 'show_image' => 'yes', 'show_dimension_labels' => 'yes' ],
			]
		);

		$this->add_control(
			'horizontal_dimension',
			[
				'label'       => esc_html__( 'Horizontal Dimension Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '9\'',
				'label_block' => true,
				'condition'   => [ 'show_image' => 'yes', 'show_dimension_labels' => 'yes' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_left_specs',
			[
				'label' => esc_html__( 'Left Specifications', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$left_rows = new Repeater();
		$left_rows->add_control(
			'row_label',
			[
				'label'       => esc_html__( 'Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => 'Seating Capacity',
				'label_block' => true,
			]
		);
		$left_rows->add_control(
			'row_value',
			[
				'label'       => esc_html__( 'Value', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '8 Adults',
				'label_block' => true,
			]
		);
		$this->add_control(
			'left_rows',
			[
				'label'       => esc_html__( 'Rows', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $left_rows->get_controls(),
				'title_field' => '{{{ row_label }}}',
				'default'     => $this->default_left_rows(),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_right_specs',
			[
				'label' => esc_html__( 'Right Specifications', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$right_rows = new Repeater();
		$right_rows->add_control(
			'row_label',
			[
				'label'       => esc_html__( 'Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => 'Branding',
				'label_block' => true,
			]
		);
		$right_rows->add_control(
			'row_value',
			[
				'label'       => esc_html__( 'Value', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => 'Large acrylic logo plate with On/Ready indicator light',
				'label_block' => true,
			]
		);
		$this->add_control(
			'right_rows',
			[
				'label'       => esc_html__( 'Rows', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $right_rows->get_controls(),
				'title_field' => '{{{ row_label }}}',
				'default'     => $this->default_right_rows(),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_actions',
			[
				'label' => esc_html__( 'Footer / Buttons', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_minimize_button',
			[
				'label'        => esc_html__( 'Show Minimize Button', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'minimize_text',
			[
				'label'       => esc_html__( 'Minimize Button Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Minimize Specs',
				'label_block' => true,
				'condition'   => [ 'show_minimize_button' => 'yes' ],
			]
		);
		$this->add_control(
			'minimize_icon',
			[
				'label'       => esc_html__( 'Minimize Icon', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '^',
				'label_block' => true,
				'condition'   => [ 'show_minimize_button' => 'yes' ],
			]
		);
		$this->add_control(
			'show_manual',
			[
				'label'        => esc_html__( 'Show Owner Manual Area', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'manual_note',
			[
				'label'       => esc_html__( 'Manual Note', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Looking for more information on this model?',
				'label_block' => true,
				'condition'   => [ 'show_manual' => 'yes' ],
			]
		);
		$this->add_control(
			'manual_button_text',
			[
				'label'       => esc_html__( 'Manual Button Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => "Owner's Manual",
				'label_block' => true,
				'condition'   => [ 'show_manual' => 'yes' ],
			]
		);
		$this->add_control(
			'manual_button_link',
			[
				'label'     => esc_html__( 'Manual Button Link', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::URL,
				'default'   => [ 'url' => '#' ],
				'condition' => [ 'show_manual' => 'yes' ],
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
				'label'      => esc_html__( 'Section Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [ 'top' => 44, 'right' => 40, 'bottom' => 44, 'left' => 40, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			'content_width',
			[
				'label'      => esc_html__( 'Content Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 320, 'max' => 1600 ], '%' => [ 'min' => 20, 'max' => 100 ] ],
				'default'    => [ 'size' => 1120, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-inner' => 'max-width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			'columns_gap',
			[
				'label'      => esc_html__( 'Column Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 140 ], 'em' => [ 'min' => 0, 'max' => 10 ] ],
				'default'    => [ 'size' => 34, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-grid' => 'gap: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			'top_grid_margin',
			[
				'label'      => esc_html__( 'Space After Title', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ], 'em' => [ 'min' => 0, 'max' => 8 ] ],
				'default'    => [ 'size' => 26, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-grid' => 'margin-top: {{SIZE}}{{UNIT}};' ],
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
				'label'     => esc_html__( 'Title Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-specs-title' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .phtf-specs-title',
			]
		);
		$this->add_responsive_control(
			'title_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'left',
				'selectors' => [ '{{WRAPPER}} .phtf-specs-title' => 'text-align: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_rows_style',
			[
				'label' => esc_html__( 'Specification Rows', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'row_background',
			[
				'label'     => esc_html__( 'Row Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [ '{{WRAPPER}} .phtf-specs-row' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'row_alt_background',
			[
				'label'     => esc_html__( 'Alternate Row Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#F3F3F3',
				'selectors' => [ '{{WRAPPER}} .phtf-specs-row:nth-child(even)' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_responsive_control(
			'row_padding',
			[
				'label'      => esc_html__( 'Row Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'top' => 16, 'right' => 18, 'bottom' => 16, 'left' => 18, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			'row_gap',
			[
				'label'      => esc_html__( 'Label / Value Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ], 'em' => [ 'min' => 0, 'max' => 6 ] ],
				'default'    => [ 'size' => 28, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-row' => 'column-gap: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			'label_width',
			[
				'label'      => esc_html__( 'Label Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 70, 'max' => 260 ], '%' => [ 'min' => 20, 'max' => 60 ] ],
				'default'    => [ 'size' => 130, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-row-label' => 'flex-basis: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Label Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-specs-row-label' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .phtf-specs-row-label',
			]
		);
		$this->add_control(
			'value_color',
			[
				'label'     => esc_html__( 'Value Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [ '{{WRAPPER}} .phtf-specs-row-value' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'value_typography',
				'selector' => '{{WRAPPER}} .phtf-specs-row-value',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Diagram Image', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'image_width',
			[
				'label'      => esc_html__( 'Image Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 120, 'max' => 700 ], '%' => [ 'min' => 20, 'max' => 100 ] ],
				'default'    => [ 'size' => 420, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-diagram' => 'max-width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			'image_spacing',
			[
				'label'      => esc_html__( 'Image Bottom Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ], 'em' => [ 'min' => 0, 'max' => 8 ] ],
				'default'    => [ 'size' => 30, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-diagram' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_control(
			'image_fit',
			[
				'label'   => esc_html__( 'Image Fit', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'contain',
				'options' => [
					'contain' => esc_html__( 'Contain', 'perfect-hot-tub-finder' ),
					'cover'   => esc_html__( 'Cover', 'perfect-hot-tub-finder' ),
					'fill'    => esc_html__( 'Fill', 'perfect-hot-tub-finder' ),
				],
				'selectors' => [ '{{WRAPPER}} .phtf-specs-diagram img' => 'object-fit: {{VALUE}};' ],
			]
		);
		$this->add_responsive_control(
			'image_height',
			[
				'label'      => esc_html__( 'Image Height', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'auto' ],
				'range'      => [ 'px' => [ 'min' => 120, 'max' => 600 ] ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-diagram img' => 'height: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .phtf-specs-diagram img',
			]
		);
		$this->add_responsive_control(
			'image_radius',
			[
				'label'      => esc_html__( 'Image Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-diagram img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_shadow',
				'selector' => '{{WRAPPER}} .phtf-specs-diagram img',
			]
		);
		$this->add_control(
			'dimension_label_color',
			[
				'label'     => esc_html__( 'Dimension Label Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#B9B9B9',
				'selectors' => [ '{{WRAPPER}} .phtf-specs-dimension' => 'color: {{VALUE}}; border-color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'dimension_typography',
				'selector' => '{{WRAPPER}} .phtf-specs-dimension',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Footer Buttons', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'footer_top_spacing',
			[
				'label'      => esc_html__( 'Footer Top Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ], 'em' => [ 'min' => 0, 'max' => 8 ] ],
				'default'    => [ 'size' => 24, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-footer' => 'margin-top: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_control(
			'manual_note_color',
			[
				'label'     => esc_html__( 'Manual Note Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [ '{{WRAPPER}} .phtf-specs-manual-note' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'manual_note_typography',
				'selector' => '{{WRAPPER}} .phtf-specs-manual-note',
			]
		);
		$this->start_controls_tabs( 'button_tabs' );
		$this->start_controls_tab( 'button_normal', [ 'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ) ] );
		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [ '{{WRAPPER}} .phtf-specs-pill' => 'color: {{VALUE}} !important;' ],
			]
		);
		$this->add_control(
			'button_background',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-specs-pill' => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab( 'button_hover', [ 'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ) ] );
		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [ '{{WRAPPER}} .phtf-specs-pill:hover, {{WRAPPER}} .phtf-specs-pill:focus-visible' => 'color: {{VALUE}} !important;' ],
			]
		);
		$this->add_control(
			'button_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-specs-pill:hover, {{WRAPPER}} .phtf-specs-pill:focus-visible' => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .phtf-specs-pill',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .phtf-specs-pill',
			]
		);
		$this->add_responsive_control(
			'button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => 999, 'right' => 999, 'bottom' => 999, 'left' => 999, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-pill' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'top' => 10, 'right' => 22, 'bottom' => 10, 'left' => 22, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-specs-pill' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .phtf-specs-pill',
			]
		);
		$this->end_controls_section();
	}

	private function allowed_html() {
		return [
			'a'      => [ 'href' => [], 'target' => [], 'rel' => [] ],
			'br'     => [],
			'em'     => [],
			'strong' => [],
			'sup'    => [],
			'sub'    => [],
			'span'   => [ 'class' => [] ],
			'p'      => [],
			'ul'     => [],
			'ol'     => [],
			'li'     => [],
		];
	}

	private function render_link_attrs( $link ) {
		if ( empty( $link['url'] ) ) {
			return '';
		}
		$attrs = 'href="' . esc_url( $link['url'] ) . '"';
		$rel   = [];
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

	private function render_rows( $rows ) {
		if ( empty( $rows ) || ! is_array( $rows ) ) {
			return;
		}
		foreach ( $rows as $row ) :
			?>
			<div class="phtf-specs-row">
				<div class="phtf-specs-row-label"><?php echo wp_kses( $row['row_label'] ?? '', $this->allowed_html() ); ?></div>
				<div class="phtf-specs-row-value"><?php echo wp_kses( $row['row_value'] ?? '', $this->allowed_html() ); ?></div>
			</div>
			<?php
		endforeach;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( 'spa_model' === ( $settings['data_source'] ?? 'spa_model' ) && function_exists( 'phtf_get_spa_model_data' ) && function_exists( 'phtf_get_first_spa_model_data' ) && function_exists( 'phtf_spa_model_spec_rows' ) ) {
			$model_id = absint( $settings['spa_model_id'] ?? 0 );
			$model    = $model_id ? phtf_get_spa_model_data( $model_id ) : phtf_get_first_spa_model_data();
			if ( ! empty( $model ) ) {
				$settings['title'] = ( $model['title'] ?? '' ) . ' ' . __( 'Specifications.', 'perfect-hot-tub-finder' );
				if ( ! empty( $model['image'] ) ) {
					$settings['spec_image'] = [ 'url' => $model['image'] ];
				}
				$spec_rows = phtf_spa_model_spec_rows( $model );
				if ( ! empty( $spec_rows ) ) {
					$half = (int) ceil( count( $spec_rows ) / 2 );
					$settings['left_rows'] = array_slice( $spec_rows, 0, $half );
					$settings['right_rows'] = array_slice( $spec_rows, $half );
				}
				if ( ! empty( $model['owners_manual_url'] ) ) {
					$settings['manual_button_link'] = [ 'url' => $model['owners_manual_url'] ];
				}
			}
		}
		$tag      = ! empty( $settings['title_html_tag'] ) ? $settings['title_html_tag'] : 'h2';
		if ( ! in_array( $tag, [ 'h1', 'h2', 'h3', 'h4', 'div' ], true ) ) {
			$tag = 'h2';
		}
		$image_url = phtf_image_url_or_fallback( ! empty( $settings['spec_image']['url'] ) ? $settings['spec_image']['url'] : '', 'widget' );
		?>
		<section class="phtf-model-specs phtf-specs phtf-specs-v2">
			<div class="phtf-specs-inner">
				<?php if ( 'yes' === ( $settings['show_title'] ?? 'yes' ) && ! empty( $settings['title'] ) ) : ?>
					<<?php echo esc_attr( $tag ); ?> class="phtf-specs-title"><?php echo wp_kses( $settings['title'], $this->allowed_html() ); ?></<?php echo esc_attr( $tag ); ?>>
				<?php endif; ?>

				<div class="phtf-specs-grid">
					<div class="phtf-specs-col phtf-specs-col-left">
						<?php $this->render_rows( $settings['left_rows'] ?? [] ); ?>
					</div>

					<div class="phtf-specs-col phtf-specs-col-right">
						<?php if ( 'yes' === ( $settings['show_image'] ?? 'yes' ) ) : ?>
							<figure class="phtf-specs-diagram">
								<div class="phtf-specs-diagram-frame">
									<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $settings['title'] ?? 'Spa model specifications' ) ); ?>">
									<?php if ( 'yes' === ( $settings['show_dimension_labels'] ?? 'yes' ) ) : ?>
										<span class="phtf-specs-dimension phtf-specs-dimension-y"><?php echo esc_html( $settings['vertical_dimension'] ?? '' ); ?></span>
										<span class="phtf-specs-dimension phtf-specs-dimension-x"><?php echo esc_html( $settings['horizontal_dimension'] ?? '' ); ?></span>
									<?php endif; ?>
								</div>
							</figure>
						<?php endif; ?>
						<?php $this->render_rows( $settings['right_rows'] ?? [] ); ?>
					</div>
				</div>

				<?php if ( 'yes' === ( $settings['show_minimize_button'] ?? 'yes' ) || 'yes' === ( $settings['show_manual'] ?? 'yes' ) ) : ?>
					<div class="phtf-specs-footer">
						<?php if ( 'yes' === ( $settings['show_minimize_button'] ?? 'yes' ) && ! empty( $settings['minimize_text'] ) ) : ?>
							<button type="button" class="phtf-specs-pill phtf-specs-minimize">
								<span><?php echo esc_html( $settings['minimize_text'] ); ?></span>
								<?php if ( ! empty( $settings['minimize_icon'] ) ) : ?><span class="phtf-specs-pill-icon"><?php echo esc_html( $settings['minimize_icon'] ); ?></span><?php endif; ?>
							</button>
						<?php endif; ?>
						<?php if ( 'yes' === ( $settings['show_manual'] ?? 'yes' ) ) : ?>
							<?php if ( ! empty( $settings['manual_note'] ) ) : ?>
								<div class="phtf-specs-manual-note"><?php echo esc_html( $settings['manual_note'] ); ?></div>
							<?php endif; ?>
							<?php if ( ! empty( $settings['manual_button_text'] ) ) : ?>
								<a class="phtf-specs-pill phtf-specs-manual-button" <?php echo $this->render_link_attrs( $settings['manual_button_link'] ?? [] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['manual_button_text'] ); ?></a>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
