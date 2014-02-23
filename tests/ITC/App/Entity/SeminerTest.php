<?php


use ITC\App\Utility\Test\TestCase;

use ITC\App\Utility\Registry;
use ITC\App\Entity\Seminer;

class SeminerTest extends TestCase
{

    /**
     * @var Seminer
     **/
    private $seminer;


    /**
     * エントリデータ
     *
     * @var DOMNodeList
     **/
    private $entries;


    public function setUp ()
    {
        parent::setUp();
        $this->seminer = new Seminer();

        // テスト用のDOMを生成
        $test_data_path = DATA.DS.'fixture'.DS.'test_data.xml';
        $dom = new \DOMDocument();
        $dom->load($test_data_path);
        $this->entries = $dom->getElementsByTagName('entry');
    }



    /**
     * @test
     * @group seminer
     * @group seminer-parse
     */
    public function DOMElementを解析してレコードオブジェクトに格納する ()
    {
        $entry  = $this->entries->item(0);
        $record = $this->seminer->parse($entry);

        $this->assertTrue(isset($record->id));
        $this->assertTrue(isset($record->published));
        $this->assertTrue(isset($record->updated));
        $this->assertTrue(isset($record->category));
        $this->assertTrue(isset($record->title));
        $this->assertTrue(isset($record->summary));
        $this->assertTrue(isset($record->content));
        $this->assertTrue(isset($record->link));
        $this->assertTrue(isset($record->author));
    }



    /**
     * @test
     * @group seminer
     * @group seminer-if
     */
    public function セミナーデータがDBに登録済みかどうかを確認する ()
    {
        // 未登録の場合
        $unregistered_entry = $this->entries->item(0);
        $result = $this->seminer->ifRecordExists($unregistered_entry);
        $this->assertFalse($result);


        // 登録済の場合
        $registerd_entry = $this->entries->item(1);
        $result = $this->seminer->ifRecordExists($registerd_entry);
        $this->assertTrue($result);
    }



    /**
     * @test
     * @group seminer
     * @group seminer-insert
     */
    public function セミナー新規レコードを登録する ()
    {
        try {
            $db = Registry::get('db');
            $db->beginTransaction();

            $entry = $this->entries->item(1);
            $this->seminer->parse($entry);
            $this->seminer->insert($this->seminer->getRecord());

            $db->commit();
        
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
}
