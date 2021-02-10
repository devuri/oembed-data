<?php

use PHPUnit\Framework\TestCase;
use DevUri\HttpData\DataAPI;
use DevUri\HttpData\YouTubeVideo;

class OembedHttpDataTest extends TestCase
{

	/** @var string */
	protected $url = 'https://www.youtube.com/watch?v=pvotANfq410';

	/** @var string */
	protected $invalid_url = 'httube.com/watch?v=pvotANfq410';

	protected function setUp(): void
	{
		parent::setUp();

	}

	/**
	 * @test
	 */
	public function can_get_video_id_as_string(): object
	{
		$youtube = (new YouTubeVideo());

		$this->assertIsString( $youtube->id( $this->url ) );

		return $youtube;
	}

	/**
	 * @test
	 * @depends can_get_video_id_as_string
	 */
	public function can_get_video_id( YouTubeVideo $youtube ): void
	{
		$this->assertSame(
			'pvotANfq410',
			$youtube->id( $this->url ),
			'Expecting 11 char youtube Video ID, actual value does not equal what was expected'
		);
	}

	/**
	 * @test
	 * @depends can_get_video_id_as_string
	 */
	public function throws_exception_for_invalid_url( YouTubeVideo $youtube ) : void
	{
		$this->expectException( InvalidArgumentException::class );
		$youtube->id( $this->invalid_url );
	}

}
