<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-1-8
 * Time: 下午4:24
 * To change this template use File | Settings | File Templates.
 */
class UserModel extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function login(){
        $username = $this->input->post("username", TRUE);
        $password = $this->input->post("password", TRUE);
        //1、手写参数
        $sql = "select * from user where username = ? AND password = ? ";
        $parameters = array($username, $password);
        $query = $this->db->query($sql, $parameters);
        if($query->num_rows() > 0){
            $row = $query->result_array();

            //保存用户信息到session中,这里值保存userid
//            $userInfo = array(
//                'username'  => $row[0]['username'],
//                'email'     => $row[0]['email'],
//                'userid'    => $row[0]['userid']
//            );
            return $row[0];
        }else{
            return false;
        }
    }
}
