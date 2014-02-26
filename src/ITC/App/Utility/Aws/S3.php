<?php


namespace ITC\App\Entity\Aws;

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
    private $bucket = 'app2641.com';



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
        var_dump(ROOT);
        exit();
        // AWSクライアントの設定
        $ini = parse_ini_file(ROOT.'/'.$this->aws_ini_path);

        $this->client = S3Client::factory(
            array(
                'key' => $ini['key'],
                'secret' => $ini['secret'],
                'region' => Region::AP_NORTHEAST_1
            )
        );
    }
}

