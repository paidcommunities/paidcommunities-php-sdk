<?php

namespace PaidCommunities\Model;

abstract class AbstractModelFactory implements ModelFactoryInterface {

	public function buildModel( $response ) {
		// build the model class from the response
	}

	abstract protected function getModelClass();
}