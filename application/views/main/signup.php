<?php $this->load->view('global/header')?>;
 
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Please Login or Sign up </h4>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                   <h4>  <strong>Login</strong>:</h4>
                    <br />
                    <?php echo  form_open('datacontroller/login');?>
                     <label>Mobile Number : </label>
                        <input id="txtmobile" name="txtmobile" type="text" class="form-control" placeholder="Enter Mobile Number" />
                        </br>
                        <label>Enter Password :  </label>
                        <input id="txtpass" name="txtpass" type="password" class="form-control" placeholder="Enter password"/>
                        <hr />
                        <button type="submit" class="btn btn-submit">Submit</button>
                        <?php echo form_close();?>
                </div>
                <div class="col-md-2">
                    

                </div>
                 <div class="col-md-6">
                  <?php echo form_open('datacontroller/signup');?>
                   <h4> <strong>Sign Up Now</strong> :</h4>
                    <br />    
                    <input id="txtname" name="txtname" type="text" class="form-control" placeholder="Enter Full Name"/>
                        </br>   
                        <?php echo form_error('txtname');?>            
                        <input id="txtmobile" name="txtmobile" type="text" class="form-control" placeholder="Enter Mobile Number"/>
                        </br> 
                         <?php echo form_error('txtmobile');?>
                        <input id="txtpass" name="txtpass" type="password" class="form-control" placeholder="Enter Password"/>
                          </br>	
                          <?php echo form_error('txtpass');?>
                        <input id="txtrepass" name="txtrepass" type="password" class="form-control" placeholder="ReEnter Password"/>
                          </br>	
                          <?php echo form_error('txtrepass');?>
                        <input id="txtadd" name="txtadd" type="text" class="form-control" placeholder="Enter Address"/>
                          </br>	
                          <?php echo form_error('txtadd');?>
                          <div class="col-md-4">
                    <input id="txtage" name="txtage" type="password" class="form-control" placeholder="Enter Age"/>
                        	<?php echo form_error('txtage');?>
                        <hr />

                </div>
                <div class="col-md-4">
                    <?php $this->load->view('global/drop_down_role');?>

                        <hr />
                </div>
                        
                        <button type="submit" class="btn btn-submit">Submit</button>
                        <?php echo form_close();?>
                </div>

            </div>
        </div>
    </div>
    <?php $this->load->view('global/footer.php');?>
<script type="text/javascript">
  $(document).ready(function() {
	  $("#success-alert").fadeTo(1500, 500).slideUp(500, function(){("#success-alert").slideUp(500);
		});
	  $("#loginsuccess-alert").fadeTo(1500, 500).slideUp(500, function(){("#loginsuccess-alert").slideUp(500);
		});
  });                                      
  </script>