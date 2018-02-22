<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {


	
    public function activate()
    
    {
    	
    	$email=$this->input->get('q');
    	$code=$this->input->get('c');
    	$sql = "UPDATE
    	login
    	SET
    	status ='ACTIVE'
    	
    	WHERE act_key='$code'
    	AND email='$email'";
    	
    	$query = $this->db->query($sql);
    	
    	$this->load->view('active');
    	 
    	 
    }

}