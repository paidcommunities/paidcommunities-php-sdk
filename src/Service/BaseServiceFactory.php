<?php

namespace PaidCommunities\Service;

class BaseServiceFactory extends AbstractServiceFactory {

	protected $mappings = [
		'updates' => UpdateService::class
	];

	public function __get( $name ) {
		if ( ! isset( $this->mappings[ $name ] ) ) {
			throw new \Exception( sprintf( 'Service %s has not been declares in the class mappings', $name ) );
		}

		return $this->getService( $name, $this->mappings[ $name ] );
	}
}