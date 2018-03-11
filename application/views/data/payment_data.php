<table id="table" class="table">
<thead>
<tr>
<th>Fee ID</th>
<th>Session Id</th>
<th>student Id</th>
<th>School Id</th>
<th>January</th>
<th>Febuary</th>
<th>March</th>
<th>April</th>
<th>May</th>
<th>June</th>
<th>July</th>
<th>August</th>
<th>September</th>
<th>October</th>
<th>November</th>
<th>December</th>
</tr>
</thead>
<tbody>
<?php
$session=trim($_GET['k']);
$school=trim($_GET['l']);
$usid=$this->session->userdata('login');
$sql="SELECT `fee_id`, `session_id`, `student_id`, `school_id`, `jan`, `feb`, `mar`, `april`, `may`, `june`, `july`, `aug`, `sept`, `oct`, `nov`, `decem`, `added_by` FROM `vk_student_fee_relation`
 WHERE `session_id` like '%$session%' AND `school_id` like '%$school%' AND `added_by`='$usid'";
if($query=$this->db->query($sql))
{
    while($result=mysql_fetch_array($query->result_id)){      

        ?>
	  <tr>
                <td><?php echo $result['fee_id']; ?></td>
                <td><?php echo $result['session_id']; ?></td>           
                <td><?php echo $result['student_id']; ?></td>
                <td><?php echo $result['school_id']; ?></td>
                <td><?php echo $result['jan']; ?></td>   
                <td><?php echo $result['feb']; ?></td>
                <td><?php echo $result['mar']; ?></td>
                <td><?php echo $result['april']; ?></td>           
                <td><?php echo $result['may']; ?></td>
                <td><?php echo $result['june']; ?></td>
                <td><?php echo $result['july']; ?></td>   
                <td><?php echo $result['aug']; ?></td> 
                <td><?php echo $result['sept']; ?></td>
                <td><?php echo $result['oct']; ?></td>           
                <td><?php echo $result['nov']; ?></td>
                <td><?php echo $result['decem']; ?></td> 
                
                 
 <?php 
    }
}?>
</tr>
 </tbody>
 </table>

