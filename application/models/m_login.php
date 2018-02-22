<?php
class m_login extends CI_Model{
    
	function __construct(){
		parent::__construct();
	}
	
	function validate($loginId, $password)
	{
			$sql = "SELECT 
					login.id AS loginId, 
					users.id AS userId, 
					login.role AS role,
					users.id AS id, 
					users.first_name AS firstName,
					
					users.last_name AS lastName, 
					users.mobile_number AS mobileNumber, 
					users.image_id AS imageId  
				FROM 
					login AS login, 
					user_data AS users 
				WHERE 
					login.id = '$loginId' AND 
					login.password = '$password' AND 
					login.status = 'ACTIVE' AND 
					users.user_id = '$loginId'";

		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function insertLoginHistory($sessionId, $loginId, $channel)
	{
		//check if the session already exists and then insert a record if one doesnt exist
		
		$sql = "SELECT 
					session_id  
				FROM 
					login_history
				WHERE 
					session_id = '$sessionId'";
		
		$query = $this->db->query($sql);
		
		if(sizeof($query->result()) == 1){
			//session already exists
			return;
		}else{
			$sql = "INSERT INTO 
					login_history(session_id,login_id,login_time,channel,created_by,created_on) 
				VALUES 
					('$sessionId','$loginId',now(),'$channel','$loginId',now())";
			$query = $this->db->query($sql);
			$loginHistoryId = $this->db->insert_id();
			
			return $loginHistoryId;
		}
	}
	
	function updateLogoutHistory($sessionId, $loginId)
	{
		$sql = "UPDATE
					login_history
				SET
					logout_time=now()
					
				WHERE
					session_id = '$sessionId'";
		
		$query = $this->db->query($sql);
		$affectedRows = mysql_affected_rows();
		
		return $affectedRows;
	}

	function validateQR($code)
	{
		$sql = "SELECT
		qrtable.id AS loginId
		FROM
		qrtable AS qrtable
		WHERE
		qrtable.code ='$code'";
	
		$query = $this->db->query($sql);
	
		return $query->result();
	}
	function validateuser($userID)
	{
		$sql = "SELECT
			login.id AS loginId,
			users.id AS userId,
			login.role AS role,
			users.id AS id,
			users.first_name AS firstName,
				
			users.last_name AS lastName,
			users.mobile_number AS mobileNumber,
			users.image_id AS imageId
			FROM
			login AS login,
			user_data AS users
			WHERE
			login.id = '$userID' AND
			login.status = 'ACTIVE' AND
			users.user_id = '$userID'";
			
			$query = $this->db->query($sql);
	
		return $query->result();
	}
}