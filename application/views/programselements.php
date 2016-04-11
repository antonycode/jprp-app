
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo  ucfirst($programname); ?> Data Elements</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Short Name</th>
                                            <th>Description</th>
                                            <th>Created</th>
                                            <th>Lastupdate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    		foreach ($elements as $row) {
												echo "<tr>";
												echo "<td>$row->id</td>";
												echo "<td>$row->name</td>";
												echo "<td>$row->shortname</td>";
												echo "<td>$row->description</td>";
												echo "<td>$row->created</td>";
												echo "<td>$row->updated</td>";
												echo "</tr>";
											}
                                    	
                                    	?>     
                                    </tbody>
    
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>                       
  

                    <div class="row">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Programs Implementation Table</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="orgunits" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                        	<th>Organization Unit ID</th>
                                        	<th>Organization Unit Name</th>
                                            <th>Implementing Partner</th>
                                            <th>Support Start Date</th>
                                            <th>Support End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    	if ($orgunits!='') {
                                            foreach ($orgunits as $row) {
                                                echo "<tr>";
                                                echo "<td>$row->sourceid</td>";
                                                echo "<td>$row->sourcename</td>";
                                                echo "<td>$row->ipname</td>";
                                                echo "<td>$row->startdate</td>";
                                                echo "<td>$row->enddate</td>";
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
                $("#orgunits").dataTable();
            });
        </script>
