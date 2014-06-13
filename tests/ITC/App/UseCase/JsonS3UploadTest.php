<?php


use ITC\App\UseCase\JsonS3Upload;

class JsonS3UploadTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var S3
     **/
    private $S3;


    public function setUp ()
    {
        parent::setUp();

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
        $data = array(array(
            'title' => 'foo',
            'url' => 'https://google.com',
            'date' => '2014-04-04',
            'venue' => 'bar'
        ));


        $ju = new JsonS3Upload();
        $ju->setData($data);
        $ju->setS3($this->S3);

        $result = $ju->execute();
        $this->assertTrue($result);
    }
}

