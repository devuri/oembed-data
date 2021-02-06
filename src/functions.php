<?php

namespace Http;

/**
 * Gets the oEmbed data.
 *
 * @return mixed
 */
function data( string $url ) {
    return DataAPI::get( $url );
}

/**
 * Gets the oEmbed data provider.
 *
 * @return mixed
 */
function data_provider( string $url ) {
    return DataAPI::provider( $url );
}
