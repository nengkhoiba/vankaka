<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nav extends CI_Controller {
	function __construct() {
		parent::__construct();
	
	}
	

	public function index()
	{
		$this->load->view('admin/candidateReg');
	}
	public function AddStudent()
	{
		$this->load->view('admin/candidateReg');
	}
	public function AddDriver()
	{
	$this->load->view('admin/driverReg');
	}
	public function StudentList()
	{
		$this->load->view('admin/studentList.php');
	}
	public function Drivers()
	{
		$this->load->view('admin/driverList.php');
	}public function sendSms()
	{
		$this->load->view('admin/sendSms.php');
	}
	public function StudentDetails()
	{
		$this->load->view('admin/StudentDetails.php');
	}
	public function DtStudentlist()
	{
		$this->load->view('admin/dt_student_list.php');
	}
	public function getContactList()
	{
		$this->load->view('admin/smsStudentDetail.php');
	}
	public function getFeedetails()
	{
		
		$this->load->view('admin/feeDetails.php');
	}
}	