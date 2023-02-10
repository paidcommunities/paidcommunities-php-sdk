<?php

namespace PaidCommunities\Service;

use PaidCommunities\Model\Domain;

class DomainRegistrationService extends AbstractService {

	protected $path = '/licenses';

	/**
	 * @param $license
	 * @param $request
	 *
	 * @return Domain
	 */
	public function register( $license, $request,){
		return $this->post( $this->buildPath( '/%s/domains', $license ), $request, Domain::class );
	}
}