    <style type="text/css">     
        .agency_form ul {
            width:750px;
            list-style-type:none;
            list-style-position:outside;
            margin:0px;
            padding:0px;
        }
        .agency_form li{
            padding:12px; 
            position:relative;
            margin-left: 10%;
        } 
        .agency_form li:first-child, .agency_form li:last-child {
            border-bottom:0px solid #777;
        }
        
        /* === Form Header === */
        .agency_form h2 {
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
        .agency_form label {
            width:150px;
            margin-top: 3px;
            display:inline-block;
            float:left;
            padding:3px;
        }
        .agency_form input, .agency_form select {
            height:30px; 
            width:220px; 
            padding:5px 8px;
        }
        .agency_form textarea {padding:8px; width:300px;}
        .agency_form button {margin-left:156px;}
        
            /* form element visual styles */
           .agency_form select, .agency_form input, .agency_form textarea { 
                border:1px solid #aaa;
                box-shadow: 0px 0px 3px #ccc, 0 10px 15px #eee inset;
                border-radius:2px;
                padding-right:30px;
                -moz-transition: padding .25s; 
                -webkit-transition: padding .25s; 
                -o-transition: padding .25s;
                transition: padding .25s;
            }
            .agency_form select:focus, input:focus, .agency_form textarea:focus {
                background: #fff; 
                border:1px solid #555; 
                box-shadow: 0 0 3px #aaa; 
                padding-right:70px;
            }
        
        /* === HTML5 validation styles === */   
        .agency_form select:required,input:required, .agency_form textarea:required {
            background: #fff url(images/red_asterisk.png) no-repeat 98% center;
        }
        .agency_form select:required:valid, input:required:valid, .agency_form textarea:required:valid {
            background: #fff url(images/valid.png) no-repeat 98% center;
            box-shadow: 0 0 5px #5cd053;
            border-color: #28921f;
        }
        .agency_form select:focus:invalid,input:focus:invalid, .agency_form textarea:focus:invalid {
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
        .agency_form input:focus + .form_hint {display: inline;}
        .agency_form select:focus + .form_hint {display: inline;}
        .agency_form input:required:valid + .form_hint {background: #28921f;}
        .agency_form select:required:valid + .form_hint {background: #28921f;}
        .agency_form input:required:valid + .form_hint::before {color:#28921f;}
        .agency_form select:required:valid + .form_hint::before {color:#28921f;}
            
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
        
        
    </style>






 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
     <script type="text/javascript">// <![CDATA[
     $(document).ready(function(){
         $('#agencylevel').change(function(){ //any select change on the dropdown with id country trigger this code
             $("#parents > option").remove(); //first of all clear select items
             var levelid = $('#agencylevel').val(); // here we are taking country id of the selected one.
             $.ajax({
                 type: "POST",
                 url: "http://localhost/associates/agencies/getparent/"+levelid, //here we are calling our user controller and get_cities method with the country_id
                 
                 success: function(getparent) //we're calling the response json array 'cities'
                 {
                 $.each(getparent,function(id,city) //here we're doing a foeach loop round each city with id as the key and city as the value
                 {
                 var opt = $('<option />'); // here we're creating a new select option with for each city
                 opt.val(id);
                 opt.text(city);
                 $('#parents').append(opt); //here we will append these new select options to a dropdown with the id 'cities'
                 });
                 }
             
             });
         
         });
     });
     // ]]>
</script>

 












                <section class="content-header">
                    <h1>
                        Agency Details
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Agency Update</a></li>
                        <li class="active">Agency Details</li>
                    </ol>
                </section>
                

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <div class="col-lg-6">
                        <form class="agency_form" action="<?php echo base_url()."agencies/agencyupdate/".$agencyid; ?>" method="post">
                                        <ul>
                                            <li>
                                                 <h2>Agency Update </h2>
                                            </li>

                                                            <li>
                                                                <label for='name'>Agency ID:</label>
                                                                <input type='text' name='agencyid'  value='<?php echo $agency->row()->usergroupid; ?>'  required readonly />
                                                            </li>                                            
                                                            <li>
                                                                <label for='name'>Agency Name :</label>
                                                                <input type='text' name='name'  value='<?php echo $agency->row()->name; ?>'  required readonly/>
                                                            </li>
                                                            <li>
                                                                <label for="Level">Agency Level: </label>
                                                                <?php $levels['#'] = 'Please Select'; ?>
                                                                <?php echo form_dropdown('levelid', $levels,'#','id="agencylevel"' ,'required'); ?>                                                                
                                                                 <span class='form_hint'>Select Level From Drop Down</span>
                                                            </li>                                           
                                                            <li>
                                                                 <?php $parents['#'] = 'Please Select'; ?>
                                                                <label for="city">Agency Parent: </label>
                                                                <?php echo form_dropdown('parentid', $parents, '#', 'id="parents"','required'); ?><br />                                                                                                                               
                                                                <span class='form_hint'>Select Agency Parent From Drop Down</span>
                                                            </li>
                                                                                                                                                                                                                                       
                                            <li>
                                                <button class="submit" type="submit">Update</button>
                                            </li>
                                        </ul>
                        </form>
                    </div>                                
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>