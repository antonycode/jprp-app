
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Programs
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Programs</a></li>
                        <li class="active">Programs</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Programs Table</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Program ID</th>
                                            <th>Dataset Name</th>
                                            <th>Program Name</th>
                                            <th>Program Description</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    	    if ($sections!='') {
                                                foreach ($sections as $row ) {
                                                    echo "<tr>";
                                                    echo "<td>$row->sectionid</td>";
                                                    echo "<td>$row->datasetname</td>";
                                                    echo "<td>$row->name</td>";
                                                    echo "<td>$row->description</td>";
                                                    echo "<td>$row->lastupdated</td>";
                                                    echo "<td><a href='/associates/sections/sectionelements/$row->sectionid'/>View</a>&nbsp&nbsp<a href='/associates/sections/sectionimplementation/$row->sectionid' style='color:red'/> Attribute</a>  </td>";
                                                    echo "</tr>";
                                                }  
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
        <script src="<?php echo base_url(); ?>/style/js/jquery.min.js"></script>
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

