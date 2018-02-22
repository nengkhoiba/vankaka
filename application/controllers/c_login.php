<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_login extends CI_Controller {

	
public function index()
	{
		$this->login();
	}
	
	public function __construct()
    {
    	parent::__construct();
    	$this->load->model('m_login', 'validate');
    	$this->output->set_content_type('application/json');
    }
	
 
	public function login()
	{
		if ((isset($_GET['loginId'])) && (!empty($_GET['loginId'])))
		{
			if ((isset($_GET['password'])) && (!empty($_GET['password'])))
			{
				$loginId = $_GET['loginId'];
				$password = $_GET['password'];
				
				$sessionId = $this->session->userdata('session_id');
				
				$channel = "UNKNOWN";
				if ((isset($_GET['channel'])) && (!empty($_GET['channel'])))
				{
	    			$channel = $_GET['channel'];
				}
		
				$result = $this->validate->validate($loginId, $password);
				
				if(sizeof($result) == 1){
					
					$role=$result[0]->role;
					$id=$result[0]->id;
					$firstName=$result[0]->firstName;
					
					$this->session->set_userdata('loginStatus', true);
					$this->session->set_userdata('loginId', $loginId);
					$this->session->set_userdata('role', $role);
					$this->session->set_userdata('firstName', $firstName);
					$channel = "UNKNOWN";
				$sql = "SELECT 
						users.id AS id,
					users.registration_id AS registration_id 
					
				FROM 
					login AS login, 
					user_data AS users 
				WHERE 
					login.id = users.user_id AND 
					
					login.role = 'ADMIN'
						ORDER BY  users.id ASC
					LIMIT 1";
				$query = $this->db->query($sql);
					
				if($query){
					while($result=mysql_fetch_array($query->result_id)){
						$registration_id=$result['registration_id'];
						$this->session->set_userdata('registration_id', $registration_id);
					}
					
				}
					//insert login history
					$this->validate->insertLoginHistory($sessionId, $loginId, $channel);
					
					//setting response
					$outputData = array(
						"authenticationStatus" => "valid",
						"channel" => $channel,
						"user" => $firstName,
							"user_id" => $loginId,
						"role" => $role,
							"id"=>$id
					);
					
					$this->output->set_output(json_encode($outputData));
				}
				else{
					//login failure
					$this->session->sess_destroy();
					$this->output->set_output(json_encode(array("authenticationStatus" => "invalid")));	
				}
			}else {
				$this->output->set_output(json_encode(array("error" => "Password is missing")));
				return;
			}
		}else {
			$this->output->set_output(json_encode(array("error" => "Login id is missing")));
			return;
		}
		
	}
	
	
	function logOut(){
		
		$sessionId = $this->session->userdata('session_id');
		$loginId = $this->session->userdata('loginId');
		
		if(!empty($sessionId)){
			if($this->validate->updateLogoutHistory($sessionId, $loginId) > 0){
				$this->session->sess_destroy();
				$this->output->set_output(json_encode(array("logOutStatus" => "success", "logOutMessage" => "Successfully Logged Out")));
				$this->session->set_userdata('role', "LOGOUT");
				redirect("home");
				return;
			}
		}
		
		$this->output->set_output(json_encode(array("logOutStatus" => "success", "logOutMessage" => "Already Logged Out")));
		redirect("home");
	}
	function QRload(){
		$code = $_GET['code'];
		$sql = "UPDATE
		qrtable set code='$code' WHERE id=1";
		
		$query = $this->db->query($sql);
		if($query)
		{
			$this->output->set_output(json_encode(array("status" => "success")));
		}
	}
	function QRcheck(){
		
		$sql = "UPDATE
		qrtable set code='$code' WHERE id=1";
	
		$query = $this->db->query($sql);
		if($query)
		{
			$this->output->set_output(json_encode(array("status" => "success")));
		}
	}
	
	function qrlogin()
	{
		while (1)
		{
		$sql = "SELECT userId,flag FROM
		qrtable WHERE flag=1";
		
		$query = $this->db->query($sql);
		
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
			$userId=$result['userId'];
			$result = $this->validate->validateuser($userId);
			$role=$result[0]->role;
			$id=$result[0]->id;
			$firstName=$result[0]->firstName;
			
			$this->session->set_userdata('loginStatus', true);
			$this->session->set_userdata('loginId', $userid);
			$this->session->set_userdata('role', $role);
			$this->session->set_userdata('firstName', $firstName);
			$sessionId = $this->session->userdata('session_id');
			$sql = "SELECT
						users.id AS id,
					users.registration_id AS registration_id
		
				FROM
					login AS login,
					user_data AS users
				WHERE
					login.id = users.user_id AND
		
					login.role = 'ADMIN'
						ORDER BY  users.id ASC
					LIMIT 1";
			$query = $this->db->query($sql);
			
			if($query){
				while($result=mysql_fetch_array($query->result_id)){
					$registration_id=$result['registration_id'];
					$this->session->set_userdata('registration_id', $registration_id);
				}
					
			}
			$sql = "UPDATE
			qrtable set flag=0,userId=null WHERE id=1";
			
			$query = $this->db->query($sql);
			//insert login history
			$this->validate->insertLoginHistory($sessionId, $userid, $channel);
			//setting response
			
			redirect('c_landing');
			}
		}	
		
		sleep(1);
		}
	}
	
}