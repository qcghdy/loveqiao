<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 12-12-13
 * Time: 下午8:10
 * To change this template use File | Settings | File Templates.
 */
class Lab extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
    }

    public function index(){
        $this->load->view('lab.html');
    }

    public function test(){
        $categoryId = $this->input->get('cid',true);
        $this->load->view('article/'. $categoryId .'.html');
    }

    public function login(){
        $this->load->database();//手动连接数据库
        //连接数据库,这里用到的数据库是 love
        //$db = $this->load->database('default', TRUE);
        //查询服务
        //1、手写参数
        $sql = "select * from user where username = ? AND password = ? AND type = ?";
        $param = array("qcghdy", '441782353', '1');
        $query = $this->db->query($sql, $param);
        //$query = $this->db->get('user');
        foreach ($query->result() as $row)
        {
            echo $row->userid. '<br>' . $row->username . '<br>' .$row->password  .'<br>' . $row->email. '<br>' . $row->birthday. '<br>' . $row->livecity;
        }

        //active record


    }


}
