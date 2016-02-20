<?php

/**
 * Class representing applicantion user
 */
class User extends DbEntity{
    
    private $userId = null;
    private $email;
    private $nickname = null;
    private $password;
    private $cellPhone;
    private $name;
    private $surname;
    private $birthday = '0000-00-00';
    
    public function login($password){
        $encr = Database::encryptString($password);
        return $this->password === $encr;
    }
    
    public function update(){
        $query = "UPDATE user
                SET email = ? ,
                    nickname = ? ,
                    password = ? ,
                    cellPhone = ? ,
                    name = ? ,
                    surname = ? ,
                    birthday = ?
                WHERE userId = ?";
        return $this->database->queryFromPreparedStatement($query, 
        		array($this->email, $this->nickname, $this->password, $this->cellPhone, 
        			$this->name, $this->surname, $this->birthday, $this->userId));
    }
    
    public function insert(){
        if($this->userId !== null){
            return false;
        }
        $this->checkNickname();
        $query = "INSERT INTO user(email, nickname, password, cellPhone, name, surname, birthday)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->database->queryFromPreparedStatement($query, 
        		array($this->email, $this->nickname, $this->password, $this->cellPhone, 
        			$this->name, $this->surname, $this->birthday));
    }
            
    public function selectById($idValue) {
        return parent::selectById('userId', $idValue, 'user');
    }
    
    public function selectByEmail($email) {
        return parent::selectById('email', $email, 'user');
    }
    
    public function delete() {
        return parent::delete('userId', $this->userId, 'user');
    }
    
    private function checkNickname(){
        if($this->nickname === null){
            $tmp = explode('@', $this->email);
            $this->nickname = $tmp[0];
        }
    }

    public function setUserId($userId) {$this->userId = $userId;}  
    public function setEmail($email) {$this->email = $email;}
    public function setNickname($nickname) {$this->nickname = $nickname;}
    public function setPassword($password) {$this->password = $password;}
    public function setCellPhone($cellPhone) {$this->cellPhone = $cellPhone;}
    public function setName($name) {$this->name = $name;}
    public function setSurname($surname) {$this->surname = $surname;}
    public function setBirthday($birthday) {$this->birthday = $birthday;}    
    public function getUserId() {return $this->userId;}
    public function getEmail() {return $this->email;}
    public function getNickname() {return $this->email;}
    public function getPassword() {return $this->password;}
    public function getCellPhone() {return $this->cellPhone;}
    public function getName() {return $this->name;}
    public function getSurname() {return $this->surname;}
    public function getBirthday() {return $this->birthday;}   
    
}
