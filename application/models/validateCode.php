<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-20
 * Time: 下午12:23
 * To change this template use File | Settings | File Templates.
 */

class ValidateCode extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function getCode(){
        return $this->getCodeMath(100, 24);
    }

    private function getCodeChar($num,$w,$h) {
        $code = "";
        for ($i = 0; $i < $num; $i++) {
            $code .= rand(0, 9);
        }
        //4位验证码也可以用rand(1000,9999)直接生成
        //将生成的验证码写入session，备验证时用validate-code-prev-validate-code
        $this->session->set_userdata("vcpvc", $code);
//        $_SESSION["helloweba_num"] = $code;
        //创建图片，定义颜色值
        header("Content-type: image/PNG");
        $im = imagecreate($w, $h);
        $black = imagecolorallocate($im, 0, 0, 0);
        $gray = imagecolorallocate($im, 200, 200, 200);
        $bgcolor = imagecolorallocate($im, 255, 255, 255);
        //填充背景
        imagefill($im, 0, 0, $gray);

        //画边框
        imagerectangle($im, 0, 0, $w-1, $h-1, $black);

        //随机绘制两条虚线，起干扰作用
        $style = array ($black,$black,$black,$black,$black,
            $gray,$gray,$gray,$gray,$gray
        );
        imagesetstyle($im, $style);
        $y1 = rand(0, $h);
        $y2 = rand(0, $h);
        $y3 = rand(0, $h);
        $y4 = rand(0, $h);
        imageline($im, 0, $y1, $w, $y3, IMG_COLOR_STYLED);
        imageline($im, 0, $y2, $w, $y4, IMG_COLOR_STYLED);

        //在画布上随机生成大量黑点，起干扰作用;
        for ($i = 0; $i < 80; $i++) {
            imagesetpixel($im, rand(0, $w), rand(0, $h), $black);
        }
        //将数字随机显示在画布上,字符的水平间距和位置都按一定波动范围随机生成
        $strx = rand(3, 8);
        for ($i = 0; $i < $num; $i++) {
            $strpos = rand(1, 6);
            imagestring($im, 5, $strx, $strpos, substr($code, $i, 1), $black);
            $strx += rand(8, 12);
        }
        imagepng($im);//输出图片
        imagedestroy($im);//释放图片所占内存
    }

    private function getCodeMath($w, $h) {
        $im = imagecreate($w, $h);

        //imagecolorallocate($im, 14, 114, 180); // background color
        $red = imagecolorallocate($im, 255, 0, 0);
        $white = imagecolorallocate($im, 255, 255, 255);

        $num1 = rand(1, 20);
        $num2 = rand(1, 20);

        $this->session->set_userdata("vcpvc", $num1 + $num2);

//        $_SESSION['helloweba_math'] = $num1 + $num2;

        $gray = imagecolorallocate($im, 118, 151, 199);
        $black = imagecolorallocate($im, mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100));

        //画背景
        imagefilledrectangle($im, 0, 0, 100, 24, $black);
        //在画布上随机生成大量点，起干扰作用;
        for ($i = 0; $i < 80; $i++) {
            imagesetpixel($im, rand(0, $w), rand(0, $h), $gray);
        }

        imagestring($im, 5, 5, 4, $num1, $red);
        imagestring($im, 5, 30, 3, "+", $red);
        imagestring($im, 5, 45, 4, $num2, $red);
        imagestring($im, 5, 70, 3, "=", $red);
        imagestring($im, 5, 80, 2, "?", $white);

        header("Pragma: no-cache");
        header("Content-type: image/png");
        imagepng($im);
        imagedestroy($im);
    }
}