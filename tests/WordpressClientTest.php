<?php


use PaidCommunities\Exception\ApiErrorException;
use Paidcommunities\Model\SoftwareUpdate;
use PaidCommunities\WordPress\HttpClient\WordPressClient;
use PHPUnit\Framework\TestCase;

class WordpressClientTest extends TestCase {

	/**
	 * @codeCoverageIgnore
	 */
	public function testClient() {
		$client = new WordPressClient();
		try {
			$response = $client->post( '/v1/wordpress/update-check', [] );
		} catch ( ApiErrorException $e ) {
			$this->assertTrue( $e instanceof ApiErrorException );
		}
	}

	/**
	 * @codeCoverageIgnore
	 */
	public function testService() {
		$client = new WordPressClient();
		try {
			$response = $client->updates->check( [
				'license' => 'lic_Z1m2kTJiMnGBBXMXRZb40jVDLWj1DgfQ',
				'domain'  => 'example.com',
				'version' => '1.0.0'
			] );
			$this->assertTrue( $response instanceof SoftwareUpdate );
		} catch ( ApiErrorException $e ) {
			$this->fail( 'Software update service request failed. Error: ' . $e->getMessage() );
		}
	}
}