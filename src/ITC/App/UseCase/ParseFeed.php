<?php


namespace ITC\App\UseCase;

use ITC\App\UseCase\JsonS3Upload;

use ITC\App\Entity\Feed,
    ITC\App\Entity\Seminar;

use ITC\App\Utility\Aws\S3;

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
     * ユースケースクラス
     *
     * @var JsonS3Upload
     **/
    private $ju;



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
     * @param JsonS3Upload $ju  ユースケースクラス
     * @return void
     **/
    public function setJsonS3Upload ($ju)
    {
        $this->ju = $ju;
    }



    /**
     * フィード解析処理の実行
     *
     * @return void
     **/
    public function execute ()
    {
        try {
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
            $this->ju->setSeminar($this->seminar);
            $this->ju->setDate($one_week);
            $this->ju->setS3(new S3());
            $this->ju->execute();

        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }
}
