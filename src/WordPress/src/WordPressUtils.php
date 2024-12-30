<?php

namespace PaidCommunities\WordPress;

class WordPressUtils {

	public static function createNonce( $key ) {
		return wp_create_nonce( $key . '-action' );
	}

	public static function formatPluginName( $value ) {
		return preg_replace( [ '/\//', '/\./' ], [ '_', '__' ], $value );
	}

	/**
	 * @param $pluginFile
	 *
	 * @return mixed|string
	 * @since 1.0.1
	 */
	public static function parsePluginVersion( $pluginFile ) {
		$data['Version'] = '';
		if ( file_exists( $pluginFile ) ) {
			$data = \get_file_data( $pluginFile, [ 'Version' => 'Version' ], 'plugin' );
		}

		return $data['Version'] ?? '';
	}

}