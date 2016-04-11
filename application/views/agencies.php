
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Agency Management Portal
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Agency Management Portal</a></li>
                        <li class="active">Agencies</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Agency Table</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Agency ID</th>
                                            <th>Agency Name</th>
                                            <th>Agency Level</th>
                                            <th>Agency Parent ID</th>
                                            <th>Create Date</th>
                                            <th>Last Update</th>                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($agency as $row ) {
                                                echo "<tr>";
                                                echo "<td>$row->usergroupid</td>";
                                                echo "<td>$row->name</td>";
                                                echo "<td>$row->agencylevelname</td>";
                                                echo "<td>$row->agencylevelparentid</td>";
                                                echo "<td>$row->created</td>";
                                                echo "<td>$row->lastupdated</td>";
                                                echo "<td><a href='#' onclick='editprompt($row->usergroupid,\"$row->name\")'/>Edit</a> </td>";
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
        <!-- dialog's script -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>/style/bootstrap-dialog/css/base.css" type="text/css">
        <script type="text/javascript" src="<?php echo base_url(); ?>/style/bootstrap-dialog/js/jquery-impromptu.js"></script>    
               
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
            
            function editprompt(usergroupid,agencyname){ 
                var temp = {
                    state0: {
                        title:'Agency Management',
                        html:'<form id="edit_form" action="#" method="post">\n \n\
                                <div class="field"> <label for="id" style="font-size:1.2em;margin-top:1em;width:8em;"> Agency ID: </label> <input type="text" name="agencyid" value="'+usergroupid+'" style="height:30px;font-size:18px;width:10em;" required readonly/></div>'+ 
                                '<div class="field"> <label for="name" style="font-size:1.2em;margin-top:1em;width:8em;"> Agency Name: </label> <input type="text" name="name" value="'+agencyname+'" style="height:30px;font-size:18px;width:10em;" required readonly/></div>'+ 
                                <?php 
                                    //$levels["#"] = "Please Select one";
                                    echo"'<div class=\"field\"> <label for=\"level\" style=\"font-size:1.2em;margin-top:1em;width:8.15em\"> Partner Level: </label><select name=\"levelid\" id=\"agencylevel\" style=\"height:30px;font-size:18px;width:10em;\" required>'";
                                    foreach ($levels as $row => $value) {
                                        echo "+'<option value=\"".$row."\">". $value."</option>'";
                                    }
                                    echo "+'</select>'";
                                //echo "'".form_dropdown("levelid", $levels,"#",'id="agencylevel"' ,"required")."'";
                                ?> +
                                '<div class="field"> <label for="level" style="font-size:1.2em;margin-top:1em;width:8em;"> Agency Parent: </label> <select id="parents" name="parents" style="height:30px;font-size:18px;width:10em;" required ><option>Please Select</option></select></div>'+  
                             '</form>',
                
                        buttons: { Cancel: false, Submit: true },
                        focus: 1,
                        submit:function(e,v,m,f){ 
                            if(!v)
                                $.prompt.close();
                            else {   
                                var a_level = $('#agencylevel :selected').val(),
                                    a_parent = $('#parents :selected').val(),
                                    data_url = '<?php echo base_url()."agencies/agencyupdate/"; ?>',
                                    form = $("#edit_form"),
                                    form_data = form.serialize();
//                                alert(form_data);
                                $.ajax({ 
                                    url: data_url, 
                                    dataType: 'text', 
                                    type: 'post', 
                                    contentType: 'application/x-www-form-urlencoded', 
                                    data: form_data, 
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
                        title: 'Agency Management Confirmation',
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
                
                $('#agencylevel').change(function(){ //any select change on the dropdown with id country trigger this code
                    $("#parents > option").remove(); //first of all clear select items
                    var levelid = $('#agencylevel').val(); // here we are taking country id of the selected one.
                    $.ajax({
                        type: "POST",
                        url: "http://localhost/associates/agencies/getparent/"+levelid, //here we are calling our user controller and get_cities method with the country_id

                        success: function(getparent)  {//we're calling the response json array 'cities'

                            $.each(getparent,function(id,city) {//here we're doing a foeach loop round each city with id as the key and city as the value

                                var opt = $('<option />'); // here we're creating a new select option with for each city
                                opt.val(id);
                                opt.text(city);
                                $('#parents').append(opt); //here we will append these new select options to a dropdown with the id 'cities'
                            });
                        }

                    });

                });
            }
        </script> 

