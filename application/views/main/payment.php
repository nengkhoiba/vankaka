<?php $this->load->view('global/header');?>
<?php $this->load->view('global/menu');?>
<?php echo form_open('datacontroller/updatepayment')?>
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
			                   Session
			                  </div>
			                  <?php $this->load->view('global/drop_down_session')?>
			                </div>
			                <?php echo form_error('OptSession');?>
		              
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

<?php $this->load->view('global/footer');?>
<script type="text/javascript">
$(document).ready(function() {
	  $("#statussuccess-alert").fadeTo(2000, 500).slideUp(500, function(){
		    $("#statussuccess-alert").slideUp(500);
		});
	  search();
	  });
	  
	  function search()
	  {
		  var url = "<?php echo site_url('datacontroller/loadDT_payment?k=');?>"+document.getElementById('OptSession').value+"&l="+document.getElementById('Optschool').value;
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
</script>