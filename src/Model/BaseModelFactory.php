<?php

namespace PaidCommunities\Model;

class BaseModelFactory extends AbstractModelFactory {

	private $mappings = [
		'update' => SoftwareUpdate::class
	];

	protected function getModelClass( $name ) {
		return $this->mappings[ $name ] ?? null;
	}

	protected function hasClass( $name ) {
		return isset( $this->mappings[ $name ] );
	}
}