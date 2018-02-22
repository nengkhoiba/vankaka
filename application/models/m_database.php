<?php
class M_database extends CI_Model{
    
	function __construct(){
		parent::__construct();
	}

	public function DriverReg($firstname,$lastname,$gender,$dob,$address,$fathername,$email,$phone,$vehiclenumber)
	{
		$login = $this->session->userdata('loginId');
		$userlength = rand(2, 5);
		$username = $firstname;
		$password='';
		$char=$firstname.''.$lastname.''.$phone;
		for ($i=0; $i<$userlength; $i++) {
			$username .= $phone[mt_rand(0, strlen($phone))];
		}
		
		for ($i=0; $i<8; $i++) {
			$password .= $char[mt_rand(0, strlen($char))];
		}
		
		
		
	$sql = "INSERT INTO `user_data`(`user_id`,`first_name`, `last_name`, `father_name`, `address`, `gender`, `dob`, `mobile_number`, `email`,  `other`, `created_by`, `created_on`) 
			VALUES ('$username','$firstname','$lastname','$fathername','$address','$gender','$dob','$phone','$email','$vehiclenumber','$login',NOW())";
		$query = $this->db->query($sql);
		
			
			
		if($query)
		{
			
			$sql2="INSERT INTO `login`(`id`, `password`, `status`, `role`, `question`, `answer`, `created_by`, `created_on`) 
					VALUES ('$username','$password','ACTIVE','DRIVER','pet name','tiger','$login',NOW())";
			$query2 = $this->db->query($sql2);
			if($query2)
			{
			$this->session->set_userdata('sqlstatus', 'success');
			}else
			{$this->session->set_userdata('sqlstatus', 'fail');}
			
		}
	
	
		else
		{
			$this->session->set_userdata('sqlstatus', 'fail');
		}
	
	}
	public function StudentReg($firstname,$lastname,$gender,$dob,$address,$fathername,$email,$phone,$school,$class,$section,$roll,$AcademicSession,$Servicetype)
	{
		$login = $this->session->userdata('loginId');
	
		$userlength = rand(2, 5);
		$username = $firstname;
	$password='';
	$char=$firstname.''.$lastname.''.$phone;
		for ($i=0; $i<$userlength; $i++) {
			$username .= $phone[mt_rand(0, strlen($phone))];
		}
	
		for ($i=0; $i<8; $i++) {
			$password .= $char[mt_rand(0, strlen($char))];
		}
	
			$sql = "INSERT INTO `user_data`(`user_id`,`first_name`, `last_name`, `father_name`, `address`, `gender`, `dob`, `mobile_number`, `email`,  `other`, `created_by`, `created_on`) 
			VALUES ('$username','$firstname','$lastname','$fathername','$address','$gender','$dob','$phone','$email','$Servicetype','$login',NOW())";
		$query = $this->db->query($sql);
	
			
			
		if($query)
		{
				
	
			$sql1 = "SELECT id
					FROM  user_data
					ORDER BY  user_data.id DESC
					LIMIT 1";
				
			$query1 = $this->db->query($sql1);
				
			if($query1){
				while($result=mysql_fetch_array($query1->result_id)){
					$id=$result['id'];
				}
			}
	
			$sql2="INSERT INTO `login`(`id`, `password`, `status`, `role`, `question`, `answer`, `created_by`, `created_on`)
			VALUES ('$username','$password','ACTIVE','PARENT','pet name','tiger','$login',NOW())";
			$query2 = $this->db->query($sql2);
			
			$sql3="INSERT INTO `student_school_relation`(`session_id`, `student_id`, `school_id`, `class`, `roll`, `section`)
					 VALUES ('$AcademicSession','$id','$school','$class','$roll','$section')";
			$query3 = $this->db->query($sql3);
			
			$sql4="INSERT INTO `student_fee_relation`(`session_id`, `student_id`)
					 VALUES ('$AcademicSession','$id')";
			$query4 = $this->db->query($sql4);
			
			
			if($query4)
			{
				$this->session->set_userdata('sqlstatus', 'success');
			}else
			{$this->session->set_userdata('sqlstatus', 'fail');}
				
		}
	
	
		else
		{
		$this->session->set_userdata('sqlstatus', 'fail');
		}
	
		}
		
		public function AddSchool($school,$batch,$address,$startTime,$EndTime)
		{
			
			$sql="INSERT INTO school(school_name, school_address,batch,starttime,endtime)
			VALUES ('$school','$address','$batch','$startTime','$EndTime')";
			$query = $this->db->query($sql);
				
				
			if($query)
			{
				$this->session->set_userdata('sqlstatus', 'success');
			}else
			{$this->session->set_userdata('sqlstatus', 'fail');}
		}
}