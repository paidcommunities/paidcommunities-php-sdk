<?php

namespace PaidCommunities\WordPress;

class License {

	private $name;

	private $prefix;

	private $licenseKey;

	private $secret;

	private $status;

	private $domain;

	private $domainId;

	private $expiration;

	private $createdAt;

	private $lastCheck;

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
		$this->setLicenseKey( '' );
		$this->setSecret( '' );
		$this->setStatus( '' );
		$this->setDomain( '' );
		$this->setDomainId( '' );
		$this->setExpiration( '' );
		$this->setCreatedAt( '' );
		$this->setLastCheck( '' );
	}

	public function read() {
		$data             = \get_option( $this->getOptionName(), [] );
		$this->licenseKey = $data['licenseKey'] ?? '';
		$this->secret     = $data['secret'] ?? '';
		$this->status     = $data['status'] ?? self::INACTIVE;
		$this->domain     = $data['domain'] ?? '';
		$this->domainId   = $data['domainId'] ?? '';
		$this->expiration = $data['expiration'] ?? '';
		$this->createdAt  = $data['createdAt'] ?? '';
	}

	private function getOptionName() {
		return $this->prefix . $this->name . '_settings';
	}

	public function getLicenseKey() {
		return $this->licenseKey;
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

	public function getCreatedAt() {
		return $this->createdAt;
	}

	public function getLastCheck() {
		return $this->lastCheck;
	}

	public function setLicenseKey( $key ) {
		$this->licenseKey = $key;
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

	public function setCreatedAt( $value ) {
		$this->createdAt = $value;
	}

	public function setLastCheck( $value ) {
		$this->lastCheck = $value;
	}

	public function toArray() {
		return [
			'licenseKey' => $this->licenseKey,
			'secret'     => $this->secret,
			'status'     => $this->status,
			'domain'     => $this->domain,
			'domainId'   => $this->domainId,
			'expiration' => $this->expiration,
			'createdAt'  => $this->createdAt,
			'lastCheck'  => $this->lastCheck
		];
	}

	public function isActive() {
		return $this->status === self::ACTIVE;
	}

}