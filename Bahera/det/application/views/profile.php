<?php 
 include_once("header.php");
?>
   <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo ucfirst($username);?>
                        <small>Profile</small>
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
				 <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Quick Example</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form name="profileform" id="profileform" method="post" enctype="multipart/form-data" action="<?php echo base_url().'updateprofile'; ?>">
                                    <div class="box-body">
									<div class="form-group">
                                            <label for="exampleInputEmail1">username</label>
                                            <input type="text" class="form-control" id="exampleInputusername" value="<?php echo ucfirst($userData->user); ?>" readonly="yes">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" value="<?php echo $userData->emailaddress;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword1">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Profile Photo</label>
                                            <input type="file" id="exampleInputFile" name="profile">
                                            <!--<p class="help-block">Example block-level help text here.</p>-->
                                        </div>
											
                                    </div><!-- /.box-body -->
										<input type="hidden" id="userid" name="userid" value="<?php echo $userData->id; ?>">						
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div><!-- /.box -->

               </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
<?php 
 include_once("footer.php");
?>
