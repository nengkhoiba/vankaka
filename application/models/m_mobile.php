<?php
class M_mobile extends CI_Model{
    
	function __construct(){
		parent::__construct();
		$this->load->library('unirest');
	}
	
	
	
	public function StudentList($type)
	{
		
$sql="SELECT user.id AS id,
		user.first_name AS first_name,
		user.last_name AS last_name,
		user.address,
		user.mobile_number,
		user.other AS other,
		user.image_id AS imgUrl,
		ssr.school_id as school_id,
		ssr.class AS class,
		ssr.roll AS roll,
		ssr.section AS section,
		school.school_name AS school_name
		
		from user_data user,student_school_relation ssr,school school
		WHERE user.other='$type' and ssr.session_id=1 and ssr.student_id=user.id and school.school_id=ssr.school_id";

        $query = $this->db->query($sql);
		
		$student_list= array();
	
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
					
				
	
			$student = array();
			
			
			$student['id'] = $result['id'];
			$student['firstname'] = $result['first_name'];
			$student['lastname'] = $result['last_name'];
			$student['address'] = $result['address'];
			$student['mobile_number'] = $result['mobile_number'];
			$student['school'] = $result['school_name'];
			$student['imgUrl'] = $result['imgUrl'];
			
			$student_list[]=$student;
			
			}
	
			
			$output['student_list'] =  $student_list;
			
			
			$this->output->set_content_type('application/json');
			echo json_encode($output);
		
		}
		
		
				
	}
	public function StudentDetails($id,$type)
	{
	
		$sql="SELECT user.id AS id,
user.first_name AS first_name,
user.last_name AS last_name,
user.address,
user.other AS other,
user.mobile_number,
user.image_id AS imgUrl,
ssr.school_id as school_id,
ssr.class AS class,
ssr.roll AS roll,
ssr.section AS section,
school.school_name AS school_name,
sfr.jan,
sfr.feb,
sfr.mar,
sfr.apr,
sfr.may,
sfr.june,
sfr.july,
sfr.aug,
sfr.sept,
sfr.oct,
sfr.nov,
sfr.dec

from 
user_data user,
student_school_relation ssr,
school school,
student_fee_relation sfr

WHERE user.id ='$id' 
and user.other='$type' 
and ssr.session_id=1 
and ssr.student_id=user.id 
and school.school_id=ssr.school_id
and sfr.student_id=user.id 
and sfr.session_id=1
";
	
		$query = $this->db->query($sql);
	
		$student_list= array();
	
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
					
	
	
				$student = array();
					
					
				$student['id'] = $result['id'];
				$student['firstname'] = $result['first_name'];
				$student['lastname'] = $result['last_name'];
				$student['address'] = $result['address'];
				$student['mobile_number'] = $result['mobile_number'];
				$student['school'] = $result['school_name'];
				$student['imgUrl'] = $result['imgUrl'];
				
				$student['jan'] = $result['jan'];
				$student['feb'] = $result['feb'];
				$student['mar'] = $result['mar'];
				$student['apr'] = $result['apr'];
				$student['may'] = $result['may'];
				$student['june'] = $result['june'];
				$student['july'] = $result['july'];
				$student['aug'] = $result['aug'];
				$student['sept'] = $result['sept'];
				$student['oct'] = $result['oct'];
				$student['nov'] = $result['nov'];
				$student['dec'] = $result['dec'];
					
					
				$student_list[]=$student;
					
			}
	
				
			$output['studentDetails'] =  $student_list;
				
				
			$this->output->set_content_type('application/json');
			echo json_encode($output);
	
		}
	
	
	
	}
	public function FeeDetails($id)
	{
	
		$sql="SELECT 
				fd.bill_no,
				fd.amount,
				fd.dateofpay,
				fd.timeofpay,
				fd.fine,
				fd.driver,
				user.first_name,
				user.other AS vanNo
				
				FROM fee_detail fd,user_data user
				WHERE 
				fd.bill_id='$id'
				AND user.id=fd.driver
				";
	
		$query = $this->db->query($sql);
	
		$student_list= array();
	
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
					
	
	
				$student = array();
					
					
				$student['bill_no'] = $result['bill_no'];
				$student['amount'] = $result['amount'];
				$student['dateofpay'] = $result['dateofpay'];
				$student['timeofpay'] = $result['timeofpay'];
				$student['fine'] = $result['fine'];
				$student['driver'] = $result['first_name'];
				$student['vanNo'] = $result['vanNo'];
					
					
				$student_list[]=$student;
					
			}
	
				
			$output['FeeDetails'] =  $student_list;
				
				
			$this->output->set_content_type('application/json');
			echo json_encode($output);
	
		}
	
	
	
	}
	public function addfees($driverid,$studentid,$sl,$amount,$fine,$month,$session)
	{
		$sql="INSERT INTO `fee_detail`(`bill_no`, `amount`, `dateofpay`, `timeofpay`, `fine`, `driver`)
				 VALUES ('$sl','$amount',CURDATE(),CURTIME(),'$fine','$driverid')";
		$query = $this->db->query($sql);
		
		$sql = "SELECT bill_id
					FROM  fee_detail
					ORDER BY  fee_detail.bill_id DESC
					LIMIT 1";
		
		$query1 = $this->db->query($sql);
		
		if($query1){
			while($result=mysql_fetch_array($query1->result_id)){
				$billid=$result['bill_id'];
				
					$sql = "Update
					student_fee_relation
					SET
					$month='$billid'
					WHERE student_id='$studentid'
					AND session_id='$session'";
				
					$query2 = $this->db->query($sql);
				
					if($query2){
						
						$this->output->set_output(json_encode(array("status" => "success")));
				
					}else $this->output->set_output(json_encode(array("status" => "fail")));
				
			}
		}else $this->output->set_output(json_encode(array("status" => "fail")));
	}
	public function bulkSms($type,$msg)
	{
		
		$contact="";
		
		if($type=="ALL")
		{
			$sql="SELECT 
			
					user.mobile_number,
					user.email AS email
		
			
			from
			user_data user
			";
			
			$query = $this->db->query($sql);
			
			$student_list= array();
			
			if($query)
			{
			while($result=mysql_fetch_array($query->result_id)){
				
				
			   $contact = $contact.";".$result['mobile_number'];
		     }
		
			}
		
		}elseif ($type=="SCHOOL")
		{
			

			$sql="SELECT
		
					user.mobile_number,
					user.email AS email
			
		
			from
			user_data user
					WHERE
					user.other='SCHOOL'
			";
				
			$query = $this->db->query($sql);
				
			$student_list= array();
				
			if($query)
			{
				while($result=mysql_fetch_array($query->result_id)){
			
			
					$contact = $contact.";".$result['mobile_number'];
				}
			
			}
		}
		elseif ($type=="COACHING")
		{
				
		
			$sql="SELECT
		
					user.mobile_number,
					user.email AS email
		
		
			from
			user_data user
					WHERE
					user.other='COACHING'
			";
		
			$query = $this->db->query($sql);
		
			$student_list= array();
		
			if($query)
			{
				while($result=mysql_fetch_array($query->result_id)){
						
						
					$contact = $contact.";".$result['mobile_number'];
				}
					
			}
		}
		
		
		
		
		
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
		
		public function SendSms($usrid,$msg)
		{

			$sql="SELECT
			
					user.mobile_number,
					user.email AS email
		
			
			from
			user_data user
					WHERE
					user.id='$usrid'
			";
			
			$query = $this->db->query($sql);
			
			$student_list= array();
			
			if($query)
			{
				while($result=mysql_fetch_array($query->result_id)){
						
						
					$contact = $result['mobile_number'];
				}
					
			}
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
	
