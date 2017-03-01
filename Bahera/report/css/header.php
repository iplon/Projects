<?php ob_start();?>
<!DOCTYPE html>
		<head>		
		<title>iPLON</title>
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
		<script type="text/javascript" src="<?php echo base_url().'/js/js_pdf.js'?>"></script>
		<script src="<?php //echo base_url().'js/jquery-ui-1.10.3.min.js';?>" type="text/javascript"></script>
		<script src="<?php //echo base_url().'js/jquery.validate.js';?>"></script>  
		<script src="<?php //echo base_url().'js/jquery.colorbox.js';?>" type="text/javascript"></script>
		<script src="<?php echo base_url().'js/bootstrap.min.js';?>" type="text/javascript"></script>
		<script src="<?php //echo base_url().'js/jquery.sparkline.min.js';?>" type="text/javascript"></script>
		<script src="<?php echo base_url().'js/AdminLTE/app.js';?>" type="text/javascript"></script>
		<script src="<?php //echo base_url().'js/plugins/sparkline/jquery.sparkline.min.js';?>" type="text/javascript"></script>
		<script src="<?php //echo base_url().'js/exporting.js';?>"></script>
		<script src="<?php //echo base_url().'js/highcharts/highcharts.js';?>"></script>
		<script src="<?php //echo base_url().'js/highcharts/highcharts-more.js';?>"></script>
		
		

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


<script>
function page_print() {
    window.print();
}

</script>	


   
   <script>
   $(document).ready(function() { 
	   $('#load_plot').hide();
	   $('#excel_hide').hide();
	   	    
	   
	   
	   $('#day_only .btn').removeClass('btn_active');
		$('#day_only .btn').removeClass('btn-default');
		$('#plant_only .btn').removeClass('btn_active');
		$('#plant_only .btn').removeClass('btn-default');
	   
	   $('#ttpet_btn').addClass('btn_active');
	   $('#date_btn').addClass('btn_active');
	   
		var currentDate = ("0" + (new Date).getDate()).slice(-2)        
		$('#day_m_y').val(currentDate);		
		
		
		var currentMonth = ("0" + ((new Date).getMonth() + 1)).slice(-2)		        
		$('#d_month_y').val(currentMonth);
		
		
		var currentYear = (new Date).getFullYear();        
		$('#d_m_year').val(currentYear);
		
		
		$('#d_m_y_text').val("day");	


		
    //$('#example').DataTable();
} );








$(document).ready(function() {
$('#date_btn').click(function () {
	//$('#load_plot').show();
	$('#d_m_y_text').val("day");	

	//jQuery('#process').click();	
});	

$('#month_btn').click(function () {
	//$('#load_plot').show();
	$('#d_m_y_text').val("Month");	
	
});	

$('#year_btn').click(function () {
	//$('#load_plot').show();
	$('#d_m_y_text').val("year");		

});	
});





       $(function () {


		 $('#process').click(function () { 
				$('#load_plot').show();
					    $.ajax({ 
				url:"<?php echo base_url();?>"+document.getElementById('report_name').value,			
				data: {type: document.getElementById('d_m_y_text').value,
				day: document.getElementById('day_m_y').value,
				month: document.getElementById('d_month_y').value,
				year: document.getElementById('d_m_year').value},		
        type: "POST",
        success:function(data){ 		
		//alert(data);
		$('#option').show();
		$('#table_data').show();
			$('#table_data').empty().append(data); 	
			$('#table_tbody_fill').DataTable();
			
			
			
			$('#load_plot').hide();			
        }             
        });		   
		}); 
		

		   
            $('#scada_1').click(function () {  	$('#excel_hide').hide();			
				$('#plant_only').show();
				$('#day_only').show();
				$('#hour_btn').hide();					
				$('#report_name').val('Station_Report');				
				//jQuery('#process').click();	
				alert('Building Python code');
                return false;
            });
			
			$('#scada_2').click(function () {                
				$('#day_only').hide();
				$('#plant_only').show();
				$('#hour_btn').hide();
				$('#report_name').val('Import_Export');
				alert('Building Python code');
                return false;
            });
			
			$('#scada_3').click(function () {				
				$('#day_only').show();
				$('#hour_btn').show();
				$('#d_m_y_text').val("Hourly");
				$('#report_name').val('one_ten_kv_Feeder');
				alert('Building Python code');
				//jQuery('#process').click();					
                return false;
            });
						
			$('#scada_4').click(function () {                				
				$('#day_only').show();	
				$('#hour_btn').hide();
				$('#report_name').val('Block_Report');
				alert('Building Python code');
                return false;
            });
	
			$('#scada_5').click(function () {                				
				$('#day_only').show();	
				$('#hour_btn').hide();
				$('#report_name').val('Inverter_Report');
				alert('Building Python code');
				//jQuery('#process').click();
                return false;
            });
			
			$('#scada_6').click(function () {                				
				$('#day_only').hide();	
				$('#plant_only').hide();
				$('#hour_btn').hide();
				$('#d_m_y_text').val("Day");
				$('#report_name').val('Daily_Generation_Report');
				//jQuery('#process').click();	
				alert('Building Python code');
                return false;
            });
			

		
		
		
		
function schedule_process(){	
							$('#table_data').hide();
					    $.ajax({ 
				url:"<?php echo base_url();?>check_avaiable",			
				data: {file_name: document.getElementById('excel_File_name').value},		
				type: "POST",
			success:function(data){ 						
				
				if(data=='Found')
				{
					$('#table_data').hide();
					$('#excel_hide').hide();
					//alert('Found');
					$('#load_plot').show();
					$.ajax({ 
					url:"<?php echo base_url();?>test",			
					data: {file_name: document.getElementById('excel_File_name').value},		
					type: "POST",
					success:function(data){ 
				$('#option').show();					
					$('#excel_hide').show();
					$('.report-pre').empty().append(data); 							
					$('#excel_hidden').empty().append(data); 							
					$('#load_plot').hide();			
					}             
				});
					
				}
				
				else
				{
					$('#excel_hide').hide();
					alert('that File does not exist - Call Reporting Package Manager');
				}
					
				
				//$('#load_plot').hide();	

				
				
				}             
				});
}
			
			
			$('#schedule_1').click(function () {  	
			$('#excel_File_name').val("example3.xls");
				schedule_process();
			});
			
			$('#schedule_2').click(function () {  	
			$('#excel_File_name').val("example2.xls");
				schedule_process();
			});
			
			$('#schedule_3').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});
			
			$('#schedule_4').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});
			
			$('#schedule_5').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});
			
			$('#schedule_6').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});	

			$('#schedule_7').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});	

			$('#schedule_8').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});				
		
			$('#schedule_9').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});	
			
			$('#schedule_10').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});	
			
			$('#schedule_11').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});	
			
			$('#schedule_12').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});	
			$('#schedule_13').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});	
			$('#schedule_14').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});
			$('#schedule_15').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});
			$('#schedule_16').click(function () {  	
			$('#excel_File_name').val("ex.xls");
				schedule_process();
			});
		
		
		
		
			
        });

		
		
		

</script>



<script>
       $(function () {
			$('#ttpet_btn').click(function () {  	
				   $('#day_only .btn').removeClass('btn_active');
					$('#day_only .btn').removeClass('btn-default');		
					$('#date_btn').addClass('btn_active');
			});	
			
			$('#musiri_btn').click(function () {  	
					$('#day_only .btn').removeClass('btn_active');
					$('#day_only .btn').removeClass('btn-default');		
					$('#date_btn').addClass('btn_active');
			});	
			
			$('#all_btn').click(function () {  				
					$('#day_only .btn').removeClass('btn_active');
					$('#day_only .btn').removeClass('btn-default');		
					$('#date_btn').addClass('btn_active');
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


$("#datetimepicker")
    .datetimepicker({
      dateFormat: "yy-mm-dd",
      onSelect: function(dateText) {
        $(this).change();
      }
    })
    .change(function() {
		alert('date_pass to python');
      //window.location.href = "report?date=" + this.value;
    });

});

</script>


	<script>
$(document).ready(function() {

//$('li').addClass('load_left_menu_fo');
	
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

<style>
.btn_active {
    background-color:#455486;
    color: white;
}
</style>



		


<script>
function demoFromHTML() {
    var pdf = new jsPDF('p', 'pt', 'letter');

    source = $('.report-pre')[0];

    specialElementHandlers = {        
        '#bypassme': function (element, renderer) {            
            return true
        }
    };
    margins = {
        top: 80,
        bottom: 60,
        left: 40,
        width: 522
    };

    pdf.fromHTML(
    source, // HTML string or DOM elem ref.
    margins.left, // x coord
    margins.top, { // y coord
        'width': margins.width, // max width of content on PDF
        'elementHandlers': specialElementHandlers
    },

    function (dispose) {
        // dispose: object with X, Y of the last line add to the PDF 
        //          this allow the insertion of new lines after html
        pdf.save('Test.pdf');
    }, margins);
}
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
						<!-- Messages: style can be found in dropdown.less-->
						<li class="dropdown messages-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							About Us 
							</a>
						<ul class="dropdown-menu">
							<li class="header">You have 4 messages</li>
								<li>
								<!-- inner menu: contains the actual data -->
								<ul class="menu">
								<li><!-- start message -->
								<a href="#">
								<div class="pull-left">
								<img src="<?php echo base_url();?>image/iplon_logo.png" class="img-circle" alt="User Image"/>
								</div>
								<h4>Support Team<small><i class="fa fa-clock-o"></i> 5 mins</small></h4>
									<p>Why not buy a new awesome theme?</p>
								</a>
								</li>
						</ul>
				</div><!-- end message -->
               
				<div class="navbar-right" >                    
					<ul class="nav navbar-nav">
					<!-- Messages: style can be found in dropdown.less-->
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Services</a>
						<ul class="dropdown-menu">
						<li class="header">Life Cycle Management</li>
					<li>
					<!-- inner menu: contains the actual data -->
						<ul class="menu">
							<li>
								<a href="#"><div class="pull-left"><img src="<?php echo base_url();?>image/avatar3.png" class="img-circle" alt="User Image"/></div>
								<h4>Support Team<small><i class="fa fa-clock-o"></i> 5 mins</small></h4>
								<p>Why not buy a new awesome theme?</p>
								</a>
							</li>
						</ul>
				</div><!-- end message -->
                                        
				<div class="navbar-right" >
				<ul class="nav navbar-nav">
					<li class="dropdown messages-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Contact Us</a>
				<ul class="dropdown-menu">
					<li class="header">
						<img src="<?php echo base_url();?>image/india_flag.png" class="img-circe" alt="Iplon India" width="20%"/>
						&nbsp;&nbsp;&nbsp;iPLON INDIA pvt ltd<br>

						26/80, Luz Avenue, Mylapore<br>
						Chennai<br>
						India<br>
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
				<ul class="menu">
				<li><!-- start message -->
					<a href="#">
						<div class="pull-left">
								<img src="<?php echo base_url();?>image/avatar3.png" class="img-circle" alt="User Image"/>
					</div>
					<h4>Support Team<small><i class="fa fa-clock-o"></i> 5 mins</small></h4>
					<p>Why not buy a new awesome theme?</p>
					</a>
				</li>
				</div><!-- end message -->
				</ul>
				</div>
	</nav>
			<?php }?>
        
       
			<?php if($this->uri->segment(1) !=''){
			 include_once("topnavigation.php");
			}?>
		
			
  
