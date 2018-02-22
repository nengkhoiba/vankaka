<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->view('home.php');
	}
	public function AddStudent()
	{
		$this->load->view('student_registration_view.php');
	}
	public function AddDriver()
	{
		$this->load->view('search.php');
	}
	public function StudentList()
	{
		$this->load->view('search.php');
	}
	public function Drivers()
	{
		$this->load->view('search.php');
	}public function sendSms()
	{
		$this->load->view('search.php');
	}public function search()
	{
		$this->load->view('search.php');
	}
}

	