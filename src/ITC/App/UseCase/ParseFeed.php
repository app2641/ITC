<?php


namespace ITC\App\UseCase;

use ITC\App\Entity\Feed,
    ITC\App\Entity\Seminar;

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
     * @var Seminar
     **/
    private $seminar;



    /**
     * @param Feed $feed  フィードクラス
     * @return void
     **/
    public function setFeed (Feed $feed)
    {
        $this->feed = $feed;
    }



    /**
     * @param Seminar $seminar  セミナークラス
     * @return void
     **/
    public function setSeminar ($seminar)
    {
        $this->seminar = $seminar;
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
            if(! $this->seminar->ifRecordExists($entry)) {
                $record = $this->seminar->getRecord();
                $this->seminar->insert($record);
            }
        }


        // 一週間の新着情報を JSON 化して S3 へ保存する
        $one_week  = date('Y-m-d H:i:s', time() - 60 * 60 * 24 * 7);
        $ju = new JsonS3Upload($one_week);
        $ju->setSeminar($this->seminar);
        $result = $ju->execute();

        $whats_new = $this->seminar->query->getAfterDateSeminars($one_week);

        foreach ($whats_new as $seminar) {
        
        }

        return true;
    }
}
