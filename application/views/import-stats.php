<?php
/**
 * Created by PhpStorm.
 * User: the_fegati
 * Date: 9/7/15
 * Time: 1:57 PM
 */
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data Import Statistics
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Import</a></li>
        <li class="active">Data Import</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Dataset</th>
                        <th>Dataelements Fetched(Total for all orgUnits)</th>
                        <th>Successfully Imported</th>
                        <th>Blank Values</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $temp = (json_decode(json_encode($stats)));

                    foreach ($temp as $row) {
                        echo "<tr>";
                        echo "<td>$row->dataset</td>";
                        echo "<td>$row->fetched</td>";
                        echo "<td>$row->success</td>";
                        echo "<td>$row->blank</td>";
                        echo "</tr>";
                    }

                    ?>
                    </tbody>

                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    </div>

</section><!-- /.content -->


<!-- jQuery 2.0.2 -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
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
<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>

