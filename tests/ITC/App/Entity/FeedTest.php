<?php


use ITC\App\Entity\Feed;

class FeedTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Feed
     **/
    private $feed;


    public function setUp ()
    {
        parent::setUp();
        $this->feed = new Feed();
    }



    /**
     * @test
     * @medium
     * @group feed-getdom
     * @group feed 
     **/
    public function FeedからDOMDocumentを生成する ()
    {
        $dom = $this->feed->getDom();
        $this->assertEquals('DOMDocument', get_class($dom));
    }
}
