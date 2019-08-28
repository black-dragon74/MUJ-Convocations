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
        <!-- Little bit of mess -->
       <?php
            if (getConfig($this, 'site_offline') == '1') { ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="callout callout-danger">
                    <h4 class="no-margin">Site is offline for all the users other than administrators. You can change active state from options below.</h4>
                </div>
            </div>
        </div>
        <?php }
       ?>

        <!-- Small Box Row -->
        <div class="row">
            <!-- Box 1 -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3 class="count-fast"><?php echo $users ?></h3>
                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <p class="small-box-footer">
                        <?php echo $confirmed ?> confirmed
                    </p>
                </div>
            </div>

            <!-- Box 2 -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="count-fast"><?php echo $attending ?></h3>
                        <p>Attending Ceremony</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <p class="small-box-footer">
                        <?php echo $parents ?> with parents
                    </p>
                </div>
            </div>

            <!-- Box 3 -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3 class="count-fast"><?php echo $post ?></h3>
                        <p>Opted for post</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-mail"></i>
                    </div>
                    <p class="small-box-footer">
                        No further info
                    </p>
                </div>
            </div>

            <!-- Box 4 -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3 class="count-fast"><?php echo $unpaid ?></h3>
                        <p>Unpaid Fees</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ban"></i>
                    </div>
                    <p class="small-box-footer">
                        <?php echo $paid ?> paid the fees
                    </p>
                </div>
            </div>
        </div>

        <!-- Second row, add new admin and add event days -->
        <div class="row">
            <!-- Add new Admin -->
            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header">
                        <h4 class="box-title">
                            Add new administrator
                        </h4>
                    </div>
                    <div class="box-body">
                        <form action="<?php echo site_url('admin/add_admin') ?>" method="post">
                            <div class="form-group">
                                <label for="admin-name" class="control-label">Administrator Full Name</label>
                                <input type="text" class="form-control" name="admin-name" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="admin-email" class="control-label">Administrator Email</label>
                                <input type="email" class="form-control" name="admin-email" placeholder="Email" required>
                                <small>This is the email that will be used to login.</small>
                            </div>
                            <div class="form-group">
                                <label for="admin-password" class="control-label">Administrator Password</label>
                                <input type="password" class="form-control" name="admin-password" placeholder="Password" id="admin-password" required>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label for="" class="checkbox control-label" id="showpasswordlabel">
                                        &nbsp;
                                        <input type="checkbox" name="showpassword" id="showpassword">
                                        Show Password
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-danger form-control" value="Add Administrator">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Update event days -->
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h4 class="box-title">
                            Update event days
                        </h4>
                    </div>
                    <div class="box-body">
                        <form action="<?php echo site_url('admin/update_event_days') ?>" method="post">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="start-date" class="control-label">Select Start Date</label>
                                    <input type="text" class="form-control date-picker" name="start-date" value="<?php echo isset($startDate) ? $startDate : '' ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="end-date" class="control-label">Select End Date</label>
                                    <input type="text" class="form-control date-picker" name="end-date" value="<?php echo isset($lastDate) ? $lastDate : '' ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <br>
                                    <input type="submit" value="Update Dates" class="form-control btn btn-primary">
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-xs-12">
                                <hr>
                                <h4 class="box-title">
                                    Lock Event Date
                                </h4>
                            </div>

                            <form action="<?php echo site_url('admin/lock_event_days') ?>" method="post">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <select name="disable-dates[]" class="form-control select2" data-placeholder="Select days to disable" multiple required>
                                            <?php
                                                if (isset($events)) {
                                                    foreach ($events as $event) {
                                                        echo '<option value="'. $event["value"] .'">'. $event["name"] .' ( '.$event["value"].')</option>';
                                                    }
                                                }
                                            ?>
                                            <option value=""></option>
                                        </select>
                                        <h5 class="text-red">Note: Dates once locked cannot be unlocked again.</h5>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <br>
                                        <input type="submit" class="btn btn-primary form-control" value="Lock selected date">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row to admit a new student manually -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">
                            Add student manually
                        </h3>
                    </div>

                    <div class="box-body">
                        <form action="<?php echo site_url('admin/add_student_manually') ?>" method="post" class="form-horizontal">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="reg_no" placeholder="Registration Number" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="alumni_name" placeholder="Student Name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" placeholder="Email address" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone" placeholder="Mobile Number" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="">-- Select Gender --</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="degree" placeholder="Degree">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="batch" placeholder="Batch">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="branch" placeholder="Branch">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <textarea name="address" id="" cols="30" rows="5" class="form-control" placeholder="Address"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="text" class="form-control" name="pincode" placeholder="Pincode">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="submit" value="Add student" class="btn btn-success form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row containing elements for updating fee amount for post and attendance -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h4 class="box-title">
                            Update fees for events
                        </h4>
                    </div>
                    <div class="box-body">
                        <form action="<?php echo site_url('admin/update_fees')?>" autocomplete="off" method="post">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="event-type" class="control-label">Select Event</label>
                                    <select name="event-type" id="event-type" class="form-control" required>
                                        <option value="">-- SELECT --</option>
                                        <option value="attend">Attending the ceremony</option>
                                        <option value="post">Send certificates via post</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="event-price" class="control-label">Enter Price</label>
                                    <input type="number" name="event-price" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Update</label>
                                    <input type="submit" class="btn btn-info form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Third row, Download excel template -->
        <div class="row">
            <!-- Excel template generator -->
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header">
                        <h4 class="box-title">
                            Download Excel Template
                        </h4>
                    </div>
                    <div class="box-body">
                        <div class="callout callout-success">
                            <p>Click the button below to download the 'Excel' format file.</p>
                            <p>Upload the file back by filling in the required details.</p>
                        </div>
                        <a href="<?php echo site_url('admin/gen_xlsx') ?>" target="_blank" class="btn btn-success col-xs-12">Download Template</a>
                    </div>
                </div>
            </div>

            <!-- Update event days -->
            <div class="col-md-6">
                <div class="box box-warning">
                    <div class="box-header">
                        <h4 class="box-title">
                            Upload Excel Data
                        </h4>
                    </div>
                    <div class="box-body">
                        <div class="callout callout-warning">
                            <p>Make sure the dates in uploaded file are in DD-MM-YYY format.</p>
                        </div>
                        <?php echo form_open_multipart('admin/process_data');?>
                            <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="data-file" style="display: block !important; position: static" required>
                            <div style="margin-bottom: 10px;"></div>
                            <input type="submit" value="Upload Data" class="form-control btn btn-warning">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fourth row, update details of an student -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header">
                        <h4 class="box-title">
                            Update details of student
                        </h4>
                        <div class="box-body">
                            <form action="">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <input type="text" name="reg-no" id="reg-no" placeholder="Enter registration number" required class="form-control">
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="submit" class="btn btn-default form-control" id="reg-no-btn">Fetch details</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header">
                        <h4 class="box-title">
                            Close user portal?
                        </h4>
                        <div class="box-body">
                            <form action="<?php echo site_url('admin/update_state') ?>" method="post">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <select name="site-offline" id="site-offline" class="form-control" required>
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="submit" class="btn btn-default form-control">Update Portal State</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fifth row, Reset Credentials of admin and user -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header">
                        <h4 class="box-title">
                            Reset password of Alumni
                        </h4>
                        <div class="box-body">
                            <form action="<?php echo site_url('admin/reset_alumni') ?>" method="post">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <input type="text" name="reg-no" placeholder="Enter registration number" required class="form-control">
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="submit" class="btn btn-danger form-control">Reset Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header">
                        <h4 class="box-title">
                            Reset password of Administrator
                        </h4>
                        <div class="box-body">
                            <form action="<?php echo site_url('admin/reset_admin') ?>" method="post">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <input type="email" class="form-control" name="admin-email" placeholder="Enter admin email" required>
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="submit" class="btn btn-danger form-control">Reset Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Last row, download consolidated report -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h4 class="box-title">
                            Download consolidated Excel report
                        </h4>
                    </div>
                    <div class="box-body">
                        <form action="<?php echo site_url('admin/download_report') ?>" method="post">
                            <div class="form-group">
                                <div class="col-xs-4 col-xs-offset-4">
                                    <input type="submit" class="form-control btn btn-info" value="Click here to download">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Modal box to edit the details of the student -->
<div class="modal fade in" id="updater-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <p class="text-bold text-center text-danger">
                            Values not available here can be updated from alumni's account settings
                        </p>
                    </div>
                    <div class="col-xs-12">
                        <form method="post" autocomplete="off" action="<?php echo site_url('admin/update_student') ?>" id="update-form">
                            <input type="hidden" name="regno" id="regno">
                            <div class="row">
                                <div class="col-md-6">
                                    <small>Name</small>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                                </div>

                                <div class="col-md-6">
                                    <small>Email</small>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <small>Primary Mobile</small>
                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile">
                                </div>

                                <div class="col-md-6">
                                    <small>Pincode</small>
                                    <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12">
                                    <textarea name="address" id="address" cols="30" rows="5" class="form-control" placeholder="Address"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" form="update-form" class="btn btn-success" id="send-feedback-btn"><i class="fa fa-check margin-r-5"></i>Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close margin-r-5"></i>Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    let elem = '#admin-password';
    $('#showpassword').on('change', function () {
        let isChecked = $('#showpassword').is(':checked');

        // If checked, change input type to text else password
        if (isChecked) {
            $(elem).prop('type', 'text');
        }
        else {
            $(elem).prop('type', 'password');
        }
    });

    $('#showpasswordlabel').on('click', function () {
       $('#showpassword').click();
    }).css({
        cursor: 'pointer',
        'user-select': 'none'
    });

    $(document).ready(function () {
       $('.date-picker').datepicker({
           format: 'dd-mm-yyyy',
           startDate: '<?php echo date("d/m/Y") ?>',
           todayHighlight: true,
           todayBtn: true
       });

        $('.date-picker-alt').datepicker({
            format: 'dd-mm-yyyy'
        });
    });

    $('#reg-no-btn').on('click', function (e) {
        let val = $('#reg-no').val().trim();

        if (val !== '') {
            e.preventDefault();

            // Send ajax to get the details
            $.ajax({
                url: "<?php echo site_url('admin/ajax_get_user') ?>",
                data: {
                    'convo_ajax': true,
                    'regno': val
                },
                type: 'POST',
                success: function (response) {
                    let resp = $.parseJSON(response);

                    if (resp.error) {
                        toastr.error(resp.error, 'Error');
                    }
                    else {
                        $('#regno').val(resp.regno);
                        $('#name').val(resp.name);
                        $('#email').val(resp.email);
                        $('#mobile').val(resp.mobile);
                        $('#pincode').val(resp.pincode);
                        $('#address').val(resp.address);
                        $('#updater-modal').modal({
                           backdrop: 'static',
                           keyboard: false
                        });
                    }
                },
                error: function () {
                    toastr.error('Unable to communicate with the server', 'Fatal');
                },
            });
        }
    });
</script>

<?php include_once 'includes/footer.php';
include_once 'includes/bottom_scripts.php' ?>
