<?php

namespace PaidCommunities\HttpClient;

interface ClientInterface {

	public function request( $method, $path, $request );

	function getBaseUrl();
}