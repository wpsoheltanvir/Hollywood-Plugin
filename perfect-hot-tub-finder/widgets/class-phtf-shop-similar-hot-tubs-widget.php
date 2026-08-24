<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class PHTF_Shop_Similar_Hot_Tubs_Widget extends PHTF_Spa_Series_Models_Widget {
	public function get_name() {
		return 'phtf_shop_similar_hot_tubs';
	}

	public function get_title() {
		return esc_html__( 'Shop Similar Hot Tubs', 'perfect-hot-tub-finder' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_keywords() {
		return [ 'spa', 'hot tub', 'similar', 'related', 'dynamic', 'models', 'shop' ];
	}

	protected function register_controls() {
		$this->register_similar_source_controls();
		parent::register_controls();

		$this->update_control(
			'data_source',
			[
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'spa_models',
			]
		);
		$this->update_control(
			'series_category',
			[
				'label'       => esc_html__( 'Selected Series', 'perfect-hot-tub-finder' ),
				'description' => esc_html__( 'Used only when Similarity Scope is “Choose a Series”.', 'perfect-hot-tub-finder' ),
				'condition'   => [ 'similar_scope' => 'selected_series' ],
			]
		);
		$this->update_control( 'models', [ 'condition' => [ 'data_source' => 'manual' ] ] );
		$this->update_control( 'title', [ 'default' => esc_html__( 'Shop Similar Hot Tubs.', 'perfect-hot-tub-finder' ) ] );
		$this->update_control( 'show_button', [ 'default' => 'yes' ] );
		$this->update_control( 'button_text', [ 'default' => esc_html__( 'Compare Hot Tubs', 'perfect-hot-tub-finder' ) ] );
		$this->update_control( 'button_link', [ 'default' => [ 'url' => home_url( '/compare-spa-models/' ) ] ] );
		$this->update_control(
			'columns',
			[
				'default'        => 4,
				'tablet_default' => 1,
				'mobile_default' => 1,
			]
		);
		$this->update_control( 'column_gap', [ 'default' => [ 'size' => 42, 'unit' => 'px' ] ] );

		$this->register_secondary_price_style_controls();
	}

	private function register_similar_source_controls() {
		$this->start_controls_section(
			'section_similar_source',
			[
				'label' => esc_html__( 'Dynamic Similar Models', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'source_model_id',
			[
				'label'       => esc_html__( 'Reference Spa Model', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->get_model_options(),
				'default'     => 0,
				'label_block' => true,
				'description' => esc_html__( 'Uses the current Spa Model on a single-model template. Select a model when placing this widget on a normal Elementor page.', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'similar_scope',
			[
				'label'   => esc_html__( 'Similarity Scope', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'same_series',
				'options' => [
					'same_series'    => esc_html__( 'Same Series as Reference Model', 'perfect-hot-tub-finder' ),
					'all'            => esc_html__( 'All Spa Models', 'perfect-hot-tub-finder' ),
					'selected_series'=> esc_html__( 'Choose a Series', 'perfect-hot-tub-finder' ),
				],
			]
		);

		$this->add_control(
			'maximum_models',
			[
				'label'   => esc_html__( 'Maximum Models', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 1,
				'max'     => 12,
				'step'    => 1,
			]
		);

		$this->add_control(
			'show_secondary_price',
			[
				'label'        => esc_html__( 'Show Second / Monthly Price', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'secondary_price_prefix',
			[
				'label'     => esc_html__( 'Second Price Prefix', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'or', 'perfect-hot-tub-finder' ),
				'condition' => [ 'show_secondary_price' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	private function register_secondary_price_style_controls() {
		$this->start_controls_section(
			'section_similar_secondary_price_style',
			[
				'label' => esc_html__( 'Second Price', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'secondary_price_color',
			[
				'label'     => esc_html__( 'Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [ '{{WRAPPER}} .phtf-similar-secondary-price' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'secondary_price_typography',
				'selector' => '{{WRAPPER}} .phtf-similar-secondary-price',
			]
		);
		$this->add_responsive_control(
			'secondary_price_spacing',
			[
				'label'      => esc_html__( 'Top Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 40 ],
					'em' => [ 'min' => 0, 'max' => 3, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 2, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-similar-secondary-price' => 'margin-top: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->end_controls_section();
	}

	private function get_model_options() {
		$options = [ 0 => esc_html__( 'Current Spa Model / First Available', 'perfect-hot-tub-finder' ) ];
		$posts   = get_posts(
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

	private function resolve_source_model_id( $selected_id ) {
		$selected_id = absint( $selected_id );
		if ( $selected_id && 'phtf_spa_model' === get_post_type( $selected_id ) ) {
			return $selected_id;
		}

		$current_id = get_queried_object_id();
		if ( $current_id && 'phtf_spa_model' === get_post_type( $current_id ) ) {
			return $current_id;
		}

		$models = function_exists( 'phtf_get_spa_models' ) ? phtf_get_spa_models( [ 'posts_per_page' => 1 ] ) : [];
		return ! empty( $models[0]['id'] ) ? absint( $models[0]['id'] ) : 0;
	}

	private function get_similar_models( $settings, $source_model ) {
		$models    = function_exists( 'phtf_get_spa_models' ) ? phtf_get_spa_models() : [];
		$source_id = absint( $source_model['id'] ?? 0 );
		$scope     = $settings['similar_scope'] ?? 'same_series';
		$series    = '';

		if ( 'same_series' === $scope ) {
			$series = $source_model['compare_category_key'] ?? $source_model['compare_category'] ?? '';
		} elseif ( 'selected_series' === $scope ) {
			$series = $settings['series_category'] ?? '';
		}

		$models = array_values(
			array_filter(
				$models,
				static function ( $model ) use ( $source_id, $series ) {
					if ( $source_id && absint( $model['id'] ?? 0 ) === $source_id ) {
						return false;
					}
					if ( '' === $series ) {
						return true;
					}
					$model_series = $model['compare_category_key'] ?? $model['compare_category'] ?? '';
					return $series === $model_series;
				}
			)
		);

		$maximum = min( 12, max( 1, absint( $settings['maximum_models'] ?? 4 ) ) );
		return array_slice( $models, 0, $maximum );
	}

	private function link_attributes( $link ) {
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
		if ( $rel ) {
			$attrs .= ' rel="' . esc_attr( implode( ' ', array_unique( $rel ) ) ) . '"';
		}
		return $attrs;
	}

	private function render_price_value( $price, $popup_content_1, $popup_content_2 ) {
		$parts = preg_split( '/([¹²])/u', (string) $price, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
		foreach ( $parts as $part ) {
			if ( '¹' !== $part && '²' !== $part ) {
				echo esc_html( $part );
				continue;
			}

			$number  = '²' === $part ? '2' : '1';
			$content = '2' === $number ? $popup_content_2 : $popup_content_1;
			if ( '' === trim( (string) $content ) && function_exists( 'phtf_default_price_note_popup_content' ) ) {
				$content = phtf_default_price_note_popup_content( $number );
			}
			if ( '' === trim( (string) $content ) ) {
				echo '<sup>' . esc_html( $part ) . '</sup>';
				continue;
			}

			$popup_id = wp_unique_id( 'phtf-similar-price-note-' );
			?>
			<span class="phtf-price-note-wrap"><button type="button" class="phtf-price-note-trigger" aria-expanded="false" aria-describedby="<?php echo esc_attr( $popup_id ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Pricing footnote %s', 'perfect-hot-tub-finder' ), $number ) ); ?>"><sup><?php echo esc_html( $part ); ?></sup></button><span id="<?php echo esc_attr( $popup_id ); ?>" class="phtf-price-note-popup" role="tooltip"><button type="button" class="phtf-price-note-close" aria-label="<?php esc_attr_e( 'Close pricing note', 'perfect-hot-tub-finder' ); ?>">&times;</button><span class="phtf-price-note-popup-scroll"><?php echo wp_kses_post( wpautop( esc_html( $content ) ) ); ?></span></span></span>
			<?php
		}
	}

	protected function render() {
		$settings        = $this->get_settings_for_display();
		$source_model_id = $this->resolve_source_model_id( $settings['source_model_id'] ?? 0 );
		$source_model    = $source_model_id && function_exists( 'phtf_get_spa_model_data' ) ? phtf_get_spa_model_data( $source_model_id ) : [];
		$models          = $this->get_similar_models( $settings, $source_model );
		$title_tag       = $settings['title_html_tag'] ?? 'h2';
		if ( ! in_array( $title_tag, [ 'h1', 'h2', 'h3', 'h4', 'div' ], true ) ) {
			$title_tag = 'h2';
		}
		$button_link = $settings['button_link'] ?? [];
		if ( empty( $button_link['url'] ) && ! empty( $source_model['compare_url'] ) ) {
			$button_link['url'] = $source_model['compare_url'];
		}
		?>
		<section class="phtf-spa-models phtf-similar-hot-tubs" data-phtf-series-models data-phtf-similar-hot-tubs>
			<div class="phtf-spa-models-inner">
				<?php if ( 'yes' === ( $settings['show_title'] ?? 'yes' ) && ! empty( $settings['title'] ) ) : ?>
					<<?php echo esc_attr( $title_tag ); ?> class="phtf-spa-models-title"><?php echo wp_kses_post( $settings['title'] ); ?></<?php echo esc_attr( $title_tag ); ?>>
				<?php endif; ?>

				<?php if ( $models ) : ?>
					<div class="phtf-spa-models-carousel">
						<?php if ( count( $models ) > 1 ) : ?><button type="button" class="phtf-spa-models-arrow phtf-spa-models-arrow--prev" data-series-models-prev aria-label="<?php esc_attr_e( 'Previous similar model', 'perfect-hot-tub-finder' ); ?>">&lsaquo;</button><?php endif; ?>
						<div class="phtf-spa-models-grid">
							<?php foreach ( $models as $model ) :
								$model_link   = [ 'url' => ! empty( $model['view_model_url'] ) ? $model['view_model_url'] : ( $model['url'] ?? '' ) ];
								$review_link  = [ 'url' => ! empty( $model['reviews_url'] ) ? $model['reviews_url'] : ( $model_link['url'] ?? '' ) ];
								$model_attrs  = $this->link_attributes( $model_link );
								$review_attrs = $this->link_attributes( $review_link );
								$image_url    = phtf_image_url_or_fallback( $model['image'] ?? '', 'widget' );
								$series       = strtoupper( (string) ( $model['series'] ?? $model['series_display'] ?? '' ) );
								$reviews      = ! empty( $model['reviews'] ) ? '(' . trim( (string) $model['reviews'], '() ' ) . ')' : '';
								$seats        = ! empty( $model['seating_capacity'] ) ? sprintf( __( 'Seats %s', 'perfect-hot-tub-finder' ), preg_replace( '/[^0-9\-]+/', '', (string) $model['seating_capacity'] ) ) : '';
								$price_1      = trim( (string) ( $model['price'] ?? '' ) );
								$price_2      = trim( (string) ( $model['secondary_price'] ?? '' ) );
								?>
								<article class="phtf-spa-models-card">
									<div class="phtf-spa-models-image-wrap">
										<?php if ( $model_attrs ) : ?><a class="phtf-spa-models-image-link" <?php echo $model_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php endif; ?><img class="phtf-spa-models-image" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $model['title'] ?? '' ); ?>"><?php if ( $model_attrs ) : ?></a><?php endif; ?>
									</div>
									<?php if ( 'yes' === ( $settings['show_series_label'] ?? 'yes' ) && $series ) : ?><div class="phtf-spa-models-series"><?php echo esc_html( $series ); ?></div><?php endif; ?>
									<?php if ( ! empty( $model['title'] ) ) : ?><?php if ( $model_attrs ) : ?><a class="phtf-spa-models-name phtf-spa-models-name-link" <?php echo $model_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo wp_kses_post( $model['title'] ); ?></a><?php else : ?><div class="phtf-spa-models-name"><?php echo wp_kses_post( $model['title'] ); ?></div><?php endif; ?><?php endif; ?>
									<?php if ( 'yes' === ( $settings['show_rating'] ?? 'yes' ) ) : ?>
										<div class="phtf-spa-models-rating" aria-label="<?php echo esc_attr( $reviews ); ?>"><span class="phtf-spa-models-stars"><?php echo esc_html( $settings['star_text'] ?? '★★★★★' ); ?></span><?php if ( $reviews ) : ?><?php if ( $review_attrs ) : ?><a class="phtf-spa-models-reviews" <?php echo $review_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $reviews ); ?></a><?php else : ?><span class="phtf-spa-models-reviews"><?php echo esc_html( $reviews ); ?></span><?php endif; ?><?php endif; ?></div>
									<?php endif; ?>
									<?php if ( 'yes' === ( $settings['show_meta'] ?? 'yes' ) && ( $seats || $price_1 || ( 'yes' === ( $settings['show_secondary_price'] ?? 'yes' ) && $price_2 ) ) ) : ?>
										<div class="phtf-spa-models-meta phtf-similar-pricing">
											<div class="phtf-similar-primary-price"><?php if ( $seats ) : ?><span class="phtf-spa-models-seats"><?php echo esc_html( $seats ); ?></span><?php endif; ?><?php if ( $seats && $price_1 ) : ?><span class="phtf-spa-models-divider">|</span><?php endif; ?><?php if ( $price_1 ) : ?><span class="phtf-spa-models-price"><span class="phtf-spa-models-msrp-label"><?php esc_html_e( 'MSRP:', 'perfect-hot-tub-finder' ); ?></span> <strong class="phtf-spa-models-msrp-value"><?php $this->render_price_value( $price_1, $model['price_note_popup_content'] ?? '', $model['price_note_popup_content_2'] ?? '' ); ?></strong></span><?php endif; ?></div>
											<?php if ( 'yes' === ( $settings['show_secondary_price'] ?? 'yes' ) && $price_2 ) : ?><div class="phtf-similar-secondary-price"><span class="phtf-similar-secondary-prefix"><?php echo esc_html( $settings['secondary_price_prefix'] ?? 'or' ); ?></span> <strong class="phtf-spa-models-price"><?php $this->render_price_value( $price_2, $model['price_note_popup_content'] ?? '', $model['price_note_popup_content_2'] ?? '' ); ?></strong></div><?php endif; ?>
										</div>
									<?php endif; ?>
								</article>
							<?php endforeach; ?>
						</div>
						<?php if ( count( $models ) > 1 ) : ?><button type="button" class="phtf-spa-models-arrow phtf-spa-models-arrow--next" data-series-models-next aria-label="<?php esc_attr_e( 'Next similar model', 'perfect-hot-tub-finder' ); ?>">&rsaquo;</button><?php endif; ?>
					</div>
				<?php else : ?>
					<p class="phtf-similar-empty"><?php esc_html_e( 'No similar spa models are available.', 'perfect-hot-tub-finder' ); ?></p>
				<?php endif; ?>

				<?php if ( 'yes' === ( $settings['show_button'] ?? 'yes' ) && ! empty( $settings['button_text'] ) && ! empty( $button_link['url'] ) ) : ?>
					<div class="phtf-spa-models-actions"><a class="phtf-spa-models-button" <?php echo $this->link_attributes( $button_link ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['button_text'] ); ?></a></div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
