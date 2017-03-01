<?php ob_start();?>
<!DOCTYPE html>
		<head>		
		<title>iPLON | DET</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="UTF-8">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- CSS Start -->
		<link href="<?php echo base_url().'css/bootstrap.min.css'; ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url().'css/font-awesome.min.css';?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url().'css/ionicons.min.css';?>" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url().'css/bootstrap/bootstrapValidator.css';?>"/>
		<link href="<?php echo base_url().'css/AdminLTE.css';?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url().'css/colorbox.css';?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url().'css/jquery-ui.css';?>" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="<?php echo base_url().'image/favicon3.ico';?>">

		<script src="<?php echo base_url().'js/jquery.min.js';?>"></script>
		<script src="<?php echo base_url().'js/jquery-ui-1.10.3.min.js';?>" type="text/javascript"></script>
		<script src="<?php echo base_url().'js/jquery.validate.js';?>"></script> 
		<script src="<?php echo base_url().'js/jquery.colorbox.js';?>" type="text/javascript"></script>
		<script src="<?php echo base_url().'js/bootstrap.min.js';?>" type="text/javascript"></script>
		<script src="<?php echo base_url().'js/jquery.sparkline.min.js';?>" type="text/javascript"></script>
		<script src="<?php echo base_url().'js/AdminLTE/app.js';?>" type="text/javascript"></script>
        
        
		
	<?php if($this->uri->segment(1)== 'det'){?>
			<style type="text/css">
			${demo.css}
			</style>
			
			<link href="<?php echo base_url().'css/datatables/dataTables.bootstrap.css';?>" rel="stylesheet" type="text/css" />
			<script src="<?php echo base_url().'js/plugins/datatables/dataTables.bootstrap.js';?>" type="text/javascript"></script>
			<script src="<?php echo base_url().'js/AdminLTE/demo.js';?>" type="text/javascript"></script>
			<script src="<?php echo base_url().'js/plugins/flot/jquery.flot.min.js';?>" type="text/javascript"></script>
			<script src="<?php echo base_url().'js/plugins/flot/jquery.flot.resize.min.js';?>" type="text/javascript"></script>
			<script src="<?php echo base_url().'js/plugins/flot/jquery.flot.pie.min.js';?>" type="text/javascript"></script>
			<script src="<?php echo base_url().'js/plugins/flot/jquery.flot.categories.min.js';?>" type="text/javascript"></script>
			<script type="text/javascript">
			$(function() { // Document Ready function START  
			
			var base_url = "<?php echo base_url(); ?>";$(".ajax").colorbox(
                       {
                        onClosed:function(){parent.location.reload();
                       }
                                    }
                       );
					   //////ALARM TABLE START/////
			
                $('#example1').dataTable({
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": false,
                    "bAutoWidth": false
                });//////ALARM TABLE END/////

				$('#timepicker').datetimepicker({
	datepicker:false,
	format:'H:i',
	});
$('#timepickers').datetimepicker({
	
	timepicker:false,
	format:'d-m-Y',
	defaultDate:'d-m-Y',
	minDate:'2013/01/01' // and tommorow is maximum date calendar
});
  
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
				</ul>
				</div>
	</nav>
			<?php }?>
        
       
			<?php if($this->uri->segment(1) !=''){
			 include_once("topnavigation.php");
			}?>
		
			
  
