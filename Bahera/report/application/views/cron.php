	<?php
	 include_once("header.php");		 
	?>
    <input type="hidden" value="" id="report_name" >
    <aside class="right-side">   
<script>
$(document).ready(function() {
var input = $('#input-a');
input.clockpicker({
    autoclose: true
});

intchange = function(val){
	if(val=='day_variable'){
		var data = "<option value='day' style='size:25%'>Day</option><option value='month'>Month</option><option value='year'>Year</option>";	
	}else{
		var data = "<option value='01' style='size:25%'>1 Minute</option><option value='05'>5 Minute</option><option value='15'>15 Minute</option><option value='30'>30 Minute</option><option value='60'>60 Minute</option>";
	}
	$('#rinterval').empty().append(data);	
}
});
</script>

<section class="content" style="min-height: 900px;">
<div class="row">
<div class="col-md-12 lg-12">
<table border="0" style="vertical-align: middle;" width="100%" style="background-color:#D3D3D3; display:none;" id="dmy_mtt"> <tr>
<td style="vertical-align: middle;" align="left" width="50%" >
</td>
<td style="vertical-align: middle;" align="right" width="50%" id="plant_only">
<img  src="<?php echo base_url().'image/welspun.jpg';?>">
</td>
</tr>
</table>
<div class="box">
<div class="box-body">							
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">						
<div id="abt" >
<div>
<div class="wide" style="background:#3C8DBC; text-align: left; vertical-align: middle; line-height: 30px; color:#FFF; " width="100%" >
  ABT Revenue Calculation
</div>			
<form action="<?php echo base_url()."cron/calc_revenue"; ?>" id="add_new" method="POST" enctype="multipart/form-data" >
<table  width="70%" class="table table-striped table-bordered">
<tr><td style="vertical-align: middle;">Date</td><td><input type="text" name="date" id="abt_datepicker" value="<?php echo date('d-m-Y'); ?>" readonly required="required" style="vertical-align: middle;"></td></tr>
<!--<tr><td style="vertical-align: middle;">Plant</td>
<td><select name="plant" style="vertical-align: middle; width:160px;">
<option value="bahera">Bahera</option>
</select></td></tr>-->
<input type="hidden" name="plant" value="Bahera">
<tr><td style="vertical-align: middle;">Gross Export</td><td><input type="text" name="cexport" required style="vertical-align: middle;"> MWh</td></tr>
<tr><td style="vertical-align: middle;">Import</td><td><input type="text" name="import" required style="vertical-align: middle;"> MWh</td></tr>
<!--<tr><td style="vertical-align: middle;">Net Export</td><td><input type="text" name="nexport" required style="vertical-align: middle;"> MWh</td></tr>-->
<tr><td><input type="submit" name="insert" id="addnewrev" value="Insert" class="btn btn-primary" /></td><td></td></tr>

 </table>
</form>
</div><hr>

<div id="scada_template_view" style="display:none;">
<div>
<div class="wide" style="background:#3C8DBC; text-align: left;
vertical-align: middle;
line-height: 30px; color:#FFF; " width="100%" >
    Create New Reports
</div>			
<form action="<?php echo base_url()."cron/add_new"; ?>" id="add_new" method="POST" enctype="multipart/form-data" >
<table  width="70%" class="table table-striped table-bordered">
<!--<tr><td style="vertical-align: middle;">Plant</td><td>
<select name="plant" style="vertical-align: middle;  width:160px;">
<option value="bahera">Bahera</option>
</select>
</td></tr>-->
<input type="hidden" name="plant" value="Bahera">
<tr><td style="vertical-align: middle;">Report Tilte</td><td><input type="text" name="title" required style="vertical-align: middle;"></td></tr>
<tr><td style="vertical-align: middle;">Report Name</td><td><input type="text" name="name" required style="vertical-align: middle;">.ods</td></tr>

<tr><td style="vertical-align: middle;">Type</td><td>
<select name="type" style="vertical-align: middle; width:160px;" onChange="intchange(this.value);">
<option value="historical">Historical</option><option value="day_variable">Day Variable</option>
</select></td></tr>

<tr><td style="vertical-align: middle;">Interval</td><td><select name="interval" id="rinterval" style="vertical-align: middle;  width:160px;">
<option value="01" style="size:25%">01 Minute</option><option value="05">05 Minute</option><option value="15">15 Minute</option><option value="30">30 Minute</option><option value="60">60 Minute</option>
</select></td></tr>
<tr><td><input type="submit" name="submit" id="addnewButton" value="Add" class="btn btn-primary" /></td><td></td>
</tr> </table>
</form>
</div><hr>



<div>
<div class="wide" style="background:#3C8DBC; text-align: left;
vertical-align: middle;
line-height: 30px; color:#FFF; " width="100%" >
    Reports Template Upload
</div>			
<form action="upload" id="ods_upload" method="POST" enctype="multipart/form-data" >
<table  width="70%" class="table table-striped table-bordered"><tr><td width="25%" style="vertical-align: middle;">Select Template (*.ods)</td>   <td width="25%"><input type="file" name="userfile" required style="vertical-align: middle;"></td>   <td><input type="submit" name="submit" id="uploadButton" value="Upload" class="btn btn-primary" /></td></tr> </table>
</form>
</div><hr>

        <script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
		
        <script type="text/javascript">
            $(document).ready( function() {
                $('form').submit( function() {
                    var bar = $('.bar');
                    var percent = $('.percent');
                    var status = $('#status');
                    $(this).ajaxForm({
                        beforeSend: function() {
                            status.html();
                            var percentVal = '0%';
                            bar.width(percentVal)
                            percent.html(percentVal);
                        },
                        uploadProgress: function(event, position, total, percentComplete) {
                            var percentVal = percentComplete + '%';
                            bar.width(percentVal)
                            percent.html(percentVal);
                        },
                        complete: function(xhr) {
                            status.html(xhr.responseText);
                        }
                    });
                });
            });
        </script>
<style>


    .progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
    .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
    .percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>



<div class="wide" style="background:#3C8DBC; text-align: left;
vertical-align: middle;
line-height: 30px; color:#FFF; " width="100%" >
    Scheduling Report Template List
</div>
	
<table width="70%" border="0" id="example" class="table table-striped table-bordered table-hover"> 
<tr style="vertical-align: middle;"> <th style="vertical-align: middle;">S.No.</th> <th style="vertical-align: middle;">Reports</th>  <th style="vertical-align: middle;" colspan='2'>Download</th></tr>
<tr >
<td style="vertical-align: middle;" width="5%">1</td> 
<td style="vertical-align: middle;" width="30%">Inverter Generation Report</td>
<td width="20%" style="text-align:center;"  colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Inverter_Generation_Report-Bahera.ods';"></span>

</td>
</tr>

<tr> 
<td style="vertical-align: middle;">2</td> 
<td style="vertical-align: middle;">SMU Genertation Report</td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/SMU_Generation_Report-Bahera.ods';"></span>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">3</td> 
<td style="vertical-align: middle;">SMU Daily Communication Report</td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/SMU_Daily_Communication_Report-Bahera.ods';"></span>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">4</td>
<td style="vertical-align: middle;">WMS Minutes Report</td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/WMS_OneMinutes_Report-Bahera.ods';"></span>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">5</td>
<td style="vertical-align: middle;">WMS Monthly Report</td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/WMS_Monthly_Report-Bahera.ods';"></span>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">6</td>
<td style="vertical-align: middle;">Inverter Monthly Generation Report</td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Inverter_Monthly_Generation_Report-Bahera.ods';"></span>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">7</td>
<td style="vertical-align: middle;">Block Wise SMU Communication Report</td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/SMU_Hourly_Communication_Report-Bahera.ods';"></span>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">8</td>
<td style="vertical-align: middle;">Plant Generation Report</td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Plant_Generation_Report-Bahera.ods';"></span>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">9</td>
<td style="vertical-align: middle;">Main Page Daily Report</td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Main_Page_Daily-Bahera.ods';"></span>
</td>
</tr>

<tr>
<td style="vertical-align: middle;">10</td> 
<td style="vertical-align: middle;">Parameter Daily Report</td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Parameter_Daily_Report-Bahera.ods';"></span>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">11</td>
<td style="vertical-align: middle;">Plant Daily Generation Report</td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Plant_Daily_Generation_Report-Bahera.ods';"></span></td>
</tr>

<tr> 
<td style="vertical-align: middle;">12</td>
<td style="vertical-align: middle;">Monthly Report </td>
<td width="10%" style="text-align:center;"  colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Monthly_Report-Bahera.ods';"></span></td>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">13</td>
<td style="vertical-align: middle;">Block Report </td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Block_Report-Bahera.ods';"></span></td>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">14</td>
<td style="vertical-align: middle;">Inverter CUF Report </td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Inverter_CUF_Report-Bahera.ods';"></span></td>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">15</td>
<td style="vertical-align: middle;">Inverter Comparison Report</td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Inverter_Comparison_Report-Bahera.ods';"></span></td>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">16</td>
<td style="vertical-align: middle;">ABT Revenue Report </td>
<td width="10%" style="text-align:center;" colspan='2'>
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/ABT_Revenue_Report-Bahera.ods';"></span></td>
</td>
</tr>
<?php
  if(isset($newReport) && (count($newReport)>0)){
	  echo "<tr><th colspan='4'>Dynamic Reports</th></tr>";
	  $si=16;
      foreach ($newReport as $info){
		  $si++;
		  ?>
          <tr> 
<td style="vertical-align: middle;"><?php echo $si; ?></td>
<td style="vertical-align: middle;"><?php echo $info->report_title; ?> </td>
<td width="10%" style="text-align:center;">
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/<?php echo $info->report_name; ?>.ods';"></span></td>
</td>
<td width="10%" style="text-align:center;">
<a href="<?php echo base_url()."cron/del_report/$info->id"; ?>"><span title="Delete the report" onmouseover="this.style.cursor='pointer';" style="color:red;" class="glyphicon glyphicon-remove"></span></a></td>
</tr>
<?php }} ?>
</table>
<hr>


<div class="wide" style="background:#3C8DBC; text-align: left;
vertical-align: middle;
line-height: 30px; color:#FFF; " width="100%" >
    Scada Report Template
</div>
<table width="70%" id="example" class="table table-striped table-bordered table-hover"> 
<tr style="vertical-align: middle;"> <th style="vertical-align: middle;">S.No.</th> <th style="vertical-align: middle;">Reports</th>  <th style="vertical-align: middle;">Type</th> <th style="vertical-align: middle;">Download</th></tr>

<tr > 
<td style="vertical-align: middle;" >1</td> 
<td style="vertical-align: middle;" >Station Report</td>
<td  align="center"><select id="Station_Report_type_drop" title="Select Type"> <option value="Day">Day</option> <option value="Month">Month</option> <option value="Year">Year</option></select></td>
<td style="text-align:center;">
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Station_Report-Bahera-'+$('#Station_Report_type_drop').val()+'.ods';"></span>
</td>

</tr>

<tr> 
<td style="vertical-align: middle;">2</td> 
<td style="vertical-align: middle;">Import Export Report</td>
<td align="center">---</td>
<td style="text-align:center;">
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Import_Export-Bahera.ods';"></span>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">3</td> 
<td style="vertical-align: middle;">132kV_Feeder Report</td>
<td align="center">---</td>
<td style="text-align:center;">
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/132kV_Feeder_Report-Bahera.ods';"></span>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">4</td> 
<td style="vertical-align: middle;">33kV_Block Report</td>
<td align="center">---</td>
<td style="text-align:center;">
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/33kV_Block_Report-Bahera.ods';"></span>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">5</td> 
<td style="vertical-align: middle;">Inverter Report</td>
<td align="center"><select id="Inverter_Report_drop" title="Select Type"> <option value="Hourly-All">Hour All Block</option> <option value="Hourly">Hour single Block</option> <option value="Day">Day</option> <option value="Month">Month</option> <option value="Year">Year</option> <option value="TillDate">Till Date</option></select></td>
<td style="text-align:center;">
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Inverter_Report-Bahera-'+$('#Inverter_Report_drop').val()+'.ods';"></span>
</td>
</tr>

<tr> 
<td style="vertical-align: middle;">6</td> 
<td style="vertical-align: middle;">Inverter Daily Generation Report</td>
<td align="center">---</td>
<td style="text-align:center;">
<span title="Download Template" onmouseover="this.style.cursor='pointer';" style="color:blue;" class="glyphicon glyphicon-cloud-download" onclick="location.href='/report/ctest3/Inverter_Daily_Generation_Report-Bahera.ods';"></span>
</td>
</tr>
</table>
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
