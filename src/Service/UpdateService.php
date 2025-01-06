<?php

namespace PaidCommunities\Service;

use PaidCommunities\Model\SoftwareUpdate;

class UpdateService extends AuthenticatedService {

	protected $path = '/update_check';

	/**
	 * @param $request
	 *
	 * @return mixed
	 */
	public function check( $request ) {
		return $this->post( $this->buildPath(), $request, SoftwareUpdate::class );
	}
}