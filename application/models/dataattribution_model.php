<?php


/**
 * 
 */
class Dataattribution_model extends CI_Model {
	
	public function attribution_mechanisms_programs(){
		$list=$this->db->get("attribution_mechanisms_programs");
		if (sizeof($list->result())>=1) {
			return $list->result();
		}
		return "";
	}
	
	
	public function global_attribution(){
		//Step1 Get All IPSL
		$ipsl=$this->db->get_where("attribution_mechanisms_programs");
		if (sizeof($ipsl->result())>=1) {
			foreach ($ipsl->result() as $ipslrow) {
				//echo $ipslrow->datim_id;
				$attribution_key=$this->db->get_where("attribution_keys",array("datim_id"=>$ipslrow->datim_id))->row()->categorycombo_id;
				$orgunit=$ipslrow->organization_id;
				$periods=$this->db->query("SELECT * FROM period where ( periodtypeid = '3' AND startdate <='$ipslrow->period' and  enddate >= '$ipslrow->period') ");
				$program_dataelements=$this->db->get_where("attribution_programs_dataelements",array("program_id"=>$ipslrow->program_id));
				//Step2 Check If Any Period Is Available For Data Entry	
				if (sizeof($periods->result())>=1) {
					// Step 3 Check If Program Has Dataelements
					if (sizeof($program_dataelements->result())>=1) {
						foreach ($program_dataelements->result() as $progelement) {
							foreach ($periods->result() as $period) {									
								$datavalue=$this->db->get_where("datavalue",array("dataelementid"=>$progelement->dataelement_id,"sourceid"=>$orgunit,"periodid"=>$period->periodid));
								if (sizeof($datavalue->result())==1 && $datavalue->row()->support_id == "") {
									$update=array(
										"dataelementid"=>$progelement->dataelement_id,
										"sourceid"=>$orgunit,
										"periodid"=>$period->periodid														
									);
									$data=array(
										"attributeoptioncomboid"=>$attribution_key,
										"support_id"=>$ipslrow->support_id
										
									);
									$this->db->update('datavalue', $data,$update); 										
								}elseif(sizeof($datavalue->result())>=1 && $datavalue->row()->support_id != ""){
									$size=1;
									foreach ($datavalue->result() as $row) {
										if ($row->support_id==$ipslrow->support_id) {
											//echo $period->periodid."updating </br>";
											$update=array(
												"dataelementid"=>$progelement->dataelement_id,
												"sourceid"=>$orgunit,
												"periodid"=>$period->periodid,
												"support_id"=>$ipslrow->support_id			
											);
											$data=array(
												"attributeoptioncomboid"=>$attribution_key,
												
											);
											$this->db->update('datavalue', $data,$update); 													
											break;
										}
										if($size==sizeof($datavalue->result())) {
											$newsupportdata=array(
												"dataelementid"=>$progelement->dataelement_id,
												"sourceid"=>$orgunit,
												"periodid"=>$period->periodid,
												"support_id"=>$ipslrow->support_id,
												"categoryoptioncomboid"=>$row->categoryoptioncomboid,
												"attributeoptioncomboid"=>$attribution_key,
												"value"=>$row->value,
												"storedby"=>$row->storedby,
												"created"=>$row->created											
											);
											$this->db->insert("datavalue",$newsupportdata);
										}
										
									}									
								}
							}
						}
					}else{
						
					}						
				}else{
					
				}	
	
			}
			return "success";
			
		} else {
			return "No IPSL Available For Data Attribution";
		}
		
	}
	
	
	
	
	public function program_dataattribution($prog_id){
		//Step1 Check If Program Id Exists
		$program=$this->db->get_where("attribution_programs",array("program_id"=>$prog_id));
		if (sizeof($program->result())==1) {
			//Step2 Get All IPSL Entries With The Program in The Active IPSLS
			$ipsl=$this->db->get_where("attribution_mechanisms_programs",array("program_id"=>$prog_id));
			if (sizeof($ipsl->result())>=1) {
				//Step 3 Get Program Dataelements
				$program_dataelements=$this->db->get_where("attribution_programs_dataelements",array("program_id"=>$prog_id));
				if (sizeof($program_dataelements->result())>=1) {
					foreach ($ipsl->result() as $ipslrow) {
						$attribution_key=$this->db->get_where("attribution_keys",array("datim_id"=>$ipslrow->datim_id))->row()->categorycombo_id;
						$orgunit=$ipslrow->organization_id;
						$periods=$this->db->query("SELECT * FROM period where ( periodtypeid = '3' AND startdate <='$ipslrow->period' and  enddate >= '$ipslrow->period') ");
						//Check If Any Period Is Available For Data Entry
						if (sizeof($periods->result())>=1) {
							foreach ($program_dataelements->result() as $progelement) {
								foreach ($periods->result() as $period) {
									//echo "</br>".$period->periodid."  key  ".$attribution_key;									
									$datavalue=$this->db->get_where("datavalue",array("dataelementid"=>$progelement->dataelement_id,"sourceid"=>$orgunit,"periodid"=>$period->periodid));
									if (sizeof($datavalue->result())==1 && $datavalue->row()->support_id == "") {
										$update=array(
											"dataelementid"=>$progelement->dataelement_id,
											"sourceid"=>$orgunit,
											"periodid"=>$period->periodid														
										);
										$data=array(
											"attributeoptioncomboid"=>$attribution_key,
											"support_id"=>$ipslrow->support_id
											
										);
										$this->db->update('datavalue', $data,$update); 										
									}elseif(sizeof($datavalue->result())>=1 && $datavalue->row()->support_id != ""){
										$size=1;
										foreach ($datavalue->result() as $row) {
											if ($row->support_id==$ipslrow->support_id) {
												//echo $period->periodid."updating </br>";
												$update=array(
													"dataelementid"=>$progelement->dataelement_id,
													"sourceid"=>$orgunit,
													"periodid"=>$period->periodid,
													"support_id"=>$ipslrow->support_id			
												);
												$data=array(
													"attributeoptioncomboid"=>$attribution_key,
													
												);
												$this->db->update('datavalue', $data,$update); 													
												break;
											}
											if($size==sizeof($datavalue->result())) {
												$newsupportdata=array(
													"dataelementid"=>$progelement->dataelement_id,
													"sourceid"=>$orgunit,
													"periodid"=>$period->periodid,
													"support_id"=>$ipslrow->support_id,
													"categoryoptioncomboid"=>$row->categoryoptioncomboid,
													"attributeoptioncomboid"=>$attribution_key,
													"value"=>$row->value,
													"storedby"=>$row->storedby,
													"created"=>$row->created											
												);
												$this->db->insert("datavalue",$newsupportdata);
											}
											
										}									
									}
								}
																
							}						
						}
					}
					return "success";
				} else {
					return "The Selected Program Has No Dataelements.Kindly Assign Dataelements To $progam->program_name Before Data Attribution ";
				}
				
				
			} else {
				return "No IPSL Entry Found With The Selected Program";
			}
			
			
		} else {
			return "Program Doesnot Exist";
		}
		
	}
	
	
	public function mechanism_dataattribution($datim_id){
		//Step1 Check If Datim Id Exists
		$mech=$this->db->get_where("attribution_keys",array("datim_id"=>$datim_id));
		if (sizeof($mech->result())==1) {
			//Check If DatimID Exists In The IPSL 
			$attribution_key=$mech->row()->categorycombo_id;
			$ipsl=$this->db->get_where("attribution_mechanisms_programs",array("datim_id"=>$datim_id));
			if (sizeof($ipsl->result())>=1) {
				foreach ($ipsl->result() as $ipslrow) {
					$program=$this->db->get_where("attribution_programs",array("program_id"=>$ipslrow->program_id));
					if (sizeof($program->result())==1) {
						//Check If Program Has Dataelements
						$program_dataelements=$this->db->get_where("attribution_programs_dataelements",array("program_id"=>$ipslrow->program_id));
						if (sizeof($program_dataelements->result())>=1) {
							$periods=$this->db->query("SELECT * FROM period where ( periodtypeid = '3' AND startdate <='$ipslrow->period' and  enddate >= '$ipslrow->period')' ) ");
							//Check If Period Exists
							if (sizeof($periods->result())>=1) {
								$orgunit=$ipslrow->organization_id;
								foreach ($program_dataelements->result() as $progelement) {
									foreach ($periods->result() as $period) {									
										$datavalue=$this->db->get_where("datavalue",array("dataelementid"=>$progelement->dataelement_id,"sourceid"=>$orgunit,"periodid"=>$period->periodid));
										if (sizeof($datavalue->result())==1 && $datavalue->row()->support_id == "") {
											$update=array(
												"dataelementid"=>$progelement->dataelement_id,
												"sourceid"=>$orgunit,
												"periodid"=>$period->periodid														
											);
											$data=array(
												"attributeoptioncomboid"=>$attribution_key,
												"support_id"=>$ipslrow->support_id
												
											);
											$this->db->update('datavalue', $data,$update); 										
										}elseif(sizeof($datavalue->result())>=1 && $datavalue->row()->support_id != ""){
											$size=1;
											foreach ($datavalue->result() as $row) {
												if ($row->support_id==$ipslrow->support_id) {
													//echo $period->periodid."updating </br>";
													$update=array(
														"dataelementid"=>$progelement->dataelement_id,
														"sourceid"=>$orgunit,
														"periodid"=>$period->periodid,
														"support_id"=>$ipslrow->support_id			
													);
													$data=array(
														"attributeoptioncomboid"=>$attribution_key,
														
													);
													$this->db->update('datavalue', $data,$update); 													
													break;
												}
												if($size==sizeof($datavalue->result())) {
													$newsupportdata=array(
														"dataelementid"=>$progelement->dataelement_id,
														"sourceid"=>$orgunit,
														"periodid"=>$period->periodid,
														"support_id"=>$ipslrow->support_id,
														"categoryoptioncomboid"=>$row->categoryoptioncomboid,
														"attributeoptioncomboid"=>$attribution_key,
														"value"=>$row->value,
														"storedby"=>$row->storedby,
														"created"=>$row->created											
													);
													$this->db->insert("datavalue",$newsupportdata);
												}
												
											}									
										}
									}								
								}	
							}else{
								//No Period For Attribution
							}
						}else{
							//Program Has No DataElements
						}						
					} else {
						//Un Identified Program
					}
				}		
				return "success";
			}else{
				return "Mechanism Has No IPSL Allocated To It.";
			}
		} else {
			return "Mechanism Selected Has Not Been Allocated An Attribution Key";
		}
	}
	
}
