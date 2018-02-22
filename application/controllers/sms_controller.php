<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_controller extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('unirest');
	}
	

	public function SendBulk()
	{
		
		
		
		
		$url="https://freesms8.p.mashape.com/index.php?msg=Testing+free+sms&phone=9774180184;8259939749;9089066314&pwd=3550&uid=9774180184";


$headers = array("X-Mashape-Key" => "DfqXgGS8kOmshkGNKxlSzCt4rLhvp13SMdRjsnstLRZ1v10iIG");

$response = $this->unirest->get($url, $headers, $body=null);


    
    
    if($response->body->response)
       $this->output->set_output(json_encode(array("SMS" => $response->body->response)));
    else
    {
    	$this->output->set_output(json_encode(array("SMS" => "Failed")));
    }
	}
	
	public function SendBulksms()
	{
	
	$contact=$_GET['contact'];
	$msg=$_GET['msg'];
	
	
		$url="https://freesms8.p.mashape.com/index.php?msg=$msg&phone=$contact&pwd=3550&uid=9774180184";
	
	
		$headers = array("X-Mashape-Key" => "DfqXgGS8kOmshkGNKxlSzCt4rLhvp13SMdRjsnstLRZ1v10iIG");
	
		$response = $this->unirest->get($url, $headers, $body=null);
	
	
	
	
		if($response->body->response)
			$this->output->set_output(json_encode(array("SMS" => $response->body->response)));
		else
		{
			$this->output->set_output(json_encode(array("SMS" => "Failed")));
		}
	}
	

}	