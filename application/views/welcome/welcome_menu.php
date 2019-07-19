<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="<?php echo site_url('welcome') ?>" class="navbar-brand"><b>MUJ</b>Convocations</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" id="mobile-welcome-menu">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
                <ul class="nav navbar-nav" id="welcome-menu">
                    <li><a href="<?php echo site_url('welcome') ?>">Home</a></li>
                    <li><a href="<?php echo site_url('welcome/guidelines') ?>">Guidelines</a></li>
                    <li><a href="<?php echo site_url('welcome/instructions') ?>">Instructions</a></li>
                    <li><a href="<?php echo site_url('welcome/contact') ?>">Contact Us</a></li>
                    <li><a href="<?php echo site_url('login') ?>" class="text-bold" style="color: red !important;">LOGIN & REGISTER</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Dirty hack to position navbar elems sanely -->
    <script>
        $('#mobile-welcome-menu').on('click', function () {
           $('#navbar-collapse').toggleClass('pull-right');
        });
    </script>
</header>