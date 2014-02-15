<?php


namespace ITC\App\Entity;

class Feed
{

    /**
     * 解析するFeedのURL
     *
     * @var String
     **/
    private $url = 'http://tinyurl.com/itcal';



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
        
        } catch (\Exception $e) {
            throw $e;
        }
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
            var_dump($feed);
            exit();
        
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
