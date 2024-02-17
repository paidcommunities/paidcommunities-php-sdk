<?php

namespace PaidCommunities\Model;

/**
 * @property bool $update
 * @property string $version
 * @property string $package
 * @property string $lastCheck
 */
class SoftwareUpdate extends AbstractModel {
	/**
	 * @return bool
	 */
	public function isUpdate() {
		return $this->update;
	}

	/**
	 * @param bool $update
	 */
	public function setUpdate( bool $update ) {
		$this->update = $update;
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @param string $version
	 */
	public function setVersion( string $version ) {
		$this->version = $version;
	}

	/**
	 * @return string
	 */
	public function getPackage() {
		return $this->package;
	}

	/**
	 * @param string $package
	 */
	public function setPackage( string $package ) {
		$this->package = $package;
	}

	/**
	 * @return string
	 */
	public function getLastCheck() {
		return $this->lastCheck;
	}

	/**
	 * @param string $lastCheck
	 */
	public function setLastCheck( string $lastCheck ) {
		$this->lastCheck = $lastCheck;
	}

}