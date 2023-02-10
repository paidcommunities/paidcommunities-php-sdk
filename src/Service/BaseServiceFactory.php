<?php

namespace PaidCommunities\Service;

class BaseServiceFactory extends AbstractServiceFactory {

	protected $mappings = [
		'updates'            => UpdateService::class,
		'domains'            => DomainService::class,
		'domainRegistration' => DomainRegistrationService::class
	];

	public function __get( $name ) {
		if ( ! isset( $this->mappings[ $name ] ) ) {
			throw new \Exception( sprintf( 'Service %s has not been declared in the class mappings', $name ) );
		}

		return $this->getService( $name, $this->mappings[ $name ] );
	}
}