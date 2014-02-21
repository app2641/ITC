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
    protected $query;


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
