<?php


namespace ITC\App\Utility\Test;

use ITC\App\Utility\Registry;
use ITC\App\Utility\Database\Helper;

class TestCase extends \PHPUnit_Extensions_Database_TestCase
{


    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     **/
    public function getConnection ()
    {
        try {
            if (! Registry::getInstance()->ifKeyExists('db')) {
                $db = Helper::connection('test');

                // RegistryへDatabaseを登録する
                Registry::set('db', $db);

            } else {
                $db = Registry::get('db');
            }

        } catch (\PDOException $e) {
            $msg = $e->getMessage().PHP_EOL.PHP_EOL;

            $msg .= 'データベースのテストにはテスト用DBが必要です！'.PHP_EOL;
            $msg .= 'data/fixture/tests_schema.dbからデータベースを作成してください！';

            throw new \Exception($msg);
        }

        return $this->createDefaultDBConnection($db);
    }



    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet ()
    {
        $ds = $this->createFlatXmlDataSet(ROOT_PATH.'/data/fixture/dummy_data.xml');
        $rds = new \PHPUnit_Extensions_Database_DataSet_ReplacementDataSet($ds);
        $rds->addFullReplacement('##null##', null);

        return $rds;
    }
}

