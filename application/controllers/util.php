<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-1-17
 * Time: 上午10:56
 * To change this template use File | Settings | File Templates.
 */
class Util extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
    }

    public function index(){

    }

    public function login(){
        $this->load->model("userModel", "user");
        $bRet = $this->user->login();
        $out = array();
        if($bRet){
            if(!isset($_COOKIE["username"])){
                $cookie = array(
                    "name"  => "username",
                    "value" => $bRet["username"],
                    "expire"=> 3600
                );
                set_cookie($cookie);
                $this->session->set_userdata("userid", $bRet['userid']);
                //$this->session->set_userdata("username", $bRet['username']);
            }
            $out["HEAD"] = "success";
            $out["BODY"] = $bRet;
        }else{
            $out["HEAD"] = "error";
            $out["BODY"] = "no user";
        }
        echo json_encode($out);
    }


    public function logout(){
        //获取用户session数据。
        if(isset($_COOKIE['username'])){
            //session_destroy();
            delete_cookie("username");
        }
        //$from = $this->input->get
        //用户退出页面以后就要重新回到
        redirect("lab/test?cid=4");

    }
}
