<?php


namespace ITC\App\Entity\Model\Column;

abstract class AbstractColumn
{
    
    /**
     * カラム配列
     *
     * @var Array
     **/
    protected $column;



    /**
     * カラム配列を返す
     *
     * @return Array
     **/
    public function getColumn ()
    {
        return $this->column;
    }
}
