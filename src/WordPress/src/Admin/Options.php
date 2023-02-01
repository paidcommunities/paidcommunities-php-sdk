<?php

namespace PaidCommunities\WordPress\Admin;

class Options {

	private $title;

	private $description;

	private $buttonActivateLabel;

	private $buttonDeactivateLabel;

	public function __construct() {
		$this->initialize();
	}

	public function setTitle( $title ) {
		$this->title = $title;

		return $this;
	}

	public function setDescription( $desc ) {
		$this->description = $desc;

		return $this;
	}

	public function getSettingsTitle() {
		return $this->title;
	}

	public function getDescription() {
		return $this->description;
	}

	public function initialize() {
		$this->title                 = __( 'License Settings', 'paidcommunities' );
		$this->description           = __( 'Enter your License key and click Activate.', 'paidcommunities' );
		$this->buttonActivateLabel   = __( 'Active', 'paidcommunities' );
		$this->buttonDeactivateLabel = __( 'Deactivate', 'paidcommunities' );
	}

}