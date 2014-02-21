<?php


namespace ITC\App\Entity\Model\Query;

use ITC\App\Utility\Registry;

use ITC\App\Entity\Model\Column\SeminerColumn;
use ITC\App\Entity\Model\AbstractModel;

class SeminerQuery implements QueryInterface
{

    /**
     * @var ITC\App\Utility\Database\Database
     **/
    private $db;


    /**
     * @var SeminerColumn
     **/
    private $column;


    public function __construct ()
    {
        $this->db = Registry::get('db');
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



    /**
     * タイトルとURLでレコードを取得する
     *
     * @param String $title  セミナータイトル
     * @param String $url  イベントページURL
     * @return stdClass
     **/
    public function fetchByTitleWithUrl ($title, $url)
    {
        try {
            $sql = 'SELECT * FROM seminer
                WHERE seminer.title = ?
                AND seminer.url = ?';

            $result = $this->db->state($sql, array($title, $url))->fetch();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $result;
    }
}
