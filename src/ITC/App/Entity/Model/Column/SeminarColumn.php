<?php


namespace ITC\App\Entity\Model\Column;

class SeminarColumn extends AbstractColumn
{

    /**
     * カラム配列
     *
     * @var Array
     **/
    protected $column = array(
        'id',
        'title',
        'url',
        'date',
        'venue',
        'published',
        'is_active',
        'created',
        'updated'
    );
}
