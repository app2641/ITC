<?php


namespace ITC\App\Entity;

use ITC\App\Entity\Model\AbstractModel;
use ITC\App\Entity\Model\Query\SeminerQuery;

class Seminer extends AbstractModel
{

    /**
     * Queryインターフェースの実装
     *
     * @return void
     **/
    public function __construct ()
    {
        $this->query = new SeminerQuery;
    }


    /**
     * 指定したDOMElementのレコードが既にDBにあるかどうか
     *
     * @param DOMElement $entry  entry要素のエレメント
     * @return boolean
     **/
    public function ifRecordExists (\DOMElement $entry)
    {
        var_dump($this->getColumn());
        exit();
        var_dump($entry);
        exit();
    }
}
