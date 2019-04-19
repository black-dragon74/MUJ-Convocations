<?php include_once 'includes/top_scripts.php'; include_once 'includes/top_side_nav.php'; ?>
<?php $currentUser = $this->db->get_where('alumni', array('regno' => $regno))->row(); ?>
<script>
    $('ul > li:nth-child(3)').addClass("active");
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Review your details
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('alumni') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Review Details</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Row 1 -->
        <div class="row">
            <div class="col-xs-12">
                <div class="callout callout-danger">
                    <h4><i class="fa fa-info-circle margin-r-5"></i>Note</h4>
                    <h4>
                        The details below cannot be changed as they are already submitted. Contact your branch HoD in case you need any modifications.
                    </h4>
                </div>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-success">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/img/nick.jpg')?>" alt="User profile picture">

                        <h3 class="profile-username text-center"><?php echo $currentUser->name ?></h3>

                        <p class="text-muted text-center"><?php echo $currentUser->regno ?></p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Email</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->email ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Phone</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->mobile ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Program</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->programme ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>School</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->school ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Department</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->department ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>GPA</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->gpa ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>D.O.B</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->dob ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Address</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $currentUser->address ?></span>
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
<?php include_once 'includes/footer.php';
include_once 'includes/bottom_scripts.php' ?>
