<?php

namespace PaidCommunities\Model;

/**
 * @property string $slug
 * @property bool $update
 * @property string $version
 * @property string $package
 * @property string $last_check
 * @property \stdClass $icons
 */
class SoftwareUpdate extends AbstractModel {
	/**
	 * @return bool
	 */
	public function isUpdate() {
		return $this->update;
	}

	/**
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * @param string $slug
	 */
	public function setSlug( string $slug ) {
		$this->slug = $slug;
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
		return $this->last_check;
	}

	/**
	 * @param string $lastCheck
	 */
	public function setLastCheck( string $lastCheck ) {
		$this->last_check = $lastCheck;
	}

}