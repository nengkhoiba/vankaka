<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webservice extends CI_Controller {
	

	public function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('reg_model', 'database');
		
	}
	
	function generateRandomString($length = 20) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz981u9unakhkkjhJHJGYFUFGKUGWW';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	public function login(){
		//http://localhost/mobile_mechanic/webservice/login?email=nengkhoiba@mobimp.com&password=welcome
		$this->output->set_content_type('application/json');
		$email=$_GET['email'];
		$password=$_GET['password'];
	
		if ((isset($_GET['email'])) && (!empty($_GET['email'])))
		{
			if ((isset($_GET['password'])) && (!empty($_GET['password'])))
			{
			
					
				$result = $this->database->validateUser($email);
					
				if(sizeof($result) == 1){
	
					$pass=$this->encrypt->decode($result[0]->password);
					if($password == $pass)
					{
							
						$id=$result[0]->id;
						$Name=$result[0]->name;
						$role=$result[0]->role;
						$this->session->set_userdata('loginStatus', true);
						$this->session->set_userdata('loginId', $id);
						$this->session->set_userdata('role', $role);
						$this->session->set_userdata('name', $Name);
						$channel = "UNKNOWN";
	
						$outputData = array(
								"authenticationStatus" => "valid",
								"user" => $Name,
								"role" => $role,
								"id"=>$id
						);
							
						$this->output->set_output(json_encode($outputData));
					}
					else{
						//login failure
						$this->session->sess_destroy();
						$this->output->set_output(json_encode(array("authenticationStatus" => "invalid")));
					}
				}
			}else {
				$this->output->set_output(json_encode(array("error" => "Password is missing")));
				return;
			}
		}else {
			$this->output->set_output(json_encode(array("error" => "Login id is missing")));
			return;
		}
	
	}
	public function mechanicReg()
	{
		//http://localhost/mobile_mechanic/webservice/mechanicReg?name=NENG&add=BAMON%20LEIKAI&field=&email=nengkhoiba@mobim.com&mobile=9774180184&pass=MECHANIC
		$this->load->library('encrypt');
		$activation_code = $this->generateRandomString(20);
		$name=trim($_GET['name']);//    $name=trim($name)//
		$add=trim($_GET['add']);
		$field=trim($_GET['field']);
		$email=trim($_GET['email']);
		$mobile=trim($_GET['mobile']);
		$pass=trim($_GET['pass']);
		$bal=50;
		if($name!="" && $add!="" && $field!=""&& $email !="" && $mobile!="" && $pass!=""){
			$pass=$this->encrypt->encode($pass);
			$name=mysql_real_escape_string($name);
			$add=mysql_real_escape_string($add);
			$field=mysql_real_escape_string($field);
			$email=mysql_real_escape_string($email);
			$mobile=mysql_real_escape_string($mobile);
			$pass=mysql_real_escape_string($pass);
			
			$sql="INSERT INTO `user_data`(`name`,`address`, `email`, `mobile`) 
					VALUES ('$name','$add','$email','$mobile')";
			$query = $this->db->query($sql);
			if($query){
				
				$sql1 = "SELECT uid
					FROM  user_data
					ORDER BY  user_data.uid DESC
					LIMIT 1";
				
					$query1 = $this->db->query($sql1);
				
					while($result=mysql_fetch_array($query1->result_id)){
						$id=$result['uid'];
					}
					$sql2="INSERT INTO `login`(`uid`, `email`, `pass`, `role`, `act_key`, `status`)
							VALUES ('$id','$email','$pass','MECHANIC','$activation_code','INACTIVE')";
					$query2 = $this->db->query($sql2);
					$sql3="INSERT INTO `mechanic`(`uid`, `available`, `balance`, `field`, `main_latitude`, `main_longitude`, `status`) 
							VALUES ('$id','YES','$bal','$field','','','Available')";
					$query3 = $this->db->query($sql3);
					
					$this->load->library('email');
					
					$this->email->from('support@mobilemechanic.com','support@mobilemechanic.com');
					
					$this->email->to($email);
					$this->email->subject('Confirm Email');
					
					$url=base_url()."account/activate?q=".$email."&c=".$activation_code;
					$logo=base_url()."images/logo.png";
					$data['url']=$url;
					$data['logo']=$logo;
					$msg = $this->load->view('email_templates/confirmation_email',$data,TRUE);
					$this->email->message($msg);
					$this->email->set_mailtype("html");
					$this->email->send();
					
					
					if($query3){
						$this->output->set_output(json_encode(array("status" => "success","uid"=>$id)));
					}
					else{
						$this->output->set_output(json_encode(array("status" => "fail")));
					}
			}else{
				$this->output->set_output(json_encode(array("status" => "fail")));
			}
			
		}else{
			$this->output->set_output(json_encode(array("status" => "empty")));
		}
		
	}
	public function status_update()
	{
		//http://localhost/mobile_mechanic/webservice/status_update?uid=1&oid=1&status=
		$uid=trim($_GET['uid']);
		$oid=trim($_GET['oid']);
		$status=trim($_GET['status']);
		if($uid!="" && $status!="")
		{
			$uid=mysql_real_escape_string($uid);
			$status=mysql_real_escape_string($status);
	
			$sql="UPDATE `order_data` SET `status`='$status' WHERE uid=$uid AND oid='$oid'";
			$query=$this->db->query($sql);
			if($query)
			{
				$this->output->set_output(json_encode(array("status"=>"success")));
			}
			else {
				$this->output->set_output(json_encode(array("status"=>"fail")));
			}
		}
		else {
			$this->output->set_output(json_encode(array("status"=>"empty")));
		}
	}
	public function mechanic_status()
	{
		//http://localhost/mobile_mechanic/webservice/status_update?uid=1&oid=1&status=
		$uid=trim($_GET['uid']);
	
		$status=trim($_GET['status']);
		if($uid!="" && $status!="")
		{
			$uid=mysql_real_escape_string($uid);
			$status=mysql_real_escape_string($status);
	
			$sql="UPDATE `mechanic` SET `available`='$status' WHERE uid='$uid'";
			$query=$this->db->query($sql);
			if($query)
			{
				$this->output->set_output(json_encode(array("status"=>"success")));
			}
			else {
				$this->output->set_output(json_encode(array("status"=>"fail")));
			}
		}
		else {
			$this->output->set_output(json_encode(array("status"=>"empty")));
		}
	}
	public function accept_request()
	{
		//http://localhost/mobile_mechanic/webservice/accept_request?oid=1&uid=1
		
		$oid=trim($_GET['oid']);
		$uid=trim($_GET['uid']);
		if($uid!="" && $oid!="")
		{
			$uid=mysql_real_escape_string($uid);
			$oid=mysql_real_escape_string($oid);
			
						$sql2="UPDATE `order_data` SET `status`='ACCEPTED' WHERE oid='$oid'";
						$query2=$this->db->query($sql2);
						if($query2)
						{
							$this->output->set_output(json_encode(array("status"=>"success")));
						}else{
							$this->output->set_output(json_encode(array("status"=>"fail")));
						}
					
				
			
		}
		else {
			$this->output->set_output(json_encode(array("status"=>"empty")));
		}
	}
	public function reject_request()
	{
		//http://localhost/mobile_mechanic/webservice/reject_request?oid=1&uid=1
		$oid=trim($_GET['oid']);
		$uid=trim($_GET['uid']);
		$sql2="UPDATE `order_data` SET `status`='REJECTED' WHERE oid='$oid'";
		$query2=$this->db->query($sql2);
		if($query2)
		{
			$this->output->set_output(json_encode(array("status"=>"success")));
		}else{
			$this->output->set_output(json_encode(array("status"=>"fail")));
		}
	}
	public function set_work_progress()
	{
		//http://localhost/mobile_mechanic/webservice/set_work_progress?oid=1&uid=1&status=FIXED
		$oid=trim($_GET['oid']);
		$uid=trim($_GET['uid']);
		$status=trim($_GET['status']);
		if($uid!="" && $oid!="" && $status!="" )
		{
			$sql2="UPDATE `order_data` SET `status`='$status',`finish_date_time`=NOW() WHERE oid='$oid' and uid='$uid'";
			$query2=$this->db->query($sql2);
			if($query2)
			{
				$this->output->set_output(json_encode(array("status"=>"success")));
			}else{
				$this->output->set_output(json_encode(array("status"=>"fail")));
			}
		}
		else {
			$this->output->set_output(json_encode(array("status"=>"empty")));
		}
	}
	public function forgotpassword(){
		$email=$_GET['email'];
		$this->database->forgotpassword($email);
		$sqlstatus = $this->session->userdata('sqlstatus');
		if($sqlstatus=="success")
		{
			$this->output->set_output(json_encode(array("status" => "success")));
		}
		else
		{
			$this->output->set_output(json_encode(array("status" => "fail","error"=>"Fail to add!")));
		}
	
	
	}
	public function clientReg()
	{
	$this->load->library('encrypt');
		$activation_code = $this->generateRandomString(20);
		$name=trim($_GET['name']);//    $name=trim($name)//
		$add=trim($_GET['add']);
		$email=trim($_GET['email']);
		$mobile=trim($_GET['mobile']);
		$pass=trim($_GET['pass']);
		
		if($name!="" && $add!="" && $email !="" && $mobile!="" && $pass!=""){
			$pass=$this->encrypt->encode($pass);
			$name=mysql_real_escape_string($name);
			$add=mysql_real_escape_string($add);
			$email=mysql_real_escape_string($email);
			$mobile=mysql_real_escape_string($mobile);
			$pass=mysql_real_escape_string($pass);
			
			$sql="INSERT INTO `user_data`(`name`,`address`,`email`, `mobile`) 
					VALUES ('$name','$add','$email','$mobile')";
			$query = $this->db->query($sql);
			if($query){
				
				$sql1 = "SELECT uid
					FROM  user_data
					ORDER BY  user_data.uid DESC
					LIMIT 1";
				
					$query1 = $this->db->query($sql1);
				
					while($result=mysql_fetch_array($query1->result_id)){
						$id=$result['uid'];
					}
					$sql2="INSERT INTO `login`(`uid`, `email`, `pass`, `role`, `act_key`, `status`)
							VALUES ('$id','$email','$pass','CLIENT','$activation_code','INACTIVE')";
					$query2 = $this->db->query($sql2);
					
					$this->load->library('email');
					$this->email->from('support@mobilemechanic.com','support@mobilemechanic.com');
					$this->email->to($email);
					$this->email->subject('Confirm Email');
					$url=base_url()."account/activate?q=".$email."&c=".$activation_code;
					$logo=base_url()."images/logo.png";
					$data['url']=$url;
					$data['logo']=$logo;
					$msg = $this->load->view('email_templates/confirmation_email',$data,TRUE);
					$this->email->message($msg);
					$this->email->set_mailtype("html");
					$this->email->send();
					
					
					if($query2){
						$this->output->set_output(json_encode(array("status" => "success","uid"=>$id)));
					}
					else{
						$this->output->set_output(json_encode(array("status" => "fail")));
					}
			}else{
				$this->output->set_output(json_encode(array("status" => "fail")));
			}
			
		}else{
			$this->output->set_output(json_encode(array("status" => "empty")));
		}
	
	}
	public function registerDevice()
	{
		$uid=$_GET['uid'];
		$ids=$_GET['ids'];
		$sql = " UPDATE user_data SET reg='$ids' WHERE uid='$uid'";
	
		$query = $this->db->query($sql);
	
	}
	public function order_details()
	{
		//http://localhost/mobile_mechanic/webservice/order_details?oid=1
		$oid=$_GET['oid'];
	
		$sql="SELECT
		orders.problem as prob,
		orders.extra as extra,
		orders.status as status,
		orders.latitude as lat,
		orders.longitude as longi,
		orders.order_date as order_date,
		orders.order_time as order_time,
		orders.paid as paid,
		orders.finish_date_time as finish_date_time,
		user.name as name,
		user.mobile as mobile
		FROM order_data orders,user_data user
		WHERE user.uid=orders.client_uid
		AND orders.oid='$oid'
		";
	
		$query = $this->db->query($sql);
	
		if($query)
		{
				
			while($result=mysql_fetch_array($query->result_id)){
					
				$order = array();
	
				$order['prob'] = $result['prob'];
				$order['extra'] = $result['extra'];
				$order['status'] = $result['status'];
				$order['lat'] = $result['lat'];
				$order['long'] = $result['longi'];
			
				$now=strtotime(date("Y-m-d"));
				$past=strtotime($result['order_date']);
				$diff=$now-$past;
				$day=floor($diff/(60*60*24));
				if($day==0)
				{
				
					$diff=strtotime(date("H:i:s"))-strtotime($result['order_time']);
						
					$temp=$diff/86400; // 60 sec/min*60 min/hr*24 hr/day=86400 sec/day
						
					// days
					$days=floor($temp);$temp=24*($temp-$days);
					// hours
					$hours=floor($temp);$temp=60*($temp-$hours);
					// minutes
					$minutes=floor($temp); $temp=60*($temp-$minutes);
					// seconds
					$seconds=floor($temp);
						
					if($hours==0){
						if($minutes==0){
							$day=$seconds." sec ago";
						}else{
							$day=$minutes." mins ago";
						}
				
					}else{
						$day=$hours." hrs ago";
					}
				
				}else
				{
					if($day<=31){
						$day=$day." day(s) ago.";
					}else{
							
						$day=ceil($day/30);
						if($day<=12)
						{
							$day=$day." month(s) ago.";
						}else{
							$day=ceil($day/12);
							$day=$day." year(s) ago.";
						}
					}
				}
				$order['days'] = $day;
				$order['name'] = $result['name'];
				$order['mobile'] = $result['mobile'];
					
				$order_list[]=$order;
					
			}
			$output['order_detail'] =  $order_list;
			$this->output->set_content_type('application/json');
			echo json_encode($output);
		}
		else
		{
			$this->output->set_output(json_encode(array("status" => "fail")));
		}
	}
	public function update_location()
	{
		//http://localhost/mobile_mechanic/webservice/update_location?uid=1&lat=23.0909&long=89.98989
		$uid=$_GET['uid'];
		$lat=$_GET['lat'];
		$long=$_GET['long'];
	
		$sql = "SELECT * FROM loc_data WHERE uid='$uid'";
	
		$query = $this->db->query($sql);
		$num=$query->num_rows();
		if($num<1){
			$sql = "INSERT INTO `loc_data`(`uid`, `latitude`, `longitude`, `update_date`, `update_time`)
			VALUES ('$uid','$lat','$long',CURDATE(),CURTIME())";
				
			$query = $this->db->query($sql);
			if($query)
			{
				$this->output->set_output(json_encode(array("status" => "success")));
			}
			else
			{
				$this->output->set_output(json_encode(array("status" => "fail")));
			}
		}else{
			$sql = "UPDATE `loc_data` SET
			`latitude`='$lat',
			`longitude`='$long',
			`update_date`=CURDATE(),
			`update_time`=CURTIME() WHERE uid='$uid'";
	
			$query = $this->db->query($sql);
			if($query)
			{
				$this->output->set_output(json_encode(array("status" => "success")));
			}
			else
			{
				$this->output->set_output(json_encode(array("status" => "fail")));
			}
		}
	
	
	}
	
	public function view_profile_mechanic()
	{
		//http://localhost/mobile_mechanic/webservice/view_profile_mechanic?uid=1
		$uid=$_GET['uid'];
	
		$sql = "SELECT user_data.name,user_data.address,user_data.email,user_data.mobile,mechanic.field,mechanic.available FROM user_data,mechanic WHERE user_data.uid='$uid' and mechanic.uid=user_data.uid";
	
		$query = $this->db->query($sql);
	
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
					
				$profile = array();
					
				$profile['name'] = $result['name'];
				$profile['address'] = $result['address'];
				$profile['email'] = $result['email'];
				$profile['mobile'] = $result['mobile'];
				$profile['field'] = $result['field'];
				$profile['status'] = $result['available'];
				$profile_list[]=$profile;
					
			}
			$output['profile']=$profile_list;
			$this->output->set_content_type('application/json');
			echo json_encode($output);
		}
		else
		{
			$this->output->set_output(json_encode(array("status" => "fail")));
		}
	}
	public function check_balance()
	{
		//http://localhost/mobile_mechanic/webservice/check_balance?uid=1
		$uid=$_GET['uid'];
	
		$sql = "SELECT balance FROM mechanic WHERE uid='$uid'";
	
		$query = $this->db->query($sql);
	
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
					
				$bal=$result['balance'];
					
			}
			$output['balance']=$bal;
			$this->output->set_content_type('application/json');
			echo json_encode($output);
		}
		else
		{
			$this->output->set_output(json_encode(array("status" => "fail")));
		}
	}
	public function edit_profile_mechanic()
	{
		//http://localhost/mobile_mechanic/webservice/edit_profile_mechanic?name=Nengkhoi&add=Bamon%20leikai&field=ENGINE&uid=1
		$name=trim($_GET['name']);
		$add=trim($_GET['add']);
		$field=trim($_GET['field']);
		$uid=trim($_GET['uid']);
	
		if($name!="" && $add!="" && $field!="" && $uid!=""){
	
			$name=mysql_real_escape_string($name);
			$add=mysql_real_escape_string($add);
			$field=mysql_real_escape_string($field);
			$uid=mysql_real_escape_string($uid);
	
	
			$sql="UPDATE user_data SET name='$name',address='$add' WHERE uid='$uid'";
			$query = $this->db->query($sql);
				
			if($query){
				$sql1="UPDATE mechanic SET field='$field' WHERE uid='$uid'";
				$query1 = $this->db->query($sql1);
				if($query1){
						
					$this->output->set_output(json_encode(array("status" => "success")));
				}
				else{
					$this->output->set_output(json_encode(array("status" => "fail")));
				}
	
			}
			else{
				$this->output->set_output(json_encode(array("status" => "fail")));
			}
	
	
		}else{
			$this->output->set_output(json_encode(array("status" => "empty")));
		}
	
	}
	public function create_order()
	{
		$field=trim($_GET['field']);
		$problem=trim($_GET['problem']);
		$extra=trim($_GET['extra']);
		$uid=trim($_GET['uid']);
		$c_uid=trim($_GET['c_uid']);
		$latitude=trim($_GET['latitude']);
		$longitude=trim($_GET['longitude']);
	
		if($field!="" && $problem!="" && $c_uid!="" && $uid!="")
		{
	
			$field=mysql_real_escape_string($field);
			$problem=mysql_real_escape_string($problem);
			$extra=mysql_real_escape_string($extra);
			$uid=mysql_real_escape_string($uid);
			$c_uid=mysql_real_escape_string($c_uid);
			$latitude=mysql_real_escape_string($latitude);
			$longitude=mysql_real_escape_string($longitude);
			$smstext="Dear Mechanic a client has requested your service on (".$problem."). Please check the app for more detail.";
			$sql="INSERT INTO `order_data`(`client_uid`,`field`, `problem`, `extra`, `accept`, `status`, `latitude`, `longitude`, `uid`, `order_date`, `order_time`)
			VALUES ('$c_uid','$field','$problem','$extra','NO','pending','$latitude','$longitude','$uid',CURDATE(),CURTIME())";
			$query = $this->db->query($sql);
			if($query)
			{
				$sql1 = "SELECT order_data.oid,user_data.mobile
					FROM  order_data,user_data
						WHERE user_data.uid=order_data.uid
					ORDER BY  order_data.oid DESC
					LIMIT 1";
					
				$query1 = $this->db->query($sql1);
					
				while($result=mysql_fetch_array($query1->result_id)){
					$oid=$result['oid'];
					$mobile=$result['mobile'];
				}
				if($query1)
				{
					$authKey = "9894A3pFnKl9R25630c16b";
						
					// Multiple mobiles numbers separated by comma
					$mobileNumber = $mobile;
						
					// Sender ID,While using route4 sender id should be 6 characters long.
					$senderId = "MOBIMP";
						
					// Your message to send, Add URL encoding here.
					$sms_text = urlencode ( $smstext );
						
					// Define route
					$route = "route4";
					// Prepare you post parameters
					$postData = array (
							'authkey' => $authKey,
							'mobiles' => $mobileNumber,
							'message' => $sms_text,
							'sender' => $senderId,
							'route' => $route
					);
						
					// API URL
					$url = "http://sms.ssdindia.com/api/sendhttp.php";
						
					// init the resource
					$ch = curl_init ();
					curl_setopt_array ( $ch, array (
							CURLOPT_URL => $url,
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_POST => true,
							CURLOPT_POSTFIELDS => $postData
					) )
					// ,CURLOPT_FOLLOWLOCATION => true
					;
						
					// Ignore SSL certificate verification
					curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
					curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
						
					// get response
					$output = curl_exec ( $ch );
						
					// Print error if any
					if (curl_errno ( $ch )) {
						echo 'error:' . curl_error ( $ch );
					}
						
					curl_close ( $ch );
					$this->output->set_output(json_encode(array("status" => "success","oid"=>$oid)));
				}
				else
				{
					$this->output->set_output(json_encode(array("status" => "fail")));
				}
			}
			else
			{
				$this->output->set_output(json_encode(array("status" => "fail")));
			}
		}
		else
		{
			$this->output->set_output(json_encode(array("status" => "empty")));
		}
	}
	public function order_history(){
		//http://localhost/mobile_mechanic/webservice/order_history?uid=1
		$uid=$_GET['uid'];

		$sql="SELECT orders.oid as oid,
					 orders.problem as prob,
					 orders.extra as extra,
					 orders.status as status,
					 orders.latitude as lat,
					 orders.longitude as longi,
					 orders.order_date as order_date,
					 orders.order_time as order_time,
					 orders.paid as paid,
					 orders.finish_date_time as finish_date_time,
					 user.name as name,
					 user.mobile as mobile
				FROM order_data orders,user_data user
				WHERE user.uid=orders.client_uid
					  AND orders.uid='$uid'
					  ORDER BY orders.oid DESC";
		
		$query = $this->db->query($sql);
		
		$order_list= array();
		
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
			
				$order = array();
					
				$order['oid'] = $result['oid'];
				$order['prob'] = $result['prob'];
				$order['extra'] = $result['extra'];
				$order['status'] = $result['status'];
				$order['lat'] = $result['lat'];
				$order['long'] = $result['longi'];
				$now=strtotime(date("Y-m-d"));
				$past=strtotime($result['order_date']);
				$diff=$now-$past;
				$day=floor($diff/(60*60*24));
				if($day==0)
				{
				
					$diff=strtotime(date("H:i:s"))-strtotime($result['order_time']);
				
					$temp=$diff/86400; // 60 sec/min*60 min/hr*24 hr/day=86400 sec/day
				
					// days
					$days=floor($temp);$temp=24*($temp-$days);
					// hours
					$hours=floor($temp);$temp=60*($temp-$hours);
					// minutes
					$minutes=floor($temp); $temp=60*($temp-$minutes);
					// seconds
					$seconds=floor($temp);
				
					if($hours==0){
						if($minutes==0){
							$day=$seconds." sec ago";
						}else{
							$day=$minutes." mins ago";
						}
				
					}else{
						$day=$hours." hrs ago";
					}
				
				}else
				{
					if($day<=31){
						$day=$day." day(s) ago.";
					}else{
							
						$day=ceil($day/30);
						if($day<=12)
						{
							$day=$day." month(s) ago.";
						}else{
							$day=ceil($day/12);
							$day=$day." year(s) ago.";
						}
					}
				}$order['day'] = $day;
				$order['finish_date_time'] = $result['finish_date_time'];
				$order['name'] = $result['name'];
				$order['mobile'] = $result['mobile'];
					
				$order_list[]=$order;
					
			}
			$output['order'] =  $order_list;
				
				
			$this->output->set_content_type('application/json');
			echo json_encode($output);
		
		}
		
	}

	public function recent_order(){
		//http://localhost/mobile_mechanic/webservice/recent_order?uid=1
		$uid=$_GET['uid'];
	
		$sql="SELECT orders.oid as oid,
		orders.problem as prob,
		orders.extra as extra,
		orders.status as status,
		orders.latitude as lat,
		orders.longitude as longi,
		orders.order_date as order_date,
		orders.order_time as order_time,
		orders.paid as paid,
		orders.finish_date_time as finish_date_time,
		user.name as name,
		user.mobile as mobile
		FROM order_data orders,user_data user
		WHERE user.uid=orders.uid
		AND orders.client_uid='$uid'
		ORDER BY orders.oid DESC";
	
		$query = $this->db->query($sql);
	
		$order_list= array();
	
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
					
				$order = array();
					
				$order['oid'] = $result['oid'];
				$order['prob'] = $result['prob'];
				$order['extra'] = $result['extra'];
				$order['status'] = $result['status'];
				$order['lat'] = $result['lat'];
				$order['long'] = $result['longi'];
				$now=strtotime(date("Y-m-d"));
				$past=strtotime($result['order_date']);
				$diff=$now-$past;
				$day=floor($diff/(60*60*24));
				if($day==0)
				{
				
					$diff=strtotime(date("H:i:s"))-strtotime($result['order_time']);
				
					$temp=$diff/86400; // 60 sec/min*60 min/hr*24 hr/day=86400 sec/day
				
					// days
					$days=floor($temp);$temp=24*($temp-$days);
					// hours
					$hours=floor($temp);$temp=60*($temp-$hours);
					// minutes
					$minutes=floor($temp); $temp=60*($temp-$minutes);
					// seconds
					$seconds=floor($temp);
				
					if($hours==0){
						if($minutes==0){
							$day=$seconds." sec ago";
						}else{
							$day=$minutes." mins ago";
						}
				
					}else{
						$day=$hours." hrs ago";
					}
				
				}else
				{
					if($day<=31){
						$day=$day." day(s) ago.";
					}else{
							
						$day=ceil($day/30);
						if($day<=12)
						{
							$day=$day." month(s) ago.";
						}else{
							$day=ceil($day/12);
							$day=$day." year(s) ago.";
						}
					}
				}
				$order['days'] = $day;
				$order['paid'] = $result['paid'];
				$order['finish_date_time'] = $result['finish_date_time'];
				$order['name'] = $result['name'];
				$order['mobile'] = $result['mobile'];
					
				$order_list[]=$order;
					
			}
			$output['order'] =  $order_list;
	
	
			$this->output->set_content_type('application/json');
			echo json_encode($output);
	
		}
	
	}
	public function cancel_order()
	{
		$oid=$_GET['oid'];
	
		$sql = " UPDATE order_data SET status='Cancel' WHERE oid='$oid'";
	
		$query = $this->db->query($sql);
		if($query)
		{
			$this->output->set_output(json_encode(array("status" => "success")));
		}
		else
		{
			$this->output->set_output(json_encode(array("status" => "fail")));
		}
	}
	
	public function view_profile()
	{
		//http://localhost/mobile_mechanic/webservice/view_profile?uid=1
		$uid=$_GET['uid'];
	
		$sql = "SELECT name,address,email,mobile FROM user_data WHERE uid='$uid' ";
	
		$query = $this->db->query($sql);
		
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
					
				$profile = array();
					
				$profile['name'] = $result['name'];
				$profile['address'] = $result['address'];
				$profile['email'] = $result['email'];
				$profile['mobile'] = $result['mobile'];
				$profile_list[]=$profile;
					
			}
			$output['profile']=$profile_list;
			$this->output->set_content_type('application/json');
			echo json_encode($output);
		}
		else
		{
			$this->output->set_output(json_encode(array("status" => "fail")));
		}
	}
	public function edit_profile()
	{	
		//http://localhost/mobile_mechanic/webservice/edit_profile?name=Nengkhoi&add=Bamon%20leikai&uid=1
		$name=trim($_GET['name']);
		$add=trim($_GET['add']);
		$uid=trim($_GET['uid']);
	
		if($name!="" && $add!="" && $uid!=""){
			
			$name=mysql_real_escape_string($name);
			$add=mysql_real_escape_string($add);
			$uid=mysql_real_escape_string($uid);
			
			
			$sql="UPDATE user_data SET name='$name',address='$add' WHERE uid='$uid'";
			$query = $this->db->query($sql);
		
					if($query){
						$this->output->set_output(json_encode(array("status" => "success")));
					}
					else{
						$this->output->set_output(json_encode(array("status" => "fail")));
					}
			
			
		}else{
			$this->output->set_output(json_encode(array("status" => "empty")));
		}
		
	}
	
	public function mechanic_list(){
		//http://localhost/mobile_mechanic/webservice/mechanic_list?radius=15&lat=78.9999&long=43.8888
		$rad=$_GET['radius'];
		$lat=$_GET['lat'];
		$long=$_GET['long'];
	
		$sql="SELECT
		user.uid as uid,
		user.name as name,
		user.address as address,
		user.mobile as mobile,
		mech.available as avail,
		mech.field as field,
		loc.latitude as lat,
		loc.longitude as longi,
		loc.update_date as update_date,
		loc.update_time as update_time,
		(((acos(sin(('$lat'*pi()/180))*sin((loc.latitude*pi()/180))+cos(('$lat'*pi()/180))*cos((loc.latitude*pi()/180))*cos((('$long'- loc.longitude)*pi()/180))))*180/pi())*60*1.1515) as distance
		FROM user_data user,mechanic mech,loc_data loc
		WHERE loc.uid=mech.uid AND mech.uid=user.uid HAVING distance<=$rad 
		ORDER BY distance DESC";
		$query = $this->db->query($sql);
	
		$mechanic_list= array();
	
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
					
				$order = array();
					
				$order['uid'] = $result['uid'];
				$order['name'] = $result['name'];
				$order['address'] = $result['address'];
				$order['mobile'] = $result['mobile'];
				$order['avail'] = $result['avail'];
				$order['field'] = $result['field'];
				$order['lat'] = $result['lat'];
				$order['longi'] = $result['longi'];
				$now=strtotime(date("Y-m-d"));
				$past=strtotime($result['update_date']);
				$diff=$now-$past;
				$day=floor($diff/(60*60*24));
				if($day==0)
				{
				
					$diff=strtotime(date("H:i:s"))-strtotime($result['update_time']);
						
					$temp=$diff/86400; // 60 sec/min*60 min/hr*24 hr/day=86400 sec/day
						
					// days
					$days=floor($temp);$temp=24*($temp-$days);
					// hours
					$hours=floor($temp);$temp=60*($temp-$hours);
					// minutes
					$minutes=floor($temp); $temp=60*($temp-$minutes);
					// seconds
					$seconds=floor($temp);
						
					if($hours==0){
						if($minutes==0){
							$day=$seconds." sec ago";
						}else{
							$day=$minutes." mins ago";
						}
				
					}else{
						$day=$hours." hrs ago";
					}
				
				}else
				{
					if($day<=31){
						$day=$day." day(s) ago.";
					}else{
							
						$day=ceil($day/30);
						if($day<=12)
						{
							$day=$day." month(s) ago.";
						}else{
							$day=ceil($day/12);
							$day=$day." year(s) ago.";
						}
					}
				}
				$order['days'] = $day;
				$order['distance'] = round($result['distance'],2);
					
				$mechanic_list[]=$order;
					
			}
			$output['mechanic'] =  $mechanic_list;
	
	
			$this->output->set_content_type('application/json');
			echo json_encode($output);
	
		}
	
	}
	public function mechanic_detail(){
		//http://localhost/mobile_mechanic/webservice/mechanic_detail?uid=1&lat=989&long=98989
		$uid=$_GET['uid'];
		$lat=$_GET['lat'];
		$long=$_GET['long'];
	
		$sql="SELECT
		user.uid as uid,
		user.name as name,
		user.address as address,
		user.mobile as mobile,
		mech.available as avail,
		mech.field as field,
		loc.latitude as lat,
		loc.longitude as longi,
		loc.update_date as update_date,
		loc.update_time as update_time,
		(((acos(sin(('$lat'*pi()/180))*sin((loc.latitude*pi()/180))+cos(('$lat'*pi()/180))*cos((loc.latitude*pi()/180))*cos((('$long'- loc.longitude)*pi()/180))))*180/pi())*60*1.1515) as distance
		FROM user_data user,mechanic mech,loc_data loc
		WHERE loc.uid=mech.uid AND mech.uid=user.uid AND user.uid='$uid'
		LIMIT 1";
		$query = $this->db->query($sql);
	
		$mechanic_list= array();
	
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
					
				$order = array();
					
				$order['uid'] = $result['uid'];
				$order['name'] = $result['name'];
				$order['address'] = $result['address'];
				$order['mobile'] = $result['mobile'];
				$order['avail'] = $result['avail'];
				$order['field'] = $result['field'];
				$order['lat'] = $result['lat'];
				$order['longi'] = $result['longi'];
				$now=strtotime(date("Y-m-d"));
				$past=strtotime($result['update_date']);
				$diff=$now-$past;
				$day=floor($diff/(60*60*24));
				if($day==0)
				{
	
					$diff=strtotime(date("H:i:s"))-strtotime($result['update_time']);
	
					$temp=$diff/86400; // 60 sec/min*60 min/hr*24 hr/day=86400 sec/day
	
					// days
					$days=floor($temp);$temp=24*($temp-$days);
					// hours
					$hours=floor($temp);$temp=60*($temp-$hours);
					// minutes
					$minutes=floor($temp); $temp=60*($temp-$minutes);
					// seconds
					$seconds=floor($temp);
	
					if($hours==0){
						if($minutes==0){
							$day=$seconds." sec ago";
						}else{
							$day=$minutes." mins ago";
						}
	
					}else{
						$day=$hours." hrs ago";
					}
	
				}else
				{
					if($day<=31){
						$day=$day." day(s) ago.";
					}else{
							
						$day=ceil($day/30);
						if($day<=12)
						{
							$day=$day." month(s) ago.";
						}else{
							$day=ceil($day/12);
							$day=$day." year(s) ago.";
						}
					}
				}
				$order['days'] = $day;
				$order['distance'] = round($result['distance'],2);
					
				$mechanic_list[]=$order;
					
			}
			$output['mechanic'] =  $mechanic_list;
	
	
			$this->output->set_content_type('application/json');
			echo json_encode($output);
	
		}
	
	}
	public function search_mechanic(){
		//http://localhost/mobile_mechanic/webservice/search_mechanic?radius=15&lat=78.9999&long=43.8888&field=Tyres
		$rad=$_GET['radius'];
		$lat=$_GET['lat'];
		$long=$_GET['long'];
		$field=$_GET['field'];
		$sql="SELECT
		user.uid as uid,
		user.name as name,
		user.address as address,
		user.mobile as mobile,
		mech.available as avail,
		mech.field as field,
		loc.latitude as lat,
		loc.longitude as longi,
		loc.update_date as update_date,
		loc.update_time as update_time,
		(((acos(sin(('$lat'*pi()/180))*sin((loc.latitude*pi()/180))+cos(('$lat'*pi()/180))*cos((loc.latitude*pi()/180))*cos((('$long'- loc.longitude)*pi()/180))))*180/pi())*60*1.1515) as distance
		FROM user_data user,mechanic mech,loc_data loc
		WHERE loc.uid=mech.uid AND mech.uid=user.uid AND mech.field='$field'  HAVING distance<=$rad
		ORDER BY distance DESC";
		$query = $this->db->query($sql);
	
		$mechanic_list= array();
	
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
					
				$order = array();
					
				$order['uid'] = $result['uid'];
				$order['name'] = $result['name'];
				$order['address'] = $result['address'];
				$order['mobile'] = $result['mobile'];
				$order['avail'] = $result['avail'];
				$order['field'] = $result['field'];
				$order['lat'] = $result['lat'];
				$order['longi'] = $result['longi'];
				$now=strtotime(date("Y-m-d"));
				$past=strtotime($result['update_date']);
				$diff=$now-$past;
				$day=floor($diff/(60*60*24));
				if($day==0)
				{
	
					$diff=strtotime(date("H:i:s"))-strtotime($result['update_time']);
	
					$temp=$diff/86400; // 60 sec/min*60 min/hr*24 hr/day=86400 sec/day
	
					// days
					$days=floor($temp);$temp=24*($temp-$days);
					// hours
					$hours=floor($temp);$temp=60*($temp-$hours);
					// minutes
					$minutes=floor($temp); $temp=60*($temp-$minutes);
					// seconds
					$seconds=floor($temp);
	
					if($hours==0){
						if($minutes==0){
							$day=$seconds." sec ago";
						}else{
							$day=$minutes." mins ago";
						}
	
					}else{
						$day=$hours." hrs ago";
					}
	
				}else
				{
					if($day<=31){
						$day=$day." day(s) ago.";
					}else{
							
						$day=ceil($day/30);
						if($day<=12)
						{
							$day=$day." month(s) ago.";
						}else{
							$day=ceil($day/12);
							$day=$day." year(s) ago.";
						}
					}
				}
				$order['days'] = $day;
				$order['distance'] = round($result['distance'],2);
					
				$mechanic_list[]=$order;
					
			}
			$output['mechanic'] =  $mechanic_list;
	
	
			$this->output->set_content_type('application/json');
			echo json_encode($output);
	
		}
	
	}
	public function findmechanic(){
		//http://yourdomain.com?number=#mobile#&msg=#fullmessage#
		$number=$_POST['number'];
		$msg=$_POST['msg'];
		//$number = $_REQUEST["number"];
		//$msg = $_REQUEST["message"];
		//$keyword = $_REQUEST["keyword"];
		$rad=5000;
		
		$str=explode('MECHANIC',$msg,2);
		$field= trim($str[0]);
		$address=trim($str[1]);
		
		$coordinates = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=true');
		$coordinates = json_decode($coordinates);
		
		$lat= $coordinates->results[0]->geometry->location->lat;
		$long= $coordinates->results[0]->geometry->location->lng;
		
		
		
		$sql="SELECT
		user.uid as uid,
		user.name as name,
		user.address as address,
		user.mobile as mobile,
		mech.available as avail,
		mech.field as field,
		loc.latitude as lat,
		loc.longitude as longi,
		loc.update_date as update_date,
		loc.update_time as update_time,
		(((acos(sin(('$lat'*pi()/180))*sin((loc.latitude*pi()/180))+cos(('$lat'*pi()/180))*cos((loc.latitude*pi()/180))*cos((('$long'- loc.longitude)*pi()/180))))*180/pi())*60*1.1515) as distance
		FROM user_data user,mechanic mech,loc_data loc
		WHERE loc.uid=mech.uid AND mech.uid=user.uid AND mech.field like '%$field%' AND mech.available='YES'   HAVING distance<=$rad
		ORDER BY distance DESC LIMIT 1";
		$query = $this->db->query($sql);
		
		$flag=0;
		if($query)
		{
			while($result=mysql_fetch_array($query->result_id)){
				$flag=1;
					
				
				$name= $result['name'];
				$address = $result['address'];
				$mobile = $result['mobile'];
				
				$dist = round($result['distance'],2);
				$sms_text="Dear customer here are the detail of mechanic. Name:".$name." Address: ".$address." Mobile: ".$mobile." Approx ".$dist." km from your address.";  
			}
		}
		if($flag==1){
			$sms_text="Dear customer here are the detail of mechanic. Name:".$name." Address: ".$address." Mobile: ".$mobile." Approx ".$dist." km from your address.";
				
		}else{
			$sms_text="Dear customer, there is no mechanic available of your requirement near you. Please try a different address or pincode.";
			
		}
		
		$authKey = "9894A3pFnKl9R25630c16b";
		
		// Multiple mobiles numbers separated by comma
		$mobileNumber = $number;
		
		// Sender ID,While using route4 sender id should be 6 characters long.
		$senderId = "MOBIMP";
		
		// Your message to send, Add URL encoding here.
		$sms_text = urlencode ( $sms_text );
		
		// Define route
		$route = "route4";
		// Prepare you post parameters
		$postData = array (
				'authkey' => $authKey,
				'mobiles' => $mobileNumber,
				'message' => $sms_text,
				'sender' => $senderId,
				'route' => $route
		);
		
		// API URL
		$url = "http://sms.ssdindia.com/api/sendhttp.php";
		
		// init the resource
		$ch = curl_init ();
		curl_setopt_array ( $ch, array (
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $postData
		) )
		// ,CURLOPT_FOLLOWLOCATION => true
		;
		
		// Ignore SSL certificate verification
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		
		// get response
		$output = curl_exec ( $ch );
		
		// Print error if any
		if (curl_errno ( $ch )) {
			echo 'error:' . curl_error ( $ch );
		}
		
		curl_close ( $ch );
		
	}
}