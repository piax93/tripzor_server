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
                    name = ?, 
                    nPart = ?, 
                    place = ?, 
                    startDate = ?, 
                    endDate = ?, 
                    userId = ?
                  WHERE tripId = ?";        
        return $this->database->queryFromPreparedStatement($query, 
        		array($this->name, $this->nPart, $this->place, $this->startDate, 
        				$this->endDate, $this->userId, $this->tripId));
    }
    
    public function insert() {
        if($this->tripId !== null) return false;
        $query = "INSERT INTO trip(name, nPart, place, startDate, endDate, userId) VALUES (?, ?, ?, ?, ?, ?)";
        return $this->database->queryFromPreparedStatement($query, 
        		array($this->name, $this->nPart, $this->place, $this->startDate, 
        				$this->endDate, $this->userId));        
    }
    
    public function delete() {
        return parent::delete('tripId', $this->tripId, 'trip');
    }
    
	public function isOwned($userId) {
		return $userId == $this->userId;
	}
    
    public function selectById($idValue) {
        return parent::selectById('tripId', $idValue, 'trip');
    }
    
    public function asArray(){
    	$res = array('tripid' => $this->tripId, 'name' => $this->name, 'place' => $this->place,
    			'start' => $this->startDate, 'end' => $this->endDate, 
    			'participants' => $this->getParticipants() );
    	return $res;
    }
    
    public function getParticipants(){
    	$tmp = $this->database->execSelectQuery('userId', 'participant', array('tripId' => $this->tripId));
    	$res = array($this->userId);
    	if(is_array($tmp)) foreach ($tmp as $u) array_push($res, $u['userId']);
    	return $res;
    }
    
    public function addParticipant($userId){
    	$query = 'INSERT INTO participant VALUES (?, ?)';
    	$this->nPart++;
    	return $this->database->queryFromPreparedStatement($query, array($userId, $this->tripId), false, true) 
    			&& $this->update();
    }
    
    public function removeParticipant($userId) {
    	$query = 'DELETE FROM participant WHERE userId = ? AND tripId = ?';
    	$this->nPart--;
    	return $this->database->queryFromPreparedStatement($query, array($userId, $this->tripId), false, true) 
    			&& $this->update();
    }
    
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
