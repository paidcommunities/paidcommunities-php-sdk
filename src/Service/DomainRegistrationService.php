<?php

namespace PaidCommunities\Service;

use PaidCommunities\Model\Domain;

class DomainRegistrationService extends AbstractService {

	protected $path = '/domains';

	/**
	 * @param $license
	 * @param $request
	 *
	 * @return Domain
	 */
	public function register( $request ) {
		return $this->post( $this->buildPath( '' ), $request, Domain::class );
	}
}