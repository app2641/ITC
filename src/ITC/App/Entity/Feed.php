<?php


namespace ITC\App\Entity;

class Feed
{

    /**
     * 解析するFeedのURL
     *
     * @var String
     **/
    private $url = 'http://www.google.com/calendar/feeds/fvijvohm91uifvd9hratehf65k%40group.calendar.google.com/public/basic';



    /**
     * FeedのXMLを格納するDOMDocument
     *
     * @var DOMDocument
     **/
    private $dom;



    /**
     * IT勉強会フィードを解析して情報を取得する
     *
     * @return array
     **/
    public function parse ()
    {
        try {
            // DOMを取得する
            $this->dom = $this->getDom();

            // DOMを解析して勉強会データを取得する
            $entries = $this->getEntryData();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $entries;
    }



    /**
     * FeedをDOMDocumentに格納する
     *
     * @return DOMDocument
     **/
    public function getDom ()
    {
        try {
            $feed = file_get_contents($this->url);
            $dom  = new \DOMDocument('1.0', 'UTF-8');
            $dom->loadXML($feed);

        } catch (\Exception $e) {
            throw $e;
        }

        return $dom;
    }



    /**
     * DOMからentry要素データを取得する
     *
     * @return array
     **/
    public function getEntryData ()
    {
        $entries = $this->dom->getElementsByTagName('entry');
        return $entries;
    }
}
