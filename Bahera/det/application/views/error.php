<?php 
 include_once("header.php");
?>
   <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo ucfirst($username);?>
                        <small>Dashboard</small>
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
				  <h1>
                        <?php echo $heading;?>
                        
                    </h1>
                   <p><?php echo $message;?></p> 
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
<?php 
 include_once("footer.php");
?>
