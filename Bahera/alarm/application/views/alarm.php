	<?php
	 include_once("header.php");
	?>

			<aside class="right-side">   
				<section class="content-header">
					<h1>Alarm Configuration</h1>
				</section>
				

				<section class="content">
				<div class="box">
				<div class="box-body">
				<div class="row">
				<div class="col-md-12 lg-12">		



				<div class="modal fade" id="alarmAdd" role="dialog" >
				<div class="modal-dialog modal-sm">
				<div class="modal-content">
				<div class="modal-header" style="background-color:#3C8DBC;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Alarm Add</h4>
				</div>
				<div class="modal-body">
				<form method="POST" action="<?php echo base_url().'alarm/alarm_add_new'; ?>">
				<table class="table" >
				<tr><td style="vertical-align: middle;" width="30%;"> Alarm Text </td> <td style="vertical-align: middle;"> 
				<select name="field">
				<?php  						 
				foreach($alarmInfo as $key=>$value) {	

				if(!empty($value['add_alarm_type'])){																	
				foreach($value['add_alarm_type'] as $key=>$list) {  ?>
				<option value="<?php echo $list->field; ?>"> <?php echo $list->field; ?></option>
				<?php
				} } }
				?>
				</select>

				
				</td> </tr>	

<tr><td style="vertical-align: middle;">Alarm Device</td>   <td style="vertical-align: middle;">

				<select name="alarm_type">
				<option value="CR_IO">CR_IO</option>
				<option value="EM">EM</option>				
				<option value="inverter">Inverter</option>
				<option value="IO">IO</option>
				<option value="SMU">SMU</option>

				</select>
</td></tr>				
				
				
				<tr><td> Alarm Type </td>  <td>
				<select name="type" onclick="handleClick(this);">
				<option value='process'>process</option>
				<option value='event'>Event</option>
				<option value='fire'>Fire</option>
				</select> </td></tr>				
				
				<!--<tr><td style="vertical-align: middle;">Alarm Type </td>  <td style="vertical-align: middle;"><input type="radio" name="type" value="process" checked="checked" onclick="handleClick(this);">Process <input type="radio" name="type" value="event" onclick="handleClick(this);">Event <input type="radio" name="type" value="fire" onclick="handleClick(this);">Fire</td> </tr>-->
				
				<tr><td style="vertical-align: middle;">Priority </td>  <td style="vertical-align: middle;"><select name="priority" id="priority">
				<option value='N'>Null</option>
				<option value='4'>4</option>
				<option value='3'>3</option>
				<option value='2'>2</option>
				<option value='1'>1</option>
                <option value='0'>0</option>
				</select></td> </tr>
				<tr><td style="vertical-align: middle;">Audio Status </td>  <td style="vertical-align: middle;">
				
				<select name="audio_status" id="audio_status">
				<option value='1'>Active</option>
				<option value='0'>Deactive</option>
				</select></td></tr>
				
				<tr><td> History Status </td>  <td>
				<select name="history_status" id="history_status">
				<option value='1'>Active</option>
				<option value='0'>Deactive</option>
				</select>
				</td></tr>

				<tr><td> Status </td>  <td>
				<select name="status" id="status">
				<option value='1'>Active</option>
				<option value='0'>Deactive</option>
				</select> </td></tr>
				
				
		
				<!--
				<input type="radio" name="audio_status" value="1" checked="checked">Active <input type="radio" name="audio_status" value="0" >Deactive</td> </tr>
				<tr><td style="vertical-align: middle;">History Enable </td>  <td style="vertical-align: middle;"><input type="radio" name="history_status" value="1" checked="checked">Active <input type="radio" name="history_status" value="0" >Deactive</td> </tr>
				<tr><td style="vertical-align: middle;">Status </td>  <td style="vertical-align: middle;"><input type="radio" name="status" value="1" checked="checked">Active <input type="radio" name="status" value="0" >Deactive</td> </tr>
				-->	
				
				</table><br>
				<div width="100%" align="right"><input type="submit" value="Save" class="btn btn-primary" >   <input type="button" value="Cancel" class="btn btn-default" data-dismiss="modal"> </div>
				</form>
				</div>

				</div>
				</div>
				</div>

	

			
			
	<div class="container" style="max-width: 100%">	
	<input type="button"  id="add_alarm" value="Add Alarm" data-toggle="modal" class="pull-right btn btn-info btn-lg" data-target="#alarmAdd"><br><br><br>
	<div class="row">
      <div class="table-responsive">
	  
	

						
				<table id="example" class="table table-striped table-bordered dt-responsive nowrap pull-right" cellspacing="0">
				<thead>
				<tr >

				<th>Alarm Type</th>
				<th>Alarm Field</th>
				<th>Type</th>				
				<th>Audio</th>
				<th>History</th>
				<th>Log</th>
				<th>Priority</th>
				<th align="center">Delete</th>
			



				</tr>
				</thead>
				<tbody >
				<?php  						 
				foreach($alarmInfo as $key=>$value) {	

				if(!empty($value['list'])){																	
				foreach($value['list'] as $key=>$list) {  ?>	

				<tr style="height: 35px;">


				<td style="vertical-align: middle;" align="left"><?php $id=$list->id; echo $list->alarm_type; ?></td>
				<td style="vertical-align: middle;" align="left"><?php echo $list->alarm_field; ?></td>
				<td style="vertical-align: middle;" align="left"><?php echo $list->type; ?></td>
				

				<!--<td align="center" data-toggle="tooltip" title="Priority"><?php //echo $list->priority; ?></td>-->
				
				
				<td align="center"  title="Audio status"><?php $st = $list->audio_status; if($st == 'Inactive'){ $st_id ='0';?> <a href=" <?php echo 'alarm/alarm_audio/'.$id.'/'.$st_id?>"  onclick="return confirm('Are you sure want to Active Audio Status ?')"><img src="<?php echo base_url().'image/audio_deactive.png'; ?>" height="28" width="28"></a> <?php }  else {  $st_id ='1';?> <a href="<?php echo 'alarm/alarm_audio/'.$id.'/'.$st_id; ?>"   onclick="return confirm('Are you sure want to Deactive Audio Status ?')"><img src="<?php echo base_url().'image/audio_active.png'; ?>" height="28" width="28"></a> <?php } ?></td>	
                							   								   
				<td align="center"  title="History Status"><?php $st = $list->history_enable; if($st == 'Inactive'){ $st_id ='0'; ?> <a href="<?php echo 'alarm/alarm_history/'.$id.'/'.$st_id; ?>"   onclick="return confirm('Are you sure want to Active History Status ?')"><img src="<?php echo base_url().'image/history_deactive.png'; ?>" height="24" width="24"></a> <?php }  else {  $st_id ='1'; ?> <a href="<?php echo 'alarm/alarm_history/'.$id.'/'.$st_id; ?>" onclick="return confirm('Are you sure want to Deactive History Status ?')"> <img src="<?php echo base_url().'image/history_active.png'; ?>" height="24" width="24"> </a><?php } ?></td>
                
				<td align="center"  title="Status log"><?php $st = $list->status; if($st == 'Active'){ $st_id ='1'; ?> <a href="<?php echo 'alarm/alarm_status'.'/'.$id.'/'.$st_id; ?>" onclick="return confirm('Are you sure want to Deactive Status ?')" > <img src="<?php echo base_url().'image/active.png'; ?>" height="24" width="24">  </a> <?php }  else {  $st_id ='0'; ?> <a href="<?php echo 'alarm/alarm_status/'.$id.'/'.$st_id; ?>" onclick="return confirm('Are you sure want to Active Status?')" > <img src="<?php echo base_url().'image/deactive.png'; ?>" height="24" width="24"> </a><?php } ?></td>															   			
				
				<!--<td align="center" data-toggle="tooltip" title="Edit"> <a href="" data-toggle="modal" data-target="<?php //echo '#editAlarm'; ?>" > <img src="<?php //echo base_url().'image/edit.png'; ?>" height="24" width="24"></a></td>-->								   
				
				
				
				<td><?php $pri = $list->priority;?>

		<select id="test_drop" <?php $type_=$list->type; if($type_!='process')echo "disabled";?> onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
   
    <option <?php echo ($pri == 'N')?"selected":"" ?> value="alarm/pup/<?php echo $list->id;?>/N">Null</option>
    <option <?php echo ($pri == '4')?"selected":"" ?> value="alarm/pup/<?php echo $list->id;?>/4">4</option>
	<option <?php echo ($pri == '3')?"selected":"" ?> value="alarm/pup/<?php echo $list->id;?>/3">3</option>
	<option <?php echo ($pri == '2')?"selected":"" ?> value="alarm/pup/<?php echo $list->id;?>/2">2</option>
	<option <?php echo ($pri == '1')?"selected":"" ?> value="alarm/pup/<?php echo $list->id;?>/1">1</option>
    <option <?php echo ($pri == '0')?"selected":"" ?> value="alarm/pup/<?php echo $list->id;?>/0">0</option>
</select>	

				
				</td>					

				<td align="center" title="Delete"> <a href=<?php echo base_url()."alarm/alarm_remove/$id"?> onclick="return confirm('Are you sure want to delete this Alarm?')" > <img src="<?php echo base_url().'image/remove.png'; ?>" height="20" width="20"> </a> </td>								   
				

				
				
				
				</tr>				
				<?php
				}																	
				}

				}

				?>
				</tbody>
				</table>
				      </div>

	  

	</div>
</div>
				
				
				
						
				
				
				
				</div>
				</div>
				</div>
				</div>
				
				</section>
			</aside>

	<?php 
	include_once("footer.php");
	?>

