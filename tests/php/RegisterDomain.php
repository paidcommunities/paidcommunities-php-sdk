<?php

namespace php;

use PaidCommunities\WordPress\HttpClient\WordPressClient;
use PHPUnit\Framework\TestCase;

class RegisterDomain extends TestCase {

	public function testRegisterDomain() {
		$license = $_ENV['LICENSE'];
		$client  = new WordPressClient( WordPressClient::SANDBOX );
		try {
			$response = $client->domains->create( $license, [ 'domain' => 'test4.example.com' ] );
			$this->assertIsString( $response->id, sprintf( 'Domain ID: %s', $response->id ) );

			$response = $client->domains->delete( $license, $response->id );
			$this->assertIsString( $response->id, sprintf( 'Domain %s deleted.', $response->id ) );
		} catch ( \Exception $e ) {
			$this->fail( 'Domain registration failed. Reason: ' . $e->getMessage() );
		}
	}
}