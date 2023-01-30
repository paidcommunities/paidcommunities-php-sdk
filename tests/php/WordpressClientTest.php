<?php

namespace php;

use PaidCommunities\WordPress\HttpClient\WordPressClient;
use PHPUnit\Framework\TestCase;

class WordpressClientTest extends TestCase {

	public function testClient() {
		$client   = new WordPressClient( WordPressClient::SANDBOX );
		$response = $client->post( '/v1/wordpress/update-check', [] );
		if ( $response ) {

		}
	}
}