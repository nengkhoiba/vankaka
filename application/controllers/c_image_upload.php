<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_image_upload extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->output->set_content_type('application/json');
	}
	
	public function index()
	{
 
	$base=$_REQUEST['image'];
	// Get file name posted from Android App
	$userid = $_REQUEST['userid'];
	$filename = $_REQUEST['filename'];
	// Decode Image
	// $binary=base64_decode($base);
	if($base!=null)
	{
		$binary=base64_decode($base);
		header('Content-Type: bitmap; charset=utf-8');
	
		
		$output_dir = "images/profile/";
		$fileName = $user_id.'_profile.jpg';
		file_put_contents($output_dir.$fileName, $binary);
		$url=base_url().$output_dir.$fileName;
		 $sql1="UPDATE user SET profile_url='$url' where id='$userid'";
		$query1 = $this->db->query($sql1);
	
	}
	
	if($query1)
	{
		$this->output->set_output(json_encode(array("status" => "uploaded")));
	}
	else{
		$this->output->set_output(json_encode(array("status" => "uploade_fail")));
	}
	}

	
}

