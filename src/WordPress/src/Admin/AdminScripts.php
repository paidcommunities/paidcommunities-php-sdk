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
		AssetDataRegistry::instance()->register( $this->asset_data );
	}

	public function initialize() {
		add_action( 'admin_init', [ $this, 'register_scripts' ] );
	}

	public function register_scripts() {
		$this->assets->register_script( 'paidcommunities-license', 'build/license-settings.js' );
		$this->assets->register_script( 'paidcommunities-wp', 'build/paidcommunities-wp.js' );
		$this->assets->register_style( 'paidcommunities-wp', 'build/styles.css' );

		$this->asset_data->add( $this->config->getPluginData() );
	}

}