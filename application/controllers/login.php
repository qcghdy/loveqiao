<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-27
 * Time: 下午3:38
 * To change this template use File | Settings | File Templates.
 */

class Login extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
    }
    public function index(){
        $this->load->view("login.html");
    }

    public function signin(){
        $out = array();
        $captcha = $this->input->post("code", TRUE);
        $bool = $captcha == $this->session->userdata("vcpvc");
        if($bool){
            $this->load->model("userModel", "user");
            $bRet = $this->user->login();
            if($bRet){
                if(!isset($_COOKIE["username"])){
                    $cookie = array(
                        "name"  => "username",
                        "value" => $bRet["username"],
                        "expire"=> 3600
                    );
                    set_cookie($cookie);
//                    $this->session->set_userdata("username", $bRet['username']);
                    $this->session->set_userdata("userid", $bRet['userid']);
                }
                $out["HEAD"] = "success";
                $out["BODY"] = $bRet;
            }else{
                $out["HEAD"] = "error";
                $out["BODY"] = "用户不存在或者密码错误";
            }
        }else{
            $out["HEAD"] = "error";
            $out["BODY"] = "验证码错误";
        }
        echo json_encode($out);
    }

    public function captcha(){
        $this -> load -> model('validateCode', "validateCode");
        $this->validateCode->getCode();
    }

}

