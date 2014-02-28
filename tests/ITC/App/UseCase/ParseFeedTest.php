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



    /**
     * @var Seminar
     **/
    private $seminar;



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

        // Seminarクラスモック
        $seminar = $this->getMock('ITC\App\Entity\Seminar');
        $seminar->expects($this->any())
            ->method('ifRecordExists')
            ->with($this->equalTo($entries->item(0)))
            ->will($this->returnValue(false));

        $seminar->expects($this->any())
            ->method('getRecord')
            ->will($this->returnValue(new \stdClass));

        $seminar->expects($this->any())
            ->method('insert');
        $this->seminar = $seminar;

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
        $this->usecase->setSeminar($this->seminar);
        $this->usecase->setJsonS3Upload($this->ju);

        $result = $this->usecase->execute();
        $this->assertTrue($result);
    }
}
