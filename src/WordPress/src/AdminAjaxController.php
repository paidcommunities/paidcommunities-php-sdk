<?php

namespace PaidCommunities\WordPress;

use PaidCommunities\WordPress\Html\Notice;
use PaidCommunities\WordPress\HttpClient\WordPressClient;

class AdminAjaxController {

	private $name;

	private $config;

	private $actions = [
		'activate'   => 'activate_',
		'deactivate' => 'deactivate_'
	];

	public function __construct( PluginConfig $config ) {
		$this->name   = $config->getPluginSlug();
		$this->config = $config;
		$this->initialize();
	}

	private function initialize() {
		add_action( 'wp_ajax_' . $this->getActions()->activate . $this->name, [ $this, 'handleLicenseActivate' ] );
		add_action( 'wp_ajax_' . $this->getActions()->deactivate . $this->name, [ $this, 'handleLicenseDeactivate' ] );
	}

	private function getActions() {
		return (object) $this->actions;
	}

	public function handleLicenseActivate() {
		// use the license key to activate the domain
		$license = $this->config->getLicense();
		$client  = new WordPressClient( WordPressClient::SANDBOX );
		//$licenseKey = $_POST[ $this->name . '_license_key' ] ?? '';
		$licenseKey = $_POST['license'] ?? '';
		$domain     = $_SERVER['SERVER_NAME'] ?? '';
		try {
			if ( ! $licenseKey ) {
				throw new \Exception( 'Please provide a license key' );
			}
			if ( ! $domain ) {
				$domain = $_SERVER['HTTP_HOST'];
			}
			$domain = $client->domains->create( $licenseKey, [
				'domain' => $domain
			] );
			$license->setKey( $licenseKey );
			$license->setStatus( License::ACTIVE );
			$license->setDomain( $domain->domain );
			$license->setDomainId( $domain->id );
			$license->save();
			$this->send_ajax_success_response( [ 'license' => $license->toArray(), 'message' => Notice::renderSuccess( 'Your site has been activated.' ) ] );
		} catch ( \Exception $e ) {
			$this->send_ajax_error_response( $e );
		}
	}

	public function handleLicenseDeactivate() {
		$license = $this->config->getLicense();
		$client  = new WordPressClient( WordPressClient::SANDBOX );
		try {
			$id       = $license->getKey();
			$response = $client->domains->delete( $id, $license->getDomainId() );
			$license->setKey( '' );
			$license->setDomain( '' );
			$license->setDomainId( '' );
			$license->setStatus( License::INACTIVE );
			$license->save();

			$this->send_ajax_success_response( [ 'message' => Notice::renderSuccess( 'Your site has been deactivated.' ) ] );
		} catch ( \Exception $e ) {
			$this->send_ajax_error_response( $e );
		}
	}

	private function send_ajax_success_response( $data ) {
		\wp_send_json( [
			'success' => true,
			'data'    => $data
		] );
	}

	private function send_ajax_error_response( $e ) {
		\wp_send_json( [
			'success' => false,
			'error'   => [
				'message' => Notice::renderError( $e->getMessage() )
			]
		] );
	}

}