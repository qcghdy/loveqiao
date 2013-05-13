<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-27
 * Time: 下午2:03
 * To change this template use File | Settings | File Templates.
 */

/** *后台权限拦截钩子 **/
class ManageAuth {
    private $CI;
    public function __construct() {
        $this->CI = &get_instance();
    }

    /*** 权限认证     */
    public function auth() {
        $this->CI->load->helper('url');
        if (preg_match("/admin/i", uri_string())) {
            // 需要进行权限检查的URL
            $this->CI->load->library('session');
            if(!isset($_COOKIE['username'])){
                // 用户未登陆,返回首頁
                redirect(base_url("login"));
                return;
            }
        }
    }
}