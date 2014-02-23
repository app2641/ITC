<?php


namespace ITC\App\UseCase;

use ITC\App\Entity\Feed,
    ITC\App\Entity\Seminer;

class ParseFeed
{

    /**
     * フィードクラス
     *
     * @var Feed
     **/
    private $feed;



    /**
     * セミナークラス
     *
     * @var Seminer
     **/
    private $seminer;



    /**
     * @param Feed $feed  フィードクラス
     * @return void
     **/
    public function setFeed (Feed $feed)
    {
        $this->feed = $feed;
    }



    /**
     * @param Seminer $seminer  セミナークラス
     * @return void
     **/
    public function setSeminer ($seminer)
    {
        $this->seminer = $seminer;
    }



    /**
     * フィード解析処理の実行
     *
     * @return void
     **/
    public function execute ()
    {
        // Feed から新着情報を取得する
        $entries = $this->feed->parse();


        // 重複を調べて DB へ新着情報を登録する
        foreach ($entries as $entry) {
            if(! $this->seminer->ifRecordExists($entry)) {
                $record = $this->seminer->getRecord();
                $this->seminer->insert($record);
            }
        }


        // 新着情報を JSON 化して S3 へ保存する

        return true;
    }
}
