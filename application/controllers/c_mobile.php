<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_mobile extends CI_Controller {

	public function __construct()
    {
    	parent::__construct();
    	$this->load->model('m_mobile', 'database');
    	$this->output->set_content_type('application/json');
    }
	
  public function GetStudentList()
    {
    	$type=$_GET['type'];
    	$this->database-> StudentList($type);
    }
  public function GetStudentDetails()
    {
    	$id=$_GET['id'];
    	$type=$_GET['type'];
    	$this->database-> StudentDetails($id,$type);
    }
  public function feeDetails()
    {
    	$id=$_GET['id'];
    	$this->database-> FeeDetails($id);
    }
    public function AddFees()
    {   $driverid=$_GET['driver'];
    	$studentid=$_GET['student'];
    	$sl=$_GET['sl'];
    	$amount=$_GET['amount'];
    	$fine=$_GET['fine'];
    	$month=$_GET['month'];
    	$session=$_GET['session'];
    	$this->database-> addfees($driverid,$studentid,$sl,$amount,$fine,$month,$session);
    } 
    public function bulksms()
    {
    	$type=$_GET['type'];
    	$msg=$_GET['msg'];
    	$this->database-> bulkSms($type,$msg);
    	
    }
    public function sendsms()
    {
    	$usrid=$_GET['userid'];
    	$msg=$_GET['msg'];
    	$this->database-> SendSms($usrid,$msg);
    } 
}