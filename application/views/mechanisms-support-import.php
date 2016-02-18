<link rel="stylesheet" href="<?php echo base_url(); ?>/style/js/jquery-ui.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo base_url() ?>css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo base_url() ?>css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript>
    <link rel="stylesheet" href="<?php echo base_url() ?>css/jquery.fileupload-noscript.css">
</noscript>
<noscript>
    <link rel="stylesheet" href="<?php echo base_url() ?>css/jquery.fileupload-ui-noscript.css">
</noscript>

<!-- Alert Css AND JS -->
<link href="<?php echo base_url() ?>style/alert/alerts.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>style/alert/theme.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>style/alert/theme.min.css" rel="stylesheet" type="text/css"/>


<script>

    function dropsupport(id, org, name, support, period) {
//        alert(id);
        var temp = {
            state0: {
                title: 'Drop '+name +  '.',
                html: "<p style='font-size:14px'>Do you want to drop <div style='color: red; font-size:15px; font-weight: bold;'> "+ name +" :  "+ support +"  Support In  "+ org +"  For Period "+ period +" ? </div></p>",
                buttons: {Cancel: false, Yes: true},
                focus: 1,
                submit: function (e, v, m, f) {
                    if (!v)
                        $.prompt.close();
                    else {

                        form_url = "<?php echo base_url('mechanisms/drop_mechanism_support')?>" + "/" + id;
                        //alert(form_url);
                        $.ajax({
                            url: form_url,
                            dataType: 'text',
                            type: 'post',
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
                title: name + ' Delete Confirmation',
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


</script>

<div id="loadScreen" style="display: none;width: 100%; height: 100%; top: 0pt;left: 0pt;">
    <div id="loadScr"
         style="filter: alpha(opacity = 65);  z-index: 9999;border: medium none; margin: 0pt; padding: 0pt; width: 100%; height: 100%; top: 0pt;left: 0pt; background-color: rgb(0, 0, 0); opacity: 0.2; cursor: wait; position: fixed;"></div>
    <div id="loader"
         style="z-index: 10000; position: fixed; padding: 0px; margin: 0px;width: 30%; top: 40%; left: 35%; text-align: center;cursor: wait; ">
        <img src="<?php echo base_url(); ?>/style/loaders/loader.gif" alt="loading"/>
    </div>
</div>


<div id="alertInfo" data-mozilla="36" data-pie="php" data-draggable="true" data-align="left" data-icon="info"
     data-cancel="true" data-type="info" id="smartAlert"
     style="display: none;width: 100%; height: 100%; top: 0pt;left: 0pt;">

    <div id="loadScr"
         style="filter: alpha(opacity = 65);  z-index: 9999;border: medium none; margin: 0pt; padding: 0pt; width: 100%; height: 100%; top: 0pt;left: 0pt; background-color: rgb(0, 0, 0); opacity: 0.2; cursor: wait; position: fixed;"></div>
    <div id="loader"
         style="z-index: 10000; position: fixed; padding: 0px; margin: 0px;width: 30%; top: 40%; left: 35%; text-align: center; ">

        <div id="smartAlertBox" style="width: auto; top: 142px; left: 627px;" class="ui-draggable">
            <div id="smartAlertHeader">
                <div id="smartAlertTitle">Mechanisms Import Response</div>
                <div id="smartAlertClose"></div>
            </div>
            <div id="smartAlertBody">
                <div id="smartAlertIcon"></div>
                <div id="smartAlertContent">
                    <div id="infomessage">Info Alert</div>
                </div>
            </div>
            <div id="smartAlertButtons">
                <div onclick="closeInfoAlert()" data-id="ok" class="smartAlertButton smartAlertActive">Ok</div>
            </div>
        </div>

    </div>


</div>

<script>
    function mechanismsUpload(urls) {
        var file = urls;
        // Ajax Request
        var r = $.ajax({
            type: "POST",
            dataType: 'json',
            async: false,
            url: "<?php echo base_url();?>supportimport/supportexcelimport/?url=" + file,
            cache: false,
            beforeSend: function () {
                // alert(urls);
                $('#loadScreen').show();
            },
            success: function (data) {
                //alert(data.message);
                $('#loadScreen').hide();
                $("#infomessage").html(data.message);
                $('#alertInfo').show();
            },
            error: function (data) {
                alert(data.error);
                $("#infomessage").html("placeHTML")
                $('#loadScreen').hide();
                $('#alertInfo').show();
                //alert(textStatus);
                //alert(errorThrown);

            }
        });
    }

    //Close Custom info alert box
    function closeInfoAlert() {
        //alert("woek");
        $('#alertInfo').hide();
        location.reload();
    }

</script>


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Mechanisms Support Import
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Mechanisms</a></li>
        <li class="active">Support Import</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Mechanisms Support Import Excel</h3>
                </div>
                <blockquote style="text-height: 14px;">
                    File Upload Mechanisms Support Excel file:
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
                            <!-- The fileinput-button span is used to style the file input field as button -->
                                            <span class="btn btn-success fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Add files...</span>
                                                <input type="file" name="files[]" multiple>
                                            </span>
                            <button type="submit" class="btn btn-primary start">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Start upload</span>
                            </button>
                            <button type="reset" class="btn btn-warning cancel">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span>Cancel upload</span>
                            </button>
                            <button type="button" class="btn btn-danger delete">
                                <i class="glyphicon glyphicon-trash"></i>
                                <span>Delete</span>
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
                <h3 class="box-title">Mechanisms Support Table</h3>
                <?php if ($mechanisms_right) {
                    echo '<h1 style="float: left; margin-left: 15%; margin-top: 0.2%; font-size: 18px; color: red">' . $error_message . '</h1>';
                } ?>


            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="mechanisms-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    	<th style="width:20%">Organization Unit</th>
                        <th style="width:20%">Mechanism Name</th>
                        <th style="width:10%">Datim ID</th>
                        <th style="width:10%">Program Name</th>
                        <th style="width:10%">Support Type</th>
                        <th style="width:10%">Period</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($support != '') {
                        $i = 1;
                        foreach ($support as $row) {
                            echo "<tr class='grade_tr' data-id='" . $row->id . "' data-name='" . $row->mechanism_name . "' data-org='".$row->organization_name."' data-period='".$row->period."' data-support='".$row->support_type."'>";
                            echo "<td>$row->organization_name</td>";
                            echo "<td>$row->mechanism_name</td>";
                            echo "<td>$row->datim_id</td>";
                            echo "<td>$row->program_name</td>";
							echo "<td>$row->support_type</td>";
                            echo "<td>$row->period</td>";
                            $i++;
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
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Support Import Errors Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="supporterrors-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    	<th style="width:20%">Organization Unit</th>
                        <th style="width:20%">Mechanism Name</th>
                        <th style="width:10%">Program Name</th>
                        <th style="width:10%">Support Type</th>
                        <th style="width:10%">Period</th>
                        <th style="width:10%">Error</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($import_errors != '') {
                        $i = 1;
                        foreach ($import_errors as $row) {
                            echo "<tr>";
                            echo "<td>$row->organization_name</td>";
                            echo "<td>$row->mechanism_name</td>";
                            echo "<td>$row->program_name</td>";
							echo "<td>$row->support_type</td>";
                            echo "<td>$row->start_date to $row->stop_date</td>";
                            echo "<td>$row->import_error</td>";
                            $i++;
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


<!-- jQuery 2.0.2 -->
<script src="<?php echo base_url() ?>js/jquery.min.js"></script>
<!-- Bootstrap -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/style/bootstrap-dialog/css/base.css" type="text/css">
<script src="<?php echo base_url() ?>style/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/style/bootstrap-dialog/js/jquery-impromptu.js"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo base_url() ?>style/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>style/js/plugins/datatables/dataTables.bootstrap.js"
        type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>style/js/AdminLTE/app.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>style/js/AdminLTE/demo.js" type="text/javascript"></script>
<!-- page script -->


<script type="text/javascript">
    $(function () {
        $("#mechanisms-table").dataTable();
        $('#supporterrors-table').dataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true
        });
    });
</script>


<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}


</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                
                <button class="btn btn-primary delete"  onclick="mechanismsUpload('{%=file.deleteUrl%}')"data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Upload</span>
                </button>                  
                
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}


</script>

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
        echo '<li class=""><a href="#" id="view"><i class="fa fa-plus"></i> View</a></li> <br>';
        if ($mechanisms_right) {
            echo '<li class=""><a href="#" id="edit"><i class="fa fa-edit"></i> Update</a></li> <br>';
        };
        if ($mechanisms_right) {
            echo '<li class=""><a href="#" id="remove" onclick=""><i class="fa fa-trash-o"></i> Drop Support</a></li> <br>';
        };
        if (true) {
            echo '<li class=""><a href="#" id="attribute"><i class="fa fa-plus"></i> Attribute</a></li> <br>';
        };
        ?>
    </ul>
</div>


<!--  -->
<script>

    $(document).ready(function () {
        $("#contextMenuID").hide();
        $('#programs-table').DataTable();


        $('body').delegate('#mechanisms-table .grade_tr', 'click', function (event) {


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
            var mechanism_name = $(this).closest('tr').data('name');
            var support=$(this).closest('tr').data('support');
            var period =$(this).closest('tr').data('period');
            var org =$(this).closest('tr').data('org');

            // Actions
            document.getElementById("view").href = "<?php echo base_url();?>" + "mechanisms/viewmechanism/" + id;
            document.getElementById("edit").href = "<?php echo base_url();?>" + "mechanisms/editmechanism/" + id;
            document.getElementById("remove").setAttribute('onclick', "dropsupport('" + id + "','" + org + "','" + mechanism_name + "','" + support + "','" + period + "')");
            document.getElementById("attribute").href = "<?php echo base_url();?>" + "mechanisms/mechanisms_data_attribution/" + id;

        });

        $("#btn-dismiss, thead, tfoot").click(function () {

            $("#contextMenuID").hide(100);
            $("tr").removeClass("alert alert-success");

        })

    });

</script>


<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo base_url() ?>js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php echo base_url() ?>js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo base_url() ?>js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo base_url() ?>js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="<?php echo base_url() ?>js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="<?php echo base_url() ?>js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo base_url() ?>js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo base_url() ?>js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="<?php echo base_url() ?>js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
        
 