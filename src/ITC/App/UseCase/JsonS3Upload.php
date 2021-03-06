<?php


namespace ITC\App\UseCase;

use ITC\App\Entity\Seminar;

class JsonS3Upload
{

    /**
     * 指定日
     *
     * @var String
     **/
    private $date;



    /**
     * Seminar エンティティ
     *
     * @var Seminar
     **/
    private $seminar;



    /**
     * S3 エンティティ
     *
     * @var S3
     **/
    private $S3;



    /**
     * 指定日セッター
     *
     * @param String $date  指定日
     * @return void
     **/
    public function setDate ($date)
    {
        $this->date = $date;
    }



    /**
     * Seminarセッター
     *
     * @param Seminar $seminar  エンティティ
     * @return void
     **/
    public function setSeminar (Seminar $seminar)
    {
        $this->seminar = $seminar;
    }



    /**
     * S3 セッター
     *
     * @param S3 $S3  エンティティ
     * @return void
     **/
    public function setS3 ($S3)
    {
        $this->S3 = $S3;
    }



    /**
     * 指定日以降のセミナーデータをJson化してS3へアップロードする
     *
     * @param String $date  指定日
     * @return boolean
     **/
    public function execute ()
    {
        try {
            // 指定日以降のセミナー情報を取得してJSON化する
            $whats_new = $this->seminar->query->getAfterDateSeminars($this->date);
            $data = array();

            foreach ($whats_new as $seminar) {
                $data[] = array(
                    'title' => $seminar->title,
                    'url' => $seminar->url,
                    'date' => $seminar->date,
                    'venue' => $seminar->venue
                );
            }
            $json = json_encode($data);

            // S3へ保存する
            $this->S3->upload($json);
        
        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }
}

