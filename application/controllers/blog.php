<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 12-12-12
 * Time: 下午4:43
 * To change this template use File | Settings | File Templates.
 */
class Blog extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this -> load -> model('blogModel', "blogModel");
    }

    public function index(){
        $pageId = $this->input->get("p", TRUE);
        //这里主要是防止用户恶意输入，如果恶意输入，那就直接将其置为1，表示默认拉取第一页数据
        $pageId = !empty($pageId) && is_numeric($pageId) && $pageId == (int)$pageId && (int)$pageId > 0 ? $pageId : 1;
        $data = $this->blogModel->getSuiSuiList($pageId);
        $this->load->view('blog.html', $data);
    }

    public function item(){

        $sid = $this->input->get("sid", TRUE);
        if(is_numeric($sid) && $sid > 0 ){
            $suiSuiNian = $this->blogModel->getSuiSuiNian($sid);
            if($suiSuiNian){
                $this->load->view('archive.html', $suiSuiNian);
            }else{
                $this->load->view('error.html');
            }
        }else{
            $this->load->view('error.html');
        }

    }

}
