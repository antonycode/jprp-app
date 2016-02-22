<link rel="stylesheet" href="<?php echo base_url(); ?>/style/js/jquery-ui.css">

<script src="<?php echo base_url(); ?>/style/js/jquery-1.11.3.min.js"></script>
<!--<script src="--><?php //echo base_url(); ?><!--js/jquery-picklist.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery.ui.widget.js"></script>

<style>
    body { margin: 0.5em; }

    .pickList_sourceListContainer, .pickList_controlsContainer, .pickList_targetListContainer { float: left; margin: 0.25em; }
    .pickList_controlsContainer { text-align: center; }
    .pickList_controlsContainer button { display: block; width: 100%; text-align: center; }
    .pickList_list { list-style-type: none; margin: 0; padding: 0; float: left; width: 150px; height: 75px; border: 1px inset #eee; overflow-y: auto; cursor: default; }
    .pickList_selectedListItem { background-color: #a3c8f5; }
    .pickList_listLabel { font-size: 0.9em; font-weight: bold; text-align: center; }
    .pickList_clear { clear: both; }

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
<script>
    // Hide error/Success message after 10 seconds
    $(window).load(function () {
        setTimeout(function () {
            $('#message').fadeOut('fast');
        }, 2000);
    });

    // Function to delete a program
    function roledelete(data, name) {
        //alert(data);
        var temp = {
            state0: {
                title: 'Drop ' + name,
                html: 'Do you want to remove ' + name + '  Role?',
                buttons: {Cancel: false, Yes: true},
                focus: 1,
                submit: function (e, v, m, f) {
                    if (!v)
                        $.prompt.close();
                    else {

                        form_url = "<?php echo base_url('usermanagement/deleterole')?>" + "/" + data;
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


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        User Management
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">User Management</a></li>
        <li class="active">Roles</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="box">


            <!--Start Modal Update User-->
            <div class="modal fade bs-example-modal-lg" id="updateuserModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update User</h4>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo base_url('usermanagement/update_user'); ?>" method="post">
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">User Name:</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                           value="">
                                    <input type="hidden" id="userid" name="userid" value="">
                                </div>
                                <div>
                                    <select id="basic" name="role">
                                        <?php
                                        if ($roles != '') {
                                            foreach ($roles as $row) {
                                                echo "<option value='" . $row->attributionroleid . "' >".$row->rolename."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update User</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Modal Update Group-->

        </div>
        <!-- /.box -->
    </div>

    <div class="row"><!-- start users-->
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Available Users </h3>
                <?php
                echo '<h1 id="message" style="float: left; margin-left: 15%; margin-top: 0.2%; font-size: 18px; color: green">' . $error_message . '</h1>';
                ?>
                <?php if ($right) {
                    echo '<a href="' . base_url('User_manager/global_create_donoragency_user') . '" class="btn btn-primary btn-sm" style="background-color: green; float: left; margin-left: 30%; margin-top: 0.2%; font-size: 14px; color: white"><i class="glyphicon glyphicon-plus"></i>New Donor/Agency User</a>';
                	echo '<a href="' . base_url('User_manager/global_create_im_user') . '" class="btn btn-primary btn-sm" style="float: right; margin-right: 15%; margin-top: 0.2%; font-size: 14px; color: white"><i class="glyphicon glyphicon-plus"></i>New Implementing Mechanism User</a>';
				}else{
               	echo '<a href="' . base_url('User_manager/create_user') . '" class="btn btn-primary btn-sm" style="float: right; margin-right: 10%; margin-top: 0.2%; font-size: 14px; color: white"><i class="glyphicon glyphicon-plus"></i>New User</a>';					
				} 
				?>
            </div>

            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="users-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th >Name</th>
                        <th >Organization</th>
                        <th >User Role</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($users != '') {
                        foreach ($users as $row) {
                            echo "<tr class='grade_tr' data-id='" . $row->userid . "' data-name='" . $row->surname . "'>";
                            echo "<td>$row->surname  $row->firstname</td>";
							echo "<td>$row->orgname</td>";
 							echo "<td>$row->rolename</td>";
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
    <!-- end users-->

</section><!-- /.content -->


<!-- Pop over Class -->

<style type="text/css">

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

<div id="contextMenuIDusers" class="contextMenu" style="width: 200px; display:block;">
    <button type="button" class="close" id="btn-dismiss" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <br/>
    <ul class="" style="list-style-type:none">
        <?php
        echo '<li class=""><a href="#" id="viewuser"><i class="fa fa-plus"></i> View</a></li> <br>';
        echo '<li class=""><a href="#updateuserModal" id="updateuser"><i class="fa fa-edit"></i>Role Update</a></li> <br>';
        echo '<li class=""><a href="#" id="deleteuser" onclick=""><i class="fa fa-trash-o"></i> Delete</a></li> <br>';
        ?>
    </ul>
</div>

<!-- popover scripts-->

<!--update user groups context menu-->
<script>
    $(document).ready(function () {
        $("#contextMenuIDusers").hide();
        // $('#roles-table').DataTable();


        $('body').delegate('#users-table .grade_tr', 'click', function (event) {


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


            $("#contextMenuIDusers").show();
            $("#contextMenuIDusers").css({"top": mouseCoordinates.y, "left": mouseCoordinates.x});

            $("tbody tr").removeClass("alert alert-success");
            $(this).addClass("alert alert-success");
            var id = $(this).closest('tr').data('id');
            var name = $(this).closest('tr').data('name');
            var shortname = $(this).closest('tr').data('shortname');
            var description = $(this).closest('tr').data('desc');
            var uid = $(this).closest('tr').data('uid');

            $('#updateuser').click(function () {
                document.cookie = escape("idid") + "=" + escape(id);
                $(".modal-body #username").val(name);
                $(".modal-body #userid").val(id);
                $('#updateuserModal').modal('show');
//                $("#basic").pickList();
                return false;
            });

            document.getElementById("viewuser").href = "<?php echo base_url();?>" + "user_manager/userview/" + id;
            // document.getElementById("updaterole").href = "<?php echo base_url();?>" + "programmanager/editprogram/" + id;
            document.getElementById("deleteruser").setAttribute('onclick', "userdelete('" + id + "','" + name + "')");
        });

        $("#btn-dismiss, thead, tfoot").click(function () {

            $("#contextMenuIDuser").hide(100);
            $("tr").removeClass("alert alert-success");

        })

    });


</script>

<script type="text/javascript">

    $(function () {
        $('#users-table').dataTable({
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


