<?php include_once 'includes/top_scripts.php'; include_once 'includes/top_side_nav.php'; ?>
<?php $currentUser = $this->db->get_where('alumni', array('regno' => $regno))->row(); ?>
<script>
    $('ul > li:nth-child(5)').addClass("active");
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Invoice
            <small><?php echo $orderID ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('alumni') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Print Invoice</li>
        </ol>
    </section>

    <div class="pad margin no-print">
        <div class="callout callout-success" style="margin-bottom: 0!important;">
           <h4 style="margin: 0;">
               Your payment is complete. Here is your invoice for further reference.
           </h4>
        </div>
    </div>

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <img src="<?php echo base_url('assets/img/logo.jpeg') ?>" alt="Manipal University" height="45" />
                    <small class="pull-right">Invoice Date: <?php echo $paymentDate ?></small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                    <strong>Manipal University</strong><br>
                    Jaipur-Ajmer Expressway,<br>
                    Dehmi Kalan, Rajasthan, 303007<br>
                    Phone: +91-141-3999100
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                To
                <address>
                    <strong><?php echo $currentUser->name ?></strong><br>
                    <?php echo $currentUser->address ?><br>
                    Phone: <?php echo $currentUser->mobile ?><br>
                    Email: <?php echo $currentUser->email ?>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Txn ID: </b><?php echo $txnID?><br>
                <br>
                <b>Order ID:</b> <?php echo $orderID ?><br>
                <b>Pay Mode:</b> PayTM
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Serial #</th>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Convocation Fee</td>
                        <td><?php echo $paymentDesc ?></td>
                        <td>₹<?php echo $paymentAmount ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6 overflow-hidden">
                <p class="lead">Payment Methods:</p>
                <img src="<?php echo base_url('assets/img/paytm_logo.png') ?>" alt="PayTM" class="margin-r-5">
                <img src="<?php echo base_url('assets/img/secured_seals.png') ?>" alt="PayTM">

                <p class="text-muted well well-sm no-shadow" style="margin-top: 20px !important;">
                    Your payments are carried out securely by <b>One97 Communications Limited</b>
                </p>
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <p class="lead">Amount Breakup:</p>

                <div class="table-responsive">
                    <table class="table">
                        <tbody><tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>₹<?php echo $paymentAmount ?></td>
                        </tr>
                        <tr>
                            <th>Tax (0.0%)</th>
                            <td>₹0.00</td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td>₹0.00</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>₹<?php echo $paymentAmount ?></td>
                        </tr>
                        </tbody></table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="#" target="_blank" class="btn btn-instagram pull-right" id="printnow"><i class="fa fa-print margin-r-5"></i> Print Invoice</a>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>
</div>
<script>
    $('#printnow').on('click', function (e) {
        e.preventDefault();
        window.print();
    });
</script>
<?php include_once 'includes/footer.php';
include_once 'includes/bottom_scripts.php' ?>
