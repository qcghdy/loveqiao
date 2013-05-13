<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-27
 * Time: 上午10:33
 * To change this template use File | Settings | File Templates.
 */
class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }


    /**
     * 停止执行程序，给出错误信息，并写入错误日志。
     * 所有参数由helper提供
     *
     * @param $error_code 错误代码，用于区分错误类别
     * @param $error_level 错误级别
     * @param $error_message 错误提示信息
     */
    public function stop_doing($error_code='',$error_level='',$error_message='')
    {
//        $this->load->library('slog');
        //写入日志
        $error_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        //$this->slog->process_logs($error_url,$error_code,$error_level,$error_message);
        $rediret_url = 'http://'.$error_url;
        header("Content-type:text/html; charset=utf-8");
        die('<script type="text/javascript">alert("错误信息！"); window.navigate("$rediret_url");</script>');
    }


    /**
     * 获取表单的值
     * @param $name 表单元素名称
     * @param $type 提交方式，默认为post
     * @param $xxsf 让取得的数据经过跨站脚本过滤（XSS Filtering），默认为false，开启为true
     */
    public function obtainParam($name,$type='post',$xxsf=false)
    {
        if($type == 'post')
        {
            return $this->input->post($name,$xxsf);
        }
        else if($type == 'get')
        {
            return $this->input->get($name,$xxsf);
        }
        else
        {
            return $this->input->get_post($name,$xxsf);
        }
    }



    /**
     * 令牌验证
     */
    const FORM_TOKEN_KEY = 'form_token_key';
    const INPUT_TOKEN_NAME = 'input_token_name';

    /**
     * 生成令牌
     *
     * @return string
     */
    public function gen_token()
    {
        $hash = md5(uniqid(rand(), true));
        $token = sha1($hash);
        return $token;
    }

    /**
     * 生成session令牌
     *
     */
    public function gen_session_token()
    {
        //生成token
        $token = $this->gen_token();
        //删除session中原来的token
        $this->destroy_stoken();
        //将新的token注册到session
        $this->session->set_userdata(self::FORM_TOKEN_KEY,$token);
    }

    /**
     * 生成隐藏输入域表单
     *
     * @return 表单
     */
    public function gen_input()
    {
        $this->gen_session_token();
        $token_input =  '<input type="hidden" name="'.self::INPUT_TOKEN_NAME.'" id="token" value="'.$this->session->userdata(self::FORM_TOKEN_KEY).'" readonly="true" />';
        return $token_input;
    }

    /**
     * 检测token是否合法，如果合法则继续执行，否则跳出
     *
     * @param string $token_input 页面提交的token
     */
    public function token_check($token_input)
    {
        // 检测session中是否已注册token
        if($this->is_stoken())
        {
            if($token_input)
            {
                if($token_input == $this->session->userdata(self::FORM_TOKEN_KEY))
                {
                    $this->destroy_stoken();
                    return 0;
                }
                else
                {
                    $this->destroy_stoken();
                    return 1;
                    //$this->stop_doing(error_code('d'),error_level('ce'),error_message('d_add'));
                }
            }
            else
            {
                $this->destroy_stoken();
                return 1;
                //$this->stop_doing(error_code('v'),error_level('ce'),error_message('v_null'));
            }
        }
        else
        {
            $this->destroy_stoken();
            return 1;
            //$this->stop_doing(error_code('s'),error_level('e'),error_message('s_check'));
        }
    }

    /**
     * 销毁token
     *
     * @return bool
     */
    public function destroy_stoken()
    {
        $this->session->unset_userdata(self::FORM_TOKEN_KEY);
        return true;
    }

    /**
     * 检测token是否存在
     *
     * @return bool
     */
    public function is_stoken()
    {
        if($this->session->userdata(self::FORM_TOKEN_KEY))
            return true;
        else
            return false;
    }

    /**
     * 合并二维数组的相同项
     */
    function array_multi_unique($ar)
    {
        $ar = array_map('serialize', $ar);
        $ar = array_unique($ar);
        return array_map('unserialize', $ar);
    }


}
