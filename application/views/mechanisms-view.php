                <link rel="stylesheet" href="<?php echo base_url(); ?>/style/js/jquery-ui.css">
                
                <script src="<?php echo base_url(); ?>/style/js/jquery-1.11.3.min.js"></script>  
                <script src="<?php echo base_url(); ?>/style/js/jquery-ui.js"></script>                             

                <style type="text/css">     
                    .donor_form ul {
                        width:750px;
                        list-style-type:none;
                        list-style-position:outside;
                        margin:0px;
                        padding:0px;
                    }
                    .donor_form li{
                        padding:12px; 
                        position:relative;
                        margin-left: 10%;
                    } 
                    .donor_form li:first-child, .donor_form li:last-child {
                        border-bottom:0px solid #777;
                    }
                    
                    /* === Form Header === */
                    .donor_form h2 {
                        margin:0;
                        display: inline;
                    }
                    .required_notification {
                        color:#d45252; 
                        margin:5px 0 0 0; 
                        display:inline;
                        float:right;
                    }
                    
                    /* === Form Elements === */
                    .donor_form label {
                        width:150px;
                        margin-top: 3px;
                        display:inline-block;
                        float:left;
                        padding:3px;
                    }
                    .donor_form input, .donor_form select {
                        height:30px; 
                        width:220px; 
                        padding:5px 8px;
                    }
                    .donor_form textarea {padding:8px; width:300px;}
                    .donor_form button {margin-left:156px;}
                    
                    /* form element visual styles */
                   .donor_form select, .donor_form input, .donor_form textarea { 
                        border:1px solid #aaa;
                        box-shadow: 0px 0px 3px #ccc, 0 10px 15px #eee inset;
                        border-radius:2px;
                        padding-right:30px;
                        -moz-transition: padding .25s; 
                        -webkit-transition: padding .25s; 
                        -o-transition: padding .25s;
                        transition: padding .25s;
                    }
                    .donor_form select:focus, input:focus, .donor_form textarea:focus {
                        background: #fff; 
                        border:1px solid #555; 
                        box-shadow: 0 0 3px #aaa; 
                        padding-right:70px;
                    }
                    
                    /* === HTML5 validation styles === */   
                    .donor_form select:required,input:required, .donor_form textarea:required {
                        background: #fff url(images/red_asterisk.png) no-repeat 98% center;
                    }
                    .donor_form select:required:valid, input:required:valid, .donor_form textarea:required:valid {
                        background: #fff url(images/valid.png) no-repeat 98% center;
                        box-shadow: 0 0 5px #5cd053;
                        border-color: #28921f;
                    }
                    .donor_form select:focus:invalid,input:focus:invalid, .donor_form textarea:focus:invalid {
                        background: #fff url(images/invalid.png) no-repeat 98% center;
                        box-shadow: 0 0 5px #d45252;
                        border-color: #b03535
                    }
                    
                    /* === Form hints === */
                    .form_hint {
                        background: #d45252;
                        border-radius: 3px 3px 3px 3px;
                        color: white;
                        margin-left:8px;
                        padding: 1px 6px;
                        z-index: 999; /* hints stay above all other elements */
                        position: absolute; /* allows proper formatting if hint is two lines */
                        display: none;
                    }
                    .form_hint::before {
                        content: "\25C0";
                        color:#d45252;
                        position: absolute;
                        top:1px;
                        left:-6px;
                    }
                    .donor_form input:focus + .form_hint {display: inline;}
                    .donor_form select:focus + .form_hint {display: inline;}
                    .donor_form input:required:valid + .form_hint {background: #28921f;}
                    .donor_form select:required:valid + .form_hint {background: #28921f;}
                    .donor_form input:required:valid + .form_hint::before {color:#28921f;}
                    .donor_form select:required:valid + .form_hint::before {color:#28921f;}
                        
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
                        -webkit-box-shadow: 0 1px 0 0 #9fd574 inset ;
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
                        opacity:.85;
                        cursor: pointer; 
                    }
                    button.submit:active {
                        border: 1px solid #20911e;
                        box-shadow: 0 0 10px 5px #356b0b inset; 
                        -webkit-box-shadow:0 0 10px 5px #356b0b inset ;
                        -moz-box-shadow: 0 0 10px 5px #356b0b inset;
                        -ms-box-shadow: 0 0 10px 5px #356b0b inset;
                        -o-box-shadow: 0 0 10px 5px #356b0b inset;
                        
                    }       
                    
                    div.dataTables_filter input {
                        height: 30px;
                        width: 17em;
                    }
                </style>



				<script>
				
                    function supportedit(id,orgunit,program,s_date,s_end){  

                        var temp = {
                            state0: {
                                title:'Update Support For '+program,
                                html:'<form id="edit_support" action="#" method="post">\n\
                                        <fieldset>Update the support details.</fieldset>'+
                                        "<div class='field'>\n\
                                            <label for='support_type' style='font-size:1.2em;margin-top:1em;width:8em;'>Support Type</label>\n\
                                            <select id='support_type'><option value='DSD'>DSD</option><option value='TA'>TA</option></select>\n\
                                            <span class='form_hint'>yyyy/mm/dd</span> \n\
                                        </div>"+                                        
                                        "<div class='field'>\n\
                                            <label for='start_date' style='font-size:1.2em;margin-top:1em;width:8em;'>Start Date</label>\n\
                                            <input  type='text' id='datepickerstart' value='"+s_date+"'  required pattern='[A-Za-z\s0-9]{5,}' name='start_date' placeholder='dd-mm-yy' style='height:30px;font-size:18px;width:10em;'/>\n\
                                            <span class='form_hint'>dd-mm-yyyy</span> \n\
                                        </div>"+
                                        "<div class='field'>\n\
                                            <label for='end_date' style='font-size:1.2em;margin-top:1em;width:8em;'>End date</label>\n\
                                            <input type='text' id='datepickerend'  required pattern='[A-Za-z\s0-9]{5,}' name='end_date' value='"+s_end+"' placeholder='dd-mm-yy' style='height:30px;font-size:18px;width:10em;'/>\n\
                                            <span class='form_hint'>dd-mm-yyyy</span> \n\
                                        </div>\n" +
                                    '</form>',
                                buttons: { Cancel: false, Submit: true },
                                focus: 1,
                                submit:function(e,v,m,f){ 
                                    if(!v)
                                        $.prompt.close();
                                    else { 
                                        var s_date = $('#datepickerstart').val();
                                        var e_date = $('#datepickerend').val();
                                        var s_type=document.getElementById("support_type").value;
                                        var info= '{"support_id": " '+id+'","type":"'+s_type+'","sdate":"'+s_date+'","edate":"'+e_date+'"}';
                                        var data_url = '<?php echo base_url()?>mechanisms/supportupdate';
                                        $.ajax({ 
                                            url: data_url, 
                                            dataType: 'text', 
                                            type: 'post', 
                                            contentType: 'application/x-www-form-urlencoded', 
                                            data: {"data": info}, 
                                            success: function( data, textStatus, jQxhr ){ 
                                                $('#response').html(data);
                                                $.prompt.goToState('state1');//go forward 
                                            }, 
                                            error: function( jqXhr, textStatus, errorThrown ) {
                                                console.log( errorThrown ); 
                                            }
                                        });
                                    }
                                    return false; 
                                }
                            },
                            state1: {
                                title: 'Support Dates Update Confirmation',
                                html:'<p id="response"></p>',
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
                        // $('#datepickerstart').Zebra_DatePicker();
                        // $('#datepickerend').Zebra_DatePicker();
                        $("#datepickerstart").datepicker({
                              defaultDate: "+1w",
                              dateFormat:"dd-mm-yy",
                              changeMonth: true,
                              numberOfMonths: 1,
                              onClose: function( selectedDate ) {
                                $("#datepickerend").datepicker( "option", "minDate", selectedDate );
                              }
                            });

                            $("#datepickerend").datepicker({
                              defaultDate: "+4w",
                              dateFormat:"dd-mm-yy",
                              changeMonth: true,
                              numberOfMonths: 1,
                              onClose: function( selectedDate ) {
                                $("#datepickerstart").datepicker( "option", "maxDate", selectedDate );
                              }
                            });

                    }
				
				
				
					
                    function supportdrop(data, orgunit, program){
                        //alert(data);
                        var temp = {
                            state0: {
                                title:'Drop '+name+' Support',
                                html:'Do You Want To Drop Support For  '+program+' In '+orgunit,
                                buttons: { Cancel: false, Submit: true },
                                focus: 1,
                                submit:function(e,v,m,f){ 
                                    if(!v)
                                        $.prompt.close();
                                    else { 
                                    	//alert("robin");
                                        form_url = "<?php echo base_url('mechanisms/dropsupport')?>"+"/"+data; 
                                            alert(form_url);
                                        $.ajax({ 
                                            url: form_url, 
                                            dataType: 'text', 
                                            type: 'post', 
                                            success: function( data, textStatus, jQxhr ){ 
                                                $('#response').html(data);
                                                $.prompt.goToState('state1');//go forward 
                                            }, 
                                            error: function( jqXhr, textStatus, errorThrown ) {
                                                console.log( errorThrown ); 
                                            }
                                        });
                                    }
                                    return false; 
                                }
                            },
                            state1: {
                                title: name+' Delete Confirmation',
                                html:'<p id="response"></p>',
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



                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo $mech_details->mechanism_name ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Mehanisms Management</a></li>
                        <li class="active">View Mechanism</li>
                    </ol>
                </section>       
       
                <section class="content">
					<div class="row"> 
						<div class="box">
                                <div class="box-header">
                                    <h3 class="box-title"> <?php echo $mech_details->mechanism_name; ?> : Support Faccilities And Programs   </h3>
                                </div><!-- /.box-header -->			
                                <div class="box-body table-responsive">
                                    <table id="support-table" class="table table-bordered table-striped" >                                    	
                                    <thead>
                                        <tr>
                                            <th style="width:5%">#</th>
                                            <th style="width:30%">Organization Unit Name</th>
                                            <th style="width:25%">Program Name</th>
                                            <th style="width:15%">Support Type</th>
                                            <th style="width:12.5%">Support Start</th>
                                            <th style="width:12.5%">Support End</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    	    if ($mech_programs!='') {
                                                foreach ($mech_programs as $row ) {
                                                    echo "<tr class='grade_tr' data-id='".$row->id."' data-orgunit='".$row->organization_name."' data-program='".$row->program_name."' data-s_date='".$row->start_date."' data-s_end='".$row->stop_date."'>";
                                                    echo "<td>$row->id</td>";
													echo "<td>$row->organization_name</td>";
													echo "<td>$row->program_name</td>";
                                                    echo "<td>$row->support_type</td>";
													echo "<td>$row->start_date</td>";
													echo "<td>$row->stop_date</td>";
                                                    echo "</tr>";
                                                }  
											}
                                    	?>
                                    </tbody>
    
                                    </table>
                                </div><!-- /.box-body -->                                			
						</div>
				    </div>               
       </section>
   
                
        <script type="text/javascript"> 
            $(function() {
                $('#support-table').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
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
        <script src="<?php echo base_url(); ?>/style/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>/style/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url(); ?>/style/js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url(); ?>/style/js/AdminLTE/demo.js" type="text/javascript"></script>
        <!-- Jquery UI js -->
        <script src="<?php echo base_url(); ?>/style/js/jquery-ui.js" type="text/javascript"></script>
 


<!-- Pop over Class -->

<div id="contextMenuID" class="contextMenu" style="width: 200px; display:block;">
<button type="button" class="close" id="btn-dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<br/>
<ul class="" style="list-style-type:none">
	<?php
		if($program_right){echo '<li class=""><a href="#" id="update"><i class="fa fa-edit"></i> Update</a></li> <br>';};
		if($program_right){echo '<li class=""><a href="#" id="delete" onclick=""><i class="fa fa-trash-o"></i> Drop support</a></li> <br>';};
        if($attribution_right){echo '<li class=""><a href="#" id="attribute"><i class="fa fa-plus"></i> Attribute</a></li>';}; 
	?>	
</ul>
</div>


        
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

.contextMenuItemActive{
  background-color: #246BA1 !important;
  color: #fff !important;
}
</style>
        
        
 <!--  -->
    <script>

        $(document).ready(function() {
			$("#contextMenuID").hide();
            $('#support-table').DataTable(); 


            $('body').delegate('#support-table .grade_tr', 'click', function (event) {
            	
            	
                var menuHeight = $('.contextMenu').height();
                var menuWidth = $('.contextMenu').width();
                var winHeight = $(window).height();
                var winWidth = $(window).width();

                var pageX = event.pageX;
                var pageY = event.pageY;

                if( (menuWidth + pageX) > winWidth ) {
                  pageX -= menuWidth;
                }

                if( (menuHeight + pageY) > winHeight ) {
                  pageY -= menuHeight;

                  if( pageY < 0 ) {
                    pageY = event.pageY;
                  }
                }

                var mouseCoordinates = {
                    x : pageX,
                    y : pageY
                };


                $("#contextMenuID").show();
                $("#contextMenuID").css({"top":mouseCoordinates.y,"left":mouseCoordinates.x});
                
                $("tbody tr").removeClass("contextMenuItemActive");
                $(this).addClass("contextMenuItemActive");
                var id = $(this).closest('tr').data('id');
                var orgunit= $(this).closest('tr').data('orgunit');
                var program= $(this).closest('tr').data('program');
                var s_date= $(this).closest('tr').data('s_date');
                var s_end= $(this).closest('tr').data('s_end');
                 document.getElementById("update").setAttribute('onclick',"supportedit('"+id+"','"+orgunit+"','"+program+"','"+s_date+"','"+s_end+"')");
                 document.getElementById("delete").setAttribute('onclick',"supportdrop('"+id+"','"+orgunit+"','"+program+"')");
                 document.getElementById("view").href="<?php echo base_url();?>"+"programmanager/viewprogram/"+id;

            });

            $("#btn-dismiss, thead, tfoot").click(function () {

                 $("#contextMenuID").hide(100);
                 $("tr").removeClass("contextMenuItemActive");

             })

        });
        
    </script>        
