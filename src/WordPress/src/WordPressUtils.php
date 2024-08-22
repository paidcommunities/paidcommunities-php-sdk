<?php

namespace PaidCommunities\WordPress;

class WordPressUtils {

	public static function createNonce( $key ) {
		return wp_create_nonce( $key . '-action' );
	}

	public static function formatPluginName( $value ) {
		return preg_replace( [ '/\//', '/\./' ], [ '_', '__' ], $value );
	}

}