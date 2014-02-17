<?php


namespace ITC\App\Entity\Model;

abstract class AbstractModel
{

    /**
     * クエリーインターフェース
     *
     * @var QueryInterface
     **/
    protected $query;



    /**
     * カラムを取得する
     *
     * @return array
     **/
    public function getColumn ()
    {
        var_dump($this->query);
        exit();
        $this->query->getColumn();
    }
}
