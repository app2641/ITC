<?php


use ITC\App\Utility\Test\TestCase;

use ITC\App\UseCase\JsonS3Upload;

class JsonS3UploadTest extends TestCase
{

    /**
     * @var Seminar
     **/
    private $seminar;


    /**
     * @var S3
     **/
    private $S3;


    public function setUp ()
    {
        parent::setUp();

        $this->seminar = $this->getMock('ITC\App\Entity\Seminar');
        
        $S3 = $this->getMock('ITC\App\Utility\Aws\S3');
        $S3->expects($this->any())
            ->method('upload')
            ->will($this->returnValue(true));
        $this->S3 = $S3;
    }



    /**
     * @test
     * @group json
     */
    public function 指定日以降のセミナーデータをS3保存する ()
    {
        $ju = new JsonS3Upload();
        $ju->setDate('2014-02-19');
        $ju->setSeminar($this->seminar);
        $ju->setS3($this->S3);

        $result = $ju->execute();
        $this->assertTrue($result);
    }
}

