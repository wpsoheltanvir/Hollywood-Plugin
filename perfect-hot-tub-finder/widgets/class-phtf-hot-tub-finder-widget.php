<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;

class PHTF_Hot_Tub_Finder_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'phtf_hot_tub_finder';
	}

	public function get_title() {
		return esc_html__( 'Spa Shop Slider', 'perfect-hot-tub-finder' );
	}

	public function get_icon() {
		return 'eicon-product-images';
	}

	public function get_categories() {
		return [ 'phtf-widgets' ];
	}

	public function get_keywords() {
		return [ 'hot tub', 'spa', 'spa shop slider', 'product finder', 'shop', 'filter', 'carousel' ];
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

	private function register_content_controls() {

		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Header / Breadcrumb', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_header',
			[
				'label'        => esc_html__( 'Show Header', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_breadcrumb',
			[
				'label'        => esc_html__( 'Show Breadcrumb', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [ 'show_header' => 'yes' ],
			]
		);

		$breadcrumb_repeater = new Repeater();
		$breadcrumb_repeater->add_control(
			'label',
			[
				'label'       => esc_html__( 'Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Home', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);
		$breadcrumb_repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'perfect-hot-tub-finder' ),
				'type'  => Controls_Manager::URL,
			]
		);
		$breadcrumb_repeater->add_control(
			'active',
			[
				'label'        => esc_html__( 'Active / Current', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'breadcrumbs',
			[
				'label'       => esc_html__( 'Breadcrumb Items', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $breadcrumb_repeater->get_controls(),
				'title_field' => '{{{ label }}}',
				'condition'   => [
					'show_header'     => 'yes',
					'show_breadcrumb' => 'yes',
				],
				'default'     => [
					[
						'label' => esc_html__( 'Home', 'perfect-hot-tub-finder' ),
						'link'  => [ 'url' => '' ],
					],
					[
						'label'  => esc_html__( 'Shop', 'perfect-hot-tub-finder' ),
						'active' => 'yes',
					],
				],
			]
		);

		$this->add_control(
			'breadcrumb_separator',
			[
				'label'     => esc_html__( 'Separator', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '>',
				'condition' => [
					'show_header'     => 'yes',
					'show_breadcrumb' => 'yes',
				],
			]
		);

		// Keep the old fixed breadcrumb fields registered so existing Elementor data
		// can be converted into the new repeater without losing custom labels.
		$this->add_control(
			'breadcrumb_home',
			[
				'type'    => Controls_Manager::HIDDEN,
				'default' => esc_html__( 'Home', 'perfect-hot-tub-finder' ),
			]
		);
		$this->add_control(
			'breadcrumb_current',
			[
				'type'    => Controls_Manager::HIDDEN,
				'default' => esc_html__( 'Shop', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'header_title',
			[
				'label'       => esc_html__( 'Title', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Find Your Perfect Hot Tub.', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'condition'   => [ 'show_header' => 'yes' ],
			]
		);

		$this->add_control(
			'header_subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Step into relaxation, blending comfort, design, and performance.', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'condition'   => [ 'show_header' => 'yes' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_filters',
			[
				'label' => esc_html__( 'Filters', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_filters',
			[
				'label'        => esc_html__( 'Show Filters', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'seating_filter_heading',
			[
				'label'     => esc_html__( 'Seating Filter', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 'show_filters' => 'yes' ],
			]
		);

		$this->add_control(
			'show_seating_filter',
			[
				'label'        => esc_html__( 'Show Seating Filter', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_filters' => 'yes' ],
			]
		);

		$this->add_control(
			'seating_title',
			[
				'label'     => esc_html__( 'Seating Filter Title', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Seating', 'perfect-hot-tub-finder' ),
				'condition' => [
					'show_filters'        => 'yes',
					'show_seating_filter' => 'yes',
				],
			]
		);

		$seat_filter_repeater = new Repeater();
		$seat_filter_repeater->add_control(
			'label',
			[
				'label'       => esc_html__( 'Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '2-3 Seats', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);
		$seat_filter_repeater->add_control(
			'value',
			[
				'label'       => esc_html__( 'Match Value', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '2-3',
				'label_block' => true,
				'description' => esc_html__( 'Products using this filter must use the same value.', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'seat_filters',
			[
				'label'       => esc_html__( 'Seating Options', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $seat_filter_repeater->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => [
					[ 'label' => esc_html__( '2-3 Seats', 'perfect-hot-tub-finder' ), 'value' => '2-3' ],
					[ 'label' => esc_html__( '4-5 Seats', 'perfect-hot-tub-finder' ), 'value' => '4-5' ],
					[ 'label' => esc_html__( '6-8 Seats', 'perfect-hot-tub-finder' ), 'value' => '6-8' ],
				],
				'condition'   => [
					'show_filters'        => 'yes',
					'show_seating_filter' => 'yes',
				],
			]
		);


		$this->add_control(
			'price_filter_heading',
			[
				'label'     => esc_html__( 'Price Filter', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'show_filters' => 'yes' ],
			]
		);

		$this->add_control(
			'show_price_filter',
			[
				'label'        => esc_html__( 'Show Price Filter', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_filters' => 'yes' ],
			]
		);

		$this->add_control(
			'price_title',
			[
				'label'     => esc_html__( 'Price Filter Title', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Price', 'perfect-hot-tub-finder' ),
				'condition' => [
					'show_filters'      => 'yes',
					'show_price_filter' => 'yes',
				],
			]
		);

		$price_filter_repeater = new Repeater();
		$price_filter_repeater->add_control(
			'label',
			[
				'label'       => esc_html__( 'Label', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '$$$$',
				'label_block' => true,
			]
		);
		$price_filter_repeater->add_control(
			'value',
			[
				'label'       => esc_html__( 'Match Value', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'tier-4',
				'label_block' => true,
				'description' => esc_html__( 'Products using this filter must use the same value.', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'price_filters',
			[
				'label'       => esc_html__( 'Price Options', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $price_filter_repeater->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => [
					[ 'label' => '$', 'value' => 'tier-1' ],
					[ 'label' => '$$', 'value' => 'tier-2' ],
					[ 'label' => '$$$', 'value' => 'tier-3' ],
					[ 'label' => '$$$$', 'value' => 'tier-4' ],
				],
				'condition'   => [
					'show_filters'      => 'yes',
					'show_price_filter' => 'yes',
				],
			]
		);


		$this->add_control(
			'price_info_icon',
			[
				'label'        => esc_html__( 'Show Price Info Icon', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_filters'      => 'yes',
					'show_price_filter' => 'yes',
				],
			]
		);


		$this->add_control(
			'price_info_custom_icon',
			[
				'label'            => esc_html__( 'Custom Price Info Icon', 'perfect-hot-tub-finder' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'price_info_custom_icon_fa4',
				'default'          => [
					'value'   => 'fas fa-info-circle',
					'library' => 'fa-solid',
				],
				'condition'        => [
					'show_filters'      => 'yes',
					'show_price_filter' => 'yes',
					'price_info_icon'   => 'yes',
				],
			]
		);


		$this->add_control(
			'price_info_popup_title',
			[
				'label'       => esc_html__( 'Price Info Popup Title', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'PRICE', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'condition'   => [
					'show_filters'      => 'yes',
					'show_price_filter' => 'yes',
					'price_info_icon'   => 'yes',
				],
			]
		);

		$this->add_control(
			'price_info_popup_content',
			[
				'label'       => esc_html__( 'Price Info Popup Content', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '<p><strong>$</strong> (Up to $9,999)</p><p><strong>$$</strong> ($10,000 - $16,999)</p><p><strong>$$$</strong> ($17,000 - $20,999)</p><p><strong>$$$$</strong> ($21,000 and up)</p><p>Dealers have sole discretion to set actual prices, which will vary based on options, accessories, installation costs, destination charges, finance charges, taxes and other local factors. Talk to your <strong>local dealer</strong> for your local price and to take advantage of ongoing promotions and offers.</p>',
				'condition'   => [
					'show_filters'      => 'yes',
					'show_price_filter' => 'yes',
					'price_info_icon'   => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_products',
			[
				'label' => esc_html__( 'Products', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'data_source',
			[
				'label'   => esc_html__( 'Data Source', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cpt',
				'options' => [
					'cpt'      => esc_html__( 'Spa Model Posts', 'perfect-hot-tub-finder' ),
					'repeater' => esc_html__( 'Elementor Product Repeater', 'perfect-hot-tub-finder' ),
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'cpt_source_notice',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf(
					'<strong>%1$s</strong><br>%2$s<br><br><a class="elementor-button elementor-button-default" href="%3$s" target="_blank" rel="noopener">%4$s</a>',
					esc_html__( 'Spa Shop Slider is using Spa Model posts.', 'perfect-hot-tub-finder' ),
					esc_html__( 'Add/edit products in WordPress Dashboard > Spa Models. Published Spa Model posts automatically appear in this widget.', 'perfect-hot-tub-finder' ),
					esc_url( admin_url( 'edit.php?post_type=phtf_spa_model' ) ),
					esc_html__( 'Open Spa Models', 'perfect-hot-tub-finder' )
				),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => [
					'data_source' => 'cpt',
				],
			]
		);

		$this->add_control(
			'product_source_id',
			[
				'label'       => esc_html__( 'Product Source ID', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'main',
				'ai'          => [ 'active' => false ],
				'label_block' => true,
				'description' => esc_html__( 'Use this same ID in the Explore Our Models widget to pull these products dynamically.', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'show_secondary_price',
			[
				'label'        => esc_html__( 'Show Monthly / Second Price', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'Hide', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => '',
				'description'  => esc_html__( 'Turn this on only if you want the monthly/second price to appear after MSRP.', 'perfect-hot-tub-finder' ),
			]
		);

		$product_repeater = new Repeater();

		$product_repeater->add_control(
			'brand',
			[
				'label'       => esc_html__( 'Brand / Model Name', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Cantabria®', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$product_repeater->add_control(
			'series',
			[
				'label'       => esc_html__( 'Series', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'UTOPIA® SERIES',
				'options'     => [
					'UTOPIA® SERIES'   => esc_html__( 'Utopia® Series', 'perfect-hot-tub-finder' ),
					'PARADISE® SERIES' => esc_html__( 'Paradise® Series', 'perfect-hot-tub-finder' ),
					'VACANZA® SERIES'  => esc_html__( 'Vacanza® Series', 'perfect-hot-tub-finder' ),
					'FANTASY™ SERIES'  => esc_html__( 'Fantasy™ Series', 'perfect-hot-tub-finder' ),
				],
				'label_block' => true,
			]
		);

		$product_repeater->add_control(
			'rating',
			[
				'label'   => esc_html__( 'Rating', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 5,
				'step'    => 0.1,
				'default' => 4.5,
			]
		);

		$product_repeater->add_control(
			'reviews',
			[
				'label'       => esc_html__( 'Reviews Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '197 Reviews', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$product_repeater->add_control(
			'msrp',
			[
				'label'       => esc_html__( 'MSRP / Price Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '$29,499¹', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$product_repeater->add_control(
			'secondary_price',
			[
				'label'       => esc_html__( 'Monthly / Second Price Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '$471/mo for 75 mos²', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'description' => esc_html__( 'Optional. Displays inline after the MSRP with “or”. Add a ² marker anywhere in this text to use Price Footnote Link 2.', 'perfect-hot-tub-finder' ),
			]
		);

		$product_repeater->add_control(
			'seating',
			[
				'label'       => esc_html__( 'Displayed Seating', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '8 Adults', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$product_repeater->add_control(
			'seating_filter_value',
			[
				'label'       => esc_html__( 'Seating Filter Group', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '6-8',
				'label_block' => true,
				'description' => esc_html__( 'Match one of the Seating Options values above, for example 6-8.', 'perfect-hot-tub-finder' ),
			]
		);

		$product_repeater->add_control(
			'dimensions',
			[
				'label'       => esc_html__( 'Dimensions', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( "9' x 7'7\" x 38\"", 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$product_repeater->add_control(
			'jets',
			[
				'label'   => esc_html__( 'Jets', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '74',
			]
		);

		$product_repeater->add_control(
			'water_care',
			[
				'label'       => esc_html__( 'Water Care', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'FreshWater® IQ Ready Salt + Smart Monitoring Included | Dosing Optional', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$product_repeater->add_control(
			'price_filter_value',
			[
				'label'       => esc_html__( 'Price Filter Group', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'tier-4',
				'label_block' => true,
				'description' => esc_html__( 'Match one of the Price Options values above, for example tier-4.', 'perfect-hot-tub-finder' ),
			]
		);

		$product_repeater->add_control(
			'product_image',
			[
				'label'   => esc_html__( 'Product Image', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => phtf_get_fallback_image_url( 'product' ),
				],
			]
		);

		$product_repeater->add_control(
			'background_image',
			[
				'label'   => esc_html__( 'Background / Lifestyle Image', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => phtf_get_fallback_image_url( 'lifestyle' ),
				],
			]
		);

		$product_repeater->add_control(
			'view_link',
			[
				'label'       => esc_html__( 'View Model Link', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$product_repeater->add_control(
			'compare_link',
			[
				'label'       => esc_html__( 'Compare Models Link', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$product_repeater->add_control(
			'title_link',
			[
				'label'       => esc_html__( 'Model Title Link', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$product_repeater->add_control(
			'reviews_link',
			[
				'label'       => esc_html__( 'Reviews Link', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'perfect-hot-tub-finder' ),
				'label_block' => true,
			]
		);

		$product_repeater->add_control(
			'price_note_link',
			[
				'label'       => esc_html__( 'Price Footnote Link', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => '#',
				'label_block' => true,
				'description' => esc_html__( 'Optional. Leave blank to use the popup only.', 'perfect-hot-tub-finder' ),
			]
		);

		$product_repeater->add_control(
			'price_note_popup_content',
			[
				'label'       => esc_html__( 'Price Footnote Popup Text', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 7,
				'default'     => $this->get_default_price_note_popup_content( '1' ),
				'label_block' => true,
			]
		);

		$product_repeater->add_control(
			'price_note_link_2',
			[
				'label'       => esc_html__( 'Price Footnote Link 2', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'perfect-hot-tub-finder' ),
				'label_block' => true,
				'description' => esc_html__( 'Optional second footnote. Use a ² marker in the price text or Monthly / Second Price Text.', 'perfect-hot-tub-finder' ),
			]
		);

		$product_repeater->add_control(
			'price_note_popup_content_2',
			[
				'label'       => esc_html__( 'Price Footnote Popup Text 2', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 7,
				'default'     => $this->get_default_price_note_popup_content( '2' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'products',
			[
				'label'       => esc_html__( 'Product Results', 'perfect-hot-tub-finder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $product_repeater->get_controls(),
				'default'     => [
					[
						'brand'                => esc_html__( 'Cantabria®', 'perfect-hot-tub-finder' ),
						'series'               => esc_html__( 'UTOPIA® SERIES', 'perfect-hot-tub-finder' ),
						'rating'               => 4.5,
						'reviews'              => esc_html__( '197 Reviews', 'perfect-hot-tub-finder' ),
						'msrp'                 => esc_html__( '$29,499¹', 'perfect-hot-tub-finder' ),
						'secondary_price'      => esc_html__( '$471/mo for 75 mos²', 'perfect-hot-tub-finder' ),
						'price_note_popup_content'   => $this->get_default_price_note_popup_content( '1' ),
						'price_note_popup_content_2' => $this->get_default_price_note_popup_content( '2' ),
						'seating'              => esc_html__( '8 Adults', 'perfect-hot-tub-finder' ),
						'seating_filter_value' => '6-8',
						'dimensions'           => esc_html__( "9' x 7'7\" x 38\"", 'perfect-hot-tub-finder' ),
						'jets'                 => '74',
						'water_care'           => esc_html__( 'FreshWater® IQ Ready Salt + Smart Monitoring Included | Dosing Optional', 'perfect-hot-tub-finder' ),
						'price_filter_value'   => 'tier-4',
						'product_image'        => [ 'url' => phtf_get_fallback_image_url( 'product' ) ],
						'background_image'     => [ 'url' => phtf_get_fallback_image_url( 'lifestyle' ) ],
					],
				],
				'title_field' => '{{{ brand || "Spa Model" }}}',
				'condition'   => [
					'data_source' => 'repeater',
				],
			]
		);

		$this->add_control(
			'global_image_visibility_heading',
			[
				'label' => esc_html__( 'Image Visibility', 'perfect-hot-tub-finder' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'show_product_image',
			[
				'label'        => esc_html__( 'Show Product Image', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_background_image',
			[
				'label'        => esc_html__( 'Show Background / Lifestyle Image', 'perfect-hot-tub-finder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'perfect-hot-tub-finder' ),
				'label_off'    => esc_html__( 'No', 'perfect-hot-tub-finder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);


		$this->add_control(
			'view_button_text',
			[
				'label'   => esc_html__( 'View Button Text', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'View Model', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'compare_button_text',
			[
				'label'   => esc_html__( 'Compare Button Text', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Compare Models', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'results_label',
			[
				'label'   => esc_html__( 'Results Label', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Results', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'empty_message',
			[
				'label'   => esc_html__( 'Empty Results Message', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'No hot tubs match your selected filters.', 'perfect-hot-tub-finder' ),
			]
		);

		$this->end_controls_section();
	}

	private function register_style_controls() {
		$this->start_controls_section(
			'section_typography',
			[
				'label' => esc_html__( 'Fonts / Typography', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'base_typography',
				'label'          => esc_html__( 'Base Font', 'perfect-hot-tub-finder' ),
				'selector'       => '{{WRAPPER}} .phtf-widget',
				'fields_options' => [
					'font_family' => [ 'default' => 'Questrial' ],
					'font_weight' => [ 'default' => '400' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'title_typography',
				'label'          => esc_html__( 'Main Title', 'perfect-hot-tub-finder' ),
				'selector'       => '{{WRAPPER}} .phtf-title',
				'fields_options' => [
					'font_family' => [ 'default' => 'Questrial' ],
					'font_weight' => [ 'default' => '700' ],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'button_typography',
				'label'          => esc_html__( 'Buttons', 'perfect-hot-tub-finder' ),
				'selector'       => '{{WRAPPER}} .phtf-button',
				'fields_options' => [
					'font_family' => [ 'default' => 'Questrial' ],
					'font_weight' => [ 'default' => '700' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_model_series_style',
			[
				'label' => esc_html__( 'Model & Series', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'model_heading',
			[
				'label' => esc_html__( 'Brand / Model', 'perfect-hot-tub-finder' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'model_color',
			[
				'label'     => esc_html__( 'Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtf-product-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'model_typography',
				'label'          => esc_html__( 'Font Style', 'perfect-hot-tub-finder' ),
				'selector'       => '{{WRAPPER}} .phtf-product-title',
				'fields_options' => [
					'font_family' => [ 'default' => 'Questrial' ],
					'font_weight' => [ 'default' => '700' ],
				],
			]
		);

		$this->add_responsive_control(
			'model_bottom_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 60 ],
					'em'  => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
					'rem' => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 12, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-product-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'series_heading',
			[
				'label'     => esc_html__( 'Series', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'series_color',
			[
				'label'     => esc_html__( 'Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtf-series' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'series_typography',
				'label'          => esc_html__( 'Font Style', 'perfect-hot-tub-finder' ),
				'selector'       => '{{WRAPPER}} .phtf-series',
				'fields_options' => [
					'font_family' => [ 'default' => 'Questrial' ],
					'font_weight' => [ 'default' => '700' ],
				],
			]
		);

		$this->add_responsive_control(
			'series_bottom_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 60 ],
					'em'  => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
					'rem' => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 14, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-series' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_price_text_style',
			[
				'label' => esc_html__( 'Price Text & Footnotes', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_value_color',
			[
				'label'     => esc_html__( 'MSRP / Monthly Price Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-price-value-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_footnote_marker_color',
			[
				'label'     => esc_html__( 'Footnote ¹ / ² Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-price-footnote-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_footnote_marker_size',
			[
				'label'      => esc_html__( 'Footnote ¹ / ² Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'em', 'px', 'rem' ],
				'range'      => [
					'em'  => [ 'min' => 0.3, 'max' => 1.2, 'step' => 0.05 ],
					'px'  => [ 'min' => 6, 'max' => 24 ],
					'rem' => [ 'min' => 0.3, 'max' => 1.2, 'step' => 0.05 ],
				],
				'default'    => [ 'size' => 0.65, 'unit' => 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-msrp .phtf-price-note-trigger sup, {{WRAPPER}} .phtf-msrp .phtf-price-note-link sup' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_footnote_marker_top_offset',
			[
				'label'      => esc_html__( 'Footnote ¹ / ² Top Offset', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'em', 'px', 'rem' ],
				'range'      => [
					'em'  => [ 'min' => -1, 'max' => 1, 'step' => 0.05 ],
					'px'  => [ 'min' => -20, 'max' => 20 ],
					'rem' => [ 'min' => -1, 'max' => 1, 'step' => 0.05 ],
				],
				'default'    => [ 'size' => 0, 'unit' => 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-msrp .phtf-price-note-trigger sup, {{WRAPPER}} .phtf-msrp .phtf-price-note-link sup' => 'position: relative; top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_footnote_popup_width',
			[
				'label'      => esc_html__( 'Popup Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 260, 'max' => 900 ],
					'vw' => [ 'min' => 30, 'max' => 95 ],
				],
				'default'    => [ 'size' => 540, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-price-popup-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_footnote_popup_max_height',
			[
				'label'      => esc_html__( 'Popup Max Height', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 180, 'max' => 900 ],
					'vh' => [ 'min' => 20, 'max' => 90 ],
				],
				'default'    => [ 'size' => 520, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-price-popup-max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_slide_arrows',
			[
				'label' => esc_html__( 'Slide Arrows', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'slide_arrow_nav_gap',
			[
				'label'      => esc_html__( 'Arrow / Label Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 80 ],
					'em'  => [ 'min' => 0, 'max' => 6, 'step' => 0.1 ],
					'rem' => [ 'min' => 0, 'max' => 6, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 18, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-results-nav' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slide_arrow_size',
			[
				'label'      => esc_html__( 'Arrow Icon Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 12, 'max' => 120 ],
					'em'  => [ 'min' => 0.5, 'max' => 8, 'step' => 0.1 ],
					'rem' => [ 'min' => 0.5, 'max' => 8, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 20, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slide_arrow_box_size',
			[
				'label'      => esc_html__( 'Arrow Box Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 20, 'max' => 120 ],
					'em'  => [ 'min' => 1, 'max' => 8, 'step' => 0.1 ],
					'rem' => [ 'min' => 1, 'max' => 8, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 25, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slide_arrow_padding',
			[
				'label'      => esc_html__( 'Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'slide_arrow_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-arrow' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
				],
			]
		);

		$this->add_responsive_control(
			'slide_arrow_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default'    => [
					'top'      => 5,
					'right'    => 5,
					'bottom'   => 5,
					'left'     => 5,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .phtf-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'slide_arrow_style_tabs' );

		$this->start_controls_tab(
			'slide_arrow_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'slide_arrow_normal_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-arrow-normal: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_arrow_normal_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => 'rgba(255,255,255,0)',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-arrow-bg-normal: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_arrow_normal_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'default'   => 'rgba(255,255,255,0)',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-arrow-border-normal: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'slide_arrow_normal_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-arrow',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slide_arrow_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'slide_arrow_hover_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-arrow-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_arrow_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-arrow-bg-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_arrow_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-arrow-border-hover: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'slide_arrow_hover_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-arrow:hover, {{WRAPPER}} .phtf-arrow:focus-visible',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slide_arrow_tab_active',
			[
				'label' => esc_html__( 'Active', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'slide_arrow_active_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-arrow-active: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_arrow_active_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-arrow-bg-active: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_arrow_active_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-arrow-border-active: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'slide_arrow_active_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-arrow:active, {{WRAPPER}} .phtf-arrow.is-active',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'slide_arrow_disabled_opacity',
			[
				'label'      => esc_html__( 'Disabled Opacity', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [ 'min' => 0.05, 'max' => 1, 'step' => 0.05 ],
				],
				'default'    => [ 'size' => 0.3 ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-arrow[disabled]' => 'opacity: {{SIZE}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'widget_min_height',
			[
				'label'      => esc_html__( 'Minimum Height', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 420, 'max' => 900 ],
					'vh' => [ 'min' => 40, 'max' => 100 ],
				],
				'default'        => [ 'size' => 625, 'unit' => 'px' ],
				'laptop_default' => [ 'size' => 590, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-widget' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'product_content_vertical_position',
			[
				'label'                => esc_html__( 'Left Area Position', 'perfect-hot-tub-finder' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'top'    => [
						'title' => esc_html__( 'Top', 'perfect-hot-tub-finder' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'perfect-hot-tub-finder' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'              => 'center',
				'toggle'               => false,
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'center' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors'            => [
					'{{WRAPPER}} .phtf-widget--classic' => '--phtf-left-area-justify: {{VALUE}};',
				],
				'separator'            => 'before',
			]
		);

		$this->add_responsive_control(
			'product_content_vertical_offset',
			[
				'label'      => esc_html__( 'Left Area Custom Offset', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => -100, 'max' => 260 ],
					'vh' => [ 'min' => -10, 'max' => 30 ],
				],
				'description' => esc_html__( 'Moves the full left area together: filters, results, product details, and buttons.', 'perfect-hot-tub-finder' ),
				'selectors'  => [
					'{{WRAPPER}} .phtf-widget--classic' => '--phtf-left-area-custom-offset: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .phtf-left-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .phtf-widget--classic' => '--phtf-content-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'filter_width',
			[
				'label'      => esc_html__( 'Filter Column Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 110, 'max' => 260 ] ],
				'default'        => [ 'size' => 150, 'unit' => 'px' ],
				'laptop_default' => [ 'size' => 150, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-filters' => 'width: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_mobile_filter_drawer_style',
			[
				'label' => esc_html__( 'Mobile Filter Drawer', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'mobile_filter_drawer_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'These color options apply to the tablet/mobile slide-in filter drawer only. Desktop filters keep the normal layout.', 'perfect-hot-tub-finder' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'mobile_filter_button_heading',
			[
				'label'     => esc_html__( 'Filter Button', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mobile_filter_button_bg_color',
			[
				'label'     => esc_html__( 'Button Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-button-bg: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_button_text_color',
			[
				'label'     => esc_html__( 'Button Text', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-button-text: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_button_hover_bg_color',
			[
				'label'     => esc_html__( 'Button Hover Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-button-hover-bg: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_button_hover_text_color',
			[
				'label'     => esc_html__( 'Button Hover Text', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-button-hover-text: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_drawer_heading',
			[
				'label'     => esc_html__( 'Drawer', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mobile_filter_drawer_bg_color',
			[
				'label'     => esc_html__( 'Drawer Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-drawer-bg: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => 'rgba(0, 38, 61, 0.22)',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-overlay: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_border' ],
				'default'   => 'rgba(0, 38, 61, 0.17)',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-divider: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_header_heading',
			[
				'label'     => esc_html__( 'Top Bar / Back Button', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mobile_filter_header_bg_color',
			[
				'label'     => esc_html__( 'Top Bar Background', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-header-bg: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_back_text_color',
			[
				'label'     => esc_html__( 'Back Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-back-text: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_back_hover_color',
			[
				'label'     => esc_html__( 'Back Hover Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-back-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_group_heading',
			[
				'label'     => esc_html__( 'Filter Headings', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mobile_filter_heading_color',
			[
				'label'     => esc_html__( 'Heading Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-heading: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_heading_hover_color',
			[
				'label'     => esc_html__( 'Heading Hover/Focus Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-heading-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_chevron_color',
			[
				'label'     => esc_html__( 'Chevron Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-chevron: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_body_heading',
			[
				'label'     => esc_html__( 'Filter Options / Price Note', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mobile_filter_option_text_color',
			[
				'label'     => esc_html__( 'Option Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-option-text: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_checkbox_color',
			[
				'label'     => esc_html__( 'Checkbox Border / Active Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-checkbox: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_price_accent_color',
			[
				'label'     => esc_html__( 'Price Accent / Bold Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-price-accent: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_filter_price_note_color',
			[
				'label'     => esc_html__( 'Price Note Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-mobile-filter-note-text: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price_info_icon_style',
			[
				'label' => esc_html__( 'Price Info Icon', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'price_info_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 10, 'max' => 40 ],
				],
				'default'    => [ 'size' => 15, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-filter-group--price .phtf-info-icon, {{WRAPPER}} .phtf-filter-group--price .phtf-price-info-trigger' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_info_icon_font_size',
			[
				'label'      => esc_html__( 'Icon Font Size', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 8, 'max' => 24 ],
				],
				'default'    => [ 'size' => 10, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-filter-group--price .phtf-info-icon, {{WRAPPER}} .phtf-filter-group--price .phtf-price-info-trigger' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_info_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .phtf-filter-group--price .phtf-info-icon, {{WRAPPER}} .phtf-filter-group--price .phtf-price-info-trigger' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_info_icon_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .phtf-filter-group--price .phtf-info-icon, {{WRAPPER}} .phtf-filter-group--price .phtf-price-info-trigger' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_info_icon_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .phtf-filter-group--price .phtf-info-icon, {{WRAPPER}} .phtf-filter-group--price .phtf-price-info-trigger' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_info_icon_hover_heading',
			[
				'label'     => esc_html__( 'Hover', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'price_info_icon_hover_color',
			[
				'label'     => esc_html__( 'Hover Icon Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtf-filter-group--price .phtf-price-info-trigger:hover, {{WRAPPER}} .phtf-filter-group--price .phtf-price-info-trigger:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_info_icon_hover_border_color',
			[
				'label'     => esc_html__( 'Hover Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtf-filter-group--price .phtf-price-info-trigger:hover, {{WRAPPER}} .phtf-filter-group--price .phtf-price-info-trigger:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_info_icon_hover_background_color',
			[
				'label'     => esc_html__( 'Hover Background Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .phtf-filter-group--price .phtf-price-info-trigger:hover, {{WRAPPER}} .phtf-filter-group--price .phtf-price-info-trigger:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_info_popup_style_heading',
			[
				'label'     => esc_html__( 'Popup Text', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'price_info_popup_title_color',
			[
				'label'     => esc_html__( 'Popup Title Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-price-info-title-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_info_popup_text_color',
			[
				'label'     => esc_html__( 'Popup Body Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=text' ],
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-price-info-text-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_info_popup_accent_color',
			[
				'label'     => esc_html__( 'Popup Accent / Bold Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtf-widget' => '--phtf-price-info-accent-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'price_info_popup_title_typography',
				'label'          => esc_html__( 'Popup Title Font', 'perfect-hot-tub-finder' ),
				'selector'       => '{{WRAPPER}} .phtf-price-note-popup--price-info .phtf-price-note-popup-title',
				'fields_options' => [
					'font_family' => [ 'default' => 'Questrial' ],
					'font_weight' => [ 'default' => '700' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'price_info_popup_body_typography',
				'label'          => esc_html__( 'Popup Body Font', 'perfect-hot-tub-finder' ),
				'selector'       => '{{WRAPPER}} .phtf-price-note-popup--price-info, {{WRAPPER}} .phtf-price-note-popup--price-info p',
				'fields_options' => [
					'font_family' => [ 'default' => 'Questrial' ],
					'font_weight' => [ 'default' => '400' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_images_style',
			[
				'label' => esc_html__( 'Product & Background Images', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_image_style_heading',
			[
				'label' => esc_html__( 'Product Image', 'perfect-hot-tub-finder' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'product_image_width',
			[
				'label'      => esc_html__( 'Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 80, 'max' => 700 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
					'vw' => [ 'min' => 10, 'max' => 80 ],
				],
				'default'        => [ 'size' => 250, 'unit' => 'px' ],
				'laptop_default' => [ 'size' => 250, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-product-image, {{WRAPPER}} .phtf-widget.phtf-widget--classic .phtf-product-image' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; aspect-ratio: 1 / 1;',
				],
			]
		);

		$this->add_responsive_control(
			'product_image_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 80, 'max' => 900 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
					'vw' => [ 'min' => 10, 'max' => 100 ],
				],
				'default'        => [ 'size' => 250, 'unit' => 'px' ],
				'laptop_default' => [ 'size' => 250, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-product-image' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_image_display_height',
			[
				'label'      => esc_html__( 'Height', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 60, 'max' => 800 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
					'vh' => [ 'min' => 5, 'max' => 90 ],
					'vw' => [ 'min' => 5, 'max' => 80 ],
				],
				'default'        => [ 'size' => 30, 'unit' => 'vh' ],
				'laptop_default' => [ 'size' => 30, 'unit' => 'vh' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-product-image, {{WRAPPER}} .phtf-widget.phtf-widget--classic .phtf-product-image' => 'height: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}}; aspect-ratio: auto;',
				],
			]
		);

		$this->add_control(
			'product_image_object_fit',
			[
				'label'     => esc_html__( 'Image Fit', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					'cover'   => esc_html__( 'Cover', 'perfect-hot-tub-finder' ),
					'contain' => esc_html__( 'Contain', 'perfect-hot-tub-finder' ),
					'fill'    => esc_html__( 'Fill', 'perfect-hot-tub-finder' ),
				],
				'selectors' => [
					'{{WRAPPER}} .phtf-product-image' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_image_right_position',
			[
				'label'      => esc_html__( 'Desktop Position From Right', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range'      => [
					'%'  => [ 'min' => 0, 'max' => 100 ],
					'px' => [ 'min' => -300, 'max' => 900 ],
					'vw' => [ 'min' => -20, 'max' => 100 ],
				],
				'default'        => [ 'size' => 40, 'unit' => '%' ],
				'laptop_default' => [ 'size' => 40, 'unit' => '%' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-product-image' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_image_top_position',
			[
				'label'      => esc_html__( 'Vertical Position', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vh' ],
				'range'      => [
					'%'  => [ 'min' => 0, 'max' => 100 ],
					'px' => [ 'min' => -200, 'max' => 900 ],
					'vh' => [ 'min' => 0, 'max' => 100 ],
				],
				'default'        => [ 'size' => 50, 'unit' => '%' ],
				'laptop_default' => [ 'size' => 50, 'unit' => '%' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-product-image' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_image_translate_x',
			[
				'label'      => esc_html__( 'Horizontal Offset', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [ 'min' => -100, 'max' => 100 ],
					'px' => [ 'min' => -300, 'max' => 300 ],
				],
				'default'        => [ 'size' => 50, 'unit' => '%' ],
				'laptop_default' => [ 'size' => 50, 'unit' => '%' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-product-image' => '--phtf-product-image-translate-x: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_image_translate_y',
			[
				'label'      => esc_html__( 'Vertical Offset', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [ 'min' => -100, 'max' => 100 ],
					'px' => [ 'min' => -300, 'max' => 300 ],
				],
				'default'        => [ 'size' => -50, 'unit' => '%' ],
				'laptop_default' => [ 'size' => -50, 'unit' => '%' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-product-image' => '--phtf-product-image-translate-y: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_image_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 15,
					'right'    => 15,
					'bottom'   => 15,
					'left'     => 15,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'laptop_default' => [
					'top'      => 15,
					'right'    => 15,
					'bottom'   => 15,
					'left'     => 15,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .phtf-product-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_image_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ '' => [ 'min' => 0, 'max' => 1, 'step' => 0.01 ] ],
				'default'   => [ 'size' => 1 ],
				'selectors' => [
					'{{WRAPPER}} .phtf-product-image' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'product_image_z_index',
			[
				'label'     => esc_html__( 'Z-Index', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 25,
				'min'       => 0,
				'max'       => 100,
				'selectors' => [
					'{{WRAPPER}} .phtf-product-image' => 'z-index: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'product_image_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-product-image',
			]
		);

		$this->add_control(
			'background_image_style_heading',
			[
				'label'     => esc_html__( 'Background / Lifestyle Image', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'background_image_width',
			[
				'label'      => esc_html__( 'Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range'      => [
					'%'  => [ 'min' => 10, 'max' => 100 ],
					'px' => [ 'min' => 120, 'max' => 1400 ],
					'vw' => [ 'min' => 10, 'max' => 100 ],
				],
				'default'        => [ 'size' => 48, 'unit' => '%' ],
				'laptop_default' => [ 'size' => 46, 'unit' => '%' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-hero-bg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'background_image_mobile_banner_height',
			[
				'label'          => esc_html__( 'Tablet / Mobile Banner Height', 'perfect-hot-tub-finder' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px', 'vw' ],
				'range'          => [
					'px' => [ 'min' => 100, 'max' => 420 ],
					'vw' => [ 'min' => 15, 'max' => 70 ],
				],
				'default'        => [ 'size' => 260, 'unit' => 'px' ],
				'laptop_default' => [ 'size' => 260, 'unit' => 'px' ],
				'tablet_default' => [ 'size' => 260, 'unit' => 'px' ],
				'mobile_default' => [ 'size' => 220, 'unit' => 'px' ],
				'description'    => esc_html__( 'Controls the lifestyle-image banner height when the filters switch to the tablet/mobile drawer layout.', 'perfect-hot-tub-finder' ),
				'selectors'      => [
					'{{WRAPPER}} .phtf-widget--classic' => '--phtf-mobile-banner-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'background_image_height',
			[
				'label'      => esc_html__( 'Height', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', '%' ],
				'range'      => [
					'px' => [ 'min' => 120, 'max' => 1000 ],
					'vh' => [ 'min' => 10, 'max' => 100 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
				],
				'default'        => [ 'size' => 100, 'unit' => 'vh' ],
				'laptop_default' => [ 'size' => 100, 'unit' => 'vh' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-widget.phtf-widget--classic .phtf-hero-bg, {{WRAPPER}} .phtf-hero-bg' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hero_image_position',
			[
				'label'     => esc_html__( 'Background Position', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center center',
				'options'   => [
					'center center' => esc_html__( 'Center', 'perfect-hot-tub-finder' ),
					'top center'    => esc_html__( 'Top', 'perfect-hot-tub-finder' ),
					'bottom center' => esc_html__( 'Bottom', 'perfect-hot-tub-finder' ),
					'center left'   => esc_html__( 'Left', 'perfect-hot-tub-finder' ),
					'center right'  => esc_html__( 'Right', 'perfect-hot-tub-finder' ),
				],
				'selectors' => [
					'{{WRAPPER}} .phtf-hero-bg' => 'background-position: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_image_size',
			[
				'label'     => esc_html__( 'Background Size', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					'cover'   => esc_html__( 'Cover', 'perfect-hot-tub-finder' ),
					'contain' => esc_html__( 'Contain', 'perfect-hot-tub-finder' ),
					'auto'    => esc_html__( 'Auto', 'perfect-hot-tub-finder' ),
				],
				'selectors' => [
					'{{WRAPPER}} .phtf-hero-bg' => 'background-size: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_image_repeat',
			[
				'label'     => esc_html__( 'Background Repeat', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'no-repeat',
				'options'   => [
					'no-repeat' => esc_html__( 'No Repeat', 'perfect-hot-tub-finder' ),
					'repeat'    => esc_html__( 'Repeat', 'perfect-hot-tub-finder' ),
					'repeat-x'  => esc_html__( 'Repeat X', 'perfect-hot-tub-finder' ),
					'repeat-y'  => esc_html__( 'Repeat Y', 'perfect-hot-tub-finder' ),
				],
				'selectors' => [
					'{{WRAPPER}} .phtf-hero-bg' => 'background-repeat: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'background_image_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'laptop_default' => [
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .phtf-hero-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'background_image_opacity',
			[
				'label'     => esc_html__( 'Image Opacity', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ '' => [ 'min' => 0, 'max' => 1, 'step' => 0.01 ] ],
				'default'   => [ 'size' => 1 ],
				'selectors' => [
					'{{WRAPPER}} .phtf-hero-bg' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'background_overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0)',
				'selectors' => [
					'{{WRAPPER}} .phtf-hero-bg::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_overlay_opacity',
			[
				'label'     => esc_html__( 'Overlay Opacity', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ '' => [ 'min' => 0, 'max' => 1, 'step' => 0.01 ] ],
				'default'   => [ 'size' => 1 ],
				'selectors' => [
					'{{WRAPPER}} .phtf-hero-bg::after' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'background_curve_display',
			[
				'label'     => esc_html__( 'Curved Cutout', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'block',
				'options'   => [
					'block' => esc_html__( 'Show', 'perfect-hot-tub-finder' ),
					'none'  => esc_html__( 'Hide', 'perfect-hot-tub-finder' ),
				],
				'selectors' => [
					'{{WRAPPER}} .phtf-hero-bg::before' => 'display: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'background_curve_width',
			[
				'label'      => esc_html__( 'Curved Cutout Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 600 ],
					'%'  => [ 'min' => 0, 'max' => 100 ],
					'vw' => [ 'min' => 0, 'max' => 60 ],
				],
				'default'        => [ 'size' => 25, 'unit' => '%' ],
				'laptop_default' => [ 'size' => 25, 'unit' => '%' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-hero-bg::before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'background_curve_offset',
			[
				'label'      => esc_html__( 'Curved Cutout Offset', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => -500, 'max' => 300 ],
					'%'  => [ 'min' => -100, 'max' => 100 ],
					'vw' => [ 'min' => -80, 'max' => 40 ],
				],
				'default'        => [ 'size' => -8, 'unit' => '%' ],
				'laptop_default' => [ 'size' => -8, 'unit' => '%' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-hero-bg::before' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_buttons_layout',
			[
				'label' => esc_html__( 'Buttons Layout', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'buttons_alignment',
			[
				'label'   => esc_html__( 'Position', 'perfect-hot-tub-finder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'perfect-hot-tub-finder' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'perfect-hot-tub-finder' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'perfect-hot-tub-finder' ),
						'icon'  => 'eicon-text-align-right',
					],
					'space-between' => [
						'title' => esc_html__( 'Space Between', 'perfect-hot-tub-finder' ),
						'icon'  => 'eicon-h-align-stretch',
					],
				],
				'default'   => 'flex-start',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .phtf-actions' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'buttons_gap',
			[
				'label'      => esc_html__( 'Button Gap', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 60 ],
					'em' => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 14, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-actions' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'primary_button_min_width',
			[
				'label'      => esc_html__( 'Primary Button Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'min' => 80, 'max' => 340 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
					'em' => [ 'min' => 5, 'max' => 24, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 145, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-button--primary' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'secondary_button_min_width',
			[
				'label'      => esc_html__( 'Secondary Button Width', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'min' => 80, 'max' => 380 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
					'em' => [ 'min' => 5, 'max' => 26, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 184, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .phtf-button--secondary' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_primary_button',
			[
				'label' => esc_html__( 'Primary Button', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'primary_button_typography',
				'label'          => esc_html__( 'Typography', 'perfect-hot-tub-finder' ),
				'selector'       => '{{WRAPPER}} .phtf-button--primary',
				'fields_options' => [
					'font_family' => [ 'default' => 'Questrial' ],
					'font_weight' => [ 'default' => '700' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'primary_button_text_shadow',
				'label'    => esc_html__( 'Text Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-button--primary',
			]
		);

		$this->start_controls_tabs( 'primary_button_tabs' );

		$this->start_controls_tab(
			'primary_button_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'primary_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .phtf-button--primary' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'primary_button_background',
				'label'          => esc_html__( 'Background Type', 'perfect-hot-tub-finder' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => '{{WRAPPER}} .phtf-button--primary',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color'      => [ 'default' => '#85D9DE' ],
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'primary_button_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-button--primary',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'primary_button_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'primary_button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .phtf-button--primary:hover, {{WRAPPER}} .phtf-button--primary:focus-visible' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'primary_button_hover_background',
				'label'          => esc_html__( 'Background Type', 'perfect-hot-tub-finder' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => '{{WRAPPER}} .phtf-button--primary:hover, {{WRAPPER}} .phtf-button--primary:focus-visible',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color'      => [ 'default' => '#00263D' ],
				],
			]
		);

		$this->add_control(
			'primary_button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=primary' ],
				'default'   => '#00263D',
				'selectors' => [
					'{{WRAPPER}} .phtf-button--primary:hover, {{WRAPPER}} .phtf-button--primary:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'primary_button_hover_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-button--primary:hover, {{WRAPPER}} .phtf-button--primary:focus-visible',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'primary_button_border',
				'label'          => esc_html__( 'Border Type', 'perfect-hot-tub-finder' ),
				'selector'       => '{{WRAPPER}} .phtf-button--primary',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'color'  => [ 'default' => '#85D9DE' ],
					'width'  => [
						'default' => [
							'top'      => 2,
							'right'    => 2,
							'bottom'   => 2,
							'left'     => 2,
							'unit'     => 'px',
							'isLinked' => true,
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'primary_button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 999,
					'right'    => 999,
					'bottom'   => 999,
					'left'     => 999,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .phtf-button--primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'primary_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 10,
					'right'    => 30,
					'bottom'   => 10,
					'left'     => 30,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .phtf-button--primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_secondary_button',
			[
				'label' => esc_html__( 'Secondary Button', 'perfect-hot-tub-finder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'secondary_button_typography',
				'label'          => esc_html__( 'Typography', 'perfect-hot-tub-finder' ),
				'selector'       => '{{WRAPPER}} .phtf-button--secondary',
				'fields_options' => [
					'font_family' => [ 'default' => 'Questrial' ],
					'font_weight' => [ 'default' => '700' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'secondary_button_text_shadow',
				'label'    => esc_html__( 'Text Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-button--secondary',
			]
		);

		$this->start_controls_tabs( 'secondary_button_tabs' );

		$this->start_controls_tab(
			'secondary_button_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'secondary_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtf-button--secondary' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'secondary_button_background',
				'label'          => esc_html__( 'Background Type', 'perfect-hot-tub-finder' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => '{{WRAPPER}} .phtf-button--secondary',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color'      => [ 'default' => 'rgba(255,255,255,0)' ],
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'secondary_button_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-button--secondary',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'secondary_button_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'perfect-hot-tub-finder' ),
			]
		);

		$this->add_control(
			'secondary_button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=hol_white' ],
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .phtf-button--secondary:hover, {{WRAPPER}} .phtf-button--secondary:focus-visible' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'secondary_button_hover_background',
				'label'          => esc_html__( 'Background Type', 'perfect-hot-tub-finder' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => '{{WRAPPER}} .phtf-button--secondary:hover, {{WRAPPER}} .phtf-button--secondary:focus-visible',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color'      => [ 'default' => '#85D9DE' ],
				],
			]
		);

		$this->add_control(
			'secondary_button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'perfect-hot-tub-finder' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [ 'default' => 'globals/colors?id=secondary' ],
				'default'   => '#85D9DE',
				'selectors' => [
					'{{WRAPPER}} .phtf-button--secondary:hover, {{WRAPPER}} .phtf-button--secondary:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'secondary_button_hover_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'perfect-hot-tub-finder' ),
				'selector' => '{{WRAPPER}} .phtf-button--secondary:hover, {{WRAPPER}} .phtf-button--secondary:focus-visible',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'secondary_button_border',
				'label'          => esc_html__( 'Border Type', 'perfect-hot-tub-finder' ),
				'selector'       => '{{WRAPPER}} .phtf-button--secondary',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'color'  => [ 'default' => '#85D9DE' ],
					'width'  => [
						'default' => [
							'top'      => 2,
							'right'    => 2,
							'bottom'   => 2,
							'left'     => 2,
							'unit'     => 'px',
							'isLinked' => true,
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'secondary_button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 999,
					'right'    => 999,
					'bottom'   => 999,
					'left'     => 999,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .phtf-button--secondary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'secondary_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'perfect-hot-tub-finder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 10,
					'right'    => 30,
					'bottom'   => 10,
					'left'     => 30,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .phtf-button--secondary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Return editable breadcrumb items while preserving the legacy Home / Current fields.
	 *
	 * @param array $settings Elementor display settings.
	 * @return array
	 */
	private function get_breadcrumb_items( $settings ) {
		$raw_settings = $this->get_data( 'settings' );
		$has_saved_repeater = is_array( $raw_settings ) && array_key_exists( 'breadcrumbs', $raw_settings );

		if ( $has_saved_repeater ) {
			$items = ! empty( $settings['breadcrumbs'] ) && is_array( $settings['breadcrumbs'] ) ? $settings['breadcrumbs'] : [];
		} else {
			$home_label    = ! empty( $settings['breadcrumb_home'] ) ? $settings['breadcrumb_home'] : esc_html__( 'Home', 'perfect-hot-tub-finder' );
			$current_label = ! empty( $settings['breadcrumb_current'] ) ? $settings['breadcrumb_current'] : esc_html__( 'Shop', 'perfect-hot-tub-finder' );
			$items = [
				[
					'label' => $home_label,
					'link'  => [ 'url' => '' ],
				],
				[
					'label'  => $current_label,
					'active' => 'yes',
				],
			];
		}

		$normalized = [];
		$active_found = false;
		foreach ( $items as $item ) {
			$label = isset( $item['label'] ) ? trim( (string) $item['label'] ) : '';
			if ( '' === $label ) {
				continue;
			}

			$is_active = ! $active_found && 'yes' === ( $item['active'] ?? '' );
			if ( $is_active ) {
				$active_found = true;
			}

			$normalized[] = [
				'label'  => $label,
				'link'   => ! empty( $item['link'] ) && is_array( $item['link'] ) ? $item['link'] : [],
				'active' => $is_active ? 'yes' : '',
			];
		}

		return $normalized;
	}

	/**
	 * Normalize Elementor repeater filter options with a reliable default fallback.
	 *
	 * @param mixed $items Elementor repeater items.
	 * @param array $defaults Default label/value pairs.
	 * @return array
	 */
	private function get_filter_options( $items, $defaults ) {
		$source = is_array( $items ) && ! empty( $items ) ? $items : $defaults;
		$options = [];

		foreach ( $source as $item ) {
			$label = isset( $item['label'] ) ? trim( (string) $item['label'] ) : '';
			$value = isset( $item['value'] ) ? trim( (string) $item['value'] ) : '';

			if ( '' === $label || '' === $value ) {
				continue;
			}

			$options[] = [
				'label' => $label,
				'value' => $value,
			];
		}

		return ! empty( $options ) ? $options : $defaults;
	}

	private function render_rating( $rating ) {
		$rating = floatval( $rating );
		$rating = max( 0, min( 5, $rating ) );
		$full   = floor( $rating );
		$half   = ( $rating - $full ) >= 0.5;
		$output = '';

		for ( $i = 1; $i <= 5; $i++ ) {
			$class = 'phtf-star';
			if ( $i <= $full ) {
				$class .= ' is-full';
			} elseif ( $half && $i === ( $full + 1 ) ) {
				$class .= ' is-half';
			}
			$output .= '<span class="' . esc_attr( $class ) . '" aria-hidden="true">★</span>';
		}

		return '<span class="screen-reader-text">' . esc_html( sprintf( __( '%s out of 5 stars', 'perfect-hot-tub-finder' ), $rating ) ) . '</span>' . $output;
	}

	private function render_link_attrs( $link ) {
		if ( empty( $link['url'] ) ) {
			return 'href="#"';
		}

		$attrs = 'href="' . esc_url( $link['url'] ) . '"';

		if ( ! empty( $link['is_external'] ) ) {
			$attrs .= ' target="_blank"';
		}

		if ( ! empty( $link['nofollow'] ) ) {
			$attrs .= ' rel="nofollow"';
		}

		return $attrs;
	}

    private function get_default_price_note_popup_content( $note_number = '1' ) {
        if ( '2' === (string) $note_number ) {
            return __( "Pricing is for U.S. only.\n\n2. Pricing and promotional details may vary by model, configuration, options, delivery, installation, taxes, dealer charges, finance charges, and local market factors. Dealers have sole discretion to set actual prices, which will vary.", 'perfect-hot-tub-finder' );
        }

        return __( "Pricing is for U.S. only.\n\n1. Prices listed are the Manufacturer’s Suggested Retail Price (MSRP) for base models. Options such as water care, steps, cover lifters, accessories and delivery are available at an additional cost. Prices exclude tax, destination charges, installation costs, finance charges, surcharges (attributable to raw material costs in the product supply chain), additional dealer charges, if any, and other local factors. Dealers have sole discretion to set actual prices, which will vary.", 'perfect-hot-tub-finder' );
    }

    private function normalize_price_note_number( $note_text ) {
        $map = [
            '¹' => '1',
            '²' => '2',
            '³' => '3',
            '⁴' => '4',
            '⁵' => '5',
            '⁶' => '6',
            '⁷' => '7',
            '⁸' => '8',
            '⁹' => '9',
        ];

        return $map[ $note_text ] ?? (string) $note_text;
    }

    private function render_price_note_popup_content( $content, $note_text ) {
        $content = trim( (string) $content );

        if ( '' === $content ) {
            return [
                'id'     => '',
                'markup' => '',
            ];
        }

        $popup_id   = 'phtf-price-note-popup-' . wp_unique_id();
        $paragraphs = preg_split( '/\R{2,}/', $content );
        $output     = '<span id="' . esc_attr( $popup_id ) . '" class="phtf-price-note-popup" role="tooltip">';
        $output    .= '<button type="button" class="phtf-price-note-close" aria-label="' . esc_attr__( 'Close pricing note', 'perfect-hot-tub-finder' ) . '">×</button>';
        $output    .= '<span class="phtf-price-note-popup-scroll">';

        foreach ( $paragraphs as $index => $paragraph ) {
            $paragraph = trim( (string) $paragraph );
            if ( '' === $paragraph ) {
                continue;
            }
            $class   = 0 === $index ? 'phtf-price-note-intro' : 'phtf-price-note-body';
            $output .= '<p class="' . esc_attr( $class ) . '">' . nl2br( esc_html( $paragraph ) ) . '</p>';
        }

        $output .= '</span>';
        $output .= '</span>';

        return [
            'id'     => $popup_id,
            'markup' => $output,
        ];
    }

    private function render_price_info_popup_content( $title = '', $content = '' ) {
        $content = trim( (string) $content );
        $title   = trim( (string) $title );

        if ( '' === $content && '' === $title ) {
            return [
                'id'     => '',
                'markup' => '',
            ];
        }

        $popup_id = 'phtf-price-info-popup-' . wp_unique_id();
        $output   = '<span id="' . esc_attr( $popup_id ) . '" class="phtf-price-note-popup phtf-price-note-popup--price-info" role="tooltip">';
        $output  .= '<button type="button" class="phtf-price-note-close" aria-label="' . esc_attr__( 'Close price information', 'perfect-hot-tub-finder' ) . '">×</button>';
        $output  .= '<span class="phtf-price-note-popup-scroll">';

        if ( '' !== $title ) {
            $output .= '<span class="phtf-price-note-popup-title">' . esc_html( $title ) . '</span>';
        }

        if ( '' !== $content ) {
            $output .= wp_kses_post( $content );
        }

        $output .= '</span>';
        $output .= '</span>';

        return [
            'id'     => $popup_id,
            'markup' => $output,
        ];
    }

    private function get_price_info_icon_markup( $settings = [] ) {
        if ( ! empty( $settings['price_info_custom_icon']['value'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['price_info_custom_icon'], [ 'aria-hidden' => 'true' ] );
            $icon_markup = trim( ob_get_clean() );

            if ( '' !== $icon_markup ) {
                return $icon_markup;
            }
        }

        return '<span class="phtf-price-info-fallback">i</span>';
    }


    private function render_price_info_icon_popup( $settings = [] ) {
        $title   = $settings['price_info_popup_title'] ?? '';
        $content = $settings['price_info_popup_content'] ?? '';
        $popup   = $this->render_price_info_popup_content( $title, $content );

        if ( ! empty( $popup['markup'] ) ) {
            return '<span class="phtf-price-note-wrap phtf-price-info-wrap"><button type="button" class="phtf-price-note-trigger phtf-price-info-trigger phtf-info-icon" aria-expanded="false" aria-describedby="' . esc_attr( $popup['id'] ) . '" aria-label="' . esc_attr__( 'Price information', 'perfect-hot-tub-finder' ) . '">' . $this->get_price_info_icon_markup( $settings ) . '</button>' . $popup['markup'] . '</span>';
        }

        return '<span class="phtf-info-icon" title="' . esc_attr__( 'Price tiers can be customized in this widget.', 'perfect-hot-tub-finder' ) . '">' . $this->get_price_info_icon_markup( $settings ) . '</span>';
    }

    private function render_price_note_marker( $note_text, $price_note_link = [], $price_note_link_2 = [], $popup_content = '', $popup_content_2 = '' ) {
        $note_number = $this->normalize_price_note_number( $note_text );
        $link        = '2' === $note_number ? $price_note_link_2 : $price_note_link;
        $content     = '2' === $note_number ? $popup_content_2 : $popup_content;

        $popup = $this->render_price_note_popup_content( $content, $note_text );
        if ( ! empty( $popup['markup'] ) ) {
            return '<span class="phtf-price-note-wrap"><button type="button" class="phtf-price-note-trigger" aria-expanded="false" aria-describedby="' . esc_attr( $popup['id'] ) . '" aria-label="' . esc_attr( sprintf( __( 'Pricing footnote %s', 'perfect-hot-tub-finder' ), $note_number ) ) . '"><sup>' . esc_html( $note_text ) . '</sup></button>' . $popup['markup'] . '</span>';
        }

        if ( ! empty( $link['url'] ) ) {
            return '<a class="phtf-price-note-link" ' . $this->render_link_attrs( $link ) . '><sup>' . esc_html( $note_text ) . '</sup></a>';
        }

        return '<sup>' . esc_html( $note_text ) . '</sup>';
    }

    private function render_msrp_value( $msrp, $settings = [], $price_note_link = [], $price_note_link_2 = [], $popup_content = '', $popup_content_2 = '' ) {
        unset( $settings );

        $charset = get_bloginfo( 'charset' ) ? get_bloginfo( 'charset' ) : 'UTF-8';
        $msrp    = html_entity_decode( (string) $msrp, ENT_QUOTES, $charset );
        $parts   = preg_split( '/([¹²³⁴⁵⁶⁷⁸⁹])/u', $msrp, -1, PREG_SPLIT_DELIM_CAPTURE );

        if ( false === $parts || count( $parts ) < 2 ) {
            return esc_html( $msrp );
        }

        $output = '';
        foreach ( $parts as $part ) {
            if ( preg_match( '/^[¹²³⁴⁵⁶⁷⁸⁹]$/u', $part ) ) {
                $output .= $this->render_price_note_marker( $part, $price_note_link, $price_note_link_2, $popup_content, $popup_content_2 );
            } else {
                $output .= esc_html( $part );
            }
        }

        return $output;
    }

	private function sort_spa_shop_models_by_series( $models ) {
		$series_order = [
			'utopia'   => 0,
			'paradise' => 1,
			'vacanza'  => 2,
			'fantasy'  => 3,
		];

		foreach ( $models as $index => &$model ) {
			$model['_phtf_slider_original_index'] = $index;
		}
		unset( $model );

		usort(
			$models,
			function ( $a, $b ) use ( $series_order ) {
				$a_key = ! empty( $a['compare_category_key'] ) ? $a['compare_category_key'] : ( function_exists( 'phtf_compare_spa_category_key' ) ? phtf_compare_spa_category_key( $a['compare_category'] ?? '', $a['series'] ?? '', $a['series_display'] ?? '' ) : '' );
				$b_key = ! empty( $b['compare_category_key'] ) ? $b['compare_category_key'] : ( function_exists( 'phtf_compare_spa_category_key' ) ? phtf_compare_spa_category_key( $b['compare_category'] ?? '', $b['series'] ?? '', $b['series_display'] ?? '' ) : '' );

				$a_order = array_key_exists( $a_key, $series_order ) ? $series_order[ $a_key ] : 99;
				$b_order = array_key_exists( $b_key, $series_order ) ? $series_order[ $b_key ] : 99;

				if ( $a_order !== $b_order ) {
					return $a_order <=> $b_order;
				}

				$a_menu = isset( $a['menu_order'] ) ? (int) $a['menu_order'] : 0;
				$b_menu = isset( $b['menu_order'] ) ? (int) $b['menu_order'] : 0;
				if ( $a_menu !== $b_menu ) {
					return $a_menu <=> $b_menu;
				}

				$title_compare = strcasecmp( (string) ( $a['title'] ?? '' ), (string) ( $b['title'] ?? '' ) );
				if ( 0 !== $title_compare ) {
					return $title_compare;
				}

				return ( (int) ( $a['_phtf_slider_original_index'] ?? 0 ) ) <=> ( (int) ( $b['_phtf_slider_original_index'] ?? 0 ) );
			}
		);

		return $models;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$products = [];

		// Products can be managed from Spa Model posts or from the Elementor product repeater.
		$data_source = ! empty( $settings['data_source'] ) ? $settings['data_source'] : 'cpt';

		if ( 'cpt' === $data_source && function_exists( 'phtf_get_spa_models' ) ) {
			$spa_shop_models = $this->sort_spa_shop_models_by_series( phtf_get_spa_models() );

			foreach ( $spa_shop_models as $model ) {
				$products[] = [
					'brand'                 => $model['title'] ?? '',
					'series'                => ! empty( $model['series_display'] ) ? strtoupper( $model['series_display'] ) : strtoupper( ( $model['series'] ?? '' ) . ' SERIES' ),
					'rating'                => $model['rating'] ?? 0,
					'reviews'               => ! empty( $model['reviews'] ) ? $model['reviews'] . ' Reviews' : '',
					'msrp'                  => $model['price'] ?? '',
					'secondary_price'       => $model['secondary_price'] ?? '',
					'seating'               => $model['seating_capacity'] ?? '',
					'seating_group'         => $model['seating_filter'] ?? '',
					'seating_filter_value'  => $model['seating_filter'] ?? '',
					'dimensions'            => $model['dimensions'] ?? '',
					'jets'                  => $model['jet_count'] ?? ( $model['jets'] ?? '' ),
					'water_care'            => $model['water_care_systems'] ?? '',
					'price_group'           => $model['price_tier'] ?? '',
					'price_filter_value'    => $model['price_tier'] ?? '',
					'explore_series_label'  => $model['series'] ?? '',
					'explore_categories'    => $model['explore_categories'] ?? '',
					'product_image'         => [ 'url' => phtf_image_url_or_fallback( $model['image'] ?? '', 'product' ) ],
					'background_image'      => [ 'url' => phtf_image_url_or_fallback( ! empty( $model['lifestyle_image_url'] ) ? $model['lifestyle_image_url'] : ( $model['image'] ?? '' ), 'lifestyle' ) ],
					'view_link'             => [ 'url' => ! empty( $model['view_model_url'] ) ? $model['view_model_url'] : ( $model['url'] ?? '' ) ],
					'compare_link'          => [ 'url' => $model['compare_url'] ?? '' ],
					'title_link'            => [ 'url' => '' ],
					'reviews_link'          => [ 'url' => ! empty( $model['reviews_url'] ) ? $model['reviews_url'] : '' ],
					'price_note_link'       => [ 'url' => ! empty( $model['price_note_url'] ) ? $model['price_note_url'] : '' ],
					'price_note_link_2'     => [ 'url' => ! empty( $model['price_note_url_2'] ) ? $model['price_note_url_2'] : '' ],
					'price_note_popup_content'   => $model['price_note_popup_content'] ?? '',
					'price_note_popup_content_2' => $model['price_note_popup_content_2'] ?? '',
				];
			}
		}

		if ( ( 'repeater' === $data_source || empty( $products ) ) && ! empty( $settings['products'] ) && is_array( $settings['products'] ) ) {
			foreach ( $settings['products'] as $item ) {
				$product_image_url = '';
				if ( ! empty( $item['product_image']['url'] ) ) {
					$product_image_url = $item['product_image']['url'];
				} elseif ( ! empty( $item['image']['url'] ) ) {
					$product_image_url = $item['image']['url'];
				}
				$product_image_url = phtf_image_url_or_fallback( $product_image_url, 'product' );

				$background_image_url = '';
				if ( ! empty( $item['background_image']['url'] ) ) {
					$background_image_url = $item['background_image']['url'];
				} elseif ( ! empty( $item['lifestyle_image']['url'] ) ) {
					$background_image_url = $item['lifestyle_image']['url'];
				} elseif ( ! empty( $item['hero_image']['url'] ) ) {
					$background_image_url = $item['hero_image']['url'];
				}
				$background_image_url = phtf_image_url_or_fallback( $background_image_url, 'lifestyle' );

				$products[] = [
					'brand'                 => $item['brand'] ?? ( $item['title'] ?? ( $item['product_title'] ?? '' ) ),
					'series'                => $item['series'] ?? ( $item['series_display'] ?? '' ),
					'rating'                => $item['rating'] ?? 0,
					'reviews'               => $item['reviews'] ?? ( ! empty( $item['reviews_count'] ) ? $item['reviews_count'] . ' Reviews' : '' ),
					'msrp'                  => $item['msrp'] ?? ( $item['price'] ?? '' ),
					'secondary_price'       => $item['secondary_price'] ?? '',
					'seating'               => $item['seating'] ?? ( $item['seating_capacity'] ?? '' ),
					'seating_group'         => $item['seating_group'] ?? ( $item['seat'] ?? '' ),
					'seating_filter_value'  => $item['seating_filter_value'] ?? ( $item['seat'] ?? ( $item['seating_group'] ?? '' ) ),
					'dimensions'            => $item['dimensions'] ?? '',
					'jets'                  => $item['jets'] ?? ( $item['jet_count'] ?? '' ),
					'water_care'            => $item['water_care'] ?? ( $item['water_care_systems'] ?? '' ),
					'price_group'           => $item['price_group'] ?? ( $item['price'] ?? '' ),
					'price_filter_value'    => $item['price_filter_value'] ?? ( $item['price_group'] ?? '' ),
					'explore_series_label'  => $item['explore_series_label'] ?? '',
					'explore_categories'    => $item['explore_categories'] ?? '',
					'product_image'         => [ 'url' => $product_image_url ],
					'background_image'      => [ 'url' => $background_image_url ],
					'view_link'             => $item['view_link'] ?? [ 'url' => $item['view_model_url'] ?? '' ],
					'compare_link'          => $item['compare_link'] ?? [ 'url' => $item['compare_url'] ?? '' ],
					'title_link'            => $item['title_link'] ?? [ 'url' => $item['model_title_url'] ?? '' ],
					'reviews_link'          => $item['reviews_link'] ?? [ 'url' => $item['reviews_url'] ?? '' ],
					'price_note_link'       => $item['price_note_link'] ?? [ 'url' => $item['price_note_url'] ?? '' ],
					'price_note_link_2'     => $item['price_note_link_2'] ?? [ 'url' => $item['price_note_url_2'] ?? '' ],
					'price_note_popup_content'   => $item['price_note_popup_content'] ?? $this->get_default_price_note_popup_content( '1' ),
					'price_note_popup_content_2' => $item['price_note_popup_content_2'] ?? $this->get_default_price_note_popup_content( '2' ),
				];
			}
		}

		if ( empty( $products ) ) {
			$products = [
				[
					'brand'                => 'Cantabria®',
					'series'               => 'UTOPIA® SERIES',
					'rating'               => 4.5,
					'reviews'              => '197 Reviews',
					'msrp'                 => '$29,499¹',
					'secondary_price'      => '$471/mo for 75 mos²',
					'price_note_popup_content'   => $this->get_default_price_note_popup_content( '1' ),
					'price_note_popup_content_2' => $this->get_default_price_note_popup_content( '2' ),
					'seating'              => '8 Adults',
					'seating_group'        => '6-8',
					'seating_filter_value' => '6-8',
					'dimensions'           => '9\' x 7\'7" x 38"',
					'jets'                 => '74',
					'water_care'           => 'FreshWater® IQ Ready Salt + Smart Monitoring Included | Dosing Optional',
					'price_group'          => 'tier-4',
					'price_filter_value'   => 'tier-4',
					'product_image'        => [ 'url' => phtf_get_fallback_image_url( 'product' ) ],
					'background_image'     => [ 'url' => phtf_get_fallback_image_url( 'lifestyle' ) ],
					'view_link'            => [ 'url' => '' ],
					'compare_link'         => [ 'url' => '' ],
					'title_link'           => [ 'url' => '' ],
					'reviews_link'         => [ 'url' => '' ],
					'price_note_link'      => [ 'url' => '' ],
					'price_note_link_2'    => [ 'url' => '' ],
				],
			];
		}

		$uid = 'phtf-' . $this->get_id();
		$header = [
			'show_header'          => $settings['show_header'] ?? 'yes',
			'show_breadcrumb'      => $settings['show_breadcrumb'] ?? 'no',
			'breadcrumbs'          => $this->get_breadcrumb_items( $settings ),
			'breadcrumb_separator' => ! empty( $settings['breadcrumb_separator'] ) ? $settings['breadcrumb_separator'] : '>',
			'title'                => ! empty( $settings['header_title'] ) ? $settings['header_title'] : ( ! empty( $settings['title'] ) ? $settings['title'] : esc_html__( 'Find Your Perfect Hot Tub.', 'perfect-hot-tub-finder' ) ),
			'subtitle'             => ! empty( $settings['header_subtitle'] ) ? $settings['header_subtitle'] : ( ! empty( $settings['subtitle'] ) ? $settings['subtitle'] : esc_html__( 'Step into relaxation, blending comfort, design, and performance.', 'perfect-hot-tub-finder' ) ),
		];

		$default_seat_filters = [
			[ 'value' => '2-3', 'label' => esc_html__( '2-3 Seats', 'perfect-hot-tub-finder' ) ],
			[ 'value' => '4-5', 'label' => esc_html__( '4-5 Seats', 'perfect-hot-tub-finder' ) ],
			[ 'value' => '6-8', 'label' => esc_html__( '6-8 Seats', 'perfect-hot-tub-finder' ) ],
		];
		$seat_filters = $this->get_filter_options( $settings['seat_filters'] ?? [], $default_seat_filters );

		$default_price_filters = [
			[ 'value' => 'tier-1', 'label' => '$' ],
			[ 'value' => 'tier-2', 'label' => '$$' ],
			[ 'value' => 'tier-3', 'label' => '$$$' ],
			[ 'value' => 'tier-4', 'label' => '$$$$' ],
		];
		$price_filters = $this->get_filter_options( $settings['price_filters'] ?? [], $default_price_filters );

		$show_filters          = 'yes' === ( $settings['show_filters'] ?? 'yes' );
		$show_seating_filter   = $show_filters && 'yes' === ( $settings['show_seating_filter'] ?? 'yes' ) && ! empty( $seat_filters );
		$show_price_filter     = $show_filters && 'yes' === ( $settings['show_price_filter'] ?? 'yes' ) && ! empty( $price_filters );
		$show_product_image    = 'yes' === ( $settings['show_product_image'] ?? 'yes' );
		$show_background_image = 'yes' === ( $settings['show_background_image'] ?? 'yes' );
		$show_explore_models   = false; // Explore Our Models now renders in its own separate widget.
		$show_explore_tabs     = $show_explore_models && 'yes' === ( $settings['show_explore_tabs'] ?? 'yes' );

		$explore_tabs = [];
		if ( ! empty( $settings['explore_tabs'] ) && is_array( $settings['explore_tabs'] ) ) {
			foreach ( $settings['explore_tabs'] as $explore_tab ) {
				$tab_label = isset( $explore_tab['label'] ) ? trim( (string) $explore_tab['label'] ) : '';
				$tab_value = isset( $explore_tab['value'] ) ? trim( (string) $explore_tab['value'] ) : '';
				if ( '' !== $tab_label && '' !== $tab_value ) {
					$explore_tabs[] = [
						'label' => $tab_label,
						'value' => $tab_value,
					];
				}
			}
		}
		if ( empty( $explore_tabs ) ) {
			$explore_tabs = [
				[ 'label' => esc_html__( 'All Models', 'perfect-hot-tub-finder' ), 'value' => 'all' ],
				[ 'label' => esc_html__( '2-3 Seats', 'perfect-hot-tub-finder' ), 'value' => '2-3' ],
				[ 'label' => esc_html__( '4-5 Seats', 'perfect-hot-tub-finder' ), 'value' => '4-5' ],
				[ 'label' => esc_html__( '6-8 Seats', 'perfect-hot-tub-finder' ), 'value' => '6-8' ],
				[ 'label' => esc_html__( 'Lounge', 'perfect-hot-tub-finder' ), 'value' => 'lounge' ],
				[ 'label' => esc_html__( 'Salt Water System', 'perfect-hot-tub-finder' ), 'value' => 'salt-water' ],
				[ 'label' => esc_html__( 'Cold Plunge', 'perfect-hot-tub-finder' ), 'value' => 'cold-plunge' ],
			];
		}

		$product_source_key = sanitize_key( $settings['product_source_id'] ?? 'main' );
		if ( '' === $product_source_key ) {
			$product_source_key = 'main';
		}

		$product_source_data = [];
		foreach ( $products as $source_product ) {
			$product_image = phtf_image_url_or_fallback( ! empty( $source_product['product_image']['url'] ) ? $source_product['product_image']['url'] : '', 'product' );
			$seat_data     = ! empty( $source_product['seating_filter_value'] ) ? $source_product['seating_filter_value'] : ( $source_product['seating_group'] ?? '' );
			$price_data    = ! empty( $source_product['price_filter_value'] ) ? $source_product['price_filter_value'] : ( $source_product['price_group'] ?? '' );

			$product_source_data[] = [
				'brand'                => $source_product['brand'] ?? '',
				'series'               => $source_product['series'] ?? '',
				'rating'               => $source_product['rating'] ?? 0,
				'reviews'              => $source_product['reviews'] ?? '',
				'msrp'                 => $source_product['msrp'] ?? '',
				'seating'              => $source_product['seating'] ?? '',
				'seat'                 => $seat_data,
				'price'                => $price_data,
				'explore_series_label' => $source_product['explore_series_label'] ?? '',
				'explore_categories'   => $source_product['explore_categories'] ?? '',
				'product_image'        => esc_url_raw( $product_image ),
			];
		}
		?>
		<section id="<?php echo esc_attr( $uid ); ?>" class="phtf-widget phtf-widget--classic" data-phtf-layout="classic" data-phtf-widget data-phtf-product-source="<?php echo esc_attr( $product_source_key ); ?>">
			<script type="application/json" class="phtf-product-source-json" data-phtf-product-source="<?php echo esc_attr( $product_source_key ); ?>"><?php echo wp_json_encode( $product_source_data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></script>
			<div class="phtf-stage">
				<div class="phtf-left-panel">
					<?php if ( 'yes' === $header['show_header'] ) : ?>
						<div class="phtf-header">
							<?php if ( 'yes' === $header['show_breadcrumb'] && ! empty( $header['breadcrumbs'] ) ) : ?>
								<nav class="phtf-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'perfect-hot-tub-finder' ); ?>">
									<?php foreach ( $header['breadcrumbs'] as $breadcrumb_index => $crumb ) : ?>
										<?php if ( $breadcrumb_index > 0 ) : ?>
											<span class="phtf-breadcrumb-separator" aria-hidden="true"><?php echo esc_html( $header['breadcrumb_separator'] ); ?></span>
										<?php endif; ?>
										<?php
										$is_active = 'yes' === ( $crumb['active'] ?? '' );
										$item_classes = [ 'phtf-breadcrumb-item' ];
										if ( 0 === $breadcrumb_index ) {
											$item_classes[] = 'is-home';
										}
										if ( $is_active ) {
											$item_classes[] = 'is-active';
										}
										$class_attr = implode( ' ', $item_classes );
										?>
										<?php if ( ! $is_active && ! empty( $crumb['link']['url'] ) ) : ?>
											<a class="<?php echo esc_attr( $class_attr ); ?>" <?php echo $this->render_link_attrs( $crumb['link'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $crumb['label'] ); ?></a>
										<?php else : ?>
											<span class="<?php echo esc_attr( $class_attr ); ?>"<?php echo $is_active ? ' aria-current="page"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $crumb['label'] ); ?></span>
										<?php endif; ?>
									<?php endforeach; ?>
								</nav>
							<?php endif; ?>

							<?php if ( ! empty( $header['title'] ) ) : ?>
								<h2 class="phtf-title"><?php echo esc_html( $header['title'] ); ?></h2>
							<?php endif; ?>

							<?php if ( ! empty( $header['subtitle'] ) ) : ?>
								<p class="phtf-subtitle"><?php echo esc_html( $header['subtitle'] ); ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<div class="phtf-content-grid">
						<?php if ( $show_seating_filter || $show_price_filter ) : ?>
							<div class="phtf-filter-overlay" data-phtf-filter-overlay hidden></div>
							<aside id="<?php echo esc_attr( $uid ); ?>-filters" class="phtf-filters" aria-label="<?php esc_attr_e( 'Hot tub filters', 'perfect-hot-tub-finder' ); ?>">
								<div class="phtf-filters-mobile-header">
									<button type="button" class="phtf-filters-back" data-phtf-filter-close>‹ <?php esc_html_e( 'Back', 'perfect-hot-tub-finder' ); ?></button>
								</div>
								<?php if ( $show_seating_filter ) : ?>
									<div class="phtf-filter-group phtf-filter-group--seating" data-phtf-filter-group>
										<div class="phtf-filter-group-toggle phtf-filter-group-plain-heading">
											<span class="phtf-filter-group-title"><?php echo esc_html( $settings['seating_title'] ?? esc_html__( 'Seating', 'perfect-hot-tub-finder' ) ); ?></span>
										</div>
										<div class="phtf-filter-group-body" data-phtf-filter-group-body>
										<?php foreach ( $seat_filters as $filter_index => $filter ) :
											$input_id = $uid . '-seat-' . $filter_index . '-' . sanitize_html_class( $filter['value'] );
											?>
											<label class="phtf-checkbox" for="<?php echo esc_attr( $input_id ); ?>">
												<input id="<?php echo esc_attr( $input_id ); ?>" type="checkbox" data-phtf-filter="seat" value="<?php echo esc_attr( $filter['value'] ); ?>">
												<span class="phtf-box" aria-hidden="true"></span>
												<span><?php echo esc_html( $filter['label'] ); ?></span>
											</label>
										<?php endforeach; ?>
										</div>
									</div>
								<?php endif; ?>

								<?php if ( $show_price_filter ) : ?>
									<div class="phtf-filter-group phtf-filter-group--price" data-phtf-filter-group>
										<div class="phtf-filter-group-head">
											<div class="phtf-filter-group-toggle phtf-filter-group-plain-heading">
												<span class="phtf-filter-group-title-wrap">
													<span class="phtf-filter-group-title"><?php echo esc_html( $settings['price_title'] ?? esc_html__( 'Price', 'perfect-hot-tub-finder' ) ); ?></span>
												</span>
											</div>
											<?php if ( 'yes' === ( $settings['price_info_icon'] ?? 'yes' ) ) : ?>
												<span class="phtf-filter-heading-info">
													<?php echo $this->render_price_info_icon_popup( $settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
												</span>
											<?php endif; ?>
										</div>
										<div class="phtf-filter-group-body" data-phtf-filter-group-body>
										<?php foreach ( $price_filters as $filter_index => $filter ) :
											$input_id = $uid . '-price-' . $filter_index . '-' . sanitize_html_class( $filter['value'] );
											?>
											<label class="phtf-checkbox" for="<?php echo esc_attr( $input_id ); ?>">
												<input id="<?php echo esc_attr( $input_id ); ?>" type="checkbox" data-phtf-filter="price" value="<?php echo esc_attr( $filter['value'] ); ?>">
												<span class="phtf-box" aria-hidden="true"></span>
												<span><?php echo esc_html( $filter['label'] ); ?></span>
											</label>
										<?php endforeach; ?>
											<?php if ( ! empty( $settings['price_info_popup_content'] ) ) : ?>
												<div class="phtf-price-info-inline" data-phtf-price-info-inline>
													<?php echo wp_kses_post( $settings['price_info_popup_content'] ); ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>
								<div class="phtf-filters-mobile-actions" data-phtf-filter-mobile-actions>
									<button type="button" class="phtf-mobile-filter-action phtf-mobile-filter-action--show" data-phtf-filter-show-results><?php esc_html_e( 'Show Results', 'perfect-hot-tub-finder' ); ?></button>
									<button type="button" class="phtf-mobile-filter-action phtf-mobile-filter-action--reset" data-phtf-filter-reset><?php esc_html_e( 'Reset Filters', 'perfect-hot-tub-finder' ); ?></button>
								</div>
							</aside>
						<?php endif; ?>

						<div class="phtf-results-panel">
							<div class="phtf-results-nav">
								<div class="phtf-results-nav-main">
									<button type="button" class="phtf-arrow phtf-arrow--prev" data-phtf-prev aria-label="<?php esc_attr_e( 'Previous result', 'perfect-hot-tub-finder' ); ?>">‹</button>
									<span class="phtf-results-count" data-phtf-count data-label="<?php echo esc_attr( $settings['results_label'] ); ?>"><?php echo esc_html( $settings['results_label'] ); ?> (1 <?php esc_html_e( 'of', 'perfect-hot-tub-finder' ); ?> <?php echo esc_html( count( $products ) ); ?>)</span>
									<button type="button" class="phtf-arrow phtf-arrow--next" data-phtf-next aria-label="<?php esc_attr_e( 'Next result', 'perfect-hot-tub-finder' ); ?>">›</button>
								</div>
								<?php if ( $show_seating_filter || $show_price_filter ) : ?>
									<div class="phtf-filter-toggle-row">
										<button type="button" class="phtf-filter-toggle" data-phtf-filter-open aria-expanded="false" aria-controls="<?php echo esc_attr( $uid ); ?>-filters">
											<span class="phtf-filter-toggle-label"><?php esc_html_e( 'Filter', 'perfect-hot-tub-finder' ); ?></span>
											<span class="phtf-filter-toggle-arrow" aria-hidden="true">›</span>
										</button>
									</div>
								<?php endif; ?>
							</div>

							<div class="phtf-empty" data-phtf-empty hidden><?php echo esc_html( $settings['empty_message'] ); ?></div>

							<div class="phtf-products" data-phtf-products>
								<?php foreach ( $products as $index => $product ) :
									$product_image = phtf_image_url_or_fallback( ! empty( $product['product_image']['url'] ) ? $product['product_image']['url'] : '', 'product' );
									$bg_image      = phtf_image_url_or_fallback( ! empty( $product['background_image']['url'] ) ? $product['background_image']['url'] : '', 'lifestyle' );
									$is_active     = 0 === $index ? ' is-active' : '';
									$seat_data     = ! empty( $product['seating_filter_value'] ) ? $product['seating_filter_value'] : ( $product['seating_group'] ?? '' );
									$price_data    = ! empty( $product['price_filter_value'] ) ? $product['price_filter_value'] : ( $product['price_group'] ?? '' );
									?>
									<article class="phtf-product<?php echo esc_attr( $is_active ); ?>" data-phtf-item data-seat="<?php echo esc_attr( $seat_data ); ?>" data-price="<?php echo esc_attr( $price_data ); ?>">
	<div class="phtf-product-visual">
		<?php if ( $show_background_image ) : ?>
			<div class="phtf-hero-bg" style="background-image:url('<?php echo esc_url( $bg_image ); ?>');"></div>
		<?php endif; ?>
		<?php if ( $show_product_image ) : ?>
			<img class="phtf-product-image" src="<?php echo esc_url( $product_image ); ?>" alt="<?php echo esc_attr( $product['brand'] ); ?>">
		<?php endif; ?>
	</div>
	<div class="phtf-product-copy">
											<h3 class="phtf-product-title">
												<?php if ( ! empty( $product['title_link']['url'] ) ) : ?>
													<a class="phtf-product-title-link" <?php echo $this->render_link_attrs( $product['title_link'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $product['brand'] ); ?></a>
												<?php else : ?>
													<?php echo esc_html( $product['brand'] ); ?>
												<?php endif; ?>
											</h3>
											<?php if ( ! empty( $product['series'] ) ) : ?>
												<div class="phtf-series"><?php echo esc_html( $product['series'] ); ?></div>
											<?php endif; ?>
											<div class="phtf-rating-row">
												<span class="phtf-stars"><?php echo $this->render_rating( $product['rating'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
												<span class="phtf-review-count">
									<?php if ( ! empty( $product['reviews_link']['url'] ) ) : ?>
										<a class="phtf-review-link" <?php echo $this->render_link_attrs( $product['reviews_link'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $product['reviews'] ); ?></a>
									<?php else : ?>
										<?php echo esc_html( $product['reviews'] ); ?>
									<?php endif; ?>
								</span>
											</div>
											<?php
											$show_secondary_price = 'yes' === ( $settings['show_secondary_price'] ?? '' );
											?>
											<?php if ( ! empty( $product['msrp'] ) || ( $show_secondary_price && ! empty( $product['secondary_price'] ) ) ) : ?>
												<div class="phtf-msrp">
													<div class="phtf-msrp-line">
														<?php if ( ! empty( $product['msrp'] ) ) : ?>
															<span><?php esc_html_e( 'MSRP:', 'perfect-hot-tub-finder' ); ?></span> <strong class="phtf-msrp-price"><?php echo $this->render_msrp_value( $product['msrp'], $settings, $product['price_note_link'] ?? [], $product['price_note_link_2'] ?? [], $product['price_note_popup_content'] ?? '', $product['price_note_popup_content_2'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
														<?php endif; ?>
														<?php if ( $show_secondary_price && ! empty( $product['secondary_price'] ) ) : ?>
															<?php if ( ! empty( $product['msrp'] ) ) : ?>
																<span class="phtf-msrp-separator"><?php esc_html_e( 'or', 'perfect-hot-tub-finder' ); ?></span>
															<?php endif; ?>
															<strong class="phtf-msrp-price phtf-msrp-price--secondary"><?php echo $this->render_msrp_value( $product['secondary_price'], $settings, $product['price_note_link'] ?? [], $product['price_note_link_2'] ?? [], $product['price_note_popup_content'] ?? '', $product['price_note_popup_content_2'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
														<?php endif; ?>
													</div>
												</div>
											<?php endif; ?>

											<div class="phtf-product-specs" aria-label="<?php esc_attr_e( 'Product specifications', 'perfect-hot-tub-finder' ); ?>">
												<div><span><?php esc_html_e( 'Seating', 'perfect-hot-tub-finder' ); ?></span><strong><?php echo esc_html( $product['seating'] ); ?></strong></div>
												<div><span><?php esc_html_e( 'Dimensions', 'perfect-hot-tub-finder' ); ?></span><strong><?php echo esc_html( $product['dimensions'] ); ?></strong></div>
												<div><span><?php esc_html_e( 'Jets', 'perfect-hot-tub-finder' ); ?></span><strong><?php echo esc_html( $product['jets'] ); ?></strong></div>
											</div>

											<?php if ( ! empty( $product['water_care'] ) ) : ?>
												<div class="phtf-water-care"><span><?php esc_html_e( 'Water Care', 'perfect-hot-tub-finder' ); ?></span><p><?php echo esc_html( $product['water_care'] ); ?></p></div>
											<?php endif; ?>

											<div class="phtf-actions">
												<a class="phtf-button phtf-button--primary" <?php echo $this->render_link_attrs( $product['view_link'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['view_button_text'] ); ?></a>
												<a class="phtf-button phtf-button--secondary" <?php echo $this->render_link_attrs( $product['compare_link'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['compare_button_text'] ); ?></a>
											</div>
										</div>


									</article>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php if ( $show_explore_models ) : ?>
				<div class="phtf-explore" data-phtf-explore>
					<?php if ( ! empty( $settings['explore_title'] ) ) : ?>
						<h2 class="phtf-explore-title"><?php echo esc_html( $settings['explore_title'] ); ?></h2>
					<?php endif; ?>

					<?php if ( $show_explore_tabs && ! empty( $explore_tabs ) ) : ?>
						<div class="phtf-explore-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Model categories', 'perfect-hot-tub-finder' ); ?>">
							<?php foreach ( $explore_tabs as $tab_index => $tab ) : ?>
								<button type="button" class="phtf-explore-tab<?php echo 0 === $tab_index ? ' is-active' : ''; ?>" data-phtf-explore-tab="<?php echo esc_attr( $tab['value'] ); ?>">
									<?php echo esc_html( $tab['label'] ); ?>
								</button>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<div class="phtf-explore-carousel">
						<button type="button" class="phtf-explore-arrow phtf-explore-arrow--prev" data-phtf-explore-prev aria-label="<?php esc_attr_e( 'Previous models', 'perfect-hot-tub-finder' ); ?>">‹</button>

						<div class="phtf-explore-viewport">
							<div class="phtf-explore-track">
								<?php foreach ( $products as $product ) :
									$product_image  = phtf_image_url_or_fallback( ! empty( $product['product_image']['url'] ) ? $product['product_image']['url'] : '', 'product' );
									$seat_data      = ! empty( $product['seating_filter_value'] ) ? $product['seating_filter_value'] : ( $product['seating_group'] ?? '' );
									$category_list  = [];
									if ( '' !== trim( (string) $seat_data ) ) {
										$category_list[] = trim( (string) $seat_data );
									}
									if ( ! empty( $product['explore_categories'] ) ) {
										$extra_categories = explode( ',', (string) $product['explore_categories'] );
										foreach ( $extra_categories as $extra_category ) {
											$extra_category = trim( $extra_category );
											if ( '' !== $extra_category ) {
												$category_list[] = $extra_category;
											}
										}
									}
									$category_list = array_values( array_unique( array_filter( $category_list ) ) );
									$category_attr = implode( ',', $category_list );

									$series_label = '';
									if ( ! empty( $product['explore_series_label'] ) ) {
										$series_label = $product['explore_series_label'];
									} elseif ( ! empty( $product['series'] ) ) {
										$series_label = preg_replace( '/\s*series\s*$/i', '', (string) $product['series'] );
									}

									$reviews_label = '';
									if ( ! empty( $product['reviews'] ) ) {
										if ( preg_match( '/\d+/', (string) $product['reviews'], $review_matches ) ) {
											$reviews_label = '(' . $review_matches[0] . ')';
										} else {
											$reviews_label = $product['reviews'];
										}
									}

									$seats_label = '';
									if ( ! empty( $product['seating'] ) ) {
										if ( preg_match( '/\d+(?:\s*-\s*\d+)?/', (string) $product['seating'], $seat_matches ) ) {
											$seats_label = sprintf( esc_html__( 'Seats %s', 'perfect-hot-tub-finder' ), str_replace( ' ', '', $seat_matches[0] ) );
										} else {
											$seats_label = $product['seating'];
										}
									}
									?>
									<article class="phtf-explore-card" data-phtf-explore-item data-phtf-explore-cats="<?php echo esc_attr( $category_attr ); ?>">
										<div class="phtf-explore-image-wrap">
											<img class="phtf-explore-image" src="<?php echo esc_url( $product_image ); ?>" alt="<?php echo esc_attr( $product['brand'] ?? '' ); ?>">
										</div>

										<?php if ( ! empty( $series_label ) ) : ?>
											<div class="phtf-explore-card-series"><?php echo esc_html( $series_label ); ?></div>
										<?php endif; ?>

										<h3 class="phtf-explore-card-title"><?php echo esc_html( $product['brand'] ?? '' ); ?></h3>

										<div class="phtf-explore-rating">
											<span class="phtf-stars"><?php echo $this->render_rating( $product['rating'] ?? 0 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
											<?php if ( ! empty( $reviews_label ) ) : ?>
												<span class="phtf-explore-reviews"><?php echo esc_html( $reviews_label ); ?></span>
											<?php endif; ?>
										</div>

										<div class="phtf-explore-meta">
											<?php if ( ! empty( $seats_label ) ) : ?>
												<span><?php echo esc_html( $seats_label ); ?></span>
											<?php endif; ?>
											<?php if ( ! empty( $product['msrp'] ) ) : ?>
												<span><?php esc_html_e( 'MSRP:', 'perfect-hot-tub-finder' ); ?> <strong><?php echo esc_html( $product['msrp'] ); ?></strong></span>
											<?php endif; ?>
										</div>
									</article>
								<?php endforeach; ?>
							</div>
						</div>

						<button type="button" class="phtf-explore-arrow phtf-explore-arrow--next" data-phtf-explore-next aria-label="<?php esc_attr_e( 'Next models', 'perfect-hot-tub-finder' ); ?>">›</button>
					</div>

					<?php if ( ! empty( $settings['explore_button_text'] ) ) : ?>
						<div class="phtf-explore-actions">
							<a class="phtf-explore-button" <?php echo $this->render_link_attrs( $settings['explore_button_link'] ?? [] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['explore_button_text'] ); ?></a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</section>
		<?php
	}
}
