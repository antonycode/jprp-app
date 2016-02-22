<!---->
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: banga-->
<!-- * Date: 23/02/16-->
<!-- * Time: 00:18-->
<!-- */-->

<!--/**-->
<!-- * Created by IntelliJ IDEA.-->
<!-- * User: banga-->
<!-- * Date: 10/09/15-->
<!-- * Time: 13:57-->
<!-- */-->

<link rel="stylesheet" href="<?php echo base_url(); ?>/style/js/jquery-ui.css" xmlns="http://www.w3.org/1999/html">
<!-- Alert Css AND JS -->
<link href="<?php echo base_url() ?>style/alert/alerts.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>style/alert/theme.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>style/alert/theme.min.css" rel="stylesheet" type="text/css"/>


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        UserGroup: <?php echo $this->session->userdata('groupname')?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Userroles</a></li>
        <li class="active">Userrole List</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">User Roles</h3>
                <?php if (true) {
                    echo '<h1 id="message" style="float: left; margin-left: 15%; margin-top: 0.2%; font-size: 18px; color: green">' . $error_message . '</h1>';
                } ?>
                <?php if (true) {
                    echo '<a href="' . base_url('user_manager/add_userrole') . '" class="btn btn-primary btn-sm" style="float: right; margin-right: 10%; margin-top: 0.2%; font-size: 14px; color: white">Add User Role</a>';
                } ?>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="userrole_table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width:10%">#</th>
                        <th style="width:20%">Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($userroles != '') {
                        $i = 1;
                        foreach ($userroles as $row) {

                            echo "<tr class='grade_tr' data-id='" . $row->attributionroleid . ">";
                            echo "<td>$i</td>";
                            echo "<td>$row->rolename</td>";
                            $i++;
                        }
                    }

                    ?>
                    </tbody>

                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</section>
<!-- /.content -->


<!-- page script -->


<!-- jQuery 2.0.2 -->
<script src="<?php echo base_url() ?>js/jquery.min.js"></script>
<!-- Bootstrap -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/style/bootstrap-dialog/css/base.css" type="text/css">
<script src="<?php echo base_url() ?>style/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/style/bootstrap-dialog/js/jquery-impromptu.js"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo base_url() ?>style/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>style/js/plugins/datatables/dataTables.bootstrap.js"
        type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>style/js/AdminLTE/app.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>style/js/AdminLTE/demo.js" type="text/javascript"></script>
<!-- page script -->


<script type="text/javascript">
    $(function () {
        $('#userrole_table').dataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true
        });
    });
</script>



<!-- Pop over Class -->

<style type="text/css">

    /*table{
        -moz-user-select: none;
    }
    */
    .contextMenu {
        position: absolute;
        font-size: 9pt;
        color: #000;
        border: 1px solid #ddd;
        padding-left: 4px;
        padding-right: 4px;
        width: 60px;
        max-height: 400px;
        overflow-y: auto;
        background-color: #f7f7f7;
        display: none;
        z-index: 9;
        filter: alpha(opacity=98);
        opacity: 0.98;
        border-bottom-left-radius: 3px;
        border-bottom-right-radius: 3px;
        box-shadow: #ccc 0 1px 1px 0;
    }

    .contextMenuItemActive {
        background-color: #246BA1 !important;
        color: #fff !important;
    }

</style>


<div id="contextMenuID" class="contextMenu" style="width: 200px; display:block;">
    <button type="button" class="close" id="btn-dismiss" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <br/>
    <ul class="" style="list-style-type:none">
        <?php
        echo '<li class=""><a href="#" id="view"><i class="fa fa-plus"></i> View</a></li> <br>';
        if (true) {
            echo '<li class=""><a href="#" id="edit"><i class="fa fa-edit"></i> Update</a></li> <br>';
        };
        if (true) {
            echo '<li class=""><a href="#" id="remove" onclick=""><i class="fa fa-trash-o"></i> Remove</a></li> <br>';
        };
        ?>
    </ul>
</div>

<!-- Show Details pop up -->
<script type="text/javascript">
    // Hide error/Success message after 10 seconds
    $(window).load(function () {
        setTimeout(function () {
            $('#message').fadeOut('fast');
        }, 2000);
    });


</script>

<!--  -->
<script>
    $(document).ready(function () {
        $("#contextMenuID").hide();
        $('#programs-table').DataTable();


        $('body').delegate('#agency_table .grade_tr', 'click', function (event) {


            var menuHeight = $('.contextMenu').height();
            var menuWidth = $('.contextMenu').width();
            var winHeight = $(window).height();
            var winWidth = $(window).width();

            var pageX = event.pageX;
            var pageY = event.pageY;

            if ((menuWidth + pageX) > winWidth) {
                pageX -= menuWidth;
            }

            if ((menuHeight + pageY) > winHeight) {
                pageY -= menuHeight;

                if (pageY < 0) {
                    pageY = event.pageY;
                }
            }

            var mouseCoordinates = {
                x: pageX,
                y: pageY
            };


            $("#contextMenuID").show();
            $("#contextMenuID").css({"top": mouseCoordinates.y, "left": mouseCoordinates.x});

            $("tbody tr").removeClass("alert alert-success");
            $(this).addClass("alert alert-success");

            var id = $(this).closest('tr').data('id');
            var name = $(this).closest('tr').data('name');

            // Actions
            document.getElementById("view").href = "<?php echo base_url();?>" + "development_partners/view_agency/" + id;
            document.getElementById("edit").href = "<?php echo base_url();?>" + "development_partners/update_agency/" + id;
            document.getElementById("remove").setAttribute('onclick', "removeAgency('" + id + "','" + name + "')");
            document.getElementById("showdetails").setAttribute('onclick', "showAgencyDetails('" + id + "')");

        });

        $("#btn-dismiss, thead, tfoot").click(function () {

            $("#contextMenuID").hide(100);
            $("tr").removeClass("alert alert-success");

        })

    });

</script>


<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo base_url() ?>js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php echo base_url() ?>js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo base_url() ?>js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo base_url() ?>js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="<?php echo base_url() ?>js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="<?php echo base_url() ?>js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo base_url() ?>js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="<?php echo base_url() ?>js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->

