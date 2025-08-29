<?php

return [
    'route_permissions' => [
        //user
        'user.create' => 'user.create',
        'user.delete' => 'user.delete',
        'user.edit' => 'user.edit',
        'user.list' => 'user.list',
        //hardware 
        'hardware.create' => 'hardware.create',
        'hardware.delete' => 'hardware.delete',
        'hardware.edit' => 'hardware.edit',
        'hardware.list' => 'hardware.list',
        
        //software
        'software.create' => 'software.create',
        'software.delete' => 'software.delete',
        'software.edit' => 'software.edit',
        'software.list' => 'software.list',
        
        //role
        'role.create' => 'role.create',
        'role.delete' => 'role.delete',
        'role.edit' => 'role.edit',
        'role.list' => 'role.list',
        'role.getall' => 'role.list',
        'role.get' => 'role.list',
        'role.getbyname' => 'role.list',
        'role.getbyuser' => 'role.list',
        'role.getbyuserandname' => 'role.list',
        'role.getallusersfromrole' => 'role.list',

        // role permission
        'permission.create' => 'permission.create',
        'permission.delete' => 'permission.delete',
        'permission.edit' => 'permission.edit',
        'permission.list' => 'permission.list',
        'permission.getall' => 'permission.list',
        'permission.getbyname' => 'permission.list',

    ],
    'default_actions' => [
    //get all
        'index' => 'list',
        'show' => 'list',
        'list' => 'list',
        'getall' => 'list',
        'get all' => 'list',
        'get' => 'list',

    //create

        'create' => 'create',
        'store' => 'create',


    //update
        'edit' => 'edit',
        'update' => 'edit',
    //delete
        'destroy' => 'delete',
    //detail
        'detail' => 'detail',
    ],
];