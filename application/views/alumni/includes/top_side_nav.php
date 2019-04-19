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
                        <span class="hidden-xs">Welcome, <?php echo ucfirst($username) ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo base_url('assets/img/nick.jpg') ?>" class="img-circle" alt="User Image">

                            <p>
                                <?php echo $username ?>
                                <small><?php echo $regno ?></small>
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
            <li>
                <a href="<?php echo site_url('alumni/review_details') ?>">
                    <i class="fa fa-check"></i> <span>Review Details</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('alumni/fee') ?>">
                    <i class="fa fa-mouse-pointer"></i> <span>Pay Fees Online</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('alumni/invoice') ?>">
                    <i class="fa fa-newspaper-o"></i> <span>Payment Invoice</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('alumni/account_settings') ?>">
                    <i class="fa fa-gear"></i> <span>Profile Settings</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<div class="modal modal-success fade in" id="feedback-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">AMS Feedback</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <form id="feedback-form" method="post" autocomplete="off">
                            <input type="hidden" name="ams_ajax" value="true">
                            <div class="form-group">
                                <label for="feedback-name" class="control-label">Name</label>
                                <input type="text" class="form-control" id="feedback-name" placeholder="Your Name" required>
                            </div>
                            <div class="form-group">
                                <label for="feedback-email" class="control-label">Email</label>
                                <input type="email" class="form-control" id="feedback-email" placeholder="Your Email" required>
                            </div>
                            <div class="form-group">
                                <label for="feedback-feedback" class="control-label">Feedback</label>
                                <textarea id="feedback-feedback" class="form-control no-resize" rows="5" placeholder="Your detailed feedback" required></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" form="feedback-form" class="btn btn-warning" id="send-feedback-btn"><i class="fa fa-paper-plane margin-r-5"></i>Send</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close margin-r-5"></i>Close</button>
            </div>
        </div>
    </div>
</div>