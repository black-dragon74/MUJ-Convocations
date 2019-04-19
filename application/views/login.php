<?php defined('BASEPATH') OR exit('No direct script access allowed'); require_once "login_includes/header.php" ?>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="<?php echo site_url('login') ?>"><b>MUJ Convocations</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Log in with your credentials</p>

        <form action="<?php echo site_url('login/validate_login')?>" method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Registration Number" name="username">
                <span class="glyphicon glyphicon-info-sign form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4 pull-right">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
            </div>
        </form>

        <a href="<?php echo site_url('login/forgot_password') ?>">Forgot password?</a><br>
        <a href="<?php echo site_url('login/register'); ?>" class="text-center">Register</a>
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
