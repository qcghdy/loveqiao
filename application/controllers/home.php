<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 12-12-11
 * Time: 下午2:39
 * To change this template use File | Settings | File Templates.
 */
class Home extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
    }

    public function index(){
        $this->load->view('home.html');
    }

    public function acl(){
        $this->load->view('home.html');
    }
}
