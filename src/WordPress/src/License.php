<?php

namespace PaidCommunities\WordPress;

class License {

	private $name;

	private $prefix;

	private $key;

	private $secret;

	private $status;

	private $domain;

	private $domainId;

	private $expiration;

	const INACTIVE = 'inactive';

	const ACTIVE = 'active';

	public function __construct( $name, $prefix ) {
		$this->name   = $name;
		$this->prefix = $prefix;
	}

	public function save() {
		\update_option( $this->getOptionName(), $this->toArray(), true );
	}

	public function delete() {
		\delete_option( $this->getOptionName() );
	}

	public function read() {
		$data             = \get_option( $this->getOptionName(), [] );
		$this->key        = $data['key'] ?? '';
		$this->secret     = $data['secret'] ?? '';
		$this->status     = $data['status'] ?? self::INACTIVE;
		$this->domain     = $data['domain'] ?? '';
		$this->domainId   = $data['domainId'] ?? '';
		$this->expiration = $data['expiration'] ?? '';
	}

	private function getOptionName() {
		return $this->prefix . $this->name . '_settings';
	}

	public function getKey() {
		return $this->key;
	}

	public function getSecret() {
		return $this->secret;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getDomain() {
		return $this->domain;
	}

	public function getDomainId() {
		return $this->domainId;
	}

	public function setKey( $key ) {
		$this->key = $key;
	}

	public function setSecret( $secret ) {
		$this->secret = $secret;
	}

	public function setStatus( $status ) {
		$this->status = $status;
	}

	public function setDomain( $domain ) {
		$this->domain = $domain;
	}

	public function setDomainId( $id ) {
		$this->domainId = $id;
	}

	public function toArray() {
		return [
			'key'        => $this->key,
			'secret'     => $this->secret,
			'status'     => $this->status,
			'domain'     => $this->domain,
			'domainId'   => $this->domainId,
			'expiration' => $this->expiration
		];
	}

	public function isActive() {
		return $this->status === self::ACTIVE;
	}

	public function getMaskedKey() {
		if ( $this->key ) {
			$length = strlen( $this->key ) - 4;
			$key    = implode( '', array_fill( 0, $length, 'x' ) ) . substr( $this->key, $length );

			return $key;
		}

		return $this->key;
	}

}