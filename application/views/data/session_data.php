<table id="table" class="table">
<thead>
<tr>
<th>Session ID</th>
<th>Year</th>
<th>Active</th>
<th>Edit</th>
<th>Remove</th>
</tr>
</thead>
<tbody>
<?php
$session=trim($_GET['q']);
$active=trim($_GET['k']);
$usid=$this->session->userdata('login');
$sql="SELECT `id`, `year`, `isActive` FROM `vk_sessions` WHERE `year` like '%$session%' AND  `added_by`='$usid' AND `isActive`='$active'";
$query=$this->db->query($sql);
if($query)
{
    while($result=mysql_fetch_array($query->result_id)){      

        ?>
	  <tr>
                <td><?php echo $result['id']; ?></td>
                <td><?php echo $result['year']; ?></td>           
                <td><?php if($result['isActive']==1)
                    echo "yes";
                else 
                    echo "no";?></td> 
                 <td><i style="cursor: pointer" onclick="edit('<?php echo $result['id']; ?>','<?php echo $result['year']; ?>')" class="fa fa-edit"></i></td>
                <td><i style="cursor: pointer" onclick="remove('<?php echo $result['id']; ?>')" class="fa fa-remove"></i></td>

 <?php 
    }
}?>
</tr>
 </tbody>
 </table>