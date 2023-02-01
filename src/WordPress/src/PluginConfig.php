<?php

namespace PaidCommunities\WordPress;

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

	/**
	 * @param string $slug    The name of the plugin
	 * @param string $version The current version of the plugin
	 */
	public function __construct( $slug, $version, $settings = null ) {
		$this->slug    = $slug;
		$this->version = $version;
		$this->initialize();
	}

	private function initialize() {
		//$this->settings  = $settings ?? new LicenseSettings( new AssetsApi( dirname( __DIR__ ), plugin_dir_url( __DIR__ ), $version ) );
		$dir                  = PREMIUM_PLUGIN_DIR . '/vendor/paidcommunities/paidcommunities-php/src/WordPress/src';
		$this->settings       = $settings ?? new LicenseSettings( $this, new AssetsApi( dirname( $dir ), plugin_dir_url( $dir ), $version ) );
		$this->ajaxController = AdminAjaxController( $this->slug );
		$this->client         = new WordPressClient( WordPressClient::SANDBOX );
	}

	public function getOptionPrefix() {
		return 'paidcommunities_';
	}

	public function getOptionName() {
		return $this->getOptionPrefix() . $this->slug . '_settings';
	}

	public function updateSettings( $data ) {
		\update_option( $this->getOptionName(), $data, true );
	}

	public function addSubmenu( $parent_slug, $title, $menu_title, $capability, $callback = '', $position = null ) {
		$callback = $callback ?: [ $this->settings, 'render' ];
		$slug     = "{$this->slug}_license";
		add_submenu_page( $parent_slug, $title, $menu_title, $capability, $slug, $callback, $position );
	}

	public function getPluginSlug() {
		return $this->slug;
	}

	public function getLicense() {
		if ( ! $this->license ) {
			$this->license = new License( $this->slug, $this->getOptionPrefix() );
			$this->license->read();
		}

		return $this->license;
	}

}