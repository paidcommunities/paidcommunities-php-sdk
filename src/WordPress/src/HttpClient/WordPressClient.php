<?php

namespace PaidCommunities\WordPress\HttpClient;

use PaidCommunities\Exception\BadRequestException;
use PaidCommunities\HttpClient\AbstractClient;
use PaidCommunities\Model\BaseModelFactory;
use PaidCommunities\Service\BaseServiceFactory;
use PaidCommunities\Service\DomainRegistrationService;
use PaidCommunities\Service\DomainService;
use PaidCommunities\Service\LicenseService;
use PaidCommunities\Service\UpdateService;

/**
 * @property UpdateService $updates
 * @property DomainService $domains
 * @property DomainRegistrationService $domainRegistration
 */
class WordPressClient extends AbstractClient {

	const REQUEST_URI = '/wordpress/v1';

	private $http;

	public function __construct( $environment = self::PRODUCTION, $secret = null ) {
		parent::__construct( $environment, $secret );
		$this->http = new \WP_Http();
	}

	public function __get( $name ) {
		if ( ! $this->serviceFactory ) {
			$this->serviceFactory = new BaseServiceFactory( $this, new BaseModelFactory() );
		}

		return $this->serviceFactory->{$name};
	}

	public function getBaseUrl() {
		return parent::getBaseUrl() . self::REQUEST_URI;
	}

	public function request( $method, $path, $body = [], $opts = [] ) {
		list( $headers, $body ) = $this->prepareRequest( $body );
		if ( isset( $opts['headers'] ) ) {
			$headers = array_merge( $headers, $opts['headers'] );
		}
		$args = [ 'method' => strtoupper( $method ), 'headers' => $headers, 'timeout' => 30 ];
		if ( $method !== 'get' && $body ) {
			$args = wp_parse_args( [ 'body' => $body ], $args );
		}

		return $this->handleResponse( $this->http->request( $this->buildUrl( $path ), $args ) );
	}

	private function handleResponse( $response ) {
		if ( \is_wp_error( $response ) ) {
			throw BadRequestException::factory( 400, [ 'error' => [ 'message' => $response->get_error_message() ] ] );
		}
		$httpStatus = wp_remote_retrieve_response_code( $response );
		$body       = json_decode( wp_remote_retrieve_body( $response ), true );
		$this->handleStatusCode( $httpStatus, $body );

		return $body;
	}
}