<!--/**-->
<!-- * Created by IntelliJ IDEA.-->
<!-- * User: banga-->
<!-- * Date: 12/02/16-->
<!-- * Time: 09:04-->
<!-- */-->

<link rel="stylesheet" href="<?php echo base_url(); ?>/style/js/jquery-ui.css">

<script src="<?php echo base_url(); ?>/style/js/jquery-1.11.3.min.js"></script>


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        User Management
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">User Management</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content" style="background: #ffffff; height: 100%">
    <div class="row">
        <!-- /.box-header -->
        <div class="container">
            <div class="row">

                <div class="col-md-6 item-user" style="margin-left: -10%;margin-top: 5%;">

                    <a href="<?php echo base_url('user_management/user_roles') ?>">
                        <div class="col-md-2">
                            <i class="fa fa-wrench fa-5x"></i>
                        </div>
                        <div>
                            <div>
                                <span style="font-size: 15px" class="label label-success">User Roles</span>
                            </div>
                            <div>
                                <span style="color:#000">
                                    Create, modify and view all user roles. A user role has a set of authorities within a system.
                                </span>
                            </div>
                        </div>

                    </a>

                </div>

                <div class="col-md-6  item-user" style="margin-left: 10%;margin-top: 5%;">
                    <a href="<?php echo base_url('user_manager/user_list') ?>">
                        <div class="col-md-2">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div>
                            <div>
                                <span style="font-size: 15px" class="label label-success">Users</span>
                            </div>

                            <div>
                            <span style="color:#000">
                                Create, modify and view all users. A user is associated with user roles.
                            </span>
                            </div>

                        </div>
                    </a>
                </div>
            </div>
            <br/>

            <?php
            if ($associatesmanagement) {
             	echo '
            	
            <div class="row">
                <div class="col-md-6 item-user" style="margin-left: -10%; margin-top: 5%;">
                    <a href="';
                    echo base_url('user_manager/associates_list');
                        echo '"><div class="col-md-2">
                            <i class="fa fa-users fa-5x"></i>
                        </div>

                        <div>
                            <div>
                                <span style="font-size: 15px" class="label label-success">Associates</span>
                            </div>
                            <div>
                            <span style="color:#000">
                                Modify and view all Associates.
                            </span>
                            </div>

                        </div>
                    </a>
                </div>
            </div>            	
            	
            	
            	';               
            }
            ?>

        </div>
        <!-- /.box-body -->
    </div>
    </div>

</section><!-- /.content -->
<script>
    $(".item-user").hover(function () {
        $(this).toggleClass("well");
    });
</script>


<link rel="stylesheet" href="<?php echo base_url(); ?>/style/bootstrap-dialog/css/base.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url(); ?>/style/bootstrap-dialog/js/jquery-impromptu.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>/style/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo base_url(); ?>/style/js/plugins/datatables/jquery.dataTables.js"
        type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/style/js/plugins/datatables/dataTables.bootstrap.js"
        type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>/style/js/AdminLTE/app.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>/style/js/AdminLTE/demo.js" type="text/javascript"></script>




