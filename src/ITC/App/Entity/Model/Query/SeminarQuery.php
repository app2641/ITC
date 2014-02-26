<?php


namespace ITC\App\Entity\Model\Query;

use ITC\App\Utility\Registry;

use ITC\App\Entity\Model\Column\SeminarColumn;
use ITC\App\Entity\Model\AbstractModel;

class SeminarQuery implements QueryInterface
{

    /**
     * @var ITC\App\Utility\Database\Database
     **/
    private $db;


    /**
     * @var SeminarColumn
     **/
    private $column;


    public function __construct ()
    {
        $this->db = Registry::get('db');
        $this->column = new SeminarColumn;
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
        try {
            foreach ($params as $key => $param) {
                if (! in_array($key, $this->getColumn())) {
                    throw new \Exception(sprintf('%s invalid column!', $key));
                }
            }
            $params->created = date('Y-m-d H:i:s');

            $sql = 'INSERT INTO seminar
                (title, url, date, venue, published, created) VALUES
                (:title, :url, :date, :venue, :published, :created)';
            $this->db->state($sql, $params);
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->fetchById($this->db->lastInsertId());
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
        try {
            $sql = 'SELECT * FROM seminar
                WHERE id = ?';
            $result = $this->db->state($sql, $id)->fetch();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $result;
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
            $sql = 'SELECT * FROM seminar
                WHERE seminar.title = ?
                AND seminar.url = ?';

            $result = $this->db->state($sql, array($title, $url))->fetch();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $result;
    }



    /**
     * 指定日以降に登録されたレコードを全取得する
     *
     * @param String $date  指定日
     * @return array
     **/
    public function getAfterDateSeminars ($date)
    {
        try {
            $sql = 'SELECT * FROM seminar
                WHERE seminar.created >= ?';

            $results = $this->db
                ->state($sql, $date)->fetchAll();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $results;
    }
}
