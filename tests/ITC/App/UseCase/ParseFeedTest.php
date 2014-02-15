<?php


use ITC\App\UseCase\ParseFeed;

class ParseFeedTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ParseFeed
     **/
    private $usecase;



    /**
     * @var Feed
     **/
    private $feed;



    public function setUp ()
    {
        parent::setUp();

        $this->usecase = new ParseFeed();

        $feed = $this->getMock('ITC\App\Entity\Feed');
        $feed->expects($this->any())
            ->method('parse')
            ->will($this->returnValue(array()));
        $this->feed = $feed;
    }



    /**
     * @test
     * @group parse-feed
     */
    public function フィードを解析する ()
    {
        $this->usecase->setFeed($this->feed);
        $result = $this->usecase->execute();
        $this->assertTrue($result);
    }
}
