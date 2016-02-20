<?php

/**
 * Connection to database (singleton)
 */
class Database {
    
    private static $database = null;
    
    private $connection;
    
    private function __construct() {
        include 'values/DBcredentials.php';
        $this->connection = new mysqli($address, $user, $password, $databaseName);
        if ($this->connection->connect_error) {
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
    	$this->connection->autocommit(false);
        // mysqli_begin_transaction($this->connection);
        $result = $this->connection->query($query);
        
		ob_start();
		var_dump($this);
		$sqlLog = ob_get_contents();
		ob_end_clean();
		file_put_contents('SQL.log', $sqlLog . PHP_EOL . PHP_EOL, FILE_APPEND);
	
		if($result !== false){
            if(!$waitToCommit){
                $this->connection->commit();
                $this->connection->autocommit(true);
            }
        }else{
            $this->connection->rollback();
            $this->connection->autocommit(true);
        }
        if($hasResult){
            $returnArray = array(); $i = 0;
            if($result !== NULL){
                while($returnArray[$i] = $result->fetch_assoc()) {
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
    
    /**
     * @param string $query
     * @param array $fields
     */
    public function prepareStatement($query, $fields){
    	if(!is_arr)
 		
    	$stm = $this->connection->prepare($query);
    }
	
	/**
	 * Encrypts string using a very secret salt u.u
	 * @param string $string String to encrypt
	 */
	public static function encryptString($string){
		require 'values/salt.php';
		return crypt($string, $salt);
	}
	
	
	public static function sessionEncrypt($string){
		require 'values/salt.php';	
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($salt), 
				$string, MCRYPT_MODE_CBC, md5(md5($salt))));
	}	
	
	public static function sessionDecrypt($encrypted){
		require 'values/salt.php';
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($salt), base64_decode($encrypted), 
				MCRYPT_MODE_CBC, md5(md5($salt))), "\0");			
	}
    
}
