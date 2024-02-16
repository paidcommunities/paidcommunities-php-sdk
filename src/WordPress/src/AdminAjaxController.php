<?php

namespace PaidCommunities\WordPress;

use PaidCommunities\Util\GeneralUtils;
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
		check_admin_referer( "{$this->config->getPluginSlug()}-nonce", 'nonce' );
		// use the license key to activate the domain
		$license   = $this->config->getLicense();
		$client    = new WordPressClient( 'sandbox' );
		$licenseId = $_POST['license'] ?? '';
		$domain    = $_SERVER['SERVER_NAME'] ?? '';
		try {
			if ( ! $licenseId ) {
				throw new \Exception( __( 'Please provide a license key', 'paidcommunities' ) );
			}
			if ( ! $domain ) {
				$domain = $_SERVER['HTTP_HOST'];
			}
			$domain = $client->domainRegistration->register( [
				'license' => $licenseId,
				'domain'  => $domain,
				'version' => $this->config->getVersion()
			] );

			$license->setLicenseKey( GeneralUtils::redactString( $licenseId, 8 ) );
			$license->setStatus( License::ACTIVE );
			$license->setSecret( $domain->secret );
			$license->setDomain( $domain->domain );
			$license->setDomainId( $domain->id );
			$license->setCreatedAt( $domain->createdAt );
			$license->save();
			$this->send_ajax_success_response( [
				'license' => $license->toArray(),
				'message' => Notice::renderSuccess( 'Your site has been activated.' )
			] );
		} catch ( \Exception $e ) {
			$this->send_ajax_error_response( $e );
		}
	}

	public function handleLicenseDeactivate() {
		check_admin_referer( "{$this->config->getPluginSlug()}-nonce", 'nonce' );
		$license = $this->config->getLicense();
		$client  = new WordPressClient( 'sandbox' );
		try {
			$id = $license->getDomainId();

			if ( ! $id ) {
				throw new \Exception( __( 'Domain ID cannot be empty. Are you sure you have a registered domain?', 'paidcommunities' ) );
			}
			$client->setSecret( $license->getSecret() );

			$client->domains->delete( $id );

			$license->delete();

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