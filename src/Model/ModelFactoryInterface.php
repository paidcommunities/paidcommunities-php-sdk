<?php

namespace PaidCommunities\Model;

interface ModelFactoryInterface {

	function buildModel( $clazz, $response );

}