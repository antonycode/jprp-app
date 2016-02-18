<?php

/**
 * 
 */
class Usermanagement_model extends CI_Model {

	
	public function get_global_users(){
		$query="SELECT
 users.userinfoid as userid, users.surname as surname, users.firstname as firstname,groups.name as orgname, roles.rolename as rolename
FROM userinfo users, usergroup groups,usergroupmembers members,attribution_roles roles
where users.userinfoid=members.userid and groups.usergroupid=members.usergroupid and roles.attributionroleid=CASE 
            WHEN users.attributionroleid is not null
               THEN users.attributionroleid
               ELSE groups.attributionroleid
       END  
 
 ";		
		$users=$this->db->query($query);
		if (sizeof($users->result())>0) {
			return $users->result();
		} else {
			return "";
		}
	}
	
	public function get_org_users($group_id){
		$query="SELECT
 users.userinfoid as userid, users.surname as surname, users.firstname as firstname,groups.name as orgname, roles.rolename as rolename
FROM userinfo users, usergroup groups,usergroupmembers members,attribution_roles roles
where users.userinfoid=members.userid and groups.usergroupid=$group_id and roles.attributionroleid=CASE 
            WHEN users.attributionroleid is not null
               THEN users.attributionroleid
               ELSE groups.attributionroleid
       END  
 
 ";			$users=$this->db->query($query);
		if (sizeof($users->result())>0) {
			return $users->row();
		} else {
			return "";
		}		
	}
	
	public function get_global_groups(){
        $this->db->select('*');
        $this->db->from('usergroup');
        $this->db->join('attribution_roles', 'attribution_roles.attributionroleid=usergroup.attributionroleid');
        $this->db->join('attribution_hierarchy', 'attribution_hierarchy.uid=usergroup.uid');
        $this->db->join('attribution_hierarchy_levels', 'attribution_hierarchy_levels.level_id=attribution_hierarchy.level');
        $groups = $this->db->get();
		if (sizeof($groups->result())>0) {
			return $groups->result();
		} else {
			return "";
		}		
	}
	
	public function get_devuid($group_id){
		return $this->db->get_where("usergroups",array("usergroupid"=>$group_id))->row()->uid;
	}
    public function get_all_roles(){
        $roles = $this->db->get('attribution_roles');
		if (sizeof($roles->result())>0) {
			return $roles->result();
		} else {
			return "";
		}        
    }	
	public function update_group($groupId, $roleId){	
	        $this->db->where('usergroupid', $groupId);
	        $this->db->update('usergroup', array("attributionroleid"=>$roleId));
	}
}

