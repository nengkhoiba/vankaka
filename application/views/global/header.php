<!DOCTYPE html>
<html xmlns="http://localhost/vankaka">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Vankaka</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" />
     <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <strong>Email: </strong>info@vankaka.com
                    &nbsp;&nbsp;
                    <strong>Support: </strong>+91 9089779715
                </div>

            </div>
        </div>
    </header>
    <!-- HEADER END-->
    
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url();?>">

                    <img src="<?php echo base_url();?>assets/img/vanlogo1.png" />
                </a>

            </div>

            <div class="left-div">
                <div class="user-settings-wrapper">
                    <ul class="nav">

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <span class="glyphicon glyphicon-user" style="font-size: 25px;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-settings">
                                <div class="media">
                                    <a class="media-left" href="#">
                                        <img src="assets/img/64-64.jpg" alt="" class="img-rounded" />
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php 
     		if($this->session->userdata('login')!=null){
     		
     			$id=$this->session->userdata('login');
     			$role=$this->session->userdata('role');
     			$sql="SELECT `name`, `address`, `age`, `mobile`, `profile_url` FROM `vk_user_data`
 WHERE `user_id`='$id' AND `isActive`=1";
     			$query=$this->db->query($sql);
     			while($result=mysql_fetch_array($query->result_id))
     			{
     			    $name=$result['name'];
     			    $adress=$result['address'];
     			    $age=$result['age'];
     			    $mobile=$result['mobile'];
     			    $profile=$result['profile_url'];
     			}
     			$sql1="SELECT `code`, `description` FROM `vk_role` WHERE `role_id`='$role' AND `isActive`=1";
     			$query1=$this->db->query($sql1);
     			while($result=mysql_fetch_array($query1->result_id))
     			{
     			    $rcode=$result['code'];
     			    $rdes=$result['description'];
     			   
     			}
     			 echo $name;?> </h4>
                                        <h5>Address:  <?php echo $adress;?></h5>

                                    </div>
                                        <h5>Mobile: <?php echo $mobile; ?></h5>

                                   
                                </div>
                                <hr />
                                <h5><strong>Role: <?php echo $rcode;?></strong> <?php echo $rdes;?></h5>
                                
                                <hr />
                                <a href="<?php echo $profile;?>" class="btn btn-info btn-sm">Full Profile</a>&nbsp;
                                 <a href="<?php echo base_url();?>/nav_controller/logout" class="btn btn-danger btn-sm">Logout</a>
<?php 
     			
     		}
     		?>
                            </div>
                        </li>


                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
    
    <?php 
     		if($this->session->userdata('signup')!=null){
     		
     			$msg=$this->session->userdata('signup');
     			?>
     			<div id="success-alert" class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Message: </strong> <?php echo $msg;?>
				</div>
     			<?php 
     			$this->session->set_userdata('signup', null);
     		}
     		?>
     		<?php 
     		if($this->session->userdata('loginstatus')!=null){
     		
     			$msg=$this->session->userdata('loginstatus');
     			?>
     			<div id="loginsuccess-alert" class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Message: </strong> <?php echo $msg;?>
				</div>
     			<?php 
     			$this->session->set_userdata('loginstatus', null);
     		}
     		?><?php
     		if($this->session->userdata('status')!=null){
     		
     			$msg=$this->session->userdata('status');
     			?>
     			<div id="statussuccess-alert" class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Message: </strong> <?php echo $msg;?>
				</div>
     			<?php 
     			$this->session->set_userdata('status', null);
     		}
     		?>