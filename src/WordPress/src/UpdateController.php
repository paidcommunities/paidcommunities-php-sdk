<?php

namespace PaidCommunities\WordPress;

use PaidCommunities\Exception\ApiErrorException;
use PaidCommunities\WordPress\HttpClient\WordPressClient;

/**
 * Controller that manages the plugin update logic
 */
class UpdateController {

	private $config;

	private $client;

	public function __construct( PluginConfig $config, WordPressClient $client ) {
		$this->config = $config;
		$this->client = $client;
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
		try {
			$license = $this->config->getLicense();
			$key     = $license->getKey();
			$domain  = $license->getDomainId();
			if ( $key && $domain ) {
				$response = $this->client->updates->check( [
					'license' => $key,
					'domain'  => $domain,
					'version' => $pluginData['Version']
				] );
				if ( $response ) {
					$update = [
						'new_version' => $response->version,
						'version'     => $pluginData['Version'],
						'package'     => $response->package,
						'slug'        => $this->config->getPluginSlug()
					];
				}
			}
		} catch ( ApiErrorException $e ) {
			// add logging
			error_log( $e->getMessage() );
		}

		return $update;
	}

}