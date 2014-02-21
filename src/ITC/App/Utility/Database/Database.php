<?php


namespace ITC\App\Utility\Database;

class Database extends \PDO
{

    /**
     * コネクション先
     *
     * @var String
     **/
    private $connection;


    // Database drivers that support SAVEPOINTs.
    protected static $savepointTransactions = array("pgsql", "mysql");

    // The current transaction level.
    protected $transLevel = 0;



    /**
     * コネクション先を変数に仕込む
     *
     * @param 
     * @return void
     **/
    public function __construct ($dsn, $user, $password, $connection)
    {
        parent::__construct($dsn, $user, $password);
        $this->connection = $connection;
    }



    /**
     * コネクション名を取得する
     *
     * @return String
     **/
    public function getConnection ()
    {
        return $this->connection;
    }



    protected function nestable() {
        return in_array($this->getAttribute(\PDO::ATTR_DRIVER_NAME),
                        self::$savepointTransactions);
    }

    public function beginTransaction() {
        if(!$this->nestable() || $this->transLevel == 0) {
            parent::beginTransaction();
        } else {
            $this->exec("SAVEPOINT LEVEL{$this->transLevel}");
        }

        $this->transLevel++;
    }

    public function commit() {
        $this->transLevel--;

        if(!$this->nestable() || $this->transLevel == 0) {
            parent::commit();
        } else {
            $this->exec("RELEASE SAVEPOINT LEVEL{$this->transLevel}");
        }
    }

    public function rollBack() {
        $this->transLevel--;

        if(!$this->nestable() || $this->transLevel == 0) {
            parent::rollBack();
        } else {
            $this->exec("ROLLBACK TO SAVEPOINT LEVEL{$this->transLevel}");
        }
    }


    // sql処理の実行
    public function state ($sql, $bind = array())
    {
        // stdclassの場合はarrayにキャスト
        if ($bind instanceof \stdClass) {
            $bind = (array) $bind;
        }

        if (! is_array($bind)) {
            $bind = array($bind);
        }

        // mysql strict mode 対策　STRICT_TRANS_TABLES、STRICT_ALL_TABLES
        // http://dev.mysql.com/doc/refman/5.1/ja/server-sql-mode.html
        // booleanをintに変更
        foreach($bind as $k => $v) {
            if (is_bool($v) === true) {
                $bind[$k] = (int)$v;
            }
        }

        $stmt = $this->prepare($sql);
        $stmt->execute($bind);

        return $stmt;
    }
}
