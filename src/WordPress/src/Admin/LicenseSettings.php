<?php

namespace PaidCommunities\WordPress\Admin;

use PaidCommunities\WordPress\Assets\AssetDataApi;
use PaidCommunities\WordPress\Assets\AssetsApi;
use PaidCommunities\WordPress\PluginConfig;
use PaidCommunities\WordPress\WordPressUtils;

class LicenseSettings {

	private $config;

	protected $callback;

	public function __construct( PluginConfig $config, $callback = null ) {
		$this->config   = $config;
		$this->callback = $callback;
	}

	public function render() {
		$license     = $this->config->getLicense();
		$plugin_name = WordPressUtils::formatPluginName( $this->config->getPluginFile() );

		wp_enqueue_script( 'paidcommunities-license' );
		wp_enqueue_style( 'paidcommunities-styles' );

		$json_data = _wp_specialchars( wp_json_encode( $this->config->getPluginData() ), ENT_QUOTES, 'UTF-8', true );

		if ( $this->callback ) {
			$callback = $this->callback;
			call_user_func( $callback, $this );
		} else {
			include_once __DIR__ . '/Views/license.php';
		}
	}

}