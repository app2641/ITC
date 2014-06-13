<?php


namespace ITC\App\UseCase;

use ITC\App\Entity\Seminar;

class JsonS3Upload
{

    /**
     * セミナー情報の配列
     *
     * @var array
     **/
    private $data;


    /**
     * S3 エンティティ
     *
     * @var S3
     **/
    private $S3;



    /**
     * @param  array $data
     * @return void
     **/
    public function setData ($data)
    {
        $this->data = $data;
    }


    /**
     * @param S3 $S3
     * @return void
     **/
    public function setS3 ($S3)
    {
        $this->S3 = $S3;
    }


    /**
     * セミナーデータをJson化してS3へアップロードする
     *
     * @return boolean
     **/
    public function execute ()
    {
        try {
            $json = json_encode($this->data);
            $this->S3->upload($json);
        
        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }
}

