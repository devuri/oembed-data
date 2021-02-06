<?php

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use DevUri\HttpData\DataAPI;
use DevUri\HttpData\YouTube;

class OembedHttpDataTest extends TestCase
{

	/** @var string */
    protected $url = 'https://www.youtube.com/watch?v=wfN4PVaOU5Q';

	/** @var string */
    protected $invalid_url = 'httube.com/watch?v=wfN4PVaOU5Q';

    protected function setUp(): void
    {
        parent::setUp();

    }

	/** @test */
	public function can_get_video_id(): void
    {
		$youtube = (new YouTube());
        $this->assertEquals(
            'wfN4PVaOU5Q',
            $youtube->id( $this->url )
        );
    }

	/** @test */
	public function throws_exception_for_invalid_url()
    {
		$youtube = (new YouTube());
        $this->expectException( InvalidArgumentException::class );
        $youtube->id( $this->invalid_url );
    }
}
