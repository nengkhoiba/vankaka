
 <select class="form-control form-control-lg " id="Optschool" name="Optschool">
 <option value=0 >- Select School - </option>
 
 <?php 
 $id=$this->session->userdata('login');
 $sql="SELECT `id`, `name` FROM `vk_school` WHERE `added_by`='$id'" ;
 if($query=$this->db->query($sql))
{
	
	while($result=mysql_fetch_array($query->result_id)){
		
		?>
		<option value=<?php echo $result['id'];?>><?php echo $result['name'];?></option>
		<?php 
	}
	
}

?>
 </select>