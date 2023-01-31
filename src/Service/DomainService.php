<?php

namespace PaidCommunities\Service;

use PaidCommunities\Model\Domain;

class DomainService extends AbstractService {

	protected $path = '/licenses';

	/**
	 * @param $license
	 * @param $request
	 *
	 * @return Domain
	 */
	public function create( $license, $request ) {
		return $this->post( $this->buildPath( '/%s/domains', $license ), $request, Domain::class );
	}

	public function delete( $license, $id ) {
		return $this->request( 'delete', $this->buildPath( '/%s/domains/%s', $license, $id ) );
	}
}