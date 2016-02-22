<link rel="stylesheet" href="<?php echo base_url(); ?>/style/js/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/style/chosen/chosen.min.css" type="text/css">
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
    .donor_form h4 {
        margin: 0;
        display: inline;
    }

    .required_notification {
        color: #d45252;
        margin: 5px 0 0 0;
        display: inline;
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
    .donor_form select, .donor_form input, .donor_form textarea {
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
    .chosen-container-active.chosen-with-drop .chosen-single{
    	width:500px;
    }
	.chosen-container-single .chosen-drop{
		width:500px;
		overflow-x: hidden
	}
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
        float: left;
        padding: 4px;
    }

    .donor_form SECTION > DIV + DIV {
        width: 300px;
        text-align: center;
    }

</style>

<div id="results"></div>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Update <?php echo $program_details->program_name; ?>  Details
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Program Management</a></li>
        <li class="active">Edit Program</li>
    </ol>
</section>

<section class="content">

    <script>
        jQuery.fn.filterByText = function (textbox, selectSingleMatch) {
            return this.each(function () {
                var select = this;
                var options = [];
                $(select).find('option').each(function () {
                    options.push({value: $(this).val(), text: $(this).text()});
                });
                $(select).data('options', options);
                $(textbox).bind('change keyup', function () {
                    var options = $(select).empty().data('options');
                    var search = $.trim($(this).val());
                    var regex = new RegExp(search, "gi");

                    $.each(options, function (i) {
                        var option = options[i];
                        if (option.text.match(regex) !== null) {
                            $(select).append(
                                $('<option>').text(option.text).val(option.value)
                            );
                        }
                    });
                    if (selectSingleMatch === true && $(select).children().length === 1) {
                        $(select).children().get(0).selected = true;
                    }
                });
            });
        };

        $(function () {
            $('#leftValues').filterByText($('#textbox'), true);
        });

    </script>
    <div class="container">
        <div class="row">
    <!-- "<?php echo base_url('programmanager/updateprogram/' . $program_details->program_id) ?>" -->
            <form class="donor_form" id="program_details" action="" method="">
                    <div class="form-group">
                        <label>Program Details:</label>
                        <span class="required_notification">* Denotes Required Field</span>   

                        <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Program Name:</label>
                                <input type="text" name="pname" id="pname" class="form-control" value="<?php echo $program_details->program_name; ?>"
                                        required pattern="[A-Za-z\s]{10,}"/>
                                <span class="form_hint">Program Name Must Be Of Atleast 10 Characters</span>
                            </div>

                            <div class="form-group">
                                <label for="name">Program ShortName:</label>
                                <input type="text" name="sname" id="sname"  class="form-control" value="<?php echo $program_details->program_shortname; ?>"
                                       required pattern="[A-Za-z\s]{2,}" maxlength="20" />
                                <span class="form_hint">Program Name Must Be Of Atleast 2 Characters</span>  
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Program Description:</label>
                                <textarea id="pdescription" name="pdescription" class="form-control" rows="3" cols="120" required
                                          pattern="[A-Za-z\s]{15,}"><?php echo $program_details->program_description; ?></textarea>
                                <span class="form_hint">Description Must Be Of Atleast 15 Characters</span>
                            </div>

                        </div>
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="col-md-12">
                          <div>

                            <div>
                                <label for="datasets">Data Sets Available </label>
                            </div>


							<!-- TODO: Format the CSS to have a better appearance for Chosen select -->
                            <div>
                                <select id="datasets" class="chosen-select"  style="height: 30px; width: 350px;" onchange="getElements()" tabindex="2">
                                    <option value="nil">All Data Sets</option>
                                    <?php
                                    if ($datasets!='') {
                                        foreach ($datasets as $dataset_row) {
                                            echo "<option value='$dataset_row->datasetid'>$dataset_row->name</option>";
                                        }
                                    }
                                    ?>
                                </select>
							<!--                                <div class="alert alert-warning" role="alert">No data elements available</div>-->
                            </div>
                            <span class="required_notification" id="dataset_error_notification"></span>
                            <!--                                   End Steve: Data Sets on page  -->

                            
                            <div>&nbsp;</div>
                            <div>
                                <label for="datasets" >Search Dataelements </label>
                            </div>
                            
                            <div>
                                 <input id="textbox" type="text" class="form-control" placeholder="Search Dataelements"/>
                            </div>

                        </div>
                            
                            <section class="container">
                                <div>
                                    <div>
                                        <label for="name" style="font-size: 16px; width: 200px">Dataelements Available </label>
                                    </div>
                                    <div>
                                        <select id="leftValues" size="4" multiple style="width:370px; height:250px;">
                                            <?php
                                            if ($available != '') {
                                                foreach ($available as $row) {
                                                    echo "<option value='$row->uid'>$row->name</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div style="margin-top: 10%;">
                                    <input type="button" class="btn btn-md" id="btnRight" value="&gt;&gt;"/>
                                    <input type="button" class="btn btn-md" id="btnLeft" value="&lt;&lt;" style="margin-top: 30px"/>
                                </div>
                                <div>
                                    <div>
                                        <div>
                                            <label for="name" style="font-size: 16px; margin-left:0px; width: 200px">Selected
                                                Dataelements </label>
                                        </div>
                                        <div>
                                            <select id="rightValues" size="5" name='dataelements[]' style="width:370px; height:250px;" multiple required>
                                                <?php
                                                if ($program_dataelements != '') {
                                                    foreach ($program_dataelements as $row) {
                                                        echo "<option value='$row->dataelement_uid'>$row->dataelement_name</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        <div class="col-md-offset-4">
                            <button class="submit">Submit</button>
                        </div>
                        </div>
                    </div>

            </form>
        </div>
    </div>

</section>


<script type="text/javascript">

    $(document).ready(function () {

        $("#btnLeft").click(function () {
            var selectedItem = $("#rightValues option:selected");
            $("#leftValues").append(selectedItem);
             $("#rightValues option").prop("selected", true);
        });

        $("#btnRight").click(function () {
            var selectedItem = $("#leftValues option:selected");
            $("#rightValues").append(selectedItem);
             $("#rightValues option").prop("selected", true);
        });

        $("#rightValues").change(function () {
            var selectedItem = $("#rightValues option:selected");
            $("#txtRight").val(selectedItem.text());
        });
        // $("#program_details").submit(function (event) {
        //     // Stop form from submitting normally
        //     event.preventDefault();
        //     var form = $(this);
        //     // create array to hold your data
        //     submitform();
        // });
    });
    $(function () {
        $("#example1").dataTable();
        $("#supportedorgs").dataTable();
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
    // object to hold table data
    function dataRow(id, sdate, edate) {
        this.dxCode = id;
        this.dxSDate = sdate;
        this.dxEDate = edate;
    }
</script>

<script type="text/javascript">
    
    $( window ).load(function() {
        // selects all values on the right select box when the window loads
          $("#rightValues option").prop("selected", true);
    });

    $(document).ready(function () {
        
        $('#program_details').submit(function (e) {
            // selects all values on the right select box
            $("#rightValues option").prop("selected", true);
            var elements = [];
            $('#rightValues :selected').each(function (i, selected) {
                elements[i] = $(selected).val();
            });

            // Form Update Data 
            var form_data = {
                dataelements: elements,
                pname: $("#pname").val(),
                sname: $("#sname").val(),
                pdescription: $("#pdescription").val()

            };
            e.preventDefault();

             var temp = {
                state0: {
                    title:'Confirm Update',
                    html:'Do you want to update program information?',
                    buttons: { Cancel: false, YES: true },
                    focus: 1,
                    submit:function(e,v,m,f){ 
                        if(!v)
                            $.prompt.close();
                        else { 
                            
                            var check_program_url="<?php echo base_url('programmanager/check_changes_program_dataelements/'.$program_details->program_id) ?>"
                           
                            $.ajax({ 
                                url: check_program_url, 
                                dataType: 'text', 
                                type: 'post', 
                                contentType: 'application/x-www-form-urlencoded', 
                                data:form_data, 
                                success: function( data, textStatus, jQxhr ){ 
                                    if (data == -1) {
                                         $.prompt.goToState('state1');
                                    }
                                    else{
                                        $.ajax({
                                            url: "<?php echo base_url('programmanager/updateprogram/'.$program_details->program_id) ?>",
                                            type: 'POST',
                                            data: form_data,
                                            success: function (msg) {
                                                $('#response').html(msg);
                                                $.prompt.goToState('finalState');
                                            }
                                        });
                                    }
                                   
                                }, 
                                error: function(jqXhr, textStatus, errorThrown ) {
                                    console.log( errorThrown ); 
                                }
                            });
                        }
                        return false; 
                    }
                },
                state1: {
                    title: '<h4>Backup Data Elements</h4>',
                    html:'<p class="alert alert-info">Do you want to create an archive of the changes in the data elements of the program?</p>',
                    buttons: {No: false ,Yes:true },
                    focus: 1,
                    submit:function(e,v,m,f){
                        if(v==false)
                        {
                            $.ajax({
                                url: "<?php echo base_url('programmanager/updateprogram/'.$program_details->program_id) ?>",
                                type: 'POST',
                                data: form_data,
                                success: function (msg) {
                                    $('#response').html(msg);
                                    $.prompt.goToState('finalState');
                                }
                            });
                        }
                        else {
                            $.ajax({
                                url: "<?php echo base_url('programmanager/check_program_exists_archive/'.$program_details->program_id) ?>",
                                type: 'POST',
                                data: form_data,
                                success: function (msg) {
                                    //console.log(msg);
                                    if(!msg){
                    
                                        $('#startdateForm').html('<form id="edit_support" action="#" method="post">\n\
                                        <fieldset>Enter Archive Start Date.</fieldset>'+                                    
                                        "<div class='field'>\n\
                                            <label for='start_date' style='font-size:1.2em;margin-top:1em;width:8em;'>Start Date</label>\n\
                                            <input  type='text' id='datepickerstart' value=''  name='start_date' placeholder='dd-mm-yyyy' style='height:30px;font-size:18px;width:10em;'/>\n\
                                            <span class='form_hint'>dd-mm-yyyy</span> \n\
                                        </div>"+
                                        '</form>');

                                        $( "#datepickerstart" ).datepicker({ minDate: "-20Y", maxDate: "-1D",dateFormat:"dd-mm-yy" });

                                        
                                        $.prompt.goToState('state2');

                                    }else{
                                        $.ajax({
                                            url: "<?php echo base_url('programmanager/updateprogram_archive/'.$program_details->program_id) ?>",
                                            type: 'POST',
                                            data: form_data,
                                            success: function (msg) {
                                                $('#response').html(msg);
                                                $.prompt.goToState('finalState');
                                            }
                                        });
                                    }
                                }
                            });
                            
                        } 
                        return false; 
                    }
                },

                state2: {
                    title: 'Archive Start Date',
                    html:'<div id="startdateForm"></div>',
                    buttons: {cancel: false, submit:true },
                    focus: 1,
                    submit:function(e,v,m,f){
                        if(!v){
                           $.prompt.close();//close dialog
                        }
                        else  
                        {
                            $("#rightValues option").prop("selected", true);
                            var elements = [];
                            $('#rightValues :selected').each(function (i, selected) {
                                elements[i] = $(selected).val();
                            });

                            var form_data2 = {
                                dataelements: elements,
                                pname: $("#pname").val(),
                                sname: $("#sname").val(),
                                pdescription: $("#pdescription").val(),
                                start_date:$('#datepickerstart').val()
                            };

                            $.ajax({
                                url: "<?php echo base_url('programmanager/updateprogram_archive/'.$program_details->program_id) ?>",
                                type: 'POST',
                                data: form_data2,
                                success: function (msg) {
                                    $('#response').html(msg);
                                    $.prompt.goToState('finalState');
                                }
                            });
                        }

                        return false; 
                    }
                },
                finalState: {
                    title: 'Update Success',
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

        });
});

</script>

 </script>
<!--                Steve Scripts -->
<script>
    var datasets = <?php echo json_encode($datasets); ?>;
    var datasetmembers = <?php echo json_encode($datasetmembers); ?>;
    var dataelements = <?php echo json_encode($program_dataelements); ?>;
    function getElements() {
        var dataSetId = $( "#datasets option:selected" ).val();
        var dataElementList = [];

        $("#dataset_error_notification").empty();
        $("#leftValues").empty();

        if (dataSetId == 'nil'){
            $.each(dataelements, function (e) {
                $("#leftValues").append("<option value='" + dataelements[e].uid + "'>" + dataelements[e].name + "</option>");
            });
        }
        else {
            $.each(datasetmembers, function (e) {
                if (datasetmembers[e].datasetid == dataSetId){
                    dataElementList.push(datasetmembers[e].dataelementid);
                }
            });
            if (dataElementList.length == 0){
                $("#dataset_error_notification").append("*No DataElements Available for selected Data Set");
            }else{
                $.each(dataElementList, function(element){
                    $.each(dataelements, function (e) {
                        if (dataelements[e].dataelementid == dataElementList[element] ){
                            $("#leftValues").append("<option value='" + dataelements[e].uid + "'>" + dataelements[e].name + "</option>");
                        }
                    });
                });
            }

        }
    }
</script>


<!--                End Steve Scripts -->


                <!--                End Steve Scripts -->


<link rel="stylesheet" href="<?php echo base_url(); ?>/style/date/css/default.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/style/bootstrap-dialog/css/base.css" type="text/css">


<script type="text/javascript" src="<?php echo base_url(); ?>/style/date/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/style/date/js/core.js"></script>
 <script type="text/javascript" src="<?php echo base_url(); ?>/style/chosen/chosen.jquery.min.js"></script>

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
<!-- Jquery Confirm Modal js -->
<script src="<?php echo base_url(); ?>/js/jquery.confirm.min.js" type="text/javascript"></script>
<!-- Jquery UI js -->
<script src="<?php echo base_url(); ?>/style/js/jquery-ui.js" type="text/javascript"></script>

 