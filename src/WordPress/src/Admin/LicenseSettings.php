<?php

namespace PaidCommunities\WordPress\Admin;

class LicenseSettings {

	protected $callback;

	private $options;

	public function __construct( $callback = null ) {
		$this->callback = $callback;
		$this->options  = new Options();
	}

	public function options() {
		$this->options = new Options();

		return $this->options();
	}

	public function render() {
		if ( $this->callback ) {
			call_user_func( $this->callback, $this );
		} else {
			?>
            <div class="pc-license-settings">
                <div class="pc-license-settings__header">
                    <h2><?php esc_html_e( $this->options->getSettingsTitle() ) ?></h2>
                </div>
            </div>
			<?php
		}
	}

}