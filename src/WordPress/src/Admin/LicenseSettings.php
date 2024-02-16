<?php

namespace PaidCommunities\WordPress\Admin;

use PaidCommunities\WordPress\Assets\AssetDataApi;
use PaidCommunities\WordPress\Assets\AssetsApi;
use PaidCommunities\WordPress\PluginConfig;

class LicenseSettings {

	private $config;

	private $assets;

	protected $callback;

	private $options;

	private $data;

	public function __construct( PluginConfig $config, AssetsApi $assets, $callback = null ) {
		$this->config   = $config;
		$this->assets   = $assets;
		$this->callback = $callback;
		$this->data     = new AssetDataApi();
		$this->options  = new Options();
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );
	}

	public function register_scripts() {
		$this->assets->register_script( 'paidcommunities-license', 'build/license-settings.js' );
		$this->assets->register_style( 'paidcommunities-styles', 'build/styles.css' );
		$this->addAssetData();
	}

	public function options() {
		$this->options = new Options();

		return $this->options();
	}

	public function render() {
		$license    = $this->config->getLicense();
		$buttonText = $license->isActive() ? 'Deactivate Site' : 'Activate Site';
		wp_enqueue_script( 'paidcommunities-license' );
		wp_enqueue_style( 'paidcommunities-styles' );
		$this->data->print_data( 'paidCommunitiesLicenseParams' );
		if ( $this->callback ) {
			$callback = $this->callback;
			call_user_func( $callback, $this );
		} else {
			?>
            <div class="pc-license-settings">
                <div class="pc-license-settings__header">
                    <h2><?php esc_html_e( $this->options->getSettingsTitle() ) ?></h2>
                </div>
                <div class="pc-grid-sm-6">
                    <div class="pc-paper">
                        <div class="pc-row">
                            <div class="pc-grid">
                                <div class="pc-input-field">
                                    <label>License Key</label>
                                    <input type="text" id="<?php echo $this->config->getPluginSlug() . '_license' ?>" name="<?php echo $this->config->getPluginSlug() . '_license' ?>" value="<?php echo $license->getLicenseKey() ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="pc-row">
                            <div class="pc-grid">
                                <button class="btn button-secondary paidcommunities-license-btn"><?php echo $buttonText ?></button>
                            </div>
                        </div>
                        <div class="pc-notices"></div>
                    </div>
                </div>
            </div>
			<?php
		}
	}

	private function addAssetData() {
		$this->data->add( 'ajaxUrl', add_query_arg( [ 'nonce' => wp_create_nonce( "{$this->config->getPluginSlug()}-nonce" ) ], admin_url( 'admin-ajax.php' ) ) );
		$this->data->add( 'actions', [ 'activate' => "activate_{$this->config->getPluginSlug() }", 'deactivate' => "deactivate_{$this->config->getPluginSlug() }" ] );
		$this->data->add( 'pluginName', $this->config->getPluginSlug() );
		$this->data->add( 'license', $this->config->getLicense()->toArray() );
		$this->data->add( 'i18n', [ 'activateMsg' => 'Activating...', 'deactivateMsg' => 'Deactivating...' ] );
	}

}