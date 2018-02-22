<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_landing extends CI_Controller {
    
	function __construct() {
        parent::__construct();
     
    }
	
    function index(){
    	if($this->session->userdata('loginStatus'))
		{
			if($this->session->userdata('role') == "ADMIN"){
				redirect('nav');
			}else {
			if($this->session->userdata('role') == "PARENT"){
				$this->load->view('manager/landing_page');
			}else {
			if($this->session->userdata('role') == "DRIVER"){
				$this->load->view('retailer/landing_page');
			}else {
			if($this->session->userdata('role') == "OPERATOR"){
				$this->load->view('operator/landing_page');
			}else {
				redirect('c_home');
			}
				
			}
			}
			}
			
			
			//User is correctly logged in
		} else {
			//Session is not present so logout the user and show login screen
			redirect('c_home');
		}
    }
    
	
}
