<table id="table" class="table">
<thead>
<tr>
<th>Student ID</th>
<th>Name</th>
<th>Address</th>
<th>Father's Name</th>
<th>Mother's Name</th>
<th>Mobile</th>
<th>Active</th>
<th>Edit</th>
<th>Remove</th>
</tr>
</thead>
<tbody>
<?php
$student=trim($_GET['q']);
$active=trim($_GET['k']);
$usid=$this->session->userdata('login');
$sql="SELECT `id`, `name`, `address`, `f_name`, `m_name`, `mobile`, `isActive` FROM `vk_student` WHERE 
`name` like '%$student%' AND `isActive`='$active' AND `added_by`='$usid'";
if($query=$this->db->query($sql))
{
    while($result=mysql_fetch_array($query->result_id)){      

        ?>
	  <tr>
                <td><?php echo $result['id']; ?></td>
                <td><?php echo $result['name']; ?></td>           
                <td><?php echo $result['address']; ?></td>
                <td><?php echo $result['f_name']; ?></td>
                <td><?php echo $result['m_name']; ?></td>   
                <td><?php echo $result['mobile']; ?></td> 
                <td><?php if($result['isActive']==1)
                    echo "yes";
                else 
                    echo "no";?></td> 
                 <td><i style="cursor: pointer" onclick="edit('<?php echo $result['id']; ?>','<?php echo $result['name']; ?>','<?php echo $result['address']; ?>','<?php echo $result['f_name'];?>','<?php echo $result['m_name']; ?>','<?php echo $result['mobile']; ?>')" class="fa fa-edit"></i></td>
                <td><i style="cursor: pointer" onclick="remove('<?php echo $result['id']; ?>')" class="fa fa-remove"></i></td>

 <?php 
    }
}?>
</tr>
 </tbody>
 </table>
