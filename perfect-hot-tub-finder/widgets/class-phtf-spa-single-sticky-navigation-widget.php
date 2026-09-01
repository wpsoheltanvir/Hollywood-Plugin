<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;

class PHTF_Spa_Single_Sticky_Navigation_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'phtf_spa_single_sticky_navigation';
	}

	public function get_title() {
		return esc_html__( 'Spa Single Sticky Navigation', 'perfect-hot-tub-finder' );
	}

	public function get_icon() {
		return 'eicon-navigation-horizontal';
	}

	public function get_categories() {
		return [ 'phtf-widgets' ];
	}

	public function get_keywords() {
		return [ 'spa', 'single', 'sticky', 'navigation', 'scrollspy', 'anchor', 'menu' ];
	}

	public function get_style_depends() {
		return [ 'phtf-hot-tub-finder' ];
	}

	public function get_script_depends() {
		return [ 'phtf-hot-tub-finder' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_navigation',
			[ 'label' => esc_html__( 'Navigation Items', 'perfect-hot-tub-finder' ) ]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'label',
			[
				'label'       => esc_html__( 'Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Overview', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'section_id',
			[
				'label'       => esc_html__( 'Section CSS ID', 'perfect-hot-tub-finder' ),
				'description' => esc_html__( 'Enter the target section ID without #. Add the same ID in the target section’s Advanced tab.', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'section--overview',
				'label_block' => true,
			]
		);
		$this->add_control(
			'items',
			[
				'label'       => esc_html__( 'Menu Items', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => [
					[ 'label' => 'Overview', 'section_id' => 'section--overview' ],
					[ 'label' => 'Colors', 'section_id' => 'section--color-selector' ],
					[ 'label' => 'Massage', 'section_id' => 'section--massage' ],
					[ 'label' => 'Features', 'section_id' => 'section--features' ],
					[ 'label' => 'Accessories', 'section_id' => 'section--accessories' ],
					[ 'label' => 'Specs', 'section_id' => 'section--specs' ],
					[ 'label' => 'Reviews', 'section_id' => 'section--reviews' ],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_behavior',
			[ 'label' => esc_html__( 'Sticky & Scroll Behavior', 'perfect-hot-tub-finder' ) ]
		);
		$this->add_control(
			'enable_sticky',
			[
				'label'        => esc_html__( 'Sticky at Top', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'auto_active',
			[
				'label'        => esc_html__( 'Auto-change Active Underline', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'smooth_scroll',
			[
				'label'        => esc_html__( 'Smooth Scrolling', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_responsive_control(
			'sticky_top_offset',
			[
				'label'      => esc_html__( 'Sticky Top Offset', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 250 ] ],
				'default'    => [ 'size' => 0, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-sticky-nav' => '--phtf-sticky-nav-top: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			'scroll_gap',
			[
				'label'       => esc_html__( 'Section Scroll Gap', 'perfect-hot-tub-finder' ),
				'description' => esc_html__( 'Extra space kept above the target section after a menu click.', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [ 'px' => [ 'min' => 0, 'max' => 160 ] ],
				'default'     => [ 'size' => 12, 'unit' => 'px' ],
				'selectors'   => [ '{{WRAPPER}} .phtf-sticky-nav' => '--phtf-sticky-nav-scroll-gap: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_control(
			'mobile_icon',
			[
				'label'   => esc_html__( 'Mobile Menu Icon', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [ 'value' => 'fas fa-chevron-down', 'library' => 'fa-solid' ],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => esc_html__( 'Bar Layout', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-sticky-nav' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_responsive_control(
			'content_width',
			[
				'label'      => esc_html__( 'Content Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [ 'px' => [ 'min' => 600, 'max' => 1800 ], '%' => [ 'min' => 50, 'max' => 100 ], 'vw' => [ 'min' => 50, 'max' => 100 ] ],
				'default'    => [ 'size' => 1180, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-sticky-nav__inner' => 'max-width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			'bar_padding',
			[
				'label'      => esc_html__( 'Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'top' => 18, 'right' => 20, 'bottom' => 18, 'left' => 20, 'unit' => 'px' ],
				'tablet_default' => [ 'top' => 14, 'right' => 16, 'bottom' => 14, 'left' => 16, 'unit' => 'px' ],
				'mobile_default' => [ 'top' => 0, 'right' => 12, 'bottom' => 0, 'left' => 12, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-sticky-nav__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);
		$this->add_control(
			'z_index',
			[
				'label'     => esc_html__( 'Sticky Z-Index', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 999999,
				'default'   => 999,
				'selectors' => [ '{{WRAPPER}} .phtf-sticky-nav' => 'z-index: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'bar_shadow',
				'selector' => '{{WRAPPER}} .phtf-sticky-nav',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_items_style',
			[
				'label' => esc_html__( 'Navigation Links', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'item_gap',
			[
				'label'      => esc_html__( 'Item Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ], 'em' => [ 'min' => 0, 'max' => 5 ] ],
				'default'    => [ 'size' => 18, 'unit' => 'px' ],
				'tablet_default' => [ 'size' => 12, 'unit' => 'px' ],
				'mobile_default' => [ 'size' => 0, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-sticky-nav__list' => 'column-gap: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			'link_padding',
			[
				'label'      => esc_html__( 'Link Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'top' => 4, 'right' => 8, 'bottom' => 8, 'left' => 8, 'unit' => 'px' ],
				'tablet_default' => [ 'top' => 4, 'right' => 6, 'bottom' => 8, 'left' => 6, 'unit' => 'px' ],
				'mobile_default' => [ 'top' => 11, 'right' => 4, 'bottom' => 8, 'left' => 4, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-sticky-nav__link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'link_typography',
				'selector' => '{{WRAPPER}} .phtf-sticky-nav__link, {{WRAPPER}} .phtf-sticky-nav__mobile-toggle',
			]
		);
		$this->start_controls_tabs( 'link_color_tabs' );
		$this->start_controls_tab( 'link_normal_tab', [ 'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ) ] );
		$this->add_control(
			'link_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [ '{{WRAPPER}} .phtf-sticky-nav__link, {{WRAPPER}} .phtf-sticky-nav__mobile-toggle' => 'color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab( 'link_hover_tab', [ 'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ) ] );
		$this->add_control(
			'link_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-sticky-nav__link:hover, {{WRAPPER}} .phtf-sticky-nav__link:focus-visible' => 'color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab( 'link_active_tab', [ 'label' => esc_html__( 'Active', 'perfect-hot-tub-finder' ) ] );
		$this->add_control(
			'link_active_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [ '{{WRAPPER}} .phtf-sticky-nav__item.is-active .phtf-sticky-nav__link' => 'color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'separator_color',
			[
				'label'     => esc_html__( 'Separator Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.32)',
				'selectors' => [ '{{WRAPPER}} .phtf-sticky-nav__separator' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_underline_style',
			[
				'label' => esc_html__( 'Active Underline', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'underline_color',
			[
				'label'     => esc_html__( 'Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [ '{{WRAPPER}} .phtf-sticky-nav' => '--phtf-sticky-nav-underline: {{VALUE}};' ],
			]
		);
		$this->add_responsive_control(
			'underline_width',
			[
				'label'      => esc_html__( 'Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [ '%' => [ 'min' => 10, 'max' => 100 ], 'px' => [ 'min' => 10, 'max' => 200 ] ],
				'default'    => [ 'size' => 100, 'unit' => '%' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-sticky-nav__link::after' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			'underline_thickness',
			[
				'label'      => esc_html__( 'Thickness', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
				'default'    => [ 'size' => 2, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-sticky-nav__link::after' => 'height: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_mobile_style',
			[
				'label' => esc_html__( 'Mobile Menu', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'mobile_dropdown_background',
			[
				'label'     => esc_html__( 'Dropdown Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [ '{{WRAPPER}} .phtf-sticky-nav__list' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_responsive_control(
			'mobile_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 36 ] ],
				'default'    => [ 'size' => 15, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .phtf-sticky-nav__mobile-icon' => 'font-size: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->end_controls_section();
	}

	private function normalized_items( $items ) {
		$normalized = [];
		foreach ( is_array( $items ) ? $items : [] as $item ) {
			$label = trim( wp_strip_all_tags( $item['label'] ?? '' ) );
			$id    = sanitize_html_class( ltrim( trim( (string) ( $item['section_id'] ?? '' ) ), '#' ) );
			if ( '' !== $label && '' !== $id ) {
				$normalized[] = [ 'label' => $label, 'id' => $id ];
			}
		}
		return $normalized;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items    = $this->normalized_items( $settings['items'] ?? [] );
		if ( empty( $items ) ) {
			return;
		}
		$icon = is_array( $settings['mobile_icon'] ?? null ) && ! empty( $settings['mobile_icon']['value'] )
			? $settings['mobile_icon']
			: [ 'value' => 'fas fa-chevron-down', 'library' => 'fa-solid' ];
		?>
		<nav class="phtf-sticky-nav" data-phtf-sticky-nav data-sticky="<?php echo esc_attr( 'yes' === ( $settings['enable_sticky'] ?? 'yes' ) ? 'true' : 'false' ); ?>" data-auto-active="<?php echo esc_attr( 'yes' === ( $settings['auto_active'] ?? 'yes' ) ? 'true' : 'false' ); ?>" data-smooth-scroll="<?php echo esc_attr( 'yes' === ( $settings['smooth_scroll'] ?? 'yes' ) ? 'true' : 'false' ); ?>" aria-label="<?php esc_attr_e( 'Spa page sections', 'perfect-hot-tub-finder' ); ?>">
			<div class="phtf-sticky-nav__inner">
				<button type="button" class="phtf-sticky-nav__mobile-toggle" data-phtf-sticky-nav-toggle aria-expanded="false">
					<span data-phtf-sticky-nav-current><?php echo esc_html( $items[0]['label'] ); ?></span>
					<span class="phtf-sticky-nav__mobile-icon" aria-hidden="true"><?php Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?></span>
				</button>
				<ul class="phtf-sticky-nav__list" data-phtf-sticky-nav-list>
					<?php foreach ( $items as $index => $item ) : ?>
						<li class="phtf-sticky-nav__item<?php echo 0 === $index ? ' is-active' : ''; ?>" data-phtf-sticky-nav-item>
							<a class="phtf-sticky-nav__link" href="#<?php echo esc_attr( $item['id'] ); ?>" data-phtf-sticky-nav-link data-section-id="<?php echo esc_attr( $item['id'] ); ?>"<?php echo 0 === $index ? ' aria-current="true"' : ''; ?>><?php echo esc_html( $item['label'] ); ?></a>
							<?php if ( $index < count( $items ) - 1 ) : ?><span class="phtf-sticky-nav__separator" aria-hidden="true"></span><?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</nav>
		<?php
	}
}
