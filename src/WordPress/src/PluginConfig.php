<?php

namespace PaidCommunities\WordPress;

use PaidCommunities\WordPress\Admin\AdminScripts;
use PaidCommunities\WordPress\Admin\LicenseSettings;
use PaidCommunities\WordPress\Assets\AssetsApi;
use PaidCommunities\WordPress\HttpClient\WordPressClient;

class PluginConfig {

	private $slug;

	private $version;

	private $settings;

	private $license;

	private $ajaxController;

	private $client;

	private $updates;

	private $baseDir;

	/**
	 * @param string $slug    The name of the plugin
	 * @param string $version The current version of the plugin
	 */
	public function __construct( $slug, $version ) {
		$this->slug    = $slug;
		$this->version = $version;
		$this->baseDir = dirname( __DIR__ );
		$this->initialize();
	}

	private function initialize() {
		$assets_api           = new AssetsApi( $this->baseDir, plugin_dir_url( __DIR__ ), $this->version );
		$this->settings       = new LicenseSettings( $this, $assets_api );
		$this->ajaxController = new \PaidCommunities\WordPress\Admin\AdminAjaxController( $this );
		$this->client         = new WordPressClient();
		$this->updates        = new UpdateController( $this, $this->client );
		$this->updates->initialize();

		if ( is_admin() ) {
			( new AdminScripts( $this, $assets_api ) )->initialize();
		}
	}

	public function getVersion() {
		return $this->version;
	}

	public function getOptionPrefix() {
		return 'paidcommunities_';
	}

	public function getOptionName() {
		return $this->getOptionPrefix() . $this->slug . '_settings';
	}

	/**
	 * @return LicenseSettings
	 */
	public function getLicenseSettings() {
		return $this->settings;
	}

	/**
	 * @return UpdateController
	 */
	public function getUpdateController() {
		return $this->updates;
	}

	public function getPluginSlug() {
		return $this->slug;
	}

	/**
	 * @return \PaidCommunities\WordPress\License
	 */
	public function getLicense() {
		if ( ! $this->license ) {
			$this->license = new License( $this->slug, $this->getOptionPrefix() );
			$this->license->read();
		}

		return $this->license;
	}

}