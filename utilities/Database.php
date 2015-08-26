<?php

/**
 * Connection to database (singleton)
 */
class Database {
    
    private static $database = null;
    
    private $connection;
    
    private function __construct() {
        include 'values/DBcredentials.php';
        $this->connection = mysqli_connect($address, $user, $password, $databaseName);
        if ($this->connection === FALSE) {
            die('Error connecting to DB');
        }
    }
    
    /**
     * Get an instance of the database object
     * @return Database
     */
    public static function getDbInstance(){
        if(self::$database === NULL){
            self::$database = new Database();
        }
        return self::$database;
    }
    
    /**
     * Executes a query
     * @param string $query Query to execute
     * @param bool $hasResult Does the query return anything ?
     * @param bool $waitToCommit To perform transactions
     * @return mixed An array of associative arrays representing selected rows, false in case of failure, 
     *      true in case of success with nothing to return
     */
    public function execQuery($query, $hasResult = true, $waitToCommit = false){
        mysqli_autocommit($this->connection, false);
        mysqli_begin_transaction($this->connection);
        $result = mysqli_query($this->connection, $query);
        
	ob_start();
	var_dump($this);
	$sqlLog = ob_get_clean();
	ob_end_clean();
	file_put_contents('SQL.log', $sqlLog, FILE_APPEND);

	if($result !== false){
            if(!$waitToCommit){
                mysqli_commit($this->connection);
                mysqli_autocommit($this->connection, true);
            }
        }else{
            mysqli_rollback($this->connection);
            mysqli_autocommit($this->connection, true);
        }
        if($hasResult){
            $returnArray = array(); $i = 0;
            if($result !== NULL){
                while($returnArray[$i] = mysqli_fetch_assoc($result)) {
                    $i++;
                }
                array_pop($returnArray);
                if(count($returnArray) != 0){
                    return $returnArray;
                }
            }
	}else{
            return $result;
	}
        return false;
    }
    
    /**
     * Build and execute a select query
     * @param array $fields Fields to select
     * @param string $table Table to query
     * @param string $where Where conditions
     */
    public function execSelectQuery($fields, $table, $where = ''){
        if(is_array($fields)){
            $select = implode(', ', $fields);
        }else{
            $select = $fields;
        }        
        $query = 'SELECT ' . $select .
                ' FROM ' . $table;
        $query .= $where === '' ? '' : ' WHERE ' . $where;
        return $this->execQuery($query);
    }
    
}
