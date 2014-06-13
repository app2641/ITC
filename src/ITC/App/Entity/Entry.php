<?php


namespace ITC\App\Entity;

class Entry
{

    /**
     * @var DOMElement
     **/
    private $data;


    /**
     * @param DOMElement $data
     * @return void
     **/
    public function setData (\DOMElement $data)
    {
        $this->data = $data;
    }


    /**
     * セミナー登録日を取得する
     *
     * @return string
     **/
    public function getPublishedDate ()
    {
        $published = $this->data->getElementsByTagName('published')->item(0);
        return date('Y-m-d H:i:s', strtotime($published->textContent));
    }


    /**
     * セミナーのタイトルを取得する
     *
     * @return string
     **/
    public function getTitle ()
    {
        $title = $this->data->getElementsByTagName('title')->item(0);
        return $title->textContent;
    }


    /**
     * セミナーの開催日を取得する
     *
     * @return string
     **/
    public function getSchedule ()
    {
        $content_el = $this->data->getElementsByTagName('content')->item(0);
        $content = $content_el->textContent;
        preg_match('/期間:(.*)\n/', $content, $matches);

        return (count($matches) > 0) ? trim($matches[1]): '';
    }


    /**
     * セミナーの開催場所を取得する
     *
     * @return string
     **/
    public function getVenue ()
    {
        $content_el = $this->data->getElementsByTagName('content')->item(0);
        $content = $content_el->textContent;
        preg_match('/場所:(.*)\n/', $content, $matches);

        return (count($matches) > 0) ? trim($matches[1]): '';
    }


    /**
     * セミナーのURLを取得する
     *
     * @return string
     **/
    public function getUrl ()
    {
        $content_el = $this->data->getElementsByTagName('content')->item(0);
        $content = $content_el->textContent;
        preg_match('/予定の説明:(.*)/', $content, $matches);

        return (count($matches) > 0) ? trim($matches[1]): '';
    }
}

