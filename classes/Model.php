<?php

class Model extends DB
{
    protected $table;

    protected $primaryKey = 'id';
    protected $keyType = 'INT';
    protected $loaded = false;

    protected $incrementing = true;

    protected const INCREMENT = 'INT AUTO_INCREMENT primary key';
    protected $id = 'id';

    private const INT = 'INT';
    private const STRING = 'VARCHAR';

    protected $idModel;

    public $properties = [];
    protected $table_name;
    protected $table_columns = [];

    private $stringColumns;
    private $stringProperty;

    public function set($data){
        $this->properties = $data;
    }

    public function setStringColums(){
        foreach ($this->table_columns as $key => $value){
            $this->stringColumns .= $key.' '. $value .',';
        }
        var_dump($this->stringColumns);
        $this->stringColumns = substr($this->stringColumns,0,-1);
    }

    protected function setStringProperty(){
        array_shift($this->properties);
        foreach ($this->properties as $key => $value){
            $this->stringProperty .= $key.' = '. "'$value'" .',';
        }
        $this->stringProperty = substr($this->stringProperty,0,-1);
    }

    function update(){
        $this->setStringProperty();
        self::updateModel($this->table_name, $this->stringProperty, $this->idModel);
    }

    function create(){
        $this->loaded = true;
        $this->idModel = $this->insert($this->table_name, $this->stringProperty);
    }

    function save(){
        if($this->loaded == true){
            $this->update();
        }
        else{
            $this->create();
        }
    }

    function __set($name, $val) {
        if(array_key_exists($name, $this->table_columns)){
            $this->properties[$name] = $val;
        }
    }

    function __get($name) {
        if(isset($this->properties[$name])){
            return $this->properties[$name];
        }
    }

    function checkTable($table_name){
        if(DB::tableExists($table_name) == false){
            $this->table_columns = static::COLUMNS;
            $this->setStringColums();
            $primaryKey = $this->id .' '. self::INCREMENT .',';
            $this->createTable($table_name, $this->stringColumns, $primaryKey);
            return false;
        }
        return true;
    }

    function __construct($table_name, $id = null) {
        $this->table_name = static::TABLE;
        $check = $this->checkTable($table_name);

        // Если таблица только - что создана, получать запись не имеет смысла
        if(isset($id) && $check == true){
            $this->loaded = true;
            $this->idModel = $id;
            $this->properties = DB::getModelId($table_name, $id);
        }
        else{
            $this->properties = DB::getModel($table_name);
        }
    }
}