<?php

namespace PaidCommunities\Service;

use PaidCommunities\Util\GeneralUtils;

/**
 *
 */
class AbstractService implements ServiceInterface {

	private $client;

	protected $path = '';

	public function __construct( ClientInterface $client ) {
		$this->client = $client;
	}

	public function request( $method, $path, $request = [] ) {
		return $this->client->request( $method, $this->buildPath( $path, $request ) );
	}

	public function retrieve( $id ) {
		return $this->request( 'get', $this->buildPath( '' ) );
	}

	public function post( $path, $request ) {
		return $this->request( 'post', $path, $request );
	}

	protected function buildPath( $path = '', ...$args ) {
		if ( $path ) {
			$path = '/' . GeneralUtils::trimPath( $path );
		}
		if ( $this->path ) {
			$path = '/' . GeneralUtils::trimPath( $this->path ) . $path;
		}

		return sprintf( $path, ...array_map( '\urlencode', $args ) );
	}
}