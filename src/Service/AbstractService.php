<?php

namespace PaidCommunities\Service;

use PaidCommunities\HttpClient\ClientInterface;
use PaidCommunities\Model\ModelFactoryInterface;
use PaidCommunities\Util\GeneralUtils;

/**
 *
 */
class AbstractService implements ServiceInterface {

	protected $client;

	private $models;

	protected $path = '';

	public function __construct( ClientInterface $client, ModelFactoryInterface $models ) {
		$this->client = $client;
		$this->models = $models;
	}

	public function request( $method, $path, $request = [], $model = null, $opts = [] ) {
		$response = $this->client->request( $method, $path, $request, $opts );
		if ( $response ) {
			return $this->models->buildModel( $model, $response );
		}

		return $response;
	}

	public function retrieve( $id ) {
		return $this->request( 'get', $this->buildPath( '' ) );
	}

	public function post( $path, $request, $model = null ) {
		return $this->request( 'post', $path, $request, $model );
	}

	public function get( $path, $request = [], $model = null ) {
		return $this->request( 'get', $path, $request, $model );
	}

	public function put( $path, $request, $model = null ) {
		return $this->request( 'put', $path, $request, $model );
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