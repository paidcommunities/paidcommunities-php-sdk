<?php

namespace PaidCommunities\WordPress;

use PaidCommunities\WordPress\Admin\LicenseSettings;
use PaidCommunities\WordPress\Assets\AssetsApi;

class PluginConfig {

	private $slug;

	private $version;

	private $settings;

	private static $_instance;

	public function instance() {
		return self::$_instance;
	}

	/**
	 * @param string $slug    The name of the plugin
	 * @param string $version The current version of the plugin
	 */
	public function __construct( $slug, $version, $settings = null ) {
		$this->slug      = $slug;
		$this->version   = $version;
		$this->settings  = $settings ?? new LicenseSettings( new AssetsApi( __DIR__ ) );
		self::$_instance = $this;
	}

	public function getOptionPrefix() {
		return 'paidcommunities_';
	}

	public function getOptionName() {
		return $this->getOptionPrefix() . $this->slug . '_settings';
	}

	public function updateSettings() {
		\update_option( $this->getOptionName(), [], true );
	}

	public function addSubmenu( $parent_slug, $title, $menu_title, $capability, $callback = '', $position = null ) {
		$callback = $callback ?: [ $this->settings, 'render' ];
		$slug     = "{$this->slug}_license";
		add_submenu_page( $parent_slug, $title, $menu_title, $capability, $slug, $callback, $position );
	}

}