<?php

namespace PaidCommunities\WordPress;

use PaidCommunities\Exception\ApiErrorException;
use PaidCommunities\WordPress\HttpClient\WordPressClient;

/**
 * Controller that manages the plugin update logic
 */
class UpdateController {

	private $config;

	public function __construct( PluginConfig $config ) {
		$this->config = $config;
	}

	public function initialize() {
		add_filter( 'update_plugins_paidcommunities.com', [ $this, 'checkPluginUpdates' ], 10, 3 );
	}

	/**
	 * Given the provided plugin data, make a request to check for updates.
	 *
	 * @param $update
	 * @param $pluginData
	 * @param $pluginFile
	 *
	 * @return void
	 */
	public function checkPluginUpdates( $update, $pluginData, $pluginFile ) {
		if ( $pluginFile === $this->config->getPluginFile() ) {
			try {
				$license = $this->config->getLicense();
				$secret  = $license->getSecret();

				if ( $secret ) {
					$client   = new WordPressClient( $this->config->getEnvironment(), $secret );
					$response = $client->updates->check( [
						'version' => $pluginData['Version']
					] );
					if ( $response ) {
						$update = [
							'new_version' => $response->version,
							'version'     => $pluginData['Version'],
							'package'     => $response->package,
							'slug'        => $this->config->getPluginSlug()
						];
						$license->setLastCheck( $response->lastCheck );
						$license->save();
					}
				}
			} catch ( ApiErrorException $e ) {
				// add logging
				error_log( $e->getMessage() );
			}
		}

		return $update;
	}

}