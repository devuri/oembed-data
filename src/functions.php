<?php

namespace DevUri\HttpData;

/**
 * Gets the oEmbed data.
 *
 * @param string $url
 * @return mixed
 */
function data( string $url ) {
    return DataAPI::get( $url );
}

/**
 * Gets the oEmbed data provider.
 *
 * @param string $url
 * @return mixed
 */
function data_provider( string $url ) {
    return DataAPI::provider( $url );
}
