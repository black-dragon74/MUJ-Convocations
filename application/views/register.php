<?php defined('BASEPATH') OR exit('No direct script access allowed'); require_once "login_includes/header.php" ?>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="<?php echo site_url('welcome') ?>"><b>MUJ Convocations</b></a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Register for convocation ceremony</p>

        <form action="<?php echo site_url('login/validate_registration') ?>" method="post">
            <div class="form-group has-feedback">
                <input type="number" name="regNo" class="form-control" placeholder="Registration Number" max="999999999" required>
                <span class="glyphicon glyphicon-info-sign form-control-feedback"></span>
            </div>
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('gre_site_key'); ?>"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 pull-right">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
            </div>
        </form>
        <br>
        <a href="<?php echo site_url('login') ?>" class="text-center">Login</a>
    </div>
</div>

<?php
if ($this->session->flashdata('error') != '') { ?>
    <script>
        toastr.error("<?php echo $this->session->flashdata('error') ?>", "Error")
    </script>
<? }
?>

<?php
if ($this->session->flashdata('success') != '') { ?>
    <script>
        toastr.success("<?php echo $this->session->flashdata('success') ?>", "Success")
    </script>
<? }
?>
<?php require_once "login_includes/footer.php" ?>