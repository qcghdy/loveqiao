<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-27
 * Time: 下午7:56
 * To change this template use File | Settings | File Templates.
 */
class Feedback extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
    }
    public function index(){
        $this->load->view("feedback.html");
    }

    public function submit(){
        $out = array();
        $captcha = $this->input->post("code", TRUE);
        $bool = $captcha == $this->session->userdata("vcpvc");
        if($bool){
            $this->load->model("feedbackModel", "feedback");
            $bRet = $this->feedback->submit();
            if($bRet){
                $out["HEAD"] = "success";
                $out["BODY"] = $bRet;
            }else{
                $out["HEAD"] = "error";
                $out["BODY"] = "请求异常，请重试";
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
