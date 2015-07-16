<?php

class Trip extends DbEntity {
    
    private $tripId = null;
    private $name;
    private $nPart = 0;
    private $place;
    private $startDate;
    private $endDate;
    private $userId; //creator
    
    public function update(){
        $query = "UPDATE trip SET
                    name = '$this->name', nPart = $this->nPart, 
                    place = '$this->place', startDate = '$this->startDate', 
                    endDate = '$this->endDate', userId = '$this->userId'
                  WHERE tripId = $this->tripId";
        return $this->database->execQuery($query, false);
    }
    
    public function insert() {
        if($this->tripId !== null) return false;
        $query = "INSERT INTO trip(name, nPart, place, startDate, endDate, userId)
                    VALUES ('$this->name', $this->nPart, '$this->place', '$this->startDate', '$this->endDate', $this->userId)";
        return $this->database->execQuery($query, false);        
    }
    
    public function delete() {
        return parent::delete('tripId', $this->tripId, 'trip');
    }
    
    public function selectById($idValue) {
        return parent::selectById('tripId', $idValue, 'trip');
    }
    
    public function addParticipant(){$this->nPart++;}
    public function setTripId($tripId) {$this->tripId = $tripId;}
    public function setName($name) {$this->name = $name;}
    public function setNPart($nPart) {$this->nPart = $nPart;}
    public function setPlace($place) {$this->place = $place;}
    public function setStartDate($startDate) {$this->startDate = $startDate;}
    public function setEndDate($endDate) {$this->endDate = $endDate;}
    public function setUserId($userId) {$this->userId = $userId;}
    public function getTripId() {return $this->tripId;}
    public function getName() {return $this->name;}
    public function getNPart() {return $this->nPart;}
    public function getPlace() {return $this->place;}
    public function getStartDate() {return $this->startDate;}
    public function getEndDate() {return $this->endDate;}
    public function getUserId() {return $this->userId;}
    
}
