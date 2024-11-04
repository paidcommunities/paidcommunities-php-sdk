<?php

namespace PaidCommunities\WordPress\Admin;

use PaidCommunities\WordPress\Assets\AssetDataApi;
use PaidCommunities\WordPress\Assets\AssetDataRegistry;
use PaidCommunities\WordPress\Assets\AssetsApi;
use PaidCommunities\WordPress\PluginConfig;
use PaidCommunities\WordPress\WordPressUtils;

class AdminScripts {

	private $config;

	private $assets;

	private $asset_data;

	public function __construct( PluginConfig $config, AssetsApi $assets ) {
		$this->config     = $config;
		$this->assets     = $assets;
		$this->asset_data = new AssetDataApi( $config->getPluginFile() );
	}

	public function initialize() {
		if ( did_action( 'admin_init' ) ) {
			$this->register_scripts();
		} else {
			add_action( 'admin_init', [ $this, 'register_scripts' ] );
		}
	}

	public function register_scripts() {
		$this->assets->register_script( 'paidcommunities-license', 'build/license-settings.js' );
		$this->assets->register_script( 'paidcommunities-wp-api', 'build/api.js' );
		$this->assets->register_script( 'paidcommunities-admin-license', 'build/admin-license.js' );
		$this->assets->register_script( 'paidcommunities-wp-components', 'build/components.js' );
		$this->assets->register_style( 'paidcommunities-wp-components', 'build/styles.css' );
	}

	public function getAssetData() {
		return $this->asset_data;
	}

}