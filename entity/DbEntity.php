<?php

/**
 * General database entity
 */
class DbEntity {

    protected $database;

    public function __construct() {
        $this->database = Database::getDbInstance();
    }

    public function fillByAssoc($array) {
        foreach ($array as $key => $value) {
            $method = 'set' . ucfirst($key);
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

    public function selectById($idName, $idValue, $tableName){
        if($idValue == '') return false;
        $res = $this->database->execSelectQuery('*', $tableName, array($idName => $idValue));
        if($res !== false){
            $this->fillByAssoc($res[0]);
            return true;
        }
        return false;
    }

    public function delete($idName, $idValue, $tableName){
        $query = "DELETE FROM $tableName WHERE $idName = ?";
        return $this->database->queryFromPreparedStatement($query, array($idValue));
    }

}
