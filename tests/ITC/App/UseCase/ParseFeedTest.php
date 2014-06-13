<?php


use ITC\App\UseCase\ParseFeed;
use ITC\App\Entity\Entry;

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


    /**
     * @var Entry
     **/
    private $entry;


    /**
     * @var JsonS3Upload
     **/
    private $ju;



    public function setUp ()
    {
        parent::setUp();
        $this->usecase = new ParseFeed();

        // テスト用のDOMを生成
        $test_data_path = DATA.DS.'fixture'.DS.'test_data.xml';
        $dom = new \DOMDocument();
        $dom->load($test_data_path);
        $entries = $dom->getElementsByTagName('entry');


        // Feedクラスモック
        $feed = $this->getMock('ITC\App\Entity\Feed');
        $feed->expects($this->any())
            ->method('parse')
            ->will($this->returnValue($entries));
        $this->feed = $feed;


        // JsonS3Uploadクラスモック
        $ju = $this->getMock('ITC\App\UseCase\JsonS3Upload');
        $ju->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(true));
        $this->ju = $ju;
    }



    /**
     * @test
     * @group parse-feed
     */
    public function フィードを解析する ()
    {
        $this->usecase->setFeed($this->feed);
        $this->usecase->setEntry(new Entry());
        $this->usecase->setJsonS3Upload($this->ju);
        $this->usecase->setBeginDate('2014-02-12 22:03:00');

        $result = $this->usecase->execute();
        $this->assertTrue($result);
    }
}
