<?php
/**
 * Created by PhpStorm.
 * User: the_fegati
 * Date: 9/2/15
 * Time: 10:39 AM
 */
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/style/js/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
    .donor_form h2 {
        margin: 0;
        display: inline;
    }

    .required_notification {
        color: #d45252;
        margin: 5px 0 0 0;
        display: inline;
        float: right;
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
<script type="text/javascript">

    $(document).ready(function () {
        var dataSetsArray = [["UpS2bTVcClZ", "MOH 711 Integrated RH, HIVAIDS, Malaria, TB & Nutrition"],
            ["kAofV66isvC", "MOH 731-1 HIV Counselling And Testing"], ["yrYwif6R6sH", "MOH 731-2 PMTCT"], ["GGgrU5QkjVs", "MOH 731-3 Care and Treatment"],
            ["NJHaY8wlURg", "MOH 731-4 Voluntary Male Circumcision"], ["UeBJcYEoHeA", "MOH 731-5 Post-Exposure Prophylaxis"], ["IH4pYzRqTSE", "MOH 731-6 Blood Safety"]];

        for (var i = dataSetsArray.length - 1; i >= 0; i--) {
            var select = document.getElementById("leftValues")
            var opt = document.createElement('option');
            opt.innerHTML = dataSetsArray[i][1];
            opt.value = dataSetsArray[i][0];
            select.appendChild(opt);

        }
        ;
    });

    $(function () {
        $('.date-picker').datepicker({
            beforeShow: function () {
                $('#hideMonth').html('.ui-datepicker-calendar{display:none;}');
            },
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'yyMM',
            monthNames: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
            monthNamesShort: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
            onClose: function () {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
                setTimeout(function () {
                    $('#hideMonth').html('');
                }, 100);
            }
        });
    });

</script>
<script type="text/javascript">
    function submitform(data) {
        //alert(data);
        var temp = {
            state0: {
                title: 'Program Creation',
                html: 'Do you want to  create the program with selected dataelements?',
                buttons: {Cancel: false, Submit: true},
                focus: 1,
                submit: function (e, v, m, f) {
                    if (!v)
                        $.prompt.close();
                    else {
                        var myArray = new Array(document.getElementById("pname").value, "Volvo", document.getElementById("rightValues").value);
                        var x = document.getElementById("rightValues");
                        var dataelements = " ";
                        var i;
                        for (i = 0; i < x.options.length; i++) {
                            if (i = 1) {
                                dataelements = '{"dname": " ' + x.options[i].value + '","duid":"" }';
                            } else {
                                dataelements = '{"dname": " ' + x.options[i].value + '","duid":"" }' + ',' + dataelements;
                            }
                            ;

                        }
                        ;
                        alert(JSON.stringify(dataelements));

                        var data = JSON.stringify(myArray);
                        alert(data);
                        var form = $("#program_details");
                        form_url = form.attr("action");
                        alert(form_url);
                        $.ajax({
                            url: form_url,
                            dataType: 'text',
                            type: 'post',
                            data: {"data": data},
                            contentType: 'application/x-www-form-urlencoded',
                            success: function (data, textStatus, jQxhr) {
                                $('#response').html(data);
                                $.prompt.goToState('state1');//go forward
                            },
                            error: function (jqXhr, textStatus, errorThrown) {
                                console.log(errorThrown);
                            }
                        });
                    }
                    return false;
                }
            },
            state1: {
                title: 'Program Creation Confirmation',
                html: '<p id="response"></p>',
                buttons: {Finish: 1},
                focus: 0,
                submit: function (e, v, m, f) {
                    if (v == 1)
                        window.location.reload(true); //Refresh page to reflect the changes
                    else  $.prompt.close();//close dialog
                    return false;
                }
            }
        };

        $.prompt(temp, {
            close: function (e, v, m, f) {
                if (v !== undefined) {
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

    function formerror() {
        var tourSubmitFunc = function (e, v, m, f) {
                if (v === -1) {
                    $.prompt.prevState();
                    return false;
                }
                else if (v === 1) {
                    $.prompt.nextState();
                    return false;
                }
            },
            tourStates = [
                {
                    title: 'Before submitting',
                    html: 'Please make sure you Fill All Required Fields',
                    buttons: {Next: 1},
                    focus: 0,
                    position: {container: '#program_details', x: 250, y: 60, width: 300, arrow: 'tc'},
                    submit: tourSubmitFunc
                },
                {
                    title: 'Start Date',
                    html: 'The date of beggining support of the program in the facility.',
                    buttons: {Prev: -1, Next: 1},
                    focus: 1,
                    position: {container: '#datepicker-example7-start', x: 170, y: 0, width: 300, arrow: 'lt'},
                    submit: tourSubmitFunc
                },
                {
                    title: 'End Date',
                    html: 'The date of dropping support of the program in the facility',
                    buttons: {Prev: -1, Next: 1},
                    focus: 1,
                    position: {container: '#datepicker-example7-end', x: -280, y: 0, width: 300, arrow: 'rt'},
                    submit: tourSubmitFunc
                },
                {
                    title: 'List of Facilities',
                    html: 'You can select multiple facilities and click the >> button to select',
                    buttons: {Prev: -1, Next: 1},
                    focus: 1,
                    position: {container: '#leftValues', x: 180, y: 10, width: 300, arrow: 'lt'},

                    submit: tourSubmitFunc
                },
                {
                    title: 'Selected Facilities',
                    html: 'You can undo selection by selecting the facility and clicking the << button to unselect',
                    buttons: {Prev: -1, Next: 1},
                    focus: 1,
                    position: {container: '#rightValues', x: -270, y: 10, width: 300, arrow: 'rt'},
                    submit: tourSubmitFunc
                },
                {
                    title: 'Submit',
                    html: 'You can complete the selection by clicking Submit button',
                    buttons: {Done: 2},
                    focus: 0,
                    position: {container: '.submit', x: -100, y: -200, width: 300, arrow: 'bc'},
                    submit: tourSubmitFunc
                }
            ];
        $.prompt(tourStates, {
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
<div id="results"></div>
<!-- Content Header (Page header) -->
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

        $(function () {
            $('#orgleftValues').filterByText($('#orgtextbox'), true);
        });

    </script>

    <form class="donor_form" id="program_details" action="<?php echo base_url('dataimport/fetch_data/'); ?>"
          method="post">
        <ul>
            <li>
                <label for="name" style="font-size: 16px; width:250px;margin-left:80%">Import Data from National
                    DHIS2</label>

                <div>
                    <label for="startDate" style="...">Select Reporting Period:&nbsp;&nbsp;</label>&nbsp;
                    <input name="startDate" id="startDate" class="date-picker"/>
                    <style id='hideMonth'></style>
                </div>
                <section class="container">
                    <div>
                        <div>
                            <label for="name" style="font-size: 16px; width: 200px">Datasets Available </label>
                        </div>
                        <div>
                            <input id="textbox" type="text" placeholder="Datasets Search Box"/><br/>
                            <select name="datasets" id="leftValues" size="4" multiple
                                    style="width:450px; height:250px;">
                            </select>
                        </div>
                    </div>
                    <div style="margin-top: 5%;">
                        <input type="button" id="btnRight" value="&gt;&gt;"/>
                        <input type="button" id="btnLeft" value="&lt;&lt;" style="margin-top: 30px"/>
                    </div>
                    <div>
                        <div>
                            <div>
                                <label for="name" style="font-size: 16px; margin-left:45px; width: 200px">Selected
                                    Datasets </label>
                            </div>
                            <div>
                                <select id="rightValues" size="5" name='datasets[]' style="width:400px; height:250px;"
                                        multiple required readonly>
                                    <?php
                                    //                                    if ($program_dataelements!='') {
                                    //                                        foreach ($program_dataelements as $row) {
                                    //                                            echo "<option value='$row->dataelement_uid'>$row->dataelement_name</option>";
                                    //                                        }
                                    //                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="container">
                    <div>
                        <div>
                            <label for="name" style="font-size: 16px; width: 200px">Available Orgunits </label>
                        </div>
                        <div>
                            <input id="orgtextbox" type="text" placeholder="OrgUnits Search Box"/><br/>
                            <select name="orgUnits" id="orgleftValues" size="4" multiple
                                    style="width:450px; height:250px;">
                                <?php
                                if ($orgUnits != '') {
                                    foreach ($orgUnits as $row) {
                                        echo "<option value='$row->org_uuid'>$row->org_name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div style="margin-top: 5%;">
                        <input type="button" id="orgbtnRight" value="&gt;&gt;"/>
                        <input type="button" id="orgbtnLeft" value="&lt;&lt;" style="margin-top: 30px"/>
                    </div>
                    <div>
                        <div>
                            <div>
                                <label for="name" style="font-size: 16px; margin-left:45px; width: 200px">Selected
                                    Orgunits </label>
                            </div>
                            <div>
                                <select id="orgrightValues" size="5" name='orgUnits[]'
                                        style="width:400px; height:250px;" multiple required readonly>
                                    <?php
                                    //                                    if ($program_dataelements!='') {
                                    //                                        foreach ($program_dataelements as $row) {
                                    //                                            echo "<option value='$row->dataelement_uid'>$row->dataelement_name</option>";
                                    //                                        }
                                    //                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>
            </li>
            <li style="margin-left: 32%; width: 100%">
                <button class="submit" type="submit">Submit</button>
            </li>
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

        $("#orgbtnLeft").click(function () {
            var selectedItem = $("#orgrightValues option:selected");
            $("#orgleftValues").append(selectedItem);
        });

        $("#orgbtnRight").click(function () {
            var selectedItem = $("#orgleftValues option:selected");
            $("#orgrightValues").append(selectedItem);
        });

        $("#orgrightValues").change(function () {
            var selectedItem = $("#orgrightValues option:selected");
            $("#orgtxtRight").val(selectedItem.text());
        });
        $("#program_detailsss").submit(function (event) {
            // Stop form from submitting normally
            event.preventDefault();
            var form = $(this);
            // create array to hold your data
            submitform();
        });
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


<link rel="stylesheet" href="<?php echo base_url(); ?>/style/date/css/default.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/style/bootstrap-dialog/css/base.css" type="text/css">


<script type="text/javascript" src="<?php echo base_url(); ?>/style/date/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/style/date/js/core.js"></script>

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
