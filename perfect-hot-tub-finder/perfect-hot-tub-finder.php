<?php
/**
 * Plugin Name: Perfect Hot Tub Finder
 * Description: Adds a customizable Elementor widget for a hot tub finder/shop layout.
 * Version: 1.0.229
 * Author: Attractional Marketing
 * Text Domain: perfect-hot-tub-finder
 * Update URI: https://github.com/wpsoheltanvir/Hollywood-Plugin
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'phtf_get_fallback_image_url' ) ) {
	/**
	 * Return the default Elementor/WordPress image placeholder.
	 *
	 * No custom fallback images are bundled or uploaded with the plugin.
	 *
	 * @param string $type product|lifestyle|background|widget. Kept for backward compatibility.
	 * @return string
	 */
	function phtf_get_fallback_image_url( $type = 'widget' ) {
		if ( defined( 'ELEMENTOR_ASSETS_URL' ) ) {
			return trailingslashit( ELEMENTOR_ASSETS_URL ) . 'images/placeholder.png';
		}

		return includes_url( 'images/media/default.png' );
	}
}

if ( ! function_exists( 'phtf_image_url_or_fallback' ) ) {
	/**
	 * Normalize empty image URLs to the default Elementor/WordPress placeholder.
	 *
	 * @param string $url  Existing URL.
	 * @param string $type Placeholder type. Kept for backward compatibility.
	 * @return string
	 */
	function phtf_image_url_or_fallback( $url = '', $type = 'widget' ) {
		$url = trim( (string) $url );
		if ( '' === $url ) {
			return phtf_get_fallback_image_url( $type );
		}
		return $url;
	}
}

if ( ! function_exists( 'phtf_apply_elementor_global_colors' ) ) {
	/**
	 * Add/update the plugin brand colors in Elementor's active Site Settings kit.
	 *
	 * @return bool
	 */
	function phtf_apply_elementor_global_colors() {
		$kit_id = absint( get_option( 'elementor_active_kit' ) );

		if ( ! $kit_id ) {
			$kits = get_posts(
				[
					'post_type'      => 'elementor_library',
					'post_status'    => 'publish',
					'posts_per_page' => 1,
					'fields'         => 'ids',
					'orderby'        => 'ID',
					'order'          => 'ASC',
					'meta_query'     => [
						[
							'key'   => '_elementor_template_type',
							'value' => 'kit',
						],
					],
				]
			);

			if ( ! empty( $kits[0] ) ) {
				$kit_id = absint( $kits[0] );
			}
		}

		if ( ! $kit_id ) {
			return false;
		}

		$page_settings = get_post_meta( $kit_id, '_elementor_page_settings', true );
		if ( ! is_array( $page_settings ) ) {
			$page_settings = [];
		}

		$page_settings['system_colors'] = [
			[
				'_id'   => 'primary',
				'title' => 'Primary',
				'color' => '#00263D',
			],
			[
				'_id'   => 'secondary',
				'title' => 'Secondary',
				'color' => '#85D9DE',
			],
			[
				'_id'   => 'text',
				'title' => 'Text',
				'color' => '#7A7A7A',
			],
			[
				'_id'   => 'accent',
				'title' => 'Accent',
				'color' => '#00263D',
			],
		];

		$required_custom_colors = [
			'White'      => '#FFFFFF',
			'Text Color' => '#1C1D1B',
			'Border'     => '#E4E4E4',
		];

		$custom_colors = isset( $page_settings['custom_colors'] ) && is_array( $page_settings['custom_colors'] ) ? $page_settings['custom_colors'] : [];

		foreach ( $required_custom_colors as $title => $color ) {
			$found = false;

			foreach ( $custom_colors as $index => $existing_color ) {
				if ( isset( $existing_color['title'] ) && $existing_color['title'] === $title ) {
					$custom_colors[ $index ]['color'] = $color;
					$found = true;
					break;
				}
			}

			if ( ! $found ) {
				$custom_colors[] = [
					'_id'   => 'hol_' . sanitize_title( $title ),
					'title' => $title,
					'color' => $color,
				];
			}
		}

		$page_settings['custom_colors'] = $custom_colors;

		update_post_meta( $kit_id, '_elementor_page_settings', $page_settings );
		update_option( 'phtf_elementor_global_colors_version', PHTF_Perfect_Hot_Tub_Finder::VERSION, false );

		return true;
	}
}

final class PHTF_Perfect_Hot_Tub_Finder {
	const VERSION = '1.0.229';
	const MINIMUM_ELEMENTOR_VERSION = '3.5.0';
	const MINIMUM_PHP_VERSION = '7.4';

	private static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {
		require_once __DIR__ . '/includes/class-phtf-spa-models-cpt.php';
		require_once __DIR__ . '/includes/class-phtf-github-updater.php';
		new PHTF_Spa_Models_CPT();
		if ( is_admin() ) {
			new PHTF_GitHub_Updater( __FILE__, self::VERSION, 'wpsoheltanvir', 'Hollywood-Plugin' );
		}
		add_action( 'init', [ $this, 'maybe_flush_rewrite_rules' ], 99 );

		add_action( 'admin_init', [ $this, 'maybe_apply_elementor_global_colors' ] );

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
			return;
		}

		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		add_action( 'elementor/elements/categories_registered', [ $this, 'register_widget_category' ] );
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
	}

	public function maybe_apply_elementor_global_colors() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( get_option( 'phtf_elementor_global_colors_version' ) === self::VERSION ) {
			return;
		}

		phtf_apply_elementor_global_colors();
	}

	public function maybe_flush_rewrite_rules() {
		if ( ! get_option( 'phtf_flush_rewrite_rules' ) ) {
			return;
		}

		flush_rewrite_rules( false );
		delete_option( 'phtf_flush_rewrite_rules' );
	}

	public function admin_notice_missing_elementor() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'perfect-hot-tub-finder' ),
			'<strong>' . esc_html__( 'Perfect Hot Tub Finder', 'perfect-hot-tub-finder' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'perfect-hot-tub-finder' ) . '</strong>'
		);

		echo '<div class="notice notice-warning is-dismissible"><p>' . wp_kses_post( $message ) . '</p></div>';
	}

	public function admin_notice_minimum_php_version() {
		$message = sprintf(
			/* translators: 1: Plugin name 2: Required PHP version 3: Current PHP version */
			esc_html__( '"%1$s" requires PHP %2$s or higher. Your site is running PHP %3$s.', 'perfect-hot-tub-finder' ),
			'<strong>' . esc_html__( 'Perfect Hot Tub Finder', 'perfect-hot-tub-finder' ) . '</strong>',
			esc_html( self::MINIMUM_PHP_VERSION ),
			esc_html( PHP_VERSION )
		);

		echo '<div class="notice notice-warning is-dismissible"><p>' . wp_kses_post( $message ) . '</p></div>';
	}

	public function register_widget_category( $elements_manager ) {
		$elements_manager->add_category(
			'phtf-widgets',
			[
				'title' => esc_html__( 'Hot Tub Finder', 'perfect-hot-tub-finder' ),
				'icon'  => 'fa fa-plug',
			]
		);
	}

	public function register_assets() {
		wp_register_style(
			'phtf-questrial-font',
			'https://fonts.googleapis.com/css2?family=Questrial&display=swap',
			[],
			null
		);

		wp_register_style(
			'phtf-hot-tub-finder',
			plugins_url( 'assets/css/hot-tub-finder.css', __FILE__ ),
			[ 'phtf-questrial-font' ],
			self::VERSION
		);

		wp_register_script(
			'phtf-hot-tub-finder',
			plugins_url( 'assets/js/hot-tub-finder.js', __FILE__ ),
			[],
			self::VERSION,
			true
		);
	}

	public function register_widgets( $widgets_manager ) {
		$widgets = [
			[ 'widgets/class-phtf-hot-tub-finder-widget.php', '\PHTF_Hot_Tub_Finder_Widget' ],
			[ 'widgets/class-phtf-series-comparison-widget.php', '\PHTF_Series_Comparison_Widget' ],
			[ 'widgets/class-phtf-explore-models-widget.php', '\PHTF_Explore_Models_Widget' ],
			[ 'widgets/class-phtf-spa-colors-widget.php', '\PHTF_Spa_Colors_Widget' ],
			[ 'widgets/class-phtf-spa-series-models-widget.php', '\PHTF_Spa_Series_Models_Widget' ],
			[ 'widgets/class-phtf-spa-series-delight-widget.php', '\PHTF_Spa_Series_Delight_Widget' ],
			[ 'widgets/class-phtf-spa-series-slider-widget.php', '\PHTF_Spa_Series_Slider_Widget' ],
			[ 'widgets/class-phtf-spa-model-slider-widget.php', '\PHTF_Spa_Model_Slider_Widget' ],
			[ 'widgets/class-phtf-reviews-widget.php', '\PHTF_Reviews_Widget' ],
			[ 'widgets/class-phtf-spa-model-specifications-widget.php', '\PHTF_Spa_Model_Specifications_Widget' ],
			[ 'widgets/class-phtf-compare-spa-models-widget.php', '\PHTF_Compare_Spa_Models_Widget' ],
		];

		foreach ( $widgets as $widget ) {
			$file  = __DIR__ . '/' . $widget[0];
			$class = $widget[1];

			if ( ! file_exists( $file ) ) {
				error_log( sprintf( 'Perfect Hot Tub Finder: missing widget file %s', $file ) );
				continue;
			}

			require_once $file;

			if ( class_exists( $class ) ) {
				$widgets_manager->register( new $class() );
			}
		}
	}
}


register_activation_hook( __FILE__, function() {
	delete_option( 'phtf_elementor_global_colors_version' );
	update_option( 'phtf_flush_rewrite_rules', 1, false );
} );

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

PHTF_Perfect_Hot_Tub_Finder::instance();
