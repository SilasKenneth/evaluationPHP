<?php
?>
<?php
include_once "nav.php";
?>
<title>Lecturer- Evaluations</title>
<?php 
include_once "sidenav.php";

?>
<style type="text/css">

</style>
<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-2 col-lg-6 col-lg-offset-3 form">
    <div class="clearfix"></div>
    <hr>
	<table class="table table-responsive table-striped table-bordered">
		<thead>
			<th>
			 #	
			</th>
			<th>Date started</th>
			<th>Close date</th>
			<th>Status</th>
			<th>Actions</th>
		</thead>
		<tbody>
                    <?php 
                       $records=  Evaluation::getEvaluations();
                       //print_r($records);
                       if(!$records){
                           //print_r($records);
                       }
                       else{
    //print_r($records);
                         foreach ($records as $record){
                    ?>
			<tr>
                            <td>
                                <?php 
                                      echo $record['id'];
                                    ?>
                            </td>
                                <td>
                                    <?php 
                                      echo Settings::formatdate($record['startdate']);
                                    
                                    ?>
                                </td>
				<td><?php 
                                      echo Settings::formatdate($record['enddate']);
                                    ?></td>
				<td>
                                    <?php if($record['status']==1){ ?>
					<label class="btn btn-success" disabled></label>        
                                    <?php }else{ ?>
                                    <label class="btn btn-danger" disabled></label> 
                                    <?php } ?>
				</td>
				<td>
                                    <a class="btn btn-xs btn-info" href="/Project/super/index.php?page=viewres&mod=Lecturer&evaluation=<?= htmlspecialchars($record['id']) ?>">
						View result
					</a>
				</td>
			</tr>
                           <?php } 
                       }
                           ?>
		</tbody>
	</table>
</div>