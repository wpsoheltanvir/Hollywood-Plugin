<?php
/**
 * GitHub release updater for Perfect Hot Tub Finder.
 *
 * @package PerfectHotTubFinder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PHTF_GitHub_Updater {
	const TRANSIENT_KEY = 'phtf_github_latest_release';

	private $plugin_file;
	private $plugin_basename;
	private $slug;
	private $current_version;
	private $owner;
	private $repo;

	public function __construct( $plugin_file, $current_version, $owner, $repo ) {
		$this->plugin_file     = $plugin_file;
		$this->plugin_basename = plugin_basename( $plugin_file );
		$this->slug            = dirname( $this->plugin_basename );
		$this->current_version = $current_version;
		$this->owner           = $owner;
		$this->repo            = $repo;

		add_filter( 'pre_set_site_transient_update_plugins', [ $this, 'check_for_update' ] );
		add_filter( 'plugins_api', [ $this, 'plugin_info' ], 20, 3 );
		add_filter( 'http_request_args', [ $this, 'add_github_download_headers' ], 10, 2 );
	}

	public function check_for_update( $transient ) {
		if ( empty( $transient->checked ) || empty( $transient->checked[ $this->plugin_basename ] ) ) {
			return $transient;
		}

		$release = $this->get_latest_release();
		if ( ! $release || empty( $release['version'] ) || empty( $release['package'] ) ) {
			return $transient;
		}

		if ( version_compare( $release['version'], $this->current_version, '<=' ) ) {
			return $transient;
		}

		$transient->response[ $this->plugin_basename ] = (object) [
			'id'          => $this->plugin_basename,
			'slug'        => $this->slug,
			'plugin'      => $this->plugin_basename,
			'new_version' => $release['version'],
			'url'         => $release['html_url'],
			'package'     => $release['package'],
			'tested'      => get_bloginfo( 'version' ),
			'requires'    => '6.0',
			'requires_php'=> '7.4',
		];

		return $transient;
	}

	public function plugin_info( $result, $action, $args ) {
		if ( 'plugin_information' !== $action || empty( $args->slug ) || $this->slug !== $args->slug ) {
			return $result;
		}

		$release = $this->get_latest_release();
		if ( ! $release ) {
			return $result;
		}

		return (object) [
			'name'          => 'Perfect Hot Tub Finder',
			'slug'          => $this->slug,
			'version'       => $release['version'],
			'author'        => 'Attractional Marketing',
			'homepage'      => $release['html_url'],
			'download_link' => $release['package'],
			'requires'      => '6.0',
			'requires_php'  => '7.4',
			'tested'        => get_bloginfo( 'version' ),
			'sections'      => [
				'description' => 'Custom Elementor hot tub finder/shop slider.',
				'changelog'   => ! empty( $release['body'] ) ? wp_kses_post( wpautop( $release['body'] ) ) : 'See the GitHub release for update details.',
			],
		];
	}

	public function add_github_download_headers( $args, $url ) {
		if ( false === strpos( $url, 'api.github.com/repos/' . $this->owner . '/' . $this->repo ) ) {
			return $args;
		}

		if ( empty( $args['headers'] ) || ! is_array( $args['headers'] ) ) {
			$args['headers'] = [];
		}

		$args['headers']['User-Agent'] = 'Perfect-Hot-Tub-Finder-Updater';

		if ( false !== strpos( $url, '/releases/assets/' ) ) {
			$args['headers']['Accept'] = 'application/octet-stream';
		} else {
			$args['headers']['Accept'] = 'application/vnd.github+json';
		}

		$token = $this->get_token();
		if ( $token ) {
			$args['headers']['Authorization'] = 'Bearer ' . $token;
		}

		return $args;
	}

	private function get_latest_release() {
		$cached = get_site_transient( self::TRANSIENT_KEY );
		if ( is_array( $cached ) ) {
			return $cached;
		}

		$url      = sprintf( 'https://api.github.com/repos/%s/%s/releases/latest', rawurlencode( $this->owner ), rawurlencode( $this->repo ) );
		$response = wp_remote_get(
			$url,
			[
				'timeout' => 12,
				'headers' => $this->get_api_headers(),
			]
		);

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return false;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( empty( $data['tag_name'] ) || empty( $data['assets'] ) || ! is_array( $data['assets'] ) ) {
			return false;
		}

		$asset = $this->find_release_asset( $data['assets'] );
		if ( ! $asset ) {
			return false;
		}

		$release = [
			'version'  => $this->version_from_tag( $data['tag_name'] ),
			'html_url' => ! empty( $data['html_url'] ) ? esc_url_raw( $data['html_url'] ) : sprintf( 'https://github.com/%s/%s/releases', $this->owner, $this->repo ),
			'package'  => ! empty( $asset['url'] ) ? esc_url_raw( $asset['url'] ) : '',
			'body'     => ! empty( $data['body'] ) ? (string) $data['body'] : '',
		];

		set_site_transient( self::TRANSIENT_KEY, $release, 6 * HOUR_IN_SECONDS );

		return $release;
	}

	private function find_release_asset( $assets ) {
		$fallback = null;

		foreach ( $assets as $asset ) {
			if ( empty( $asset['name'] ) || empty( $asset['url'] ) ) {
				continue;
			}

			$name = strtolower( $asset['name'] );
			if ( false === strpos( $name, '.zip' ) || false === strpos( $name, 'perfect-hot-tub-finder' ) ) {
				continue;
			}

			if ( false !== strpos( $name, 'install' ) ) {
				return $asset;
			}

			$fallback = $asset;
		}

		return $fallback;
	}

	private function version_from_tag( $tag ) {
		if ( preg_match( '/(\d+\.\d+(?:\.\d+)?)/', (string) $tag, $matches ) ) {
			return $matches[1];
		}

		return ltrim( (string) $tag, 'vV' );
	}

	private function get_api_headers() {
		$headers = [
			'Accept'     => 'application/vnd.github+json',
			'User-Agent' => 'Perfect-Hot-Tub-Finder-Updater',
		];

		$token = $this->get_token();
		if ( $token ) {
			$headers['Authorization'] = 'Bearer ' . $token;
		}

		return $headers;
	}

	private function get_token() {
		$token = defined( 'PHTF_GITHUB_TOKEN' ) ? PHTF_GITHUB_TOKEN : '';

		if ( ! $token ) {
			$token = getenv( 'PHTF_GITHUB_TOKEN' );
		}

		return trim( (string) apply_filters( 'phtf_github_token', $token ) );
	}
}
