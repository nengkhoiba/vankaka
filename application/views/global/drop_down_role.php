
 <select class="form-control form-control-lg " id="OptRole" name="OptRole">
 <option value=0 >- Select Role - </option>
 
 <?php $sql="SELECT `role_id`,`description`, `isActive` FROM `vk_role` WHERE `isActive`=1" ;

$query = $this->db->query($sql);
if($query)
{
	
	while($result=mysql_fetch_array($query->result_id)){
		
		?>
		<option value=<?php echo $result['role_id'];?>><?php echo $result['description'];?></option>
		<?php 
	}
	
}

?>
 </select>