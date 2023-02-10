<?php

namespace PaidCommunities\Service;

use PaidCommunities\Model\Domain;

class DomainService extends AuthenticatedService {

	protected $path = '/domains/';

	public function delete( $id ) {
		return $this->request( 'delete', $this->buildPath( '/%s', $id ) );
	}
}