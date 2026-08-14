<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'PHTF_SPA_CATEGORY_TAXONOMY' ) ) {
	define( 'PHTF_SPA_CATEGORY_TAXONOMY', 'phtf_spa_category' );
}

if ( ! function_exists( 'phtf_compare_spa_category_default_options' ) ) {
	function phtf_compare_spa_category_default_options() {
		return [
			'utopia'   => __( 'Utopia® Series', 'perfect-hot-tub-finder' ),
			'paradise' => __( 'Paradise® Series', 'perfect-hot-tub-finder' ),
			'vacanza'  => __( 'Vacanza® Series', 'perfect-hot-tub-finder' ),
			'fantasy'  => __( 'Fantasy™ Series', 'perfect-hot-tub-finder' ),
		];
	}
}

if ( ! function_exists( 'phtf_compare_spa_category_options' ) ) {
	function phtf_compare_spa_category_options() {
		$defaults = phtf_compare_spa_category_default_options();
		$options  = [];

		if ( function_exists( 'taxonomy_exists' ) && taxonomy_exists( PHTF_SPA_CATEGORY_TAXONOMY ) ) {
			$terms = get_terms(
				[
					'taxonomy'   => PHTF_SPA_CATEGORY_TAXONOMY,
					'hide_empty' => false,
					'orderby'    => 'name',
				]
			);

			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				$terms_by_slug = [];
				foreach ( $terms as $term ) {
					$terms_by_slug[ $term->slug ] = $term->name;
				}

				foreach ( $defaults as $slug => $label ) {
					$options[ $slug ] = isset( $terms_by_slug[ $slug ] ) ? $terms_by_slug[ $slug ] : $label;
				}

				foreach ( $terms_by_slug as $slug => $name ) {
					if ( ! isset( $options[ $slug ] ) ) {
						$options[ $slug ] = $name;
					}
				}
			}
		}

		return ! empty( $options ) ? $options : $defaults;
	}
}

if ( ! function_exists( 'phtf_compare_spa_category_label' ) ) {
	function phtf_compare_spa_category_label( $category, $series = '', $series_display = '' ) {
		$options  = phtf_compare_spa_category_options();
		$defaults = phtf_compare_spa_category_default_options();
		$category = trim( (string) $category );

		if ( isset( $options[ $category ] ) ) {
			return $options[ $category ];
		}

		foreach ( $options as $option_label ) {
			if ( strtolower( trim( wp_strip_all_tags( (string) $option_label ) ) ) === strtolower( trim( wp_strip_all_tags( $category ) ) ) ) {
				return $option_label;
			}
		}

		$lookup = strtolower( wp_strip_all_tags( $category . ' ' . $series . ' ' . $series_display ) );
		foreach ( $defaults as $key => $default_label ) {
			$needle = str_replace( [ '®', '™', ' series' ], '', strtolower( wp_strip_all_tags( $default_label ) ) );
			if ( false !== strpos( $lookup, $key ) || ( $needle && false !== strpos( $lookup, trim( $needle ) ) ) ) {
				return isset( $options[ $key ] ) ? $options[ $key ] : $default_label;
			}
		}

		$first = reset( $options );
		return $first ? $first : $defaults['utopia'];
	}
}

if ( ! function_exists( 'phtf_compare_spa_category_key' ) ) {
	function phtf_compare_spa_category_key( $category, $series = '', $series_display = '' ) {
		$options  = phtf_compare_spa_category_options();
		$category = trim( (string) $category );

		if ( isset( $options[ $category ] ) ) {
			return $category;
		}

		$label = phtf_compare_spa_category_label( $category, $series, $series_display );
		foreach ( $options as $key => $option_label ) {
			if ( strtolower( trim( wp_strip_all_tags( (string) $label ) ) ) === strtolower( trim( wp_strip_all_tags( (string) $option_label ) ) ) ) {
				return $key;
			}
		}

		$first_key = key( $options );
		return $first_key ? $first_key : 'utopia';
	}
}

if ( ! function_exists( 'phtf_get_spa_model_compare_category_data' ) ) {
	function phtf_get_spa_model_compare_category_data( $post_id ) {
		$terms = function_exists( 'get_the_terms' ) ? get_the_terms( $post_id, PHTF_SPA_CATEGORY_TAXONOMY ) : false;
		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			$term = array_shift( $terms );
			return [
				'key'   => $term->slug,
				'label' => $term->name,
			];
		}

		$meta_category = get_post_meta( $post_id, '_phtf_compare_category', true );
		if ( '' !== trim( (string) $meta_category ) ) {
			return [
				'key'   => phtf_compare_spa_category_key( $meta_category ),
				'label' => phtf_compare_spa_category_label( $meta_category ),
			];
		}

		$options = phtf_compare_spa_category_options();
		$key     = key( $options );
		return [
			'key'   => $key ? $key : 'utopia',
			'label' => $key && isset( $options[ $key ] ) ? $options[ $key ] : __( 'Utopia® Series', 'perfect-hot-tub-finder' ),
		];
	}
}

if ( ! function_exists( 'phtf_explore_model_category_options' ) ) {
	function phtf_explore_model_category_options() {
		return [
			'2-3'         => __( '2-3 Seats', 'perfect-hot-tub-finder' ),
			'4-5'         => __( '4-5 Seats', 'perfect-hot-tub-finder' ),
			'6-8'         => __( '6-8 Seats', 'perfect-hot-tub-finder' ),
			'lounge'      => __( 'Lounge', 'perfect-hot-tub-finder' ),
			'salt-water'  => __( 'Salt Water System', 'perfect-hot-tub-finder' ),
			'cold-plunge' => __( 'Cold Plunge', 'perfect-hot-tub-finder' ),
		];
	}
}


if ( ! function_exists( 'phtf_default_price_note_popup_content' ) ) {
	function phtf_default_price_note_popup_content( $note_number = '1' ) {
		if ( '2' === (string) $note_number ) {
			return __( "Pricing is for U.S. only.\n\n2. Pricing and promotional details may vary by model, configuration, options, delivery, installation, taxes, dealer charges, finance charges, and local market factors. Dealers have sole discretion to set actual prices, which will vary.", 'perfect-hot-tub-finder' );
		}

		return __( "Pricing is for U.S. only.\n\n1. Prices listed are the Manufacturer’s Suggested Retail Price (MSRP) for base models. Options such as water care, steps, cover lifters, accessories and delivery are available at an additional cost. Prices exclude tax, destination charges, installation costs, finance charges, surcharges (attributable to raw material costs in the product supply chain), additional dealer charges, if any, and other local factors. Dealers have sole discretion to set actual prices, which will vary.", 'perfect-hot-tub-finder' );
	}
}

if ( ! function_exists( 'phtf_normalize_placeholder_meta_value' ) ) {
	function phtf_normalize_placeholder_meta_value( $value, $field = [] ) {
		// Placeholders must never overwrite or hide manually saved data. Earlier
		// builds treated values matching sample placeholder text as empty; that made
		// real entries such as $29,499¹, 8 Adults, or the popup disclaimer disappear
		// after saving. Keep saved values exactly as the user entered them, and let
		// the HTML placeholder attribute show examples only when the field is empty.
		if ( is_array( $value ) ) {
			return $value;
		}

		return trim( (string) $value );
	}
}


if ( ! function_exists( 'phtf_spa_model_id_exists' ) ) {
	function phtf_spa_model_id_exists( $spa_id, $post_id = 0 ) {
		$spa_id = trim( (string) $spa_id );
		if ( '' === $spa_id ) {
			return false;
		}

		$existing = get_posts(
			[
				'post_type'      => 'phtf_spa_model',
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'post__not_in'   => $post_id ? [ absint( $post_id ) ] : [],
				'meta_query'     => [
					[
						'key'   => '_phtf_spa_id',
						'value' => $spa_id,
					],
				],
			]
		);

		return ! empty( $existing );
	}
}

if ( ! function_exists( 'phtf_generate_unique_spa_model_id' ) ) {
	function phtf_generate_unique_spa_model_id( $post_id ) {
		$post_id = absint( $post_id );
		$base    = $post_id ? $post_id : wp_rand( 1000, 9999 );
		$spa_id  = (string) $base;

		if ( ! phtf_spa_model_id_exists( $spa_id, $post_id ) ) {
			return $spa_id;
		}

		for ( $i = 1; $i <= 999; $i++ ) {
			$candidate = (string) ( $base + ( $i * 1000 ) );
			if ( ! phtf_spa_model_id_exists( $candidate, $post_id ) ) {
				return $candidate;
			}
		}

		return (string) ( $base . wp_rand( 1000, 9999 ) );
	}
}


if ( ! function_exists( 'phtf_get_compare_url_for_spa_model' ) ) {
	function phtf_get_compare_url_for_spa_model( $spa_id = '' ) {
		$spa_id = trim( (string) $spa_id );
		if ( '' === $spa_id ) {
			$spa_id = '1378';
		}

		return esc_url_raw( add_query_arg( 'spaID', rawurlencode( $spa_id ), home_url( '/compare-spa-models/' ) ) );
	}
}



if ( ! function_exists( 'phtf_spa_model_meta_fields' ) ) {
	function phtf_spa_model_meta_fields() {
		return [
			'compare_category'        => [ 'label' => __( 'Compare Category', 'perfect-hot-tub-finder' ), 'type' => 'select', 'default' => 'utopia', 'options' => function_exists( 'phtf_compare_spa_category_options' ) ? phtf_compare_spa_category_options() : [ 'utopia' => 'Utopia® Series', 'paradise' => 'Paradise® Series', 'vacanza' => 'Vacanza® Series', 'fantasy' => 'Fantasy™ Series' ], 'description' => __( 'Used only by the Compare Spa Models widget dropdown categories.', 'perfect-hot-tub-finder' ) ],
			'spa_id'                  => [ 'label' => __( 'Compare Model ID', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => __( 'Auto-generated unique ID', 'perfect-hot-tub-finder' ), 'readonly' => true, 'description' => __( 'Automatically generated unique ID used in compare page URLs, for example ?spaID=1378.', 'perfect-hot-tub-finder' ) ],
			'rating'                  => [ 'label' => __( 'Rating', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => '5', 'legacy_placeholder_value' => '5' ],
			'reviews'                 => [ 'label' => __( 'Reviews Count', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => '120', 'legacy_placeholder_value' => '120', 'legacy_placeholder_values' => [ '197', '197 Reviews' ] ],
			'price'                   => [ 'label' => __( 'Price / MSRP', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => '$29,499¹', 'legacy_placeholder_value' => '$29,499¹', 'legacy_placeholder_values' => [ '$29,499 ¹', '$29,4991', '$29,499' ], 'description' => __( 'Spa Shop Slider uses this as the first price. Add ¹ to show the first price footnote popup.', 'perfect-hot-tub-finder' ) ],
			'secondary_price'         => [ 'label' => __( 'Monthly / Second Price Text', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => '$471/mo for 75 mos²', 'legacy_placeholder_value' => '$471/mo for 75 mos²', 'description' => __( 'Optional. Displays inline after MSRP with “or”. Add ² to show the second price footnote popup.', 'perfect-hot-tub-finder' ) ],

			'seating_capacity'        => [ 'label' => __( 'Seating Capacity', 'perfect-hot-tub-finder' ), 'type' => 'select', 'default' => '', 'legacy_placeholder_value' => '8 Adults', 'options' => [ '' => __( 'Select seating capacity', 'perfect-hot-tub-finder' ), '1 Adults' => '1 Adults', '2 Adults' => '2 Adults', '3 Adults' => '3 Adults', '4 Adults' => '4 Adults', '5 Adults' => '5 Adults', '6 Adults' => '6 Adults', '7 Adults' => '7 Adults', '8 Adults' => '8 Adults', '9 Adults' => '9 Adults', '10 Adults' => '10 Adults', '11 Adults' => '11 Adults', '12 Adults' => '12 Adults', '13 Adults' => '13 Adults', '14 Adults' => '14 Adults', '15 Adults' => '15 Adults' ] ],
			'seating_filter'          => [ 'label' => __( 'Seating Filter Value', 'perfect-hot-tub-finder' ), 'type' => 'select', 'default' => '', 'legacy_placeholder_value' => '6-8', 'options' => [ '' => __( 'Select seating filter', 'perfect-hot-tub-finder' ), '2-3' => '2-3 Seats', '4-5' => '4-5 Seats', '6-8' => '6-8 Seats' ] ],
			'price_tier'              => [ 'label' => __( 'Price Tier', 'perfect-hot-tub-finder' ), 'type' => 'select', 'default' => '', 'legacy_placeholder_value' => 'tier-4', 'options' => [ '' => __( 'Select price tier', 'perfect-hot-tub-finder' ), 'tier-1' => '$ (Up to $9,999)', 'tier-2' => '$$ ($10,000 - $16,999)', 'tier-3' => '$$$ ($17,000 - $20,999)', 'tier-4' => '$$$$ ($21,000 and up)' ] ],
			'explore_categories'      => [ 'label' => __( 'Explore Our Models Categories', 'perfect-hot-tub-finder' ), 'type' => 'checkbox_multiple', 'default' => '', 'options' => function_exists( 'phtf_explore_model_category_options' ) ? phtf_explore_model_category_options() : [ '2-3' => '2-3 Seats', '4-5' => '4-5 Seats', '6-8' => '6-8 Seats', 'lounge' => 'Lounge', 'salt-water' => 'Salt Water System', 'cold-plunge' => 'Cold Plunge' ], 'description' => __( 'Select one or more categories for the Explore Our Models widget tabs.', 'perfect-hot-tub-finder' ) ],
			'product_image_url'       => [ 'label' => __( 'Product Image URL', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => 'https://example.com/product-image.jpg', 'description' => __( 'Optional fallback. Use the Featured Image box for the main upload.', 'perfect-hot-tub-finder' ) ],
			'lifestyle_image_url'     => [ 'label' => __( 'Background / Lifestyle Image URL', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => 'https://example.com/lifestyle-image.jpg', 'description' => __( 'Optional fallback URL. For easier editing, use the Background / Lifestyle Image upload box in the right sidebar.', 'perfect-hot-tub-finder' ) ],
			'view_model_url'          => [ 'label' => __( 'View Model URL', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => 'https://your-link.com' ],
			'compare_url'             => [ 'label' => __( 'Compare URL', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => 'https://your-site.com/compare-spa-models/?spaID=1378', 'description' => __( 'Auto-filled from your compare page URL and the Compare Model ID. You can replace the page URL if needed.', 'perfect-hot-tub-finder' ) ],
			'reviews_url'             => [ 'label' => __( 'Reviews Link URL', 'perfect-hot-tub-finder' ), 'type' => 'url', 'default' => '', 'placeholder' => 'https://your-link.com', 'description' => __( 'Optional custom link for the review count in Spa Shop Slider.', 'perfect-hot-tub-finder' ) ],

			'price_note_popup_content'=> [ 'label' => __( 'Price Footnote Popup Text', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'rows' => 7, 'default' => '', 'placeholder' => function_exists( 'phtf_default_price_note_popup_content' ) ? phtf_default_price_note_popup_content( '1' ) : '', 'legacy_placeholder_value' => function_exists( 'phtf_default_price_note_popup_content' ) ? phtf_default_price_note_popup_content( '1' ) : '', 'description' => __( 'Popup content for the ¹ marker in Spa Shop Slider.', 'perfect-hot-tub-finder' ) ],
			'price_note_popup_content_2'=> [ 'label' => __( 'Price Footnote Popup Text 2', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'rows' => 7, 'default' => '', 'placeholder' => function_exists( 'phtf_default_price_note_popup_content' ) ? phtf_default_price_note_popup_content( '2' ) : '', 'legacy_placeholder_value' => function_exists( 'phtf_default_price_note_popup_content' ) ? phtf_default_price_note_popup_content( '2' ) : '', 'description' => __( 'Popup content for the ² marker in Spa Shop Slider.', 'perfect-hot-tub-finder' ) ],

			'brochure_url'            => [ 'label' => __( 'Download Brochure Link', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => 'https://your-link.com' ],
			'local_pricing_url'       => [ 'label' => __( 'Get Local Pricing URL', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => 'https://your-link.com' ],
			'owners_manual_url'       => [ 'label' => __( 'Owner Manual URL', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => 'https://your-link.com' ],
			'review_quote'            => [ 'label' => __( 'Review Quote', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => 'Enter customer review quote' ],
			'review_author'           => [ 'label' => __( 'Review Author', 'perfect-hot-tub-finder' ), 'type' => 'text', 'default' => '', 'placeholder' => 'Customer Name' ],
			'hero_description'        => [ 'label' => __( 'Single Hero Description', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'rows' => 5, 'default' => '', 'placeholder' => __( 'Describe this spa model for the Spa Model Single Hero.', 'perfect-hot-tub-finder' ), 'description' => __( 'Dynamic description shown in the Spa Model Single Hero widget.', 'perfect-hot-tub-finder' ) ],
			'dimensions'              => [ 'label' => __( 'Dimensions', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '9\' x 7\'7" x 38" / 274cm x 231cm x 97cm', 'legacy_placeholder_value' => '9\' x 7\'7" x 38" / 274cm x 231cm x 97cm' ],
			'water_capacity'          => [ 'label' => __( 'Water Capacity', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '615 gallons / 2325 liters', 'legacy_placeholder_value' => '615 gallons / 2325 liters' ],
			'weight_dry'              => [ 'label' => __( 'Weight (dry)', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '1310 lbs. / 595 kg', 'legacy_placeholder_value' => '1310 lbs. / 595 kg' ],
			'weight_filled'           => [ 'label' => __( 'Weight (filled)', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '7840 lbs. / 3560 kg', 'legacy_placeholder_value' => '7840 lbs. / 3560 kg' ],
			'jet_count'               => [ 'label' => __( 'Jet Count', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '74 Total Jets', 'legacy_placeholder_value' => '74 Total Jets' ],
			'jets'                    => [ 'label' => __( 'Jets', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => "1 Atlas® Neck Massage\n56 Euro\n7 VersaSage®\n4 AdaptaSage®\n4 Euro-Pulse®\n2 OrbiSsage®\n1 Euphoria®", 'legacy_placeholder_value' => "1 Atlas® Neck Massage\n56 Euro\n7 VersaSage®\n4 AdaptaSage®\n4 Euro-Pulse®\n2 OrbiSsage®\n1 Euphoria®" ],
			'water_care_systems'      => [ 'label' => __( 'Water Care Systems', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'FreshWater® IQ Ready Salt + Smart Monitoring Included | Dosing Optional', 'legacy_placeholder_value' => 'FreshWater® IQ Ready Salt + Smart Monitoring Included | Dosing Optional' ],
			'ultramasseuse_system'    => [ 'label' => __( 'Ultramasseuse System', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '6 Jetting Sequences; 3 Speeds', 'legacy_placeholder_value' => '6 Jetting Sequences; 3 Speeds' ],
			'jet_pumps'               => [ 'label' => __( 'Jet Pump(s)', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => "3 ReliaFlo® Pumps;\n2 Dual-Speed 2.5 HP (5.2BHP)\n1 Single-Speed 2.5HP (5.2 BHP)", 'legacy_placeholder_value' => "3 ReliaFlo® Pumps;\n2 Dual-Speed 2.5 HP (5.2BHP)\n1 Single-Speed 2.5HP (5.2 BHP)" ],
			'control_system'          => [ 'label' => __( 'Control System', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'Advent® LCD Touchscreen Control with Auxiliary panel & UltraMasseuse Panel', 'legacy_placeholder_value' => 'Advent® LCD Touchscreen Control with Auxiliary panel & UltraMasseuse Panel' ],
			'circulation_pump'        => [ 'label' => __( 'Circulation Pump', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'EnergyPro® Circulation Pump', 'legacy_placeholder_value' => 'EnergyPro® Circulation Pump' ],
			'heater_output'           => [ 'label' => __( 'Heater Output', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'EnergyPro® Heater (4,000 Watts)', 'legacy_placeholder_value' => 'EnergyPro® Heater (4,000 Watts)' ],
			'electrical_requirements' => [ 'label' => __( 'Electrical Requirements', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '230v/50 amp or 70 amp', 'legacy_placeholder_value' => '230v/50 amp or 70 amp' ],
			'gfci_sub_panel'          => [ 'label' => __( 'GFCI Sub-panel', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'GFCI Sub-panel (50 amp) included', 'legacy_placeholder_value' => 'GFCI Sub-panel (50 amp) included' ],
			'filter_size'             => [ 'label' => __( 'Filter Size', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '100 sq. ft. filter', 'legacy_placeholder_value' => '100 sq. ft. filter' ],
			'ozone_system'            => [ 'label' => __( 'Ozone System', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '(Optional) Corona Discharge Ozone. Not compatible with the FreshWater IQ System.', 'legacy_placeholder_value' => '(Optional) Corona Discharge Ozone. Not compatible with the FreshWater IQ System.' ],
			'water_feature'           => [ 'label' => __( 'Water Feature', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '2 Acquarella® Waterfalls with LED lighting', 'legacy_placeholder_value' => '2 Acquarella® Waterfalls with LED lighting' ],
			'multi_color_led_lighting'=> [ 'label' => __( 'Multi-color Led Lighting', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'SpaGlo® Multi-Zone LED Lighting including 7 Points-of-Interior Lights & Exterior Light Bar', 'legacy_placeholder_value' => 'SpaGlo® Multi-Zone LED Lighting including 7 Points-of-Interior Lights & Exterior Light Bar' ],
			'energy_efficiency'       => [ 'label' => __( 'Energy Efficiency', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'Fully-insulated with FiberCor® material, 2 lb. density, CEC-compliant', 'legacy_placeholder_value' => 'Fully-insulated with FiberCor® material, 2 lb. density, CEC-compliant' ],
			'branding'                => [ 'label' => __( 'Branding', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'Large acrylic logo plate with On/Ready indicator light', 'legacy_placeholder_value' => 'Large acrylic logo plate with On/Ready indicator light' ],
			'bottom_seal'             => [ 'label' => __( 'Bottom Seal', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'ABS Base Pan', 'legacy_placeholder_value' => 'ABS Base Pan' ],
			'insulating_cover'        => [ 'label' => __( 'Insulating Cover', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'WeatherPro™ 4” tapered custom fit with hinge seal', 'legacy_placeholder_value' => 'WeatherPro™ 4” tapered custom fit with hinge seal' ],
			'spa_shell_options'       => [ 'label' => __( 'Spa Shell Options', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'White Pearl, Platinum, Tuscan Sun, Arctic White, Midnight Canyon', 'legacy_placeholder_value' => 'White Pearl, Platinum, Tuscan Sun, Arctic White, Midnight Canyon' ],
			'cabinet_type'            => [ 'label' => __( 'Cabinet Type', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'EcoTech® Plus', 'legacy_placeholder_value' => 'EcoTech® Plus' ],
			'cabinet_step_colors'     => [ 'label' => __( 'Cabinet & Step Colors', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'Java, Ash & Parchment', 'legacy_placeholder_value' => 'Java, Ash & Parchment' ],
			'cover_lifter'            => [ 'label' => __( 'Cover Lifter', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '(Included) ProLift® III Cover Lifter', 'legacy_placeholder_value' => '(Included) ProLift® III Cover Lifter' ],
			'cover_colors'            => [ 'label' => __( 'Cover Colors', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'Storm, Chestnut, Black', 'legacy_placeholder_value' => 'Storm, Chestnut, Black' ],
			'cover_design'            => [ 'label' => __( 'Cover Design', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => 'Curved front skirt', 'legacy_placeholder_value' => 'Curved front skirt' ],
			'music_system'            => [ 'label' => __( 'Music System', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '(Optional) Wireless Audio System with Wireless Technology; Subwoofer; 22” HD Wireless Monitor (each sold separately)', 'legacy_placeholder_value' => '(Optional) Wireless Audio System with Wireless Technology; Subwoofer; 22” HD Wireless Monitor (each sold separately)' ],
			'entertainment_system'    => [ 'label' => __( 'Entertainment System', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '(Optional) 22” HD Wireless Monitor', 'legacy_placeholder_value' => '(Optional) 22” HD Wireless Monitor' ],
			'step_type'               => [ 'label' => __( 'Step Type', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '(Optional) Utopia® Step in Java, Ash & Parchment', 'legacy_placeholder_value' => '(Optional) Utopia® Step in Java, Ash & Parchment' ],
			'smart_spa_technology'    => [ 'label' => __( 'Smart Spa Technology', 'perfect-hot-tub-finder' ), 'type' => 'textarea', 'default' => '', 'placeholder' => '(Optional) Caldera Spas App, Powered by the Connected Spa Kit', 'legacy_placeholder_value' => '(Optional) Caldera Spas App, Powered by the Connected Spa Kit' ],
		];
	}
}

if ( ! function_exists( 'phtf_spa_model_specs_labels' ) ) {
	function phtf_spa_model_specs_labels() {
		$fields = phtf_spa_model_meta_fields();
		$skip   = [ 'compare_category', 'spa_id', 'rating', 'reviews', 'price', 'secondary_price', 'seating_capacity', 'seating_filter', 'price_tier', 'explore_categories', 'product_image_url', 'lifestyle_image_url', 'view_model_url', 'compare_url', 'model_title_url', 'reviews_url', 'price_note_popup_content', 'price_note_popup_content_2', 'brochure_url', 'local_pricing_url', 'owners_manual_url', 'review_quote', 'review_author' ];
		$labels = [];
		foreach ( $fields as $key => $field ) {
			if ( in_array( $key, $skip, true ) ) {
				continue;
			}
			$labels[ $key ] = $field['label'];
		}
		return $labels;
	}
}

if ( ! function_exists( 'phtf_get_spa_models' ) ) {
	function phtf_get_spa_models( $args = [] ) {
		$defaults = [
			'post_type'      => 'phtf_spa_model',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
		];

		$query = new WP_Query( wp_parse_args( $args, $defaults ) );
		$models = [];
		foreach ( $query->posts as $post ) {
			$models[] = phtf_get_spa_model_data( $post->ID );
		}
		wp_reset_postdata();
		return $models;
	}
}

if ( ! function_exists( 'phtf_get_spa_model_data' ) ) {
	function phtf_get_spa_model_data( $post_id ) {
		$fields = phtf_spa_model_meta_fields();
		$data = [
			'id'         => (int) $post_id,
			'title'      => get_the_title( $post_id ),
			'slug'       => get_post_field( 'post_name', $post_id ),
			'url'        => get_permalink( $post_id ),
			'menu_order' => (int) get_post_field( 'menu_order', $post_id ),
		];

		foreach ( $fields as $key => $field ) {
			$value = get_post_meta( $post_id, '_phtf_' . $key, true );
			$value = phtf_normalize_placeholder_meta_value( $value, $field );
			if ( '' === $value && isset( $field['default'] ) ) {
				$value = $field['default'];
			}
			$data[ $key ] = $value;
		}

		if ( empty( $data['compare_url'] ) && function_exists( 'phtf_get_compare_url_for_spa_model' ) ) {
			$data['compare_url'] = phtf_get_compare_url_for_spa_model( $data['spa_id'] ?? $post_id );
		}

		$lifestyle_image_ids = get_post_meta( $post_id, '_phtf_lifestyle_image_ids', true );
		$lifestyle_image_ids = is_array( $lifestyle_image_ids ) ? $lifestyle_image_ids : preg_split( '/[,|]+/', (string) $lifestyle_image_ids );
		$lifestyle_image_ids = array_values( array_filter( array_map( 'absint', (array) $lifestyle_image_ids ) ) );

		$legacy_lifestyle_image_id = absint( get_post_meta( $post_id, '_phtf_lifestyle_image_id', true ) );
		if ( empty( $lifestyle_image_ids ) && $legacy_lifestyle_image_id ) {
			$lifestyle_image_ids = [ $legacy_lifestyle_image_id ];
		}

		$data['lifestyle_image_ids'] = $lifestyle_image_ids;
		$data['lifestyle_images']    = [];
		foreach ( $lifestyle_image_ids as $image_id ) {
			$lifestyle_image_url = wp_get_attachment_image_url( $image_id, 'full' );
			if ( $lifestyle_image_url ) {
				$data['lifestyle_images'][] = esc_url_raw( $lifestyle_image_url );
			}
		}
		if ( ! empty( $data['lifestyle_images'] ) ) {
			$data['lifestyle_image_url'] = $data['lifestyle_images'][0];
		} elseif ( function_exists( 'phtf_get_fallback_image_url' ) ) {
			$data['lifestyle_image_url'] = phtf_get_fallback_image_url( 'lifestyle' );
		}

		if ( function_exists( 'phtf_get_spa_model_compare_category_data' ) ) {
			$category_data = phtf_get_spa_model_compare_category_data( $post_id );
			$data['compare_category']       = $category_data['key'];
			$data['compare_category_label'] = $category_data['label'];
			$data['compare_category_key']   = $category_data['key'];

			// Series fields were removed from the dashboard. Keep these derived values so
			// older widgets can still display a series label using the Spa Category.
			$data['series_display'] = $data['compare_category_label'];
			$data['series']         = trim( preg_replace( '/[®™]?\s*Series$/u', '', wp_strip_all_tags( $data['compare_category_label'] ) ) );
		}

		$image = get_the_post_thumbnail_url( $post_id, 'large' );
		if ( ! $image && ! empty( $data['product_image_url'] ) ) {
			$image = $data['product_image_url'];
		}
		$data['image'] = $image ? esc_url_raw( $image ) : ( function_exists( 'phtf_get_fallback_image_url' ) ? phtf_get_fallback_image_url( 'product' ) : '' );

		$specs = [];
		foreach ( phtf_spa_model_specs_labels() as $key => $label ) {
			$specs[ $key ] = [
				'label' => $label,
				'value' => $data[ $key ] ?? '',
			];
		}
		$data['specs'] = $specs;

		return $data;
	}
}

if ( ! function_exists( 'phtf_get_first_spa_model_data' ) ) {
	function phtf_get_first_spa_model_data() {
		$models = function_exists( 'phtf_get_spa_models' ) ? phtf_get_spa_models() : [];
		return ! empty( $models ) ? $models[0] : null;
	}
}

if ( ! function_exists( 'phtf_spa_model_text' ) ) {
	function phtf_spa_model_text( $model, $fallback = '' ) {
		if ( empty( $model['id'] ) ) {
			return $fallback;
		}
		$excerpt = get_the_excerpt( $model['id'] );
		if ( ! empty( $excerpt ) ) {
			return $excerpt;
		}
		$content = wp_strip_all_tags( get_post_field( 'post_content', $model['id'] ) );
		return ! empty( $content ) ? $content : $fallback;
	}
}

if ( ! function_exists( 'phtf_spa_model_lines' ) ) {
	function phtf_spa_model_lines( $value ) {
		$value = (string) $value;
		$value = str_replace( [ "\r\n", "\r", '&' ], [ "\n", "\n", ',' ], $value );
		$parts = preg_split( '/[,\n\|]+/', $value );
		$parts = array_filter( array_map( 'trim', (array) $parts ) );
		return array_values( $parts );
	}
}

if ( ! function_exists( 'phtf_spa_model_swatches' ) ) {
	function phtf_spa_model_swatches( $value, $preview_url = '' ) {
		$colors  = [ '#6f5848', '#8c8f8f', '#d7c8ad', '#f3f1ed', '#b7aaa1', '#d3b37d', '#f7f7f7', '#2f3640', '#111111' ];
		$items   = [];
		$names   = phtf_spa_model_lines( $value );
		foreach ( $names as $index => $name ) {
			$items[] = [
				'name'          => $name,
				'swatch_color'  => $colors[ $index % count( $colors ) ],
				'swatch_image'  => [ 'url' => '' ],
				'preview_image' => [ 'url' => $preview_url ],
				'active'        => 0 === $index ? 'yes' : '',
			];
		}
		return $items;
	}
}

if ( ! function_exists( 'phtf_spa_model_spec_rows' ) ) {
	function phtf_spa_model_spec_rows( $model, $keys = [] ) {
		$rows   = [];
		$labels = function_exists( 'phtf_spa_model_specs_labels' ) ? phtf_spa_model_specs_labels() : [];
		if ( empty( $keys ) ) {
			$keys = array_keys( $labels );
		}
		foreach ( $keys as $key ) {
			$value = $model[ $key ] ?? '';
			if ( '' === trim( (string) $value ) ) {
				continue;
			}
			$rows[] = [
				'row_label' => isset( $labels[ $key ] ) ? $labels[ $key ] : ucwords( str_replace( '_', ' ', $key ) ),
				'row_value' => nl2br( esc_html( $value ) ),
			];
		}
		return $rows;
	}
}

if ( ! function_exists( 'phtf_spa_model_cards' ) ) {
	function phtf_spa_model_cards( $models = null ) {
		if ( null === $models ) {
			$models = function_exists( 'phtf_get_spa_models' ) ? phtf_get_spa_models() : [];
		}
		$cards = [];
		foreach ( (array) $models as $model ) {
			$cards[] = [
				'image'        => [ 'url' => ! empty( $model['image'] ) ? $model['image'] : '' ],
				'image_alt'    => $model['title'] ?? '',
				'series_label' => strtoupper( (string) ( $model['series'] ?? $model['series_display'] ?? '' ) ),
				'model_name'   => $model['title'] ?? '',
				'reviews'      => ! empty( $model['reviews'] ) ? '(' . trim( (string) $model['reviews'], '() ' ) . ')' : '',
				'seats'        => ! empty( $model['seating_capacity'] ) ? sprintf( __( 'Seats %s', 'perfect-hot-tub-finder' ), preg_replace( '/[^0-9\-]+/', '', (string) $model['seating_capacity'] ) ) : '',
			'price'        => ! empty( $model['price'] ) ? 'MSRP: ' . $model['price'] : '',
			'price_note_popup_content' => $model['price_note_popup_content'] ?? '',
			'link'         => [ 'url' => ! empty( $model['view_model_url'] ) ? $model['view_model_url'] : ( $model['url'] ?? '' ) ],
			'reviews_link' => [ 'url' => ! empty( $model['reviews_url'] ) ? $model['reviews_url'] : ( $model['url'] ?? '' ) ],
			];
		}
		return $cards;
	}
}

class PHTF_Spa_Models_CPT {
	public function __construct() {
		add_action( 'init', [ $this, 'register_post_type' ] );
		add_action( 'init', [ $this, 'disable_elementor_builder_support' ], 30 );
		add_action( 'admin_init', [ $this, 'disable_elementor_cpt_option' ] );
		add_filter( 'elementor/utils/is_post_type_support', [ $this, 'force_elementor_post_type_support' ], 10, 2 );
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'save_post_phtf_spa_model', [ $this, 'save_meta' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
		add_filter( 'manage_phtf_spa_model_posts_columns', [ $this, 'admin_columns' ] );
		add_action( 'manage_phtf_spa_model_posts_custom_column', [ $this, 'admin_column_content' ], 10, 2 );
	}

	public function disable_elementor_builder_support() {
		remove_post_type_support( 'phtf_spa_model', 'editor' );
		remove_post_type_support( 'phtf_spa_model', 'elementor' );
	}

	public function force_elementor_post_type_support( $is_supported, $post_type ) {
		if ( 'phtf_spa_model' === $post_type ) {
			return false;
		}

		return $is_supported;
	}

	public function disable_elementor_cpt_option() {
		$supported_post_types = get_option( 'elementor_cpt_support' );
		if ( ! is_array( $supported_post_types ) || ! in_array( 'phtf_spa_model', $supported_post_types, true ) ) {
			return;
		}

		$supported_post_types = array_values( array_diff( $supported_post_types, [ 'phtf_spa_model' ] ) );
		update_option( 'elementor_cpt_support', $supported_post_types );
	}

	public function register_post_type() {
		register_post_type(
			'phtf_spa_model',
			[
				'labels' => [
					'name'               => __( 'Spa Models', 'perfect-hot-tub-finder' ),
					'singular_name'      => __( 'Spa Model', 'perfect-hot-tub-finder' ),
					'menu_name'          => __( 'Spa Models', 'perfect-hot-tub-finder' ),
					'add_new_item'       => __( 'Add New Spa Model', 'perfect-hot-tub-finder' ),
					'edit_item'          => __( 'Edit Spa Model', 'perfect-hot-tub-finder' ),
					'new_item'           => __( 'New Spa Model', 'perfect-hot-tub-finder' ),
					'view_item'          => __( 'View Spa Model', 'perfect-hot-tub-finder' ),
					'search_items'       => __( 'Search Spa Models', 'perfect-hot-tub-finder' ),
					'not_found'          => __( 'No spa models found.', 'perfect-hot-tub-finder' ),
				],
				'public'       => true,
				'show_ui'      => true,
				'show_in_menu' => true,
				'menu_icon'    => 'dashicons-screenoptions',
				'supports'     => [ 'title', 'thumbnail', 'page-attributes' ],
				'taxonomies'   => [ PHTF_SPA_CATEGORY_TAXONOMY ],
				'has_archive'  => false,
				'rewrite'      => [ 'slug' => 'spa-model' ],
				'show_in_rest' => true,
			]
		);

		$this->register_taxonomy();
	}

	public function register_taxonomy() {
		register_taxonomy(
			PHTF_SPA_CATEGORY_TAXONOMY,
			[ 'phtf_spa_model' ],
			[
				'labels' => [
					'name'              => __( 'Spa Categories', 'perfect-hot-tub-finder' ),
					'singular_name'     => __( 'Spa Category', 'perfect-hot-tub-finder' ),
					'menu_name'         => __( 'Spa Categories', 'perfect-hot-tub-finder' ),
					'all_items'         => __( 'All Spa Categories', 'perfect-hot-tub-finder' ),
					'edit_item'         => __( 'Edit Spa Category', 'perfect-hot-tub-finder' ),
					'view_item'         => __( 'View Spa Category', 'perfect-hot-tub-finder' ),
					'update_item'       => __( 'Update Spa Category', 'perfect-hot-tub-finder' ),
					'add_new_item'      => __( 'Add New Spa Category', 'perfect-hot-tub-finder' ),
					'new_item_name'     => __( 'New Spa Category Name', 'perfect-hot-tub-finder' ),
					'search_items'      => __( 'Search Spa Categories', 'perfect-hot-tub-finder' ),
					'not_found'         => __( 'No spa categories found.', 'perfect-hot-tub-finder' ),
				],
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_in_menu'      => false,
				'meta_box_cb'       => false,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'rewrite'           => [ 'slug' => 'spa-category' ],
			]
		);

		foreach ( phtf_compare_spa_category_default_options() as $slug => $label ) {
			if ( ! term_exists( $slug, PHTF_SPA_CATEGORY_TAXONOMY ) && ! term_exists( $label, PHTF_SPA_CATEGORY_TAXONOMY ) ) {
				wp_insert_term( $label, PHTF_SPA_CATEGORY_TAXONOMY, [ 'slug' => $slug ] );
			}
		}
	}

	public function add_meta_boxes() {
		add_meta_box( 'phtf_spa_model_details', __( 'Spa Shop Slider Product Details', 'perfect-hot-tub-finder' ), [ $this, 'render_details_meta_box' ], 'phtf_spa_model', 'normal', 'high' );
		add_meta_box( 'phtf_spa_model_specs', __( 'Compare Specifications', 'perfect-hot-tub-finder' ), [ $this, 'render_specs_meta_box' ], 'phtf_spa_model', 'normal', 'default' );
		add_meta_box( 'phtf_spa_model_lifestyle_image', __( 'Background / Lifestyle Image', 'perfect-hot-tub-finder' ), [ $this, 'render_lifestyle_image_meta_box' ], 'phtf_spa_model', 'side', 'default' );
		add_meta_box( 'phtf_spa_model_categories', __( 'Spa Categories', 'perfect-hot-tub-finder' ), [ $this, 'render_spa_categories_meta_box' ], 'phtf_spa_model', 'side', 'default' );
		add_meta_box( 'phtf_spa_model_explore_categories', __( 'Explore Our Models Categories', 'perfect-hot-tub-finder' ), [ $this, 'render_explore_categories_meta_box' ], 'phtf_spa_model', 'side', 'default' );
	}

	public function enqueue_admin_assets( $hook ) {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || 'phtf_spa_model' !== $screen->post_type ) {
			return;
		}

		wp_enqueue_media();
		wp_add_inline_style( 'wp-admin', '.post-type-phtf_spa_model #phtf_spa_category-tabs, .post-type-phtf_spa_model #phtf_spa_category-adder, .post-type-phtf_spa_model #taxonomy-phtf_spa_category .taxonomy-add-new { display:none !important; } .post-type-phtf_spa_model #postdivrich, .post-type-phtf_spa_model #elementor-switch-mode, .post-type-phtf_spa_model .elementor-switch-mode, .post-type-phtf_spa_model .edit-with-elementor, .post-type-phtf_spa_model .elementor-button { display:none !important; }' );
		wp_add_inline_script(
			'jquery-core',
			<<<'JS'
document.addEventListener('click', function(event) {
	var uploadButton = event.target.closest('.phtf-upload-lifestyle-image');
	var removeButton = event.target.closest('.phtf-remove-lifestyle-image');

	function renderSpaImages(box, attachments) {
		var input = box.querySelector('[name="phtf_lifestyle_image_ids"]');
		var preview = box.querySelector('.phtf-lifestyle-image-preview');
		var remove = box.querySelector('.phtf-remove-lifestyle-image');
		var upload = box.querySelector('.phtf-upload-lifestyle-image');
		var attachment = attachments && attachments.length ? attachments[0] : null;
		var ids = [];
		var html = '';

		if (attachment && attachment.id) {
			ids.push(attachment.id);
			var url = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : (attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : (attachment.url || ''));
			if (url) {
				html = '<span class="phtf-lifestyle-thumb" style="display:block;border:1px solid #dcdcde;background:#f6f7f7;padding:4px;"><img src="' + url + '" alt="" style="width:100%;height:auto;display:block;" /></span>';
			}
		}

		if (input) {
			input.value = ids.join(',');
		}
		if (preview) {
			preview.innerHTML = html;
		}
		if (remove) {
			remove.style.display = ids.length ? '' : 'none';
		}
		if (upload) {
			upload.textContent = ids.length ? (upload.getAttribute('data-change') || 'Replace Background Image') : (upload.getAttribute('data-select') || 'Set Background Image');
		}
	}

	if (uploadButton) {
		event.preventDefault();
		var box = uploadButton.closest('.phtf-lifestyle-image-box');
		if (!box || typeof wp === 'undefined' || !wp.media) {
			return;
		}

		var input = box.querySelector('[name="phtf_lifestyle_image_ids"]');
		var selectedIds = input && input.value ? input.value.split(',').filter(Boolean).slice(0, 1) : [];
		var frame = wp.media({
			title: uploadButton.getAttribute('data-title') || 'Select Background / Lifestyle Image',
			button: { text: uploadButton.getAttribute('data-button') || 'Use Background Image' },
			multiple: false,
			library: { type: 'image' }
		});

		frame.on('open', function() {
			var selection = frame.state().get('selection');
			selectedIds.forEach(function(id) {
				var attachment = wp.media.attachment(id);
				attachment.fetch();
				selection.add(attachment ? [attachment] : []);
			});
		});

		frame.on('select', function() {
			var attachment = frame.state().get('selection').first();
			renderSpaImages(box, attachment ? [attachment.toJSON()] : []);
		});

		frame.open();
	}

	if (removeButton) {
		event.preventDefault();
		var wrap = removeButton.closest('.phtf-lifestyle-image-box');
		if (!wrap) {
			return;
		}

		renderSpaImages(wrap, []);
	}
});
JS
		);
	}

	private function render_field( $post_id, $key, $field ) {
		$value = get_post_meta( $post_id, '_phtf_' . $key, true );
		$value = phtf_normalize_placeholder_meta_value( $value, $field );
		if ( 'spa_id' === $key && '' === trim( (string) $value ) && function_exists( 'phtf_generate_unique_spa_model_id' ) ) {
			$value = phtf_generate_unique_spa_model_id( $post_id );
		}
		if ( '' === $value && isset( $field['default'] ) ) {
			$value = $field['default'];
		}
		$placeholder = isset( $field['placeholder'] ) ? (string) $field['placeholder'] : '';
		$name = 'phtf_spa_model[' . esc_attr( $key ) . ']';
		$id   = 'phtf_' . esc_attr( $key );
		$readonly = ! empty( $field['readonly'] ) ? ' readonly="readonly"' : '';
		$description = ! empty( $field['description'] ) ? (string) $field['description'] : '';
		if ( 'compare_url' === $key ) {
			$spa_id = get_post_meta( $post_id, '_phtf_spa_id', true );
			$spa_id = trim( (string) $spa_id );
			if ( '' === $spa_id && function_exists( 'phtf_generate_unique_spa_model_id' ) ) {
				$spa_id = phtf_generate_unique_spa_model_id( $post_id );
			}
			$auto_compare_url = function_exists( 'phtf_get_compare_url_for_spa_model' ) ? phtf_get_compare_url_for_spa_model( $spa_id ) : '';
			if ( '' === trim( (string) $value ) ) {
				$value = $auto_compare_url;
			}
			if ( '' !== $auto_compare_url ) {
				$placeholder = $auto_compare_url;
			}
			$description = sprintf(
				/* translators: 1: Compare Model ID value, 2: auto-generated compare URL. */
				__( 'Auto-filled from the Compare Model ID %1$s. Use this URL for the Compare Models button: %2$s', 'perfect-hot-tub-finder' ),
				'' !== $spa_id ? $spa_id : '1378',
				$auto_compare_url ? $auto_compare_url : __( 'save this Spa Model to generate the URL', 'perfect-hot-tub-finder' )
			);
		}
		?>
		<p class="phtf-admin-field phtf-admin-field--<?php echo esc_attr( $field['type'] ); ?>">
			<label for="<?php echo esc_attr( $id ); ?>"><strong><?php echo esc_html( $field['label'] ); ?></strong></label>
			<?php if ( 'textarea' === $field['type'] ) : ?>
				<?php $rows = ! empty( $field['rows'] ) ? absint( $field['rows'] ) : 3; ?>
				<textarea id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" rows="<?php echo esc_attr( $rows ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" style="width:100%;"><?php echo esc_textarea( $value ); ?></textarea>
			<?php elseif ( 'select_multiple' === $field['type'] || 'checkbox_multiple' === $field['type'] ) : ?>
				<?php
				$selected_values = is_array( $value ) ? $value : preg_split( '/[,|]+/', (string) $value );
				$selected_values = array_filter( array_map( 'trim', (array) $selected_values ) );
				$normalized_values = [];
				if ( isset( $field['options'] ) && is_array( $field['options'] ) ) {
					foreach ( $selected_values as $selected_value ) {
						$selected_value = (string) $selected_value;
						if ( isset( $field['options'][ $selected_value ] ) ) {
							$normalized_values[] = $selected_value;
							continue;
						}
						foreach ( $field['options'] as $option_value => $option_label ) {
							if ( strtolower( trim( wp_strip_all_tags( $selected_value ) ) ) === strtolower( trim( wp_strip_all_tags( (string) $option_label ) ) ) ) {
								$normalized_values[] = (string) $option_value;
								break;
							}
						}
					}
				}
				$selected_values = array_unique( $normalized_values );
				?>
				<?php if ( 'checkbox_multiple' === $field['type'] ) : ?>
					<div id="<?php echo esc_attr( $id ); ?>" class="phtf-admin-checkboxes" style="display:flex;flex-direction:column;gap:6px;padding:10px 12px;border:1px solid #8c8f94;background:#fff;max-height:170px;overflow:auto;">
						<?php foreach ( $field['options'] as $option_value => $option_label ) : ?>
							<label style="display:flex;align-items:center;gap:8px;margin:0;">
								<input type="checkbox" name="<?php echo esc_attr( $name ); ?>[]" value="<?php echo esc_attr( $option_value ); ?>" <?php checked( in_array( (string) $option_value, $selected_values, true ), true ); ?> />
								<span><?php echo esc_html( $option_label ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>[]" multiple="multiple" size="6" style="width:100%;min-height:138px;">
						<?php foreach ( $field['options'] as $option_value => $option_label ) : ?>
							<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( in_array( (string) $option_value, $selected_values, true ), true ); ?>><?php echo esc_html( $option_label ); ?></option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>
			<?php elseif ( 'select' === $field['type'] ) : ?>
				<?php
				$selected_value = (string) $value;
				if ( isset( $field['options'] ) && is_array( $field['options'] ) && ! isset( $field['options'][ $selected_value ] ) ) {
					foreach ( $field['options'] as $option_value => $option_label ) {
						if ( strtolower( trim( wp_strip_all_tags( (string) $selected_value ) ) ) === strtolower( trim( wp_strip_all_tags( (string) $option_label ) ) ) ) {
							$selected_value = (string) $option_value;
							break;
						}
					}
				}
				?>
				<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" style="width:100%;">
					<?php foreach ( $field['options'] as $option_value => $option_label ) : ?>
						<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $selected_value, (string) $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
					<?php endforeach; ?>
				</select>
			<?php else : ?>
				<input type="<?php echo esc_attr( $field['type'] ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" style="width:100%;"<?php echo $readonly; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> />
			<?php endif; ?>
			<?php if ( '' !== $description ) : ?>
				<span class="description"><?php echo esc_html( $description ); ?></span>
			<?php endif; ?>
		</p>
		<?php
	}

	public function render_details_meta_box( $post ) {
		wp_nonce_field( 'phtf_save_spa_model', 'phtf_spa_model_nonce' );
		$fields = phtf_spa_model_meta_fields();
		$detail_keys = [ 'spa_id', 'rating', 'reviews', 'reviews_url', 'price', 'price_note_popup_content', 'secondary_price', 'price_note_popup_content_2', 'hero_description', 'seating_capacity', 'seating_filter', 'price_tier', 'view_model_url', 'compare_url', 'brochure_url', 'local_pricing_url' ];
		echo '<p class="description" style="margin-top:0;">' . esc_html__( 'These fields replace the old Elementor product repeater for the Spa Shop Slider. Use one Spa Model post for each product/result.', 'perfect-hot-tub-finder' ) . '</p>';
		echo '<div class="phtf-admin-grid" style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px 18px;">';
		foreach ( $detail_keys as $key ) {
			if ( isset( $fields[ $key ] ) ) {
				echo '<div>';
				$this->render_field( $post->ID, $key, $fields[ $key ] );
				echo '</div>';
			}
		}
		echo '</div>';
	}

	public function render_specs_meta_box( $post ) {
		$fields = phtf_spa_model_meta_fields();
		$spec_keys = array_values( array_diff( array_keys( phtf_spa_model_specs_labels() ), [ 'seating_capacity' ] ) );

		// Seating Capacity is managed in the Spa Shop Slider Product Details box only.
		unset( $fields['seating_capacity'] );
		echo '<div class="phtf-admin-grid" style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px 18px;">';
		foreach ( $spec_keys as $key ) {
			if ( 'seating_capacity' === $key ) {
				continue;
			}

			if ( isset( $fields[ $key ] ) ) {
				echo '<div>';
				$this->render_field( $post->ID, $key, $fields[ $key ] );
				echo '</div>';
			}
		}
		echo '</div>';
	}

	public function render_spa_categories_meta_box( $post ) {
		$terms = get_terms(
			[
				'taxonomy'   => PHTF_SPA_CATEGORY_TAXONOMY,
				'hide_empty' => false,
				'orderby'    => 'name',
			]
		);

		if ( is_wp_error( $terms ) ) {
			$terms = [];
		}

		$selected_terms = wp_get_object_terms( $post->ID, PHTF_SPA_CATEGORY_TAXONOMY, [ 'fields' => 'ids' ] );
		if ( is_wp_error( $selected_terms ) ) {
			$selected_terms = [];
		}
		$selected_terms = array_map( 'absint', (array) $selected_terms );
		?>
		<div class="categorydiv phtf-spa-category-box">
			<div class="tabs-panel" style="max-height:220px;overflow:auto;border:1px solid #dcdcde;background:#fff;padding:8px 10px;">
				<ul class="categorychecklist form-no-clear" style="margin:0;">
					<?php foreach ( (array) $terms as $term ) : ?>
						<li style="margin:0 0 6px;">
							<label class="selectit">
								<input type="checkbox" name="phtf_spa_category_terms[]" value="<?php echo esc_attr( $term->term_id ); ?>" <?php checked( in_array( (int) $term->term_id, $selected_terms, true ), true ); ?> />
								<?php echo esc_html( $term->name ); ?>
							</label>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php
	}

	public function render_explore_categories_meta_box( $post ) {
		$fields = phtf_spa_model_meta_fields();
		$field  = isset( $fields['explore_categories'] ) ? $fields['explore_categories'] : [
			'options' => function_exists( 'phtf_explore_model_category_options' ) ? phtf_explore_model_category_options() : [],
		];

		$value = get_post_meta( $post->ID, '_phtf_explore_categories', true );
		if ( '' === $value && isset( $field['default'] ) ) {
			$value = $field['default'];
		}

		$selected_values = is_array( $value ) ? $value : preg_split( '/[,|]+/', (string) $value );
		$selected_values = array_filter( array_map( 'trim', (array) $selected_values ) );
		$normalized_values = [];

		if ( ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
			foreach ( $selected_values as $selected_value ) {
				$selected_value = (string) $selected_value;
				if ( isset( $field['options'][ $selected_value ] ) ) {
					$normalized_values[] = $selected_value;
					continue;
				}
				foreach ( $field['options'] as $option_value => $option_label ) {
					if ( strtolower( trim( wp_strip_all_tags( $selected_value ) ) ) === strtolower( trim( wp_strip_all_tags( (string) $option_label ) ) ) ) {
						$normalized_values[] = (string) $option_value;
						break;
					}
				}
			}
		}

		$selected_values = array_unique( $normalized_values );
		?>
		<div class="categorydiv phtf-explore-category-box">
			<div class="tabs-panel" style="max-height:220px;overflow:auto;border:1px solid #dcdcde;background:#fff;padding:8px 10px;">
				<ul class="categorychecklist form-no-clear" style="margin:0;">
					<?php foreach ( (array) $field['options'] as $option_value => $option_label ) : ?>
						<li style="margin:0 0 6px;">
							<label class="selectit">
								<input type="checkbox" name="phtf_spa_model[explore_categories][]" value="<?php echo esc_attr( $option_value ); ?>" <?php checked( in_array( (string) $option_value, $selected_values, true ), true ); ?> />
								<?php echo esc_html( $option_label ); ?>
							</label>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php
	}

	public function render_lifestyle_image_meta_box( $post ) {
		$image_ids = get_post_meta( $post->ID, '_phtf_lifestyle_image_ids', true );
		$image_ids = is_array( $image_ids ) ? $image_ids : preg_split( '/[,|]+/', (string) $image_ids );
		$image_ids = array_values( array_filter( array_map( 'absint', (array) $image_ids ) ) );

		$legacy_image_id = absint( get_post_meta( $post->ID, '_phtf_lifestyle_image_id', true ) );
		if ( empty( $image_ids ) && $legacy_image_id ) {
			$image_ids = [ $legacy_image_id ];
		}
		?>
		<?php $primary_image_id = ! empty( $image_ids ) ? absint( $image_ids[0] ) : 0; ?>
		<div class="phtf-lifestyle-image-box">
			<input type="hidden" name="phtf_lifestyle_image_ids" value="<?php echo esc_attr( $primary_image_id ? (string) $primary_image_id : '' ); ?>" />
			<div class="phtf-lifestyle-image-preview" style="margin-bottom:10px;">
				<?php if ( $primary_image_id ) : ?>
					<?php $image_url = wp_get_attachment_image_url( $primary_image_id, 'medium' ); ?>
					<?php if ( $image_url ) : ?>
						<span class="phtf-lifestyle-thumb" style="display:block;border:1px solid #dcdcde;background:#f6f7f7;padding:4px;">
							<img src="<?php echo esc_url( $image_url ); ?>" alt="" style="width:100%;height:auto;display:block;" />
						</span>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<p>
				<button type="button" class="button phtf-upload-lifestyle-image" data-title="<?php echo esc_attr__( 'Select Background / Lifestyle Image', 'perfect-hot-tub-finder' ); ?>" data-button="<?php echo esc_attr__( 'Use Background Image', 'perfect-hot-tub-finder' ); ?>" data-select="<?php echo esc_attr__( 'Set Background Image', 'perfect-hot-tub-finder' ); ?>" data-change="<?php echo esc_attr__( 'Replace Background Image', 'perfect-hot-tub-finder' ); ?>"><?php echo $primary_image_id ? esc_html__( 'Replace Background Image', 'perfect-hot-tub-finder' ) : esc_html__( 'Set Background Image', 'perfect-hot-tub-finder' ); ?></button>
			</p>
			<p>
				<button type="button" class="button-link-delete phtf-remove-lifestyle-image" style="<?php echo $primary_image_id ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Remove background image', 'perfect-hot-tub-finder' ); ?></button>
			</p>
			<p class="description" style="margin-top:8px;">
				<?php esc_html_e( 'Used as the Spa Shop Slider lifestyle/background image. This is easier than pasting the image URL field.', 'perfect-hot-tub-finder' ); ?>
			</p>
		</div>
		<?php
	}

	public function save_meta( $post_id ) {
		if ( ! isset( $_POST['phtf_spa_model_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['phtf_spa_model_nonce'] ) ), 'phtf_save_spa_model' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$input  = isset( $_POST['phtf_spa_model'] ) && is_array( $_POST['phtf_spa_model'] ) ? wp_unslash( $_POST['phtf_spa_model'] ) : [];
		$fields = phtf_spa_model_meta_fields();
		foreach ( $fields as $key => $field ) {
			if ( ! array_key_exists( $key, $input ) ) {
				if ( 'select_multiple' === $field['type'] || 'checkbox_multiple' === $field['type'] ) {
					update_post_meta( $post_id, '_phtf_' . $key, '' );
				}
				continue;
			}

			$value = $input[ $key ];
			$value = phtf_normalize_placeholder_meta_value( $value, $field );
			if ( 'select_multiple' === $field['type'] || 'checkbox_multiple' === $field['type'] ) {
				$allowed = isset( $field['options'] ) && is_array( $field['options'] ) ? array_keys( $field['options'] ) : [];
				$value   = is_array( $value ) ? $value : preg_split( '/[,|]+/', (string) $value );
				$value   = array_map( 'sanitize_text_field', (array) $value );
				$value   = array_values( array_intersect( array_unique( $value ), $allowed ) );
				$value   = implode( ',', $value );
			} elseif ( 'textarea' === $field['type'] ) {
				$value = sanitize_textarea_field( $value );
			} elseif ( 'url' === $field['type'] ) {
				$value = esc_url_raw( $value );
			} else {
				$value = sanitize_text_field( $value );
			}

			if ( 'spa_id' === $key ) {
				$value = preg_replace( '/[^A-Za-z0-9_-]/', '', (string) $value );
				if ( '' === $value || ( function_exists( 'phtf_spa_model_id_exists' ) && phtf_spa_model_id_exists( $value, $post_id ) ) ) {
					$value = function_exists( 'phtf_generate_unique_spa_model_id' ) ? phtf_generate_unique_spa_model_id( $post_id ) : (string) absint( $post_id );
				}
			}

			if ( 'compare_url' === $key && '' === trim( (string) $value ) ) {
				$spa_id = isset( $input['spa_id'] ) ? sanitize_text_field( wp_unslash( $input['spa_id'] ) ) : get_post_meta( $post_id, '_phtf_spa_id', true );
				$spa_id = preg_replace( '/[^A-Za-z0-9_-]/', '', (string) $spa_id );
				if ( '' === $spa_id ) {
					$spa_id = function_exists( 'phtf_generate_unique_spa_model_id' ) ? phtf_generate_unique_spa_model_id( $post_id ) : (string) absint( $post_id );
				}
				$value = function_exists( 'phtf_get_compare_url_for_spa_model' ) ? phtf_get_compare_url_for_spa_model( $spa_id ) : '';
			}

			update_post_meta( $post_id, '_phtf_' . $key, $value );
		}


		if ( taxonomy_exists( PHTF_SPA_CATEGORY_TAXONOMY ) ) {
			$term_ids = isset( $_POST['phtf_spa_category_terms'] ) && is_array( $_POST['phtf_spa_category_terms'] ) ? wp_unslash( $_POST['phtf_spa_category_terms'] ) : [];
			$term_ids = array_values( array_filter( array_map( 'absint', (array) $term_ids ) ) );
			wp_set_object_terms( $post_id, $term_ids, PHTF_SPA_CATEGORY_TAXONOMY, false );
		}

		if ( isset( $_POST['phtf_lifestyle_image_ids'] ) ) {
			$image_ids = sanitize_text_field( wp_unslash( $_POST['phtf_lifestyle_image_ids'] ) );
			$image_ids = preg_split( '/[,|]+/', (string) $image_ids );
			$image_ids = array_values( array_filter( array_map( 'absint', (array) $image_ids ) ) );

			if ( ! empty( $image_ids ) ) {
				$primary_image_id = $image_ids[0];
				update_post_meta( $post_id, '_phtf_lifestyle_image_ids', implode( ',', $image_ids ) );
				update_post_meta( $post_id, '_phtf_lifestyle_image_id', $primary_image_id );
				$image_url = wp_get_attachment_image_url( $primary_image_id, 'full' );
				if ( $image_url ) {
					update_post_meta( $post_id, '_phtf_lifestyle_image_url', esc_url_raw( $image_url ) );
				}
			} else {
				delete_post_meta( $post_id, '_phtf_lifestyle_image_ids' );
				delete_post_meta( $post_id, '_phtf_lifestyle_image_id' );
				delete_post_meta( $post_id, '_phtf_lifestyle_image_url' );
			}
		}
	}

	public function admin_columns( $columns ) {
		$new = [];
		foreach ( $columns as $key => $label ) {
			$new[ $key ] = $label;
			if ( 'title' === $key ) {
				$new['phtf_series'] = __( 'Spa Category', 'perfect-hot-tub-finder' );
				$new['phtf_price']  = __( 'MSRP', 'perfect-hot-tub-finder' );
				$new['phtf_seats']  = __( 'Seats', 'perfect-hot-tub-finder' );
			}
		}
		return $new;
	}

	public function admin_column_content( $column, $post_id ) {
		if ( 'phtf_series' === $column ) {
			$category_data = function_exists( 'phtf_get_spa_model_compare_category_data' ) ? phtf_get_spa_model_compare_category_data( $post_id ) : [ 'label' => get_post_meta( $post_id, '_phtf_compare_category', true ) ];
			echo esc_html( $category_data['label'] ?? '' );
		}
		if ( 'phtf_price' === $column ) {
			echo esc_html( get_post_meta( $post_id, '_phtf_price', true ) );
		}
		if ( 'phtf_seats' === $column ) {
			echo esc_html( get_post_meta( $post_id, '_phtf_seating_capacity', true ) );
		}
	}
}
