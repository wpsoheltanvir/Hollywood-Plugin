<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
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
		$this->register_style_controls();
	}

	private function register_style_controls() {
		$this->start_controls_section( 'style_content', [ 'label' => esc_html__( 'Content', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'content_background', [ 'label' => esc_html__( 'Content Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-model-slider, {{WRAPPER}} .phtf-model-slider__content' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'heading_color', [ 'label' => esc_html__( 'Heading Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-model-slider__title, {{WRAPPER}} .phtf-model-slider__specs b' => 'color: {{VALUE}};' ] ] );
		$this->add_control( 'text_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-model-slider__content' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'content_typography', 'selector' => '{{WRAPPER}} .phtf-model-slider' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_actions', [ 'label' => esc_html__( 'Buttons & Gallery', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'primary_button_color', [ 'label' => esc_html__( 'Primary Button Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-model-slider__button--solid, {{WRAPPER}} .phtf-model-slider__arrow' => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ] ] );
		$this->add_control( 'secondary_button_color', [ 'label' => esc_html__( 'Secondary Button Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-model-slider__button--outline' => 'color: {{VALUE}}; border-color: {{VALUE}};', '{{WRAPPER}} .phtf-model-slider__thumb.is-active' => 'border-color: {{VALUE}};' ] ] );
		$this->add_control( 'gallery_background', [ 'label' => esc_html__( 'Gallery Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-model-slider__gallery' => 'background-color: {{VALUE}};' ] ] );
		$this->end_controls_section();
	}

	private function link( $link ) {
		if ( empty( $link['url'] ) ) { return ''; }
		$rel = array_filter( [ ! empty( $link['is_external'] ) ? 'noopener noreferrer' : '', ! empty( $link['nofollow'] ) ? 'nofollow' : '' ] );
		return sprintf( ' href="%s"%s%s', esc_url( $link['url'] ), ! empty( $link['is_external'] ) ? ' target="_blank"' : '', ! empty( $rel ) ? ' rel="' . esc_attr( implode( ' ', $rel ) ) . '"' : '' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$slides = $s['slides'] ?? [];
		if ( empty( $slides ) ) {
			$slides = [ [ 'image' => [ 'url' => Utils::get_placeholder_image_src() ], 'image_alt' => $s['title'] ?? '' ] ];
		}
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
			<div class="phtf-model-slider__gallery"><?php foreach ( $slides as $i => $slide ) : $src = $slide['image']['url'] ?? Utils::get_placeholder_image_src(); ?><img class="phtf-model-slider__image<?php echo 0 === $i ? ' is-active' : ''; ?>" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $slide['image_alt'] ?? '' ); ?>"<?php echo 0 === $i ? '' : ' hidden'; ?>><?php endforeach; ?><?php if ( count( $slides ) > 1 ) : ?><div class="phtf-model-slider__controls"><button type="button" class="phtf-model-slider__arrow" data-model-prev aria-label="Previous slide">‹</button><div class="phtf-model-slider__thumbs"><?php foreach ( $slides as $i => $slide ) : $src = $slide['image']['url'] ?? Utils::get_placeholder_image_src(); ?><button type="button" class="phtf-model-slider__thumb<?php echo 0 === $i ? ' is-active' : ''; ?>" data-model-slide="<?php echo esc_attr( $i ); ?>" aria-label="<?php echo esc_attr( sprintf( 'Show slide %d', $i + 1 ) ); ?>" aria-current="<?php echo 0 === $i ? 'true' : 'false'; ?>"><img src="<?php echo esc_url( $src ); ?>" alt=""></button><?php endforeach; ?></div><button type="button" class="phtf-model-slider__arrow" data-model-next aria-label="Next slide">›</button></div><?php endif; ?></div>
		</section>
		<?php
	}
}
