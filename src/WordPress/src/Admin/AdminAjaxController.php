<?php

namespace PaidCommunities\WordPress\Admin;

use PaidCommunities\Util\GeneralUtils;
use PaidCommunities\WordPress\Html\Notice;
use PaidCommunities\WordPress\HttpClient\WordPressClient;
use PaidCommunities\WordPress\License;
use PaidCommunities\WordPress\PluginConfig;

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
		$license   = $this->config->getLicense();
		$client    = new WordPressClient( $this->config->getEnvironment() );
		$licenseKy = $_POST['license_key'] ?? '';
		$domain    = $_SERVER['SERVER_NAME'] ?? '';
		try {
			$this->verify_admin_nonce();

			if ( ! current_user_can( 'administrator' ) ) {
				throw new \Exception( __( 'Administrator access is required to perform this action.', 'paidcommunities' ), 403 );
			}
			if ( ! $licenseKy ) {
				throw new \Exception( __( 'Please provide a license key', 'paidcommunities' ) );
			}
			if ( ! $domain ) {
				$domain = $_SERVER['HTTP_HOST'];
			}
			$domain = $client->domainRegistration->register( [
				'license' => $licenseKy,
				'domain'  => $domain,
				'version' => $this->config->getVersion()
			] );

			$license->setLicenseKey( GeneralUtils::redactString( $licenseKy, 8 ) );
			$license->setStatus( License::ACTIVE );
			$license->setSecret( $domain->secret );
			$license->setDomain( $domain->domain );
			$license->setDomainId( $domain->id );
			$license->setCreatedAt( $domain->createdAt );
			$license->save();

			ob_start();
			$this->config->getLicenseSettings()->render();
			$html = ob_get_clean();

			$this->send_ajax_success_response( [
				'license' => $license->toArray(),
				'notice'  => [
					'code'    => 'activation_success',
					'message' => __( 'Your site has been activated.', 'paidcommunities' )
				],
				'html'    => $html,
				'license' => [
					'domain'      => $license->getDomain(),
					'domain_id'   => $license->getDomainId(),
					'registered'  => $license->isRegistered(),
					'license_key' => $license->getLicenseKey()
				]
			] );
		} catch ( \Exception $e ) {
			$this->send_ajax_error_response( $e );
		}
	}

	public function handleLicenseDeactivate() {
		$license = $this->config->getLicense();
		$client  = new WordPressClient( 'sandbox' );
		try {
			$this->verify_admin_nonce();

			if ( ! current_user_can( 'administrator' ) ) {
				throw new \Exception( __( 'Administrator access is required to perform this action.', 'paidcommunities' ), 403 );
			}

			$id = $license->getDomainId();

			if ( ! $id ) {
				throw new \Exception( __( 'Domain ID cannot be empty. Are you sure you have a registered domain?', 'paidcommunities' ) );
			}
			$client->setSecret( $license->getSecret() );

			$client->domains->delete( $id );

			$license->delete();

			ob_start();
			$this->config->getLicenseSettings()->render();
			$html = ob_get_clean();

			$this->send_ajax_success_response( [
				'notice'  => [
					'code'    => 'deactivation_success',
					'message' => esc_html__( 'Your site has been deactivated.', 'paidcommunities' ),
				],
				'html'    => $html,
				'license' => [
					'domain'      => $license->getDomain(),
					'domain_id'   => $license->getDomainId(),
					'registered'  => $license->isRegistered(),
					'license_key' => $license->getLicenseKey()
				]
			] );
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
				'code'    => 'activation_error',
				'message' => esc_html( $e->getMessage() )
			]
		] );
	}

	private function verify_admin_nonce() {
		$nonce = isset( $_REQUEST['nonce'] ) ? $_REQUEST['nonce'] : false;
		if ( ! $nonce ) {
			throw new \Exception( __( 'Requests require a nonce parameter.', 'paidcommunities' ) );
		}
		$result = \wp_verify_nonce( $nonce, "{$this->config->getPluginSlug()}-action" );
		if ( ! $result ) {
			throw new \Exception( __( 'Unauthorized request.', 'paidcommunities' ), 403 );
		}
	}

}