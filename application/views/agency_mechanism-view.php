
<!--/**-->
<!-- * Created by IntelliJ IDEA.-->
<!-- * User: banga-->
<!-- * Date: 10/09/15-->
<!-- * Time: 19:01-->
<!-- */-->

<link rel="stylesheet" href="<?php echo base_url(); ?>/style/js/jquery-ui.css">

<script src="<?php echo base_url(); ?>/style/js/jquery-1.10.2.js"></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
<script src="<?php echo base_url(); ?>/style/js/jquery-ui.js"></script>
<style type="text/css">
    .donor_form ul {
        width: 750px;
        list-style-type: none;
        list-style-position: outside;
        margin: 0px;
        padding: 0px;
    }

    .donor_form li {
        padding: 12px;
        position: relative;
        margin-left: 10%;
    }

    .donor_form li:first-child, .donor_form li:last-child {
        border-bottom: 0px solid #777;
    }

    /* === Form Header === */
    .donor_form h2 {
        margin: 0;
        display: inline;
    }

    .required_notification {
        color: #d45252;
        margin: 5px 0 0 0;
        display: inline;
        float: right;
    }

    /* === Form Elements === */
    .donor_form label {
        width: 150px;
        margin-top: 3px;
        display: inline-block;
        float: left;
        padding: 3px;
    }

    .donor_form input, .donor_form select {
        height: 30px;
        width: 240px;
        padding: 5px 8px;
    }

    .donor_form textarea {
        padding: 8px;
        width: 300px;
    }

    .donor_form button {
        margin-left: 156px;
    }

    /* form element visual styles */
    .donor_form select, .donor_form input {
        border: 0px solid #aaa;
        box-shadow: 0px 0px 3px #fff, 0 10px 15px #fff inset;
        border-radius: 0px;
        padding-right: 30px;
        -moz-transition: padding .25s;
        -webkit-transition: padding .25s;
        -o-transition: padding .25s;
        transition: padding .25s;
    }

    .donor_form textarea {
        border: 1px solid #aaa;
        box-shadow: 0px 0px 3px #ccc, 0 10px 15px #eee inset;
        border-radius: 2px;
        padding-right: 30px;
        -moz-transition: padding .25s;
        -webkit-transition: padding .25s;
        -o-transition: padding .25s;
        transition: padding .25s;
    }

    .donor_form select:focus, input:focus, .donor_form textarea:focus {
        background: #fff;
        border: 1px solid #555;
        box-shadow: 0 0 3px #aaa;
        padding-right: 70px;
    }

    /* === HTML5 validation styles === */
    .donor_form select:required, input:required, .donor_form textarea:required {
        background: #fff url(images/red_asterisk.png) no-repeat 98% center;
    }

    .donor_form select:required:valid, input:required:valid, .donor_form textarea:required:valid {
        background: #fff url(images/valid.png) no-repeat 98% center;
        box-shadow: 0 0 5px #5cd053;
        border-color: #28921f;
    }

    .donor_form select:focus:invalid, input:focus:invalid, .donor_form textarea:focus:invalid {
        background: #fff url(images/invalid.png) no-repeat 98% center;
        box-shadow: 0 0 5px #d45252;
        border-color: #b03535
    }

    /* === Form hints === */
    .form_hint {
        background: #d45252;
        border-radius: 3px 3px 3px 3px;
        color: white;
        margin-left: 8px;
        padding: 1px 6px;
        z-index: 999; /* hints stay above all other elements */
        position: absolute; /* allows proper formatting if hint is two lines */
        display: none;
    }

    .form_hint::before {
        content: "\25C0";
        color: #d45252;
        position: absolute;
        top: 1px;
        left: -6px;
    }

    .donor_form input:focus + .form_hint {
        display: inline;
    }

    .donor_form select:focus + .form_hint {
        display: inline;
    }

    .donor_form input:required:valid + .form_hint {
        background: #28921f;
    }

    .donor_form select:required:valid + .form_hint {
        background: #28921f;
    }

    .donor_form input:required:valid + .form_hint::before {
        color: #28921f;
    }

    .donor_form select:required:valid + .form_hint::before {
        color: #28921f;
    }

    /* === Button Style === */
    button.submit {
        background-color: #68b12f;
        background: -webkit-gradient(linear, left top, left bottom, from(#68b12f), to(#50911e));
        background: -webkit-linear-gradient(top, #68b12f, #50911e);
        background: -moz-linear-gradient(top, #68b12f, #50911e);
        background: -ms-linear-gradient(top, #68b12f, #50911e);
        background: -o-linear-gradient(top, #68b12f, #50911e);
        background: linear-gradient(top, #68b12f, #50911e);
        border: 1px solid #509111;
        border-bottom: 1px solid #5b992b;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -ms-border-radius: 3px;
        -o-border-radius: 3px;
        box-shadow: inset 0 1px 0 0 #9fd574;
        -webkit-box-shadow: 0 1px 0 0 #9fd574 inset;
        -moz-box-shadow: 0 1px 0 0 #9fd574 inset;
        -ms-box-shadow: 0 1px 0 0 #9fd574 inset;
        -o-box-shadow: 0 1px 0 0 #9fd574 inset;
        color: white;
        font-weight: bold;
        padding: 6px 20px;
        text-align: center;
        text-shadow: 0 -1px 0 #396715;
    }

    button.submit:hover {
        opacity: .85;
        cursor: pointer;
    }

    button.submit:active {
        border: 1px solid #20911e;
        box-shadow: 0 0 10px 5px #356b0b inset;
        -webkit-box-shadow: 0 0 10px 5px #356b0b inset;
        -moz-box-shadow: 0 0 10px 5px #356b0b inset;
        -ms-box-shadow: 0 0 10px 5px #356b0b inset;
        -o-box-shadow: 0 0 10px 5px #356b0b inset;

    }

    div.dataTables_filter input {
        height: 30px;
        width: 17em;
    }
</style>

<style>

    .donor_form SELECT {
        width: 200px;
        height: 200px;
        box-sizing: border-box;
        overflow-y: auto;
        overflow-x: auto;
    }

    .donor_form INPUT[type="text"] {
        width: 220px;
        box-sizing: border-box;
    }

    .donor_form SECTION {
        padding: 8px;
        overflow: auto;
    }

    .donor_form SECTION > DIV {
        width: 600px;
        float: left;
        padding: 4px;
    }

    .donor_form SECTION > DIV + DIV {
        width: 400px;
        text-align: center;
    }
</style>

<div id="results"></div>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $mechanism_details->name; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Agency</a></li>
        <li class="active">View Implementing Mechanism Details</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"> <?php echo $mechanism_details->name; ?> : Programs </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="programs-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width:30%">Program Name</th>
                        <th style="width:50%">Program Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($program != false) {
                        foreach ($program as $row) {
                            echo "<tr>";
                            echo "<td>$row->program_name</td>";
                            echo "<td>$row->program_description</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    </tbody>

                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"> <?php echo $mechanism_details->name; ?> : Facilities</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="support-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width:20%">Organization Unit</th>
                        <th style="width:10%">Program Name</th>
                        <th style="width:10%">Support Type</th>
                        <th style="width:10%">Period</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($support != '') {
                        $i = 1;
                        foreach ($support as $row) {
                            echo "<tr class='grade_tr' data-id='" . $row->hierarchy_uid . "' data-name='" . $row->mechanism_name . "' data-org='".$row->organization_name."'>";
                            echo "<td>$row->organization_name</td>";
                            echo "<td>$row->program_name</td>";
                            echo "<td>$row->support_type</td>";
                            echo "<td>$row->period</td>";
                            $i++;
                        }
                    }


                    ?>
                    </tbody>

                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</section>


<script type="text/javascript">
    $(function () {
        $('#programs-table').dataTable({});
        $('#support-table').dataTable({});
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
        if ($program_right) {
            echo '<li class=""><a href="#" id="description"><i class="fa fa-info-circle"></i> Show details</a></li>';
        };
        ?>
    </ul>
</div>


<!--  -->
<script>

    $(document).ready(function () {
        $("#contextMenuID").hide();
        $('#agencies-table').DataTable();


        $('body').delegate('#mechanism-table .grade_tr', 'click', function (event) {


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

            document.getElementById("view").href = "<?php echo base_url();?>" + "moh_manager/agencyview/" + uid;
            document.getElementById("description").setAttribute('onclick', "show_program_details('" + id + "')");

        });

        $("#btn-dismiss, thead, tfoot").click(function () {

            $("#contextMenuID").hide(100);
            $("tr").removeClass("alert alert-success");

        })

    });

</script>
