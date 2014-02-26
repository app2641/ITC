<?php


namespace ITC\App\Entity\Model;

use ITC\App\Utility\Registry;
use ITC\App\Utility\Database\Helper;

abstract class AbstractModel
{

    /**
     * クエリーインターフェース
     *
     * @var QueryInterface
     **/
    public $query;


    /**
     * レコードオブジェクト
     *
     * @var stdClass
     **/
    protected $record;



    /**
     * コンストラクタ
     *
     * @return void
     **/
    public function __construct ()
    {
        // DBへの接続を確立する
        $db = Helper::connection();
        Registry::set('db', $db);
    }



    /**
     * 新規レコード挿入
     *
     * @param stdClass $params  レコードパラメータ
     * @return void
     **/
    public function insert (\stdClass $params)
    {
        $this->record = $this->query->insert($params);
    }



    /**
     * レコード更新
     *
     * @return void
     **/
    public function update ()
    {
        $this->record = $this->query->update($this);
    }



    /**
     * レコードの削除
     *
     * @return void
     **/
    public function delete ()
    {
        $this->query->delete($this);
        $this->record = null;
    }



    /**
     * カラムを取得する
     *
     * @return array
     **/
    public function getColumn ()
    {
        $this->query->getColumn();
    }



    /**
     * レコードオブジェクトを返す
     *
     * @return stdClass
     **/
    public function getRecord ()
    {
        return $this->record;
    }
}
