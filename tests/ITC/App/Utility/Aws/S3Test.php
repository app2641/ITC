<?php


use ITC\App\Utility\Test\TestCase;

use ITC\App\Utility\Aws\S3;

class S3Test extends TestCase
{

    /**
     * @var ITC\App\Utility\Aws\S3
     **/
    private $S3;


    public function setUp ()
    {
        $this->S3 = new S3();
    }



    /**
     * @test
     *
     * @group s3
     */
    public function 単純テスト ()
    {
        $foo = 's3 test';
        $this->assertEquals('s3 test', $foo);
    }



    /**
     * @test
     *
     * @group s3
     * @group s3-upload
     */
    //public function S3アップロードテスト ()
    //{
        //$path = 'resources/json/dummy.json';
        //$body = json_encode(array('val' => 'dummy'));

        //// ダミーデータが残っていたら削除する
        //if ($this->S3->doesObjectExist($path)) {
            //$this->S3->delete($path);
        //}

        //$response = $this->S3->upload($path, $body);
        //$this->assertTrue($response);

        //// S3に生成できていたら削除する
        //if ($this->S3->doesObjectExist($path)) {
            //$this->S3->delete($path);
        //}
    //}



    /**
     * @test
     * @group s3
     * @group s3-download
     */
    //public function S3ダウンロードテスト ()
    //{
        //$path = 'resources/json/dummy.json';
        //$body = json_encode(array('val' => 'dummy'));

        //// ダミーデータが残っていたら削除する
        //if (! $this->S3->doesObjectExist($path)) {
            //$this->S3->upload($path, $body);
        //}

        //$response = $this->S3->download($path);
        //$this->assertTrue(isset($response['Body']));

        //// S3に生成できていたら削除する
        //if ($this->S3->doesObjectExist($path)) {
            //$this->S3->delete($path);
        //}
    //}
}
    
