<?php

namespace PaidCommunities\Util;

class GeneralUtils {
	
	public static function trimPath( $path ) {
		return \ltrim( \rtrim( $path, '/\\' ), '/\\' );
	}
}