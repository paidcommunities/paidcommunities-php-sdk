<?php

namespace PaidCommunities\WordPress\Admin;

use PaidCommunities\WordPress\Assets\AssetDataApi;
use PaidCommunities\WordPress\Assets\AssetsApi;
use PaidCommunities\WordPress\PluginConfig;

class LicenseSettings {

	private $config;

	private $assets;

	protected $callback;

	private $options;

	private $data;

	public function __construct( PluginConfig $config, AssetsApi $assets, $callback = null ) {
		$this->config   = $config;
		$this->assets   = $assets;
		$this->callback = $callback;
		$this->data     = new AssetDataApi();
	}

	public function render() {
		$license = $this->config->getLicense();
		$slug    = $this->config->getPluginSlug();

		wp_enqueue_script( 'paidcommunities-license' );
		wp_enqueue_style( 'paidcommunities-styles' );

		if ( $this->callback ) {
			$callback = $this->callback;
			call_user_func( $callback, $this );
		} else {
			include_once __DIR__ . '/Views/license.php';
		}
	}

}