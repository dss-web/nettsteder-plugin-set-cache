<?php
/**
 * Plugin Name:  Nettsteder Plugin Set cache
 * Plugin URI:   https://github.com/dss-web/nettsteder-plugin-set-cache
 * GitHub Plugin https://github.com/dss-web/nettsteder-plugin-set-cache
 * Description:  Add missing cache in header.
 * Version:      1.0.0
 * Author:       Dekode Interaktiv / DSS
 *
 * @package DSS/Plugin
 */

declare( strict_types = 1 );

namespace DSS\Plugin\Set_Cache;

\add_filter( 'wp_headers', __NAMESPACE__ . '\\on_wp_headers', 10, 1 );

function on_wp_headers( array $headers ) : array {
	// check if cache control is set in the header .
	if( isset ( $headers['Cache-Control'] ) and \is_string( $headers['Cache-Control'] ) ) {
		$current_cache_control = \array_map( 'trim', \explode( ',', $headers['Cache-Control'] ) );

		// check for no caching.
		if( \in_array('no-cache', $current_cache_control, true ) ) {
			// Set defaul caching to 300 seconds / 5 minutes.
			$seconds_to_cache = \apply_filters( 'dss/nettsteder/plugin/set_cache/seconds_to_cache', 300 );
			$expires = \gmdate("D, d M Y H:i:s", \time() + $seconds_to_cache) . " GMT";
			$headers['Expires'] = $expires;
			$headers['Cache-Control'] = 'max-age=' . $seconds_to_cache;
		}
	}

	return $headers;
}
