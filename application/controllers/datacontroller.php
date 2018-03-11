<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datacontroller extends CI_Controller {
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
        
public function signup()
{
    $this->load->helper(array('form', 'url'));
    
    $this->load->library('form_validation');
    $this->load->library('encrypt');
    
    $this->form_validation->set_rules('txtname', 'Full Name', 'required');
    $this->form_validation->set_rules('txtmobile', 'Mobile Number', 'max_length[13]|min_length[10]|required');
    $this->form_validation->set_rules('txtpass', 'Password', 'required');
    $this->form_validation->set_rules('txtrepass', 'Confirmation', 'matches[txtpass]|required');
    $this->form_validation->set_rules('txtadd', 'Address', 'required');
    $this->form_validation->set_rules('txtage', 'First Name', 'is_natural_no_zero|required');
    $this->form_validation->set_rules('OptRole', 'Role', 'is_natural_no_zero|required',array("required"=>"please choose a Role"));
    
    if ($this->form_validation->run() == FALSE)
    {
        $this->session->set_userdata('signup',"Some error occured");
        $this->load->view('main/signup');
        
    }
    else
    {
        $name=mysql_real_escape_string(trim($_POST['txtname']));
        $mobile=mysql_real_escape_string(trim($_POST['txtmobile']));
        $pass=mysql_real_escape_string(trim($_POST['txtpass']));
        $address=mysql_real_escape_string(trim($_POST['txtadd']));
        $age=mysql_real_escape_string(trim($_POST['txtage']));
        $role=mysql_real_escape_string(trim($_POST['OptRole']));
        //$pass=$this->encrypt->encode($pass);
        $sql="INSERT INTO `vk_user_data`(`name`, `address`, `age`, `mobile`,`isActive`)
                                 VALUES ('$name','$address','$age','$mobile',1)";
        $query=$this->db->query($sql);
        if($query)
        {
            $sql1="SELECT `user_id` FROM `vk_user_data` ORDER by vk_user_data.user_id DESC LIMIT 1";
            $query1=$this->db->query($sql1);
            if($query1)
            {
                while($result=mysql_fetch_array($query1->result_id))
                {
                    $usid=$result['user_id'];
                }
                $otp=$this->generateRandomString(5);
                $sql3="INSERT INTO `vk_login`(`user_id`, `mobile`, `password`, `otp`,`Role`, `isActive`) 
                                      VALUES ('$usid','$mobile','$pass','$otp','$role',1)";
                $query3=$this->db->query($sql3);
                if($query3)
                {
                    $sql4="UPDATE `vk_user_data` SET `added_by`='$usid' WHERE `user_id`='$usid'";
                    if($query4=$this->db->query($sql4))
                    {
                        $this->session->set_userdata('signup',"Sucessfully created account");
                        redirect('home');
                    }
                   
                }
                else {
                    $this->session->set_userdata('signup',"failed");
                    redirect('home');
                }
            }
            else 
            {
                $this->session->set_userdata('signup',"failed");
                redirect('home');
            }
        }
        else 
        {
            $this->session->set_userdata('signup',"Failed");
            redirect('home');
        }
        
    }
}
public function login()
{
    $this->load->helper(array('form', 'url'));
    
    $this->load->library('form_validation');
    
    
    $this->form_validation->set_rules('txtmobile', 'Mobile Number', 'max_length[13]|min_length[10]|required');
    $this->form_validation->set_rules('txtpass', 'password','required');
    if ($this->form_validation->run() == FALSE)
    {
        $this->session->set_userdata('login',"Some error occured");
        $this->load->view('main/signup');
        
    }
    else {
        $mobile=mysql_real_escape_string(trim($_POST['txtmobile']));
        $pass=mysql_real_escape_string(trim($_POST['txtpass']));
        $sql="SELECT `user_id`,`Role` FROM `vk_login` WHERE `mobile`='$mobile' AND `password`='$pass'";
        $query=$this->db->query($sql);
        if($query)
        {
            if($query->num_rows()>0)
            {
                while($result=mysql_fetch_array($query->result_id))
                {
                    $usid=$result['user_id'];
                    $role=$result['Role'];
                }
                $this->session->set_userdata('login',$usid);
                $this->session->set_userdata('role',$role);
                $this->session->set_userdata('loginstatus',"Sucessfully Login");
                redirect('nav_controller/home');
            }
        }
        else {
            $this->session->set_userdata('loginstatus',"failed");
            redirect('home');
        }
    }
}
public function loadDT_school()
{
    $this->load->view('data/school_data');
}
public function loadDT_session()
{
    $this->load->view('data/session_data');
}
public function loadDT_student()
{
    $this->load->view('data/student_data');
}
public function loadDT_payment()
{
    $this->load->view('data/payment_data');
}
public function removeDT_school()
{
    $sid=$_GET['id'];
    $sql="UPDATE `vk_school` SET `isActive`=0 WHERE `id`='$sid'";
    $query=$this->db->query($sql);
    if($query)
    {
        $this->session->set_userdata('status',"succesfully deleted");
    }
    else
    {
        $this->session->set_userdata('status',"Failed");
    }
}
public function removeDT_session()
{
    $sid=$_GET['id'];
    $sql="UPDATE `vk_sessions` SET  `isActive`=0 WHERE `id`='$sid'";
    $query=$this->db->query($sql);
    if($query)
    {
        $this->session->set_userdata('status',"succesfully deleted");
    }
    else
    {
        $this->session->set_userdata('status',"Failed");
    }
}
public function removeDT_student()
{
    $sid=$_GET['id'];
    $sql="UPDATE `vk_student` SET  `isActive`=0 WHERE `id`='$sid'";
    $sql1="UPDATE `vk_student_driver_data` SET  `isActive`=0 WHERE `id`='$sid'";
    $sql2="UPDATE `vk_student_fee_relation` SET  `isActive`=0 WHERE `id`='$sid'";
    $sql3="UPDATE `vk_student_school_relation` SET  `isActive`=0 WHERE `id`='$sid'";
    
    if($query=$this->db->query($sql))
    {
        if($query1=$this->db->query($sql1))
        {
            if($query2=$this->db->query($sql2))
            {
                if($query3=$this->db->query($sql3))
                {
                    $this->session->set_userdata('status',"succesfully deleted");
                }
            }
        }
    }
    else
    {
        $this->session->set_userdata('status',"Failed");
    }
}
public function updateschool()
{
    $this->load->helper(array('form', 'url'));
    
    $this->load->library('form_validation');
    
    
    $this->form_validation->set_rules('txtschool', 'School name', 'required');
    $this->form_validation->set_rules('txtaddress', 'Adress','required');
    $this->form_validation->set_rules('txtBatch', 'Batch', 'required');
    $this->form_validation->set_rules('timestart', 'Start time','required');
    $this->form_validation->set_rules('timeEnd', 'End time', 'required');
    if ($this->form_validation->run() == FALSE)
    {
        $this->session->set_userdata('login',"Some error occured");
        $this->load->view('master/school');
        
    }
    else {
        $school=mysql_real_escape_string(trim($_POST['txtschool']));
        $address=mysql_real_escape_string(trim($_POST['txtaddress']));
        $batch=mysql_real_escape_string(trim($_POST['txtBatch']));
        $s_time=mysql_real_escape_string(trim($_POST['timestart']));
        $e_time=mysql_real_escape_string(trim($_POST['timeEnd']));
        $edit=mysql_real_escape_string(trim($_POST['postType']));
        $sid=mysql_real_escape_string(trim($_POST['edit']));
        
        if($edit!="")
        {
            $sql="UPDATE `vk_school` SET `name`='$school',`address`='$address',`batch`='$batch',
                    `starttime`='$s_time',`endtime`='$e_time' WHERE id='$sid'";
            if($query=$this->db->query($sql))
            {
                $this->session->set_userdata('status', "School updated");
                redirect('nav_controller/add_school');
            }
            else
            {
                $this->session->set_userdata('status', "update failed");
                $this->load->view('master/school');
            }
        }
        else 
        {
            $id=$this->session->userdata('login');
            $sql="INSERT INTO `vk_school`( `name`, `address`, `batch`, `starttime`, `endtime`, `added_by`, `isActive`)
            VALUES ('$school','$address','$batch','$s_time','$e_time','$id',1)";
            if($query=$this->db->query($sql))
            {
                $this->session->set_userdata('status', "School added");
                redirect('nav_controller/add_school');
            }
            else
            {
                $this->session->set_userdata('status', "failed");
                $this->load->view('master/school');
            }
        }
    }
}
public function updatesession()
{
    $this->load->helper(array('form', 'url'));
    
    $this->load->library('form_validation');
    
    
    $this->form_validation->set_rules('session', 'session', 'required');
    
    if ($this->form_validation->run() == FALSE)
    {
        $this->session->set_userdata('login',"Some error occured");
        $this->load->view('master/session');
        
    }
    else {
        $year=mysql_real_escape_string(trim($_POST['session']));       
        $edit=mysql_real_escape_string(trim($_POST['postType']));
        $sid=mysql_real_escape_string(trim($_POST['edit']));
        
        if($edit!="")
        {
            $sql="UPDATE `vk_sessions` SET `year`='$year' WHERE id='$sid'";
            if($query=$this->db->query($sql))
            {
                $this->session->set_userdata('status', "session updated");
                redirect('nav_controller/add_session');
            }
            else
            {
                $this->session->set_userdata('status', "update failed");
                $this->load->view('master/session');
            }
        }
        else
        {
            $id=$this->session->userdata('login');
            $sql="INSERT INTO `vk_sessions`(`year`, `added_by`, `isActive`)
                                    VALUES ('$year','$id',1)";
            if($query=$this->db->query($sql))
            {
                $this->session->set_userdata('status', "session added");
                redirect('nav_controller/add_session');
            }
            else
            {
                $this->session->set_userdata('status', "failed");
                $this->load->view('master/session');
            }
        }
    }
}
public function updatestudent()
{
    $this->load->helper(array('form', 'url'));
    
    $this->load->library('form_validation');    
    
    $this->form_validation->set_rules('txtstu_name', 'student', 'required');
    $this->form_validation->set_rules('txtaddress', 'address', 'required');
    $this->form_validation->set_rules('f_name', 'father name', 'required');
    $this->form_validation->set_rules('m_name', 'mother name', 'required');
    $this->form_validation->set_rules('mobile', 'mobile', 'required');
    $this->form_validation->set_rules('Optschool', 'school', 'required');
    $this->form_validation->set_rules('OptSession', 'session', 'required');
    $this->form_validation->set_rules('class', 'class', 'required');
    $this->form_validation->set_rules('section', 'section', 'required');
    $this->form_validation->set_rules('roll', 'roll', 'required');
    $this->form_validation->set_rules('OptStart', 'start month', 'required');
    $this->form_validation->set_rules('OptEnd', 'end month', 'required');
    $this->form_validation->set_rules('OptDriver', 'Driver', 'required');
    $this->form_validation->set_rules('fee', 'fee', 'required');
    
    if ($this->form_validation->run() == FALSE)
    {
        $this->session->set_userdata('status',"Some error occured");
        $this->load->view('master/student');
        
    }
    else
    {
        $student=mysql_real_escape_string(trim($_POST['txtstu_name']));
        $address=mysql_real_escape_string(trim($_POST['txtaddress']));
        $father=mysql_real_escape_string(trim($_POST['f_name']));
        $mother=mysql_real_escape_string(trim($_POST['m_name']));
        $mobile=mysql_real_escape_string(trim($_POST['mobile']));
        $school=mysql_real_escape_string(trim($_POST['Optschool']));
        $session=mysql_real_escape_string(trim($_POST['OptSession']));
        $class=mysql_real_escape_string(trim($_POST['class']));
        $section=mysql_real_escape_string(trim($_POST['section']));
        $roll=mysql_real_escape_string(trim($_POST['roll']));
        $start=mysql_real_escape_string(trim($_POST['OptStart']));
        $end=mysql_real_escape_string(trim($_POST['OptEnd']));
        $driver=mysql_real_escape_string(trim($_POST['OptDriver']));
        $fee=mysql_real_escape_string(trim($_POST['fee']));
        $id=$this->session->userdata('login');
        $sql="INSERT INTO `vk_student`(`name`, `address`, `f_name`, `m_name`, `mobile`, `added_by`, `isActive`)
                               VALUES ('$student','$address','$father','$mother','$mobile','$id',1)";
        if($query=$this->db->query($sql))
        {
            $sql1="SELECT `id` FROM `vk_student` order by vk_student.id DESC LIMIT 1";
                if($query1=$this->db->query($sql1))
                {
                   while($result=mysql_fetch_array($query1->result_id))
                   {
                       $stu_id=$result['id'];
                   }
                   $sql2="INSERT INTO `vk_student_driver_data`(`session_id`, `school_id`, `driver_id`, `student_id`, `added_by`, `isActive`)
                                                       VALUES ('$session','$school','$driver','$stu_id','$id',1)";
                   if($query2=$this->db->query($sql2))
                   {
                       $sql3="INSERT INTO `vk_student_fee_relation`(`session_id`, `student_id`, `school_id`,`added_by`) 
                                                            VALUES ('$session','$stu_id','$school','$id')";
                       if($query3=$this->db->query($sql3))
                       {
                           $sql4="INSERT INTO `vk_student_school_relation`(`session_id`, `student_id`, `school_id`, `start_month`, `end_month`, `class`, `roll`, `section`, `fee_amount`, `added_by`, `isActive`) 
                                                                   VALUES ('$session','$stu_id','$school','$start','$end','$class','$roll','$section','$fee','$id',1)";
                           if($query4=$this->db->query($sql4))
                           {
                               $this->session->set_userdata('status',"Student added");
                              redirect('nav_controller/add_student');
                           }
                       }
                   }
                }
        }
    }
}
}