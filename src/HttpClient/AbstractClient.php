<?php

namespace PaidCommunities\HttpClient;

use PaidCommunities\Exception\AuthenticationException;
use PaidCommunities\Exception\BadRequestException;
use PaidCommunities\Exception\NotFoundException;
use PaidCommunities\Util\GeneralUtils;

class AbstractClient implements ClientInterface {

	const SANDBOX = 'sandbox';

	const PRODUCTION = 'production';

	const SANDBOX_URL = 'http://localhost:8080';

	const PRODUCTION_URL = 'https://api.paidcommunities.com';

	const GET = 'GET';

	const POST = 'POST';

	const PUT = 'PUT';

	const DELETE = 'DELETE';

	private $environment;

	public function __construct( $environment = self::PRODUCTION ) {
		$this->environment = $environment;
	}

	public function request( $method, $path ) {

	}

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
				throw new BadRequestException();
			case 401:
				throw new AuthenticationException();
				break;
			case 403:
				break;
			case 404:
				throw new NotFoundException();
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
}