                <link rel="stylesheet" href="<?php echo base_url(); ?>/style/js/jquery-ui.css">
                
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
                
                <style>
            
                    .donor_form SELECT{
                        width: 200px;
                        height:200px;
                        box-sizing: border-box;
                    }
                    .donor_form INPUT[type="text"] {
                        width: 200px;
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
                    function openprompt(source_id,section_id){  
                        var temp = {
                            state0: {
                                title: 'Drop Facility Confirmation',
                                html: '<h5> Are you sure you want to drop this facility?</h5>'+
                                      '<p>This action is irreversible!.</p>',
                                buttons: { Cancel: false, Drop: true },
                                focus: 1,
                                submit: function(e,v,m,f){ 
                                    if(!v)
                                        $.prompt.close();
                                    else {
                                    	
                                        var data_url = '<?php echo base_url(); ?>sections/dropfacility/' + source_id + '/' + section_id;
                                        $.ajax({ 
                                            url: data_url, 
                                            dataType: 'text', 
                                            type: 'post', 
                                            contentType: 'application/x-www-form-urlencoded', 
                                            data: $(this).serialize(), 
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
                                title: 'Drop Facility Confirmation',
                                html:'<p id="response"></p>',
                                buttons: {Finish: 1 },
                                focus: 0,
                                submit:function(e,v,m,f){
                                    if(v==1)
                                        return true; //we're done 
                                    else  $.prompt.close();//close dialog
                                    return false; 
                                }
                            } 
                        };
                
                        $.prompt(temp,{
                            close: function(e,v,m,f){  //function(event[, value, message, formVals]){}
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
                    
                    function editprompt(source_id,section_id,sdate,edate){  
                        var temp = {
                            state0: {
                                title:' Faciltiy Support Dates',
                                html:'<form id="edit_form" action="#" method="post">\n\
                                        <fieldset>Change the implementation dates.</fieldset>'+
                                        "<div class='field'>\n\
                                            <label for='start_date' style='font-size:1.2em;margin-top:1em;width:8em;'>Start Date</label>\n\
                                            <input  type='text' id='datepickerstart' value="+sdate+" data-zdp_direction='[\""+sdate+"\", false]' required pattern='[A-Za-z\s0-9]{5,}' name='start_date' placeholder='yyyy/mm/dd' style='height:30px;font-size:18px;width:10em;'/>\n\
                                            <span class='form_hint'>yyyy/mm/dd</span> \n\
                                        </div>"+
                                        "<div class='field'>\n\
                                            <label for='end_date' style='font-size:1.2em;margin-top:1em;width:8em;'>End date</label>\n\
                                            <input type='text' id='datepickerend'  required pattern='[A-Za-z\s0-9]{5,}' name='end_date' value='"+ edate 
                                                        +"' placeholder='yyyy/mm/dd' style='height:30px;font-size:18px;width:10em;'/>\n\
                                            <span class='form_hint'>yyyy/mm/dd</span> \n\
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
                                        var data_url = '<?php echo base_url()?>sections/supportfacilityedit/' + source_id + '/' + section_id + '/'+ s_date + '/' + e_date;
                                        $.ajax({ 
                                            url: data_url, 
                                            dataType: 'text', 
                                            type: 'post', 
                                            contentType: 'application/x-www-form-urlencoded', 
                                            data: $(this).serialize(), 
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
                                title: 'Edit Facility Confirmation',
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
                        $('#datepickerstart').Zebra_DatePicker();
                        $('#datepickerend').Zebra_DatePicker();
                    }
                    
                    function submitform(data){
                        //alert(data);
                        var temp = {
                            state0: {
                                title:'Facility Allocation',
                                html:'Do you want to select these facilities?',
                                buttons: { Cancel: false, Submit: true },
                                focus: 1,
                                submit:function(e,v,m,f){ 
                                    if(!v)
                                        $.prompt.close();
                                    else { 
                                    	alert("robin");
                                        var form = $( "#pickfacility" ); 
                                            form_url = form.attr( "action" ); 
                                            //alert(form_url);
                                        $.ajax({ 
                                            url: form_url, 
                                            dataType: 'text', 
                                            type: 'post', 
                                            contentType: 'application/x-www-form-urlencoded', 
                                            data: {"data": data}, 
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
                                title: 'Facility Confirmation',
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
                                        position: { container: '#pickfacility', x: 250, y: 60, width: 300, arrow: 'tc' },
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
                    
                    function checkPrev(datepickerID){
                        $( "#"+datepickerID+"_b" ).attr('value',"");
                        var startdate = $("#"+datepickerID).val();
                        var now = new Date(startdate);
                        now.setMonth(now.getMonth()+1);
                        $( "#"+datepickerID+"_b" ).datepicker( "destroy" );
                        
                        $("#"+datepickerID+"_b").datepicker({minDate: now}); 
                    }
                </script>
                <div id="results"></div>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo ucfirst($programname) ?> Implementation Portal
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Sections</a></li>
                        <li class="active">Implementing Partner Sections</li>
                    </ol>
                </section>       
       
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
                                <h3 class="box-title"><?php echo  ucfirst($programname); ?> Supported Facilities</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table id="supportedorgs" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Facility Id</th>
                                            <th>Facility Name</th>
                                            <th>Support Start Date</th>
                                            <th>Support End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php
                                            if ($ip_org!='') {
                                                $section_id = $sectionid;
                                                foreach ($ip_org as $row) {
                                                    echo "<tr>";
                                                    echo "<td>$row->sourceid</td>";
                                                    echo "<td>$row->sourcename</td>";
                                                    echo "<td id='s_date'>$row->startdate</td>";
                                                    echo "<td id='e_date'>$row->enddate</td>"; 
                                                    echo "<td>  
                                                            <button class='btn btn-primary btn-sm' onclick='editprompt($row->sourceid,$section_id,\"$row->startdate\",\"$row->enddate\")'> Update </button>
                                                            <button class='btn btn-danger btn-sm' onclick='openprompt($row->sourceid,$section_id)'> Drop </button>
                                                        </td>";
                                                    echo "</tr>";
                                                }  
                                            }    
                                        ?>     
                                    </tbody> 
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>   
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

                <form class="donor_form" id="pickfacility" action="<?php echo base_url()?>sections/supportfacilities/<?php echo $sectionid ?>" method="post">
                    <ul>                         
                        <li>
                            <label for="name" style="font-size: 16px; width:200px;margin-left:50%">Support Facilities </label>
                            <section class="container">
                                
                                <div>
                                    <div>
                                      <label for="name" style="font-size: 16px;">Facilities Available </label>  
                                    </div>
                                    <div>
                                        <input id="textbox" type="text" /><br />
                                        <select id="leftValues" size="4" multiple>
                                            <?php
                                                if ($av_org!='') {
                                                    foreach ($av_org as $row) {
                                                        echo "<option value='$row->orgunitid'>$row->name</option>";
                                                    }
                                                } 
                                            ?>                
                                        </select>                                        
                                    </div>
                                </div>  
                                <div style="margin-top: 5%;">
                                    <input type="button" id="btnRight" value="&gt;&gt;" />
                                    <input type="button" id="btnLeft" value="&lt;&lt;" style="margin-top: 30px" />
                                </div>
                                <div> 
                                    <div>
                                        <div>
                                          <label for="name" style="font-size: 16px; margin-left:45px;">Selected Facilities </label>  
                                        </div>
                                        <div>
                                            <select  id="rightValues"  size="5" name='facilities[]' multiple required readonly>  </select>                                    
                                        </div>
                                    </div> 
                                </div> 
                            </section>
                        </li> 
                        <li style="margin-left: 32%; width: 100%">
                            <button id="select" class="btn btn-primary" type="button"> Select </button>
                        </li> 
                    </ul>
                    
                    <ul>
                        <div class="row">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Edit Dates for Selected Facilities</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" id="sel_table">
                                     
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <li style="margin-left: 32%; width: 100%">
                            <button class="submit" type="submit">Submit</button>
                        </li>
                    </ul> 
                    
                </form>
                    
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
                $("#pickfacility" ).submit(function( event ) { 
                	alert("heres");
                    // Stop form from submitting normally
                    event.preventDefault();    
                    var form = $(this);
                    // create array to hold your data
                    var dataArray = new Array();
                    // iterate through rows of table, Start from '2' to skip the header row 
                    for(var i = 1; i <= $("#edit_facilities tbody tr").length; i++){
                        var uuid = $("input[name='" + i + "_uuid']").val(),
                            sdate = $("input[id='" + i + "']").val(),
                            edate = $("input[id='" + i + "_b']").val();
                        // create object and push to array  
                        dataArray.push( new dataRow( uuid,sdate,edate ) );
                    }
                    var sJson = JSON.stringify(dataArray);
                    $.each(dataArray, function( i, val ){ console.log(val); });
                    submitform(sJson); 
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
                $("#facility-edit").dataTable();
                $("#select").click(function () { 
                    $("#sel_table").html("");
                    var html = '<table id="edit_facilities" class="table table-bordered table-striped"> <thead>'+
                             '<tr><td>ID</td><td>Name</td><td>Start Date</td><td>End Date</td></tr> </thead> <tbody> ';
                    $("#facility-edit tbody tr").not(':first').not(':last').remove(); 
                    var i=1;
                    $.each( $("#rightValues option:selected"), function(id, name){
                        //console.log(id + '=' + name.value + '->' + $(this).text()); 
                        html += '<tr id="row_'+ i +'"> <td> <input name="'+ i +'_uuid" DISABLED value="' + name.value + '" style="width:7em"></td><td>' + $(this).text() + 
                                '</td><td> <input type="text" class="datepicker" id="'+ i +'" onclick="$(this).datepicker().datepicker('+"'option',"+"'dateFormat',"+"'yy-mm-dd'"+').datepicker('+"'show'"+')" required> </td>' +
                                '<td> <input type="text" class="datepicker" id="'+ i +'_b" onclick="checkPrev('+i+'); $(this).datepicker().datepicker('+"'option',"+"'dateFormat',"+"'yy-mm-dd'"+').datepicker('+"'show'"+')" required> </td> </tr>'; 
                        i++;
                    });
                    html += '</tbody> </table>';
                    $("#sel_table").append(html);
                    $("#edit_facilitis").dataTable(); 
                }); 
            });
            // object to hold table data
            function dataRow(id,sdate,edate) {
                this.dxCode = id;
                this.dxSDate = sdate;
                this.dxEDate = edate;
            }
        </script>
                
        <link rel="stylesheet" href="<?php echo base_url(); ?>/style/date/css/default.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/style/bootstrap-dialog/css/base.css" type="text/css">
        
        
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
 