<?php

namespace PaidCommunities\WordPress\Admin;

use PaidCommunities\WordPress\Assets\AssetDataApi;
use PaidCommunities\WordPress\Assets\AssetsApi;
use PaidCommunities\WordPress\PluginConfig;
use PaidCommunities\WordPress\WordPressUtils;

class AdminScripts {

	private $config;

	private $assets;

	private $data;

	public function __construct( PluginConfig $config, AssetsApi $assets ) {
		$this->config = $config;
		$this->assets = $assets;
		$this->data   = new AssetDataApi();
	}

	public function initialize() {
		add_action( 'admin_init', [ $this, 'register_scripts' ] );
	}

	public function register_scripts() {
		$this->assets->register_script( 'paidcommunities-license', 'build/license-settings.js' );
		$this->assets->register_script( 'paidcommunities-wordpress-api', 'build/paidcommunities-api.js' );
		$this->assets->register_script( 'paidcommunities-wp-components', 'build/react-components.js' );
		$this->assets->register_style( 'paidcommunities-styles', 'build/styles.css' );

		$this->add_data();
		$this->data->add_inline_script( 'paidcommunitiesLicenseParams', 'paidcommunities-wordpress-api' );
	}

	private function add_data() {
		$this->data->add( 'name', $this->config->getPluginFile() );
		$this->data->add( 'formattedPluginFile', WordPressUtils::formatPluginName( $this->config->getPluginFile() ) );
		$this->data->add( 'nonce', WordPressUtils::createNonce( $this->config->getPluginFile() ) );
		$this->data->add( 'license', [
			'domain'      => $this->config->getLicense()->getDomain(),
			'domain_id'   => $this->config->getLicense()->getDomainId(),
			'registered'  => $this->config->getLicense()->isRegistered(),
			'license_key' => $this->config->getLicense()->getLicenseKey()
		] );
		$this->data->add( 'i18n', [
			'activateLicense'      => __( 'Activate License', 'paidcommunities' ),
			'deactivateLicense'    => __( 'Deactivate License', 'paidcommunities' ),
			'licenseKey'           => __( 'License Key', 'paidcommunities' ),
			'activateMsg'          => __( 'Activating...', 'paidcommunities' ),
			'deactivateMsg'        => __( 'Deactivating...', 'paidcommunities' ),
			'activation_error'     => __( 'Activation Error!', 'paidcommunities' ),
			'activation_success'   => __( 'Activation Success!', 'paidcommunities' ),
			'deactivation_success' => __( 'De-activation Success!', 'paidcommunities' ),
		] );
	}

}