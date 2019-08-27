<?php include_once 'includes/top_scripts.php'; include_once 'includes/top_side_nav.php'; ?>
<?php $currentUser = $this->db->get_where('alumni', array('regno' => $regno))->row(); ?>
<script>
    $('ul > li:nth-child(2)').addClass("active");
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('alumni') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Row 1 -->
        <?php if ($this->db->get_where('users', array('regno' => $regno))->row()->paid != '1') {?>
        <div class="row">
            <div class="col-xs-12">
                <div class="callout callout-danger">
                    <h4><i class="fa fa-warning margin-r-5"></i>Important Notice</h4>
                    <h4 id="pay-fee-now">
                        Your registration is not yet complete. Click here to pay fee and complete your registration.
                    </h4>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="callout callout-success">
                    <h4><i class="fa fa-check margin-r-5"></i>Note</h4>
                    <h4 id="get-invoice-now">
                        Your registration process is complete. Click here to get your invoice.
                    </h4>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- Row 2 -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-success">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/img/avatar.png')?>" alt="User profile picture">

                        <h3 class="profile-username text-center"><?php echo $currentUser->name ?></h3>

                        <p class="text-muted text-center"><?php echo $currentUser->regno ?></p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Email</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->email ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Gender</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->gender ? $currentUser->gender : 'NA' ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Degree</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->degree ? $currentUser->degree : 'NA' ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Batch</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->batch ? $currentUser->batch : 'NA' ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Branch</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->branch ? $currentUser->branch : 'NA' ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Phone</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->mobile ? $currentUser->mobile : 'NA' ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Address</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->address ? $currentUser->address : 'NA' ?></span>
                            </li>
                        </ul>

                        <h4 class="text-danger text-center">Contact your branch HoD incase of any errors</h4>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $('#alumni-formtype').on('change', function () {
        const result = $('#alumni-formtype').val();
        if (result === '1') {
            $('#alumni-address-box').removeClass('hidden');
            $('#alumni-address-text').prop('required', true);
        }
        else {
            $('#alumni-address-box').addClass('hidden');
            $('#alumni-address-text').prop('required', false);
        }
    });

    // I am lazy to type HTML and css and hence handling clicks via JS, this is fun though ;)
    $('#pay-fee-now').on('click', function () {
       window.location = '<?php echo site_url('alumni/fee') ?>';
    }).css({
        'cursor': 'pointer',
        'user-select': 'none'
    });

    $('#get-invoice-now').on('click', function () {
        window.location = '<?php echo site_url('alumni/invoice') ?>';
    }).css({
        'cursor': 'pointer',
        'user-select': 'none'
    });
</script>
<?php include_once 'includes/footer.php';
include_once 'includes/bottom_scripts.php' ?>
