<?php

namespace Http;

/**
 * Get url data
 * uses oEmbed via Core class WP_oEmbed used to get oEmbed data.
 *
 * @link https://oembed.com/
 * @link https://developer.wordpress.org/reference/classes/wp_oembed/
 */
class DataAPI
{

	/**
	 * Get_data() using  WP_oEmbed
	 *
	 * @param  string $url video url.
	 * @return object
	 * @link https://developer.wordpress.org/reference/classes/wp_oembed/
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
	public static function get( $url = null )
	{

		if ( is_null( $url ) ) {
			return array();
		}

		$o_embed = new \WP_oEmbed();
		return $o_embed->get_data( $url );

	}

	/**
	 * Provider description
	 *
	 * @param  string $geturl the url.
	 * @return object
	 */
	public static function provider( $geturl = null ) : object
	{
		$provider = array();
		$provider['name'] = self::get( $geturl )->provider_name;
		$provider['url']  = self::get( $geturl )->provider_url;
		$obdata       = (object) $provider;
		return $obdata;
	}

}
