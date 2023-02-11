<?php

namespace php;

use PaidCommunities\WordPress\HttpClient\WordPressClient;
use PHPUnit\Framework\TestCase;

class RegisterDomain extends TestCase {

	public function testRegisterDomain() {
		$license = $_ENV['LICENSE'];
		$client  = new WordPressClient();
		try {
			$response = $client->domainRegistration->register( $license, [ 'domain' => 'test.example.com' ] );

			$this->assertIsString( $response->id, sprintf( 'Domain ID: %s', $response->id ) );

			$client->setSecret( $response->secret );

			$response = $client->domains->delete( $response->id );
			$this->assertIsString( $response->id, sprintf( 'Domain %s deleted.', $response->id ) );
		} catch ( \Exception $e ) {
			$this->fail( 'Domain registration failed. Reason: ' . $e->getMessage() );
		}
	}
}