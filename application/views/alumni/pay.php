<?php include_once 'includes/top_scripts.php'; include_once 'includes/top_side_nav.php'; ?>
<?php $currentUser = $this->db->get_where('alumni', array('regno' => $regno))->row(); ?>
<script>
    $('ul > li:nth-child(4)').addClass("active");
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pay Fees
            <small>using PayTM</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('alumni') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Pay Fees</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Row 1 -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-header">
                        <h4 class="box-title">
                            Please review the details and click on pay
                        </h4>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12" style="font-size: 20px;">
                                <p>Please keep in mind:</p>
                                <ul>
                                    <li>You will have to pay Rs. 300/- if you opted to get your certs via post.</li>
                                    <li>You will have to pay Rs. 1000/- if you are attending the ceremony.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <form action="<?php echo site_url('alumni/process_payment')?>" name="f1" method="post">
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <div class="checkbox">
                                                <label class="control-label" style="font-weight: bold;">
                                                    <input type="checkbox" name="agree" id="agree"> I have read and agree to the above terms and conditions
                                                    <input type="hidden" name="regno" value="<?php echo $currentUser->regno ?>">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="button" class="btn btn-flat btn-danger" id="cancelnow">Back to Dashboard</button>
                        <button type="submit" class="btn btn-flat btn-success pull-right" id="paynow">Proceed To Pay My Fees</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $('#paynow').on('click', function (e) {
        let val = $('#agree').is(':checked');

        if (!val) {
            e.preventDefault();
            toastr.error('Please accept the agreement.', 'Error');
        }
        else {
            document.f1.submit();
        }
    });

    $('#cancelnow').on('click', function () {
        window.location = "/";
    });
</script>
<?php include_once 'includes/footer.php';
include_once 'includes/bottom_scripts.php' ?>
