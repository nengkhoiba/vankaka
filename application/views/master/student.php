<?php $this->load->view('global/header'); ?>
<?php $this->load->view('global/menu'); ?>
<hr>
<?php echo form_open('datacontroller/updatestudent');?>
<div class="row">
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Student Name
			                  </div>
			                  <input id="postType" type="hidden" name="postType">
			                  <input id="edit" type="hidden" name="edit">
			                  <input id="txtstu_name" name="txtstu_name" type="text" class="form-control" value="<?php echo set_value('txtstu_name')?>">
			                </div>
			                <?php echo form_error('txtstu_name');?>
		              
		              </div>
	     			</div>
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Address
			                  </div>
			                  
			                  <input id="txtaddress" name="txtaddress" type="text" class="form-control" value="<?php echo set_value('txtaddress')?>">
			                </div>
			                <?php echo form_error('txtaddress');?>
		              
		              </div>
	     			</div>
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Father's Name
			                  </div>
			                 
			                  <input id="f_name" name="f_name" type="text" class="form-control" value="<?php echo set_value('f_name')?>">
			                </div>
			                <?php echo form_error('f_name');?>
		              
		              </div>
	     			</div>
	     			
	   </div>
	   <div class="row">
	   <div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Mother's Name
			                  </div>
			                 
			                  <input id="m_name" name="m_name" type="text" class="form-control" value="<?php echo set_value('m_name')?>">
			                </div>
			                <?php echo form_error('m_name');?>
		              
		              </div>
	     			</div>
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Mobile
			                  </div>
			                  
			                  <input id="mobile" name="mobile" type="text" class="form-control" value="<?php echo set_value('mobile')?>">
			                </div>
			                <?php echo form_error('mobile');?>
		              
		              </div>
	     			</div>    			
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   School
			                  </div>
			                  <?php $this->load->view('global/drop_down_school');?>
			                </div>
			                <?php echo form_error('Optschool');?>
		              
		              </div>
	     			</div> 
	     			
	     			</div>
	     			<div class="row">
	   <div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Session
			                  </div>
			                 
			                 <?php $this->load->view('global/drop_down_session');?>
			                </div>
			                <?php echo form_error('OptSession');?>
		              
		              </div>
	     			</div>
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Class
			                  </div>
			                  
			                  <input id="class" name="class" type="text" class="form-control" value="<?php echo set_value('class')?>">
			                </div>
			                <?php echo form_error('class');?>
		              
		              </div>
	     			</div>    			
	     			
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Section
			                  </div>
			                  
			                  <input id="section" name="section" type="text" class="form-control" value="<?php echo set_value('section')?>">
			                </div>
			                <?php echo form_error('section');?>
		              
		              </div>
	     			</div> 
	     			</div>
<div class="row">
	   <div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Roll
			                  </div>
			                 
			                  <input id="roll" name="roll" type="text" class="form-control" value="<?php echo set_value('roll')?>">
			                </div>
			                <?php echo form_error('roll');?>
		              
		              </div>
	     			</div>
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Start Month
			                  </div>
			                  <select id="OptStart" name="OptStart" class="form-control">
			                  <option value="0">-- select --</option>
			                  <option value="Jan">Jan</option>
			                  	<option value="Feb">Feb</option>
			                  	<option value="March">March</option>
			                  	<option value="April">April</option>
			                  	<option value="May">may</option>
			                  	<option value="June">June</option>
			                  	<option value="July">July</option>
			                  	<option value="Aug">Aug</option>
			                  	<option value="Sept">Sept</option>
			                  	<option value="Oct">Oct</option>
			                  	<option value="Nov">Nov</option>
			                  	<option value="Dec">Dec</option>
			                 </select>
			                </div>
			                <?php echo form_error('OptStart');?>
		              
		              </div>
	     			</div>    			
	     			
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   End Month
			                  </div>
			                  <select id="OptEnd" name="OptEnd" class="form-control">
			                  <option value="Jan">-- select --</option>
			                   <option value="Jan">Jan</option>
			                  	<option value="Feb">Feb</option>
			                  	<option value="March">March</option>
			                  	<option value="April">April</option>
			                  	<option value="May">may</option>
			                  	<option value="June">June</option>
			                  	<option value="July">July</option>
			                  	<option value="Aug">Aug</option>
			                  	<option value="Sept">Sept</option>
			                  	<option value="Oct">Oct</option>
			                  	<option value="Nov">Nov</option>
			                  	<option value="Dec">Dec</option>
			                  </select>
			                </div>
			                <?php echo form_error('OptEnd');?>
		              
		              </div>
	     			</div>
	     			
	     			</div>
<div class="row">
	   <div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Driver
			                  </div>
			                 <?php $this->load->view('global/drop_down_driver');?>
			                  
			                </div>
			                <?php echo form_error('OptDriver');?>
		              
		              </div>
	     			</div>
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Fee
			                  </div>
			                  
			                  <input id="fee" name="fee" type="text" class="form-control" value="<?php echo set_value('timestart')?>">
			                </div>
			                <?php echo form_error('fee');?>
		              
		              </div>
	     			</div>    			
	     			
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   is Active
			                  </div>
			                  <select id="OptActive" name="OptActive" class="form-control">
			                  <option value="1">Yes</option>
			                  	<option value="0">No</option>
			                  	</select>
			                </div>
			                <?php echo form_error('OptActive');?>
		              
		              </div>
	     			</div>
	     			
	     			</div>
	     			<div class="row">
	     			<div class="col-sm-3">
	     			<div class="form-group">
	     			<div class="btn-group btn-group-justified" role="group">
						  <div class="btn-group" role="group">
						    <input class="btn btn-default" type="submit" value="Save">
						  </div>
						  <div class="btn-group" role="group">
						 <label class="btn btn-default" onclick="search()">Search</label>
						   </div>
						  <div class="btn-group" role="group">
						  <input class="btn btn-default" type="reset" value="Reset">
						   </div>						 
					</div>
	              
	              </div>
     			</div>
     			<div class="col-sm-3">
     			</div>
     			<div class="col-sm-3">
     			</div>
     			<div class="col-sm-3">
     			</div>
	     			</div>
                        
               <div class="table-responsive">
     			<div id="data_container">
     			
     			</div>
     			</div>
                      
                    
                    
	     			
<?php echo form_close();?>
<?php $this->load->view('global/footer'); ?>
<script type="text/javascript">
$(document).ready(function() {
	  $("#statussuccess-alert").fadeTo(2000, 500).slideUp(500, function(){
		    $("#statussuccess-alert").slideUp(500);
		});
	  search();
	  });
	  
	  function search()
	  {
		  var url = "<?php echo site_url('datacontroller/loadDT_student?q=');?>"+document.getElementById('txtstu_name').value+"&k="+document.getElementById('OptActive').value;
	  	var xmlHttp = GetXmlHttpObject();
	  	if (xmlHttp != null) {
	  		try {
	  			xmlHttp.onreadystatechange=function() {
	  			if(xmlHttp.readyState == 4) {
	  				if(xmlHttp.responseText != null){
	  					
	  					document.getElementById('data_container').innerHTML = xmlHttp.responseText;
	  					$('#table').DataTable({
	  				        dom: 'Bfrtip',
	  				        buttons: [
	  				            'csv', 'pdf', 'print'
	  				        ]
	  				    });
	  				}else{
	  					alert("Error");
	  				}
	  			}
	  		}
	  		xmlHttp.open("GET", url, true);
	  		xmlHttp.send(null);
	  	}
	  	catch(error) {}
	  	}
	  	}
		function edit(id,name,address,father,mother,mobile)
		{
			document.getElementById('txtstu_name').value=name;
			document.getElementById('postType').value=id;
			document.getElementById('txtaddress').value=address;
			document.getElementById('f_name').value=father;
			document.getElementById('m_name').value=mother;
			document.getElementById('mobile').value=mobile;
			document.getElementById('edit').value=id;
			
			
		}
		function remove(id){
			if (confirm('Are you sure you want to delete?')) {
				var url = "<?php echo site_url('datacontroller/removeDT_student?id=');?>"+id;
			  	var xmlHttp = GetXmlHttpObject();
			  	if (xmlHttp != null) {
			  		try {
			  			xmlHttp.onreadystatechange=function() {
			  			if(xmlHttp.readyState == 4) {
			  				if(xmlHttp.responseText != null){
			  					search();
			  				}else{
			  					alert("Error");
			  				}
			  			}
			  		}
			  		xmlHttp.open("GET", url, true);
			  		xmlHttp.send(null);
			  	}
			  	catch(error) {}
			  	}
			} 
		  
			}
</script>