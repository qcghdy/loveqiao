<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 12-12-12
 * Time: 下午4:43
 * To change this template use File | Settings | File Templates.
 */
class Tool extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
    }

    public function index(){
        $this->load->view('tool.html');
    }
}
