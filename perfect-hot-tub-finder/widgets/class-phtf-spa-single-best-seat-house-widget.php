<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

class PHTF_Spa_Single_Best_Seat_House_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'phtf_spa_single_best_seat_house'; }
	public function get_title() { return esc_html__( 'Spa Single Best Seat House', 'perfect-hot-tub-finder' ); }
	public function get_icon() { return 'eicon-slider-push'; }
	public function get_categories() { return [ 'phtf-widgets' ]; }
	public function get_keywords() { return [ 'spa', 'seat', 'massage', 'slider', 'single', 'best seat' ]; }
	public function get_style_depends() { return [ 'phtf-hot-tub-finder' ]; }
	public function get_script_depends() { return [ 'phtf-hot-tub-finder' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'section_header', [ 'label' => esc_html__( 'Header', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'title', [ 'label' => esc_html__( 'Title', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Best Seat in the House.', 'perfect-hot-tub-finder' ), 'label_block' => true ] );
		$this->add_control( 'title_tag', [ 'label' => esc_html__( 'HTML Tag', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SELECT, 'default' => 'h2', 'options' => [ 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'div' => 'DIV' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_slides', [ 'label' => esc_html__( 'Seat Slides', 'perfect-hot-tub-finder' ) ] );
		$repeater = new Repeater();
		$repeater->add_control( 'spa_image', [ 'label' => esc_html__( 'Spa Image', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => Utils::get_placeholder_image_src() ] ] );
		$repeater->add_control( 'spa_alt', [ 'label' => esc_html__( 'Spa Image Alt', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Spa seat view', 'perfect-hot-tub-finder' ) ] );
		$repeater->add_control( 'seat_overlay', [ 'label' => esc_html__( 'Highlighted Seat Overlay (PNG/SVG)', 'perfect-hot-tub-finder' ), 'description' => esc_html__( 'Upload a transparent image sized to match the spa image.', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::MEDIA ] );
		$repeater->add_control( 'body_image', [ 'label' => esc_html__( 'Body / Jet Diagram', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::MEDIA ] );
		$repeater->add_control( 'seat_title', [ 'label' => esc_html__( 'Seat Title', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => 'ULTRAMASSAGE® LOUNGE', 'label_block' => true ] );
		$repeater->add_control( 'description', [ 'label' => esc_html__( 'Description', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 6, 'default' => esc_html__( 'Neck, shoulder, full back, calf and foot jets soothe and delight, with a customizable massage system that offers multiple jet sequences and speeds.', 'perfect-hot-tub-finder' ) ] );
		$repeater->add_control( 'video_text', [ 'label' => esc_html__( 'Video Link Text', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Watch Video', 'perfect-hot-tub-finder' ) ] );
		$repeater->add_control( 'video_url', [ 'label' => esc_html__( 'Video Link', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::URL, 'placeholder' => 'https://example.com/video' ] );
		$this->add_control( 'slides', [
			'label' => esc_html__( 'Slides', 'perfect-hot-tub-finder' ),
			'type' => Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(),
			'title_field' => '{{{ seat_title }}}',
			'default' => [
				[ 'seat_title' => 'ULTRAMASSAGE® LOUNGE' ],
				[ 'seat_title' => 'ECSTA SEAT' ],
				[ 'seat_title' => 'FOOT RIDGE®' ],
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_slider', [ 'label' => esc_html__( 'Slider Settings', 'perfect-hot-tub-finder' ) ] );
		$this->add_control( 'show_arrows', [ 'label' => esc_html__( 'Show Arrows', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
		$this->add_control( 'show_dots', [ 'label' => esc_html__( 'Show Dots', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ] );
		$this->add_control( 'autoplay', [ 'label' => esc_html__( 'Autoplay', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ] );
		$this->add_control( 'autoplay_speed', [ 'label' => esc_html__( 'Autoplay Speed (ms)', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::NUMBER, 'min' => 1500, 'max' => 15000, 'step' => 500, 'default' => 5000, 'condition' => [ 'autoplay' => 'yes' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_general', [ 'label' => esc_html__( 'Branding & Layout', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'background_color', [ 'label' => esc_html__( 'Background', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'default' => '#FFFFFF', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => 'background-color: {{VALUE}};' ] ] );
		$this->add_control( 'accent_color', [ 'label' => esc_html__( 'Accent Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=secondary' ], 'default' => '#85D9DE', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => '--phtf-best-seat-accent: {{VALUE}};' ] ] );
		$this->add_control( 'heading_color', [ 'label' => esc_html__( 'Heading Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=primary' ], 'default' => '#00263D', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => '--phtf-best-seat-heading: {{VALUE}};' ] ] );
		$this->add_control( 'text_color', [ 'label' => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'global' => [ 'default' => 'globals/colors?id=text' ], 'default' => '#7A7A7A', 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => '--phtf-best-seat-text: {{VALUE}};' ] ] );
		$this->add_responsive_control( 'content_width', [ 'label' => esc_html__( 'Content Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 700, 'max' => 1600 ] ], 'default' => [ 'size' => 1120, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__inner' => 'max-width: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'section_padding', [ 'label' => esc_html__( 'Section Padding', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em', '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_title', [ 'label' => esc_html__( 'Section Title', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'title_color', [ 'label' => esc_html__( 'Color', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__title' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .phtf-best-seat__title' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_content', [ 'label' => esc_html__( 'Slide Content', 'perfect-hot-tub-finder' ), 'tab' => Controls_Manager::TAB_STYLE ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'seat_title_typography', 'label' => esc_html__( 'Seat Title Typography', 'perfect-hot-tub-finder' ), 'selector' => '{{WRAPPER}} .phtf-best-seat__seat-title' ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'description_typography', 'label' => esc_html__( 'Description Typography', 'perfect-hot-tub-finder' ), 'selector' => '{{WRAPPER}} .phtf-best-seat__description' ] );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'link_typography', 'label' => esc_html__( 'Link Typography', 'perfect-hot-tub-finder' ), 'selector' => '{{WRAPPER}} .phtf-best-seat__video' ] );
		$this->add_responsive_control( 'spa_image_width', [ 'label' => esc_html__( 'Spa Image Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ '%' => [ 'min' => 40, 'max' => 100 ] ], 'size_units' => [ '%' ], 'default' => [ 'size' => 100, 'unit' => '%' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__visual' => 'width: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_responsive_control( 'body_image_width', [ 'label' => esc_html__( 'Body Diagram Width', 'perfect-hot-tub-finder' ), 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 30, 'max' => 180 ] ], 'default' => [ 'size' => 82, 'unit' => 'px' ], 'selectors' => [ '{{WRAPPER}} .phtf-best-seat__body-image' => 'width: {{SIZE}}{{UNIT}};' ] ] );
		$this->end_controls_section();
	}

	private function link_attributes( $link ) {
		if ( empty( $link['url'] ) ) { return ''; }
		$attrs = 'href="' . esc_url( $link['url'] ) . '"';
		if ( ! empty( $link['is_external'] ) ) { $attrs .= ' target="_blank"'; }
		if ( ! empty( $link['nofollow'] ) ) { $attrs .= ' rel="nofollow"'; }
		return $attrs;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$slides = array_values( array_filter( $settings['slides'] ?? [], 'is_array' ) );
		if ( empty( $slides ) ) { return; }
		$tag = in_array( $settings['title_tag'] ?? 'h2', [ 'h1', 'h2', 'h3', 'h4', 'div' ], true ) ? $settings['title_tag'] : 'h2';
		?>
		<section class="phtf-best-seat" data-phtf-best-seat data-autoplay="<?php echo 'yes' === ( $settings['autoplay'] ?? '' ) ? 'yes' : 'no'; ?>" data-autoplay-speed="<?php echo esc_attr( absint( $settings['autoplay_speed'] ?? 5000 ) ); ?>">
			<div class="phtf-best-seat__inner">
				<?php if ( ! empty( $settings['title'] ) ) : ?><<?php echo esc_attr( $tag ); ?> class="phtf-best-seat__title"><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $tag ); ?>><?php endif; ?>
				<div class="phtf-best-seat__viewport" aria-live="polite">
					<?php foreach ( $slides as $index => $slide ) : ?>
						<article class="phtf-best-seat__slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-phtf-best-seat-slide="<?php echo esc_attr( $index ); ?>"<?php echo 0 === $index ? '' : ' hidden'; ?>>
							<div class="phtf-best-seat__visual">
								<img class="phtf-best-seat__spa-image" src="<?php echo esc_url( phtf_image_url_or_fallback( $slide['spa_image']['url'] ?? '', 'widget' ) ); ?>" alt="<?php echo esc_attr( $slide['spa_alt'] ?? '' ); ?>">
								<?php if ( ! empty( $slide['seat_overlay']['url'] ) ) : ?><img class="phtf-best-seat__overlay" src="<?php echo esc_url( $slide['seat_overlay']['url'] ); ?>" alt=""><?php endif; ?>
							</div>
							<div class="phtf-best-seat__content">
								<?php if ( ! empty( $slide['body_image']['url'] ) ) : ?><img class="phtf-best-seat__body-image" src="<?php echo esc_url( $slide['body_image']['url'] ); ?>" alt=""><?php endif; ?>
								<?php if ( ! empty( $slide['seat_title'] ) ) : ?><h3 class="phtf-best-seat__seat-title"><?php echo esc_html( $slide['seat_title'] ); ?></h3><?php endif; ?>
								<?php if ( ! empty( $slide['description'] ) ) : ?><div class="phtf-best-seat__description"><?php echo wp_kses_post( wpautop( $slide['description'] ) ); ?></div><?php endif; ?>
								<?php if ( ! empty( $slide['video_text'] ) && ! empty( $slide['video_url']['url'] ) ) : ?><a class="phtf-best-seat__video" <?php echo $this->link_attributes( $slide['video_url'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $slide['video_text'] ); ?></a><?php endif; ?>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
				<?php if ( count( $slides ) > 1 && 'yes' === ( $settings['show_arrows'] ?? 'yes' ) ) : ?>
					<button class="phtf-best-seat__arrow phtf-best-seat__arrow--prev" type="button" data-phtf-best-seat-prev aria-label="<?php esc_attr_e( 'Previous seat', 'perfect-hot-tub-finder' ); ?>">‹</button>
					<button class="phtf-best-seat__arrow phtf-best-seat__arrow--next" type="button" data-phtf-best-seat-next aria-label="<?php esc_attr_e( 'Next seat', 'perfect-hot-tub-finder' ); ?>">›</button>
				<?php endif; ?>
				<?php if ( count( $slides ) > 1 && 'yes' === ( $settings['show_dots'] ?? 'yes' ) ) : ?>
					<div class="phtf-best-seat__dots" role="tablist" aria-label="<?php esc_attr_e( 'Seat slides', 'perfect-hot-tub-finder' ); ?>">
						<?php foreach ( $slides as $index => $slide ) : ?><button type="button" class="phtf-best-seat__dot<?php echo 0 === $index ? ' is-active' : ''; ?>" data-phtf-best-seat-dot="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Show slide %d', 'perfect-hot-tub-finder' ), $index + 1 ) ); ?>" aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>"></button><?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
