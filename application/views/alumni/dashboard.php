<?php include_once 'includes/top_scripts.php'; include_once 'includes/top_side_nav.php'; ?>
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
                <div class="callout callout-warning">
                    <h4><i class="fa fa-info-circle margin-r-5"></i>Note</h4>
                    <h4>
                        Please pay your convocation fees in order to complete your registration.
                    </h4>
                </div>
            </div>
        </div>
        <?php } ?>
        <!--Row 2-->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger box-solid collapsed-box">
                    <div class="box-header">
                        <h4 class="box-title text-bold">
                            Instructions for the graduates
                        </h4>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12" style="font-size: 20px;">
                                <!-- Section One -->
                                <div>
                                    <p>
                                        The 5th convocation of Manipal University Jaipur is scheduled as below:
                                    </p>
                                    <ul>
                                        <li>Day 1: Thursday, November 01, 2018</li>
                                        <li>Day 2: Friday, November 02, 2018</li>
                                    </ul>
                                    <p>
                                        Since a large number of students are eligible for the award of Degree during this year, the Convocation has been planned for two days.
                                    </p>
                                    <p>
                                        The graduates may opt for receiving their Degree on either of the two days. As such, you are advised to register yourself for attending the function on either of the two days, and the registration shall be done on First Come First Served. Once confirmed, the date opted for convocation will not be changed.
                                    </p>
                                    <hr>
                                </div>

                                <!-- Section 2 -->
                                <div>
                                    <h4 class="box-title text-bold text-center">
                                        Reporting & Rehearsal
                                    </h4>
                                    <h4 class="text-bold">1. Graduates who have registered for Thursday, November 01, 2018:</h4>
                                    <p>
                                        Graduates are advised to reach the University latest by 2:00 pm on October 31, 2018 and collect the ceremonial kit.
                                        Please note that the ceremonial kit and the convocation folder will be issued only till 4:00 pm.
                                        The rehearsal for the Convocation will start at 4:30 pm.
                                    </p>

                                    <br>
                                    <h4 class="text-bold">2. Graduates who have registered for Friday, November 02, 2018:</h4>
                                    <p>
                                        Graduates are advised to reach the University latest by 9:00 am on November 01, 2018 and collect the ceremonial kit.
                                        Please note that the ceremonial kit and the convocation folder will be issued only till 10:00 am.
                                        The rehearsal for the Convocation will start at 11:00 am.
                                    </p>

                                    <br>
                                    <h4 class="text-bold">
                                        Note: If any graduate fails to report in person for the rehearsal on the specified date, he / she will not be accommodated in the convocation ceremony.
                                    </h4>

                                    <br>
                                    <h4 class="text-bold text-danger">
                                        Note: Please bring Rs 1000 (in Cash) on the day of Convocation as Security Deposit of Graduation Gown. This Security deposit will be collected by the Vendor and will be returned to you after the convocation on the submission of the Graduation Gown back to the vendor.
                                    </h4>
                                    <hr>
                                </div>

                                <!-- Section 3 -->
                                <div>
                                    <p>
                                        For any furthur assistance, Please write us at: <b>convocation@jaipur.manipal.edu.</b>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3 -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success box-solid">
                    <div class="box-header">
                        <h4 class="box-title text-bold">
                            Steps for registration
                        </h4>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12" style="font-size: 20px;">
                                <ul>
                                    <li>We have created a basic profile of all the graduates.You can check the details
                                        by clicking the link available at the left panel. If you found any discrepancy
                                        in the data provided in the basic profile,Please write us at:
                                        <b>convocation@jaipur.manipal.edu</b> mentioning the chnages required.
                                    </li>
                                    <br>
                                    <li>For attending the convocation, you have to pay the convocation fee of Rs 1000.
                                        This fee you can pay using Paytm or PayU by clicking the Pay Fee link in the left panel.
                                        Once you paid the fee, keep the Order ID/Payment ID, Date of payment and Amount paid, required for filling the registration form.
                                    </li>
                                    <br>
                                    <li>
                                        If you are not able to attend the Convocation personally, you may request for the Degree Certificate by the post.
                                        For this, you have to pay Rs.300/- towards handling charges.
                                        This fee you can pay using Paytm or PayU by clicking the Pay Fee link in the left panel.
                                        Once you paid the fee, keep the Order ID/Payment ID, Date of payment and Amount paid, required for filling the request form.
                                    </li>
                                </ul>
                                <p>
                                    For any future assistance in registration , Please write us at: <b>convocation@jaipur.manipal.edu</b>
                                </p>
                            </div>
                        </div>
                    </div>
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
    })
</script>
<?php include_once 'includes/footer.php';
include_once 'includes/bottom_scripts.php' ?>
