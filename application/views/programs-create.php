                <link rel="stylesheet" href="<?php echo base_url(); ?>/style/js/jquery-ui.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>/style/chosen/chosen.min.css" type="text/css">


                <script src="<?php echo base_url(); ?>/style/js/jquery-1.10.2.js"></script>
                <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
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
                        width:240px; 
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
                        background: #fff url(images/red_asterisk.png) no-repeat 98% left;
                    }
                    .donor_form select:required:valid, input:required:valid, .donor_form textarea:required:valid {
                        background: #fff url(images/valid.png) no-repeat 98% left;
                        box-shadow: 0 0 5px #5cd053;
                        border-color: #28921f;
                    }
                    .donor_form select:focus:invalid,input:focus:invalid, .donor_form textarea:focus:invalid {
                        background: #fff url(images/invalid.png) no-repeat 98% left;
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
                
                <style>
	                .chosen-container-active.chosen-with-drop .chosen-single{
	                	width:500px;
	                }
            		.chosen-container-single .chosen-drop{
            			width:500px;
            			overflow-x: hidden
            		}
                    .donor_form SELECT{
                        width: 200px;
                        height:200px;
                        box-sizing: border-box;
                        overflow-y:auto; overflow-x:auto;
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
                
                <script type="text/javascript"> 
                    function submitform(data){
                        //alert(data);
                        var temp = {
                            state0: {
                                title:'Program Creation',
                                html:'Do you want to  create the program with selected dataelements?',
                                buttons: { Cancel: false, Submit: true },
                                focus: 1,
                                submit:function(e,v,m,f){ 
                                    if(!v)
                                        $.prompt.close();
                                    else { 
										var myArray = new Array(document.getElementById("pname").value, "Volvo", document.getElementById("rightValues").value);
									    var x = document.getElementById("rightValues");
									    var dataelements = " ";
									    var i;
									    for (i = 0; i < x.options.length; i++) {
									    	if (i=1) {
									    		dataelements = '{"dname": " '+x.options[i].value+'","duid":"" }';
									    	} else{
									    		dataelements = '{"dname": " '+x.options[i].value+'","duid":"" }'+','+dataelements;
									    	};
									        
									    };
									    alert(JSON.stringify(dataelements));
									                                       	
									    var data=JSON.stringify(myArray);                                    	
                                    	//alert(data);
                                        var form = $( "#program_details" ); 
                                            form_url = form.attr( "action" ); 
                                            alert(form_url);
                                        $.ajax({ 
                                            url: form_url, 
                                            dataType: 'text', 
                                            type: 'post', 
                                            data:{"data": data},
                                            contentType: 'application/x-www-form-urlencoded',  
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
                                title: 'Program Creation Confirmation',
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
                    
                    function formerror(){
                        var tourSubmitFunc = function(e,v,m,f){
                            if(v === -1){
                                    $.prompt.prevState();
                                    return false;
                            }
                            else if(v === 1){
                                    $.prompt.nextState();
                                    return false;
                            }
                        },
                        tourStates = [
                                {
                                        title: 'Before submitting',
                                        html: 'Please make sure you Fill All Required Fields',
                                        buttons: { Next: 1 },
                                        focus: 0,
                                        position: { container: '#program_details', x: 250, y: 60, width: 300, arrow: 'tc' },
                                        submit: tourSubmitFunc
                                },
                                {
                                        title: 'Start Date',
                                        html: 'The date of beggining support of the program in the facility.',
                                        buttons: { Prev: -1, Next: 1 },
                                        focus: 1,
                                        position: { container: '#datepicker-example7-start', x: 170, y: 0, width: 300, arrow: 'lt' },
                                        submit: tourSubmitFunc
                                },
                                {
                                        title: 'End Date',
                                        html: 'The date of dropping support of the program in the facility',
                                        buttons: { Prev: -1, Next: 1 },
                                        focus: 1,
                                        position: { container: '#datepicker-example7-end', x: -280, y: 0, width: 300, arrow: 'rt' },
                                        submit: tourSubmitFunc
                                },
                                {
                                        title: 'List of Facilities',
                                        html: 'You can select multiple facilities and click the >> button to select',
                                        buttons: { Prev: -1, Next: 1 },
                                        focus: 1,
                                        position: { container: '#leftValues', x: 180, y: 10, width: 300, arrow: 'lt' },
                                        submit: tourSubmitFunc
                                },
                                {
                                        title: 'Selected Facilities',
                                        html: 'You can undo selection by selecting the facility and clicking the << button to unselect',
                                        buttons: { Prev: -1, Next: 1 },
                                        focus: 1,
                                        position: { container: '#rightValues', x: -270, y: 10, width: 300, arrow: 'rt' },
                                        submit: tourSubmitFunc
                                },
                                {
                                        title: 'Submit',
                                        html: 'You can complete the selection by clicking Submit button',
                                        buttons: { Done: 2 },
                                        focus: 0,
                                        position: { container: '.submit', x: -100, y: -200, width: 300, arrow: 'bc' },
                                        submit: tourSubmitFunc
                                }
                        ];
                        $.prompt(tourStates,{
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
                        } );                                   
                    }
                    

                </script>
                <div id="results"></div>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Create Program
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Program Management</a></li>
                        <li class="active">Create Program</li>
                    </ol>
                </section>       
       
                <section class="content">
 
                <script>
                    jQuery.fn.filterByText = function(textbox, selectSingleMatch) {
                        return this.each(function() {
                            var select = this;
                            var options = [];
                            $(select).find('option').each(function() {
                                options.push({value: $(this).val(), text: $(this).text()});
                            });
                            $(select).data('options', options);
                            $(textbox).bind('change keyup', function() {
                                var options = $(select).empty().data('options');
                                var search = $.trim($(this).val());
                                var regex = new RegExp(search,"gi");
                              
                                $.each(options, function(i) {
                                    var option = options[i];
                                    if(option.text.match(regex) !== null) {
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
                
                    $(function() {
                        $('#leftValues').filterByText($('#textbox'), true);
                    }); 
                </script>
        <div class="container">
        <div class="row">
                <form class="donor_form" id="program_details" action="<?php echo base_url('programmanager/addnewprogram')?>" method="post">
                    <div class="form-group">
                        <label>Program Details:</label>
                        <span class="required_notification">* Denotes Required Field</span>   

                        <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Program Name:</label>
                                <input type="text" name="pname" id="pname"  placeholder="Program Name"  required pattern="{2,}"  />
                                <span class="form_hint">Program Name Must Be Of Atleast 2 Characters</span>
                            </div>

                            <div class="form-group">
                               <label for="name">Program ShortName:</label>
                                <input type="text" name="sname" id="sname"  placeholder="Program Short Name: PMTCT"  required pattern="[A-Za-z\s]{2,}" maxlength="20" />
                                <span class="form_hint">Program Name Must Be Of Atleast 2 Characters</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Program Description:</label>
                                <textarea name="pdescription" rows="4" cols="100" placeholder="Fill In Brief Details About The Program"  required pattern="[A-Za-z\s]{15,}"></textarea>
                                 <span class="form_hint">Description Must Be Of Atleast 15 Characters</span>
                            </div>

                        </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                        <div>
                            <div>
                                <label for="datasets" style="font-size: 16px; width: 200px">Data Sets Available </label>
                            </div>


<!-- TODO: Format the CSS to have a better appearance for Chosen select -->
                            <div>
                                <select id="datasets" class="chosen-select" style="height: 30px;  " onchange="getElements()" tabindex="2">
                                    <option value="nil" >All Data Sets</option>
                                    <?php
                                    if ($datasets!='') {
                                        foreach ($datasets as $dataset_row) {
                                            echo "<option value='$dataset_row->datasetid' >$dataset_row->name</option>";
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
                                <label for="datasets" style="font-size: 16px; width: 200px">Search Dataelements </label>
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
                                        <select id="leftValues" size="10" multiple style="width:370px; height:250px;">
                                            <?php
                                                if ($dataelements!='') {
                                                    foreach ($dataelements as $row) {
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
                                            <select id="rightValues" size="10" name='dataelements[]' style="width:370px; height:250px;" multiple required >
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
                });

                $("#btnRight").click(function () {
                    var selectedItem = $("#leftValues option:selected");
                    $("#rightValues").append(selectedItem); 
                });
                  
                $("#rightValues").change(function () {
                    var selectedItem = $("#rightValues option:selected");
                    $("#txtRight").val(selectedItem.text());
                });  
                $("#program_detailsss" ).submit(function( event ) { 
                    // Stop form from submitting normally
                    event.preventDefault();    
                    var form = $(this);
                    // create array to hold your data
                    submitform(); 
                });

               

            });

            $(function() {
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
            function dataRow(id,sdate,edate) {
                this.dxCode = id;
                this.dxSDate = sdate;
                this.dxEDate = edate;
            }
        </script>

        <script type="text/javascript">
        $(document).ready(function () {

             $('.submit').click(function() {
                        $("#program_details").submit(function( event ) {

                            $("#rightValues option").prop("selected", true);

                            var elements = [];

                            $('#rightValues :selected').each(function (i, selected) {
                                elements[i] = $(selected).val();
                            });
                              if (element.length>0) {
                                return;
                              }

                              $("#errorSelectedDataelements").text( "<b>No Data Elements Selected<b>").show().fadeOut(8000);
                              event.preventDefault();
                               
                            });
                    
                });
        })
        </script>
<!--                Steve Scripts -->
<script>
    var datasets = <?php echo json_encode($datasets); ?>;
    var datasetmembers = <?php echo json_encode($datasetmembers); ?>;
    var dataelements = <?php echo json_encode($dataelements); ?>;
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


                
        <link rel="stylesheet" href="<?php echo base_url(); ?>/style/date/css/default.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/style/bootstrap-dialog/css/base.css" type="text/css">
        
        <script type="text/javascript" src="<?php echo base_url(); ?>/style/chosen/chosen.jquery.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>/style/date/js/zebra_datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>/style/date/js/core.js"></script>                
        
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
<!--                Chosen needs to be after jquery -->
                <script>
                    $(".chosen-select").chosen();
                </script>
