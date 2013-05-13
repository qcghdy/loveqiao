<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-18
 * Time: 下午7:30
 * To change this template use File | Settings | File Templates.
 */
class Admin extends MY_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->helper('url');
        $this -> load -> model('blogModel', "blogModel");
    }

    public function index(){
        $this->load->view("admin/admin.html");
    }

    public function changepwd(){
        $sid = $this->input->post("code", TRUE);
        $bool = $sid == $this->session->userdata("vcpvc");
        if($bool){
            $out["HEAD"] = "success";
        }else{
            $out["HEAD"] = "error";
        }

        echo json_encode($out);
    }

    /**
     * vc  validateCode
     */
    public function vc(){
        $this -> load -> model('validateCode', "validateCode");
        $this->validateCode->getCode();
    }


    //新建文章的请求，返回的是一个供用户编辑文章的模板
    public function newBlog(){
        $data['input_token'] = parent::gen_input();
        $this->load->view('admin/newBlog.html', $data);
    }

    //用户新增一篇文章，并进行提交，插入数据库
    public function submitBlog(){

        //令牌验证，是否非法提交表单
        $bool = parent::token_check(parent::obtainParam(parent::INPUT_TOKEN_NAME,'post',true));
        //如果验证失败，就返回
        if(!$bool){
            $rediret_url = 'http://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            header("Content-type:text/html; charset=utf-8");
            die('<script type="text/javascript">alert("错误信息！"); window.navigate("$rediret_url");</script>');
        }
        //如果验证成功，就提交数据
        $retCode = $this -> blogModel -> submitBlog();
        $out["HEAD"] = "success";
        $out["BODY"] = $retCode;
        echo json_encode($out);
    }

    //编辑文章的请求，返回的是一个供用户编辑文章的模板
    public function editBlog(){
        $sid = $this->input->get("sid", TRUE);
        if(is_numeric($sid) && $sid > 0 ){
            $suiSuiNian = $this->blogModel->getSuiSuiNian($sid);
            if($suiSuiNian){
                $data = $suiSuiNian;
                $data['input_token'] = parent::gen_input();
                $this->load->view('admin/editBlog.html', $data);
            }else{
                $this->load->view('error.html');
            }
        }else{
            $this->load->view('error.html');
        }
    }

    //用户修改一篇文章，并进行提交，插入数据库
    public function updateBlog(){
//令牌验证，是否非法提交表单
        $bool = parent::token_check(parent::obtainParam(parent::INPUT_TOKEN_NAME,'post',true));
        //如果验证失败，就返回
        if(!$bool){
            $rediret_url = 'http://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            header("Content-type:text/html; charset=utf-8");
            die('<script type="text/javascript">alert("错误信息！"); window.navigate("$rediret_url");</script>');
        }
        //如果验证成功，就提交数据
        $retCode = $this -> blogModel -> updateBlog();
        $out["HEAD"] = "success";
        $out["BODY"] = $retCode;
        echo json_encode($out);
    }

    public function feedback(){
        $data = $this->getFeedbackList();
    }

    public function getFeedbackList(){
        //可将数据先缓存起来
        $this->load->model("feedbackModel", 'feedbackModel');
        $data = $this->feedbackModel->getFeedbackList();
        $this->load->view("admin/feedback.html", $data);
    }

    public function setFeedbackRead(){
        $this->load->model("feedbackModel", 'feedbackModel');
        //先设置已读
        $this->feedbackModel->batchSetFeedbackRead();
        //在拉取列表
        redirect(base_url('admin/feedback'));
    }

    public function deleteFeedback(){
        $this->load->model("feedbackModel", 'feedbackModel');
        //先设置已读
        $this->feedbackModel->batchDeleteFeedback();
        //在拉取列表
        redirect(base_url('admin/feedback'));
    }

    //管理员获取碎碎念列表，用以进行审核
    public function blog(){
        $pageId = $this->input->get("p", TRUE);
        //这里主要是防止用户恶意输入，如果恶意输入，那就直接将其置为1，表示默认拉取第一页数据
        $pageId = !empty($pageId) && is_numeric($pageId) && $pageId == (int)$pageId && (int)$pageId > 0 ? $pageId : 1;
        $data = $this->blogModel->getSuiSuiList($pageId, 7, "admin/blog");
        $this->load->view("admin/operateBlog.html", $data);
    }

    public function deleteBlog(){
        $sid = $this->input->post("sid", TRUE);
        $bool = $this->blogModel->deleteBlog($sid);
        if($bool){
            $out["HEAD"] = "success";
        }else{
            $out["HEAD"] = "error";
        }

        echo json_encode($out);
    }


    public function user(){
        $this->load->view('admin/user.html');
    }
}
