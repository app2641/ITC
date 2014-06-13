<?php


use ITC\App\Entity\Entry;

class EntryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Entry
     **/
    private $entry;


    /**
     * @var DOMDocument
     **/
    private $dom;


    /**
     * セットアップ
     *
     * @return void
     **/
    public function setUp ()
    {
        $this->entry = new Entry();

        $this->dom = new \DOMDocument('1.0', 'UTF-8');
        $this->dom->loadXML(file_get_contents(ROOT_PATH.'/data/fixture/test_data.xml'));

        $el = $this->dom->getElementsByTagName('entry')->item(0);
        $this->entry->setData($el);
    }


    /**
     * @test
     * @group entry
     * @group entry-get-date
     */
    public function セミナー登録日を取得する ()
    {
        $date = $this->entry->getPublishedDate();
        $this->assertEquals('2014-02-13 16:00:55', $date);
    }


    /**
     * @test
     * @group entry
     * @group entry-get-title
     **/
    public function セミナーのタイトルを取得する ()
    {
        $title = $this->entry->getTitle();
        $this->assertEquals('[東京]Enterprise x HTML5 Conference 2014 - エンタープライズIT向けWeb標準技術のソリューション展', $title);
    }


    /**
     * @test
     * @group entry
     * @group entry-get-schedule
     */
    public function セミナーの開催日を取得する ()
    {
        $schedule = $this->entry->getSchedule();
        $this->assertEquals('2014/02/28 (金) 10:30～18:00', $schedule);
    }


    /**
     * @test
     * @group entry
     * @group entry-get-venue
     */
    public function セミナーの開催場所を取得する ()
    {
        $venue = $this->entry->getVenue();
        $this->assertEquals('明星大学 日野キャンパス 28号館 2F', $venue);
    }


    /**
     * @test
     * @group entry
     * @group entry-get-url
     */
    public function セミナーのurlを取得する ()
    {
        $url = $this->entry->getUrl();
        $this->assertEquals('http://conference.html5biz.org/2014spring/', $url);
    }
}

