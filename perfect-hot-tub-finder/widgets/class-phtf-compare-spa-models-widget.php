<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class PHTF_Compare_Spa_Models_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'phtf_compare_spa_models';
	}

	public function get_title() {
		return esc_html__( 'Hollywood Compare Spa Models', 'perfect-hot-tub-finder' );
	}

	public function get_icon() {
		return 'eicon-table';
	}

	public function get_categories() {
		return [ 'phtf-widgets' ];
	}

	public function get_keywords() {
		return [ 'spa', 'compare', 'models', 'select', 'specifications', 'hot tub' ];
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

	private function get_compare_category_options() {
		if ( function_exists( 'phtf_compare_spa_category_options' ) ) {
			return phtf_compare_spa_category_options();
		}

		return [
			'utopia'   => esc_html__( 'Utopia® Series', 'perfect-hot-tub-finder' ),
			'paradise' => esc_html__( 'Paradise® Series', 'perfect-hot-tub-finder' ),
			'vacanza'  => esc_html__( 'Vacanza® Series', 'perfect-hot-tub-finder' ),
			'fantasy'  => esc_html__( 'Fantasy™ Series', 'perfect-hot-tub-finder' ),
		];
	}

	private function get_model_compare_category_key( $model ) {
		if ( ! empty( $model['compare_category_key'] ) ) {
			return (string) $model['compare_category_key'];
		}

		if ( function_exists( 'phtf_compare_spa_category_key' ) ) {
			return phtf_compare_spa_category_key( $model['compare_category'] ?? '', $model['series'] ?? '', $model['series_display'] ?? '' );
		}

		$lookup = strtolower( wp_strip_all_tags( ( $model['compare_category'] ?? '' ) . ' ' . ( $model['series'] ?? '' ) . ' ' . ( $model['series_display'] ?? '' ) ) );
		if ( false !== strpos( $lookup, 'paradise' ) ) {
			return 'paradise';
		}
		if ( false !== strpos( $lookup, 'vacanza' ) ) {
			return 'vacanza';
		}
		if ( false !== strpos( $lookup, 'fantasy' ) ) {
			return 'fantasy';
		}
		return 'utopia';
	}

	private function filter_models_by_categories( $models, $selected_categories ) {
		if ( ! is_array( $selected_categories ) ) {
			$selected_categories = '' !== (string) $selected_categories ? [ (string) $selected_categories ] : [];
		}

		$selected_categories = array_values( array_filter( array_map( 'strval', $selected_categories ) ) );
		if ( empty( $selected_categories ) ) {
			$selected_categories = array_keys( $this->get_compare_category_options() );
		}

		return array_values( array_filter( (array) $models, function( $model ) use ( $selected_categories ) {
			return in_array( $this->get_model_compare_category_key( $model ), $selected_categories, true );
		} ) );
	}

	private function get_model_options() {
		$options = [ '' => esc_html__( 'Auto Select', 'perfect-hot-tub-finder' ) ];
		if ( function_exists( 'phtf_get_spa_models' ) ) {
			foreach ( phtf_get_spa_models() as $model ) {
				$options[ (string) $model['id'] ] = $model['title'] . ', ' . ( $model['series_display'] ?: $model['series'] );
			}
		}
		return $options;
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
				'default'     => esc_html__( 'Hollywood Compare Spa Models', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'condition'   => [ 'show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => esc_html__( 'Compare Columns', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'2' => esc_html__( '2 Columns', 'perfect-hot-tub-finder' ),
					'3' => esc_html__( '3 Columns', 'perfect-hot-tub-finder' ),
					'4' => esc_html__( '4 Columns', 'perfect-hot-tub-finder' ),
				],
			]
		);

		$this->add_control(
			'compare_categories',
			[
				'label'       => esc_html__( 'Compare Categories', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => $this->get_compare_category_options(),
				'default'     => [ 'utopia', 'paradise', 'vacanza', 'fantasy' ],
				'description' => esc_html__( 'Used only by Compare Spa Models. The select dropdown will be grouped by these categories.', 'perfect-hot-tub-finder' ),
			]
		);

		$options = $this->get_model_options();
		for ( $i = 1; $i <= 4; $i++ ) {
			$this->add_control(
				'default_model_' . $i,
				[
					'label'     => sprintf( esc_html__( 'Default Model Column %d', 'perfect-hot-tub-finder' ), $i ),
					'type'      => Controls_Manager::SELECT,
					'options'   => $options,
					'default'   => '',
					'condition' => [ 'columns!' => (string) ( $i - 1 ) ],
				]
			);
		}

		$this->add_control(
			'auto_select_from_url',
			[
				'label'        => esc_html__( 'Auto Select From URL', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'url_param_name',
			[
				'label'       => esc_html__( 'URL Parameter Name', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'spaID',
				'description' => esc_html__( 'Example: compare page URL with ?spaID=1378 will select the matching Spa Model automatically.', 'perfect-hot-tub-finder' ),
				'condition'   => [ 'auto_select_from_url' => 'yes' ],
			]
		);

		$this->add_control(
			'url_auto_column',
			[
				'label'     => esc_html__( 'URL Auto Select Column', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => [
					'1' => esc_html__( 'Column 1', 'perfect-hot-tub-finder' ),
					'2' => esc_html__( 'Column 2', 'perfect-hot-tub-finder' ),
					'3' => esc_html__( 'Column 3', 'perfect-hot-tub-finder' ),
					'4' => esc_html__( 'Column 4', 'perfect-hot-tub-finder' ),
				],
				'condition' => [ 'auto_select_from_url' => 'yes' ],
			]
		);

		$this->add_control(
			'clear_other_url_columns',
			[
				'label'        => esc_html__( 'Keep Other Columns Empty From URL', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'auto_select_from_url' => 'yes' ],
			]
		);

		$this->add_control(
			'show_selects',
			[
				'label'        => esc_html__( 'Show Select Dropdowns', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_images',
			[
				'label'        => esc_html__( 'Show Model Images', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'empty_message',
			[
				'label'   => esc_html__( 'Empty Message', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Add Spa Models in the WordPress dashboard to use this comparison widget.', 'perfect-hot-tub-finder' ),
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
			'wrapper_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 600, 'max' => 1800 ], '%' => [ 'min' => 50, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 1120 ],
				'selectors'  => [ '{{WRAPPER}} .phtf-compare' => 'max-width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'wrapper_padding',
			[
				'label'      => esc_html__( 'Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-compare' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'label_min_width',
			[
				'label'      => esc_html__( 'Label Column Min Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 80, 'max' => 260 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 190 ],
				'selectors'  => [ '{{WRAPPER}} .phtf-compare-label-cell' => 'min-width: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'model_min_width',
			[
				'label'      => esc_html__( 'Model Column Min Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 180, 'max' => 520 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 300 ],
				'selectors'  => [ '{{WRAPPER}} .phtf-compare-model-cell' => 'min-width: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'cell_padding',
			[
				'label'      => esc_html__( 'Cell Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'top' => 24, 'right' => 18, 'bottom' => 24, 'left' => 18, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-compare-table th, {{WRAPPER}} .phtf-compare-table td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
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
				'selectors' => [ '{{WRAPPER}} .phtf-compare-title' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .phtf-compare-title' ] );
		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [ '{{WRAPPER}} .phtf-compare-title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_select_style',
			[
				'label' => esc_html__( 'Select Dropdowns', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control( 'select_text_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-compare-select' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'select_bg_color', [ 'label' => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_white' ], 'default' => '#ffffff', 'selectors' => [ '{{WRAPPER}} .phtf-compare-select' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'select_border_color', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_border' ], 'default' => '#d9d9d9', 'selectors' => [ '{{WRAPPER}} .phtf-compare-select' => 'border-color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'select_typography', 'selector' => '{{WRAPPER}} .phtf-compare-select' ] );
		$this->add_responsive_control( 'select_padding', [ 'label' => esc_html__( 'Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-compare-select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'select_radius', [ 'label' => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-compare-select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Model Images', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control( 'image_width', [ 'label' => esc_html__( 'Image Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', '%' ], 'range' => [ 'px' => [ 'min' => 80, 'max' => 420 ], '%' => [ 'min' => 20, 'max' => 100 ] ], 'default' => [ 'unit' => 'px', 'size' => 240 ], 'selectors' => [ '{{WRAPPER}} .phtf-compare-image' => 'width: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'image_height', [ 'label' => esc_html__( 'Image Height', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 80, 'max' => 420 ] ], 'default' => [ 'unit' => 'px', 'size' => 180 ], 'selectors' => [ '{{WRAPPER}} .phtf-compare-image' => 'height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_control( 'image_fit', [ 'label' => esc_html__( 'Image Fit', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SELECT, 'default' => 'contain', 'options' => [ 'contain' => esc_html__( 'Contain', 'perfect-hot-tub-finder' ), 'cover' => esc_html__( 'Cover', 'perfect-hot-tub-finder' ), 'fill' => esc_html__( 'Fill', 'perfect-hot-tub-finder' ) ], 'selectors' => [ '{{WRAPPER}} .phtf-compare-image' => 'object-fit: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'image_border', 'selector' => '{{WRAPPER}} .phtf-compare-image' ] );
		$this->add_responsive_control( 'image_radius', [ 'label' => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-compare-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'image_shadow', 'selector' => '{{WRAPPER}} .phtf-compare-image' ] );
		$this->end_controls_section();

		$this->start_controls_section(
			'section_table_style',
			[
				'label' => esc_html__( 'Table', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control( 'label_text_color', [ 'label' => esc_html__( 'Label Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-compare-label-cell' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'cell_text_color', [ 'label' => esc_html__( 'Cell Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=text' ], 'default' => '#7A7A7A', 'selectors' => [ '{{WRAPPER}} .phtf-compare-model-cell' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'alternate_row_color', [ 'label' => esc_html__( 'Alternate Row Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#f4f4f4', 'selectors' => [ '{{WRAPPER}} .phtf-compare-table tbody tr:nth-child(odd) th, {{WRAPPER}} .phtf-compare-table tbody tr:nth-child(odd) td' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'row_bg_color', [ 'label' => esc_html__( 'Even Row Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_white' ], 'default' => '#ffffff', 'selectors' => [ '{{WRAPPER}} .phtf-compare-table tbody tr:nth-child(even) th, {{WRAPPER}} .phtf-compare-table tbody tr:nth-child(even) td' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'border_color', [ 'label' => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=hol_border' ], 'default' => '#d7d7d7', 'selectors' => [ '{{WRAPPER}} .phtf-compare-table th, {{WRAPPER}} .phtf-compare-table td' => 'border-color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'label_typography', 'selector' => '{{WRAPPER}} .phtf-compare-label-cell' ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'cell_typography', 'selector' => '{{WRAPPER}} .phtf-compare-model-cell' ] );
		$this->end_controls_section();
	}

	private function get_spec_rows() {
		$rows = [ 'price' => __( 'Price', 'perfect-hot-tub-finder' ) ];
		if ( function_exists( 'phtf_spa_model_specs_labels' ) ) {
			$rows = array_merge( $rows, phtf_spa_model_specs_labels() );
		}
		return $rows;
	}

	private function resolve_model_id( $models, $lookup_value ) {
		$lookup_value = trim( (string) $lookup_value );
		if ( '' === $lookup_value ) {
			return '';
		}

		foreach ( $models as $model ) {
			$candidates = [
				(string) ( $model['id'] ?? '' ),
				(string) ( $model['spa_id'] ?? '' ),
				(string) ( $model['slug'] ?? '' ),
			];

			foreach ( $candidates as $candidate ) {
				if ( '' !== $candidate && 0 === strcasecmp( $candidate, $lookup_value ) ) {
					return (string) ( $model['id'] ?? '' );
				}
			}
		}

		return '';
	}

	private function get_url_lookup_value( $param_name ) {
		$param_name = trim( (string) $param_name );
		if ( '' === $param_name ) {
			$param_name = 'spaID';
		}

		foreach ( $_GET as $key => $value ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( 0 !== strcasecmp( (string) $key, $param_name ) ) {
				continue;
			}

			if ( is_array( $value ) ) {
				$value = reset( $value );
			}

			return sanitize_text_field( wp_unslash( (string) $value ) );
		}

		return '';
	}

	private function render_options( $models, $selected_id = '' ) {
		$category_options = $this->get_compare_category_options();
		$groups = [];
		foreach ( array_keys( $category_options ) as $key ) {
			$groups[ $key ] = [];
		}

		foreach ( $models as $model ) {
			$key = $this->get_model_compare_category_key( $model );
			if ( ! isset( $groups[ $key ] ) ) {
				continue;
			}
			$groups[ $key ][] = $model;
		}

		echo '<option value="">' . esc_html__( 'Pick a Spa', 'perfect-hot-tub-finder' ) . '</option>';
		foreach ( $groups as $key => $items ) {
			if ( empty( $items ) ) {
				continue;
			}
			echo '<optgroup label="' . esc_attr( $category_options[ $key ] ) . '">';
			foreach ( $items as $model ) {
				$label = $model['title'] . ', ' . ( $model['series_display'] ?: $category_options[ $key ] );
				echo '<option value="' . esc_attr( $model['id'] ) . '" ' . selected( (string) $selected_id, (string) $model['id'], false ) . '>' . esc_html( $label ) . '</option>';
			}
			echo '</optgroup>';
		}
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$models   = function_exists( 'phtf_get_spa_models' ) ? phtf_get_spa_models() : [];
		$models   = $this->filter_models_by_categories( $models, $settings['compare_categories'] ?? [] );

		if ( empty( $models ) ) {
			echo '<div class="phtf-compare phtf-compare-empty">' . esc_html( $settings['empty_message'] ?? '' ) . '</div>';
			return;
		}

		$columns = max( 2, min( 4, (int) ( $settings['columns'] ?? 3 ) ) );
		$default_ids = [];
		for ( $i = 1; $i <= $columns; $i++ ) {
			$default_ids[] = ! empty( $settings[ 'default_model_' . $i ] ) ? (string) $settings[ 'default_model_' . $i ] : '';
		}

		$url_param_name = ! empty( $settings['url_param_name'] ) ? preg_replace( '/[^A-Za-z0-9_\-]/', '', (string) $settings['url_param_name'] ) : 'spaID';
		if ( '' === $url_param_name ) {
			$url_param_name = 'spaID';
		}
		$auto_select_from_url = 'yes' === ( $settings['auto_select_from_url'] ?? 'yes' );
		$url_auto_column = max( 0, min( $columns - 1, (int) ( $settings['url_auto_column'] ?? 1 ) - 1 ) );
		$clear_other_url_columns = 'yes' === ( $settings['clear_other_url_columns'] ?? 'yes' );
		if ( $auto_select_from_url ) {
			$url_model_id = $this->resolve_model_id( $models, $this->get_url_lookup_value( $url_param_name ) );
			if ( '' !== $url_model_id ) {
				if ( $clear_other_url_columns ) {
					$default_ids = array_fill( 0, $columns, '' );
				}
				$default_ids[ $url_auto_column ] = $url_model_id;
			}
		}

		$spec_rows = $this->get_spec_rows();
		$uid = 'phtf-compare-' . $this->get_id();
		?>
		<section id="<?php echo esc_attr( $uid ); ?>" class="phtf-compare" data-phtf-compare data-phtf-compare-auto-url="<?php echo esc_attr( $auto_select_from_url ? 'yes' : 'no' ); ?>" data-phtf-compare-url-param="<?php echo esc_attr( $url_param_name ); ?>" data-phtf-compare-url-column="<?php echo esc_attr( $url_auto_column ); ?>" data-phtf-compare-clear-other-url-columns="<?php echo esc_attr( $clear_other_url_columns ? 'yes' : 'no' ); ?>">
			<script type="application/json" class="phtf-compare-json"><?php echo wp_json_encode( $models, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></script>
			<?php if ( 'yes' === ( $settings['show_title'] ?? 'yes' ) ) : ?>
				<h2 class="phtf-compare-title"><?php echo esc_html( $settings['title'] ?? '' ); ?></h2>
			<?php endif; ?>
			<div class="phtf-compare-scroll">
				<table class="phtf-compare-table" aria-label="<?php echo esc_attr( $settings['title'] ?? __( 'Hollywood Compare Spa Models', 'perfect-hot-tub-finder' ) ); ?>">
					<thead>
						<?php if ( 'yes' === ( $settings['show_selects'] ?? 'yes' ) ) : ?>
							<tr class="phtf-compare-select-row">
								<th class="phtf-compare-label-cell"></th>
								<?php for ( $i = 0; $i < $columns; $i++ ) : ?>
									<td class="phtf-compare-model-cell">
										<select class="phtf-compare-select" data-phtf-compare-select data-phtf-compare-column="<?php echo esc_attr( $i ); ?>">
											<?php $this->render_options( $models, $default_ids[ $i ] ); ?>
										</select>
									</td>
								<?php endfor; ?>
							</tr>
						<?php endif; ?>
						<?php if ( 'yes' === ( $settings['show_images'] ?? 'yes' ) ) : ?>
							<tr class="phtf-compare-image-row">
								<th class="phtf-compare-label-cell"></th>
								<?php for ( $i = 0; $i < $columns; $i++ ) : ?>
									<td class="phtf-compare-model-cell"><img class="phtf-compare-image" data-phtf-compare-image data-phtf-compare-column="<?php echo esc_attr( $i ); ?>" alt="" /></td>
								<?php endfor; ?>
							</tr>
						<?php endif; ?>
					</thead>
					<tbody>
						<?php foreach ( $spec_rows as $key => $label ) : ?>
							<tr>
								<th class="phtf-compare-label-cell"><?php echo esc_html( $label ); ?></th>
								<?php for ( $i = 0; $i < $columns; $i++ ) : ?>
									<td class="phtf-compare-model-cell" data-phtf-compare-spec="<?php echo esc_attr( $key ); ?>" data-phtf-compare-column="<?php echo esc_attr( $i ); ?>"></td>
								<?php endfor; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</section>
		<?php
	}
}
