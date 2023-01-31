<?php

namespace PaidCommunities\Service;

use PaidCommunities\Model\SoftwareUpdate;

class UpdateService extends AbstractService {

	protected $path = '/update-check';

	public function check( $request ) {
		return $this->post( $this->buildPath(), $request, SoftwareUpdate::class );
	}
}