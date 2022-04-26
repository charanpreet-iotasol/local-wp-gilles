<?php

namespace Gravity_Forms\Gravity_Forms\Assets;

use Gravity_Forms\Gravity_Forms\GF_Service_Container;
use Gravity_Forms\Gravity_Forms\GF_Service_Provider;

/**
 * Class GF_Asset_Service_Provider
 *
 * Service provider for assets.
 *
 * @package Gravity_Forms\Gravity_Forms\Merge_Tags;
 */
class GF_Asset_Service_Provider extends GF_Service_Provider {

	const HASH_MAP = 'hash_map';
	const ASSET_PROCESSOR = 'asset_processor';

	/**
	 * Register services to the container.
	 *
	 * @since 2.6
	 *
	 * @param GF_Service_Container $container
	 */
	public function register( GF_Service_Container $container ) {
		require_once( plugin_dir_path( __FILE__ ) . '/class-gf-asset-processor.php' );

		$container->add( self::HASH_MAP, function() {
			if ( ! file_exists( plugin_dir_path( __FILE__ ) . '/../../assets/js/dist/assets.php' ) ) {
				return array();
			}

			$map = require_once( plugin_dir_path( __FILE__ ) . '/../../assets/js/dist/assets.php' );

			return $map['hash_map'];
		});

		$container->add( self::ASSET_PROCESSOR, function () use ( $container ) {
			$basepath   = \GFCommon::get_base_path();
			$asset_path = sprintf( '%s/assets/js/dist/', $basepath );

			return new GF_Asset_Processor( $container->get( self::HASH_MAP ), $asset_path );
		} );
	}

	public function init( GF_Service_Container $container ) {
		add_action( 'init', function() use ( $container ) {
			$container->get( self::ASSET_PROCESSOR )->process_assets();
		}, 9999 );
	}

}