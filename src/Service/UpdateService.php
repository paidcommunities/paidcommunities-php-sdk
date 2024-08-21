<?php

namespace PaidCommunities\Service;

use PaidCommunities\Model\SoftwareUpdate;

class UpdateService extends AuthenticatedService {

	protected $path = '/update_check';

	/**
	 * @param $request
	 *
	 * @return SoftwareUpdate
	 */
	public function check( $request ) {
		return $this->post( $this->buildPath(), $request, SoftwareUpdate::class );
	}
}