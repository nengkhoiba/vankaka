<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_database extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_database', 'database');
		$this->output->set_content_type('application/json');
	}
	
public function DriverReg()
		{
			$firstname = $_POST['firstname'];
			$lastname= $_POST['lastname'];
			$gender = $_POST['gender'];
			$dob = $_POST['dob'];
			$address = $_POST['address'];
			$fathername = $_POST['fathername'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$vehiclenumber = $_POST['vehiclenumber'];
			
		
			
			$this->database->DriverReg($firstname,$lastname,$gender,$dob,$address,$fathername,$email,$phone,$vehiclenumber);
		
			$sqlstatus = $this->session->userdata('sqlstatus');
			if($sqlstatus=="success")
			{
		
				$this->output->set_output(json_encode(array("status" => "success")));
					
					
			}
			else
			{
				$this->output->set_output(json_encode(array("status" => "fail")));
			}
		
		redirect('nav/AddDriver');
		
		
		}
		public function StudentReg()
		{
			$firstname = $_POST['firstname'];
			$lastname= $_POST['lastname'];
			$gender = $_POST['gender'];
			$dob = $_POST['dob'];
			$address = $_POST['address'];
			$fathername = $_POST['fathername'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$school = $_POST['school'];
			$class = $_POST['class'];
			$section = $_POST['section'];
			$roll = $_POST['roll'];
			$AcademicSession = $_POST['AcademicSession'];
			$Servicetype = $_POST['Servicetype'];
				
		
				
			$this->database->StudentReg($firstname,$lastname,$gender,$dob,$address,$fathername,$email,$phone,$school,$class,$section,$roll,$AcademicSession,$Servicetype);
		
			$sqlstatus = $this->session->userdata('sqlstatus');
			if($sqlstatus=="success")
			{
		
				$this->output->set_output(json_encode(array("status" => "success")));
					
					
			}
			else
			{
				$this->output->set_output(json_encode(array("status" => "fail")));
			}
		
			redirect('nav/AddStudent');
		
		
		}
		public function addSchool()
		{
			if ((!empty($_GET['school']))&&(!empty($_GET['school']))&&(!empty($_GET['address']))&&(!empty($_GET['start']))&&(!empty($_GET['end'])))
			{
				 
			$school=$_GET['school'];
			$batch=$_GET['school'];
			$address = $_GET['address'];
			$startTime=$_GET['start'];
			$EndTime=$_GET['end'];
		
		
		
		
			$this->database->AddSchool($school,$batch,$address,$startTime,$EndTime);
		
			$sqlstatus = $this->session->userdata('sqlstatus');
			if($sqlstatus=="success")
			{
		
				$this->output->set_output(json_encode(array("status" => "success")));
					
					
			}
			else
			{
				$this->output->set_output(json_encode(array("status" => "fail")));
			}
	
			}else 
			{
				$this->output->set_output(json_encode(array("status" => "empty")));
			}
		
		}
	
}

