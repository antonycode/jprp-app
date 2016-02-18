<!--/**-->
<!-- * Created by IntelliJ IDEA.-->
<!-- * User: banga-->
<!-- * Date: 13/09/15-->
<!-- * Time: 07:13-->
<!-- */-->
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
    .donor_form input{
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

    .donor_form SELECT{
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

<div id="results"></div>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Add Implementing Mechanism
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Agency</a></li>
        <li class="active">Add Mechanism</li>
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

    <form class="donor_form" id="agency_details" action="<?php echo base_url('agency_mechanism/save_mechanism')?>" method="post" style="margin-left: -30px ">
        <ul>
            <li>
                <h2>Mechanism Details </h2>
                <span class="required_notification">* Denotes Required Field</span>
            </li>
            <li>
                <label for="name">Mechanism Name:</label>
                <input type="text" name="mechanism_name" id=""  placeholder="9171 - South Rift Valley"  required pattern="{10,}"  />
                <span class="form_hint">Mechanism Name Must Be Of Atleast 10 Characters</span>
            </li>
            <li>
                <label for="name">Datim ID:</label>
                <input type="text" name="datim_id" id=""  placeholder="11243"  required pattern="[1-9][0-9]{4,}"  />
                <span class="form_hint">Mechanism ID Must Be Of Atleast 4 Integer Character Long</span>
            </li>
            <li>
                <label for="name">Partner Name:</label>
                <input type="text" name="partner_name" id=""  placeholder="South Rift Valley VCT"  required pattern="{10,}"  />
                <span class="form_hint">Partner Name Must Be Of Atleast 10 Characters</span>
            </li>
            <li>
                <label for="name">KePMS ID:</label>
                <input type="text" name="kepms_id" id=""  placeholder="124"  pattern="[1-9][0-9]{1,}"  />
                <span class="form_hint">Mechanism ID Must Be Of Atleast 1 Integer Character Long</span>
            </li>
            <li>
                <label for="name">Mechanism Start Date:</label>
                <input type="text" name="start_date" id="start_date" required pattern="\d{4}-\d{1,2}-\d{1,2}"  placeholder="yyyy-mm-dd"/>
                <span class="form_hint">Date format must be yyyy-mm-dd</span>
            </li>
            <li>
                <label for="name">Mechanism End Date:</label>
                <input type="text" name="end_date" id="end_date" required pattern="\d{4}-\d{1,2}-\d{1,2}" placeholder="yyyy-mm-dd"/>
                <span class="form_hint">Date format must be yyyy-mm-dd</span>
            </li>
            <li>
                <div>
                    <label for="datasets" style="font-size: 16px; width: 200px">Program Search </label>
                    <input id="textbox" type="text" class="form-control" placeholder="Program Search"/>
                </div>
                <section class="container">

                    <div>
                        <div>
                            <label for="name" style="font-size: 16px; width: 200px">Programs </label>
                        </div>
                        <div>
                            <select id="leftValues" size="10" multiple style="width:330px; height:250px;">
                                <?php
                                if ($programs!='') {
                                    foreach ($programs as $row) {
                                        echo "<option value='$row->program_id'>$row->program_name</option>";
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
                                <label for="name" style="font-size: 16px; margin-left:0px; width: 200px">Selected Programs </label>
                            </div>
                            <div>
                                <select id="rightValues" size="10" name='programs[]' style="width:330px; height:250px;" multiple required >
                                </select>
                            </div>
                        </div>
                    </div>

                </section>
            </li>
            <li style="margin-left: 20%; width: 100%">
                <button class="submit" type="submit">Submit</button>
            </li>
        </ul>

    </form>

</section>


<script type="text/javascript">

    $(window).load(function () {
        $("#rightValues option").prop("selected", true);
    });

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
            $("#rightValues option").prop("selected", true);
        });
    });
    $(function() {
        $("#example1").dataTable();
        $("#supportedorgs").dataTable();
        $('#edit_facilities').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
        $("#select").click(function () {
            $("#sel_table").html("");
            var html = '';
            $("#facility-edit tbody tr").not(':first').not(':last').remove();
            var i=1;
            $.each( $("#rightValues option:selected"), function(id, name){
                //console.log(id + '=' + name.value + '->' + $(this).text());
                html += '<tr id="row_'+ i +'"> <td> <input name="'+ i +'_uuid" DISABLED value="' + name.value + '" style="width:7em"></td><td> <div style="width:200px">' + $(this).text() +
                    '</div></td><td>'+ <?php if ($programs!='') {echo '\'<select style="min-width:150px; max-width: 200px; height:30px;">'; foreach ($programs as $row) { echo '<option value="'.$row->program_id.'">'.$row->program_name.'</option>';}echo '</select>\'';}?>  +
                        '</td><td><select style="min-width:150px; max-width: 200px; height:30px;"><option value="TA">TA</option><option value="DSD" >DSD</option></select> </td><td><input style="width:150px" type="text" class="datepicker" id="'+ i +'" onclick="$(this).datepicker().datepicker('+"'option',"+"'dateFormat',"+"'yy-mm-dd'"+').datepicker('+"'show'"+')" required> </td>' +
                    '<td> <input style="width:150px" type="text" class="datepicker" id="'+ i +'_b" onclick="checkPrev('+i+'); $(this).datepicker().datepicker('+"'option',"+"'dateFormat',"+"'yy-mm-dd'"+').datepicker('+"'show'"+')" required> </td> </tr>';
                i++;
            });
            //html += '</tbody> </table>';
            $("#sel_table").append(html);
        });
    });
    // object to hold table data
    function dataRow(id,sdate,edate) {
        this.dxCode = id;
        this.dxSDate = sdate;
        this.dxEDate = edate;
    }


    $(document).ready(function(){

        $("#start_date").datepicker({
            defaultDate: "+1w",
            dateFormat:"yy-mm-dd",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
                $("#end_date").datepicker( "option", "minDate", selectedDate );
            }
        });

        $("#end_date").datepicker({
            defaultDate: "+4w",
            dateFormat:"yy-mm-dd",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
                $("#start_date").datepicker( "option", "maxDate", selectedDate );
            }
        });
    });

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
