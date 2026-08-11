<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

/** Elementor hero/gallery for an individual spa model page. */
class PHTF_Spa_Model_Slider_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'phtf_spa_model_slider'; }
	public function get_title() { return esc_html__( 'Spa Model Hero', 'perfect-hot-tub-finder' ); }
	public function get_icon() { return 'eicon-slider-push'; }
	public function get_categories() { return [ 'phtf-widgets' ]; }
	public function get_keywords() { return [ 'spa', 'hot tub', 'model', 'hero', 'gallery', 'slider' ]; }
	public function get_style_depends() { return [ 'phtf-hot-tub-finder' ]; }
	public function get_script_depends() { return [ 'phtf-hot-tub-finder' ]; }

	protected function register_controls() {
		$this->register_source_controls();
		$this->start_controls_section( 'content', [ 'label' => esc_html__( 'Model Content', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'breadcrumb', [ 'label' => esc_html__( 'Breadcrumb', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Home > Shop > Utopia Series > Cantabria' ] );
		$this->add_control( 'title', [ 'label' => esc_html__( 'Model Name', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Cantabria®' ] );
		$this->add_control( 'reviews', [ 'label' => esc_html__( 'Reviews Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => '198 Reviews' ] );
		$this->add_control( 'reviews_url', [ 'label' => esc_html__( 'Reviews Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL ] );
		$this->add_control( 'price', [ 'label' => esc_html__( 'Price / MSRP', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'MSRP: $29,499¹ or $471/mo for 75 mos²' ] );
		$this->add_control( 'description', [ 'label' => esc_html__( 'Description', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 5, 'default' => 'Enjoy personalized relaxation in our Cantabria hot tub, seating 8 with an UltraMassage® lounge, UltraMasseuse® System, 6 jet patterns, and 3 speeds.' ] );
		$this->add_control( 'pricing_url', [ 'label' => esc_html__( 'Get Local Pricing Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL ] );
		$this->add_control( 'brochure_url', [ 'label' => esc_html__( 'Download Brochure Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL ] );
		$this->add_control( 'seating', [ 'label' => esc_html__( 'Seating', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => '8 Adults' ] );
		$this->add_control( 'dimensions', [ 'label' => esc_html__( 'Dimensions', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => "9' x 7'7\" x 38\"" ] );
		$this->add_control( 'jets', [ 'label' => esc_html__( 'Jets', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => '74' ] );
		$this->add_control( 'water_care', [ 'label' => esc_html__( 'Water Care', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'FreshWater® IQ Ready Salt + Smart Monitoring Included | Dosing Optional' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'slides', [ 'label' => esc_html__( 'Gallery Slides', 'perfect-hot-tub-finder' ) ] );
		$repeater = new Repeater();
		$repeater->add_control( 'image', [ 'label' => esc_html__( 'Image', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => Utils::get_placeholder_image_src() ] ] );
		$repeater->add_control( 'image_alt', [ 'label' => esc_html__( 'Image Alt Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Spa model image' ] );
		$this->add_control( 'slides', [ 'label' => esc_html__( 'Slides', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'title_field' => '{{{ image_alt }}}', 'default' => [ [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ] ], [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ] ], [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ] ] ] ] );
		$this->end_controls_section();
	}

	private function register_source_controls() {
		$model_options = [ '0' => esc_html__( 'Select a Spa Model', 'perfect-hot-tub-finder' ) ];
		if ( function_exists( 'phtf_get_spa_models' ) ) {
			foreach ( phtf_get_spa_models() as $model ) {
				$model_options[ (string) ( $model['id'] ?? 0 ) ] = $model['title'] ?? esc_html__( 'Untitled Spa Model', 'perfect-hot-tub-finder' );
			}
		}
		$this->start_controls_section( 'data_source', [ 'label' => esc_html__( 'Spa Model Data Source', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'data_source', [ 'label' => esc_html__( 'Content Source', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SELECT, 'default' => 'manual', 'options' => [ 'spa_model' => esc_html__( 'Spa Model (Dynamic)', 'perfect-hot-tub-finder' ), 'manual' => esc_html__( 'Manual Widget Content', 'perfect-hot-tub-finder' ) ] ] );
		$this->add_control( 'spa_model_id', [ 'label' => esc_html__( 'Spa Model', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SELECT, 'default' => '0', 'options' => $model_options, 'description' => esc_html__( 'Uses the selected Spa Model featured image, gallery images, reviews, price, links, and specification fields.', 'perfect-hot-tub-finder' ), 'condition' => [ 'data_source' => 'spa_model' ] ] );
		$this->end_controls_section();
	}

	private function link( $link ) { return empty( $link['url'] ) ? '' : sprintf( ' href="%s"%s%s', esc_url( $link['url'] ), ! empty( $link['is_external'] ) ? ' target="_blank"' : '', ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '' ); }

	protected function render() {
		$s = $this->get_settings_for_display();
		$slides = $s['slides'] ?? [];
		if ( 'spa_model' === ( $s['data_source'] ?? 'manual' ) && function_exists( 'phtf_get_spa_model_data' ) ) {
			$model = phtf_get_spa_model_data( absint( $s['spa_model_id'] ?? 0 ) );
			if ( ! empty( $model ) && ! empty( $model['id'] ) ) {
				$s['title']       = $model['title'] ?? $s['title'];
				$s['reviews']     = ! empty( $model['reviews'] ) ? $model['reviews'] . ' Reviews' : $s['reviews'];
				$s['reviews_url'] = [ 'url' => $model['reviews_url'] ?? '' ];
				$s['price']       = 'MSRP: ' . ( $model['price'] ?? '' ) . ( ! empty( $model['secondary_price'] ) ? ' or ' . $model['secondary_price'] : '' );
				$s['pricing_url'] = [ 'url' => $model['local_pricing_url'] ?? '' ];
				$s['brochure_url'] = [ 'url' => $model['brochure_url'] ?? '' ];
				$s['seating']     = $model['seating_capacity'] ?? $s['seating'];
				$s['dimensions']  = $model['dimensions'] ?? $s['dimensions'];
				$s['jets']        = $model['jet_count'] ?? $s['jets'];
				$s['water_care']  = $model['water_care_systems'] ?? $s['water_care'];
				$slides = [];
				if ( ! empty( $model['image'] ) ) { $slides[] = [ 'image' => [ 'url' => $model['image'] ], 'image_alt' => $model['title'] ?? '' ]; }
				foreach ( (array) ( $model['lifestyle_images'] ?? [] ) as $image_url ) { $slides[] = [ 'image' => [ 'url' => $image_url ], 'image_alt' => $model['title'] ?? '' ]; }
			}
		}
		if ( empty( $slides ) ) { return; }
		?>
		<section class="phtf-model-slider" data-phtf-model-slider>
			<div class="phtf-model-slider__content">
				<?php if ( $s['breadcrumb'] ) : ?><div class="phtf-model-slider__breadcrumb"><?php echo esc_html( $s['breadcrumb'] ); ?></div><?php endif; ?>
				<h1 class="phtf-model-slider__title"><?php echo wp_kses_post( $s['title'] ); ?></h1>
				<?php if ( $s['reviews'] ) : ?><a class="phtf-model-slider__reviews"<?php echo $this->link( $s['reviews_url'] ); ?>><span aria-hidden="true">★★★★★</span> <?php echo esc_html( $s['reviews'] ); ?></a><?php endif; ?>
				<div class="phtf-model-slider__price"><?php echo wp_kses_post( $s['price'] ); ?></div><div class="phtf-model-slider__description"><?php echo wp_kses_post( wpautop( $s['description'] ) ); ?></div>
				<div class="phtf-model-slider__actions"><a class="phtf-model-slider__button phtf-model-slider__button--solid"<?php echo $this->link( $s['pricing_url'] ); ?>>Get Local Pricing</a><a class="phtf-model-slider__button phtf-model-slider__button--outline"<?php echo $this->link( $s['brochure_url'] ); ?>>Download Brochure</a></div>
				<div class="phtf-model-slider__specs"><div><b>SEATING</b><span><?php echo esc_html( $s['seating'] ); ?></span></div><div><b>DIMENSIONS</b><span><?php echo esc_html( $s['dimensions'] ); ?></span></div><div><b>JETS</b><span><?php echo esc_html( $s['jets'] ); ?></span></div><div class="phtf-model-slider__water"><b>WATER CARE</b><span><?php echo esc_html( $s['water_care'] ); ?></span></div></div>
			</div>
			<div class="phtf-model-slider__gallery"><?php foreach ( $slides as $i => $slide ) : $src = $slide['image']['url'] ?? Utils::get_placeholder_image_src(); ?><img class="phtf-model-slider__image" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $slide['image_alt'] ?? '' ); ?>"<?php echo 0 === $i ? '' : ' hidden'; ?>><?php endforeach; ?><div class="phtf-model-slider__controls"><button type="button" class="phtf-model-slider__arrow" data-model-prev aria-label="Previous slide">‹</button><div class="phtf-model-slider__thumbs"><?php foreach ( $slides as $i => $slide ) : $src = $slide['image']['url'] ?? Utils::get_placeholder_image_src(); ?><button type="button" class="phtf-model-slider__thumb<?php echo 0 === $i ? ' is-active' : ''; ?>" data-model-slide="<?php echo esc_attr( $i ); ?>" aria-label="<?php echo esc_attr( sprintf( 'Show slide %d', $i + 1 ) ); ?>"><img src="<?php echo esc_url( $src ); ?>" alt=""></button><?php endforeach; ?></div><button type="button" class="phtf-model-slider__arrow" data-model-next aria-label="Next slide">›</button></div></div>
		</section>
		<?php
	}
}
