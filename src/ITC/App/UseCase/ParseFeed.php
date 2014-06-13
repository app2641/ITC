<?php


namespace ITC\App\UseCase;

use ITC\App\UseCase\JsonS3Upload;

use ITC\App\Entity\Feed,
    ITC\App\Entity\Entry;

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
     * ユースケースクラス
     *
     * @var JsonS3Upload
     **/
    private $ju;


    /**
     * 開始日
     *
     * @var string
     **/
    private $begin_data;



    /**
     * @param Feed $feed  フィードクラス
     * @return void
     **/
    public function setFeed (Feed $feed)
    {
        $this->feed = $feed;
    }



    /**
     * @param Entry $entry 
     * @return void
     **/
    public function setEntry ($entry)
    {
        $this->entry = $entry;
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
     * @param  string $date
     * @return void
     **/
    public function setBeginDate ($date)
    {
        $this->begin_date = $date;
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

            // 新しく登録されたセミナーを取得する
            $entry_data = array();
            foreach ($entries as $entry) {
                $this->entry->setData($entry);
                $published = $this->entry->getPublishedDate();

                if ($published >= $this->begin_date) {
                    $entry_data[] = array(
                        'title' => $this->entry->getTitle(),
                        'url'   => $this->entry->getUrl(),
                        'date' => $this->entry->getSchedule(),
                        'venue' => $this->entry->getVenue()
                    );
                }
            }


            // 新着情報を JSON 化して S3 へ保存する
            $this->ju->setData($entry_data);
            $this->ju->setS3(new S3());
            $this->ju->execute();

        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }
}
