<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reg_model extends CI_Model{
    
	function __construct(){
		parent::__construct();
	}
	function validateUser($loginId)
	{
		$sql = "SELECT
		login.uid AS id,
		login.pass AS password,
		user.name AS name,
		login.role AS role
	
	
		FROM
		login AS login,
		user_data AS user
		WHERE
		login.email = '$loginId' AND
		login.status = 'ACTIVE' AND
		user.uid = login.uid";
	
		$query = $this->db->query($sql);
	
		return $query->result();
	}
	
	function forgotpassword($email){
		$sql = "SELECT pass
		FROM  login
		WHERE email='$email'";
	
		$query1 = $this->db->query($sql);
		$flag = $query1->num_rows();
		if($flag==1){
			while($result=mysql_fetch_array($query1->result_id)){
				$password=$result['password'];
			}
			$this->load->library('encrypt');
			$pass=$this->encrypt->decode($password);
	
			$this->load->library('email');
	
			$this->email->from('support@mobilemechanic.com','support@mobilemechanic.com');
	
			$this->email->to($email);
			$this->email->subject('Forgot Password');
	
				
			$data['pass']=$pass;
				
			$msg = $this->load->view('email_templates/fogot_email',$data,TRUE);
			$this->email->message($msg);
			$this->email->set_mailtype("html");
			$this->email->send();
	
			$this->session->set_userdata('sqlstatus', 'success');
	
		}
		else {
	
			$this->session->set_userdata('sqlstatus', 'fail');
		}
	}
	
}