<?php

namespace DevUri\HttpData;

use InvalidArgumentException;

class YouTube
{
	/**
	 * Make sure we get a valid URL
	 *
	 * @param  string $url youtube url
	 * @return bool
	 */
	protected function validate( $url = null ) : bool
	{
		if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
			return true;
		}
		return false;
	}

    /**
     * Get the video id from url,
     * if not return false
     *
     * @param string $video_url the video url.
     * @return mixed
     * @throws \Exception
     */
	public function id( $video_url = null ) : string
	{
		if( ! $this->validate( $video_url ) ) {
            throw new InvalidArgumentException("This is Not a valid URL.");
        }

		// check if empty.
		if ( is_null( $video_url ) ) {
			return '';
		}

		// get the id.
		if ( null !== $video_url ) {

			if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url, $video_id ) ) {
				$id = $video_id[1];
			} else {
				$id = '';
			}
		}
		return trim($id);
	}

    /**
     * Get the video ID,
     * if not return false
     *
     * @param string $url the video url.
     * @return mixed|string
     * @return mixed|string
     */
	public function getID( $url = null ) {
		try {
			return $this->id( $url );
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

    /**
     * Get high quality video_thumbnail
     *
     * @param string $video_url the video url.
     * @return string
     * @throws \Exception
     * @throws \Exception
     */
	public function thumbnail( $video_url = null ) : string
	{
		$id = $this->id( $video_url );
		/**
		 * Set up to use the maxresdefault image
		 * example https://img.youtube.com/vi/yXzWfZ4N4xU/maxresdefault.jpg
		 *
		 * @link https://stackoverflow.com/questions/2068344/how-do-i-get-a-youtube-video-thumbnail-from-the-youtube-api
		 */
		$image_url = 'https://img.youtube.com/vi/' . $id . '/maxresdefault.jpg';

		/**
		 * Lets make sure all is well
		 * The maxresdefault is not always available
		 * if we cant get the high resolution (maxresdefault) use the (hqdefault)
		 */
		$image = wp_remote_get( $image_url );
		if ( 200 === $image['response']['code'] ) {
			$thumbnail = 'https://img.youtube.com/vi/' . $id . '/maxresdefault.jpg';
		} else {
			$thumbnail = 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
		}
		return $thumbnail;
	}

	/**
	 * Get youtube video info using WP_oEmbed
	 *
	 * @param  mixed   $v video id, or array of video ids.
	 * @param  integer $limit how many videos.
	 * @return array video data
	 */
	public function info( $v = null, $limit = 1 ) : array
	{

		if ( 1 === $limit ) {
			return $this->video( $v );
		}

		if ( is_array( $v ) ) {
			return $this->videos( $v, $limit );
		} else {
			return $this->video( $v );
		}
	}

    /**
     * Get video data for a single video using WP_oEmbed
     *
     * @param mixed $v video id.
     *
     * @return array video data
     * @throws \Exception
     * @throws \Exception
     */
	public function video( $v = null ) : array
	{
		if ( is_array( $v ) ) {
			$v = reset( $v );
		}

		if ( empty( $this->id( $v ) ) ) {
			return array();
		}

		$v = $this->id( $v );
        return array(
            'id'          => $v,
            'title'       => DataAPI::get( 'https://www.youtube.com/watch?v=' . $v )->title,
            'thumbnail'   => DataAPI::get( 'https://www.youtube.com/watch?v=' . $v )->thumbnail_url,
            'author_name' => DataAPI::get( 'https://www.youtube.com/watch?v=' . $v )->author_name,
            'author_url'  => DataAPI::get( 'https://www.youtube.com/watch?v=' . $v )->author_url,
        );
	}

    /**
     * Get info for a list of videos using WP_oEmbed
     *
     * @param null $videos
     * @param integer $limit how many videos.
     *
     * @return array video data
     * @throws \Exception
     */
	public function videos( $videos = null, $limit = 2 ) : array
	{

		if ( 1 === $limit ) {
			return $this->video( $videos );
		}

		$i = 0;
		foreach ( $videos as $key => $v ) {

			if ( empty( $this->id( $v ) ) ) {
				return array();
			}

			$v = $this->id( $v );

			$videos[ $key ] = array(
				'id'          => $v,
				'title'       => DataAPI::get( 'https://www.youtube.com/watch?v=' . $v )->title,
				'thumbnail'   => DataAPI::get( 'https://www.youtube.com/watch?v=' . $v )->thumbnail_url,
				'author_name' => DataAPI::get( 'https://www.youtube.com/watch?v=' . $v )->author_name,
				'author_url'  => DataAPI::get( 'https://www.youtube.com/watch?v=' . $v )->author_url,
			);
			if ( ++$i === $limit ) break;
		}
		return $videos;
	}

}
