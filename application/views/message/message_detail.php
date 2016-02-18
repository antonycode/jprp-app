<!---->
<!--/**-->
<!-- * Created by IntelliJ IDEA.-->
<!-- * User: banga-->
<!-- * Date: 23/09/15-->
<!-- * Time: 17:16-->
<!-- */-->
<!---->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Mailbox
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="#">Mailbox</a></li>
        <li class="active">message detail</li>
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
                                <li><a href="<?php echo base_url(); ?>message/index"> <i class="fa fa-inbox "></i> Inbox <span class="label label-warning pull-right">16</span> </a></li>
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
                        <a href="mail_compose.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Reply"><i class="fa fa-reply"></i> Reply</a>
                        <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </a>
                    </div>
                    <h2>
                        View Message
                    </h2>
                    <div class="mail-tools tooltip-demo m-t-md">


                        <h3>
                            <span class="font-noraml">Subject: </span>Aldus PageMaker including versions of Lorem Ipsum.
                        </h3>
                        <h5>
                            <span class="pull-right font-noraml">10:15AM 02 FEB 2014</span>
                            <span class="font-noraml">From: </span>alex.smith@corporation.com
                        </h5>
                    </div>
                </div>
                <div class="mail-box">


                    <div class="mail-body">
                        <p>
                            Hello Jonathan!
                            <br/>
                            <br/>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                            took a galley of type and scrambled it to make a type <strong>specimen book.</strong>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. It has survived not only five centuries, but also the leap into electronic typesetting, remaining
                            essentially unchanged.
                        </p>
                        <p>
                            It was popularised in the 1960s with the release <a href="#" class="text-navy">Letraset sheets</a>  containing Lorem Ipsum passages, and more recently with desktop publishing software
                            like Aldus PageMaker including versions of Lorem Ipsum.
                        </p>
                        <p>
                            There are many variations of passages of <strong>Lorem Ipsum</strong>Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of.
                        </p>
                    </div>

                    <div class="mail-body text-right tooltip-demo">
                        <a class="btn btn-sm btn-white" href="mail_compose.html"><i class="fa fa-reply"></i> Reply</a>
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

<!--<script>-->
<!--    $(document).ready(function(){-->
<!--        $('.i-checks').iCheck({-->
<!--            checkboxClass: 'icheckbox_square-green',-->
<!--            radioClass: 'iradio_square-green',-->
<!--        });-->
<!--    });-->
<!--</script>-->