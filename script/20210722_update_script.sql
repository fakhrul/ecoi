
ALTER TABLE `users` ADD `valid_start` DATE NOT NULL ;
ALTER TABLE `users` ADD `valid_end` DATE NOT NULL ;
ALTER TABLE `users` ADD `group_id` INT(10) NOT NULL DEFAULT '1' ;

INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.index', 'admin.users_super_admin.index');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.create', 'admin.users_super_admin.create');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.store', 'admin.users_super_admin.store');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.show', 'admin.users_super_admin.show');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.edit', 'admin.users_super_admin.edit');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.update', 'admin.users_super_admin.update');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.destroy', 'admin.users_super_admin.destroy');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.restore', 'admin.users_super_admin.restore');


INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '168');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '169');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '170');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '171');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '172');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '173');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '174');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '175');


INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.index', 'admin.users_normal.index');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.create', 'admin.users_normal.create');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.store', 'admin.users_normal.store');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.show', 'admin.users_normal.show');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.edit', 'admin.users_normal.edit');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.update', 'admin.users_normal.update');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.destroy', 'admin.users_normal.destroy');
INSERT INTO `ecoi_rtu`.`acl_permissions` (`id`, `ident`, `description`) VALUES (NULL, 'admin.users_normal.restore', 'admin.users_normal.restore');


INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '176');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '177');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '178');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '179');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '180');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '181');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '182');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '1', '183');

INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '176');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '177');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '178');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '179');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '180');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '181');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '182');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '183');

INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '1');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '2');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '3');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '4');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '5');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '6');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '7');
INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '2', '8');

INSERT INTO `ecoi_rtu`.`acl_group_permissions` (`id`, `group_id`, `permission_id`) VALUES (NULL, '4', '94');

'manual create user