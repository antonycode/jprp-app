            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php 
                                if ($this->session->userdata('gender')=='gender_female') {
                                    echo base_url()."/style/img/avatar3.png";
                                } else {
                                    echo base_url()."/style/img/avatar.png";
                                }
                                ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                        	<p style="font-size: 24px"><?php echo $this->session->userdata('name');?> </p>
                            <p><?php echo $agencyname;?> </p>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="<?php echo base_url(); ?>sections/k2d">
                                <i class="fa fa-dashboard"></i>
                                <span>JPRP Home</span>
                            </a>
                        </li>                          
                         <?php
                         if ($menu!="") {
                         	$temp = json_decode(json_encode($menu),true);
                             if (array_search('program_management', array_column($temp , 'attributionauthoritiesname'))===FALSE) {

                             }else{
                                 echo "
		                        <li class='active'>
		                            <a href=' ".base_url()."programmanager'>
		                                <i class='fa fa-tasks'></i>
		                                <span>Programs</span>
		                            </a>
		                        </li>                                   
                                 
                                 ";                             	
                             }
                         }
                         ?>
                        
   						
   						<!-- 
                        <li class="active">
                            <a href="<?php echo base_url(); ?>datasets">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>DataSets</span>
                            </a>
                        </li>
                        -->

                        <!--                                                    
                        <li class="active">
                            <a href="<?php echo base_url(); ?>implementingpartners">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Implementing partners</span>
                            </a>

                        </li> 
                        -->
                        <!--
                        <li class="active">
                            <a href="<?php echo base_url(); ?>agencies">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Partner Management</span>
                            </a>

                        </li>  -->
                        
                         <?php
                         if ($menu!="") {
                         	$temp = json_decode(json_encode($menu),true);
                             if (array_search('data_import', array_column($temp , 'attributionauthoritiesname'))===FALSE) {

                             }else{
                                 echo "
		                        <li class='active'>
		                            <a href=' ".base_url()."dataimport'>
		                                <i class='fa fa-dashboard'></i>
		                                <span>Data Import</span>
		                            </a>
		                        </li>                                   
                                 
                                 ";                             	
                             }
                         }
                         ?>  
                        <!--                      
                        <li class="active">
                            <a href="<?php echo base_url(); ?>dataimport">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Data Import</span>
                            </a>
                        </li> -->  
                         <?php
                         if ($menu!="") {
                         	$temp = json_decode(json_encode($menu),true);
                             if (array_search('moh_level', array_column($temp , 'attributionauthoritiesname'))===FALSE) {

                             }else{
                                 echo "
		                        <li class='active'>
		                            <a href=' ".base_url()."moh_manager'>
		                                <i class='fa fa-dashboard'></i>
		                                <span>MOH</span>
		                            </a>
		                        </li>                                   
                                 
                                 ";                             	
                             }
                         }
                         ?> 
                         <!--                       
                        <li class="active">
                            <a href="<?php echo base_url(); ?>moh_manager">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>MOH</span>
                            </a>
                        </li> -->
                         <?php
                         if ($menu!="") {
                         	$temp = json_decode(json_encode($menu),true);
                             if (array_search('donor_level', array_column($temp , 'attributionauthoritiesname'))===FALSE) {

                             }else{
                                 echo "
		                        <li class='active'>
		                            <a href=' ".base_url()."development_partners'>
		                                <i class='fa fa-dashboard'></i>
		                                <span>Development Partner</span>
		                            </a>
		                        </li>                                   
                                 
                                 ";                             	
                             }
                         }
                         ?>       
                         <!--                 
                        <li class="active">
                            <a href="<?php echo base_url(); ?>development_partners">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Development Partners</span>
                            </a>
                        </li> -->
                         <?php
                         if ($menu!="") {
                         	$temp = json_decode(json_encode($menu),true);
                             if (array_search('agency_level', array_column($temp , 'attributionauthoritiesname'))===FALSE) {

                             }else{
                                 echo "
		                        <li class='active'>
		                            <a href=' ".base_url()."agency_mechanism'>
		                                <i class='fa fa-dashboard'></i>
		                                <span>Agency</span>
		                            </a>
		                        </li>                                   
                                 
                                 ";                             	
                             }
                         }
                         ?>  
                         <!--                      
                        <li class="active">
                            <a href="<?php echo base_url(); ?>agency_mechanism">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Agency</span>
                            </a>
                        </li> -->
                         <?php
                         if ($menu!="") {
                         	$temp = json_decode(json_encode($menu),true);
                             if (array_search('mechanism_level', array_column($temp , 'attributionauthoritiesname'))===FALSE) {

                             }else{
                                 echo "
		                        <li class='active'>
		                            <a href=' ".base_url()."implementing_mechanism'>
		                                <i class='fa fa-dashboard'></i>
		                                <span>Implementing Mechanism</span>
		                            </a>
		                        </li>                                   
                                 
                                 ";                             	
                             }
                         }
                         ?>                        
                        <!-- 
                        <li class="active">
                            <a href="<?php echo base_url(); ?>implementing_mechanism">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Implementing Mechanism</span>
                            </a>
                        </li> -->
                        <?php
                         if ($menu!="") {
                         	$temp = json_decode(json_encode($menu),true);
                             if (array_search('ipsl_import', array_column($temp , 'attributionauthoritiesname'))===FALSE) {

                             }else{
                                 echo "
		                        <li class='active'>
		                            <a href=' ".base_url()."supportimport'>
		                                <i class='fa fa-dashboard'></i>
		                                <span>IPSL Import</span>
		                            </a>
		                        </li>                                   
                                 
                                 ";                             	
                             }
                         }
                         ?>  
                        <!--                       
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Mechanisms Manager</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url(); ?>mechanisms"><i class="fa fa-angle-double-right"></i>Mechanisms</a></li>
                                <li><a href="<?php echo base_url(); ?>supportimport"><i class="fa fa-angle-double-right"></i>Mechanisms Support</a></li>
                            </ul>
                        </li>        -->                
                        
                         <?php
                         if ($menu!="") {
                         	$temp = json_decode(json_encode($menu),true);
                             if (array_search('data_attribution', array_column($temp , 'attributionauthoritiesname'))===FALSE) {

                             }else{
                                 echo "
		                        <li class='active'>
		                            <a href=' ".base_url()."data_attribution'>
		                                <i class='fa fa-dashboard'></i>
		                                <span>Data Attribution</span>
		                            </a>
		                        </li>                                   
                                 
                                 ";                             	
                             }
                         }
                         ?>     
                         <!--                   
                        <li class="active">
                            <a href="<?php echo base_url(); ?>data_attribution">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Data Attribution</span>
                            </a>
                        </li>       -->  


                        <li class="active">
                            <a href="<?php echo base_url(); ?>message">
                                <i class="fa fa-envelope-o"></i>
                                <span>mailbox</span>
                            </a>
                        </li>                                                                                                                                                                  
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            

