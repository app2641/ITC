<?php


use ITC\App\Utility\Test\TestCase;

use ITC\App\Utility\Registry;
use ITC\App\Entity\Seminar;

class SeminarTest extends TestCase
{

    /**
     * @var Seminar
     **/
    private $seminar;


    /**
     * エントリデータ
     *
     * @var DOMNodeList
     **/
    private $entries;


    public function setUp ()
    {
        parent::setUp();
        $this->seminar = new Seminar();

        // テスト用のDOMを生成
        $test_data_path = DATA.DS.'fixture'.DS.'test_data.xml';
        $dom = new \DOMDocument();
        $dom->load($test_data_path);
        $this->entries = $dom->getElementsByTagName('entry');
    }



    /**
     * @test
     * @group seminar
     * @group seminar-parse
     */
    public function DOMElementを解析してレコードオブジェクトに格納する ()
    {
        $entry  = $this->entries->item(0);
        $record = $this->seminar->parse($entry);

        $this->assertTrue(isset($record->title));
        $this->assertTrue(isset($record->url));
        $this->assertTrue(isset($record->venue));
        $this->assertTrue(isset($record->date));
        $this->assertTrue(isset($record->published));
    }



    /**
     * @test
     * @group seminar
     * @group seminar-if
     */
    public function セミナーデータがDBに登録済みかどうかを確認する ()
    {
        // 未登録の場合
        $unregistered_entry = $this->entries->item(0);
        $result = $this->seminar->ifRecordExists($unregistered_entry);
        $this->assertFalse($result);


        // 登録済の場合
        $registerd_entry = $this->entries->item(1);
        $result = $this->seminar->ifRecordExists($registerd_entry);
        $this->assertTrue($result);
    }



    /**
     * @test
     * @group seminar
     * @group seminar-insert
     */
    public function セミナー新規レコードを登録する ()
    {
        try {
            $db = Registry::get('db');
            $db->beginTransaction();

            $entry = $this->entries->item(0);
            $this->seminar->parse($entry);
            $this->seminar->insert($this->seminar->getRecord());

            $record = $this->seminar->query->fetchByTitleWithUrl(
                $this->seminar->getRecord()->title,
                $this->seminar->getRecord()->url
            );
            $this->assertTrue(isset($this->seminar->getRecord()->id));

            $db->rollBack();
        
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }



    /**
     * @test
     * @group seminar
     * @group seminar-afterdate
     **/
    public function 指定日以降に登録されたレコードを取得する ()
    {
        // 指定日以降のレコードがある場合
        $date = '2014-02-20';
        $results = $this->seminar->query->getAfterDateSeminars($date);
        $this->assertTrue(count($results) > 0);

        // 指定日以降のレコードがない場合
        $date = '2014-02-21';
        $results = $this->seminar->query->getAfterDateSeminars($date);
        $this->assertEquals(0, count($results));
    }
}
