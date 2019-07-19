<?php include_once 'includes/top_scripts.php';
include_once 'includes/top_side_nav.php';
$homeContent = $this->db->get_where('html_content', array('name' => 'home'))->row()->content;
$guidelinesContent = $this->db->get_where('html_content', array('name' => 'guidelines'))->row()->content;
$instructionsContent = $this->db->get_where('html_content', array('name' => 'instructions'))->row()->content;
$contactContent = $this->db->get_where('html_content', array('name' => 'contact'))->row()->content;
//END?>
<script>
    $('ul > li:nth-child(3)').addClass("active");
</script>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Edit Frontend
            <small>content</small>
        </h1>
    </section>

    <section class="content">
        <!-- Home page content editor -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-header">
                        <h4 class="box-title">
                            Edit home page content
                        </h4>
                    </div>

                    <div class="box-body">
                        <form action="<?php echo site_url('admin/update_home') ?>" class="form-horizontal" method="post">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <textarea name="home" id="home_editor" cols="30" rows="10" class="form-control">
                                        <?php echo $homeContent ?>
                                    </textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="submit" class="btn btn-success" value="Update Home Page">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guidelines page content editor -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h4 class="box-title">
                            Edit guidelines page content
                        </h4>
                    </div>

                    <div class="box-body">
                        <form action="<?php echo site_url('admin/update_guidelines') ?>" class="form-horizontal" method="post">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <textarea name="guidelines" id="guidelines_editor" cols="30" rows="10" class="form-control">
                                        <?php echo $guidelinesContent ?>
                                    </textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="submit" class="btn btn-warning" value="Update Guidelines Page">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instructions page content editor -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h4 class="box-title">
                            Edit instructions page content
                        </h4>
                    </div>

                    <div class="box-body">
                        <form action="<?php echo site_url('admin/update_instructions') ?>" class="form-horizontal" method="post">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <textarea name="instructions" id="notifications_editor" cols="30" rows="10" class="form-control">
                                        <?php echo $instructionsContent ?>
                                    </textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="submit" class="btn btn-danger" value="Update Instructions Page">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact page content editor -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h4 class="box-title">
                            Edit contact page content
                        </h4>
                    </div>

                    <div class="box-body">
                        <form action="<?php echo site_url('admin/update_contact') ?>" class="form-horizontal" method="post">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <textarea name="contact" id="contact_editor" cols="30" rows="10" class="form-control">
                                        <?php echo $contactContent ?>
                                    </textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="submit" class="btn btn-info" value="Update Contact Page">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(function () {
        CKEDITOR.replace('home_editor');
        CKEDITOR.replace('guidelines_editor');
        CKEDITOR.replace('notifications_editor');
        CKEDITOR.replace('contact_editor');
    })
</script>
<?php include_once 'includes/footer.php';
include_once 'includes/bottom_scripts.php' ?>
