<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-27
 * Time: 下午2:27
 * To change this template use File | Settings | File Templates.
 */

//acl table
//format as follows:
/*
 * $acl = array(
      'controll_1' =>array(
              'method_1' => array('super admin','admin','register'), //who can access this method.
              'method_2' => array('admin'),
  ),
admin can access project/controller_1/method_2
  'controll_2' =>array(
              'method_1' => array('super admin','admin','register'), //who can access this method.
              'method_2' => array('admin','guest'), // no definition: no access limit.
  ),
);*/
$acl = array(
    'admin' => array(
        'add' => array('admin','register'),
        'html_all' => array('admin'),
        'remove_all' => array('admin'),
    ),

);

//set config
$config['acl'] = $acl;