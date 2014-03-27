<?php


namespace ITC\App\Utility\Aws;

use Aws\S3\S3Client;
use Aws\Common\Enum\Region;
use Guzzle\Http\EntityBody;

class S3
{


    /**
     * @var S3Client
     **/
    private $client;


    
    /**
     * S3バケット名
     *
     * @var String
     **/
    public $bucket;



    /**
     * JSONを保存するパス
     *
     * @var String
     **/
    public $json_path;



    /**
     * aws.ini へのパス
     *
     * @var String
     **/
    private $aws_ini_path = 'data/config/aws.ini';



    /**
     * コンストラクタ
     *
     * @return void
     **/
    public function __construct ()
    {
        // AWSクライアントの設定
        $ini = parse_ini_file(ROOT_PATH.'/'.$this->aws_ini_path);

        // メンバ変数の設定
        $this->bucket = $ini['bucket'];
        $this->json_path = $ini['json_path'];

        $this->client = S3Client::factory(
            array(
                'key' => $ini['key'],
                'secret' => $ini['secret'],
                'region' => Region::AP_NORTHEAST_1
            )
        );
    }



    /**
     * 指定パスのファイルがS3に存在するかどうか
     *
     * @param String $path  ファイルパス
     * @return boolean
     **/
    public function doesObjectExist ($path)
    {
        return $this->client->doesObjectExist($this->bucket, $path);
    }



    /**
     * 指定パスのファイルをダウンロードする
     *
     * @param String $path  S3のパス
     * @return Guzzle\Service\Resource\Model
     **/
    public function download ($path)
    {
        try {
            $response = $this->client->getObject(array(
                'Bucket' => $this->bucket,
                'Key' => $path
            ));
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $response;
    }



    /**
     * 指定パスにファイルをアップロードする
     *
     * @param String $body  ファイル内容
     * @return void
     **/
    public function upload ($body)
    {
        try {
            $this->client->putObject(array(
                'Bucket' => $this->bucket,
                'Key'  => $this->json_path,
                'Body' => $body
            ));

        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }



    /**
     * 指定パスのファイルを削除する
     *
     * @param String $path  S3のパス
     * @return boolean
     **/
    public function delete ($path)
    {
        try {
            $this->client->deleteObject(array(
                'Bucket' => $this->bucket,
                'Key' => $path
            ));
        
        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }
}

