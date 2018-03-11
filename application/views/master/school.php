<?php $this->load->view('global/header')?>;
<?php $this->load->view('global/menu'); ?>
<?php echo form_open('datacontroller/updateschool');?>
<div class="row">
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   School Name
			                  </div>
			                  <input id="postType" type="hidden" name="postType">
			                  <input id="edit" type="hidden" name="edit">
			                  <input id="txtschool" name="txtschool" type="text" class="form-control" value="<?php echo set_value('txtschool')?>">
			                </div>
			                <?php echo form_error('txtschool');?>
		              
		              </div>
	     			</div>
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Adress
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
			                   Batch
			                  </div>
			                 
			                  <input id="txtBatch" name="txtBatch" type="text" class="form-control" value="<?php echo set_value('txtBatch')?>">
			                </div>
			                <?php echo form_error('txtBatch');?>
		              
		              </div>
	     			</div>
	   </div>
	   <div class="row">
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   Start Time
			                  </div>
			                  
			                  <input id="timestart" name="timestart" type="text" class="form-control" value="<?php echo set_value('timestart')?>">
			                </div>
			                <?php echo form_error('timestart');?>
		              
		              </div>
	     			</div>
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                   End Time
			                  </div>
			                 
			                  <input id="timeEnd" name="timeEnd" type="text" class="form-control" value="<?php echo set_value('timeEnd')?>">
			                </div>
			                <?php echo form_error('timeEnd');?>
		              
		              </div>
	     			</div>
	     			
	     			<div class="col-sm-4">
		     			<div class="form-group">
		            	
			                <div class="input-group">
			                  <div class="input-group-addon">
			                    Active
			                  </div>
			                  <select id="ddlActive" name="ddlActive" class="form-control">
			                  	<option value="1">Yes</option>
			                  	<option value="0">No</option>
			                  </select>
			                </div>
		              
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
                            <div class="row container-fluid">
     			<div id="data_container">
     			
     			</div>
     		</div>
                            </div>
                      
                    
                    
	     			
<?php echo form_close();?>
<?php $this->load->view('global/footer.php');?>
<script type="text/javascript">
$(document).ready(function() {
	  $("#statussuccess-alert").fadeTo(2000, 500).slideUp(500, function(){
		    $("#statussuccess-alert").slideUp(500);
		});
	  search();
	  });
	  
	  function search()
	  {
		  var url = "<?php echo site_url('datacontroller/loadDT_school?q=');?>"+document.getElementById('txtschool').value+"&j="+document.getElementById('txtBatch').value+"&k="+document.getElementById('ddlActive').value;
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
		function edit(id,name,address,batch,start,end)
		{
			document.getElementById('txtschool').value=name;
			document.getElementById('postType').value=id;
			document.getElementById('txtaddress').value=address;
			document.getElementById('txtBatch').value=batch;
			document.getElementById('timestart').value=start;
			document.getElementById('timeEnd').value=end;
			document.getElementById('edit').value=id;	
		}
		function remove(id){
			if (confirm('Are you sure you want to delete?')) {
				var url = "<?php echo site_url('datacontroller/removeDT_school?id=');?>"+id;
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