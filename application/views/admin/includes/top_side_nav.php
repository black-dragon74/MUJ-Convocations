<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url('alumni') ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>MU</b>C</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>MUJ</b>Convocations</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <!-- For screen readers -->
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo base_url('assets/img/nick.jpg') ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs">Welcome, <?php echo ucfirst($this->session->userdata('name')) ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo base_url('assets/img/nick.jpg') ?>" class="img-circle" alt="User Image">

                            <p>
                                <?php echo $this->session->userdata('name') ?>
                                <small>MUJ CONVOCATIONS ADMINISTRATOR</small>
                                <small>With great power comes great responsibility.</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo site_url('alumni/account_settings') ?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo site_url('login/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- Main Section -->
            <li class="header">Main Menu</li>
            <li>
                <a href="<?php echo site_url('alumni') ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <!-- Use this to add some msg to the right of menu -->
                    <!-- <span class="pull-right-container">
                      <small class="label pull-right bg-red">•</small>
                    </span> -->
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>