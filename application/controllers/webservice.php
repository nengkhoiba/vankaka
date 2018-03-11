<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Webservice extends CI_Controller{
    
    function generateRandomString($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz981u9unakhkkjhJHJGYFUFGKUGWW';
        
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++)
        {
            
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
            
        }
        
        
        return $randomString;
        
    }
    
public function add_school()
{
    //localhost/vankaka/webservice/add_school?name=Mangoljao%English%School&address=Top%Awang%leikai&stime=9:30&etime=3:30&batch=2
    $school=mysql_real_escape_string(trim($_GET['name']));
    $address=mysql_real_escape_string(trim($_GET['address']));
    $start_time=mysql_real_escape_string(trim($_GET['stime']));
    $end_time=mysql_real_escape_string(trim($_GET['etime']));
    $batch=mysql_real_escape_string(trim($_GET['batch']));
    $id=$this->session->userdata('login');
  if($school!=""&&$address!=""&&$start_time!=""&&$end_time!=""&&$batch!=""&&$id!="")
  {
      $sql="INSERT INTO `vk_school`( `name`, `address`, `batch`, `starttime`, `endtime`, `added_by`, `isActive`) 
                            VALUES ('$school','$address','$batch','$start_time','$end_time','$id',1)";
      $query=$this->db->query($sql);
      if($query)
      {
          $this->output->set_output(json_encode(array("status"=>"successfully added")));
      }
      else 
      {
          $this->output->set_output(json_encode(array("status"=>"query error")));
      }
  }
  else {
      $this->output->set_output(json_encode(array("status"=>"form error")));
  }
}
public function add_user()
{
    $this->load->library('encrypt');
    //localhost/vankaka/webservice/add_user?name=Borison&address=Moirangkampu&age=22&mobile=9089779715&password=gg
    $user_name=mysql_real_escape_string(trim($_GET['name']));
    $address=mysql_real_escape_string(trim($_GET['address']));
    $age=mysql_real_escape_string(trim($_GET['age']));
    $mobile=mysql_real_escape_string(trim($_GET['mobile']));
    $id=$this->session->userdata('login');
    $pass=mysql_real_escape_string(trim($_GET['password']));
    if($user_name!=""&&$address!=""&&$age!=""&&$mobile!=""&&$id!="")
    {
        $sql="INSERT INTO `vk_user_data`(`name`, `address`, `age`, `mobile`, `added_by`, `isActive`) 
                                 VALUES ('$user_name','$address','$age','$mobile','$id',1)";
        if($query=$this->db->query($sql))
        {
            $sql1="SELECT `user_id` FROM `vk_user_data` ORDER by vk_user_data.user_id DESC LIMIT 1";            
            if($query1=$this->db->query($sql1))
            {
                while($result=mysql_fetch_array($query1->result_id))
                {
                    $usid=$result['user_id'];
                }
                $otp=$this->generateRandomString(5);
                $pass=$this->encrypt->encode($pass);
                $sql3="INSERT INTO `vk_login`(`user_id`, `mobile`, `password`, `otp`, `isActive`)
                                      VALUES ('$usid','$mobile','$pass','$otp',1)";
                $query3=$this->db->query($sql3);
                if($query3)
                {
                    $this->output->set_output(json_encode(array("status"=>"user successfully added")));
                }
                else {
                    $this->output->set_output(json_encode(array("status"=>"query error")));
                }
            }
            else
            {
                $this->output->set_output(json_encode(array("status"=>"form error")));
            }
        }
    }
}
public function add_session()
{
    //localhost/vankaka/webservice/add_session?year=5
    $id=$this->session->userdata('login');
    $year=mysql_real_escape_string(trim($_GET['year']));
    if($year!=""&&$id!="")
    {
        $sql="INSERT INTO `vk_sessions`(`year`, `added_by`, `isActive`)
                             VALUES ('$year','$id',1)";
        if($query=$this->db->query($sql))
        {
            $this->output->set_output(json_encode(array("status"=>"session successfully added")));
        }
        else 
        {
            $this->output->set_output(json_encode(array("status"=>"failed at query")));
        }
    }
    else
    {
        $this->output->set_output(json_encode(array("status"=>"form error")));
    }
}
public function add_student()
{
    //localhost/vankaka/webservice/add_student?name=athen&address=tokyo&father=naruto&mother=hinata&mobile=1234567890
    $name=mysql_real_escape_string(trim($_GET['name']));
    $address=mysql_real_escape_string(trim($_GET['address']));
    $father_name=mysql_real_escape_string(trim($_GET['father']));
    $mother_name=mysql_real_escape_string(trim($_GET['mother']));
    $mobile=mysql_real_escape_string(trim($_GET['mobile']));
    $id=$this->session->userdata('login');
    if($name!=""&&$address!=""&&$father_name!=""&&$mother_name!=""&&$mobile!=""&&$id!="")
    {
        $sql="INSERT INTO `vk_student`(`name`, `address`, `f_name`, `m_name`, `mobile`, `added_by`, `isActive`) 
                               VALUES ('$name','$address','$father_name','$mother_name','$mobile','$id',1)";
        if($query=$this->db->query($sql))
        {
            $this->output->set_output(json_encode(array("status"=>"student added")));
        }
        else 
        {
            $this->output->set_output(json_encode(array("status"=>"failed at query")));
        }
    }
    else 
    {
        $this->output->set_output(json_encode(array("status"=>"form error")));
    }
}
}