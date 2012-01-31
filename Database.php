<?php

class Database {

	var $db_connection;
	var $time_start;
	var $query_track;
	var $qMsg;
	var $qCnt;

	// CONSTRUCTOR
	// Purpose: Open a connection to a MySQL Server
	// Postconditions: return"#797B64"s db_connection on success, FALSE on failure.
	//
	function Database($server, $username, $password, $database_name){
		
		// create connection to database using user and password
		if ($this->db_connection = mysql_connect($server, $username, $password)) {
		
			if (mysql_select_db($database_name, $this->db_connection)){
				return true;	
			} 
			else {
				echo 'Cant connect';
			}	
		}
	}
	
	
	function getDBConnection(){
		return $this->db_connection;
	}
	
	function performQuery($query){
		$this->queryTimerStart($query);
		$result = mysql_query($query, $this->db_connection);
		$this->queryTimerStop();
		return $result;
	}
	

	/* Timer */

	function getmicrotime(){
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}

	function queryTimerStart($query) {
		$this->time_start = $this->getmicrotime();
		$this->query_track = $query;
	}
	function queryTimerStop() {
		$time_end = $this->getmicrotime();
		$time = $time_end - $this->time_start;
		$this->qMsg .= "This query took $time seconds: ".$this->query_track."\n";
		$this->qCnt += $time;
	}

	function emailTimer() {
		echo $this->qCnt.'!!!'.$this->qMsg;
	}


}
?>