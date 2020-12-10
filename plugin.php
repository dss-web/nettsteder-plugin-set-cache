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
	// check if cache control is set in the header and if not add it.
	if ( false === \array_key_exists( 'Cache-Control', $headers ) ) {
		// Set default caching to 300 seconds / 5 minutes. Can be changed using the filter.
		$seconds_to_cache         = \apply_filters( 'dss/nettsteder/plugin/set_cache/seconds_to_cache', 300 );
		$headers['Cache-Control'] = 'public, max-age=' . $seconds_to_cache;
	}

	return $headers;
}
