<?php


use ITC\App\Entity\Seminer;

class SeminerTest extends \PHPUnit_Framework_TestCase
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
     * @group seminer-if
     */
    public function セミナーデータがDBに登録済みかどうかを確認する ()
    {
        // 未登録の場合
        $unregistered_entry = $this->entries->item(0);
        $result = $this->seminer->ifRecordExists($unregistered_entry);
    }
}
