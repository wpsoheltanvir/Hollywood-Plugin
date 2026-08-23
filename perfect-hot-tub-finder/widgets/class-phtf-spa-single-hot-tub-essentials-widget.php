<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

class PHTF_Spa_Single_Hot_Tub_Essentials_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'phtf_spa_single_hot_tub_essentials'; }
	public function get_title() { return esc_html__( 'Spa Single Hot Tub Essentials', 'perfect-hot-tub-finder' ); }
	public function get_icon() { return 'eicon-slider-push'; }
	public function get_categories() { return [ 'phtf-widgets' ]; }
	public function get_keywords() { return [ 'spa', 'hot tub', 'essentials', 'accessories', 'covers', 'slider', 'tabs' ]; }
	public function get_style_depends() { return [ 'phtf-hot-tub-finder' ]; }
	public function get_script_depends() { return [ 'phtf-hot-tub-finder' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'section_header', [ 'label' => esc_html__( 'Header', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'title', [ 'label' => esc_html__( 'Title', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Hot Tub Essentials.', 'perfect-hot-tub-finder' ), 'label_block' => true ] );
		$this->add_control( 'title_tag', [ 'label' => esc_html__( 'HTML Tag', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SELECT, 'default' => 'h2', 'options' => [ 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'div' => 'DIV' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_slides', [ 'label' => esc_html__( 'Essential Slides', 'perfect-hot-tub-finder' ) ] );
		$repeater = new Repeater();
		$repeater->add_control( 'tab_label', [ 'label' => esc_html__( 'Tab Label', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Covers', 'perfect-hot-tub-finder' ), 'label_block' => true ] );
		$repeater->add_control( 'image', [ 'label' => esc_html__( 'Product Image', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => Utils::get_placeholder_image_src() ] ] );
		$repeater->add_control( 'image_alt', [ 'label' => esc_html__( 'Image Alt Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Hot tub accessory', 'perfect-hot-tub-finder' ) ] );
		$repeater->add_control( 'content_heading', [ 'label' => esc_html__( 'Content Heading', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'COVERS', 'perfect-hot-tub-finder' ), 'label_block' => true ] );
		$repeater->add_control( 'description', [ 'label' => esc_html__( 'Description', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 8, 'default' => esc_html__( 'Each hot tub comes equipped with a custom-built cover, made to the exact measurements of your spa. This ensures a tight seal for optimum energy efficiency.', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'slides', [
			'label' => esc_html__( 'Slides', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(), 'title_field' => '{{{ tab_label }}}',
			'default' => [
				[ 'tab_label' => 'Covers', 'content_heading' => 'COVERS' ],
				[ 'tab_label' => 'Cover Lifters', 'content_heading' => 'COVER LIFTERS' ],
				[ 'tab_label' => 'Steps', 'content_heading' => 'STEPS' ],
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_action', [ 'label' => esc_html__( 'Accessories Button', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'button_text', [ 'label' => esc_html__( 'Button Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'View All Accessories', 'perfect-hot-tub-finder' ), 'label_block' => true ] );
		$this->add_control( 'button_link', [ 'label' => esc_html__( 'Button Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL, 'placeholder' => 'https://example.com/accessories' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_slider', [ 'label' => esc_html__( 'Slider Settings', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'show_tabs', [ 'label' => esc_html__( 'Show Tabs', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
		$this->add_control( 'show_arrows', [ 'label' => esc_html__( 'Show Arrows', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
		$this->add_control( 'autoplay', [ 'label' => esc_html__( 'Autoplay', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ] );
		$this->add_control( 'autoplay_speed', [ 'label' => esc_html__( 'Autoplay Speed (ms)', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::NUMBER, 'min' => 1500, 'max' => 15000, 'step' => 500, 'default' => 5000, 'condition' => [ 'autoplay' => 'yes' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_brand', [ 'label' => esc_html__( 'Branding & Layout', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'background_color', [ 'label' => esc_html__( 'Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => '#FFFFFF', 'selectors' => [ '{{WRAPPER}} .phtf-essentials' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'brand_accent_color', [ 'label' => esc_html__( 'Brand Accent Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=secondary' ], 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-essentials' => '--phtf-essentials-accent: {{VALUE}} !important;' ] ] );
		$this->add_control( 'heading_color', [ 'label' => esc_html__( 'Heading Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-essentials' => '--phtf-essentials-heading: {{VALUE}};' ] ] );
		$this->add_control( 'text_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=text' ], 'default' => '#7A7A7A', 'selectors' => [ '{{WRAPPER}} .phtf-essentials' => '--phtf-essentials-text: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'content_width', [ 'label' => esc_html__( 'Content Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 700, 'max' => 1600 ] ], 'default' => [ 'size' => 1120, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-essentials__inner' => 'max-width: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'section_padding', [ 'label' => esc_html__( 'Section Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-essentials' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_title', [ 'label' => esc_html__( 'Title & Tabs', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'title_typography', 'label' => esc_html__( 'Title Typography', 'perfect-hot-tub-finder' ), 'selector' => '{{WRAPPER}} .phtf-essentials__title' ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'tabs_typography', 'label' => esc_html__( 'Tabs Typography', 'perfect-hot-tub-finder' ), 'selector' => '{{WRAPPER}} .phtf-essentials__tab' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_content', [ 'label' => esc_html__( 'Slide Content', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'content_heading_typography', 'label' => esc_html__( 'Heading Typography', 'perfect-hot-tub-finder' ), 'selector' => '{{WRAPPER}} .phtf-essentials__content-heading' ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'description_typography', 'label' => esc_html__( 'Description Typography', 'perfect-hot-tub-finder' ), 'selector' => '{{WRAPPER}} .phtf-essentials__description' ] );
		$this->add_responsive_control( 'image_width', [ 'label' => esc_html__( 'Image Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ '%' => [ 'min' => 40, 'max' => 100 ] ], 'size_units' => [ '%' ], 'default' => [ 'size' => 100, 'unit' => '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-essentials__image-wrap' => 'width: {{SIZE}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_button', [ 'label' => esc_html__( 'Button', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .phtf-essentials__button' ] );
		$this->add_responsive_control( 'button_padding', [ 'label' => esc_html__( 'Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em' ], 'selectors' => [ '{{WRAPPER}} .phtf-essentials__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->end_controls_section();
	}

	private function link_attributes( $link ) {
		if ( empty( $link['url'] ) ) { return ''; }
		$attrs = 'href="' . esc_url( $link['url'] ) . '"';
		$rel = [];
		if ( ! empty( $link['is_external'] ) ) { $attrs .= ' target="_blank"'; $rel[] = 'noopener'; }
		if ( ! empty( $link['nofollow'] ) ) { $rel[] = 'nofollow'; }
		if ( $rel ) { $attrs .= ' rel="' . esc_attr( implode( ' ', $rel ) ) . '"'; }
		return $attrs;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$slides = array_values( array_filter( $settings['slides'] ?? [], 'is_array' ) );
		if ( empty( $slides ) ) { return; }
		$tag = in_array( $settings['title_tag'] ?? 'h2', [ 'h1', 'h2', 'h3', 'h4', 'div' ], true ) ? $settings['title_tag'] : 'h2';
		?>
		<section class="phtf-essentials" data-phtf-essentials data-autoplay="<?php echo 'yes' === ( $settings['autoplay'] ?? '' ) ? 'yes' : 'no'; ?>" data-autoplay-speed="<?php echo esc_attr( absint( $settings['autoplay_speed'] ?? 5000 ) ); ?>">
			<div class="phtf-essentials__inner">
				<?php if ( ! empty( $settings['title'] ) ) : ?><<?php echo esc_attr( $tag ); ?> class="phtf-essentials__title"><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $tag ); ?>><?php endif; ?>
				<?php if ( count( $slides ) > 1 && 'yes' === ( $settings['show_tabs'] ?? 'yes' ) ) : ?>
					<div class="phtf-essentials__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Hot tub essentials', 'perfect-hot-tub-finder' ); ?>">
						<?php foreach ( $slides as $index => $slide ) : ?><button type="button" class="phtf-essentials__tab<?php echo 0 === $index ? ' is-active' : ''; ?>" data-phtf-essentials-tab="<?php echo esc_attr( $index ); ?>" aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"><?php echo esc_html( $slide['tab_label'] ?? '' ); ?></button><?php endforeach; ?>
					</div>
				<?php endif; ?>
				<div class="phtf-essentials__viewport" aria-live="polite">
					<?php foreach ( $slides as $index => $slide ) : ?>
						<article class="phtf-essentials__slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-phtf-essentials-slide="<?php echo esc_attr( $index ); ?>"<?php echo 0 === $index ? '' : ' hidden'; ?>>
							<div class="phtf-essentials__image-wrap"><img class="phtf-essentials__image" src="<?php echo esc_url( phtf_image_url_or_fallback( $slide['image']['url'] ?? '', 'widget' ) ); ?>" alt="<?php echo esc_attr( $slide['image_alt'] ?? '' ); ?>"></div>
							<div class="phtf-essentials__content">
								<?php if ( ! empty( $slide['content_heading'] ) ) : ?><h3 class="phtf-essentials__content-heading"><?php echo esc_html( $slide['content_heading'] ); ?></h3><?php endif; ?>
								<?php if ( ! empty( $slide['description'] ) ) : ?><div class="phtf-essentials__description"><?php echo wp_kses_post( wpautop( $slide['description'] ) ); ?></div><?php endif; ?>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
				<?php if ( count( $slides ) > 1 && 'yes' === ( $settings['show_arrows'] ?? 'yes' ) ) : ?>
					<button type="button" class="phtf-essentials__arrow phtf-essentials__arrow--prev" data-phtf-essentials-prev aria-label="<?php esc_attr_e( 'Previous essential', 'perfect-hot-tub-finder' ); ?>">‹</button>
					<button type="button" class="phtf-essentials__arrow phtf-essentials__arrow--next" data-phtf-essentials-next aria-label="<?php esc_attr_e( 'Next essential', 'perfect-hot-tub-finder' ); ?>">›</button>
				<?php endif; ?>
				<?php if ( ! empty( $settings['button_text'] ) ) : ?><div class="phtf-essentials__action"><a class="phtf-essentials__button" <?php echo $this->link_attributes( $settings['button_link'] ?? [] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['button_text'] ); ?></a></div><?php endif; ?>
			</div>
		</section>
		<?php
	}
}
