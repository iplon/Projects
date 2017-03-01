<?php 
 include_once("header.php");
 //include_once("validated-html.source.php"); /// login page slider

?>

	 <div class="loginBlockOuter" >

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="loginBlock" style="border-color:#000;" >
                <!-- Content Header (Page header) -->
				
				
                <section class="content-header">
				
                    <h1> Login </h1>
					
			
                </section>

                <!-- Main content -->
                <section class="content">
				<?php if($this->session->flashdata('failurelogin')) {?>
					 <div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-warning"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<b><?php echo ''.$this->session->flashdata('failurelogin').'';
										$this->session->keep_flashdata('failurelogin');?> </b>
								</div>
					
					<?php }?>
								<div class="container-fluid">	
									<!-- Page Heading -->
									<div class="row">
									<form id="loginform" method="post" class="form-horizontal" action="<?php echo base_url().'checklogin';?>">
									   <div class="alert alert-success" style="display: none;"></div>

										<div class="col-lg-12 form-control-group">
											<label class="control-label" for="name">User Name</label>
											<div class="controls">
											  <input type="text" class="input-large" name="username" id="username" required>
											</div>
										</div>
							  
										<div class="col-lg-12 form-control-group">
											<label class="control-label" for="name">Password</label>
											<div class="controls">
											  <input type="password" class="input-xlarge" name="password" id="password" required>
											</div>
										</div>

										<center><div class="col-lg-12 form-actions">
											<button type="submit" class="btn btn-success btn-large">Login</button>
											<button type="reset" class="btn">Cancel</button>
										</div></center>
										</form>
									</div>
									<!-- /.row -->

								</div>
								<!-- /.container-fluid -->
                </section><!-- /.content -->
				
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
		
		<?php 
 include_once("footer.php");
?>