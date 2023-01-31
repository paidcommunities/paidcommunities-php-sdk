<?php

namespace PaidCommunities\HttpClient;

use PaidCommunities\Exception\AuthenticationException;
use PaidCommunities\Exception\BadRequestException;
use PaidCommunities\Exception\NotFoundException;
use PaidCommunities\Util\GeneralUtils;

abstract class AbstractClient implements ClientInterface {

	const SANDBOX = 'sandbox';

	const PRODUCTION = 'production';

	const SANDBOX_URL = 'http://localhost:8080';

	const PRODUCTION_URL = 'https://api.paidcommunities.com';

	const GET = 'GET';

	const POST = 'POST';

	const PUT = 'PUT';

	const DELETE = 'DELETE';

	private $environment;

	protected $serviceFactory;

	public function __construct( $environment = self::PRODUCTION ) {
		$this->environment = $environment;
	}

	abstract function request( $method, $path, $request );

	public function get( $path ) {
		return $this->request( 'get', $path );
	}

	public function post( $path, $args = [] ) {
		return $this->request( 'post', $path, $args );
	}

	public function put( $path, $args = [] ) {
		return $this->request( 'put', $path, $args );
	}

	public function delete( $path ) {
		return $this->request( 'delete', $path );
	}

	protected function handleStatusCode( $code, $body ) {
		switch ( $code ) {
			case 400:
				throw BadRequestException::factory( $code, $body );
			case 401:
				throw AuthenticationException::factory( $code, $body );
			case 403:
				break;
			case 404:
				throw NotFoundException::factory( $code, $body );
			case 405:
				break;
		}
	}

	function getBaseUrl() {
		switch ( $this->environment ) {
			case self::PRODUCTION:
				return self::PRODUCTION_URL;
			case self::SANDBOX:
				return self::SANDBOX_URL;
		}
	}

	protected function buildUrl( $path ) {
		return $this->getBaseUrl() . '/' . GeneralUtils::trimPath( $path );
	}

	public function prepareRequest( $body = null ) {
		$args    = [];
		$headers = [
			'Content-Type' => 'application/json'
		];
		if ( $body && $headers['Content-Type'] === 'application/json' ) {
			$body = json_encode( $body );
		}

		return [ $headers, $body ];
	}
}