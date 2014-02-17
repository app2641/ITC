<?php


namespace ITC\App\Entity\Model\Query;

use ITC\App\Entity\Model\Column\SeminerColumn;
use ITC\App\Entity\Model\AbstractModel;

class SeminerQuery implements QueryInterface
{

    /**
     * @var SeminerColumn
     **/
    private $column;


    public function __construct ()
    {
        $this->column = new SeminerColumn;
    }



    /**
     * カラム配列を返す
     *
     * @return Array
     **/
    public function getColumn ()
    {
        return $this->column->getColumn();
    }



    /**
     * 新規レコード挿入
     *
     * @param stdClass $params  パラメータ
     * @return boolean
     **/
    public function insert (\stdClass $params)
    {
        
    }



    /**
     * レコードの更新
     *
     * @param AbstractModel $model  モデルクラス
     * @return boolean
     **/
    public function update (AbstractModel $model)
    {
        
    }


    
    /**
     * レコードの削除
     *
     * @param AbstractModel $model  モデルクラス
     * @return boolean
     **/
    public function delete (AbstractModel $model)
    {
        
    }



    /**
     * 指定IDのレコードを取得する
     *
     * @param int $id  レコードのID
     * @return stdClass
     **/
    public function fetchById ($id)
    {
        
    }
}
