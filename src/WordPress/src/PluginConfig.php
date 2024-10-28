<?php

namespace PaidCommunities\WordPress;

use PaidCommunities\HttpClient\AbstractClient;
use PaidCommunities\WordPress\Admin\AdminAjaxController;
use PaidCommunities\WordPress\Admin\AdminScripts;
use PaidCommunities\WordPress\Admin\LicenseSettings;
use PaidCommunities\WordPress\Admin\Templates;
use PaidCommunities\WordPress\Assets\AssetsApi;
use PaidCommunities\WordPress\HttpClient\WordPressClient;

class PluginConfig {

	private $plugin_file;

	private $slug;

	private $version;

	private $settings;

	private $license;

	private $ajaxController;

	private $updates;

	private $baseDir;

	private $environment;

	private $templates;

	/**
	 * @param string $slug The name of the plugin
	 * @param string $version The current version of the plugin
	 * @param array $overrides array of optional overrides to customize the default behavior.
	 */
	public function __construct( $plugin_file, $version, $overrides = [] ) {
		$this->plugin_file = $plugin_file;
		$this->slug        = dirname( $plugin_file );
		$this->version     = $version;
		$this->baseDir     = dirname( __DIR__ );
		$this->environment = AbstractClient::PRODUCTION;

		$overrides = array_merge(
			[
				'template_path' => __DIR__ . '/Admin/Views/'
			],
			$overrides
		);

		$this->templates = new Templates( $overrides['template_path'] );

		$this->initialize();
	}

	private function initialize() {
		$assets_api           = new AssetsApi( $this->baseDir, plugin_dir_url( __DIR__ ), $this->version );
		$this->settings       = new LicenseSettings( $this );
		$this->ajaxController = new AdminAjaxController( $this );
		$this->updates        = new UpdateController( $this );
		$this->updates->initialize();

		if ( is_admin() ) {
			( new AdminScripts( $this, $assets_api ) )->initialize();
		}
	}

	public function environment( $environment ) {
		if ( ! \in_array( $environment, [ AbstractClient::SANDBOX, AbstractClient::PRODUCTION ] ) ) {
			throw new \Exception( sprintf( 'Invalid environment value. Accepted values are %1$s or %2$s', AbstractClient::SANDBOX, AbstractClient::PRODUCTION ) );
		}
		$this->environment = $environment;

		return $this;
	}

	public function getEnvironment() {
		return $this->environment;
	}

	public function getClient() {
		return new WordPressClient( $this->environment );
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

	public function getPluginFile() {
		return $this->plugin_file;
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

	public function getPluginData() {
		return [
			'slug'                => $this->getPluginFile(),
			'formattedPluginFile' => WordPressUtils::formatPluginName( $this->getPluginFile() ),
			'nonce'               => WordPressUtils::createNonce( $this->getPluginFile() ),
			'license'             => [
				'status'      => $this->getLicense()->getStatus(),
				'domain'      => $this->getLicense()->getDomain(),
				'domain_id'   => $this->getLicense()->getDomainId(),
				'registered'  => $this->getLicense()->isRegistered(),
				'license_key' => $this->getLicense()->getLicenseKey()
			],
			'i18n'                => [
				'activateLicense'      => __( 'Activate License', 'paidcommunities' ),
				'deactivateLicense'    => __( 'Deactivate License', 'paidcommunities' ),
				'licenseKey'           => __( 'License Key', 'paidcommunities' ),
				'activateMsg'          => __( 'Activating...', 'paidcommunities' ),
				'deactivateMsg'        => __( 'Deactivating...', 'paidcommunities' ),
				'activation_error'     => __( 'Activation Error!', 'paidcommunities' ),
				'activation_success'   => __( 'Activation Success!', 'paidcommunities' ),
				'deactivation_success' => __( 'De-activation Success!', 'paidcommunities' ),
				'general_error'        => __( 'Activation Error!', 'paidcommunities' )
			]
		];
	}

	public function getTemplates() {
		return $this->templates;
	}

}