<?php

namespace PaidCommunities\Service;

interface ServiceFactoryInterface {

	function getService( $name, $clazz );
}