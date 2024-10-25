<?php

namespace PaidCommunities\WordPress\Admin;

use PaidCommunities\WordPress\PluginConfig;
use PaidCommunities\WordPress\WordPressUtils;

class LicenseSettings {

	private $config;

	protected $callback;

	public function __construct( PluginConfig $config ) {
		$this->config = $config;
	}

	public function render() {
		//wp_enqueue_script( 'paidcommunities-license' );
		//wp_enqueue_style( 'paidcommunities-styles' );

		$data = _wp_specialchars( wp_json_encode( $this->config->getPluginData() ), ENT_QUOTES, 'UTF-8', true );

		$this->config->getTemplates()->loadTemplate( 'license.php', [ 'data' => $data, 'license' => $this->config->getLicense() ] );
	}

}