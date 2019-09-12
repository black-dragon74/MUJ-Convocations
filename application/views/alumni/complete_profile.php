<?php include_once 'includes/top_scripts.php'; include_once 'includes/top_side_nav.php'; ?>
<?php $currentUser = $this->db->get_where('alumni', array('regno' => $regno))->row(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Complete your profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('alumni') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Row 1 -->
        <div class="row">
            <div class="col-xs-12">
                <div class="callout callout-warning">
                    <h4><i class="fa fa-warning margin-r-5"></i>Warning</h4>
                    <h4>
                        You have not completed your profile yet. Please complete it to proceed further.
                    </h4>
                </div>
            </div>
        </div>

        <!--Row 2-->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h4 class="box-title">
                            Please fill the details below
                        </h4>
                    </div>
                    <div class="box-body">
                        <form action="<?php echo site_url('alumni/setup_profile')?>" class="form-horizontal" method="post" autocomplete="off">
                            <!-- Row 1 -->
                            <div class="form-group">
                                <div class="col-md-5 col-md-offset-1">
                                    <label for="alumni-name" class="control-label">Name</label>
                                    <input type="text" class="form-control" value="<?php echo $currentUser->name ?>" disabled>
                                    <input type="hidden" class="form-control" name="alumni-name" value="<?php echo $currentUser->name ?>">
                                </div>
                                <div class="col-md-5">
                                    <label for="alumni-reg-no" class="control-label">Registration No</label>
                                    <input type="text" class="form-control"  value="<?php echo $currentUser->regno ?>" disabled>
                                    <input type="hidden" class="form-control" name="alumni-regno"  value="<?php echo $currentUser->regno ?>">
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
                                    <label for="alumni-mobile" class="control-label">Mobile</label>
                                    <input type="text" maxlength="10" minlength="10" pattern="\d*" class="form-control" value="<?php echo $currentUser->mobile ? $currentUser->mobile : 'NA' ?>" name="alumni-mobile" disabled>
                                    <small>Please do not add country code in the input field</small>
                                </div>
                            </div>

                            <!-- Row 4 -->
                            <div class="form-group">
                                <div class="col-md-5 col-md-offset-1">
                                    <label for="alumni-email" class="control-label">Email</label>
                                    <input type="email" class="form-control" name="alumni-email" value="<?php echo $currentUser->email ?>" disabled>
                                    <input type="hidden" class="form-control" name="alumni-email" value="<?php echo $currentUser->email ?>">
                                </div>
                                <div class="col-md-5">
                                    <label for="alumni-alt-mobile" class="control-label">Alternate Mobile</label>
                                    <input type="text" maxlength="10" minlength="10" pattern="\d*" class="form-control" name="alumni-alt-mobile">
                                    <small>Please do not add country code in the input field</small>
                                </div>
                            </div>

                            <!-- Row 5 -->
                            <div class="form-group">
                                <div class="col-md-5 col-md-offset-1">
                                    <label for="alumni-linkedin" class="control-label">Linkedin</label>
                                    <input type="text" class="form-control" name="alumni-linkedin">
                                </div>
                                <div class="col-md-5">
                                    <label for="alumni-facebook" class="control-label">Facebook</label>
                                    <input type="text" class="form-control" name="alumni-facebook">

                                </div>
                            </div>

                            <!-- Row 6 -->
                            <div class="form-group">
                                <div class="col-md-5 col-md-offset-1">
                                    <label for="alumni-instagram" class="control-label">Instagram</label>
                                    <input type="text" class="form-control" name="alumni-instagram">
                                </div>
                                <div class="col-md-5">
                                    <label for="alumni-current-state">You are currently</label>
                                    <select class="form-control" name="alumni-current-state" id="alumni-current-state" required>
                                        <option value="">-- Select --</option>
                                        <option value="employed">Employed in a job</option>
                                        <option value="higher">Pursuing Higher Studies</option>
                                        <option value="business">Doing Business</option>
                                        <option value="other">Others</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Row 8 -->
                            <div class="form-group hidden" id="aux-container">
                                <div class="col-md-4 col-md-offset-1">
                                    <label for="aux1" id="aux1label">Name of Employer</label>
                                    <input type="text" name="aux1" class="form-control">
                                </div>

                                <div class="col-md-3">
                                    <label for="aux2" id="aux2label">City</label>
                                    <input type="text" name="aux2" class="form-control">
                                </div>

                                <div class="col-md-3">
                                    <label for="aux3" id="aux3label">Designation</label>
                                    <input type="text" name="aux3" class="form-control">
                                </div>
                            </div>

                            <hr>
                            <!-- Event day and date selectors -->
                            <h4 class="box-title">
                                How would you like to attend?
                            </h4>

                            <br>
                            <div class="col-xs-12">
                                <div class="callout callout-danger">
                                    <h4 class="no-padding no-margin">
                                        Please fill the choices very carefully. Choices once filled cannot be changed again.
                                    </h4>
                                </div>
                            </div>

                            <!-- Row 1, full width -->
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
                                    <label for="alumni-formtype" class="control-label">I would like to</label>
                                    <select name="alumni-formtype" class="form-control" id="alumni-formtype" required>
                                        <option value="">-- SELECT --</option>
                                        <option value="0">Attend the convocation ceremony</option>
                                        <option value="1">Get certificates via post</option>
                                    </select>
                                    <small>Make sure you provide a valid postal address in case you opt for delivery via post.</small>
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="form-group">
                                <div class="col-md-5 col-md-offset-1">
                                    <label for="alumni-attend-day" class="control-label">Select Attending Day</label>
                                    <select name="alumni-attend-day" class="form-control" id="alumni-attend-day" disabled>
                                        <option value="">-- SELECT --</option>
                                        <?php
                                        if (isset($events)) {
                                            foreach ($events as $event) {
                                                echo '<option value="'. $event["value"] .'">'. $event["name"] .' ( '.$event["value"].')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="alumni-parents" class="control-label">Accompained by parents</label>
                                    <select name="alumni-parents" class="form-control" id="alumni-parents" disabled>
                                        <option value="">-- SELECT --</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Address box -->
                            <div class="form-group hidden" id="alumni-address-box">
                                <div class="col-md-10 col-md-offset-1">
                                    <label for="" class="control-label">Postal Address</label>
                                    <textarea rows="5" name="alumni-address" id="alumni-address-text" class="form-control"><?php echo $currentUser->address ?></textarea>
                                </div>

                                <div class="col-md-10 col-md-offset-1">
                                    <label for="alumni-pincode" class="control-label">Pincode</label>
                                    <input type="text" class="form-control" name="alumni-pincode" id="alumni-pincode">
                                </div>
                            </div>

                            <br>
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-5">
                                    <input type="submit" value="Update Profile" class="form-control btn btn-success">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $('#alumni-formtype').on('change', function () {
        const result = $('#alumni-formtype').val();
        if (result === '1') { // Send via post
            // Show the address box and make it required
            $('#alumni-address-box').removeClass('hidden');
            $('#alumni-address-text').prop('required', true);
            $('#alumni-pincode').prop('required', true);

            // Disable the attending day and parents option
            $('#alumni-attend-day').prop({
                disabled: true,
                required: false
            });
            $('#alumni-parents').prop({
                disabled: true,
                required: false
            });
        }
        else if (result === '0') {
            $('#alumni-address-box').addClass('hidden');
            $('#alumni-address-text').prop('required', false);
            $('#alumni-pincode').prop('required', false);

            // Enable the attending day and parents option
            $('#alumni-attend-day').prop({
                disabled: false,
                required: true
            });
            $('#alumni-parents').prop({
                disabled: false,
                required: true
            });
        }
        else {
            $('#alumni-address-box').addClass('hidden');
            // Disable the attending day and parents option
            $('#alumni-attend-day').prop({
                disabled: true,
                required: false
            });
            $('#alumni-parents').prop({
                disabled: true,
                required: false
            });
        }
    });

    $('#alumni-current-state').on('change', function() {
        let auxContainer = '#aux-container';
        let aux1 = '#aux1label';
        let aux2 = '#aux2label';
        let aux3 = '#aux3label';

        let response = $('#alumni-current-state').val();
        switch (response) {
            case 'employed':
                $(auxContainer).removeClass('hidden');
                $(aux1).text('Employer Name');
                $(aux2).text('City');
                $(aux3).text('Designation');
                break;
            case 'higher':
                $(auxContainer).removeClass('hidden');
                $(aux1).text('Name of University');
                $(aux2).text('City');
                $(aux3).text('Programme Joined');
                break;
            case 'business':
                $(auxContainer).removeClass('hidden');
                $(aux1).text('Name of firm');
                $(aux2).text('City');
                $(aux3).text('Type of firm');
                break;
            default:
                $(auxContainer).addClass('hidden');
                $(aux1).text('');
                $(aux2).text('');
                $(aux3).text('');
                break;
        }
    });
</script>
<?php include_once 'includes/footer.php';
include_once 'includes/bottom_scripts.php' ?>
