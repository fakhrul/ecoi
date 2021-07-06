<?php

class PermissionSeeder extends Seeder
{

	public function run()
	{
		DB::table('acl_permissions')->truncate();

		//Admin Channels
		AclPermission::create(array(
			'ident'     => 'admin.channels.index',
			'description' => 'Admin Channel Index Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.channels.create',
			'description' => 'Admin Channel Create Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.channels.store',
			'description' => 'Admin Channel Save'
		));
		AclPermission::create(array(
			'ident'     => 'admin.channels.show',
			'description' => 'Admin Channel Show Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.channels.edit',
			'description' => 'Admin Channel Edit Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.channels.update',
			'description' => 'Admin Channel Update'
		));
		AclPermission::create(array(
			'ident'     => 'admin.channels.destroy',
			'description' => 'Admin Channel Delete'
		));
		AclPermission::create(array(
			'ident'     => 'admin.channels.restore',
			'description' => 'Admin Channel Restore'
		));	

		//Admin Users
		AclPermission::create(array(
			'ident'     => 'admin.users.index',
			'description' => 'Admin User Index Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.users.create',
			'description' => 'Admin User Create Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.users.store',
			'description' => 'Admin User Save'
		));
		AclPermission::create(array(
			'ident'     => 'admin.users.show',
			'description' => 'Admin User Show Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.users.edit',
			'description' => 'Admin User Edit Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.users.update',
			'description' => 'Admin User Update'
		));
		AclPermission::create(array(
			'ident'     => 'admin.users.destroy',
			'description' => 'Admin User Delete'
		));
		AclPermission::create(array(
			'ident'     => 'admin.users.restore',
			'description' => 'Admin User Restore'
		));	

		//Admin Brand
		AclPermission::create(array(
			'ident'     => 'admin.brands.index',
			'description' => 'Admin Brand Index Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.brands.create',
			'description' => 'Admin Brand Create Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.brands.store',
			'description' => 'Admin Brand Save'
		));
		AclPermission::create(array(
			'ident'     => 'admin.brands.show',
			'description' => 'Admin Brand Show Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.brands.edit',
			'description' => 'Admin Brand Edit Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.brands.update',
			'description' => 'Admin Brand Update'
		));
		AclPermission::create(array(
			'ident'     => 'admin.brands.destroy',
			'description' => 'Admin Brand Delete'
		));
		AclPermission::create(array(
			'ident'     => 'admin.brands.restore',
			'description' => 'Admin Brand Restore'
		));	


		//User
		AclPermission::create(array(
			'ident'     => 'users.index',
			'description' => 'User Index Page'
		));
		AclPermission::create(array(
			'ident'     => 'users.create',
			'description' => 'User Create Page'
		));
		AclPermission::create(array(
			'ident'     => 'users.store',
			'description' => 'User Save'
		));
		AclPermission::create(array(
			'ident'     => 'users.show',
			'description' => 'User Show Page'
		));
		AclPermission::create(array(
			'ident'     => 'users.edit',
			'description' => 'User Edit Page'
		));
		AclPermission::create(array(
			'ident'     => 'users.update',
			'description' => 'User Update'
		));
		AclPermission::create(array(
			'ident'     => 'users.destroy',
			'description' => 'User Delete'
		));
		AclPermission::create(array(
			'ident'     => 'users.restore',
			'description' => 'User Restore'
		));

		//Branch
		AclPermission::create(array(
			'ident'     => 'branch.index',
			'description' => 'Branch Index Page'
		));
		AclPermission::create(array(
			'ident'     => 'branch.create',
			'description' => 'Branch Create Page'
		));
		AclPermission::create(array(
			'ident'     => 'branch.store',
			'description' => 'Branch Save'
		));
		AclPermission::create(array(
			'ident'     => 'branch.show',
			'description' => 'Branch Show Page'
		));
		AclPermission::create(array(
			'ident'     => 'branch.edit',
			'description' => 'Branch Edit Page'
		));
		AclPermission::create(array(
			'ident'     => 'branch.update',
			'description' => 'Branch Update'
		));
		AclPermission::create(array(
			'ident'     => 'branch.destroy',
			'description' => 'Branch Delete'
		));
		AclPermission::create(array(
			'ident'     => 'branch.restore',
			'description' => 'Branch Restore'
		));

		//PrepaidOrder
		AclPermission::create(array(
			'ident'     => 'prepaidorder.index',
			'description' => 'PrepaidOrder Index Page'
		));
		AclPermission::create(array(
			'ident'     => 'prepaidorder.create',
			'description' => 'PrepaidOrder Create Page'
		));
		AclPermission::create(array(
			'ident'     => 'prepaidorder.store',
			'description' => 'PrepaidOrder Save'
		));
		AclPermission::create(array(
			'ident'     => 'prepaidorder.show',
			'description' => 'PrepaidOrder Show Page'
		));
		AclPermission::create(array(
			'ident'     => 'prepaidorder.edit',
			'description' => 'PrepaidOrder Edit Page'
		));
		AclPermission::create(array(
			'ident'     => 'prepaidorder.update',
			'description' => 'PrepaidOrder Update'
		));
		AclPermission::create(array(
			'ident'     => 'prepaidorder.destroy',
			'description' => 'PrepaidOrder Delete'
		));
		AclPermission::create(array(
			'ident'     => 'prepaidorder.restore',
			'description' => 'PrepaidOrder Restore'
		));
		AclPermission::create(array(
			'ident'     => 'prepaidorder.print',
			'description' => 'PrepaidOrder Restore'
		));			

		//PortIn
		AclPermission::create(array(
			'ident'     => 'portin.index',
			'description' => 'PortIn Index Page'
		));
		AclPermission::create(array(
			'ident'     => 'portin.create',
			'description' => 'PortIn Create Page'
		));
		AclPermission::create(array(
			'ident'     => 'portin.store',
			'description' => 'PortIn Save'
		));
		AclPermission::create(array(
			'ident'     => 'portin.show',
			'description' => 'PortIn Show Page'
		));
		AclPermission::create(array(
			'ident'     => 'portin.edit',
			'description' => 'PortIn Edit Page'
		));
		AclPermission::create(array(
			'ident'     => 'portin.update',
			'description' => 'PortIn Update'
		));
		AclPermission::create(array(
			'ident'     => 'portin.destroy',
			'description' => 'PortIn Delete'
		));
		AclPermission::create(array(
			'ident'     => 'portin.restore',
			'description' => 'PortIn Restore'
		));	
		AclPermission::create(array(
			'ident'     => 'portin.print',
			'description' => 'PortIn Restore'
		));											

		//Admin PrepaidOrder
		AclPermission::create(array(
			'ident'     => 'admin.prepaidorder.index',
			'description' => 'PrepaidOrder Index Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.prepaidorder.create',
			'description' => 'PrepaidOrder Create Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.prepaidorder.store',
			'description' => 'PrepaidOrder Save'
		));
		AclPermission::create(array(
			'ident'     => 'admin.prepaidorder.show',
			'description' => 'PrepaidOrder Show Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.prepaidorder.edit',
			'description' => 'PrepaidOrder Edit Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.prepaidorder.update',
			'description' => 'PrepaidOrder Update'
		));
		AclPermission::create(array(
			'ident'     => 'admin.prepaidorder.destroy',
			'description' => 'PrepaidOrder Delete'
		));
		AclPermission::create(array(
			'ident'     => 'admin.prepaidorder.restore',
			'description' => 'PrepaidOrder Restore'
		));
		AclPermission::create(array(
			'ident'     => 'admin.prepaidorder.print',
			'description' => 'PrepaidOrder Restore'
		));			

		//Admin PortIn
		AclPermission::create(array(
			'ident'     => 'admin.portin.index',
			'description' => 'PortIn Index Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.portin.create',
			'description' => 'PortIn Create Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.portin.store',
			'description' => 'PortIn Save'
		));
		AclPermission::create(array(
			'ident'     => 'admin.portin.show',
			'description' => 'PortIn Show Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.portin.edit',
			'description' => 'PortIn Edit Page'
		));
		AclPermission::create(array(
			'ident'     => 'admin.portin.update',
			'description' => 'PortIn Update'
		));
		AclPermission::create(array(
			'ident'     => 'admin.portin.destroy',
			'description' => 'PortIn Delete'
		));
		AclPermission::create(array(
			'ident'     => 'admin.portin.restore',
			'description' => 'PortIn Restore'
		));	
		AclPermission::create(array(
			'ident'     => 'admin.portin.print',
			'description' => 'PortIn Restore'
		));	

	}

}