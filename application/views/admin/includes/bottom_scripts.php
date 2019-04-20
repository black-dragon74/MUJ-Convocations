<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('bower_components/jquery-ui/jquery-ui.min.js') ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<!-- datepicker -->
<script src="<?php echo base_url('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url('bower_components/fastclick/lib/fastclick.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('dist/js/adminlte.min.js')?>"></script>
<!-- Custom JS -->
<script src="<?php echo base_url('dist/js/custom.js')?>"></script>
<!-- Error Handler -->
<?php
if ($this->session->flashdata('error') != '') { ?>
    <script>
        toastr.error("<?php echo $this->session->flashdata('error') ?>", "Error")
    </script>
<? }
?>

<!-- Success Handler -->
<?php
if ($this->session->flashdata('success') != '') { ?>
    <script>
        toastr.success("<?php echo $this->session->flashdata('success') ?>", "Success")
    </script>
<? }
?>
</body>
</html>
<!--       _
       .__(.)< (MEOW)
        \___)

        Yeah, the duck says meow. And kudos to you for finding this easter egg.
        Come find me somehwere in MUJ and let's have a cup of coffee together.
 ~~~~~~~~~~~~~~~~~~-->