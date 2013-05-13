<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 12-12-20
 * Time: 下午2:56
 * To change this template use File | Settings | File Templates.
 */

class Test extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');

    }

    public function index(){

//        //测试，php中关于 引用的解释
//
//        /**
//         * @describe 普通情况下,foreach($arr as $value)中的$arr和$value是拷贝，不受外部影响的.
//         * @section
//         */
//        $numArray = array(0,1,2,3,4,5,6,7,8,9);
//        echo '1$numArray' ; var_dump($numArray); echo '<br>';
//        //1$numArrayarray(10) { [0]=> int(0) [1]=> int(1) [2]=> int(2) [3]=> int(3) [4]=> int(4) [5]=> int(5) [6]=> int(6) [7]=> int(7) [8]=> int(8) [9]=> int(9) }
//        foreach($numArray as $value){
//            $value = $value * 2;
//        }
//        echo '2$numArray' ; var_dump($numArray);
//        //2$numArrayarray(10) { [0]=> int(0) [1]=> int(1) [2]=> int(2) [3]=> int(3) [4]=> int(4) [5]=> int(5) [6]=> int(6) [7]=> int(7) [8]=> int(8) [9]=> int(9) }
//
//        echo '<hr>';
//
//        /**
//         * @describe 普通情况下,foreach($arr as $value)中的$arr和$value是拷贝，不受外部影响的.
//         * @section
//         */
//        $numArray = array(0,1,2,3,4,5,6,7,8,9);
//        echo '3$numArray' ; var_dump($numArray); echo '<br>';
//        //3$numArrayarray(10) { [0]=> int(0) [1]=> int(1) [2]=> int(2) [3]=> int(3) [4]=> int(4) [5]=> int(5) [6]=> int(6) [7]=> int(7) [8]=> int(8) [9]=> int(9) }
//        foreach($numArray as &$value){
//            $value = $value * 2;
//        }
//        echo '4$numArray' ; var_dump($numArray);
//        //4$numArrayarray(10) { [0]=> int(0) [1]=> int(2) [2]=> int(4) [3]=> int(6) [4]=> int(8) [5]=> int(10) [6]=> int(12) [7]=> int(14) [8]=> int(16) [9]=> &int(18) }
//        echo '<hr>';
//
//
//        /**
//         * @describe 普通情况下,foreach($arr as $value)中的$arr和$value是拷贝，不受外部影响的.
//         * @section
//         */
//        $numArray = array(0,1,2,3,4,5,6,7,8,9);
//        $numArray = &$numArray;
//        echo '5$numArray' ; var_dump($numArray); echo '<br>';
//        //3$numArrayarray(10) { [0]=> int(0) [1]=> int(1) [2]=> int(2) [3]=> int(3) [4]=> int(4) [5]=> int(5) [6]=> int(6) [7]=> int(7) [8]=> int(8) [9]=> int(9) }
//        foreach($numArray as &$value){
//            $value = $value * 2;
//        }
//        echo '6$numArray' ; var_dump($numArray);
//        //4$numArrayarray(10) { [0]=> int(0) [1]=> int(2) [2]=> int(4) [3]=> int(6) [4]=> int(8) [5]=> int(10) [6]=> int(12) [7]=> int(14) [8]=> int(16) [9]=> &int(18) }

        $this -> load -> model('TokenModel', "TokenModel");

        echo "提交的formName是：loginForm<br>";
        $tk = $this->TokenModel->granteToken("loginForm");
        echo "本次请求得到的token值是";var_dump($tk); echo "<br>";

        echo "验证请求中所带的token值是否与服务器保存的一致<br>";var_dump($this->TokenModel->isToken($tk,"loginForm", true));

        $this->load->view('home.html');
    }



}
