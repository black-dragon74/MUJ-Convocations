<?php include_once 'includes/top_scripts.php'; include_once 'includes/top_side_nav.php'; ?>
<?php $currentUser = $this->db->get_where('alumni', array('regno' => $regno))->row(); ?>
<script>
    $('ul > li:nth-child(6)').addClass("active");
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Account Settings
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('alumni') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Account Settings</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Row 1 -->
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Profile Details</a></li>
                        <li><a href="#password" data-toggle="tab" aria-expanded="true">Password</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- First Tab for basic info update -->
                        <div class="tab-pane active" id="settings">
                            <div class="row">
                                <div class="col-xs-12">
                                    <p class="text-danger text-center text-bold">
                                        Note: If you need to change other details, contact your branch HoD
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <form action="<?php echo site_url('alumni/update_profile')?>" class="form-horizontal" method="post" autocomplete="off">
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
                                            <div class="col-md-5 col-md-offset-1">
                                                <label for="alumni-email" class="control-label">Email</label>
                                                <input type="email" class="form-control" name="alumni-email" value="<?php echo $currentUser->email ?>" disabled>
                                                <input type="hidden" class="form-control" name="alumni-email" value="<?php echo $currentUser->email ?>">
                                            </div>
                                            <div class="col-md-5">
                                                <label for="alumni-alt-mobile" class="control-label">Alternate Mobile</label>
                                                <input type="text" maxlength="10" minlength="10" pattern="\d*" class="form-control" name="alumni-alt-mobile" value="<?php echo $currentUser->alt_mobile ?>">
                                                <small>Please do not add country code in the input field</small>
                                            </div>
                                        </div>

                                        <!-- Address Box -->
                                        <div class="form-group">
                                            <div class="col-md-10 col-md-offset-1">
                                                <label for="alumni-address">Postal Address</label>
                                                <textarea name="alumni-address" rows="5" class="form-control"><?php echo $currentUser->address ?></textarea>
                                            </div>
                                        </div>

                                        <!-- Row 3 -->
                                        <div class="form-group">
                                            <div class="col-md-5 col-md-offset-1">
                                                <label for="alumni-linkedin" class="control-label">Linkedin</label>
                                                <input type="text" class="form-control" name="alumni-linkedin" value="<?php echo $currentUser->linkedin ?>">
                                            </div>
                                            <div class="col-md-5">
                                                <label for="alumni-facebook" class="control-label">Facebook</label>
                                                <input type="text" class="form-control" name="alumni-facebook" value="<?php echo $currentUser->facebook ?>">

                                            </div>
                                        </div>

                                        <!-- Row 4 -->
                                        <div class="form-group">
                                            <div class="col-md-5 col-md-offset-1">
                                                <label for="alumni-instagram" class="control-label">Instagram</label>
                                                <input type="text" class="form-control" name="alumni-instagram"  value="<?php echo $currentUser->instagram ?>">
                                            </div>
                                            <div class="col-md-5">
                                                <label for="alumni-pincode" class="control-label">Pincode</label>
                                                <input type="text" class="form-control" name="alumni-pincode" value="<?php echo $currentUser->pincode ?>">

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

                        <!-- Second tab for password -->
                        <div class="tab-pane" id="password">
                            <form class="form-horizontal" autocomplete="off" method="post" action="<?php echo site_url('alumni/update_password')?>">
                                <div class="form-group">
                                    <label for="current-password" class="col-sm-2 control-label">Current Password</label>

                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" required="required" name="current-password" placeholder="Current Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="new-password" class="col-sm-2 control-label">New Password</label>

                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" required="required" name="new-password" id="new-password" placeholder="New Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="re-password" class="col-sm-2 control-label">Retype New Password</label>

                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" required="required" name="re-password" id="re-password" placeholder="Retype Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="submit" class="btn btn-success" name="submit" id="update-password" value="Update Password">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include_once 'includes/footer.php';
include_once 'includes/bottom_scripts.php' ?>