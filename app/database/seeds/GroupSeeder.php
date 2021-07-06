<?php

class GroupSeeder extends Seeder
{

	public function run()
	{
		DB::table('acl_groups')->truncate();
		DB::table('acl_group_permissions')->truncate();		

		$group = AclGroup::create(array(
			'name'     => 'Super Admin',
			'description' => 'Super Admin'
		));

		$ids = AclPermission::all()->lists('id');
		$group->permissions()->sync($ids);

		$group = AclGroup::create(array(
			'name'     => 'Brand Admin',
			'description' => 'Brand Admin'
		));

		$ids = AclPermission::where('id','<=','8')->lists('id');
		$group->permissions()->sync($ids);

		$group = AclGroup::create(array(
			'name'     => 'Channel Super User',
			'description' => 'Channel Super User'
		));

		//$ids = AclPermission::where('id','>=','17')->lists('id');
		$ids = AclPermission::where('id','>=','41')->lists('id');		
		$group->permissions()->sync($ids);		

		$group = AclGroup::create(array(
			'name'     => 'Channel User',
			'description' => 'Channel User'
		));			

		$ids = AclPermission::where('id','>=','41')->lists('id');
		$group->permissions()->sync($ids);	

		$group = AclGroup::create(array(
			'name'     => 'Sales Dept',
			'description' => 'Sales Dept'
		));			

		$ids = AclPermission::where('id','=','1')->orWhere('id','=','4')->lists('id');
		$group->permissions()->sync($ids);			

		$group = AclGroup::create(array(
			'name'     => 'Customer Service',
			'description' => 'Customer Service'
		));			

		$ids = AclPermission::where('id','>=','59')->lists('id');
		$group->permissions()->sync($ids);				

	}

}