<table id="table" class="table">
<thead>
<tr>
<th>School ID</th>
<th>Name</th>
<th>Address</th>
<th>Batch</th>
<th>Start time</th>
<th>End Time</th>
<th>Active</th>
<th>Edit</th>
<th>Remove</th>
</tr>
</thead>
<tbody>
<?php
$school=trim($_GET['q']);
$batch=trim($_GET['j']);
$active=trim($_GET['k']);
$usid=$this->session->userdata('login');
$sql="SELECT `id`, `name`, `address`, `batch`, `starttime`, `endtime`, `added_by`, `isActive` FROM `vk_school`
 WHERE `added_by`='$usid' AND `isActive`='$active' AND `name` LIKE '%$school%' AND 'batch' like '%$batch%'";
if($query=$this->db->query($sql))
{
    while($result=mysql_fetch_array($query->result_id)){      

        ?>
	  <tr>
                <td><?php echo $result['id']; ?></td>
                <td><?php echo $result['name']; ?></td>           
                <td><?php echo $result['address']; ?></td>
                <td><?php echo $result['batch']; ?></td>
                <td><?php echo $result['starttime']; ?></td>   
                <td><?php echo $result['endtime']; ?></td> 
                <td><?php if($result['isActive']==1)
                    echo "yes";
                else 
                    echo "no";?></td> 
                 <td><i style="cursor: pointer" onclick="edit('<?php echo $result['id']; ?>','<?php echo $result['name']; ?>','<?php echo $result['address']; ?>','<?php echo $result['batch'];?>','<?php echo $result['starttime']; ?>','<?php echo $result['endtime']; ?>')" class="fa fa-edit"></i></td>
                <td><i style="cursor: pointer" onclick="remove('<?php echo $result['id']; ?>')" class="fa fa-remove"></i></td>

 <?php 
    }
}?>
</tr>
 </tbody>
 </table>