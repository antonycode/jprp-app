<?php
/**
 * Created by PhpStorm.
 * User: the_fegati
 * Date: 2/21/16
 * Time: 8:06 PM
 */

class Ipsl_model extends CI_Model {
    function __construct() {
        parent:: __construct();
        $this->load->database();
    }

    public function import_ipsl($data_array){
        //i dont know why i have to have this here, if you discover why please email fegati02@gmail.com
        $temp = json_decode(json_encode($data_array));
        $this->db->truncate('ipsl');

        foreach($temp as $row){
            $this->db->insert('ipsl', $row);
        }
    }

    public function import_errors($data_array){
        //i dont know why i have to have this here, if you discover why please email fegati02@gmail.com
        $temp = json_decode(json_encode($data_array));
        $this->db->truncate('ipslimporterrors');

        foreach($temp as $row){
            $this->db->insert('ipslimporterrors', $row);
        }
    }

    public function get_ipsl(){
        $data='';
        $ipsl=$this->db->get("ipsl");
        foreach ($ipsl->result() as $row) {
            $data[]=$row;
        }
        return $data;
    }

    public function get_import_errors(){
        $data='';
        $ipslerrors=$this->db->get("ipslimporterrors");
        foreach ($ipslerrors->result() as $row) {
            $data[]=$row;
        }
        return $data;
    }

	public function ipsl_user_link(){
		$deletequery="
DELETE FROM usermembership 
WHERE userinfoid in
(select groupmem.userid from usergroupmembers as groupmem,attribution_hierarchy as ath 
where groupmem.usergroupid=ath.usergroup_id and ath.level=4);		
		";
		$this->db->query($deletequery);
		$updatequery="INSERT INTO usermembership (organisationunitid,userinfoid)
select orgs.organisationunitid, groupmem.userid from usergroupmembers as groupmem, organisationunit as orgs,attribution_hierarchy as ath, ipsl as ipsl, userinfo as users
WHERE ath.code=ipsl.datimid  and orgs.code=ipsl.mflcode and groupmem.usergroupid=ath.usergroup_id and users.userinfoid=groupmem.userid";
	$this->db->query($updatequery);
	$i=0;
	
	$query="
SELECT umem.userinfoid as userinfoid ,umem.organisationunitid as organisationunitid
  FROM attribution_hierarchy as ath, usergroupmembers as gmem, usermembership as umem 
  where gmem.usergroupid=ath.usergroup_id and 
umem.userinfoid=gmem.userid and ath.level=4	
	";
	
	$umem=$this->db->query($query);
	foreach ($umem->result() as $row) {
		$parentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$row->organisationunitid));
		if ($parentid->row()->parentid!='') {
			if (sizeof($this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$parentid->row()->parentid)))<1) {
				$data=array(
					"userinfoid"=>$row->userinfoid,
					"organisationunitid"=>$parentid->row()->parentid
				);
				$this->db->insert("usermembership", $data); 
				echo "damm";
				//Grandparent
				$grandparentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$parentid->row()->parentid));
				if ($grandparentid->row()->parentid!='') {
					echo "shiet </br>";
					if (sizeof($this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$grandparentid->row()->parentid)))<1) {
						$data=array(
							"userinfoid"=>$row->userinfoid,
							"organisationunitid"=>$grandparentid->row()->parentid
						);
						//$this->db->insert("usermembership", $data); 						
					}
				}
			}						
		}

	}

	
	
	
	/*
	while ($i <= 3) {
		echo "cllla";
		$heirachyquery="
select mem.*,org.name, org.parentid from 
usermembership as mem, organisationunit as org
where org.organisationunitid=mem.organisationunitid and org.parentid not in (select mems.organisationunitid from usermembership as mems where mems.userinfoid=mem.userinfoid)				
		";
		$this->db->query($heirachyquery);
		$i=$i+1;
	}*/
	
	$querys="
SELECT umem.userinfoid as userinfoid ,umem.organisationunitid as organisationunitid
  FROM attribution_hierarchy as ath, usergroupmembers as gmem, usermembership as umem 
  where gmem.usergroupid=ath.usergroup_id and 
umem.userinfoid=gmem.userid and ath.level=4	
	";		
		$umem=$this->db->query($querys);
		foreach ($umem->result() as $row) {
			$parentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$row->organisationunitid));
			//echo "wat".$parentid->row()->parentid;
			if (is_numeric ($parentid->row()->parentid)) {
				$dbq=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$parentid->row()->parentid));
				if ($dbq->num_rows() == 0) {
					//echo "my nigga";		
					$data=array(
						"userinfoid"=>$row->userinfoid,
						"organisationunitid"=>$parentid->row()->parentid
					);
					$this->db->insert("usermembership", $data); 
					//Grandparent
					$grandparentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$parentid->row()->parentid));
					if (is_numeric ($grandparentid->row()->parentid)) {
						//echo "shiet </br>";
						$grand=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$grandparentid->row()->parentid));
						if ($grand->num_rows() == 0) {
							//echo "yes </br>";
							$data=array(
								"userinfoid"=>$row->userinfoid,
								"organisationunitid"=>$grandparentid->row()->parentid
							);
							$this->db->insert("usermembership", $data); 	
							
							//Grandparent
							$greatparentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$grandparentid->row()->parentid));
							if (is_numeric ($greatparentid->row()->parentid)) {
								//echo "shiet </br>";
								$great=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$greatparentid->row()->parentid));
								if ($great->num_rows() == 0) {
									echo "iko boss </br>";
									$data=array(
										"userinfoid"=>$row->userinfoid,
										"organisationunitid"=>$greatparentid->row()->parentid
									);
									$this->db->insert("usermembership", $data); 							
								}
							}								
													
						}
					}					
				}					
			}
	
		}	
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		public function ipsl_user_links($userinfoid, $usergroup){
		$updateorgs="INSERT INTO usermembership (organisationunitid,userinfoid)
select orgs.organisationunitid, users.userinfoid from usergroupmembers as groupmem, organisationunit as orgs,attribution_hierarchy as ath, ipsl as ipsl, userinfo as users
WHERE ath.code=ipsl.datimid  and orgs.code=ipsl.mflcode and ath.usergroup_id=$usergroup and users.userinfoid=$userinfoid ";
	$this->db->query($updateorgs);
	
	$querys="
SELECT umem.userinfoid as userinfoid ,umem.organisationunitid as organisationunitid
  FROM attribution_hierarchy as ath, usergroupmembers as gmem, usermembership as umem 
  where gmem.usergroupid=ath.usergroup_id and 
umem.userinfoid=$userinfoid and ath.level=4	
	";		
		$umem=$this->db->query($querys);
		foreach ($umem->result() as $row) {
			$parentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$row->organisationunitid));
			//echo "wat".$parentid->row()->parentid;
			if (is_numeric ($parentid->row()->parentid)) {
				$dbq=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$parentid->row()->parentid));
				if ($dbq->num_rows() == 0) {
					//echo "my nigga";		
					$data=array(
						"userinfoid"=>$row->userinfoid,
						"organisationunitid"=>$parentid->row()->parentid
					);
					$this->db->insert("usermembership", $data); 
					//Grandparent
					$grandparentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$parentid->row()->parentid));
					if (is_numeric ($grandparentid->row()->parentid)) {
						//echo "shiet </br>";
						$grand=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$grandparentid->row()->parentid));
						if ($grand->num_rows() == 0) {
							//echo "yes </br>";
							$data=array(
								"userinfoid"=>$row->userinfoid,
								"organisationunitid"=>$grandparentid->row()->parentid
							);
							$this->db->insert("usermembership", $data); 	
							
							//Grandparent
							$greatparentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$grandparentid->row()->parentid));
							if (is_numeric ($greatparentid->row()->parentid)) {
								//echo "shiet </br>";
								$great=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$greatparentid->row()->parentid));
								if ($great->num_rows() == 0) {
									echo "iko boss </br>";
									$data=array(
										"userinfoid"=>$row->userinfoid,
										"organisationunitid"=>$greatparentid->row()->parentid
									);
									$this->db->insert("usermembership", $data); 							
								}
							}								
													
						}
					}					
				}					
			}
	
		}		
	}
	
	
	public function ems(){
		//echo "Niggas";
	$querys="
SELECT umem.userinfoid as userinfoid ,umem.organisationunitid as organisationunitid
  FROM attribution_hierarchy as ath, usergroupmembers as gmem, usermembership as umem 
  where gmem.usergroupid=ath.usergroup_id and 
umem.userinfoid=gmem.userid and ath.level=4	
	";		
		$umem=$this->db->query($querys);
		foreach ($umem->result() as $row) {
			$parentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$row->organisationunitid));
			//echo "wat".$parentid->row()->parentid;
			if (is_numeric ($parentid->row()->parentid)) {
				$dbq=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$parentid->row()->parentid));
				if ($dbq->num_rows() == 0) {
					//echo "my nigga";		
					$data=array(
						"userinfoid"=>$row->userinfoid,
						"organisationunitid"=>$parentid->row()->parentid
					);
					$this->db->insert("usermembership", $data); 
				}					
			}
	
		}		
	}
}