<?php

class DB extends Config
{
    protected static $_instance;
    private const fileSetting = 'db';
    private static $dbh;
    private const INT = 'integer';
    private const STRING = 'varchar';
    private const ID = 'id integer auto_increment primary key';

    private function tableExists($nameTable)
    {
        try {
            $result = self::$dbh->query("SELECT 1 FROM $nameTable LIMIT 1");
        } catch (Exception $e) {
            return FALSE;
        }
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function insert($nameTable, $data)
    {
        if($this->tableExists($nameTable)){
            $data = implode(',', $data);
            $sql = "INSERT INTO products (name, price) VALUES ($data)";
            self::$dbh->exec($sql);
            $id = self::$dbh->lastInsertId();
            return $id;
        }
        else{
            return false;
        }
    }

    public function select($nameTable){
        $sql = "SELECT * FROM $nameTable WHERE price > 500";
        $result = self::$dbh->query($sql);
        $data = [];
        while($row = $result->fetch()){
            $data[] = $row;
        }
    }

    public function createTable($nameTable)
    {
        $sql = 'create table ' . $nameTable . '
        (
            ' . self::ID . ', 
            name ' . self::STRING . '(30),
            price ' . self::INT . '
        );';
        self::$dbh->exec($sql);
    }

    protected function connectToDB()
    {
        $pass = $this->getSetting('PASSWORD', self::fileSetting);
        $user = $this->getSetting('LOGIN', self::fileSetting);
        $db = $this->getSetting('DB', self::fileSetting);
        $host = $this->getSetting('HOST', self::fileSetting);
        $type = $this->getSetting('TYPE', self::fileSetting);
        
        try {
            self::$dbh = new PDO($type.':host='.$host.';dbname='.$db, $user, $pass);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    protected function __construct()
    {
        $this->connectToDB();
        //$this->createTable("Products");
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }
}