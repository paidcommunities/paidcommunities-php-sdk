<?php

namespace PaidCommunities\WordPress;

class WordPressUtils {

	public static function createNonce( $slug ) {
		return wp_create_nonce( $slug . '-action' );
	}

}