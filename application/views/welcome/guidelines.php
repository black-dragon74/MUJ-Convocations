<?php
// Template for the normal index pages
defined('BASEPATH') OR exit('No direct script access allowed');
$htmlContent = $this->db->get_where('html_content', array('name' => 'guidelines'))->row()->content;
require_once VIEWPATH.'login_includes/header.php' ?>
<body class="skin-black layout-top-nav">
<div class="wrapper">
    <?php require_once "welcome_menu.php" ?>
    <div class="content-wrapper">
        <div class="container">
            <section class="content-header">
                <h1>
                    Guidelines
                    <small>for graduates</small>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-warning">
                            <div class="box-body">
                                <div>
                                    <?php echo $htmlContent ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <footer class="main-footer no-print">
        <strong>Crafted with <i class="fa fa-heart text-red"></i> by
            <a href="https://nicksuniversum.com" target="_blank" style="text-decoration: none; color: #444;" title="Da be da be dooo">Nick</a>
        </strong>

        <strong class="pull-right">
            &copy; Manipal University, Jaipur
        </strong>
    </footer>
</div>
</body>

<!-- Set the active index -->
<script>
    $('#welcome-menu > li:nth-child(2)').addClass('active');
</script>
<?php require_once VIEWPATH. "login_includes/footer.php" ?>
