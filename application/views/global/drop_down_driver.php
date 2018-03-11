
 <select class="form-control form-control-lg " id="OptDriver" name="OptDriver">
 <option value=0 >- Select Driver - </option>
 
 <?php 
 $id=$this->session->userdata('login');
 $sql="SELECT `user_id`, `name` FROM `vk_user_data` WHERE `isActive`=1 AND `added_by`='$id' OR `user_id`='$id'";

$query = $this->db->query($sql);
if($query)
{
	
	while($result=mysql_fetch_array($query->result_id)){
		
		?>
		<option value="<?php echo $result['user_id'];?>"><?php echo $result['name'];?></option>
		<?php 
	}
	
}

?>
 </select>