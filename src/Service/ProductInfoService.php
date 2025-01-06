<?php

namespace PaidCommunities\Service;

class ProductInfoService extends AuthenticatedService {

	protected $path = '/plugin_info';

	/**
	 * @param $request
	 *
	 * @return mixed
	 * @throws \PaidCommunities\Exception\ApiErrorException
	 */
	public function get( $request ) {
		return $this->request( 'get', $this->buildPath(), $request, \stdClass::class );
	}
}