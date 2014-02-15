<?php


namespace ITC\App\UseCase;

use ITC\App\Entity\Feed;

class ParseFeed
{

    /**
     * @var Feed
     **/
    private $feed;


    /**
     * @param Feed  $feed
     * @return void
     **/
    public function setFeed (Feed $feed)
    {
        $this->feed = $feed;
    }



    /**
     * フィード解析処理の実行
     *
     * @return void
     **/
    public function execute ()
    {
        // Feed から新着情報を取得する
        $whats_new = $this->feed->parse();


        // 重複を調べて DB へ新着情報を登録する
        //foreach ($whats_new as $data) {
            //$this->seminer->save($data);
        //}


        // 新着情報を JSON 化して S3 へ保存する

        return true;
    }
}
