<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nav_controller extends CI_Controller {
    

    public function home(){
        $this->load->view('home');        
}
public function signup()
{
    $this->load->view('main/signup');
}
public function logout()
{
    $this->session->set_userdata('login',null);
    $this->session->set_userdata('role',null);
    $this->session->set_userdata('loginstatus',"Sucessfully Logout");
    redirect('home');
}
public function add_school()
{
    $this->load->view('master/school');
}
public function add_student()
{
    $this->load->view('master/student');
}
public function add_session()
{
    $this->load->view('master/session');
}
public function payment()
{
    $this->load->view('main/payment');
}
}
