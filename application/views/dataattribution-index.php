<link rel="stylesheet" href="<?php echo base_url(); ?>/style/js/jquery-ui.css">

<script src="<?php echo base_url(); ?>/style/js/jquery-1.11.3.min.js"></script>

<style>
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

<div id="loadScreen" style="display: none;width: 100%; height: 100%; top: 0pt;left: 0pt;">
    <div id="loadScr"
         style="filter: alpha(opacity = 65);  z-index: 9999;border: medium none; margin: 0pt; padding: 0pt; width: 100%; height: 100%; top: 0pt;left: 0pt; background-color: rgb(0, 0, 0); opacity: 0.2; cursor: wait; position: fixed;"></div>
    <div id="loader"
         style="z-index: 10000; position: fixed; padding: 0px; margin: 0px;width: 30%; top: 40%; left: 35%; text-align: center;cursor: wait; ">
        <img src="<?php echo base_url(); ?>/style/loaders/loader.gif" alt="loading"/>
    </div>
</div>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data Attribution : Global IPSL
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Attribution</a></li>
        <li class="active">Data Attribution</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Data Attribution</h3>
                </div>
                <blockquote style="text-height: 14px;">
                    Select Attribution Criteria:
                </blockquote>

                <!-- The file upload form used as target for the file upload widget -->
                <form id="fileupload" method="POST" enctype="multipart/form-data"
                      style="margin-top: -20px; border-left: 5px solid #eee">
                    <!-- Redirect browsers with JavaScript disabled to the origin page -->
                    <noscript><input type="hidden" name="redirect"
                                     value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                    <div class="row fileupload-buttonbar">
                        <div class="col-lg-7" style="margin-left:10px">
                            <button type="button" class="btn btn-primary fileinput-button" onclick="global_attribution()">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>IPSL Data Attribution</span>
                            </button>
                            <button type="reset" class="btn btn-warning cancel" onclick="program_attribution()">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Attribution By Program</span>
                            </button>                            
                            <button type="reset" class="btn btn-warning cancel" onclick="mechanism_attribution()" style="background-color: green; border-color:green">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Attribution By Mechanism</span>
                            </button>
                            <!-- The global file processing state -->
                            <span class="fileupload-process"></span>
                        </div>
                        <!-- The global progress state -->
                        <div class="col-lg-5 fileupload-progress fade">
                            <!-- The global progress bar -->
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0"
                                 aria-valuemax="100">
                                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                            </div>
                            <!-- The extended global progress state -->
                            <div class="progress-extended">&nbsp;</div>
                        </div>
                    </div>
                    <!-- The table listing the files available for upload/download -->
                    <table role="presentation" class="table table-striped">
                        <tbody class="files"></tbody>
                    </table>
                </form>

            </div>

        </div>
    </div>
	
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Implementing Partners Support List </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="dp-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width:25%">Mechanism Name</th>
                        <th style="width:20%">Program</th>
                        <th style="width:12%">Support Type</th>
                        <th style="width:20%">Organization Unit</th>
                         <th style="width:12%">Period</th> 
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($ipsl != '') {
                        foreach ($ipsl as $row) {
                            echo "<tr class='grade_tr' data-id='" . $row->id . "' data-name='" . $row->mechanism_name . "'
                                                    data-stype='" . $row->support_type . "' data-org='" . $row->organization_name . "'>";
                            echo "<td>$row->mechanism_name</td>";
                            echo "<td>$row->program_name</td>";
							echo "<td>$row->support_type</td>";
							echo "<td>$row->organization_name</td>";
							echo "<td>$row->period</td>";
                            echo "</tr>";
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
    </div>

</section><!-- /.content -->


<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#example1").dataTable();
        $('#programs-table').dataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true
        });
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

        if ($program_right) {
            echo '<li class=""><a href="#" id="drop" onclick=""><i class="fa fa-trash-o"></i> Remove</a></li> <br>';
        };
        if ($program_right) {
            echo '<li class=""><a href="#" id="attribute"><i class="fa fa-plus"></i> Attribute</a></li> <br>';
        };
		?>
    </ul>
</div>


<!--  -->
<script>

    $(document).ready(function () {
        $("#contextMenuID").hide();
        $('#dp-table').DataTable();


        $('body').delegate('#dp-table .grade_tr', 'click', function (event) {


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
            var stype = $(this).closest('tr').data('stype');
            var org= $(this).closest('tr').data('org');

            document.getElementById("view").href = "<?php echo base_url();?>" + "moh_manager/devpartnerview/" + id;
            document.getElementById("update").href = "<?php echo base_url();?>" + "moh_manager/devpupdate/" + id;
            document.getElementById("delete").setAttribute('onclick', "programdelete('" +id + "','" + name + "')");
            document.getElementById("description").setAttribute('onclick', "show_program_details('" + id + "')");

        });

        $("#btn-dismiss, thead, tfoot").click(function () {

            $("#contextMenuID").hide(100);
            $("tr").removeClass("alert alert-success");

        })

    });

</script>





<script type="text/javascript">
    
        
			function global_attribution(){
	             var temp = {
	                state0: {
	                    title:'Confirm IPSL Data Attribution',
	                    html:'Do you want to Perfom Data Attribution Using The Implementing Partners Support List?',
	                    buttons: { Cancel: false, YES: true },
	                    focus: 1,
	                    submit:function(e,v,m,f){ 
	                        if(!v)
	                            $.prompt.close();
	                        else { 
	                            
	                            var url_details = "<?php echo base_url('data_attribution/ipsl_attribution')?>";
	                           
	                            $.ajax({ 
	                                url: url_details, 
	                                dataType: 'json', 
	                                type: 'post', 
	                                contentType: 'application/x-www-form-urlencoded', 
	                                beforeSend: function () {
	                                	$('#loadScreen').show();
	                                },
	                                success: function( data, textStatus, jQxhr ){                                 	
	                                    if (data.message == "success") {
	                                    	$('#loadScreen').hide();
	                                         $.prompt.goToState('finalState');
	                                    }
	                                    else{
	                                    	$('#loadScreen').hide();
	                                    	 $.prompt.goToState('errorState');
	                                    }
	                                   
	                                }, 
	                                error: function(jqXhr, textStatus, errorThrown ) {
	                                	$('#loadScreen').hide();
	                                	$.prompt.goToState('errorState');
	                                    //console.log( errorThrown ); 
	                                }
	                            });
	                        }
	                        return false; 
	                    }
	                },
	                errorState: {
	                    title: 'Data Attribution Report',
	                    html:'<p id="response">An Error Occurred During Data Attribution Process Kindly Try Again.</p>',
	                    buttons: {Finish: 1 },
	                    focus: 0,
	                    submit:function(e,v,m,f){
	                        if(v==1)
	                            window.location.reload(true); //Refresh page to reflect the changes
	                        else  $.prompt.close();//close dialog
	                        return false; 
	                    }
	                },
	                finalState: {
	                    title: 'Data Attribution Report',
	                    html:'<p id="response">Data Attribution Was Successful</p>',
	                    buttons: {Finish: 1 },
	                    focus: 0,
	                    submit:function(e,v,m,f){
	                        if(v==1)
	                            window.location.reload(true); //Refresh page to reflect the changes
	                        else  $.prompt.close();//close dialog
	                        return false; 
	                    }
	                }
	            };
	
	            $.prompt(temp,{
	                close: function(e,v,m,f){
	                    if(v !== undefined){
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




			//
			function program_attribution(){
				var url_details = "<?php echo base_url('data_attribution/program_attribution/')?>";
	             var temp = {
	                state0: {
	                    title:'Confirm IPSL Data Attribution',
	                    html:'Do you want to Perfom Data Attribution Using The Implementing Partners Support List?',
	                    buttons: { Cancel: false, YES: true },
	                    focus: 1,
	                    submit:function(e,v,m,f){ 
	                        if(!v)
	                            $.prompt.close();
	                        else { 
                                $('#programForm').html('<form id="edit_support" action="#" method="post">'+                                    
                                "<div class='field'><label for='start_date' style='font-size:1.2em;margin-top:1em;width:8em;'>Program</label><select id='attributionprograms'> \n\
                                <?php if ($programs!='') { foreach ($programs as $row) { echo "<option value='$row->program_id'>$row->program_name</option>"; }}?>  \n\
                                 </select>  </div>"+
                                '</form>');                      	
	                            $.prompt.goToState('state1');
	                        }
	                        return false; 
	                    }
	                },
                state1: {
                    title: '<h4>Select Program For Data Attribution </h4>',
                    html:'<div id="programForm"></div>',
                    buttons: {Cancel: false ,Submit:true },
                    focus: 1,
                    submit:function(e,v,m,f){
                        if(v==false)
                        {
                        	$.prompt.close();
                        }
                        else {
                            $.ajax({
                                url: url_details+"/"+$('#attributionprograms').val(),
                                type: 'POST',
                                dataType: 'json',
                                beforeSend: function () {
                                	$('#loadScreen').show();
                                },                                
                                success: function (data) {
                                	$('#loadScreen').hide();
                                    if(data.message=="success"){
                                    	$.prompt.goToState('finalState');
                                    }else{
                                    	$.prompt.goToState('errorState');
                                    }
                                }
                            });
                            
                        } 
                        return false; 
                    }
                },                
	                errorState: {
	                    title: 'Data Attribution Report',
	                    html:'<p id="response">An Error Occurred During Data Attribution Process Kindly Try Again.</p>',
	                    buttons: {Finish: 1 },
	                    focus: 0,
	                    submit:function(e,v,m,f){
	                        if(v==1)
	                            window.location.reload(true); //Refresh page to reflect the changes
	                        else  $.prompt.close();//close dialog
	                        return false; 
	                    }
	                },
	                finalState: {
	                    title: 'Data Attribution Report',
	                    html:'<p id="response">Data Attribution Was Successful</p>',
	                    buttons: {Finish: 1 },
	                    focus: 0,
	                    submit:function(e,v,m,f){
	                        if(v==1)
	                            window.location.reload(true); //Refresh page to reflect the changes
	                        else  $.prompt.close();//close dialog
	                        return false; 
	                    }
	                }
	            };
	
	            $.prompt(temp,{
	                close: function(e,v,m,f){
	                    if(v !== undefined){
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



			function mechanism_attribution(){
				var url_details = "<?php echo base_url('data_attribution/mechanism_attribution/')?>";
	             var temp = {
	                state0: {
	                    title:'Confirm IPSL Data Attribution',
	                    html:'Do you want to Perfom Data Attribution Using The Implementing Partners Support List?',
	                    buttons: { Cancel: false, YES: true },
	                    focus: 1,
	                    submit:function(e,v,m,f){ 
	                        if(!v)
	                            $.prompt.close();
	                        else { 
                                $('#programForm').html('<form id="edit_support" action="#" method="post">'+                                    
                                "<div class='field'><label for='start_date' style='font-size:1.2em;margin-top:1em;width:8em;'>Program</label><select id='attributionmechanism' style='width:200px'> \n\
                                <?php if ($mechanisms!='') { foreach ($mechanisms as $row) { echo "<option value='$row->datim_id'>$row->mechanism_name</option>"; }}?>  \n\
                                 </select>  </div>"+
                                '</form>');                      	
	                            $.prompt.goToState('state1');
	                        }
	                        return false; 
	                    }
	                },
                state1: {
                    title: '<h4>Select Mechanism For Data Attribution </h4>',
                    html:'<div id="programForm"></div>',
                    buttons: {Cancel: false ,Submit:true },
                    focus: 1,
                    submit:function(e,v,m,f){
                        if(v==false)
                        {
                        	$.prompt.close();
                        }
                        else {
                            $.ajax({
                                url: url_details+"/"+$('#attributionmechanism').val(),
                                type: 'POST',
                                dataType: 'json',
                                beforeSend: function () {
                                	$('#loadScreen').show();
                                },                                
                                success: function (data) {
                                	$('#loadScreen').hide();
                                    if(data.message=="success"){
                                    	$.prompt.goToState('finalState');
                                    }else{
                                    	$.prompt.goToState('errorState');
                                    }
                                }
                            });
                            
                        } 
                        return false; 
                    }
                },                
	                errorState: {
	                    title: 'Mechanism Data Attribution Report',
	                    html:'<p id="response">An Error Occurred During Data Attribution Process Kindly Try Again.</p>',
	                    buttons: {Finish: 1 },
	                    focus: 0,
	                    submit:function(e,v,m,f){
	                        if(v==1)
	                            window.location.reload(true); //Refresh page to reflect the changes
	                        else  $.prompt.close();//close dialog
	                        return false; 
	                    }
	                },
	                finalState: {
	                    title: 'Mechanism Data Attribution Report',
	                    html:'<p id="response">Data Attribution Was Successful</p>',
	                    buttons: {Finish: 1 },
	                    focus: 0,
	                    submit:function(e,v,m,f){
	                        if(v==1)
	                            window.location.reload(true); //Refresh page to reflect the changes
	                        else  $.prompt.close();//close dialog
	                        return false; 
	                    }
	                }
	            };
	
	            $.prompt(temp,{
	                close: function(e,v,m,f){
	                    if(v !== undefined){
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

 