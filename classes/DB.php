<?php

class DB
{
    protected static $_instance;
    private const fileSetting = 'db';
    private static $pbo;
    private const INT = 'integer';
    private const STRING = 'varchar';

    private static $tableCache = [];

    static function fetch($result){
        $data = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
        }
        return $data;
    }

    public static function getModel($tableName){
        $result = self::$pbo->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='aspro'  AND `TABLE_NAME`='$tableName';");
        $result = self::fetch($result);
        $columns = [];

        for($i = 1; $i < count($result); $i++){
            $columns[] = $result[$i]['COLUMN_NAME'];
        }
        return $columns;
    }

    public static function getModelId($tableName, $id){
        $result = self::$pbo->query("SELECT * FROM $tableName WHERE id=$id");
        return self::fetch($result);
    }

    public static function tableExists($nameTable)
    {
        if(self::$tableCache[$nameTable]){
            return true;
        }
        else{
            $result = self::$pbo->query("SELECT 1 FROM $nameTable LIMIT 1");
            if ($result) {
                self::$tableCache[$nameTable] = true;
                return true;
            } else {
                return false;
            }
        }
    }

    public static function updateModel($table_name, $property, $id){
        $sql = "UPDATE $table_name
                    SET $property
                    WHERE id = $id;";
        echo $sql;
        $result = self::$pbo->exec($sql);
    }

    public function insert($nameTable, $data)
    {
        if($this->tableExists($nameTable)){
            $sql = "INSERT INTO $nameTable VALUES ($data)";
            self::$pbo->exec($sql);
            $id = self::$pbo->lastInsertId();
            return $id;
        }
        else{
            return false;
        }
    }

    public static function createTable($nameTable, $columns, $primaryKey = '')
    {
            $sql = "create table $nameTable
        (
            $primaryKey 
            $columns
        );";

        self::$pbo->exec($sql);
    }

    protected function connectToDB()
    {
        $pass = Config::getSetting(self::fileSetting,'PASSWORD');
        $user = Config::getSetting(self::fileSetting,'LOGIN', );
        $db = Config::getSetting(self::fileSetting,'DB', );
        $host = Config::getSetting(self::fileSetting,'HOST', );
        $type = Config::getSetting(self::fileSetting,'TYPE', );
        
        try {
            self::$pbo = new PDO($type.':host='.$host.';dbname='.$db, $user, $pass);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    protected function __construct()
    {
        $this->connectToDB();}

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