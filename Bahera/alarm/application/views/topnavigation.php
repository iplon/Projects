  <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                    <div class="navbar-right">
                        <ul class="nav navbar-nav">

                            <!-- Tasks: style can be found in dropdown.less -->

                        <!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu" title="Log out">
                            <a href="<?php echo base_url();?>logout" class="dropdown-toggle">
                                <i style="color:#FF0009;" class="glyphicon glyphicon-off"></i>
                                <span><?php //echo ucfirst($username); ?> </span>
                            </a>
                        </li>	
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
					<div class="user-panel">
        
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
	

						                         <li class="active">
                            <a href="<?php echo base_url().'alarm';?>">
                                <i class="glyphicon glyphicon-bell"></i><span>Alarm Configuration</span>
                            </a>
                        </li>
						
                    </ul>
                </section>
            </aside>
			
