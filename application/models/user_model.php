<?php

/**
 * 
 */
class User_model extends CI_Model {
	
	function get_user_role($authorities_name, $roleid){
		$query="SELECT ar.*
  FROM attribution_roles ar, attribution_roles_members arm, attributionauthorities au 
  where ar.attributionroleid=$roleid and arm.attributionroleid=ar.attributionroleid and au.attributionauthoritiesid=arm.atributionauthoritesid 
  and au.attributionauthoritiesname = '$authorities_name' ;";
		$role = $this->db->query($query);
		//echo $this->db->last_query();
		if (sizeof($role->result())!=0) {
			return true;
		} else {
			return false;
		}
		
	}
	
	public function menu_items($roleid){
		$query="SELECT au.* FROM attribution_roles ar, attribution_roles_members arm, attributionauthorities au where ar.attributionroleid=$roleid and arm.attributionroleid=ar.attributionroleid and au.attributionauthoritiesid=arm.atributionauthoritesid ";
		$role = $this->db->query($query);
		//echo $this->db->last_query();
		if (sizeof($role->result())!=0) {
			return $role->result();
		} else {
			return "";
		}  
	}
	
}
