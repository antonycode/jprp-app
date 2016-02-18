        <link rel="stylesheet" href="http://localhost/bloodbank/style/date/css/default.css" type="text/css">
        <script type="text/javascript" src="http://localhost/bloodbank/style/date/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="http://localhost/bloodbank/style/date/js/zebra_datepicker.js"></script>
        <script type="text/javascript" src="http://localhost/bloodbank/style/date/js/core.js"></script>
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
                $("#county").dataTable();
                $("#donations").dataTable();
                $("#county_donations").dataTable();
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