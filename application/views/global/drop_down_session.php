
 <select class="form-control form-control-lg " id="OptSession" name="OptSession">
 <option value=0 >- Select Session - </option>
 
 <?php 
 $id=$this->session->userdata('login');
 $sql="SELECT `id`, `year` FROM `vk_sessions` WHERE `added_by`='$id' AND `isActive`=1" ;

$query = $this->db->query($sql);
if($query)
{
	
	while($result=mysql_fetch_array($query->result_id)){
		
		?>
		<option value=<?php echo $result['id']?>><?php echo $result['year']?></option>
		<?php 
	}
	
}

?>
 </select>