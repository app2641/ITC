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

        // テスト用のDOMを生成
        $test_data_path = DATA.DS.'fixture'.DS.'test_data.xml';
        $dom = new \DOMDocument();
        $dom->load($test_data_path);
        $entries = $dom->getElementsByTagName('entry');

        $feed = $this->getMock('ITC\App\Entity\Feed');
        $feed->expects($this->any())
            ->method('parse')
            ->will($this->returnValue($entries));
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
