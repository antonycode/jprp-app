 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> 
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

    .donor_form SELECT, INPUT[type="text"] {
        width: 200px;
        height:200px;
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

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1> 
                        <?php echo ucfirst($ip_org) ?> (Facility Edit)
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Sections</a></li>
                        <li class="active">Facility Edit</li>
                    </ol>
                </section> 

                <section class="content">
                    <form class="donor_form" action="<?php echo base_url()?>sections/supportfacilityedit" method="post">
                        <ul>
                            <li style="margin-left: 50%; width: 100%">
                                <label for="name" style="font-size: 20px; width:400px"> Implementing Support Date</label>
                            </li>
                            <li>
                                <li style="margin-left: 10%; width: 500%">
                                    <label for="name" style="font-size: 20px; width:110px;margin-top: -5px">Start Date :</label>
                                    <input type="text" name="start" id="datepicker-example7-start"  data-zdp_direction='["2013-01-20", false]'  value='<?php echo $start; ?>' placeholder="dd/mm/yyyy" style="height: 30px; font-size: 18px"  required pattern="[A-Za-z\s0-9]{5,}"/>
                                    <span class="form_hint">dd/mm/yyyy</span>
                                </li>       
                                <li style="margin-left: 70%; width: 50%; margin-top: -54px" >
                                    <label for="name" style="font-size: 20px; width:110px; margin-top: -5px"> End Date :</label>
                                    <input type="text" name="end"  id="datepicker-example7-end"  placeholder="dd/mm/yyyy" value='<?php echo $end; ?>' style="height: 30px; font-size: 18px; "  required pattern="[A-Za-z\s0-9]{5,}"/>
                                     <span class="form_hint">dd/mm/yyyy</span>
                                </li>                                                   
                            </li> 
                            <input type="hidden" name="sectionid" value="<?php echo $sectionid ?>">
                            <input type="hidden" name="facilityid" value="<?php echo $facilityid ?>">
                            <input type="hidden" name="partnerid" value="<?php echo $partnerid ?>">
                            <li style="margin-left: 32%; width: 100%">
                                <button class="submit" type="submit">Save</button>
                            </li>
                        </ul>   
                    </form>
                </section>


        <link rel="stylesheet" href="<?php echo base_url(); ?>/style/date/css/default.css" type="text/css">
        <script type="text/javascript" src="<?php echo base_url(); ?>/style/date/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>/style/date/js/zebra_datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>/style/date/js/core.js"></script>                
                       
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
        