<!---->
<!--/**-->
<!-- * Created by IntelliJ IDEA.-->
<!-- * User: banga-->
<!-- * Date: 14/09/15-->
<!-- * Time: 11:36-->
<!-- */-->
<!---->
<!--/**-->
<!-- * Created by IntelliJ IDEA.-->
<!-- * User: banga-->
<!-- * Date: 13/09/15-->
<!-- * Time: 16:45-->
<!-- */-->
<!--/**-->

<link rel="stylesheet" href="<?php echo base_url(); ?>/style/js/jquery-ui.css" xmlns="http://www.w3.org/1999/html">
<!-- Alert Css AND JS -->
<link href="<?php echo base_url() ?>style/alert/alerts.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>style/alert/theme.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>style/alert/theme.min.css" rel="stylesheet" type="text/css"/>


<script>

    function deleteAgency(id, name) {
//        alert(id);
        var temp = {
            state0: {
                title: 'Drop ' + name + '.',
                html: "<p>Do you want to drop " + name + "Mechanism?</p>",
                buttons: {Cancel: false, Yes: true},
                focus: 1,
                submit: function (e, v, m, f) {
                    if (!v)
                        $.prompt.close();
                    else {

                        form_url = "<?php echo base_url('mechanisms/deletemechanism')?>" + "/" + id;
                        //alert(form_url);
                        $.ajax({
                            url: form_url,
                            dataType: 'text',
                            type: 'post',
                            success: function (data, textStatus, jQxhr) {
                                $('#response').html(data);
                                $.prompt.goToState('state1');//go forward
                            },
                            error: function (jqXhr, textStatus, errorThrown) {
                                console.log(errorThrown);
                            }
                        });
                    }
                    return false;
                }
            },
            state1: {
                title: name + ' Removal Confirmation',
                html: '<p id="response"></p>',
                buttons: {Finish: 1},
                focus: 0,
                submit: function (e, v, m, f) {
                    if (v == 1)
                        window.location.reload(true); //Refresh page to reflect the changes
                    else  $.prompt.close();//close dialog
                    return false;
                }
            }
        };

        $.prompt(temp, {
            close: function (e, v, m, f) {
                if (v !== undefined) {
                    window.location.reload(true);
                }
            },
            classes: {
                box: '',
                fade: '',
                prompt: '',
                close: '',
                title: 'lead',
                message: '',
                buttons: '',
                button: 'btn',
                defaultButton: 'btn-primary'
            }
        });


    }


</script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Implementing Mechanism: <?php echo $this->session->userdata('groupname')?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Mechanism</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Programs</h3>
                <?php if ($mechanism_right) {
                    echo '<h1 id="message" style="float: left; margin-left: 15%; margin-top: 0.2%; font-size: 18px; color: green">' . $error_message . '</h1>';
                } ?>
<!--                --><?php //if ($mechanism_right) {
//                    echo '<a href="' . base_url('implementing_mechanism/upload_view') . '" class="btn btn-primary btn-sm" style="float: right; margin-right: 10%; margin-top: 0.2%; font-size: 14px; color: white">Upload IPSL</a>';
//                } ?>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="programs_table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width:10%">#</th>
                        <th style="width:20%">Program Name</th>
                        <th style="width:20%">Program Description </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($programs != '') {
                        $i = 1;
                        foreach ($programs as $row) {

                            echo "<tr class='grade_tr' data-id='" . $row->program_id . "' data-name='" . $row->program_name . "'>";
                            echo "<td>$i</td>";
                            echo "<td>$row->program_name</td>";
                            echo "<td>$row->program_description</td>";
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

    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"> IPSL</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="mechanisms-table" class="table table-bordered table-striped">
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
                            echo "<tr class='grade_tr' data-id='" . $row->id . "' data-name='" . $row->mechanism_name . "' data-org='".$row->organization_name."' data-period='".$row->period."' data-support='".$row->support_type."'>";
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
        $('#programs_table').dataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true
        });
    });
</script>



