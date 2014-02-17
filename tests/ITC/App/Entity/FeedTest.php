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



    /**
     * @test
     * @medium
     * @group feed-parse
     * @group feed
     */
    public function DOMDocumentからentry要素を取得する ()
    {
        $entries = $this->feed->parse();
        $this->assertEquals('DOMNodeList', get_class($entries));
    }
}
