<?php


namespace ITC\App\Entity;

use ITC\App\Entity\Model\AbstractModel;
use ITC\App\Entity\Model\Query\SeminarQuery;

class Seminar extends AbstractModel
{

    /**
     * Queryインターフェースの実装
     *
     * @return void
     **/
    public function __construct ()
    {
        parent::__construct();
        $this->query = new SeminarQuery;
    }



    /**
     * 渡されたDOMElementデータをレコードオブジェクトに格納する
     *
     * @param DOMElement $entry
     * @return void
     **/
    public function parse (\DOMElement $entry)
    {
        $this->record = new \stdClass;
        foreach ($entry->childNodes as $key => $el) {
            if ($el->nodeName != '#text') {
                $this->record->{$el->nodeName} = trim($el->nodeValue);
            }
        }

        // content要素を分解する
        $this->_parseContentElement();

        // 不要なプロパティを除去する
        foreach ($this->record as $key => $val) {
            if (! in_array($key, $this->query->getColumn())) {
                unset($this->record->{$key});
            }
        }
        unset($this->record->id);
        unset($this->record->updated);
        $this->record->published = date('Y-m-d H:i:s', strtotime($this->record->published));

        return $this->record;
    }



    /**
     * content要素の内容を解析する
     *
     * @return void
     **/
    private function _parseContentElement ()
    {
        $content = $this->record->content;

        // 開催期間
        preg_match('/期間:(.*)\n/', $this->record->content, $matches);
        $this->record->date = trim($matches[1]);

        // 開催場所
        preg_match('/場所:(.*)\n/', $this->record->content, $matches);
        $this->record->venue = trim($matches[1]);

        // イベントページ
        preg_match('/予定の説明:(.*)/', $this->record->content, $matches);
        $this->record->url = trim($matches[1]);
    }



    /**
     * 指定したDOMElementのレコードが既にDBにあるかどうか
     *
     * @param DOMElement $entry  entry要素のエレメント
     * @return boolean
     **/
    public function ifRecordExists (\DOMElement $entry)
    {
        $record = $this->parse($entry);
        $result = $this->query->fetchByTitleWithUrl(
            $record->title, $record->url
        );

        return ($result) ? true: false;
    }
}
