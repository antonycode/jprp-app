<!---->
<!--/**-->
<!-- * Created by IntelliJ IDEA.-->
<!-- * User: banga-->
<!-- * Date: 23/09/15-->
<!-- * Time: 17:27-->
<!-- */-->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Mailbox
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="#">Mailbox</a></li>
        <li class="active">Compose mail</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-2">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <a class="btn btn-block btn-primary compose-mail" href="<?php echo base_url(); ?>message/compose_mail">Compose Mail</a>
                        <div class="space-25"></div>
                        <h5>Folders</h5>
                        <ul class="folder-list m-b-md" style="padding: 0 list-style-type:none">
                            <li><a href="<?php echo base_url(); ?>message/index" > <i class="fa fa-inbox "></i> Inbox <span class="label label-warning pull-right">16</span> </a></li>
                            <li><a href="<?php echo base_url(); ?>message/index"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                        </ul>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10 animated fadeInRight">
            <div class="mail-box-header">
                <div class="pull-right tooltip-demo">
                    <a href="<?php echo base_url(); ?>message/index" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Discard</a>
                </div>
                <h2>
                    Compose mail
                </h2>
            </div>
            <div class="mail-box">


                <div class="mail-body">

                    <form class="form-horizontal" method="get">
                        <div class="form-group"><label class="col-sm-2 control-label">To:</label>

                            <div class="col-sm-5"><input type="text" title="receiver's  username" placeholder="admin" class="form-control"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Subject:</label>

                            <div class="col-sm-5"><input type="text" placeholder="Hello" title="Subject of the Message" class="form-control" value=""></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Message:</label>

                            <div class="col-sm-6">
                                <textarea class="form-control" rows="15" id="comment"></textarea>
                            </div>
                        </div>

                        <div class="col-md-offset-2">
                            <button type="submit" class="btn btn-success"><i class="fa fa-reply"></i>Send</button>
                        </div>
                    </form>

                </div>

                <div class="clearfix"></div>


            </div>
        </div>
    </div>
</div>

</section>

<!-- jQuery 2.0.2 -->
<script src="<?php echo base_url(); ?>/style/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>/style/js/bootstrap.min.js" type="text/javascript"></script>
<!--Main js libs-->
<script src="<?php echo base_url(); ?>js/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>js/slimscroll/jquery.slimscroll.min.js"></script>

<!-- iCheck -->
<script src="<?php echo base_url(); ?>js/iCheck/icheck.min.js"></script>
<!---->
<!--<script>-->
<!--    $(document).ready(function(){-->
<!--        $('.i-checks').iCheck({-->
<!--            checkboxClass: 'icheckbox_square-green',-->
<!--            radioClass: 'iradio_square-green',-->
<!--        });-->
<!--    });-->
<!--</script>-->