<?php

namespace PaidCommunities\WordPress\HttpClient;

use PaidCommunities\HttpClient\AbstractClient;

class WordPressClient extends AbstractClient {

	private $http;

	public function __construct( $environment = self::PRODUCTION ) {
		parent::__construct( $environment );
		$this->http = new \WP_Http();
	}

	public function request( $method, $path, $args = [] ) {
		return $this->handleResponse( $this->http->request( $this->buildUrl( $path ), [ 'method' => strtoupper( $method ) ] ) );
	}

	private function handleResponse( $response ) {
		$http_code = wp_remote_retrieve_response_code( $response );
		$this->handleStatusCode( $http_code );
		$body = wp_remote_retrieve_body( $response );
		if ( $body ) {
			$body = json_decode( $body, true );
		}
	}
}