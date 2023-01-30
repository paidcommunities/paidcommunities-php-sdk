<?php

namespace PaidCommunities\Service;

class AbstractServiceFactory implements ServiceFactoryInterface {

	private $services = [];

	private $client;

	public function __construct( ClientInterface $client ) {
		$this->client = $client;
	}

	function getService( $name, $clazz ) {
		if ( ! isset( $this->services[ $name ] ) ) {
			$this->services[ $name ] = new $clazz( $this->client );
		}

		return $this->services[ $name ];
	}

}