<?php
 include_once("header.php");
?>		
	<script src="<?php echo base_url().'js/jquery-1.11.1.js';?>"></script>
    <script src="<?php echo base_url().'js/highcharts/highcharts.js';?>"></script>
    <script src="<?php echo base_url().'js/highcharts/exporting.js';?>"></script>
    <script src="<?php echo base_url().'js/jquery.dataTables.min.js';?>"></script>
    <script src="<?php echo base_url().'js/dataTables.bootstrap.min.js';?>"></script>
    <style>
	.table {
	table-layout:fixed;
}

.table td {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;

}
	</style>
<script>

$(function () { 
$("#blockDrp").prepend("<option value='all' >All</option>");
$('#tab').hide();
$('#fav').hide(); 
$('#day_variable_div').hide();

dayvariable = function() {
	 $('#det_content').hide();
	 $('#det_form').hide();
	 $('#day_variable_div').show();
	 $('#graph_filter').hide();
	 $('#table_data').hide();
	 $('#fav_content').hide();
     return false;
}

det = function() {
	$('#det_form').show();
	if ($('#tab').is(':visible')) {
	$('#det_content').show(); 
	}else{$('#det_content').hide();}
	$('#day_variable_div').hide();
	$('#graph_filter').show();
	$('#table_data').hide();
	$('#fav_content').show();
	return false;
}

$('#graph_filter').css('width', '100%');
	$('#datetimepicker').datetimepicker({
			 dateFormat: 'yy-mm-dd',
			 //minDate:'-1971/01/01',
			 maxDate:'0',
			 defaultTime: '00:00'
});

	$('#datetimepicker1').datetimepicker({
			 dateFormat: 'yy-mm-dd',
			 //minDate:'-1971/01/01',
			 maxDate:'0',
			 defaultTime: '23:00'
});

	$('#datetimepicker2').datetimepicker({
			 dateFormat: 'yy-mm-dd',
			 //minDate:'-1971/01/01',
			 maxDate:'0',
			 defaultTime: '00:00'
});

	$('#datetimepicker3').datetimepicker({
			 dateFormat: 'yy-mm-dd',
			 //minDate:'-1971/01/01',
			 maxDate:'0',
			 defaultTime: '23:00'
});
			$('#datetimepickerv1').datetimepicker({
				timepicker:false,
				dateFormat:'yy-mm-dd',
				defaultTime: '00:00'
			});
			$('#datetimepickerv2').datetimepicker({
				timepicker:false,
				dateFormat:'yy-mm-dd',
				defaultTime: '00:00'
			});

});

</script>


        <script type="text/javascript">

    $(document).ready(function() {  
		 
		$('.content').hide();
		$('#table_tbody_fill').hide();
		$('#deviceDrp').hide();
		$('#fieldDrp').hide();
		
		$('#graphbtn').hide();
		$('#tablebtn').hide();


	$("#blockDrp > option").attr("selected",false);
        
	$("#blockDrp").change(function () {

			$('#tab').hide();
			$('#fav').hide();
            $('#load_plot').show();
			
		var element = [];
		$('#blockDrp option').each(function(i) {
        if (this.selected == true) {
			element.push(this.value);
			}
		});

		document.getElementById('block_hid').value = element;
	    $.ajax({ 
		url:"<?php echo base_url();?>buildDropDevice",
		data: {id: element},
        type: "POST",
        success:function(data){ 					
        $('#load_plot').hide();
		$('#deviceDrp').empty().append(data);
		$('#deviceDrp').show();			                        
        }                    
        });
	});
				
			
	$("#deviceDrp").change(function () {
			$('#tab').hide();
			$('#fav').hide();
            $('#load_plot').show();
		var device = [];
        $('#deviceDrp option').each(function(i) {
                if (this.selected == true) {
                        device.push(this.value);
                }
        });
		document.getElementById('device_hid').value = device;
	    $.ajax({ 
		url:"<?php echo base_url();?>buildDropField",
		data: {device: device,block: document.getElementById('block_hid').value},
        type: "POST",
        success:function(data){ 					
        $('#load_plot').hide();
		$('#fieldDrp').empty().append(data);					
		$('#fieldDrp').show();
        }             
        });
    });	
	
	
	
	$("#fieldDrp").change(function () {
			$('#tab').show();
			$('#fav').show();           	
		var field = [];
        $('#fieldDrp option').each(function(i) {
                if (this.selected == true) {
                        field.push(this.value);
                }
        });
		document.getElementById('field_hid').value = field;
    });	
			

	$('#fav_table').DataTable();
	$('#tab').on('click', function () {
		$('#graph_filter').css('width', '100%');
		if(($("#datetimepicker").val() == "") || ($("#datetimepicker1").val() == "")) {
		alert("no date selected");
		}
		else{
			
			if($("#block_hid").val()== 'all' || $("#device_hid").val()== 'all' || $("#field_hid").val()== 'all')
			{
			var dataa = "restrict";
			$('#graph_filter').empty().hide().append("Graphical view Not applicaiple for 'All' selection");
			$('#table_data').show();
			
		}else{
			var dataa='';
			jQuery('#graph').click();
		}
			
			/*var all_block = $("#all_block_hid").val();
			var all_device = $("#all_device_hid").val();
			var all_field = $("#all_field_hid").val();
			if($("#block_hid").val()== 'all')
				$("#block_hid").val(all_block);
			if($("#device_hid").val()== 'all')
				$("#device_hid").val(all_device);
			if($("#field_hid").val()== 'all')
				$("#field_hid").val(all_field);	*/		
			
			$.ajax({ 
			url:"<?php echo base_url();?>buildTable",
			data: {block: document.getElementById('block_hid').value,device: document.getElementById('device_hid').value,field: document.getElementById('field_hid').value,date_from:document.getElementById('datetimepicker').value,date_to:document.getElementById('datetimepicker1').value},
			type: "POST",
			beforeSend: function() {
			$('#tab').hide();
            $('#load_plot').show();
			}, 
			success:function(data){ 
			
			$('#load_plot').hide();			
			$('#tab').show();
			$('.content').show();
			
			$('#graphbtn').show();
			$('#tablebtn').show();
		
			$('#exportbtn').hide();
			$('#favbtn').hide();
			$('#table_tbody_fill').show();
			
			$('#table_data').empty().append(data); 			
			var rowCount = $("#table_tbody_fill > tbody").children().length;
			if(rowCount <= 0){
			$('#table_data').empty().append('No Record Found');}				
			$('#table_tbody_fill').DataTable();
			if(dataa=='restrict'){
			$('#graph_filter').hide();
			$('#table_data').show();
			$('#exportbtn').show();
			$('#tablebtn').addClass('active');
			$('#graphbtn').removeClass('active');
			}else{
			$('#graph_filter').show();
			$('#table_data').hide();
			$('#graphbtn').addClass('active');
			$('#tablebtn').removeClass('active');	
			$('#graph_filter').css('min-width', '100%');		
			}
			}               
			});
		}	
	});	

	///***********/
	$('#fav').on('click', function () {						
			var block = document.getElementById('block_hid').value;
			var device = document.getElementById('device_hid').value;
			var field = document.getElementById('field_hid').value;
			$.ajax({ 
			url:"<?php echo base_url();?>det/storeFav",
			data: {block: block,device: device,field: field},
			type: "POST",
			beforeSend: function() {
			$('#fav').hide();
            $('#load_plot').show();
			},
			success:function(data){
				var data = data 	
				$('#load_plot').hide();
				alert(data);
			}               
			});
	});
	
	///***********/
	
	///******upload values*****/
	
  placeOption = function (block,device,field) {
	  
		var blk = block.split(",");
		$('#blockDrp').empty();
		for(i=0; i < blk.length; i++){
		var rightblk = '<option value="'+blk[i]+'" >'+blk[i]+'</option>';
		$('#blockDrp').append(rightblk);
		}
		
		var dev = device.split(",");
		$('#deviceDrp').empty();
		for(i=0; i < dev.length; i++){
		var rightdev = '<option value="'+dev[i]+'" >'+dev[i]+'</option>';
		$('#deviceDrp').append(rightdev).show();
		}
		
		var fld = field.split(",");
		$('#fieldDrp').empty();
		for(i=0; i < fld.length; i++){
		var rightfld = '<option value="'+fld[i]+'" >'+fld[i]+'</option>';
		$('#fieldDrp').append(rightfld).show();
		}
	  
	  
	 /* var rightdev = '<option value="'+device+'" >'+device+'</option>';
	  var rightfld = '<option value="'+field+'" >'+field+'</option>';*/
	 
	  
	  
	  $('#tab').show();
	  $('#fav').hide();
	  $('#reset').show();
 	  $('#block_hid').val(block);
	  $('#device_hid').val(device);
	  $('#field_hid').val(field);
	  
	  }

  delFav = function (id) {
	  $.ajax({ 
			url:"<?php echo base_url();?>det/deleteFav",
			data: {id: id},
			type: "POST",
			success:function(data){
				var data = data
				alert(data);	
			}               
			});
}
	
	
	$('#reset').on('click', function () {						
			$('#deviceDrp').hide();
	  		$('#fieldDrp').hide();
			$.ajax({ 
			url:"<?php echo base_url();?>det/getAllBlocks",
			type: "POST",
			success:function(data){
				var data = data
				$('#blockDrp').empty().append(data);	
			}               
			});
	});
	///***********/
	
	$('#exportbtn').on('click', function () {
		
			/*var all_block = $("#all_block_hid").val()
			if($("#block_hid").val()== 'all')
				$("#block_hid").val(all_block);*/		
		
		$.ajax({ 
		url:"<?php echo base_url();?>buildExcel",
		data: {block: document.getElementById('block_hid').value,device: document.getElementById('device_hid').value,field: document.getElementById('field_hid').value,date_from:document.getElementById('datetimepicker').value,date_to:document.getElementById('datetimepicker1').value},
        type: "POST",
        success:function(data){
		$('#tabledata').empty().append(data);	
		var name = "";		
		window.open('data:application/vnd.ms-excel,'  + encodeURIComponent($('#tabledata').html()));
		data.preventDefault();
		}
        });
	});

	//url:"<?php echo base_url();?>getDataDayVariable",
	$('#exportbtnDayVariable').on('click', function () {
			
	
		$.ajax({ 				
		url:"<?php echo base_url();?>buildExcelDayVariable",
		data: {date_from:document.getElementById('datetimepicker2').value},
        type: "POST",
        success:function(data){
		$('#tabledata').empty().append(data);	
		var name = "MyExcel";		
		window.open('data:application/vnd.ms-excel,' +'&name='+name + encodeURIComponent($('#tabledata').html()));
		data.preventDefault();
		}
        });
	});	

	
//-----------------------------------------------------------------------------------------------------------	
	

	$('#graph').on('click', function () {
		
			/*var all_block = $("#all_block_hid").val()
			if($("#block_hid").val()== 'all')
				$("#block_hid").val(all_block);	*/	
			
		$.ajax({ 
		url:"<?php echo base_url();?>buildGraph",
		data: {block: document.getElementById('block_hid').value,device: document.getElementById('device_hid').value,field: document.getElementById('field_hid').value,date_from:document.getElementById('datetimepicker').value,date_to:document.getElementById('datetimepicker1').value},
        type: "POST",
        success:function(data){			 
var device_data = new Array();
device_data = data.split("!#");
device_data_len = device_data.length;


var plot_data = new Array();
plot_data = data.split("!");
plot_data_len = plot_data.length;
	
	
var start_date = $('#datetimepicker').val();	
var end_date = $('#datetimepicker1').val();	
var startDate = Math.round(new Date(start_date).getTime()/1000);	
var endDate = Math.round(new Date(end_date).getTime()/1000);	

    var chart;
    chart = new Highcharts.Chart({
        chart: {
            renderTo: "graph_filter",
			animation: Highcharts.svg,
            type: "line",
			zoomType: 'xy',
            events: {
                //load: requestData
            }
        },
	    plotOptions: {
        series: { 
            marker: {
                enabled: false
            },
        }
		},
        credits: {
            enabled: false
        },
        title: {
            text: false
        },
        xAxis: {
        type:'datetime'
	    },
        yAxis: {
        },
        series: [{ 

		}],
        exporting: {
            enabled: true
        }
    });

 
var sel_field = document.getElementById('field_hid').value;
var x_field = new Array();
x_field = sel_field.split(",");
var x_field_len = x_field.length;


var sel_device = document.getElementById('device_hid').value; 
var x_device = new Array();
x_device = sel_device.split(",");
var x_device_len = x_device.length;

var sel_block = document.getElementById('block_hid').value;
var x_block = new Array();
x_block = sel_block.split(",");
var x_block_len = x_block.length;


		
 var m=0;	var l = 0;
$.each( x_block, function( i, value0 ){
	$.each( x_device, function( j, value1 ){
	chart.addSeries(j);
		$.each( x_field, function( k, value2 ){
		chart.addSeries(k);
		
		if(x_device_len <= x_field_len)
		{	
			chart.legend.allItems[l].update({name: x_device[j]+' : '+x_field[k]});	
			chart.series[l].setData(eval('['+plot_data[l]+']'), true, true);						
		}
		else if(x_device_len > x_field_len)
		{	
			chart.legend.allItems[l].update({name: x_device[j]+' : '+x_field[k]});	
			chart.series[l].setData(eval('['+plot_data[l]+']'), true, true);
		}
		else{	
			chart.legend.allItems[l].update({name: x_device[m]+' : '+value2});	
			chart.series[l].setData(eval('['+plot_data[k]+']'), true, true);
			}
	
	
		l++;
		}); 
		
	});	

});		



		}                    
        });
	});		

	$('#graphbtn').on('click', function () {
	$('#table_data').hide();		
	$('#exportbtn').hide();
	$('#favbtn').hide();
	$('#graph_filter').show();
	$('#graphbtn').addClass('active');
	$('#tablebtn').removeClass('active');
	
	});

	$('#tablebtn').on('click', function () {
	$('#table_data').show();				
	$('#exportbtn').show();
	$('#favbtn').show()
	$('#graph_filter').hide();
	$('#tablebtn').addClass('active');
	$('#graphbtn').removeClass('active');
	});

});	
			            
        </script>
<script type="application/javascript">
function getDataTs() {
var dateString1 = document.getElementById( 'datetimepickerv1' ).value;
var dateString2 = document.getElementById( 'datetimepickerv2' ).value;
//var select = document.getElementById( 'fieldslist' )[0];
var select= document.getElementsByTagName('select')[0];
  var result = [];
  var options = select && select.options;
  var opt;

  for (var i=0, iLen=options.length; i<iLen; i++) {
    opt = options[i];

    if (opt.selected) {
      result.push(opt.value || opt.text);
    }
  }
  var str = result;	 
dateParts1 = dateString1.split(' ');
var dateParts1 = dateParts1[0];
dateParts1 = dateParts1.replace('/','');
dateParts1 = dateParts1.replace('/','');
dateParts2 = dateString2.split(' ');
var dateParts2 = dateParts2[0];
dateParts2 = dateParts2.replace('/','');
dateParts2 = dateParts2.replace('/','');
 
var url = 'day_var_exp/index/'+dateParts1+'/'+dateParts2+'/'+str;
//url = url.replace(",","-");
document.location.href= url;
}
</script>
		<?php  		
		/*$allBlockDropValue = '';
		$allBlockDropValue = implode(",", $allBlockDrop);
		$allDeviceDropValue = '';
		$allDeviceDropValue = implode(",", $allDeviceDrop);
		$allFieldDropValue = '';
		$allFieldDropValue = implode(",", $allFieldDrop);*/
		 ?>
<div id="tabledata" style="display:none"></div>		
<aside class="right-side">     
<section class="content-header">Data Extraction Tool</section>
<section class="searchFilter"> 
<div id="day_variable_div" style="display:hidden;">
<div class="col-lg-2 col-sm-1">	
<div class="form-group">
<input class="form-control" id="datetimepickerv1" type="text" value = "<?php echo date('Y/m/d 00:00');  ?>"  title="Select From Date" readonly="readonly"/>
</div></div>
<div class="col-lg-2 col-sm-1">	
<div class="form-group">
<input class="form-control" id="datetimepickerv2" type="text" value = "<?php echo date('Y/m/d 00:00');  ?>"  title="Select To Date" readonly="readonly"/>
</div></div>
<div class="col-lg-3 col-sm-1" title="Select Field">	
<div class="form-group">  
   
<select name="fieldslist" id="fieldslist" title= "Select Field" class="form-control single-col" multiple>
 <?php  foreach($getAllDayField as $field){ ?> 
 <option value="<?php echo $field;  ?>"><?php  echo $field;  ?></option> 
 <?php  } ?>		
</select>
</div>  </div>
<input type="button" id="export_day_variable" class="btn btn-primary" value="Export Data" title="click to export" onClick="getDataTs()">		
</div>
		


<?php if(isset($_GET['getData'])) print_r('getData'); ?>
<form name="testing" id="det_form" name="posting" method="POST" action="postData">
<div class="row top-form ">
<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
<div class="col-lg-2 col-sm-1">	
<div class="form-group">
<input class="form-control" id="datetimepicker" name="ts" type="text" placeholder="Select From Date" value="" required/>
</div>
</div>
<div class="col-lg-2 col-sm-1">	
<div class="form-group">
<input class="form-control" id="datetimepicker1" name="ts2" type="text" value="" placeholder="Select To Date" required/>
</div>
</div>
<br>
<input type="hidden" name="interval" id="interval" value="5">
<div class="col-lg-2 col-sm-1" title="Select Block">	
<div class="form-group">
<?php echo form_dropdown('blockDrp', $blockDrop,'','class="form-control single-col required" id="blockDrp" multiple');  ?>
</div></div>
<div class="col-lg-2 col-sm-1" title="Select Device">	
<div class="form-group">        
<select name="deviceDrp" id="deviceDrp" class="form-control single-col" required multiple>
<option value="" style="display:none">Select Device</option>        		
</select>
</div>  </div>
<div class="col-lg-3 col-sm-1" title="Select Fields">
<div class="form-group">		
<select name="fieldDrp" id="fieldDrp" class="form-control single-col" required multiple>
<option value="" >Select Field</option>
</select>
<input type="hidden" id="block_hid" >
<input type="hidden" id="device_hid" >
<input type="hidden" id="field_hid" >
<!--<input type="hidden" id="all_block_hid" value="<?php //echo $allBlockDropValue;?>">
<input type="hidden" id="all_device_hid" value="<?php //echo $allDeviceDropValue;?>">
<input type="hidden" id="all_field_hid" value="<?php //echo $allFieldDropValue;?>">	-->
	
</div>
</div>
<div class="col-lg-1 col-sm-1">	
<div class="form-group">	

<input type="button" id="tab" class="btn btn-primary" value="Show Data">
<input type="button" id="fav" class="btn btn-primary" value="Save As Favourite">
<input type="button" id="reset" class="btn btn-primary" value="Reset" style="display:none" onclick="resetFav();">
<img style="display:none; overflow: hidden;" id="load_plot" src='<?php echo base_url()."image/plot.gif"; ?>'>
<input type="hidden" id="graph" class="btn btn-primary" value="Graph">
</div>
 </div>
</div></div>
</form>
</section>		
			  
           
                 <section class="content" id="det_content">
        <div class="row">		
        <div class="col-md-12 lg-12">
        <div class="box">
        <div class="box-body">
        <div class="row section-option m0">
        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
        <button type="button" id="exportbtn" class="pull-right btn btn-default" style="display:none;">Export</button>                				
        <button type="button" id="graphbtn" class="btn btn-default">Graphical</button>
        <button type="button" id="tablebtn" class="btn btn-default">Table</button>	
        <br><br>
        <div id="table_data" >
        <table id="table_tbody_fill" class="table table-striped table-bordered" cellspacing="0" width="100%" >
        <thead>
        <tr>
        <th>Date Time</th>
        <th>Block</th>
        <th>Device</th>
        <th>Field</th>
        <th>Value</th>                
        </tr>
        </thead>
        <tbody id="table_tbody">
        </tbody>
        </table></div>
        <br>
        
        <div id="graph_filter" style="max-width:80%;"></div> 
        </div></div>
        </div></div> </div></div>
        </section>     
       <!--FAV TABLE-->
                <section class="contents" id="fav_content">
                <div class="row">		
                <div class="col-md-12 lg-12">
                <div class="box">
                <h4 class="box-title">My Favourite Selections</h4>
                <div class="box-body">
                <div class="row section-option m0">
                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                
                <table id="fav_table" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                    <thead>
                        <tr>
                        <th>Block</th>
                        <th>Device</th>
                        <th>Field</th>
                        <th width="5%">Select</th> 
                        <th width="5%">Delete</th>          
                        </tr>
                    </thead>
                  <?php  if($getAllFav) { foreach( $getAllFav as $row){ 	?>
                   <tr>
                   <td><?php echo $row['block'];  ?></td>
                   <td><?php echo $row['device'];  ?></td>
                   <td><?php echo $row['field'];  ?></td>
                   <td><button value="<?php echo $row['id'];  ?>" onclick="placeOption('<?php echo $row['block'];  ?>','<?php echo $row['device'];  ?>','<?php echo $row['field'];  ?>');">Select</button></td>
                   <td><button value="<?php echo $row['id'];  ?>" onclick="delFav(this.value);">Delete</button></td>
                   </tr> 
                   <?php } }?>  
                </table>
                </div></div></div></div></div></div>
                </section>
                <!--FAV TABLE END-->
</aside>

<?php 
 include_once("footer.php");
?>