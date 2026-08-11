<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

/** Elementor hero/gallery for a single spa series page. */
class PHTF_Spa_Series_Slider_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'phtf_spa_series_slider'; }
	public function get_title() { return esc_html__( 'Hollywood Spa Series Slider', 'perfect-hot-tub-finder' ); }
	public function get_icon() { return 'eicon-slider-push'; }
	public function get_categories() { return [ 'phtf-widgets' ]; }
	public function get_keywords() { return [ 'spa', 'hot tub', 'series', 'hero', 'gallery', 'slider' ]; }
	public function get_style_depends() { return [ 'phtf-hot-tub-finder' ]; }
	public function get_script_depends() { return [ 'phtf-hot-tub-finder' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'content', [ 'label' => esc_html__( 'Series Content', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'breadcrumb', [ 'label' => esc_html__( 'Breadcrumb', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Home > Shop > Utopia® Series' ] );
		$this->add_control( 'title', [ 'label' => esc_html__( 'Title', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Utopia® Series', 'label_block' => true ] );
		$this->add_control( 'reviews', [ 'label' => esc_html__( 'Reviews Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => '852 Reviews' ] );
		$this->add_control( 'reviews_url', [ 'label' => esc_html__( 'Reviews Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL ] );
		$this->add_control( 'description', [ 'label' => esc_html__( 'Description', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 7, 'default' => 'The Utopia series features architecturally inspired cabinetry, easy-to-use touchscreen controls, and a top-of-the-line hydrotherapy experience. Every Utopia Series spa includes the FreshWater® IQ Salt and Smart Monitoring Systems, with the option to add precision Dosing for even simpler water care.' ] );
		$this->add_control( 'brochure_text', [ 'label' => esc_html__( 'Brochure Button Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Download Brochure' ] );
		$this->add_control( 'brochure_url', [ 'label' => esc_html__( 'Brochure Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL ] );
		$this->add_control( 'pricing_text', [ 'label' => esc_html__( 'Pricing Button Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Get Local Pricing' ] );
		$this->add_control( 'pricing_url', [ 'label' => esc_html__( 'Pricing Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL ] );
		$this->end_controls_section();

		$this->start_controls_section( 'slides', [ 'label' => esc_html__( 'Gallery Slides', 'perfect-hot-tub-finder' ) ] );
		$repeater = new Repeater();
		$repeater->add_control( 'image', [ 'label' => esc_html__( 'Image', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => Utils::get_placeholder_image_src() ] ] );
		$repeater->add_control( 'image_alt', [ 'label' => esc_html__( 'Image Alt Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Spa series image' ] );
		$this->add_control( 'slides', [ 'label' => esc_html__( 'Slides', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'title_field' => '{{{ image_alt }}}', 'default' => [ [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ] ], [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ] ], [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ] ] ] ] );
		$this->end_controls_section();
	}

	private function link( $link ) {
		return empty( $link['url'] ) ? '' : sprintf( ' href="%s"%s%s', esc_url( $link['url'] ), ! empty( $link['is_external'] ) ? ' target="_blank"' : '', ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '' );
	}

	protected function render() {
		$s = $this->get_settings_for_display(); $slides = $s['slides'] ?? [];
		if ( empty( $slides ) ) { return; }
		?>
		<section class="phtf-series-slider" data-phtf-series-slider>
			<div class="phtf-series-slider__content">
				<?php if ( $s['breadcrumb'] ) : ?><div class="phtf-series-slider__breadcrumb"><?php echo esc_html( $s['breadcrumb'] ); ?></div><?php endif; ?>
				<h1 class="phtf-series-slider__title"><?php echo wp_kses_post( $s['title'] ); ?></h1>
				<?php if ( $s['reviews'] ) : ?><a class="phtf-series-slider__reviews"<?php echo $this->link( $s['reviews_url'] ); ?>><span aria-hidden="true">★★★★★</span> <?php echo esc_html( $s['reviews'] ); ?></a><?php endif; ?>
				<div class="phtf-series-slider__description"><?php echo wp_kses_post( wpautop( $s['description'] ) ); ?></div>
				<div class="phtf-series-slider__actions"><?php if ( $s['brochure_text'] ) : ?><a class="phtf-series-slider__button phtf-series-slider__button--solid"<?php echo $this->link( $s['brochure_url'] ); ?>><?php echo esc_html( $s['brochure_text'] ); ?></a><?php endif; ?><?php if ( $s['pricing_text'] ) : ?><a class="phtf-series-slider__button phtf-series-slider__button--outline"<?php echo $this->link( $s['pricing_url'] ); ?>><?php echo esc_html( $s['pricing_text'] ); ?></a><?php endif; ?></div>
			</div>
			<div class="phtf-series-slider__gallery">
				<?php foreach ( $slides as $i => $slide ) : $src = $slide['image']['url'] ?? Utils::get_placeholder_image_src(); ?><img class="phtf-series-slider__image<?php echo 0 === $i ? ' is-active' : ''; ?>" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $slide['image_alt'] ?? '' ); ?>"<?php echo 0 === $i ? '' : ' hidden'; ?>><?php endforeach; ?>
				<div class="phtf-series-slider__controls"><button type="button" class="phtf-series-slider__arrow" data-series-prev aria-label="Previous slide">‹</button><div class="phtf-series-slider__thumbs"><?php foreach ( $slides as $i => $slide ) : $src = $slide['image']['url'] ?? Utils::get_placeholder_image_src(); ?><button type="button" class="phtf-series-slider__thumb<?php echo 0 === $i ? ' is-active' : ''; ?>" data-series-slide="<?php echo esc_attr( $i ); ?>" aria-label="<?php echo esc_attr( sprintf( 'Show slide %d', $i + 1 ) ); ?>"><img src="<?php echo esc_url( $src ); ?>" alt=""></button><?php endforeach; ?></div><button type="button" class="phtf-series-slider__arrow" data-series-next aria-label="Next slide">›</button></div>
			</div>
		</section>
		<?php
	}
}
