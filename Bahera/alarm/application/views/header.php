<?php ob_start();?>
<!DOCTYPE html>
		<head>		
		<title>iPLON | Alarm</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="UTF-8">
		<meta content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=no" name="viewport">
		<!-- CSS Start -->
		<link href="<?php echo base_url().'css/bootstrap.min.css'; ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url().'css/font-awesome.min.css';?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url().'css/ionicons.min.css';?>" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="<?php //echo base_url().'css/bootstrap/bootstrapValidator.css';?>"/>
		<link href="<?php echo base_url().'css/AdminLTE.css';?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url().'css/colorbox.css';?>" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="<?php echo base_url().'image/favicon3.ico';?>">
		
		
		

		
		<!-- CSS End -->
		<!-- jQuery  start  -->
		<script src="<?php echo base_url().'js/jquery.min.js';?>"></script>				
		<script src="<?php echo base_url().'js/jquery-ui-1.10.3.min.js';?>" type="text/javascript"></script>
		<script src="<?php //echo base_url().'js/jquery.validate.js';?>"></script>  
		<script src="<?php echo base_url().'js/jquery.colorbox.js';?>" type="text/javascript"></script>
		<script src="<?php echo base_url().'js/bootstrap.min.js';?>" type="text/javascript"></script>
		<script src="<?php echo base_url().'js/jquery.sparkline.min.js';?>" type="text/javascript"></script>
		<script src="<?php echo base_url().'js/AdminLTE/app.js';?>" type="text/javascript"></script>
		<script src="<?php //echo base_url().'js/plugins/sparkline/jquery.sparkline.min.js';?>" type="text/javascript"></script>
		


				<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>	-->






					<link href="<?php echo base_url().'css/datatables/dataTables.bootstrap.css';?>" rel="stylesheet" type="text/css" />
			<script src="<?php echo base_url().'js/plugins/datatables/jquery.dataTables.js';?>" type="text/javascript"></script>
			<script src="<?php echo base_url().'js/plugins/datatables/dataTables.bootstrap.js';?>" type="text/javascript"></script>




				
	<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.8/css/dataTables.bootstrap.min.css">

    <script src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.8/js/dataTables.bootstrap.min.js"></script>-->

    

<script>
$(document).ready(function() {
    $('#example').DataTable();
	
	
} );
</script>	


    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) { 
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            
            $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
        });
    </script>


<script>


function handleClick(myRadio) {
if(myRadio.value == 'event' || myRadio.value == 'fire'){
document.getElementById('priority').setAttribute('disabled', 'disabled'); 
}			
else
document.getElementById('priority').removeAttribute('disabled');  		
}

</script>	







<script>
/*
$(document).ready(function() {
		
	$('.drop').focus(function() {
    prev_val = $(this).val();
}).change(function() {
	
	lastValue = $(this).val();
	
	     $(this).blur() 
    var success = confirm('Are you sure you want to change the Priority?');
    if(success)
    {       
		var id = $(this).attr('id');

					    $.ajax({ 
				url:"<?php echo base_url();?>priority_change",					
				data: 'id='+id+'&priority='+lastValue,				
				
				type: "POST",
			success:function(data){ 						

				}
				
				});	


    }  
    else
    {
        $(this).val(prev_val);
        alert('unchanged');
        return false; 
    }
	

});
});*/
</script>


		
		
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
			<!-- end message -->
                                        

				</ul>
				</div>
	</nav>
			<?php }?>
        
       
			<?php if($this->uri->segment(1) !=''){
			 include_once("topnavigation.php");
			}?>
		
			
  
