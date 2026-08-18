<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

/**
 * Dynamic single-model hero with a custom Series Hero gallery.
 *
 * The widget ID is intentionally preserved so existing Elementor pages migrate
 * to the replacement instead of displaying a missing-widget placeholder.
 */
class PHTF_Spa_Model_Slider_Widget extends PHTF_Spa_Series_Slider_Widget {
	public function get_name() { return 'phtf_spa_model_slider'; }
	public function get_title() { return esc_html__( 'Spa Model Single Hero', 'perfect-hot-tub-finder' ); }
	public function get_icon() { return 'eicon-slider-push'; }
	public function get_categories() { return [ 'phtf-widgets' ]; }
	public function get_keywords() { return [ 'spa', 'hot tub', 'single model', 'dynamic', 'hero', 'gallery' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'header', [ 'label' => esc_html__( 'Header / Breadcrumb', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'show_header', [ 'label' => esc_html__( 'Show Header', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Yes', 'perfect-hot-tub-finder' ), 'label_off' => esc_html__( 'No', 'perfect-hot-tub-finder' ), 'return_value' => 'yes', 'default' => 'yes' ] );
		$this->add_control( 'show_breadcrumb', [ 'label' => esc_html__( 'Show Breadcrumb', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Yes', 'perfect-hot-tub-finder' ), 'label_off' => esc_html__( 'No', 'perfect-hot-tub-finder' ), 'return_value' => 'yes', 'default' => 'yes', 'condition' => [ 'show_header' => 'yes' ] ] );
		$breadcrumb_repeater = new Repeater();
		$breadcrumb_repeater->add_control( 'label', [ 'label' => esc_html__( 'Label', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Home', 'perfect-hot-tub-finder' ), 'label_block' => true, 'dynamic' => [ 'active' => true ] ] );
		$breadcrumb_repeater->add_control( 'link', [ 'label' => esc_html__( 'Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL, 'dynamic' => [ 'active' => true ] ] );
		$breadcrumb_repeater->add_control( 'active', [ 'label' => esc_html__( 'Active / Current', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Yes', 'perfect-hot-tub-finder' ), 'label_off' => esc_html__( 'No', 'perfect-hot-tub-finder' ), 'return_value' => 'yes', 'default' => '' ] );
		$this->add_control( 'breadcrumb_items', [ 'label' => esc_html__( 'Breadcrumb Items', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::REPEATER, 'fields' => $breadcrumb_repeater->get_controls(), 'title_field' => '{{{ label }}}', 'default' => [ [ 'label' => 'Home' ], [ 'label' => 'Shop' ] ], 'condition' => [ 'show_header' => 'yes', 'show_breadcrumb' => 'yes' ] ] );
		$this->end_controls_section();
		$this->start_controls_section( 'model_source', [ 'label' => esc_html__( 'Spa Model', 'perfect-hot-tub-finder' ) ] );
		$this->add_control(
			'model_id',
			[
				'label'       => esc_html__( 'Select Spa Model', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->get_model_options(),
				'default'     => 0,
				'label_block' => true,
				'description' => esc_html__( 'Use Current Spa Model on a single Spa Model template, or select one model for a normal page.', 'perfect-hot-tub-finder' ),
			]
		);
		$this->add_control( 'pricing_text', [ 'label' => esc_html__( 'Pricing Button Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Get Local Pricing', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'brochure_text', [ 'label' => esc_html__( 'Brochure Button Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Download Brochure', 'perfect-hot-tub-finder' ) ] );
		$this->end_controls_section();

		$this->start_controls_section( 'gallery', [ 'label' => esc_html__( 'Gallery Slides', 'perfect-hot-tub-finder' ) ] );
		$repeater = new Repeater();
		$repeater->add_control( 'image', [ 'label' => esc_html__( 'Image', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => Utils::get_placeholder_image_src() ] ] );
		$repeater->add_control( 'image_alt', [ 'label' => esc_html__( 'Image Alt Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Spa model gallery image', 'perfect-hot-tub-finder' ) ] );
		$this->add_control(
			'gallery_slides',
			[
				'label'       => esc_html__( 'Gallery Slides', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ image_alt }}}',
				'default'     => [
					[ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => 'Gallery Slide 1' ],
					[ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => 'Gallery Slide 2' ],
					[ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => 'Gallery Slide 3' ],
				],
			]
		);
		$this->end_controls_section();

		$this->register_complete_style_controls();
		$this->register_model_style_controls();
		$this->register_responsive_style_controls();
	}

	private function get_model_options() {
		$options = [ 0 => esc_html__( 'Current Spa Model', 'perfect-hot-tub-finder' ) ];
		$posts = get_posts(
			[
				'post_type'      => 'phtf_spa_model',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
				'order'          => 'ASC',
			]
		);
		foreach ( $posts as $post ) {
			$options[ $post->ID ] = $post->post_title;
		}
		return $options;
	}

	private function register_model_style_controls() {
		$this->start_controls_section( 'style_series_label', [ 'label' => esc_html__( 'Series Label', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'series_label_color', [ 'label' => esc_html__( 'Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-model-single-hero__series' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'series_label_typography', 'selector' => '{{WRAPPER}} .phtf-model-single-hero__series' ] );
		$this->add_responsive_control( 'series_label_margin', [ 'label' => esc_html__( 'Margin', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-model-single-hero__series' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_model_price', [ 'label' => esc_html__( 'Price & Footnotes', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'price_color', [ 'label' => esc_html__( 'Price Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-model-single-hero__price' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'price_typography', 'selector' => '{{WRAPPER}} .phtf-model-single-hero__price' ] );
		$this->add_control( 'price_footnote_color', [ 'label' => esc_html__( 'Footnote Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-model-single-hero__price .phtf-price-note-trigger, {{WRAPPER}} .phtf-model-single-hero__price .phtf-price-note-trigger sup' => 'color: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'price_footnote_size', [ 'label' => esc_html__( 'Footnote Size', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'em', 'px' ], 'range' => [ 'em' => [ 'min' => 0.5, 'max' => 2, 'step' => 0.01 ], 'px' => [ 'min' => 8, 'max' => 32 ] ], 'default' => [ 'size' => 1.18, 'unit' => 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-model-single-hero__price .phtf-price-note-trigger sup' => 'font-size: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'price_footnote_offset', [ 'label' => esc_html__( 'Footnote Top Offset', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'em', 'px' ], 'range' => [ 'em' => [ 'min' => -1, 'max' => 1, 'step' => 0.05 ], 'px' => [ 'min' => -20, 'max' => 20 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-model-single-hero__price .phtf-price-note-trigger sup' => 'position: relative; top: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'price_popup_width', [ 'label' => esc_html__( 'Popup Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 260, 'max' => 760 ] ], 'default' => [ 'size' => 540, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-model-single-hero' => '--phtf-price-popup-width: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'price_popup_height', [ 'label' => esc_html__( 'Popup Max Height', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 180, 'max' => 800 ] ], 'default' => [ 'size' => 520, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-model-single-hero' => '--phtf-price-popup-max-height: {{SIZE}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_model_specs', [ 'label' => esc_html__( 'Specifications', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'spec_label_color', [ 'label' => esc_html__( 'Label Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-model-single-hero__spec-label' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'spec_value_color', [ 'label' => esc_html__( 'Value Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-model-single-hero__spec-value' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'spec_label_typography', 'label' => esc_html__( 'Label Typography', 'perfect-hot-tub-finder' ), 'selector' => '{{WRAPPER}} .phtf-model-single-hero__spec-label' ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'spec_value_typography', 'label' => esc_html__( 'Value Typography', 'perfect-hot-tub-finder' ), 'selector' => '{{WRAPPER}} .phtf-model-single-hero__spec-value' ] );
		$this->add_responsive_control( 'spec_column_gap', [ 'label' => esc_html__( 'Column Gap', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-model-single-hero__specs' => 'column-gap: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'spec_row_gap', [ 'label' => esc_html__( 'Row Gap', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ], 'selectors' => [ '{{WRAPPER}} .phtf-model-single-hero__specs' => 'row-gap: {{SIZE}}{{UNIT}};' ] ] );
		$this->end_controls_section();
	}

	private function render_breadcrumb( $settings, $title ) {
		if ( 'yes' !== ( $settings['show_header'] ?? 'yes' ) || 'yes' !== ( $settings['show_breadcrumb'] ?? 'yes' ) ) {
			return;
		}

		$breadcrumbs = array_values( array_filter( $settings['breadcrumb_items'] ?? [], static function ( $item ) {
			return is_array( $item ) && '' !== trim( (string) ( $item['label'] ?? '' ) );
		} ) );
		$active_found = false;
		foreach ( $breadcrumbs as $index => $breadcrumb ) {
			$is_active = ! $active_found && 'yes' === ( $breadcrumb['active'] ?? '' );
			$breadcrumbs[ $index ]['active'] = $is_active ? 'yes' : '';
			$active_found = $active_found || $is_active;
		}

		$current_label = trim( wp_strip_all_tags( $title ) );
		$last = end( $breadcrumbs );
		if ( '' !== $current_label && $current_label !== trim( wp_strip_all_tags( is_array( $last ) ? ( $last['label'] ?? '' ) : '' ) ) ) {
			$breadcrumbs[] = [ 'label' => $current_label, 'active' => $active_found ? '' : 'yes' ];
		} elseif ( ! $active_found && ! empty( $breadcrumbs ) ) {
			$last_index = array_key_last( $breadcrumbs );
			$breadcrumbs[ $last_index ]['active'] = 'yes';
		}

		if ( empty( $breadcrumbs ) ) {
			return;
		}
		?>
		<nav class="phtf-series-slider__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'perfect-hot-tub-finder' ); ?>">
			<?php foreach ( $breadcrumbs as $index => $item ) :
				$label = trim( (string) ( $item['label'] ?? '' ) );
				$is_active = 'yes' === ( $item['active'] ?? '' );
				?>
				<span class="phtf-series-slider__breadcrumb-item<?php echo $is_active ? ' is-active' : ''; ?>"<?php echo $is_active ? ' aria-current="page"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php if ( ! $is_active && ! empty( $item['link']['url'] ) ) : ?><a<?php echo $this->link( $item['link'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $label ); ?></a><?php else : ?><?php echo esc_html( $label ); ?><?php endif; ?>
				</span>
				<?php if ( $index < count( $breadcrumbs ) - 1 ) : ?><span class="phtf-series-slider__breadcrumb-separator" aria-hidden="true">&gt;</span><?php endif; ?>
			<?php endforeach; ?>
		</nav>
		<?php
	}
	private function resolve_model_id( $selected_id ) {
		$selected_id = absint( $selected_id );
		if ( $selected_id && 'phtf_spa_model' === get_post_type( $selected_id ) ) {
			return $selected_id;
		}

		$current_id = get_queried_object_id();
		if ( $current_id && 'phtf_spa_model' === get_post_type( $current_id ) ) {
			return $current_id;
		}

		$posts = get_posts( [ 'post_type' => 'phtf_spa_model', 'post_status' => 'publish', 'posts_per_page' => 1, 'orderby' => [ 'menu_order' => 'ASC', 'title' => 'ASC' ] ] );
		return ! empty( $posts ) ? (int) $posts[0]->ID : 0;
	}

	private function render_price_popup( $content ) {
		$content = trim( (string) $content );
		if ( '' === $content ) {
			return [ 'id' => '', 'markup' => '' ];
		}

		$id = 'phtf-single-hero-price-note-' . wp_unique_id();
		$markup = '<span id="' . esc_attr( $id ) . '" class="phtf-price-note-popup" role="tooltip">';
		$markup .= '<button type="button" class="phtf-price-note-close" aria-label="' . esc_attr__( 'Close pricing note', 'perfect-hot-tub-finder' ) . '">&times;</button>';
		$markup .= '<span class="phtf-price-note-popup-scroll">';
		foreach ( preg_split( '/\R{2,}/', $content ) as $index => $paragraph ) {
			$paragraph = trim( (string) $paragraph );
			if ( '' !== $paragraph ) {
				$markup .= '<p class="' . ( 0 === $index ? 'phtf-price-note-intro' : 'phtf-price-note-body' ) . '">' . nl2br( esc_html( $paragraph ) ) . '</p>';
			}
		}
		$markup .= '</span></span>';
		return [ 'id' => $id, 'markup' => $markup ];
	}

	private function render_price_value( $value, $popup_one, $popup_two ) {
		$parts = preg_split( '/(\x{00B9}|\x{00B2})/u', (string) $value, -1, PREG_SPLIT_DELIM_CAPTURE );
		$output = '';
		foreach ( $parts as $part ) {
			if ( "¹" !== $part && "²" !== $part ) {
				$output .= esc_html( $part );
				continue;
			}
			$number = "²" === $part ? '2' : '1';
			$popup = $this->render_price_popup( '2' === $number ? $popup_two : $popup_one );
			if ( $popup['markup'] ) {
				$output .= '<span class="phtf-price-note-wrap"><button type="button" class="phtf-price-note-trigger" aria-expanded="false" aria-describedby="' . esc_attr( $popup['id'] ) . '" aria-label="' . esc_attr( sprintf( __( 'Pricing footnote %s', 'perfect-hot-tub-finder' ), $number ) ) . '"><sup>' . esc_html( $part ) . '</sup></button>' . $popup['markup'] . '</span>';
			} else {
				$output .= '<sup>' . esc_html( $part ) . '</sup>';
			}
		}
		return $output;
	}

	private function render_stars( $rating ) {
		$filled = max( 0, min( 5, (int) round( (float) $rating ) ) );
		$output = '<span class="phtf-model-single-hero__stars" aria-hidden="true">';
		for ( $index = 1; $index <= 5; $index++ ) {
			$output .= '<i class="' . ( $index <= $filled ? 'is-filled' : 'is-empty' ) . '">&#9733;</i>';
		}
		return $output . '</span>';
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$model_id = $this->resolve_model_id( $settings['model_id'] ?? 0 );
		$model = $model_id && function_exists( 'phtf_get_spa_model_data' ) ? phtf_get_spa_model_data( $model_id ) : [];
		$slides = $settings['gallery_slides'] ?? [];
		if ( empty( $slides ) ) {
			$slides = [ [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => $model['title'] ?? '' ] ];
		}

		$title = $model['title'] ?? esc_html__( 'Spa Model', 'perfect-hot-tub-finder' );
		$series = $model['series_display'] ?? '';
		$reviews = trim( (string) ( $model['reviews'] ?? '' ) );
		$reviews_url = ! empty( $model['reviews_url'] ) ? $model['reviews_url'] : ( $model['url'] ?? '' );
		$description = $model['hero_description'] ?? '';
		$pricing_url = $model['local_pricing_url'] ?? '';
		$brochure_url = $model['brochure_url'] ?? '';
		?>
		<section class="phtf-series-slider phtf-model-single-hero phtf-widget" data-phtf-series-slider>
			<div class="phtf-series-slider__content">
				<?php $this->render_breadcrumb( $settings, $title ); ?>
				<h1 class="phtf-series-slider__title"><?php echo esc_html( $title ); ?></h1>
				<?php if ( $series ) : ?><div class="phtf-model-single-hero__series"><?php echo esc_html( strtoupper( wp_strip_all_tags( $series ) ) ); ?></div><?php endif; ?>
				<?php if ( $reviews ) : ?>
					<a class="phtf-series-slider__reviews" href="<?php echo esc_url( $reviews_url ); ?>">
						<?php echo $this->render_stars( $model['rating'] ?? 5 ); ?>
						<?php echo esc_html( $reviews . ' ' . __( 'Reviews', 'perfect-hot-tub-finder' ) ); ?>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $model['price'] ) || ! empty( $model['secondary_price'] ) ) : ?>
					<div class="phtf-model-single-hero__price">
						<?php if ( ! empty( $model['price'] ) ) : ?><strong><?php esc_html_e( 'MSRP:', 'perfect-hot-tub-finder' ); ?></strong> <?php echo $this->render_price_value( $model['price'], $model['price_note_popup_content'] ?? '', $model['price_note_popup_content_2'] ?? '' ); ?><?php endif; ?>
						<?php if ( ! empty( $model['secondary_price'] ) ) : ?> <span class="phtf-model-single-hero__price-or"><?php esc_html_e( 'or', 'perfect-hot-tub-finder' ); ?></span> <?php echo $this->render_price_value( $model['secondary_price'], $model['price_note_popup_content'] ?? '', $model['price_note_popup_content_2'] ?? '' ); ?><?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if ( $description ) : ?><div class="phtf-series-slider__description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div><?php endif; ?>
				<div class="phtf-series-slider__actions">
					<?php if ( ! empty( $settings['pricing_text'] ) && $pricing_url ) : ?><a class="phtf-series-slider__button phtf-series-slider__button--solid" href="<?php echo esc_url( $pricing_url ); ?>"><?php echo esc_html( $settings['pricing_text'] ); ?></a><?php endif; ?>
					<?php if ( ! empty( $settings['brochure_text'] ) && $brochure_url ) : ?><a class="phtf-series-slider__button phtf-series-slider__button--outline" href="<?php echo esc_url( $brochure_url ); ?>"><?php echo esc_html( $settings['brochure_text'] ); ?></a><?php endif; ?>
				</div>
				<div class="phtf-model-single-hero__specs">
					<?php
					$specs = [
						__( 'Seating', 'perfect-hot-tub-finder' ) => $model['seating_capacity'] ?? '',
						__( 'Dimensions', 'perfect-hot-tub-finder' ) => $model['dimensions'] ?? '',
						__( 'Jets', 'perfect-hot-tub-finder' ) => $model['jet_count'] ?? '',
						__( 'Water Care', 'perfect-hot-tub-finder' ) => $model['water_care_systems'] ?? '',
					];
					foreach ( $specs as $label => $value ) :
						if ( '' === trim( (string) $value ) ) { continue; }
						?>
						<div class="phtf-model-single-hero__spec<?php echo __( 'Water Care', 'perfect-hot-tub-finder' ) === $label ? ' is-wide' : ''; ?>">
							<span class="phtf-model-single-hero__spec-label"><?php echo esc_html( $label ); ?></span>
							<span class="phtf-model-single-hero__spec-value"><?php echo nl2br( esc_html( $value ) ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="phtf-series-slider__gallery">
				<?php foreach ( $slides as $index => $slide ) : $src = $slide['image']['url'] ?? Utils::get_placeholder_image_src(); ?>
					<img class="phtf-series-slider__image<?php echo 0 === $index ? ' is-active' : ''; ?>" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $slide['image_alt'] ?? '' ); ?>"<?php echo 0 === $index ? '' : ' hidden'; ?>>
				<?php endforeach; ?>
				<?php if ( count( $slides ) > 1 ) : ?>
					<div class="phtf-series-slider__controls">
						<button type="button" class="phtf-series-slider__arrow" data-series-prev aria-label="<?php esc_attr_e( 'Previous slide', 'perfect-hot-tub-finder' ); ?>">&lsaquo;</button>
						<div class="phtf-series-slider__thumbs">
							<?php foreach ( $slides as $index => $slide ) : $src = $slide['image']['url'] ?? Utils::get_placeholder_image_src(); ?>
								<button type="button" class="phtf-series-slider__thumb<?php echo 0 === $index ? ' is-active' : ''; ?>" data-series-slide="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Show slide %d', 'perfect-hot-tub-finder' ), $index + 1 ) ); ?>" aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>"><img src="<?php echo esc_url( $src ); ?>" alt=""></button>
							<?php endforeach; ?>
						</div>
						<button type="button" class="phtf-series-slider__arrow" data-series-next aria-label="<?php esc_attr_e( 'Next slide', 'perfect-hot-tub-finder' ); ?>">&rsaquo;</button>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
