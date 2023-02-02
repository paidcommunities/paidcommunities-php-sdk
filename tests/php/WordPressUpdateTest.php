<?php

namespace php;

class WordPressUpdateTest extends \PHPUnit\Framework\TestCase {

	public function testUpdateCheck() {
		delete_site_transient( 'update_plugins' );
		wp_update_plugins();
		$updates = get_site_transient( 'update_plugins' );
		$this->assertIsObject( $updates, 'Plugin updates is an array' );
		if ( $updates->response ) {
			if ( isset( $updates->response[ PREMIUM_PLUGIN_NAME ] ) ) {
				$update = $updates->response[ PREMIUM_PLUGIN_NAME ];
				$this->assertIsObject( $update, 'Plugin update is an array' );
				$this->assertObjectHasAttribute( 'update', $update );
				$this->assertObjectHasAttribute( 'package', $update );
			}
		} else {
			$this->assertArrayHasKey( PREMIUM_PLUGIN_NAME, $updates->no_update, 'Plugin does not have an update' );
		}
	}
}