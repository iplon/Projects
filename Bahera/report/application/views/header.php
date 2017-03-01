<?php ob_start();?>
<!DOCTYPE html>
		<head>		
		<title>iPLON | Reports</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="UTF-8">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- CSS Start -->
		<link href="<?php echo base_url().'css/bootstrap.min.css'; ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url().'css/font-awesome.min.css';?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url().'css/ionicons.min.css';?>" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="<?php //echo base_url().'css/bootstrap/bootstrapValidator.css';?>"/>
		<link href="<?php echo base_url().'css/AdminLTE.css';?>" rel="stylesheet" type="text/css">
		<link href="<?php //echo base_url().'css/colorbox.css';?>" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="<?php echo base_url().'image/favicon3.ico';?>">
		

		<!-- CSS End -->
		<!-- jQuery  start  -->
		<script src="<?php echo base_url().'js/jquery.min.js';?>"></script>		
		<script type="text/javascript" src="<?php echo base_url().'js/js_pdf.js'?>"></script>
		<script src="<?php //echo base_url().'js/jquery-ui-1.10.3.min.js';?>" type="text/javascript"></script>
		<script src="<?php //echo base_url().'js/jquery.validate.js';?>"></script>  
		<script src="<?php //echo base_url().'js/jquery.colorbox.js';?>" type="text/javascript"></script>
		<script src="<?php echo base_url().'js/bootstrap.min.js';?>" type="text/javascript"></script>
		<script src="<?php //echo base_url().'js/jquery.sparkline.min.js';?>" type="text/javascript"></script>
		<script src="<?php echo base_url().'js/AdminLTE/app.js';?>" type="text/javascript"></script>
		<script src="<?php //echo base_url().'js/plugins/sparkline/jquery.sparkline.min.js';?>" type="text/javascript"></script>
		
		<script src="<?php echo base_url().'js/highcharts/highcharts.js';?>"></script>
		<script src="<?php echo base_url().'js/exporting.js';?>"></script>
		<script src="<?php //echo base_url().'js/highcharts/highcharts-more.js';?>"></script>
		<script src="<?php //echo base_url().'js/highcharts/highchart_export.js';?>"></script>
		
		

	<?php if($this->uri->segment(1)== 'report'){?>
			
			<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/left_menu_styles.css';?>">
			<script src="<?php echo base_url().'js/left_menu_script.js';?>"></script>
			
<style>
.report-pre {
    overflow-x:scroll;
    overflow-y:hidden;
    height:450px;
    width:100%;
    padding: 0 15px;
	overflow-y: auto;
  overflow-x:auto;
  word-wrap:normal;
}
</style>

<style>
table.excel {
	class : table table-striped table-bordered;
	border-style:ridge;
	border-width:0;
	border-collapse:collapse;
	font-family:sans-serif;
	font-size:12px;
}
table.excel thead th, table.excel tbody th {	
	border-style:ridge;
	border-width:0;
	text-align: center;
	vertical-align:bottom;
	font-size:0px;
}
table.excel tbody th {
	text-align:center;
	width:22px;
}
table.excel tbody td {
	vertical-align:middle;
}
table.excel tbody td {
    padding: 0 3px;
	border: 0px solid #EEEEEE;
}
</style>	
<style>
.btn_active {
    background-color:#455486;
	color:white;
	
    <!--color: red;-->
}

</style>
<script>



function page_print() {
    window.print();
}


$(document).ready(function() {
	//$('#plant').val('Lomada');	
	//var plant = $('#plant').val();	
$('#report_name').val('Station_Report');

//--------------------------------------------------------------


$('#kill').click(function () { 

		$('#load').show();
			$.ajax({ 
		url:"<?php echo base_url();?>pkill_soffice",		
		data: 'process=kill',
        type: "POST",
        success:function(data){
$('#load').hide();			

if(data == 'fail')
{
alert('File to kill !');
		
	
}
else
{
	$('#load').hide();
	
}

		} 
		});



});

//---------------------------------------------------------------------------------------------

$('#download').click(function () { 


var date_zip = $('#datetimepicker_zip').val();
alert(date_zip);
		$('#load').show();
			$.ajax({ 
		url:"<?php echo base_url();?>download_zip",
		//data: {value: 'day'},
		data: 'date='+date_zip,
        type: "POST",
        success:function(data){
$('#load').hide();			

if(data == 'fail')
{
alert('File not found !');
//$('#myModal').modal('show');		
	
}
else
{			
	
}

		} 
		});



});

$('#block_sel2').hide();	
	
		$('#cssmenu_cron').hide();
	  var currentTime = new Date();
  var day = currentTime.getDate();
  var month = currentTime.getMonth() + 1;
  var year = currentTime.getFullYear();

  if (day < 10){
  day = "0" + day;
  }

  if (month < 10){
  month = "0" + month;
  }
  
  var today_date = year + "-" + month + "-" + day;
  
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];
 
 for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value
			
			//alert(fdate);
			
			
var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);				 
 
			$('#datetimepicker').val(tes);  
			$('#datetimepicker_zip').val(tes);  
  

$('#load').show();	

$('#report_name').val("Station_Report");
$('#d_m_y_text').val("Day");

var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			
$('#time_now').val(time);


$('#block_select').val("Nill");
var block_sel = document.getElementById('block_select').value	
block_sel = 'Nill';



$('#type_value').val("Day");

var report_name = "Station_Report";
var from_date = tes_now;
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
var to_date = $('#todate').val();


	
			$('#table_data').hide();
	

var type_value = 'Day';
$('#datetimepicker').val(from_date);


var time = document.getElementById('time_now').value									
		

$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+from_date+"_"+time);						
					
var file_name = $('#file_name').val();
 
					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",	
				//data: 'file_name='+file_name+'&block_sel='+block_sel,				
				data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+document.getElementById('plant').value+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				type: "POST",
			success:function(data){ 						
			$('#load').hide();
				
				if(data!='File not found')
				{
					$('#table_data').hide();
					$('#excel_hide').hide();
					$('#load').hide();
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
						$('#export_option').show();
						
						$('#plant_only').show();
						$('#day_only').show();
						
				}
				
				else
				{
					$('#excel_hide').hide();
					var files1 = $('#file_name').val();			
					alert('that File does not exist - Call Reporting Package Manager');
					$('#load').hide();
					
				} 
				
				}
				
				}); 
	
$('#hour_btn').hide();
$('#till_btn').hide();



$('#schedule').show();
$('#report').hide();

$('#excel_icon').css('cursor', 'pointer');
$('#pdf_icon').css('cursor', 'pointer');


//--------------------------------------------------------------------

$('#blcok_sel').change(
    function() {      
$('html, body').animate({scrollTop:$('body').position().top}, 'slow');	
        var sel = $('#blcok_sel option:selected').val();
		$('#block_select').val(sel);
		
		$('#export_option').hide();


var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);			
		
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
				
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('block_select').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);						
				//check_html();		
				//$('#schedule_13').click();

				
		
$('#load').show();	
var files = $('#file_name').val();
//alert(files);
var file_name = $('#file_name').val();
var report_name = $('#report_name1').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
var to_date = $('#todate').val();

var block_sel = $('#block_select').val();

	if(to_date == '')
		var to_date = from_date;
	
var file_name = $('#file_name').val();
var report_name = $('#report_name').val();
var plant = $('#plant').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
$('#datetimepicker').val(from_date);
var to_date = $('#from_date').val();
var block_sel = $('#block_select').val();
//var time = $('#time_now').val();
var time = document.getElementById('time_now').value

					$('#table_data').hide();
					$('#load').show();
			
					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",	
				//data: 'file_name='+file_name,	
				//data: 'file_name='+file_name+'&block_sel='+block_sel,				
				data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+plant+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				type: "POST",
			success:function(data){ 						
				$('#load').hide();
				if(data!='File not found')
				{
					//alert(files);
					$('#table_data').hide();
					$('#excel_hide').hide();
					//alert(data);
					$('#load').hide();
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
						$('#export_option').show();
				}
				
				else
				{
					$('#excel_hide').hide();
					//alert(files);
					var files1 = $('#file_name').val();
					//alert(files1);
					alert('that File does not exist - Call Reporting Package Manager');
					$('#load').hide();
				}
				}
				
				});				
  
    }
	);
	
//--------------------------------------------------

$('#block_sel_select').change(
    function() {
$('html, body').animate({scrollTop:$('body').position().top}, 'slow');
$('#export_option').hide();

	$('#day_only').hide();
	
        var sel = $('#block_sel_select option:selected').val();
		$('#block_select').val(sel);
	
		$('#export_option').hide();
	
	$('#block_sel_select').val();
	
var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);				
		
		
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
			
			var report_na = document.getElementById('report_name').value;
			
			if(report_na == 'Inverter_Report')
				$('#excel_hide').hide();
											
				
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('block_sel_select').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);				
	
	if(report_na == 'Daily_Generation_Report')			
		$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('block_sel_select').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);				
	
$('#load').show();	
var files = $('#file_name').val();
//alert(files);
var file_name = $('#file_name').val();
var report_name = $('#report_name1').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
var to_date = $('#todate').val();

var block_sel = document.getElementById('block_sel_select').value;
$('#block_select').val(block_sel);

	if(to_date == '')
		var to_date = from_date;
	
	
							
					$('#load').show();
	
var file_name = $('#file_name').val();
var report_name = $('#report_name').val();
var plant = $('#plant').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
$('#datetimepicker').val(from_date);
var to_date = $('#from_date').val();
var block_sel = $('#block_select').val();
//var time = $('#time_now').val();
var time = document.getElementById('time_now').value									

					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",	
				//data: 'file_name='+file_name,	
				//data: 'file_name='+file_name+'&block_sel='+block_sel,				
				data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+plant+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				type: "POST",
			success:function(data){ 						
				$('#load').hide();
				if(data!='File not found')
				{
					//alert(files);
					$('#table_data').show();
					$('#excel_hide').hide();
					//alert(data);
					$('#load').hide();					
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
						$('#export_option').show();
						
				if(report_na == 'Inverter_Report'){								
					$('#day_only').show();	
				}	
				
				}
				
				else
				{
					$('#excel_hide').hide();
					//alert(files);
					var files1 = $('#file_name').val();
					//alert(files1);
					alert('that File does not exist - Call Reporting Package Manager');
					$('#load').hide();
				}
				}
				
				});					
        
    }
	);	


	
});

</script>	

	<script>	
	
$(document).ready(function() {

$('#export_option').hide();

//--------------------------------------------------------------------------------------------------------


	$('#inverter_report_graph').click(function () { 
		$('#excel_hide').hide();	
			
		var fromdate = document.getElementById('fromdate').value
		var todate = document.getElementById('todate').value		
		var plant = document.getElementById('plant').value
		var type = document.getElementById('d_m_y_text').value

		$('#load').show();
			$.ajax({ 
		url:"<?php echo base_url();?>inverter_graph",
			
		data: 'type='+type+'&plant='+plant+'&from_date='+fromdate,				
		
        type: "POST",
        success:function(data){	
		$('#load').hide();
		
		//alert(data);
		$('#table_data_div').show();
		$('#table_data').show();
		
		var block_data = new Array();
		block_data = data.split(",");
		block_data_len = block_data.length;
		

	
//if(plant=='lomada') {	
    $('#table_data').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Blockwise Inverter Generation' //'Lomada change blocks for both graph'
        },
        
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Energy (MWh)'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Energy: <b>{point.y:.1f}MWh</b>'
        },
        series: [{
            name: 'Energy',
            data: [
                ['Block 1', Number(block_data[0])],
                ['Block 2', Number(block_data[1])],
                ['Block 3', Number(block_data[2])],
                ['Block 4', Number(block_data[3])]
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
  // }	
		
//--------------------------------------------------------------------------------------

$('#day_only').show();
$('#plant_only').hide();
$('#hour_btn').show();
$('#till_btn').show();
$('#export_option').show();


	$('#block_sel2').show();	
	$('#block_sel_select').show();	
		} 
		});
});	


//--------------------------------------------------------------------------------------------------------





	$('#block_report_graph').click(function () { 
		$('#excel_hide').hide();	
			
			
			
		var fromdate = document.getElementById('fromdate').value			
		var plant = document.getElementById('plant').value
		var type = document.getElementById('d_m_y_text').value
		
			var to_date = $('#todate').val();
	
	var tdate = document.getElementById('todate').value;
	

		$('#load').show();
			$.ajax({ 
		url:"<?php echo base_url();?>block_graph",
			
		data: 'type='+type+'&plant='+plant+'&from_date='+fromdate,				
		
        type: "POST",
        success:function(data){	
		
		//alert(data);
		$('#table_data_div').show();
		$('#table_data').show();
		
		var block_data = new Array();
		block_data = data.split("_");
		block_data_len = block_data.length;
//alert(block_data_len);

$('#day_only').hide();
$('#hour_btn').hide();

var blocka = block_data[0].substring(0, block_data[0].length - 2);
var blockb = block_data[1].substring(0, block_data[1].length - 2);
var blockc = block_data[2].substring(0, block_data[2].length - 2);
/*var blockd = block_data[3].substring(0, block_data[3].length - 2);*/

/*var blocke = block_data[4].substring(0, block_data[4].length - 2);
var blockf = block_data[5].substring(0, block_data[5].length - 2);
var blockg = block_data[6].substring(0, block_data[6].length - 2);
var blockh = block_data[7].substring(0, block_data[7].length - 2);
*/
blocka= blocka.split(',');  
blockb= blockb.split(',');  blockc= blockc.split(',');  
//blockd= blockd.split(',');  
//blocke= blocke.split(',');  blockf= blockf.split(',');    blockg= blockg.split(',');   blockh= blockh.split(',');

var alen = blocka.length;
if(alen < 14){	
for(i=alen+1; i<14; i++){
		blocka[i] = 0;   
		blockb[i] = 0;     blockc[i] = 0;        
		//blockd[i] = 0;     
		//blocke[i] = 0;         blockf[i] = 0;  blockg[i] = 0;  blockh[i] = 0;
		}
	}		
	
			


if(alen < 14){
	blocka[alen] = 0;   
	blockb[alen] = 0;    blockc[alen] = 0;    
	//blockd[alen] = 0;    
			//blocke[alen] = 0;    blockf[alen] = 0;    blockg[alen] = 0;     blockh[alen] = 0; 
			}	

    $('#table_data').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Block Report Hourly'
        },
  credits: {
    enabled: false
  },		
        xAxis: {
            min: 0,
            title: {
                text: 'Time in hours (HH)'
            }
        },			
        xAxis: {
			
            categories: ['06',
                '07',
                '08',
                '09',
                '10',
                '11',
                '12',
                '13',
                '14',
                '15',
                '16',
                '17',
				'18',
				'19'],
            title: {
                text: 'Time in Hours'
            }            
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Energy MWh '
            }
        },
		
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} MWh</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Block A',
            data: [Number(blocka[0]), Number(blocka[1]), Number(blocka[2]), Number(blocka[3]), Number(blocka[4]), Number(blocka[5]), Number(blocka[6]), Number(blocka[7]), Number(blocka[8]), Number(blocka[9]), Number(blocka[10]), Number(blocka[11]), Number(blocka[12]), Number(blocka[13])]

        }
        , {
            name: 'Block B',
            data: [Number(blockb[0]), Number(blockb[1]), Number(blockb[2]), Number(blockb[3]), Number(blockb[4]), Number(blockb[5]), Number(blockb[6]), Number(blockb[7]), Number(blockb[8]), Number(blockb[9]), Number(blockb[10]), Number(blockb[11]), Number(blockb[12]), Number(blockb[13])]

        }, {
            name: 'Block C',
            data: [Number(blockc[0]), Number(blockc[1]), Number(blockc[2]), Number(blockc[3]), Number(blockc[4]), Number(blockc[5]), Number(blockc[6]), Number(blockc[7]), Number(blockc[8]), Number(blockc[9]), Number(blockc[10]), Number(blockc[11]), Number(blockc[12]), Number(blockc[13])]

        }/*, {
            name: 'Block D',
            data: [Number(blockd[0]), Number(blockd[1]), Number(blockd[2]), Number(blockd[3]), Number(blockd[4]), Number(blockd[5]), Number(blockd[6]), Number(blockd[7]), Number(blockd[8]), Number(blockd[9]), Number(blockd[10]), Number(blockd[11]), Number(blockd[12]), Number(blockd[13])]

        }*/
        /*, {
            name: 'Block E', color: '#FF0000',
            data: [Number(blocke[0]), Number(blocke[1]), Number(blocke[2]), Number(blocke[3]), Number(blocke[4]), Number(blocke[5]), Number(blocke[6]), Number(blocke[7]), Number(blocke[8]), Number(blocke[9]), Number(blocke[10]), Number(blocke[11]), Number(blocke[12]), Number(blocke[13])]
		
        }, {
            name: 'Block F',
            data: [Number(blockf[0]), Number(blockf[1]), Number(blockf[2]), Number(blockf[3]), Number(blockf[4]), Number(blockf[5]), Number(blockf[6]), Number(blockf[7]), Number(blockf[8]), Number(blockf[9]), Number(blockf[10]), Number(blockf[11]), Number(blockf[12]), Number(blockf[13])]

        }, {
            name: 'Block G',
            data: [Number(blockg[0]), Number(blockg[1]), Number(blockg[2]), Number(blockg[3]), Number(blockg[4]), Number(blockg[5]), Number(blockg[6]), Number(blockg[7]), Number(blockg[8]), Number(blockg[9]), Number(blockg[10]), Number(blockg[11]), Number(blockg[12]), Number(blockg[13])]

        }, {
            name: 'Block H',
            data: [Number(blockh[0]), Number(blockh[1]), Number(blockh[2]), Number(blockh[3]), Number(blockh[4]), Number(blockh[5]), Number(blockh[6]), Number(blockh[7]), Number(blockh[8]), Number(blockh[9]), Number(blockh[10]), Number(blockh[11]), Number(blockh[12]), Number(blockh[13])]

        }*/
		]
    });



		$('#load').hide();

	
	//$('#block_sel2').show();	
	//$('#block_sel_select').show();	
	
		} 
		});
});	



	
$('ul #scheduled ul li').on('click',function(){ 
	$('li').children('a').css('background','');
	$(this).children('a').css('background','#059279');
		$('li').children('a').css('border-right','none');
		$('li').children('a').css('color','#DDD');	
	$("td:last-child").css({border:"none"})

}); 


$('ul #scada ul li').on('click',function(){ 
	$('li').children('a').css('background','');
		$('li').children('a').css('color','#DDD');
		$(this).children('a').css('background','#059279');

}); 
});                        
</script>	
	<script>
$(document).ready(function() {
	
$("#day_only").find(".btn").click(function () { 
$('#day_only .btn').removeClass('btn_active');

$(this).removeClass('btn-default');
$(this).addClass('btn_active');
}); 


$('#plant_only').find(".btn").click(function () {  
$('#plant_only .btn').removeClass('btn_active');
$(this).removeClass('btn-default');
$(this).addClass('btn_active');
}); 
});                        
</script>


   
   <script>
   $(document).ready(function() { 
	   $('#load').hide();
	   $('#excel_hide').hide();
	   	    
	   
	   
	   $('#day_only .btn').removeClass('btn_active');
		$('#day_only .btn').removeClass('btn-default');
		$('#plant_only .btn').removeClass('btn_active');
		$('#plant_only .btn').removeClass('btn-default');
	   
	   $('#plant1_btn').addClass('btn_active');
	   $('#date_btn').addClass('btn_active');
	   
		var currentDate = ("0" + (new Date).getDate()).slice(-2)        
		$('#day_m_y').val(currentDate);		
		
		
		var currentMonth = ("0" + ((new Date).getMonth() + 1)).slice(-2)		        
		$('#d_month_y').val(currentMonth);
		
		
		var currentYear = (new Date).getFullYear();        
		$('#d_m_year').val(currentYear);
		
		
		$('#d_m_y_text').val("day");	
} );

$(document).ready(function() {
	$('#load').show();	
	

//-------------------------------------------------------------------------------------------------------
	
$('#date_btn').click(function () {	
$('html, body').animate({scrollTop:$('body').position().top}, 'slow');
var report_name = $('#report_name').val();
if(report_name == 'Inverter_Report'){
	$('#excel_hide').hide();
	$('#table_data').show();
}

if(report_name == 'Inverter_Report' || report_name == 'ScaDaiGenRep')
	block_sel = document.getElementById('block_sel_select').value;

$('#type_value').val('Day');
$('#d_m_y_text').val('Day');

var type_value = $('#type_value').val();
var plant = $('#plant').val();
var from_date = $('#fromdate').val();
$('#todate').val(from_date);
var to_date = $('#todate').val();

$('#plant_only').hide();
$('#day_only').hide();
$('#export_option').hide();

	if(to_date == '')
		var to_date = from_date;
	var datepicker = document.getElementById('datetimepicker').value;
var block_sel = document.getElementById('block_select').value					

 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);	


$('#file_name').val(report_name+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+datepicker+"_"+time);	

if(report_name == 'Inverter_Report')
		$('#file_name').val(report_name+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+block_sel+"_"+datepicker+"_"+time);	

var file_name = $('#file_name').val();

var report_name = $('#report_name1').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();

var block_sel = $('#block_select').val();

	if(to_date == '')
		var to_date = from_date;

var report_name = $('#report_name').val();
var plant = $('#plant').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
$('#datetimepicker').val(from_date);
var to_date = $('#from_date').val();
var block_sel = $('#block_select').val();
//var time = $('#time_now').val();
var time = document.getElementById('time_now').value

$('#load').show();
					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",	
				//data: 'file_name='+file_name+'&block_sel='+block_sel,				
				data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+plant+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				type: "POST",
			success:function(data){ 						
			
				
				if(data!='File not found')
				{

					//$('#table_data').hide();
					
					$('#excel_hide').hide();					
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
						$('#export_option').show();
						
					$('#plant_only').show();

					if(report_name == 'Inverter_Report' || report_name == 'Inverter_Daily_Generation')
						$('#plant_only').hide();
		
					$('#day_only').show();	

				}
				
				else
				{
					$('#excel_hide').hide();					
					var files1 = $('#file_name').val();
					alert('that File does not exist - Call Reporting Package Manager');
					
				} 
					$('#load').hide();
						$('#table_data').hide();
						if(report_name == 'Inverter_Report')
							$('#table_data').show();												
				}
				
				}); 
});	

//-----------------------------------------------------------------------------------------------

$('#month_btn').click(function () { 
$('#load').show();	

$('html, body').animate({scrollTop:$('body').position().top}, 'slow');

 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			
$('#time_now').val(time);	


var file_name = $('#file_name').val();
var file_name_aplit = $('#file_name').val().split("_");
var files = file_name_aplit[0];

var files = $('#report_name').val();

if(files == 'Inverter_Report'){
	$('#excel_hide').hide();
	$('#table_data').show();
}

$('#type_value').val('Month');
$('#d_m_y_text').val('Month');

var type_value = $('#type_value').val();
var plant = $('#plant').val();
var from_date = $('#fromdate').val();
$('#todate').val(from_date);
var to_date = $('#todate').val();

	
$('#plant_only').hide();
$('#day_only').hide();
$('#export_option').hide();

	if(to_date == '')
		var to_date = from_date;
	
var block_sel = '';
	
if(files == 'ScaStaRep')
	block_sel = 'Nill';


if(files == 'Inverter_Report' || files == 'ScaDaiGenRep'){
	block_sel = $('#block_sel_select').val(); 
	$('#export_option').hide();			
}

			
$('#file_name').val(files+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('block_select').value+"_"+document.getElementById('fromdate').value+"_"+time);	
	
if(files == 'Station_Report')
{
	$('#file_name').val(files+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('fromdate').value+"_"+time);	
}
var file_name = $('#file_name').val();
var report_name = $('#report_name').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
var to_date = $('#todate').val();


	if(to_date == '')
		var to_date = from_date;
	
	
	if(files == 'Station_Report')
		block_sel = 'Nill';



					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",	
				//data: 'file_name='+file_name+'&block_sel='+block_sel,				
				data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+document.getElementById('plant').value+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				type: "POST",
			success:function(data){ 						
			$('#load').hide();
				
				if(data!='File not found')
				{

					
					$('#excel_hide').hide();					
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
						$('#export_option').show();
					$('#plant_only').show();
										
					if(report_name == 'Inverter_Report' || files == 'Inverter_Daily_Generation')
						$('#plant_only').hide();					
					
					$('#day_only').show();
				}
				
				else
				{
					$('#excel_hide').hide();					
					var files1 = $('#file_name').val();
					alert('that File does not exist - Call Reporting Package Manager');
					
				} 
					$('#load').hide();
						
						if(files == 'Inverter_Report')
							$('#table_data').show();							
						else
							$('#table_data').hide();
				}
				
				}); 
	
			
								
});	


//----------------------------------------------------------------------------------------------


$('#year_btn').click(function () {	
	$('#load').show();	
	
$('html, body').animate({scrollTop:$('body').position().top}, 'slow');
	
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			
$('#time_now').val(time);		
	
var file_name = $('#file_name').val();
var file_name_aplit = $('#file_name').val().split("_");
var files = file_name_aplit[0];

var files = $('#report_name').val();


if(files == 'Inverter_Report')
	$('#excel_hide').hide();

$('#type_value').val('Year');
$('#d_m_y_text').val('Year');

var type_value = $('#type_value').val();
var plant = $('#plant').val();
var from_date = $('#fromdate').val();
$('#todate').val(from_date);
var to_date = $('#todate').val();

var block_sel = $('#block_select').val();

var block_sel = 'Nill';


if(files == 'Inverter_Report' || files == 'Inverter_Daily_Generation'){
	block_sel = document.getElementById('block_sel_select').value;
	$('#export_option').hide();			
}

$('#plant_only').hide();
$('#day_only').hide();
$('#export_option').hide();
	
if(files == 'Inverter_Report'){ 
	$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('block_sel_select').value+"_"+document.getElementById('fromdate').value+"_"+time);	
}
else
{ 
	$('#file_name').val(files+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('fromdate').value+"_"+time);	
}

var file_name = $('#file_name').val();
var report_name = $('#report_name').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
var to_date = $('#todate').val();

//var block_sel = '';
//var report_name = $('#report_name').val();		
if(files == 'Station_Report')
	block_sel = 'Nill';

	//if(to_date == '')
	//	$("#todate").val(from_date);
	if(to_date == '')
		var to_date = from_date;
	
	
							//$('#table_data').hide();
							


					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",	
				//data: 'file_name='+file_name+'&block_sel='+block_sel,				
				data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+document.getElementById('plant').value+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				type: "POST",
			success:function(data){ 						
			$('#load').hide();
				
				if(data!='File not found')
				{

					//$('#table_data').hide();
					$('#excel_hide').hide();					
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
						$('#export_option').show();
					
						$('#plant_only').show();
					if(files == 'Inverter_Report' || files == 'Daily_Generation_Report')
						$('#plant_only').hide();					
					
						$('#day_only').show();
						

				}
				
				else
				{
					$('#excel_hide').hide();					
					var files1 = $('#file_name').val();
					alert('that File does not exist - Call Reporting Package Manager');
					
				} 
					$('#load').hide();
						$('#table_data').hide();
						if(files == 'Inverter_Report')
							$('#table_data').show();												
				}
				
				}); 
	
});	



$('#till_btn').click(function () {	
	$('#load').show();	

$('html, body').animate({scrollTop:$('body').position().top}, 'slow');	
	
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			
$('#time_now').val(time);	
	
	
var file_name = $('#file_name').val();
var file_name_aplit = $('#file_name').val().split("_");
var files = file_name_aplit[0];

var files = $('#report_name').val();

$('#table_data').show();

	$('#excel_hide').hide();

$('#type_value').val('TillDate');
$('#d_m_y_text').val('TillDate');

var type_value = $('#type_value').val();
var plant = $('#plant').val();
var from_date = $('#fromdate').val();
var to_date = $('#todate').val();

var block_sel = $('#block_select').val();


var block_sel = 'Nill';
if(files == 'Inverter_Report' || files == 'Inverter_Daily_Generation')
	block_sel = document.getElementById('block_sel_select').value;

$('#plant_only').hide();
$('#day_only').hide();
$('#export_option').hide();

	if(to_date == '')
		var to_date = from_date;
		
	//$('#table_data').hide();								
			
$('#file_name').val(files+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('block_sel_select').value+"_"+document.getElementById('fromdate').value+"_"+time);	
	

var file_name = $('#file_name').val();
var report_name = $('#report_name').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
var to_date = $('#todate').val();


	//if(to_date == '')
	//	$("#todate").val(from_date);
	if(to_date == '')
		var to_date = from_date;
	
	
							//$('#table_data').hide();
							


					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",	
				//data: 'file_name='+file_name+'&block_sel='+block_sel,				
				data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+document.getElementById('plant').value+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				type: "POST",
			success:function(data){ 						
			$('#load').hide();
				
				if(data!='File not found')
				{

					//$('#table_data').hide();
					$('#excel_hide').hide();					
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
						$('#export_option').show();
						
					if(files == 'Inverter_Report' || files == 'Daily_Generation_Report')
					$('#plant_only').show();
						$('#plant_only').hide();					
					
					$('#day_only').show();

						

				}
				
				else
				{
					$('#excel_hide').hide();					
					var files1 = $('#file_name').val();
					alert('that File does not exist - Call Reporting Package Manager');
					
				} 
					$('#load').hide();
						$('#table_data').hide();
						if(files == 'Inverter_Report')
							$('#table_data').show();												
				}
				
				}); 
	
});	


//----------------------------------------------------------------------------------------


$('#hour_btn').click(function () {	
	$('#load').show();	

$('html, body').animate({scrollTop:$('body').position().top}, 'slow');	
	
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			
$('#time_now').val(time);		
	
var file_name = $('#file_name').val();
var file_name_aplit = $('#file_name').val().split("_");
var files = file_name_aplit[0];

var files = $('#report_name').val();

if(files == 'Inverter_Report')
	$('#excel_hide').hide();

if(files == 'Inverter_Report' || files == 'Daily_Generation_Report')
	block_sel = document.getElementById('block_sel_select').value;


$('#type_value').val('Hourly');
$('#d_m_y_text').val('Hourly');






var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
var to_date = $('#todate').val();

var block_sel = $('#block_select').val();

$('#plant_only').hide();
$('#day_only').hide();
$('#export_option').hide();

	if(to_date == '')
		var to_date = from_date;

$('#file_name').val(files+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('block_sel_select').value+"_"+document.getElementById('fromdate').value+"_"+time);	
	

var file_name = $('#file_name').val();
var report_name = $('#report_name').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
var to_date = $('#todate').val();



					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",	
				//data: 'file_name='+file_name+'&block_sel='+block_sel,				
				data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+document.getElementById('plant').value+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				type: "POST",
			success:function(data){ 						
			$('#load').hide();
				
				if(data!='File not found')
				{

					//$('#table_data').hide();
					$('#excel_hide').hide();					
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
						$('#export_option').show();
						
					$('#plant_only').show();
					if(files == 'Inverter_Report' || files == 'Daily_Generation_Report')
						$('#plant_only').hide();					
					
					$('#day_only').show();
						

				}
				
				else
				{
					$('#excel_hide').hide();					
					var files1 = $('#file_name').val();
					alert('that File does not exist - Call Reporting Package Manager');
					
				} 
					$('#load').hide();
						$('#table_data').hide();
						if(files == 'Inverter_Report')
							$('#table_data').show();												
				}
				
				}); 
	
});	

});





       $(function () {
		   
		   
//---------------------------------------------------------------------------------		   

	$('#search').click(function () {
		
		
var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			
$('#time_now').val(time);						
	

var type_cap = document.getElementById('d_m_y_text').value;		

type_cap = type_cap.charAt(0).toUpperCase() + type_cap.substr(1);
$('#d_m_y_text').val(type_cap);						
	
var report_name = document.getElementById('report_name').value;	

var datepicker = document.getElementById('datetimepicker').value;


var str = datepicker;
	var res = str.replace("/", "-"); 
	var res = res.replace("/", "-"); 	
	
	var array_datepicker = res.split("-");

	
	
		tes_datepicker_1 = array_datepicker[2]+'-'+array_datepicker[1]+'-'+array_datepicker[0];				
		var tes_datepicker_new = array_datepicker[0]+'-'+array_datepicker[1]+'-'+array_datepicker[2];				

 

	//$('#datetimepicker').val(tes);	
$('#datetimepicker').val(tes_datepicker_new);				
$("#fromdate").val(tes_datepicker_new);



//--------------------------------------

	if(report_name == 'Inverter_Report')
		$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('block_select').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);
	if(report_name == 'SMU_Hourly_Communication_Report' || report_name == 'Block_Report')
		$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('block_select').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);
	else if(report_name == 'Station_Report'){		
		$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);
	}
	else if(report_name == 'Import_Export' || report_name == '33kV_Feeder_Report' || report_name == '33kV_Block_Report' || report_name == 'SMU_Generation_Report' || report_name == 'Inverter_Generation_Report' || report_name == 'SMU_Daily_Communication_Report' || report_name == 'WMS_OneMinutes_Report' || report_name == 'WMS_Monthly_Report' || report_name == 'Inverter_Monthly_Generation_Report' || report_name == 'Plant_Generation_Report' || report_name == 'Main_Page_Daily' || report_name == 'Parameter_Daily_Report' || report_name == 'Plant_Daily_Generation_Report' || report_name == 'Main_Page_Daily' || report_name == 'Monthly_Report')
		$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);

	
	if(report_name == 'ScaInvRep'){
		$('#plant_only').hide();
		$('#export_option').hide();
		//check_html();
		//$('#inverter_report_graph').click(); 
		
		
//------

var file_name = document.getElementById('file_name').value;
var block_sel = $('#block_select').val();

			$('#load').show();
					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",	
				//data: 'file_name='+file_name,	
				//data: 'file_name='+file_name+'&block_sel='+block_sel,				
				data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+plant+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				
				type: "POST",
			success:function(data){ 				
			$('#load').hide();
			
	
if(report_name == 'ScaBloRep')
	$('#block_report_graph').click();							

else if(report_name == 'ScaInvRep')
	$('#inverter_report_graph').click();

				
				if(data!='File not found')
				{
					//alert(files);
					$('#table_data').hide();
					$('#excel_hide').hide();
					//alert(data);
					//$('#load').hide();
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
			
				}
				
				else
				{
					$('#excel_hide').hide();
					//alert(files);
					var files1 = $('#file_name').val();
					//alert(files1);
					alert('that File does not exist - Call Reporting Package Manager');
					$('#load').hide();
					
				} 
				
$('#export_option').show();

				}
				
				}); 



//----				
		
	}
	else if(report_name == 'ScaBloRep'){
		$('#plant_only').hide();
		$('#day_only').hide();
		$('#export_option').hide();
		
		
		
		
//------

var file_name = document.getElementById('file_name').value;
var block_sel = $('#block_select').val();

			$('#load').show();
					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",
				data: 'file_name='+file_name+'&block_sel='+block_sel,				
				
				type: "POST",
			success:function(data){ 				
			$('#load').hide();
			
	
if(report_name == 'ScaBloRep')
	$('#block_report_graph').click();							

else if(report_name == 'ScaInvRep')
	$('#inverter_report_graph').click();

				
				if(data!='File not found')
				{
					//alert(files);
					$('#table_data').hide();
					$('#excel_hide').hide();
					//alert(data);
					//$('#load').hide();
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
			
				}
				
				else
				{
					$('#excel_hide').hide();
					//alert(files);
					var files1 = $('#file_name').val();
					//alert(files1);
					alert('that File does not exist - Call Reporting Package Manager');
					$('#load').hide();
					
				} 
				
$('#export_option').show();

				}
				
				}); 



//----		

		$('#block_report_graph').click(); 
		
	}	
	else{
		check_html();
	}
	
	})			

//--------------------------------------------------------------------------------------------------	
		
	
            $('#scada_1').click(function () {  								
			
				$('#dmy_mtt').show();
				//$('#day_only').show();
				
				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');				
				$("#fromdate").val(today_date);	
				//$("#todate").val(today_date);

				
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];

  for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value
			
			
var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);				
				
				
				    $('#day_only .btn').removeClass('btn_active');
					$('#day_only .btn').removeClass('btn-default');		
					$('#plant_only .btn').removeClass('btn_active');
					$('#plant_only .btn').removeClass('btn-default');		
					
					$('#date_btn').addClass('btn_active');			
					$('#plant1_btn').addClass('btn_active');			
				
			var fdate = document.getElementById('fromdate').value;
			$('#todate').val(fdate);
			
			var tdate = fdate;
			if(tdate == '')
				$("#todate").val(fdate);
			
				$('#type_value').val('Day');
				$('#report_name').val('Station_Report');						
				$('#d_m_y_text').val('Day');
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);				
				$('#hour_btn').hide();	
				$('#block_select').val("Nill");	
var bl = document.getElementById('block_select').value	
		

				$('#blcok_sel').hide();														
				$('#blcok_sel2').hide();			
				check_html();
				
				return false;

            });
			
			$('#scada_2').click(function () { 

			
				    $('#day_only .btn').removeClass('btn_active');
					$('#day_only .btn').removeClass('btn-default');		
					$('#plant_only .btn').removeClass('btn_active');
					$('#plant_only .btn').removeClass('btn-default');		
					
					$('#date_btn').addClass('btn_active');			
					$('#plant1_btn').addClass('btn_active');			
			
				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');				
				$("#fromdate").val(today_date);	
				
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];

 
 for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value
			
			
var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);				
							
			
			$('#todate').val(fdate);
			
			var tdate = fdate;
			
			if(tdate == '')
				$("#todate").val(fdate);
			
				$('#day_only').hide();	
				$('#plant_only').show();
				$('#hour_btn').hide();
				$('#d_m_y_text').val("day");
				$('#type_value').val('day');
				$('#report_name').val('Import_Export');
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);	
				$('#blcok_sel').hide();	
				$('#block_select').val("Nill");				
				check_html();
                return false;
            });
			
//------------------------------------------------------------------			
			
			$('#scada_3').click(function () {

				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');				
				$("#fromdate").val(today_date);	
				
				
var array = today_date.split("-");
 
 for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value
			
			
var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);	

			
				
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);

			
				$('#day_only').hide();
				$('#hour_btn').hide();
				$('#plant_only').hide();
				$('#d_m_y_text').val("day");
				$('#type_value').val("day");	
				$('#report_name').val('33kV_Feeder_Report');				
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);	
				$('#blcok_sel').hide();	
$('#block_select').val("Nill");				
				check_html();				
                return false;
            });
			
//-----------------------------------------------------------------------------------			
						
			$('#scada_4').click(function () { 	

				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');				
				$("#fromdate").val(today_date);	
				//$("#todate").val(today_date);
				
				
var array = today_date.split("-");

 for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value
			
			
var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);	
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			
			if(tdate == '')
				$("#todate").val(fdate);

			
				$('#day_only').hide();	
				$('#plant_only').hide();
				$('#hour_btn').hide();
				$('#export_option').hide();				
				//$("#todate").val(today_date);
				$('#d_m_y_text').val("day");
				$('#type_value').val("day");
				$('#report_name').val('33kV_Block_Report');
				$('#block_select').val("Nill");					
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);	
				$('#blcok_sel').hide();					
				//$('#block_report_graph').click();				
				check_html();	
                return false;
            });
			
			
//--------------------------------------------------------------------------			
	
			$('#scada_5').click(function () {  

	$('#blcok_sel').show();			
	   $('#day_only .btn').removeClass('btn_active');
		$('#day_only .btn').removeClass('btn-default');
		$('#plant_only .btn').removeClass('btn_active');
		$('#plant_only .btn').removeClass('btn-default');
	   
	   $('#plant1_btn').addClass('btn_active');
	   $('#date_btn').addClass('btn_active');			
			
			


				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');				
				$("#fromdate").val(today_date);	
				//$("#todate").val(today_date);
				
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];

 for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value
			
			
var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);	
				
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
			
				$('#day_only').hide();
				$('#plant_only').hide();
				$('#export_option').hide();				
				//$('#hour_btn').show();
				$('#d_m_y_text').val("Day");
				$('#type_value').val("Day");
				$('#report_name').val('Inverter_Report');
$('#block_select').val("All");				
document.forms["form2"].elements["block_sel_select"].selectedIndex = 0;	
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('block_select').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);	
				
				//$('#inverter_report_graph').click();							
				$('#blcok_sel2').show();				
				check_html();	
                return false;
            });
			
//-----------------------------------------------------------------------
			
			$('#scada_6').click(function () { 


  
				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');				
				$("#fromdate").val(today_date);	
				//$("#todate").val(today_date);
				
				
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];

 for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value
			
			
var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);	
				
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);			

			
				$('#day_only').hide();	
				$('#plant_only').hide();
				$('#hour_btn').hide();		

				$('#d_m_y_text').val("day");
				$('#type_value').val("day");
				$('#report_name').val('Daily_Generation_Report');	
				$('#block_select').val("All");
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('block_select').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('time_now').value);	
				$('#blcok_sel').hide();				
				check_html();
			
				document.forms["form2"].elements["block_sel_select"].selectedIndex = 0;
                return false;
            });
	  var currentTime = new Date();
  var day = currentTime.getDate();
  var month = currentTime.getMonth() + 1;
  var year = currentTime.getFullYear();

  if (day < 10){
  day = "0" + day;
  }

  if (month < 10){
  month = "0" + month;
  }

  
  var today_date = year + "-" + month + "-" + day;
//alert(today_date);  



//--------------------------------------------------------------------------------------------------



			$('#schedule_1').click(function () {  
				$('#day_only .btn').removeClass('btn_active');
				$('#day_only .btn').removeClass('btn-default');	
				$('#plant_only .btn').removeClass('btn_active');
				$('#plant_only .btn').removeClass('btn-default');					
				$('#date_btn').addClass('btn_active');
				$('#plant1_btn').addClass('btn_active');
				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');	
				var today_date_test = day + "-" + month + "-" + year;			
				$("#fromdate").val(today_date);
				var array = today_date.split("-");

				for (var i in array)
     				var tes = array[0]+'/'+array[1]+'/'+array[2];

			 for (var i in array)
				 var tes_now = array[2]+'-'+array[1]+'-'+array[0];
						$('#datetimepicker').val(tes_now);			
						$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value			
			var dt = new Date();			
			var time = dt.getHours() + "-" + dt.getMinutes();			
			$('#time_now').val(time);								
			$('#report_name1').val('Inverter_Generation_Report');
			$('#type_value').val('instantaneous');
			$('#report_name').val('Inverter_Generation_Report');
			$('#d_m_y_text').val('instantaneous');
			
			$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);
			$('#day_only').hide();
			$('#plant_only').hide();
			$('#block_select').val("Nill");
			$('#blcok_sel').hide();		
			check_html();			
			});
			

//----------------------------------------------------


			$('#schedule_2').click(function () {  
			
			
				$('#day_only .btn').removeClass('btn_active');
				$('#day_only .btn').removeClass('btn-default');	
				$('#plant_only .btn').removeClass('btn_active');
				$('#plant_only .btn').removeClass('btn-default');					
				$('#date_btn').addClass('btn_active');
				$('#plant1_btn').addClass('btn_active');			
			
			
			$('#datetimepicker').val('');	
			$('#datetimepicker1').val('');	
				$("#fromdate").val(today_date);
				//$("#todate").val(today_date);
				
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];
 

 
 for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value 
 
 
 
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);		
 
 var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			 
 
			
			
				$('#type_value').val('instantaneous');
				$('#report_name1').val('SMU_Generation_Report');
				$('#report_name').val('SMU_Generation_Report');
				$('#d_m_y_text').val('instantaneous');				
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);
				$('#day_only').hide();
				$('#plant_only').hide();
				$('#block_select').val("Nill");	
				$('#blcok_sel').hide();	
					
				check_html();
			});
			
//----------------------------------------------------			
			
			$('#schedule_3').click(function () { 
			
				$('#day_only .btn').removeClass('btn_active');
				$('#day_only .btn').removeClass('btn-default');	
				$('#plant_only .btn').removeClass('btn_active');
				$('#plant_only .btn').removeClass('btn-default');					
				$('#date_btn').addClass('btn_active');
				$('#plant1_btn').addClass('btn_active');						
			
			$('#datetimepicker').val('');	
			$('#datetimepicker1').val('');	
			$("#fromdate").val(today_date);	
			//$("#todate").val(today_date);
			
			
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];


 for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value 
 
 
 
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);		
 
 var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			 

		
			
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);			
			
			$('#type_value').val('instantaneous');
			$('#report_name1').val('SMU_Daily_Communication_Report');
			$('#report_name').val('SMU_Daily_Communication_Report');
			$('#d_m_y_text').val('instantaneous');
			$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);
				$('#day_only').hide();
				$('#plant_only').hide();
				$('#block_select').val("Nill");	
				$('#blcok_sel').hide();								
				check_html();
			});
			
//----------------------------------------------------			
			
			
			$('#schedule_4').click(function () { 
			
				$('#day_only .btn').removeClass('btn_active');
				$('#day_only .btn').removeClass('btn-default');	
				$('#plant_only .btn').removeClass('btn_active');
				$('#plant_only .btn').removeClass('btn-default');					
				$('#date_btn').addClass('btn_active');
				$('#plant1_btn').addClass('btn_active');						
				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');	
				$("#fromdate").val(today_date);
			
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];

 
 for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value 
 
 
 
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);	
 	
 
 var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  
 
 
 

			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
			
			$('#type_value').val('day');
			$('#report_name1').val('WMS_OneMinutes_Report');
			$('#report_name').val('WMS_OneMinutes_Report');	
			$('#d_m_y_text').val('Day');			
			$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);	
			$('#day_only').hide();
			$('#plant_only').hide();
			$('#block_select').val("Nill");	
			$('#blcok_sel').hide();								
			check_html();
			});


//----------------------------------------------------			

			
			$('#schedule_5').click(function () {  
			
				$('#day_only .btn').removeClass('btn_active');
				$('#day_only .btn').removeClass('btn-default');	
				$('#plant_only .btn').removeClass('btn_active');
				$('#plant_only .btn').removeClass('btn-default');					
				$('#date_btn').addClass('btn_active');
				$('#plant1_btn').addClass('btn_active');			
				
			$('#datetimepicker').val('');	
			$('#datetimepicker1').val('');	
			$("#fromdate").val(today_date);
			//$("#todate").val(today_date);
			
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'-'+array[1]+'-01';
 
 
  for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value 
 
 
 
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);	
 
 var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			 
 
 
			
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
			
			$('#type_value').val('month');
			$('#report_name1').val('WMS_Monthly_Report');
			$('#report_name').val('WMS_Monthly_Report');		
			$('#d_m_y_text').val('month');			
			$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);	
				$('#day_only').hide();
				$('#plant_only').hide();
				$('#block_select').val("Nill");
				$('#blcok_sel').hide();								
				check_html();
			});
			
			
//----------------------------------------------------						
			
			$('#schedule_6').click(function () { 
			
			
				$('#day_only .btn').removeClass('btn_active');
				$('#day_only .btn').removeClass('btn-default');	
				$('#plant_only .btn').removeClass('btn_active');
				$('#plant_only .btn').removeClass('btn-default');					
				$('#date_btn').addClass('btn_active');
				$('#plant1_btn').addClass('btn_active');	
						
				
			$('#datetimepicker').val('');	
			$('#datetimepicker1').val('');	
			
						
			$("#fromdate").val(today_date);			
var array = today_date.split("-");
 
 for (var i in array)
     var tes = array[0]+'/'+array[1]+'/01';

 
  for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value 
 
 
 
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);		
 
 var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  
 
 
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);			
	
			$('#type_value').val('month');
			$('#report_name1').val('Inverter_Monthly_Generation_Report');
			$('#report_name').val('Inverter_Monthly_Generation_Report');	
			$('#d_m_y_text').val('month');
			$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);	
				$('#day_only').hide();
				$('#plant_only').hide();
				$('#block_select').val("Nill");	
				$('#blcok_sel').hide();								
				check_html();
			});	

			
//----------------------------------------------------									
			
			$('#schedule_7').click(function () { 
			
				$('#day_only .btn').removeClass('btn_active');
				$('#day_only .btn').removeClass('btn-default');	
				$('#plant_only .btn').removeClass('btn_active');
				$('#plant_only .btn').removeClass('btn-default');					
				$('#date_btn').addClass('btn_active');
				$('#plant1_btn').addClass('btn_active');						
			
				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');	
				$("#fromdate").val(today_date);	
				//$("#todate").val(today_date);
				
				
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];

   for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value 
 
 
 
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);		
 
 var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  
 
 
				
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
			
				$('#type_value').val('day');
				$('#report_name1').val('SMU_Hourly_Communication_Report');
				$('#report_name').val('SMU_Hourly_Communication_Report');						
				$('#d_m_y_text').val('day');
				$('#block_select').val("B01");				
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('block_select').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);
				
				$('#day_only').hide();
				$('#plant_only').hide();	
document.forms["form1"].elements["blcok_sel"].selectedIndex = 0;
				$('#blcok_sel').show();								

				
				check_html();
			});	
			
//----------------------------------------------------									

			$('#schedule_8').click(function () { 
			
				$('#day_only .btn').removeClass('btn_active');
				$('#day_only .btn').removeClass('btn-default');	
				$('#plant_only .btn').removeClass('btn_active');
				$('#plant_only .btn').removeClass('btn-default');					
				$('#date_btn').addClass('btn_active');
				$('#plant1_btn').addClass('btn_active');						
			
				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');	
				$("#fromdate").val(today_date);
				//$("#todate").val(today_date);
				
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];

 
   for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value 
 
 
 
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			
//alert(time);
$('#time_now').val(time);		
 
 var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  


			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
			
				$('#type_value').val('day');
				$('#report_name1').val('Plant_Generation_Report');
				$('#report_name').val('Plant_Generation_Report');						
				$('#d_m_y_text').val('day');
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);	
				
				$('#day_only').hide();
				$('#plant_only').show();
				$('#block_select').val("Nill");									
				$('#blcok_sel').hide();				
				check_html();
			});				
		
		
//----------------------------------------------------								
		
			$('#schedule_9').click(function () { 			
			
				$('#day_only .btn').removeClass('btn_active');
				$('#day_only .btn').removeClass('btn-default');	
				$('#plant_only .btn').removeClass('btn_active');
				$('#plant_only .btn').removeClass('btn-default');					
				$('#date_btn').addClass('btn_active');
				$('#plant1_btn').addClass('btn_active');						
			
				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');	
				$("#fromdate").val(today_date);	
				//$("#todate").val(today_date);
				
				
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];

 
   for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value 
 
 
 
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);		
 
 var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  
 
 
 
 
				
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
			
				$('#type_value').val('month');
				$('#report_name1').val('Main_Page_Daily');
				$('#report_name').val('Main_Page_Daily');									
				$('#d_m_y_text').val('month');
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);
				
				$('#day_only').hide();
				$('#plant_only').show();
				$('#block_select').val("Nill");	
				$('#blcok_sel').hide();								
				check_html();
			});	
			
			
//----------------------------------------------------									
			
			
			$('#schedule_10').click(function () { 
			
			
				$('#day_only .btn').removeClass('btn_active');
				$('#day_only .btn').removeClass('btn-default');	
				$('#plant_only .btn').removeClass('btn_active');
				$('#plant_only .btn').removeClass('btn-default');					
				$('#date_btn').addClass('btn_active');
				$('#plant1_btn').addClass('btn_active');						
			
				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');				
				$("#fromdate").val(today_date);	
				//$("#todate").val(today_date);
				
				
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];

   for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value 
 
 
 
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);		
 
 var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  
 
 
				
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
			
				$('#type_value').val('day');
				$('#report_name1').val('Parameter_Daily_Report');
				$('#report_name').val('Parameter_Daily_Report');						
				$('#d_m_y_text').val('day');
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);
				
				$('#day_only').hide();
				$('#plant_only').show();
				$('#block_select').val("Nill");	
				$('#blcok_sel').hide();								
				check_html();
			});	
			
//----------------------------------------------------									
			
			
			$('#schedule_11').click(function () { 
			
			
				$('#day_only .btn').removeClass('btn_active');
				$('#day_only .btn').removeClass('btn-default');	
				$('#plant_only .btn').removeClass('btn_active');
				$('#plant_only .btn').removeClass('btn-default');					
				$('#date_btn').addClass('btn_active');
				$('#plant1_btn').addClass('btn_active');			
			
			
				$('#datetimepicker').val('');	
				$('#datetimepicker1').val('');	
				$("#fromdate").val(today_date);
				//$("#todate").val(today_date);
				
				
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];

 
   for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			
			var fdate = document.getElementById('fromdate').value 
 
 
 
 var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);		
 
 var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  
 
 
 
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
			
				$('#type_value').val('month');
				$('#report_name1').val('Plant_Daily_Generation_Report');				
				$('#report_name').val('Plant_Daily_Generation_Report');									
				$('#d_m_y_text').val('month');
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);

				$('#day_only').hide();
				$('#plant_only').show();
				$('#block_select').val("Nill");	
				$('#blcok_sel').hide();								
				check_html();
			});	
			
	$('#schedule_12').click(function () { 
		$('#day_only .btn').removeClass('btn_active');
		$('#day_only .btn').removeClass('btn-default');	
		$('#plant_only .btn').removeClass('btn_active');
		$('#plant_only .btn').removeClass('btn-default');					
		$('#date_btn').addClass('btn_active');
		$('#plant1_btn').addClass('btn_active');			
		$('#datetimepicker').val('');	
		$('#datetimepicker1').val('');	
		$("#fromdate").val(today_date);	
		var array = today_date.split("-");
		for (var i in array)
			 var tes = array[0]+'-'+array[1]+'-01';
		   for (var i in array)
			 var tes_now = array[2]+'-'+array[1]+'-'+array[0];
				$('#datetimepicker').val(tes_now);			
					$("#fromdate").val(tes_now);
					var fdate = document.getElementById('fromdate').value 
			var dt = new Date();			
			var time = dt.getHours() + "-" + dt.getMinutes();			
			$('#time_now').val(time);		
			var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
				$('#type_value').val('month');
				$('#report_name1').val('Monthly_Report');				
				$('#report_name').val('Monthly_Report');						
				$('#d_m_y_text').val('month');																		
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);
				$('#day_only').hide();
				$('#plant_only').show();
				$('#block_select').val("Nill");	
				$('#blcok_sel').hide();								
				check_html();
			});	
			
	$('#schedule_13').click(function () { 
		$('#day_only .btn').removeClass('btn_active');
		$('#day_only .btn').removeClass('btn-default');	
		$('#plant_only .btn').removeClass('btn_active');
		$('#plant_only .btn').removeClass('btn-default');					
		$('#date_btn').addClass('btn_active');
		$('#plant1_btn').addClass('btn_active');
		$('#datetimepicker').val('');	
		$('#datetimepicker1').val('');	
		$("#fromdate").val(today_date);
var array = today_date.split("-");
for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];

   for (var i in array)
     var tes_now = array[2]+'-'+array[1]+'-'+array[0];

			$('#datetimepicker').val(tes_now);			
			$("#fromdate").val(tes_now);
			var fdate = document.getElementById('fromdate').value 
			var dt = new Date();			
			var time = dt.getHours() + "-" + dt.getMinutes();			
			$('#time_now').val(time);		
			var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  
			var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  	
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
			$("#todate").val(fdate);
			$('#type_value').val('day');
			$('#report_name1').val('Block_Report');				
			$('#report_name').val('Block_Report');						
			$('#d_m_y_text').val('day');																		
			$('#block_select').val("B01");
			$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('block_select').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);
			$('#day_only').hide();
			$('#plant_only').show();
			$('#blcok_sel').show();					
			document.forms["form1"].elements["blcok_sel"].selectedIndex = 0;
			check_html();
			});	
/////////////////////3 new reports start////////////
		
	$('#schedule_14').click(function () { 
	$('#plant_only').show();
		$('#day_only .btn').removeClass('btn_active');
		$('#day_only .btn').removeClass('btn-default');	
		$('#plant_only .btn').removeClass('btn_active');
		$('#plant_only .btn').removeClass('btn-default');					
		$('#date_btn').addClass('btn_active');
		$('#plant1_btn').addClass('btn_active');			
		$('#datetimepicker').val('');	
		$('#datetimepicker1').val('');	
		$("#fromdate").val(today_date);	
		var array = today_date.split("-");
		for (var i in array)
			 var tes = array[0]+'-'+array[1]+'-01';
		   for (var i in array)
			 var tes_now = array[2]+'-'+array[1]+'-'+array[0];
				$('#datetimepicker').val(tes_now);			
					$("#fromdate").val(tes_now);
					var fdate = document.getElementById('fromdate').value 
			var dt = new Date();			
			var time = dt.getHours() + "-" + dt.getMinutes();			
			$('#time_now').val(time);		
			var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
				$('#type_value').val('month');
				$('#report_name1').val('Inverter_CUF_Report');				
				$('#report_name').val('Inverter_CUF_Report');						
				$('#d_m_y_text').val('month');																		
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);
				$('#day_only').hide();
				
				$('#block_select').val("Nill");	
				$('#blcok_sel').hide();								
				check_html();
			});	
			
			$('#schedule_15').click(function () { 
		$('#day_only .btn').removeClass('btn_active');
		$('#day_only .btn').removeClass('btn-default');	
		$('#plant_only .btn').removeClass('btn_active');
		$('#plant_only .btn').removeClass('btn-default');					
		$('#date_btn').addClass('btn_active');
		$('#plant1_btn').addClass('btn_active');			
		$('#datetimepicker').val('');	
		$('#datetimepicker1').val('');	
		$("#fromdate").val(today_date);	
		var array = today_date.split("-");
		for (var i in array)
			 var tes = array[0]+'-'+array[1]+'-01';
		   for (var i in array)
			 var tes_now = array[2]+'-'+array[1]+'-'+array[0];
				$('#datetimepicker').val(tes_now);			
					$("#fromdate").val(tes_now);
					var fdate = document.getElementById('fromdate').value 
			var dt = new Date();			
			var time = dt.getHours() + "-" + dt.getMinutes();			
			$('#time_now').val(time);		
			var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
				$('#type_value').val('month');
				$('#report_name1').val('Inverter_Comparison_Report');				
				$('#report_name').val('Inverter_Comparison_Report');						
				$('#d_m_y_text').val('month');																		
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);
				$('#day_only').hide();
				$('#plant_only').show();
				$('#block_select').val("Nill");	
				$('#blcok_sel').hide();								
				check_html();
			});	
			
			$('#schedule_16').click(function () { 
		$('#day_only .btn').removeClass('btn_active');
		$('#day_only .btn').removeClass('btn-default');	
		$('#plant_only .btn').removeClass('btn_active');
		$('#plant_only .btn').removeClass('btn-default');					
		$('#date_btn').addClass('btn_active');
		$('#plant1_btn').addClass('btn_active');			
		$('#datetimepicker').val('');	
		$('#datetimepicker1').val('');	
		$("#fromdate").val(today_date);	
		var array = today_date.split("-");
		for (var i in array)
			 var tes = array[0]+'-'+array[1]+'-01';
		   for (var i in array)
			 var tes_now = array[2]+'-'+array[1]+'-'+array[0];
				$('#datetimepicker').val(tes_now);			
					$("#fromdate").val(tes_now);
					var fdate = document.getElementById('fromdate').value 
			var dt = new Date();			
			var time = dt.getHours() + "-" + dt.getMinutes();			
			$('#time_now').val(time);		
			var today_date_test = array[2] + "-" + array[1] + "-" + array[0];			  
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
				$('#type_value').val('month');
				$('#report_name1').val('ABT_Revenue_Report');				
				$('#report_name').val('ABT_Revenue_Report');						
				$('#d_m_y_text').val('month');																		
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+today_date_test+"_"+document.getElementById('time_now').value);
				$('#day_only').hide();
				$('#plant_only').show();
				$('#block_select').val("Nill");	
				$('#blcok_sel').hide();								
				check_html();
			});	
	/////////////////////3 new reports END////////////
	
	
			
////////////////////*dynamic reports*///////////
				dynamic_report= function (file_name,type,block,interval,plant) {
					var file_name= file_name.replace('+','plus');
					//file_name = file_name;
					
					var type= type;
					var block=block;
					var interval = interval;
					var plant = plant.replace('+','plus');;
					
					//dyn_check_html();
//////////////////////*dynamic fn instead of dyn_check_html();*//////////////////////		
								
$('html, body').animate({scrollTop:$('body').position().top}, 'slow');
$('#export_option').hide();	
	$('#day_only').hide();
	$('#plant_only').hide();
	$('#table_data_div').hide();
$('#hour_btn').hide();
$('#till_btn').hide();
$('#load').show();	
$('#load').show();	
var files = $('#file_name').val();
var report_name = file_name;
var type_value = type;
var from_date = $('#fromdate').val();
var to_date = $('#from_date').val();
var block_sel = block;
var time = document.getElementById('time_now').value
var file_name = file_name+'_'+from_date+'_'+time;	
			
			$('#load').show();
			
					    $.ajax({ 
				url:"<?php echo base_url();?>report/dyn_check_html",	
											  				  
				  data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+plant+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time+'&interval='+interval,
				type: "POST",
			success:function(data){ 				
			$('#load').hide();
				if(data!='File not found')
				{
					$('#table_data').hide();
					$('#excel_hide').hide();
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
				}
				
				else
				{
					$('#excel_hide').hide();
					var files1 = $('#file_name').val();
					alert('that File does not exist - Call Reporting Package Manager');
					$('#load').hide();
				} 
$('#export_option').show();
if(report_name == 'Daily_Generation_Report')
{
	$('#day_only').hide();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
	$('#blcok_sel').hide();				
	$('#block_sel2').show();	
	$('#block_sel_select').show();	
}
}
}); 		
	
	//////////////////////*dynamic fn end*//////////////////////
					
				}

////////////////////*dynamica reports*///////////

			function blurElement(element, size){
            var filterVal = 'blur('+size+'px)';
            $(element)
              .css('filter',filterVal)
              .css('webkitFilter',filterVal)
              .css('mozFilter',filterVal)
              .css('oFilter',filterVal)
              .css('msFilter',filterVal);
        }	


	function ajaxindicatorstart(text)
	{
		if(jQuery('body').find('#resultLoading').attr('id') != 'resultLoading'){
		jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="image/load.gif"><div>'+text+'</div></div><div class="bg"></div></div>');
		}
		
		jQuery('#resultLoading').css({
			'width':'100%',
			'height':'100%',
			'position':'fixed',
			'z-index':'10000000',
			'top':'0',
			'left':'0',
			'right':'0',
			'bottom':'0',
			'margin':'auto'
		});	
		
		jQuery('#resultLoading .bg').css({
			'background':'#000000',
			'opacity':'0.7',
			'width':'100%',
			'height':'100%',
			'position':'absolute',
			'top':'0'
		});
		
		jQuery('#resultLoading>div:first').css({
			'width': '250px',
			'height':'75px',
			'text-align': 'center',
			'position': 'fixed',
			'top':'0',
			'left':'0',
			'right':'0',
			'bottom':'0',
			'margin':'auto',
			'font-size':'16px',
			'z-index':'10',
			'color':'#ffffff'
			
		});

	    jQuery('#resultLoading .bg').height('100%');
        jQuery('#resultLoading').fadeIn(300);
	    jQuery('body').css('cursor', 'wait');
	}

	function ajaxindicatorstop()
	{
	    jQuery('#resultLoading .bg').height('100%');
        jQuery('#resultLoading').fadeOut(300);
	    jQuery('body').css('cursor', 'default');
	}	
			
function check_html(){	
		
$('html, body').animate({scrollTop:$('body').position().top}, 'slow');

$('#export_option').hide();	
	$('#day_only').hide();
	$('#plant_only').hide();
	$('#table_data_div').hide();
	
	
$('#hour_btn').hide();
$('#till_btn').hide();
	
$('#load').show();	


$('#load').show();	
var files = $('#file_name').val();
var file_name = $('#file_name').val();
var report_name = $('#report_name').val();
var plant = $('#plant').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
var to_date = $('#from_date').val();
var block_sel = $('#block_select').val();
//var time = $('#time_now').val();
var time = document.getElementById('time_now').value
					
			$('#load').show();
					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",								  				  
				  data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+plant+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				type: "POST",
			success:function(data){ 
			$('#load').hide();
			
			
			
	
if(report_name == '33kV_Block_Report')
	$('#block_report_graph').click();							

else if(report_name == 'Inverter_Report')
	$('#inverter_report_graph').click();

				if(data!='File not found')
				{
					$('#table_data').hide();
					$('#excel_hide').hide();
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
				}
				
				else
				{
					$('#excel_hide').hide();
					var files1 = $('#file_name').val();
					alert('that File does not exist - Call Reporting Package Manager');
					$('#load').hide();
					
				} 
$('#export_option').show();
if(report_name == 'Inverter_CUF_Report' || report_name == 'Inverter_Comparison_Report' || report_name == 'ABT_Revenue_Report' )
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#all_btn').hide();
	$('#till_btn').hide();
	$('#hour_btn').hide();	
	$('#block_sel2').hide();	
	$('#block_sel_select').hide();		
}
else if(report_name == 'Station_Report')
{
			$('#block_sel').hide();	
			$('#block_sel2').hide();
	$('#day_only').show();
	$('#hour_btn').hide();   $('#date_btn').show();   $('#month_btn').show();   $('#year_btn').show();   $('#till_btn').hide();
	$('#plant_only').show();
	$('#all_btn').show();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
	$('#Station_Report').hide();
}	
else if(report_name == 'Import_Export')
{
			$('#block_sel').hide();	
			$('#block_sel2').hide();	
	$('#day_only').hide();
	$('#plant_only').show();
	$('#all_btn').show();		
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'ScaOneTenRep' || report_name == 'ScaBloRep')
{	
			$('#block_sel').hide();	
			$('#block_sel2').hide();	
	$('#day_only').hide();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
	$('#block_sel2').hide();	
}


else if(report_name == 'ScaBloRep')
{
	
			$('#block_sel').hide();	
			$('#block_sel2').hide();	
	$('#day_only').hide();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
	$('#block_sel2').hide();	
}

else if(report_name == 'Inverter_Report')
{
	
	$('#blcok_sel').hide();			
$('#excel_hide').show();

	
}

else if(report_name == 'Daily_Generation_Report')
{
	$('#day_only').hide();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
	$('#blcok_sel').hide();				
	$('#block_sel2').show();	
	$('#block_sel_select').show();	
}
else if(report_name == 'Inverter_Monthly_Generation_Report')
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#all_btn').hide();
	$('#till_btn').hide();
	$('#hour_btn').hide();	
	$('#block_sel2').hide();	
}
else if(report_name == 'Plant_Generation_Report' || report_name == 'Main_Page_Daily' || report_name == 'Parameter_Daily_Report' || report_name == 'Plant_Daily_Generation_Report' || report_name == 'Monthly_Report' || report_name == 'INVMonRep')
{
	$('#day_only').hide();
	$('#plant_only').show();
	$('#all_btn').show();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
	$('#block_sel2').hide();	
	$('#block_sel_select').hide();	
}
else if(report_name == 'ScaBloRep')
{
	$('#day_only').hide();
	$('#hour_btn').hide();   $('#date_btn').hide();   $('#month_btn').hide();   $('#year_btn').hide();   $('#till_btn').hide();
	
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}

else if(report_name == 'Plant_Daily_Generation_Report' || report_name == 'SMU_Generation_Report' || report_name == 'SMU_Daily_Communication_Report' || report_name == 'Inverter_Generation_Report')
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#all_btn').hide();
	$('#till_btn').hide();
	$('#hour_btn').hide();	
	$('#block_sel2').hide();	
	$('#block_sel_select').hide();		
}
else if(report_name == 'BlockSMUcommRep')
{	
	$('#day_only').hide();
	$('#plant_only').hide();
	$('#block_sel').hide();	
	//$('#block_sel2').show();	
	$('#block_sel_select').hide();	
	$('#block_sel2').hide();	
	
	$('#all_btn').hide();
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}

else if(report_name == 'BlockSMUcommRep' || report_name == 'Block_Report')
{	
		$('#block_sel_select').hide();	
			$('#block_sel').show();	
}

else if(report_name != 'BlockSMUcommRep' || report_name != 'Block_Report' || report_name != 'Inverter_Report' || report_name != 'ScaDaiGenRep')
{					
			$('#block_sel').hide();	
			$('#block_sel2').hide();
}

				}
				
				}); 
				
				//ajaxindicatorstop();
				
}		

			
        });

		
		
		

</script>
<style>
#excel_hide{
 cursor:move;
}
</style>

<script>
       $(function () {
			$('#plant2_btn').click(function () {  	
			$('#export_option').hide();
			$('#load').show();
			
			$('html, body').animate({scrollTop:$('body').position().top}, 'slow');
			
var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);							
			
				   $('#day_only .btn').removeClass('btn_active');
					$('#day_only .btn').removeClass('btn-default');		
					$('#date_btn').addClass('btn_active');
					
				var report_name = document.getElementById('report_name').value;	
					var from_date = $('#fromdate').val();
					
					var to_date = $('#todate').val();
					

if(report_name == 'ScaStaRep' || report_name == 'ScaImpExpRep')
{
	$('#day_only .btn').removeClass('btn_active');
	$('#day_only .btn').removeClass('btn-default');		
	$('#date_btn').addClass('btn_active');	
	
}					



										
					//$('#d_m_y_text').val('month');
					$('#type_value').val('Day');
					$('#d_m_y_text').val('Day');
					
					if(report_name == 'Plant_Generation_Report' || report_name == 'Parameter_Daily_Report' || report_name == 'Station_Report' || report_name == 'ScaImpExpRep')
						$('#d_m_y_text').val('Day');
					
					if(report_name == 'Inverter_Generation_Report' || report_name == 'SMU_Generation_Report' || report_name == 'SMU_Daily_Communication_Report'){
						$('#d_m_y_text').val('instantaneous');									
						$('#type_value').val('instantaneous');
					}
						
										
					
					if(report_name == 'Main_Page_Daily' || report_name == 'Monthly_Report' || report_name == 'Inverter_Monthly_Generation_Report')
					{
						$('#d_m_y_text').val('month');									
						$('#type_value').val('month');														
					}					
					
					
					var type1 = $('#d_m_y_text').val();					
				$('#file_name').val(report_name+"_"+document.getElementById('plant').value+"_"+type1+"_"+from_date+"_"+to_date);		
				
				var report_name = document.getElementById('report_name').value
				if(report_name == 'ScaInvRep')
				{
					$('#inverter_report_graph').click();
				}

else{
	var datepicker = document.getElementById('datetimepicker').value;
	var str = datepicker;
	var res = str.replace("/", "-"); 
	var res = res.replace("/", "-"); 
	var array_datepicker = res.split("-");
for (var i in array_datepicker){
	if(report_name == 'MonthRep' || report_name == 'INVMonRep')
		tes_datepicker_1 = array_datepicker[0]+'-'+array_datepicker[1]+'-01';				
		
	else	
		tes_datepicker_1 = array_datepicker[0]+'-'+array_datepicker[1]+'-'+array_datepicker[2];			
	}
	tes_datepicker_2 = tes_datepicker_1.replace("-", "/");
	tes_datepicker_2 = tes_datepicker_2.replace("-", "/");
	$('#datetimepicker1').val('');		
	var currentTime = new Date();
	var day = currentTime.getDate();
	var month = currentTime.getMonth() + 1;
	var year = currentTime.getFullYear();

  if (day < 10){
  day = "0" + day;
  }

  if (month < 10){
  month = "0" + month;
  }
  
  var today_date = year + "-" + month + "-" + day;
  
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'-'+array[1]+'-'+array[2];			
			
			$("#fromdate").val(today_date);
			//$("#todate").val(today_date);
			
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];
 
 
for (var i in array)
     var tes_m = array[0]+'/'+array[1]+'/01'; 
 
 
if(report_name != 'MonthRep' || report_name != 'INVMonRep' || report_name != 'ScaDaiGenRep' || report_name != 'ScaInvRep')				
			$("#todate").val(tes_datepicker_1); 
 
 
 
 
 
 
	//$('#datetimepicker').val(tes);	
$('#datetimepicker').val(tes_datepicker_2);				
$("#fromdate").val(tes_datepicker_1);
//$("#datetimepicker1").val(tes_datepicker_2);
if(report_name == 'MonthRep' || report_name == 'INVMonRep')	{	
		$('#datetimepicker').val(tes_datepicker_2);			
		$("#fromdate").val(tes_datepicker_2);
} 

			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);

			if(report_name == 'Station_Report')
			{ 
			$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+tes_datepicker_1+"_"+document.getElementById('time_now').value);
			}
			else{
			$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+tes_datepicker_1+"_"+document.getElementById('time_now').value);
			}
			
			$('#day_only').hide();
			$('#plant_only').hide();
			$('#block_select').val("Nill");
			$('#blcok_sel').hide();		
			
			//var block_sel = document.getElementById('blcok_sel').value
			$('#blcok_sel').val('Nill');
			var block_sel = document.getElementById('blcok_sel').value
			
			var file_name = document.getElementById('file_name').value;

var file_name = $('#file_name').val();
var report_name = $('#report_name').val();
var plant = $('#plant').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
$('#datetimepicker').val(from_date);
var to_date = $('#from_date').val();
var block_sel = $('#block_select').val();
//var time = $('#time_now').val();
var time = document.getElementById('time_now').value

					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",	
				//data: 'file_name='+file_name,	
				//data: 'file_name='+file_name+'&block_sel='+block_sel,				
				data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+plant+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				type: "POST",
			success:function(data){ 						
			$('#load').hide();
				

				
				if(data!='File not found')
				{
					//alert(files);
					$('#table_data').hide();
					$('#excel_hide').hide();
					//alert(data);
					$('#load').hide();
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
						//$('#export_option').show();
			//$('.report-pre').show();
			//$('.report-pre').empty().append(data); 
			
				}
				
				else
				{
					$('#excel_hide').hide();
					//alert(files);
					var files1 = $('#file_name').val();
					//alert(files1);
					alert('that File does not exist - Call Reporting Package Manager');
					$('#load').hide();
					
				} 
$('#export_option').show();
if(report_name == 'Station_Report')
{
	$('#day_only').show();
	$('#hour_btn').hide();   $('#date_btn').show();   $('#month_btn').show();   $('#year_btn').show();   $('#till_btn').hide();
	$('#plant_only').show();
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}	
else if(report_name == 'Import_Export')
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'ScaOneTenRep' || report_name == 'ScaBloRep')
{
	$('#day_only').hide();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'ScaInvRep')
{
	$('#day_only').show();
	$('#hour_btn').show();   $('#date_btn').show();   $('#month_btn').show();   $('#year_btn').show();   $('#till_btn').show();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();
	$('#blcok_sel').show();	
$('#excel_hide').show();
$('#table_data').show();
	
}
else if(report_name == 'ScaDaiGenRep')
{
	$('#day_only').hide();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'Plant_Generation_Report' || report_name == 'Main_Page_Daily' || report_name == 'Parameter_Daily_Report' || report_name == 'Daily_Generation_Report' || report_name == 'Monthly_Report' || report_name == 'Inverter_Monthly_Generation_Report')
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'ScaBloRep')
{
	$('#day_only').hide();
	$('#hour_btn').hide();   $('#date_btn').hide();   $('#month_btn').hide();   $('#year_btn').hide();   $('#till_btn').hide();
	
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}

else if(report_name == 'Plant_Daily_Generation_Report' || report_name == 'SMU_Generation_Report' || report_name == 'SMU_Daily_Communication_Report' || report_name == 'MainPgDaily')
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}

else if(report_name == 'Inverter_Generation_Report')
{
		$('#day_only').hide();
	$('#plant_only').show();	
	$('#all_btn').hide();
	$('#till_btn').hide();
	$('#hour_btn').hide();	
	$('#block_sel2').hide();	
	$('#block_sel_select').hide();		
}
  else if(report_name == 'Inverter_CUF_Report' || report_name == 'Inverter_Comparison_Report' || report_name == 'ABT_Revenue_Report' )
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#all_btn').hide();
	$('#till_btn').hide();
	$('#hour_btn').hide();	
	$('#block_sel2').hide();	
	$('#block_sel_select').hide();		
}
		
  				
				
				}
				
				}); 			
}

			});	
			

//-------------------------------------------------------------------------------------------------------------------			
			
			$('#plant1_btn').click(function () {  	
			$('#export_option').hide();
			$('#load').show();
			
			$('html, body').animate({scrollTop:$('body').position().top}, 'slow');
			
var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);										
			
					$('#day_only .btn').removeClass('btn_active');
					$('#day_only .btn').removeClass('btn-default');		
					$('#date_btn').addClass('btn_active');					
					$('#type_value').val('Day');
					$('#d_m_y_text').val('Day');
					
				var type_1 = $('#type_value').val('Day');
				var type_2 = $('#d_m_y_text').val('Day');		

var from_date = $('#fromdate').val();
var to_date = $('#todate').val();
				

				
				var report_name = document.getElementById('report_name').value;
																				
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('todate').value);	

					
					
					
if(report_name == 'ScaStaRep' || report_name == 'ScaImpExpRep')
{
	$('#day_only .btn').removeClass('btn_active');
	$('#day_only .btn').removeClass('btn-default');		
	$('#date_btn').addClass('btn_active');	
	
}	
					$('#d_m_y_text').val('Month');
					
					if(report_name == 'Plant_Generation_Report' || report_name == 'Parameter_Daily_Report' || report_name == 'ScaImpExpRep' || report_name == 'Station_Report')
						$('#d_m_y_text').val('Day');	

					if(report_name == 'Inverter_Generation_Report' || report_name == 'SMU_Daily_Communication_Report' || report_name == 'SMU_Generation_Report'){
						$('#d_m_y_text').val('instantaneous');									
						$('#type_value').val('instantaneous');									
					}
						
					if(report_name == 'Main_Page_Daily' || report_name == 'Monthly_Report' || report_name == 'Inverter_Monthly_Generation_Report')
					{
						$('#d_m_y_text').val('month');									
						$('#type_value').val('month');														
					}
				
				if(report_name == 'ScaInvRep'){
					 $('#inverter_report_graph').click();   
				}

else{
	
	
	var datepicker = document.getElementById('datetimepicker').value;
	
	var str = datepicker;
	var res = str.replace("/", "-"); 
	var res = res.replace("/", "-"); 	
	
	var array_datepicker = res.split("-");
	

for (var i in array_datepicker){
	if(report_name == 'MonthRep' || report_name == 'INVMonRep')
		tes_datepicker_1 = array_datepicker[0]+'-'+array_datepicker[1]+'-01';			
	else	
		tes_datepicker_1 = array_datepicker[0]+'-'+array_datepicker[1]+'-'+array_datepicker[2];			
	}
	

	
	tes_datepicker_2 = tes_datepicker_1.replace("-", "/"); 
	tes_datepicker_2 = tes_datepicker_2.replace("-", "/"); 
	
	

	
			//$('#datetimepicker').val('');	
			$('#datetimepicker1').val('');	
			//$('#excel_File_name').val("example3.xls");
			
			
	  var currentTime = new Date();
  var day = currentTime.getDate();
  var month = currentTime.getMonth() + 1;
  var year = currentTime.getFullYear();

  if (day < 10){
  day = "0" + day;
  }

  if (month < 10){
  month = "0" + month;
  }
  
  var today_date = year + "-" + month + "-" + day;
			
			$("#fromdate").val(today_date);
			//$("#todate").val(today_date);
			
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];
 
 
for (var i in array)
     var tes_m = array[0]+'/'+array[1]+'/01';
 

	
 
 if(report_name != 'MonthRep' || report_name != 'INVMonRep' || report_name != 'ScaDaiGenRep' || report_name != 'ScaInvRep')	
 {	 
			$("#todate").val(tes_datepicker_1);
			$("#fromdate").val(tes_datepicker_1);			
 }
	//$('#datetimepicker').val(tes);	
$('#datetimepicker').val(tes_datepicker_2);				
$("#fromdate").val(tes_datepicker_1);
//$("#datetimepicker1").val(tes_datepicker_2);
if(report_name == 'MonthRep' || report_name == 'INVMonRep')	{	
		$('#datetimepicker').val(tes_datepicker_2);			
		$("#fromdate").val(tes_datepicker_2);
}
//$('#datetimepicker').val(tes_m);			
	
			
			var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);

			if(report_name == 'Station_Report')
			{ 
			$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+tes_datepicker_1+"_"+document.getElementById('time_now').value);
			}
			else{
			$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+tes_datepicker_1+"_"+document.getElementById('time_now').value);
			}
			
			$('#day_only').hide();
			$('#plant_only').hide();
			$('#block_select').val("Nill");
			$('#blcok_sel').hide();		
			
			//var block_sel = document.getElementById('blcok_sel').value
			$('#blcok_sel').val('Nill');
			var block_sel = document.getElementById('blcok_sel').value
			
			var file_name = document.getElementById('file_name').value;

var file_name = $('#file_name').val();
var report_name = $('#report_name').val();
var plant = $('#plant').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
$('#datetimepicker').val(from_date);
var to_date = $('#from_date').val();
var block_sel = $('#block_select').val();
//var time = $('#time_now').val();
var time = document.getElementById('time_now').value									
			

					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",	
				//data: 'file_name='+file_name,	
				//data: 'file_name='+file_name+'&block_sel='+block_sel,				
				data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+plant+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				type: "POST",
			success:function(data){ 						
			$('#load').hide();
				

				
				if(data!='File not found')
				{
					//alert(files);
					$('#table_data').hide();
					$('#excel_hide').hide();
					//alert(data);
					$('#load').hide();
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
			
				}
				
				else
				{
					$('#excel_hide').hide();
					//alert(files);
					var files1 = $('#file_name').val();
					//alert(files1);
					alert('that File does not exist - Call Reporting Package Manager');
					$('#load').hide();
					
				} 

$('#export_option').show();
if(report_name == 'Station_Report')
{
	$('#day_only').show();
	$('#hour_btn').hide();   $('#date_btn').show();   $('#month_btn').show();   $('#year_btn').show();   $('#till_btn').hide();
	$('#plant_only').show();
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}	
else if(report_name == 'Import_Export')
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'ScaOneTenRep' || report_name == 'ScaBloRep')
{
	$('#day_only').hide();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'ScaInvRep')
{
	$('#day_only').show();
	$('#hour_btn').show();   $('#date_btn').show();   $('#month_btn').show();   $('#year_btn').show();   $('#till_btn').show();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();
	$('#blcok_sel').show();	
$('#excel_hide').show();
$('#table_data').show();
	
}
else if(report_name == 'ScaDaiGenRep')
{
	$('#day_only').hide();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'Plant_Generation_Report' || report_name == 'Main_Page_Daily' || report_name == 'Parameter_Daily_Report' || report_name == 'Daily_Generation_Report' || report_name == 'Monthly_Report' || report_name == 'Inverter_Monthly_Generation_Report')
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'ScaBloRep')
{
	$('#day_only').hide();
	$('#hour_btn').hide();   $('#date_btn').hide();   $('#month_btn').hide();   $('#year_btn').hide();   $('#till_btn').hide();
	
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}

else if(report_name == 'Plant_Daily_Generation_Report' || report_name == 'SMU_Generation_Report' || report_name == 'SMU_Daily_Communication_Report' || report_name == 'MainPgDaily')
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'Inverter_Generation_Report')
{
		$('#day_only').hide();
	$('#plant_only').show();	
	$('#all_btn').hide();
	$('#till_btn').hide();
	$('#hour_btn').hide();	
	$('#block_sel2').hide();	
	$('#block_sel_select').hide();		
}
		
  				
				
				}
				
				}); 				
	
}				
				
				
				
				
				
				
				
				
				
				
				
			});	
			
			
			$('#all_btn').click(function () {  				
			$('#export_option').hide();
			$('#load').show();
			
			$('html, body').animate({scrollTop:$('body').position().top}, 'slow');
			
var dt = new Date();			
var time = dt.getHours() + "-" + dt.getMinutes();			

$('#time_now').val(time);										
			
					$('#day_only .btn').removeClass('btn_active');
					$('#day_only .btn').removeClass('btn-default');		
					$('#date_btn').addClass('btn_active');	
					$('#type_value').val('Day');
					$('#d_m_y_text').val('Day');
					
				$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+document.getElementById('fromdate').value+"_"+document.getElementById('todate').value);	
				var report_name = document.getElementById('report_name').value
								

if(report_name == 'ScaStaRep' || report_name == 'ScaImpExpRep')
{
	$('#day_only .btn').removeClass('btn_active');
	$('#day_only .btn').removeClass('btn-default');		
	$('#date_btn').addClass('btn_active');	
	
}					
								
					$('#d_m_y_text').val('month');
										
					if(report_name == 'Plant_Generation_Report' || report_name == 'Parameter_Daily_Report' || report_name == 'Station_Report' || report_name == 'ScaImpExpRep')
						$('#d_m_y_text').val('Day');				
					
					if(report_name == 'IGRRep')
						$('#d_m_y_text').val('instantaneous');				
				
				if(report_name == 'ScaInvRep'){
					 $('#inverter_report_graph').click();   
				}	

					if(report_name == 'Main_Page_Daily' || report_name == 'Monthly_Report')
					{
						$('#d_m_y_text').val('month');									
						$('#type_value').val('month');														
					}				
				
				
				
				if(report_name == 'ScaInvRep'){
					$('#inverter_report_graph').click(); 
				}
				 
				 
else{
	


	var datepicker = document.getElementById('datetimepicker').value;
	
	
	var str = datepicker;
	var res = str.replace("/", "-"); 
	var res = res.replace("/", "-"); 


	
	var array_datepicker = res.split("-");
	

for (var i in array_datepicker){
	if(report_name == 'MonthRep')
		tes_datepicker_1 = array_datepicker[0]+'-'+array_datepicker[1]+'-01';			
	else	
		tes_datepicker_1 = array_datepicker[0]+'-'+array_datepicker[1]+'-'+array_datepicker[2];			
	}


	
	
	tes_datepicker_2 = tes_datepicker_1.replace("-", "/"); ;
	tes_datepicker_2 = tes_datepicker_2.replace("-", "/"); ;
	
			//$('#datetimepicker').val('');	
			$('#datetimepicker1').val('');	

	
	  var currentTime = new Date();
  var day = currentTime.getDate();
  var month = currentTime.getMonth() + 1;
  var year = currentTime.getFullYear();

  if (day < 10){
  day = "0" + day;
  }

  if (month < 10){
  month = "0" + month;
  }
  
  var today_date = year + "-" + month + "-" + day;
  
var array = today_date.split("-");

for (var i in array)
     var tes = array[0]+'/'+array[1]+'/'+array[2];
 
 
for (var i in array)
     var tes_m = array[0]+'/'+array[1]+'/01';
 /*
	//$('#datetimepicker').val(tes);	
	$('#datetimepicker').val(tes_datepicker_2);			
	*/
	
if(report_name != 'MonthRep' || report_name != 'INVMonRep' || report_name != 'ScaDaiGenRep' || report_name != 'ScaInvRep')				
			$("#todate").val(tes_datepicker_1);

		


	//$('#datetimepicker').val(tes);	
$('#datetimepicker').val(tes_datepicker_2);				
$("#fromdate").val(tes_datepicker_1);
//$("#datetimepicker1").val(tes_datepicker_2);
if(report_name == 'MonthRep' || report_name == 'INVMonRep')	{	
		$('#datetimepicker').val(tes_datepicker_2);			
		$("#fromdate").val(tes_datepicker_2);
}		
		var fdate = document.getElementById('fromdate').value
			var tdate = document.getElementById('todate').value
			if(tdate == '')
				$("#todate").val(fdate);
			
			
			if(report_name == 'Station_Report')
			{ 
			$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+document.getElementById('d_m_y_text').value+"_"+tes_datepicker_1+"_"+document.getElementById('time_now').value);
			}
			else{
			$('#file_name').val(document.getElementById('report_name').value+"_"+document.getElementById('plant').value+"_"+tes_datepicker_1+"_"+document.getElementById('time_now').value);
			}
			$('#day_only').hide();
			$('#plant_only').hide();
			$('#block_select').val("Nill");
			$('#blcok_sel').hide();		
			
			//var block_sel = document.getElementById('blcok_sel').value
			$('#blcok_sel').val('Nill');
			var block_sel = document.getElementById('blcok_sel').value
			
			var file_name = document.getElementById('file_name').value;
			//alert(file_name);
			
			
			
var file_name = $('#file_name').val();
var report_name = $('#report_name').val();
var plant = $('#plant').val();
var type_value = $('#type_value').val();
var from_date = $('#fromdate').val();
$('#datetimepicker').val(from_date);
var to_date = $('#from_date').val();
var block_sel = $('#block_select').val();
//var time = $('#time_now').val();
var time = document.getElementById('time_now').value									
			

				
				
			
			
			
			



					    $.ajax({ 
				url:"<?php echo base_url();?>check_html",	
				//data: 'file_name='+file_name,	
				//data: 'file_name='+file_name+'&block_sel='+block_sel,				
				data: 'file_name='+file_name+'&block_sel='+block_sel+'&plant='+plant+'&report_name='+report_name+'&report_type='+type_value+'&from_date='+from_date+'&time='+time,
				
				type: "POST",
			success:function(data){ 						
			$('#load').hide();
				

				
				if(data!='File not found')
				{
					//alert(files);
					$('#table_data').hide();
					$('#excel_hide').hide();
					//alert(data);
					$('#load').hide();
					$('#excel_hide').show();
					$('#excel_hide').empty().append(data); 
						//$('#export_option').show();
			//$('.report-pre').show();
			//$('.report-pre').empty().append(data); 
			
				}
				
				else
				{
					$('#excel_hide').hide();
					//alert(files);
					var files1 = $('#file_name').val();
					//alert(files1);
					alert('that File does not exist - Call Reporting Package Manager');
					$('#load').hide();
					
				} 
				/*
				blurElement(".right-side", 0); 
				blurElement("#cssmenu", 0);
					blurElement("#from_datepick", 0);
					blurElement("#to_datepick", 0);
					blurElement("#search_datepick", 0);	
				*/
				
$('#export_option').show();
if(report_name == 'Station_Report')
{
	$('#day_only').show();
	$('#hour_btn').hide();   $('#date_btn').show();   $('#month_btn').show();   $('#year_btn').show();   $('#till_btn').hide();
	$('#plant_only').show();
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}	
else if(report_name == 'Import_Export')
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'ScaOneTenRep' || report_name == 'ScaBloRep')
{
	$('#day_only').hide();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'ScaInvRep')
{
	$('#day_only').show();
	$('#hour_btn').show();   $('#date_btn').show();   $('#month_btn').show();   $('#year_btn').show();   $('#till_btn').show();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();
	$('#blcok_sel').show();	
$('#excel_hide').show();
$('#table_data').show();
	
}
else if(report_name == 'ScaDaiGenRep')
{
	$('#day_only').hide();
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'Plant_Daily_Generation_Report' || report_name == 'Main_Page_Daily' || report_name == 'Parameter_Daily_Report' || report_name == 'Daily_Generation_Report' || report_name == 'Monthly_Report' || report_name == 'INVMonRep' || report_name == 'Plant_Generation_Report')
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}
else if(report_name == 'ScaBloRep')
{
	$('#day_only').hide();
	$('#hour_btn').hide();   $('#date_btn').hide();   $('#month_btn').hide();   $('#year_btn').hide();   $('#till_btn').hide();
	
	$('#plant_only').hide();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}

else if(report_name == 'IGRRep' || report_name == 'SMUGenRep' || report_name == 'SMUCommRep' || report_name == 'MainPgDaily')
{
	$('#day_only').hide();
	$('#plant_only').show();	
	$('#till_btn').hide();
	$('#hour_btn').hide();	
}


		
  				
				
				}
				
				}); 			
			

					
}
					
				
				
				
				
				
				
				
				
				
			});	
				});	
</script>



			<script>

$(function () { 
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

	$('#datetimepicker_zip').datetimepicker({
			 dateFormat: 'yy-mm-dd',
			 //minDate:'-1971/01/01',
			 maxDate:'0',
			 defaultTime: '23:00'
});



$("#datetimepicker")
    .datetimepicker({
      dateFormat: "yy-mm-dd",
      onSelect: function(dateText) {
        $(this).change(); 		
      }
    })
    .change(function() {
		
		var fromdate = this.value;
		fromdate = fromdate.split("/").reverse().join("-");		
		fromdate = fromdate.split('-');
		fromdate = fromdate[2] + '-' + fromdate[1] + '-' + fromdate[0];
		$('#fromdate').val(fromdate);		
    });
});

</script>
			
			<script type="text/javascript">
			$(function() {  // Document Ready function START  
			var base_url = "<?php echo base_url(); ?>";$(".ajax").colorbox(
                       {
                        onClosed:function(){parent.location.reload();
                       }
                                    }
                       );	   

});  // Document Ready function END 


</script>
          
	<?php } ?>
	
	
	<?php if($this->uri->segment(1)== 'cron'){?>

	

<style>
.bootstrap-timepicker{position:relative}.bootstrap-timepicker.pull-right .bootstrap-timepicker-widget.dropdown-menu{left:auto;right:0}.bootstrap-timepicker.pull-right .bootstrap-timepicker-widget.dropdown-menu:before{left:auto;right:12px}.bootstrap-timepicker.pull-right .bootstrap-timepicker-widget.dropdown-menu:after{left:auto;right:13px}.bootstrap-timepicker .add-on{cursor:pointer}.bootstrap-timepicker .add-on i{display:inline-block;width:16px;height:16px}.bootstrap-timepicker-widget.dropdown-menu{padding:2px 3px 2px 2px}.bootstrap-timepicker-widget.dropdown-menu.open{display:inline-block}.bootstrap-timepicker-widget.dropdown-menu:before{border-bottom:7px solid rgba(0,0,0,0.2);border-left:7px solid transparent;border-right:7px solid transparent;content:"";display:inline-block;left:9px;position:absolute;top:-7px}.bootstrap-timepicker-widget.dropdown-menu:after{border-bottom:6px solid #fff;border-left:6px solid transparent;border-right:6px solid transparent;content:"";display:inline-block;left:10px;position:absolute;top:-6px}.bootstrap-timepicker-widget.timepicker-orient-left:before{left:6px}.bootstrap-timepicker-widget.timepicker-orient-left:after{left:7px}.bootstrap-timepicker-widget.timepicker-orient-right:before{right:6px}.bootstrap-timepicker-widget.timepicker-orient-right:after{right:7px}.bootstrap-timepicker-widget.timepicker-orient-top:before{top:-7px}.bootstrap-timepicker-widget.timepicker-orient-top:after{top:-6px}.bootstrap-timepicker-widget.timepicker-orient-bottom:before{bottom:-7px;border-bottom:0;border-top:7px solid #999}.bootstrap-timepicker-widget.timepicker-orient-bottom:after{bottom:-6px;border-bottom:0;border-top:6px solid #fff}.bootstrap-timepicker-widget a.btn,.bootstrap-timepicker-widget input{border-radius:4px}.bootstrap-timepicker-widget table{width:100%;margin:0}.bootstrap-timepicker-widget table td{text-align:center;height:30px;margin:0;padding:2px}.bootstrap-timepicker-widget table td:not(.separator){min-width:30px}.bootstrap-timepicker-widget table td span{width:100%}.bootstrap-timepicker-widget table td a{border:1px transparent solid;width:100%;display:inline-block;margin:0;padding:8px 0;outline:0;color:#333}.bootstrap-timepicker-widget table td a:hover{text-decoration:none;background-color:#eee;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;border-color:#ddd}.bootstrap-timepicker-widget table td a i{margin-top:2px;font-size:18px}.bootstrap-timepicker-widget table td input{width:25px;margin:0;text-align:center}.bootstrap-timepicker-widget .modal-content{padding:4px}@media(min-width:767px){.bootstrap-timepicker-widget.modal{width:200px;margin-left:-100px}}@media(max-width:767px){.bootstrap-timepicker{width:100%}.bootstrap-timepicker .dropdown-menu{width:100%}}
</style>

				<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/left_menu_styles_cron.css';?>">
			<script src="<?php echo base_url().'js/left_menu_script_cron.js';?>"></script>

			<script src="<?php echo base_url().'js/bootstrap-timepicker.js';?>"></script>
			
				<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/jquery-clockpicker.min.css';?>">
			<script src="<?php echo base_url().'js/jquery-clockpicker.min.js';?>"></script>		
			
			
<style>
.btn_active {
    background-color:#455486;
	color:white;
	
    <!--color: red;-->
}

</style>
					
<script>
function page_print() {
    window.print();
}


   $(document).ready(function() { 

   
$('#report').show();
	   
		$('#plant_only .btn').removeClass('btn_active');
		$('#plant_only .btn').removeClass('btn-default');
	   
	   $('#plant1_btn').addClass('btn_active');	 	   









$('ul #template ul li').on('click',function(){ 
	$('li').children('a').css('background','');
	$(this).children('a').css('background','#059279');
		//$('li').children('a').css('border-right','none');
		//$('li').children('a').css('color','#DDD');
	//$(this).children('a').css('background','#FFF');
	//$(this).children('a').css('color','#000');		
	//$(this).children('a').css('border-right','4px solid red');	
	$("td:last-child").css({border:"none"})

}); 


$('ul #schedule ul li').on('click',function(){ 
	$('li').children('a').css('background','');
	$(this).children('a').css('background','#059279');
		//$('li').children('a').css('color','#DDD');
		//$('li').children('a').css('border-right','none');
			//$(this).children('a').css('background','#FFF');
	//$(this).children('a').css('color','#000');
	//$(this).children('a').css('border-right','4px solid red');
//border-right: 1px solid red;
}); 

	 $('#abt_datepicker').datetimepicker({
			 dateFormat: 'yy-mm-dd',
			 maxDate:'0',
			 defaultTime: '00:00'
});  
} );



</script>
		


		<script>  
		$(document).ready(function() { 
		$('#cssmenu').hide();
		$('#cssmenu_cron').show();
		$('#datetimepicker').hide();
		$('#search_icon').hide();
		$('.timepicker').timepicker();	

$('#plant_only').find(".btn").click(function () {  
$('#plant_only .btn').removeClass('btn_active');
$(this).removeClass('btn-default');
$(this).addClass('btn_active');
}); 
		
		});
		</script>
	

<script>



$(document).ready(function() {
	
		$('#schedule_cron_view').hide();		
		$('#schedule_template_view').hide();	
		$('#scada_template_view').show();
	
$('#scada_template').click(function () {
		$('#schedule_cron_view').hide();		
		$('#schedule_template_view').hide();	
		$('#scada_template_view').show();		
});

$('#schedule_template').click(function () {
		$('#schedule_cron_view').hide();		
		$('#schedule_template_view').show();
		$('#scada_template_view').hide();	
});

$('#schedule_cron').click(function () {
	$('#schedule_cron_view').show();
	$('#schedule_template_view').hide();		
	$('#scada_template_view').hide();		
});

$('#scada_cron').click(function () {
		
});

});

//-----------------------------------------------------------------------------------------------------------	
	
	
$("#ods_upload1").submit(function() {	

//userfile

		 $.ajax({ 
				url:"<?php echo base_url();?>upload",	
				data: 'file_name='+file_name,				
				
				type: "POST",
			success:function(data){ 						
			
				
				if(data == 'pass')
				{

				}
				
				else
				{
					alert('that File does not exist - Call Reporting Package Manager');
					
				} 
					$('#load').hide();
				}
				
				}); 
	
	
});					
				
		
</script>

<script>
$(document).ready(function() {
$('INPUT[type="file"]').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'ods':
            $('#uploadButton').attr('disabled', false);
            break;
        default:
            alert('This is not an allowed file type.');
            this.value = '';
    }
});
});
</script>
	
		
	<?php }?>	
	
	</head>
    <body class="skin-blue  pace-done">
		<div class="pace  pace-inactive">
			<div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
				<div class="pace-progress-inner"></div>
			</div>
			<div class="pace-activity"></div>
		</div>
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url(); ?>" class="logo"><img src="<?php echo base_url(); ?>image/iplon_logo.png" title="iPLON" border="0" width="120" height="45"></a>
            <?php if($this->uri->segment(1) ==''){?> <!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top" role="navigation" >
              
                                        
				<div class="navbar-right" >
				<ul class="nav navbar-nav">
					<li class="dropdown messages-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Contact Us</a>
				<ul class="dropdown-menu">
					<li class="header">
					<img src="<?php echo base_url();?>image/India-Flag.png" class="img-ircle" alt="Iplon India" width="20%"/>
						<!--<img src="<?php //echo base_url();?>image/india_flag.png" class="img-circe" alt="Iplon India" width="20%"/>-->
						&nbsp;&nbsp;&nbsp;iPLON INDIA pvt ltd<br>

						26/80, 5th street Luz Avenue, Mylapore<br>
						Chennai<br>
						India<br>
					Tel.: +91 9884970611<br>					
						E-Mail: info@iplon.in 
					</li>
				<li class="header">
					<img src="<?php echo base_url();?>image/germany_flag.png" class="img-ircle" alt="Iplon India" width="20%"/>&nbsp;&nbsp;&nbsp;iPLON GmbH<br>
					Karl-Kurz-Str. 36<br>
					D-74523 Schwäbisch-Hall Hessental<br>
					Germany<br>
					Tel.: +49-(0)791-93050-0<br>
					Fax: +49-(0)791-93050-50<br>
					E-Mail: info@iplon.de<br>
				</li>
				<li>
				

				</div><!-- end message -->
				
				</div>
	</nav>
			<?php }?>
        
       
			<?php if($this->uri->segment(1) !=''){
			 include_once("topnavigation.php");
			}?>
