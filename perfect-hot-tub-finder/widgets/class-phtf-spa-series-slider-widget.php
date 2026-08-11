<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
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
		$breadcrumb_repeater->add_control( 'label', [ 'label' => esc_html__( 'Label', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Home', 'perfect-hot-tub-finder' ), 'label_block' => true ] );
		$breadcrumb_repeater->add_control( 'link', [ 'label' => esc_html__( 'Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL ] );
		$this->add_control( 'breadcrumb_items', [ 'label' => esc_html__( 'Breadcrumb Items', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::REPEATER, 'fields' => $breadcrumb_repeater->get_controls(), 'title_field' => '{{{ label }}}', 'default' => [ [ 'label' => 'Home' ], [ 'label' => 'Shop' ] ], 'condition' => [ 'show_header' => 'yes', 'show_breadcrumb' => 'yes' ] ] );
		$this->end_controls_section();

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

		$this->start_controls_section( 'gallery', [ 'label' => esc_html__( 'Gallery Slides', 'perfect-hot-tub-finder' ) ] );
		$repeater = new Repeater();
		$repeater->add_control( 'image', [ 'label' => esc_html__( 'Image', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => Utils::get_placeholder_image_src() ] ] );
		$repeater->add_control( 'image_alt', [ 'label' => esc_html__( 'Image Alt Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'Spa series image' ] );
		$this->add_control( 'gallery_slides', [ 'label' => esc_html__( 'Gallery Slides', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'title_field' => '{{{ image_alt }}}', 'default' => [ [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => 'Gallery Slide 1' ], [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => 'Gallery Slide 2' ], [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => 'Gallery Slide 3' ] ] ] );
		$this->end_controls_section();
	}

	private function link( $link ) {
		return empty( $link['url'] ) ? '' : sprintf( ' href="%s"%s%s', esc_url( $link['url'] ), ! empty( $link['is_external'] ) ? ' target="_blank"' : '', ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$gallery_slides = $s['gallery_slides'] ?? [];
		$legacy_slides  = $s['slides'] ?? [];
		$placeholder_url = Utils::get_placeholder_image_src();
		$has_gallery_image = false;
		foreach ( $gallery_slides as $gallery_slide ) {
			if ( ! empty( $gallery_slide['image']['url'] ) && $placeholder_url !== $gallery_slide['image']['url'] ) {
				$has_gallery_image = true;
				break;
			}
		}
		$slides = ( $has_gallery_image || empty( $legacy_slides ) ) ? $gallery_slides : $legacy_slides;
		if ( empty( $slides ) ) {
			$slides = [ [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => $s['title'] ?? '' ] ];
		}
		?>
		<section class="phtf-series-slider" data-phtf-series-slider>
			<div class="phtf-series-slider__content">
				<?php
				$breadcrumbs = $s['breadcrumb_items'] ?? [];
				if ( empty( $breadcrumbs ) && ! empty( $s['breadcrumb'] ?? '' ) ) {
					$breadcrumbs = [ [ 'label' => $s['breadcrumb'] ] ];
				}
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
				<div class="phtf-series-slider__controls"><button type="button" class="phtf-series-slider__arrow" data-series-prev aria-label="Previous slide">‹</button><div class="phtf-series-slider__thumbs"><?php foreach ( $slides as $i => $slide ) : $src = $slide['image']['url'] ?? Utils::get_placeholder_image_src(); ?><button type="button" class="phtf-series-slider__thumb<?php echo 0 === $i ? ' is-active' : ''; ?>" data-series-slide="<?php echo esc_attr( $i ); ?>" aria-label="<?php echo esc_attr( sprintf( 'Show slide %d', $i + 1 ) ); ?>"><img src="<?php echo esc_url( $src ); ?>" alt=""></button><?php endforeach; ?></div><button type="button" class="phtf-series-slider__arrow" data-series-next aria-label="Next slide">›</button></div>
			</div>
		</section>
		<?php
	}
}
