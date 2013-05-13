<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-27
 * Time: 下午2:25
 * To change this template use File | Settings | File Templates.
 */

function hookAccessControlList()
{
    global $RTR;
    $controller = $RTR->class;
    $method = $RTR->method;

    //load acl config files
    $config = & load_class('Config');
    $config->load('acl',true,true);
    $acl_settings = $config->item('acl');
    $acl_tables = $acl_settings['acl'];

    //get current user level  eg : $_COOKIE['user_role'] = 'admin'
    $current_role = (isset($_COOKIE['user_role']))? $_COOKIE['user_role'] : 'guest' ;
    if(isset($acl_tables[$controller][$method])){
        //begin to check acl
        $allow_roles = $acl_tables[$controller][$method];
        if(!in_array($current_role,$allow_roles)){
            show_error('No Right To Access',500);
        }
    }


}