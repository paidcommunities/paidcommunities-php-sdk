<?php

namespace PaidCommunities\Service;

class UpdateService extends AbstractService {

	protected $path = '/update/check';

	public function check( $request ) {
		return $this->post( $this->buildPath(), $request );
	}
}