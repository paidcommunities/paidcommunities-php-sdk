<?php

namespace PaidCommunities\Util;

class GeneralUtils {

	public static function trimPath( $path ) {
		return \ltrim( \rtrim( $path, '/\\' ), '/\\' );
	}

	public static function isList( $value ) {
		if ( ! \is_array( $value ) ) {
			return false;
		}
		if ( array() === $value ) {
			return true;
		} elseif ( \array_keys() === \range( 0, count( $value ) - 1 ) ) {
			return true;
		}

		return false;
	}

	public static function redactString( $string, $last = 4 ) {
		$length = strlen( $string ) - $last;

		return implode( '', array_fill( 0, $length, '*' ) ) . substr( $string, $length );
	}

}