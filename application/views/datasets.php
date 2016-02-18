
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Datasets
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Datasets</a></li>
                        <li class="active">Datasets</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Datasets Table</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Dataset ID</th>
                                            <th>Dataset UID</th>
                                            <th>Dataset Name</th>
                                            <th>Dataset Description</th>
                                            <th>Last Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($datasets as $row ) {
                                                echo "<tr>";
                                                echo "<td>$row->datasetid</td>";
                                                echo "<td>$row->uid</td>";
                                                echo "<td>$row->name</td>";
                                                echo "<td>$row->description</td>";
                                                echo "<td>$row->lastupdated</td>";
                                                echo "</tr>";
                                            }
                                        
                                        ?>
                                    </tbody>
    
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
 

        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url(); ?>/style/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="<?php echo base_url(); ?>/style/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>/style/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url(); ?>/style/js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url(); ?>/style/js/AdminLTE/demo.js" type="text/javascript"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
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

